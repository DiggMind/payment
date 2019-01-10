<?php

namespace Payment\Common\Qpay\Data\Query;

use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;

/**
 * Class ChargeQueryData
 * @package Payment\Common\Qpay\Data\Query
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 统一下单查询数据
 * @link https://qpay.qq.com/buss/wiki/38/1205
 */
class ChargeQueryData extends QpayBaseData
{

    protected function checkDataParam()
    {
        parent::checkDataParam();

        if (empty($this->mch_id)) {
            throw new PayException('mch_id 不能为空');
        }

        if (empty($this->nonce_str)) {
            throw new PayException('nonce_str 不能为空');
        }

        if (empty($this->transaction_id) && empty($this->out_trade_no)) {
            throw new PayException('transaction_id 或 out_trade_no 未填写');
        }
    }

    protected function getReqData()
    {
        $reqData = [
            'appid' => $this->app_id,
            'mch_id' => $this->mch_id,
            'nonce_str' => $this->nonce_str,
            'transaction_id' => $this->transaction_id,
            'out_trade_no' => $this->out_trade_no,
        ];
        return $reqData;
    }

}
