<?php

namespace Payment\Common\Qpay\Data\Query;

use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;

/**
 * Class RefundQueryData
 * @package Payment\Common\Qpay\Data\Query
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 退款查询数据
 * @link https://qpay.qq.com/buss/wiki/38/1208
 */
class RefundQueryData extends QpayBaseData
{
    protected function checkDataParam()
    {
        parent::checkDataParam();

    }

    protected function getReqData()
    {
        $reqData = [
            'dateTime' => $this->dateTime,
            'branchNo' => $this->branchNo,
            'merchantNo' => $this->merchantNo,
            'type' => $this->type,
            'orderNo' => $this->out_trade_no ? $this->out_trade_no : '',
            'date' => $this->date,
            'merchantSerialNo' => $this->refund_no ? $this->refund_no : '',
            'bankSerialNo' => $this->refund_id ? $this->refund_id : '',
        ];

        // 这里不能进行过滤空值，招商的空值也要加入签名中
        return $reqData;
    }
}
