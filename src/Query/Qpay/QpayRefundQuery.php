<?php

namespace Payment\Query\Qpay;

use Payment\Common\Qpay\Data\Query\ChargeQueryData;
use Payment\Common\Qpay\QpayBaseStrategy;


/**
 * Class QpayRefundQuery
 * @package Payment\Query\Qpay
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 退款查询接口
 */
class QpayRefundQuery extends QpayBaseStrategy
{

    protected $reqUrl = 'https://qpay.qq.com/cgi-bin/pay/qpay_refund_query.cgi';

    public function getBuildDataClass()
    {
        return ChargeQueryData::class;
    }

    protected function retData(array $data)
    {
        return $data;
    }

    protected function onRetDataSuccess()
    {

    }

    protected function onRetDataError()
    {

    }

}
