<?php

namespace Payment\Common\Qpay\Data\Query;

use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;

/**
 * Class ChargeQueryData
 * @package Payment\Common\Qpay\Data\Query
 *
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 订单查询
 * @link https://qpay.qq.com/buss/wiki/38/1205
 *
 * @property string $appId [optional] 腾讯开放平台或QQ互联平台审核通过的应用APPID
 * @property string $mchId QQ钱包分配的商户号
 * @property string $nonceStr 随机字符串，不长于32位。
 * @property string $transactionId （2选1）QQ钱包订单号，优先使用。请求30天或更久之前支付的订单时，此参数不能为空。
 * @property string $outTradeNo （2选1）商户系统内部的订单号,32个字符内、可包含字母，说明见商户订单号,当没传入transaction_id时必须传该参数
 */
class ChargeQueryData extends QpayBaseData
{

    protected function getReqData()
    {
        $reqData = [
            'appid' => $this->appId,
            'mch_id' => $this->mchId,
            'nonce_str' => $this->nonceStr,
            'transaction_id' => $this->transactionId,
            'out_trade_no' => $this->outTradeNo,
        ];

        return $reqData;
    }

    protected function checkDataParam()
    {
        parent::checkDataParam();

        if (empty($this->mchId)) {
            throw new PayException('mchId 不能为空');
        }

        if (empty($this->nonceStr)) {
            throw new PayException('nonceStr 不能为空');
        }

        if (empty($this->transactionId) && empty($this->outTradeNo)) {
            throw new PayException('transactionId 或 outTradeNo 未填写');
        }


    }
}
