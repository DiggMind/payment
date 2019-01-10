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

}