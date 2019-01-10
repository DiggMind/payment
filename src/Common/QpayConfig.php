<?php

namespace Payment\Common;

use Payment\Utils\ArrayUtil;

/**
 * Class QpayConfig
 * @package Payment\Common
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 配置
 */
class QpayConfig extends ConfigInterface
{

    /**
     * @var string 加密MD5_KEY
     */
    public $md5Key = '';

    /**
     * @var string 加密方式
     */
    public $signType = 'MD5';

    /**
     * @var string 应用ID
     */
    public $appdi = '';

    /**
     * @var string 商户号
     */
    public $mchId = '';


    /*********************************
     * 下单业务
     *********************************/

    // 支付场景
    // APP支付，统一下单接口trade_type的传参可参考这里
    const CHARGE_TRADE_TYPE_APP = 'APP';
    // 公众号支付
    const CHARGE_TRADE_TYPE_JSAPI = 'JSAPI';
    // 原生扫码支付
    const CHARGE_TRADE_TYPE_NATIVE = 'NATIVE';
    // 付款码支付，付款码支付有单独的支付接口，不调用统一下单接口
    const CHARGE_TRADE_TYPE_MICROPAY = 'MICROPAY';

    // 不准使用余额
    const CHARGE_LIMIT_PAY_NO_BALANCE = 'no_balance';
    // 不准使用信用卡
    const CHARGE_LIMIT_PAY_NO_CREDIT = 'no_credit';
    // 不准使用借记卡
    const CHARGE_LIMIT_PAY_NO_DEBIT = 'no_debit';
    // 只准使用余额
    const CHARGE_LIMIT_PAY_BALANCE_ONLY = 'balance_only';
    // 只准使用借记卡
    const CHARGE_LIMIT_PAY_DEBIT_ONLY = 'debit_only';
    // 简化注册用户不允许用余额
    const CHARGE_LIMIT_PAY_NODEBIT_NOBALAN = 'NoBindNoBalan';

    // 货币类型
    const CHARGE_FEE_TYPE_CNY = 'CNY';

    /*********************************
     * 退款业务
     *********************************/

    // 未结算资金退款（默认使用未结算资金退款）
    const REFUND_SOURCE_UNSETTLED = 'REFUND_SOURCE_UNSETTLED_FUNDS';
    // 可用余额退款(限非当日交易订单的退款）
    const REFUND_SOURCE_RECHARGE = 'REFUND_SOURCE_RECHARGE_FUNDS';

    /**
     * @param array $config
     * @throws PayException
     */
    protected function initConfig(array $config)
    {
        $config = ArrayUtil::paraFilter($config);

        // 初始 应用ID
        if (key_exists('app_id', $config) && !empty($config['app_id'])) {
            $this->appId = $config['app_id'];
        } else {
            throw new PayException('app_id 不能为空，请前往QPAY进行设置');
        }

        // 初始 应用ID
        if (key_exists('mch_id', $config) && !empty($config['mch_id'])) {
            $this->mchId = $config['mch_id'];
        } else {
            throw new PayException('mch_id 不能为空，请前往QPAY进行设置');
        }

    }

}