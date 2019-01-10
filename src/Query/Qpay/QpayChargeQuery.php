<?php

namespace Payment\Query\Qpay;

use Payment\Common\Qpay\Data\Query\ChargeQueryData;
use Payment\Common\Qpay\QpayBaseStrategy;


/**
 * Class QpayChargeQuery
 * @package Payment\Query\Qpay
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 统一下单查询接口
 */
class QpayChargeQuery extends QpayBaseStrategy
{

    protected $reqUrl = 'https://qpay.qq.com/cgi-bin/pay/qpay_order_query.cgi';

    public function getBuildDataClass()
    {
        return ChargeQueryData::class;
    }

    protected function retData(array $data)
    {

    }

    protected function onRetDataSuccess()
    {

    }

    protected function onRetDataError()
    {

    }

}
