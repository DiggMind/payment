<?php

namespace Payment\Charge\Qpay;

use GuzzleHttp\Client;
use Payment\Common\Qpay\Data\Charge\ChargeData;
use Payment\Common\Qpay\QpayBaseStrategy;

/**
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 支付接口
 */
class QpayCharge extends QpayBaseStrategy
{

    protected $reqUrl = 'https://qpay.qq.com/cgi-bin/pay/qpay_unified_order.cgi';

    public function getBuildDataClass()
    {
        return ChargeData::class;
    }

    public function handle(array $data)
    {
//        dd($this);
//dd($data);


//        $ret = $this->sendReq($xml);
//        $http = new Client();

//        $http->post($this->reqUrl,[
//
//        ]);
//        dd($http);

//        return parent::handle($data); // TODO: Change the autogenerated stub
    }

    protected function retData(array $ret)
    {
        return parent::retData($ret); // TODO: Change the autogenerated stub
    }

}
