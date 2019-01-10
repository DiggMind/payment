<?php

namespace Payment\Common\Qpay\Data\Charge;

use Payment\Common\Cmb\Data\CmbBaseData;
use Payment\Common\CmbConfig;
use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;
use Payment\Config;

/**
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 支付接口
 * @link https://qpay.qq.com/buss/wiki/38/1203
 */
class ChargeData extends QpayBaseData
{

    protected function checkDataParam()
    {
        parent::checkDataParam();
        $amount = $this->amount;

        // 订单号交给支付系统自己检查

        // 检查金额不能低于0.01
        if (bccomp($amount, Config::PAY_MIN_FEE, 2) === -1) {
            throw new PayException('支付金额不能低于 ' . Config::PAY_MIN_FEE . ' 元');
        }

        // 设置ip地址
        $spBillCreateIp = $this->spBillCreateIp;
        if (empty($spBillCreateIp)) {
            $this->spBillCreateIp = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        }

    }

    protected function getReqData()
    {
        $reqData = [
            // require
            'appid' => $this->appId,
            'mch_id' => $this->mchId,
            'nonce_str' => $this->nonceStr,
            'sign' => $this->sign,
            'body' => $this->body,
            'notify_url' => $this->notifyUrl,
            'trade_type' => $this->tradeType,
            // optional
            'attach' => '',
            'out_trade_no' => $this->outTradeNo,
            'fee_type' => $this->feeType ?: 'CNY',
            'total_fee' => $this->totalFee, // <- 单位分，整型
            'spbill_create_ip' => $this->spBillCreateIp,
            'time_start' => $this->timeStart,
            'time_expire' => $this->timeEexpire,
            'limit_pay' => $this->limitPay,
            'device_info' => $this->deviceInfo
        ];

        return $reqData;
    }
}
