<?php

namespace Payment\Common\Qpay\Data\Refund;

use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;
use Payment\Common\QpayConfig;
use Payment\Utils\ArrayUtil;

/**
 * Class RefundData
 * @package Payment\Common\Qpay\Data\Refund
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 退款数据
 * @link https://qpay.qq.com/buss/wiki/38/1207
 */
class RefundData extends QpayBaseData
{

    /**
     * @return mixed|void
     * @throws PayException
     */
    protected function checkDataParam()
    {
        if (empty($this->nonceStr)) {
            throw new PayException('nonceStr 不能为空');
        }

        if (empty($this->transactionId) && empty($this->outTradeNo)) {
            throw new PayException('transactionId 或 outTradeNo 未填写');
        }
    }

    protected function buildData()
    {
        $this->retData = [
            'appid' => $this->appid,
            'mch_id' => $this->mch_id,
            'nonce_str' => $this->nonceStr,
            'transaction_id' => $this->transaction_id,
            'out_trade_no' => $this->out_trade_no,
            'out_refund_no' => $this->out_refund_no,
            'refund_fee' => $this->refund_fee,
            'op_user_id' => $this->op_user_id ?: $this->mch_id,
            'op_user_passwd' => $this->op_user_passwd,
            'refund_account' => $this->refund_account ?: QpayConfig::REFUND_SOURCE_UNSETTLED
        ];

        $this->retData = ArrayUtil::paraFilter($this->retData);
    }


}
