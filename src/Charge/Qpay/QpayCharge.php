<?php

namespace Payment\Charge\Qpay;

use Payment\Common\Qpay\Data\Charge\ChargeData;
use Payment\Common\Qpay\QpayBaseStrategy;

/**
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 支付接口
 */
class QpayCharge extends QpayBaseStrategy
{

    public function getBuildDataClass()
    {
        return ChargeData::class;
    }

}
