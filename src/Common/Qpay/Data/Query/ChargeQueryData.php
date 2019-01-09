<?php

namespace Payment\Common\Qpay\Data\Query;

use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;

/**
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 支付接口
 * @link https://qpay.qq.com/buss/wiki/38/1205
 */
class ChargeQueryData extends QpayBaseData
{
    protected function checkDataParam()
    {
        parent::checkDataParam();

//        $bankSerialNo = $this->transaction_id;
//        $date = $this->date;
//        $orderNo = $this->out_trade_no;
//
//        if (empty($date) || mb_strlen($date) !== 8) {
//            throw new PayException('商户订单日期必须提供,格式：yyyyMMdd');
//        }
//
//        if ($bankSerialNo && mb_strlen($bankSerialNo) === 20) {
//            $this->type = 'A';
//        } elseif ($orderNo && mb_strlen($bankSerialNo) <= 32) {
//            $this->type = 'B';
//        } else {
//            throw new PayException('必须设置商户订单信息或者招商流水号');
//        }
    }

    protected function getReqData()
    {
        $reqData = [
            'dateTime' => $this->dateTime,
            'branchNo' => $this->branchNo,
            'merchantNo' => $this->merchantNo,
            'type' => $this->type,
            'bankSerialNo' => $this->transaction_id ? $this->transaction_id : '',

            'date' => $this->date ? $this->date : '',
            'orderNo' => $this->out_trade_no ? $this->out_trade_no : '',
            'operatorNo' => $this->operator_no ? $this->operator_no : '',
        ];

        // 这里不能进行过滤空值，招商的空值也要加入签名中
        return $reqData;
    }
}
