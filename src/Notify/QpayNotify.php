<?php

namespace Payment\Notify;

use Payment\Common\PayException;
use Payment\Common\QpayConfig;
use Payment\Config;
use Payment\Utils\ArrayUtil;
use Payment\Utils\DataParser;

/**
 * Class QpayNotify
 * @package Payment\Notify
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 回调通知
 */
class QpayNotify extends NotifyStrategy
{

    /**
     * QpayNotify constructor.
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
     * 获取微信返回的异步通知数据
     * @return array|bool
     * @author helei
     */
    public function getNotifyData()
    {
        // php://input 带来的内存压力更小
        $data = @file_get_contents('php://input');// 等同于微信提供的：$GLOBALS['HTTP_RAW_POST_DATA']
        // 将xml数据格式化为数组
        $arrData = DataParser::toArray($data);
        if (empty($arrData)) {
            return false;
        }

        // 移除值中的空格  xml转化为数组时，CDATA 数据会被带入额外的空格。
        $arrData = ArrayUtil::paraFilter($arrData);

        return $arrData;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function checkNotifyData(array $data)
    {
        if ($data['return_code'] != 'SUCCESS' || $data['result_code'] != 'SUCCESS') {
            // $arrData['return_msg']  返回信息，如非空，为错误原因
            // $data['result_code'] != 'SUCCESS'  表示业务失败
            return false;
        }

        // 检查返回数据签名是否正确
        return $this->verifySign($data);
    }

    /**
     * @param array $retData
     * @return boolean
     * @throws \Exception
     * @author helei
     */
    protected function verifySign(array $retData)
    {
        $retSign = $retData['sign'];
        $values = ArrayUtil::removeKeys($retData, ['sign', 'sign_type']);

        $values = ArrayUtil::paraFilter($values);

        $values = ArrayUtil::arraySort($values);

        $signStr = ArrayUtil::createLinkstring($values);

        $signStr .= '&key=' . $this->config->md5Key;
        switch ($this->config->signType) {
            case 'MD5':
                $sign = md5($signStr);
                break;
            default:
                $sign = '';
        }

        return strtoupper($sign) === $retSign;
    }

    /**
     * @param array $data
     * @return array|false
     */
    protected function getRetData(array $data)
    {
        if ($this->config->returnRaw) {
            $data['channel'] = Config::QPAY_CHARGE;
            return $data;
        }

        // 将金额处理为元
        $totalFee = bcdiv($data['total_fee'], 100, 2);
        $cashFee = bcdiv($data['cash_fee'], 100, 2);

        $retData = [
            'appid' => $data['appid'],
            'openid' => $data['openid'],
            'mch_id' => $data['mch_id'],
            'device_info' => $data['device_info'],
            'trade_type' => $data['trade_type'],
            'trade_state' => $data['trade_state'],
            'bank_type' => $data['bank_type'],
            'fee_type' => $data['fee_type'],
            'amount' => $totalFee,
            'cash_fee' => $cashFee,
            'transaction_id' => $data['transaction_id'],
            'out_trade_no' => $data['out_trade_no'],
            'pay_time' => date('Y-m-d H:i:s', strtotime($data['time_end'])),// 支付完成时间
            'channel' => Config::QPAY_CHARGE,
        ];

        if (isset($data['attach']) && !empty($data['attach'])) {
            $retData['return_param'] = $data['attach'];
        }

        return $retData;
    }

    /**
     * @param bool $flag
     * @param string $msg
     * @return bool|mixed|string
     */
    protected function replyNotify($flag, $msg = 'OK')
    {
        // 默认为成功
        $result = [
            'return_code' => 'SUCCESS',
            'return_msg' => 'OK',
        ];
        if (!$flag) {
            // 失败
            $result = [
                'return_code' => 'FAIL',
                'return_msg' => $msg,
            ];
        }

        return DataParser::toXml($result);
    }
}
