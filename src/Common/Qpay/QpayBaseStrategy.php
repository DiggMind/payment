<?php

namespace Payment\Common\Qpay;

use GuzzleHttp\Client;
use Payment\Common\BaseData;
use Payment\Common\BaseStrategy;
use Payment\Common\ConfigInterface;
use Payment\Common\PayException;
use Payment\Common\QpayConfig;

/**
 * Class QpayBaseStrategy
 * @package Payment\Common\Qpay
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 基础策略
 */
abstract class QpayBaseStrategy implements BaseStrategy
{

    /**
     * @var ConfigInterface QPAY支付配置
     */
    protected $config;

    /**
     * @var BaseData 请求数据
     */
    protected $reqData;

    /**
     * QpayBaseStrategy constructor.
     * @param array $config
     * @throws PayException
     */
    public function __construct(array $config)
    {
        try {
            $this->config = new QpayConfig($config);
        } catch (PayException $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws PayException
     */
    public function handle(array $data)
    {
        $buildClass = $this->getBuildDataClass();

        try {
            $this->reqData = new $buildClass($this->config, $data);
        } catch (PayException $e) {
            throw $e;
        }

        $this->reqData->setSign();

        $data = $this->reqData->getData();

        return $this->retData($data);
    }

    /**
     * 处理微信的返回值并返回给客户端
     * @param array $ret
     * @return mixed
     * @author helei
     */
    protected function retData(array $ret)
    {
        $json = json_encode($ret, JSON_UNESCAPED_UNICODE);

        $reqData = [
//            'url' => $this->config->getewayUrl,
//            'name' => CmbConfig::REQ_FILED_NAME,
//            'value' => $json,
        ];
        return $reqData;
    }

    protected function sendReq($baseUri, array $data, $method = 'GET')
    {
        $client = new Client([
            'base_uri' => $baseUri,
            'timeout' => '10.0'
        ]);
        $method = strtoupper($method);
        $options = [];
        if ($method === 'GET') {
            $options = [
                'query' => $data,
                'http_errors' => false
            ];
        } elseif ($method === 'POST') {
            $options = [
                'form_params' => $data,
                'http_errors' => false
            ];
        }
        // 发起网络请求
        $response = $client->request($method, '', $options);

        if ($response->getStatusCode() != '200') {
            throw new PayException('网络发生错误，请稍后再试curl返回码：' . $response->getReasonPhrase());
        }

        $body = $response->getBody()->getContents();
        try {
            $body = \GuzzleHttp\json_decode($body, true);
        } catch (\InvalidArgumentException $e) {
            throw new PayException('返回数据 json 解析失败');
        }

        return $body;

        $responseKey = str_ireplace('.', '_', $this->config->method) . '_response';
        if (!isset($body[$responseKey])) {
            throw new PayException('支付宝系统故障或非法请求');
        }

        // 验证签名，检查支付宝返回的数据
        $flag = $this->verifySign($body[$responseKey], $body['sign']);
        if (!$flag) {
            throw new PayException('支付宝返回数据被篡改。请检查网络是否安全！');
        }

        // 这里可能带来不兼容问题。原先会检查code ，不正确时会抛出异常，而不是直接返回
        return $body[$responseKey];
    }

}