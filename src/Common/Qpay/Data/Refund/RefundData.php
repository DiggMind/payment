<?php

namespace Payment\Common\Qpay\Data\Refund;

use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;
use Payment\Common\QpayConfig;
use Payment\Utils\ArrayUtil;

/**
 * @author: Benny Sung <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 退款接口
 * @link https://qpay.qq.com/buss/wiki/38/1207
 *
 * @property string $appId [optional] 腾讯开放平台审核通过的应用APPID或腾讯公众平台审核通过的公众号APPID
 * @property string $mchId QQ钱包分配的商户号
 * @property string $nonceStr 随机字符串，不长于32位。
 * @property string $transactionId （2选1）QQ钱包订单号，优先使用。请求30天或更久之前支付的订单时，此参数不能为空。
 * @property string $outTradeNo （2选1）商户系统内部的订单号,32个字符内、可包含字母，说明见商户订单号当没提供transaction_id时需要传入该参数
 * @property string $outRefundNo 商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔
 * @property string $refundFee 本次退款申请的退回金额。单位：分。币种：人民币
 * @property string $opUserId 操作员帐号, 默认为商户号，参见本页说明:操作员账户
 * @property string $opUserPasswd 操作员密码的MD5
 * @property string $refundAccount [optional] REFUND_SOURCE_UNSETTLED_FUNDS---未结算资金退款（默认使用未结算资金退款）REFUND_SOURCE_RECHARGE_FUNDS---可用现金账户资金退款
 */
class RefundData extends QpayBaseData
{

    protected function buildData()
    {
        $this->retData = [
            'appid' => $this->appId,
            'mch_id' => $this->mchId,
            'nonce_str' => $this->nonceStr,
            'transaction_id' => $this->transactionId,
            'out_trade_no' => $this->outTradeNo,
            'out_refund_no' => $this->outRefundNo,
            'refund_fee' => $this->refundFee,
            'op_user_id' => $this->opUserId ?: $this->mchId,
            'op_user_passwd' => $this->opUserPasswd,
            'refund_account' => $this->refundAccount ?: QpayConfig::REFUND_UNSETTLED
        ];

        $this->retData = ArrayUtil::paraFilter($this->retData);
    }

    /**
     * @return mixed|void
     * @throws PayException
     */
    protected function checkDataParam()
    {
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
