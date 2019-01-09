<?php

namespace Payment\Common\Qpay;

use GuzzleHttp\Client;
use Payment\Common\BaseData;
use Payment\Common\BaseStrategy;
use Payment\Common\PayException;
use Payment\Common\WxConfig;
use Payment\Utils\ArrayUtil;
use Payment\Utils\DataParser;

/**
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 支付接口
 */
abstract class QpayBaseStrategy implements BaseStrategy {

    /**
     * Qpay的配置文件
     * @var CmbConfig $config
     */
    protected $config;

    /**
     * 请求数据
     * @var BaseData $reqData
     */
    protected $reqData;

}