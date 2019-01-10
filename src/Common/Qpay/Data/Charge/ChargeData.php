<?php

namespace Payment\Common\Qpay\Data\Charge;

use Payment\Common\Cmb\Data\CmbBaseData;
use Payment\Common\CmbConfig;
use Payment\Common\PayException;
use Payment\Common\Qpay\Data\QpayBaseData;
use Payment\Common\QpayConfig;
use Payment\Config;

/**
 * Class ChargeData
 * @package Payment\Common\Qpay\Data\Charge
 *
 * @author: Benny <benny_a8@live.com>
 * @createTime: 2019-01-08 18:45
 * @description: qpay 统一下单数据
 * @link https://qpay.qq.com/buss/wiki/38/1203
 */
class ChargeData extends QpayBaseData
{

    protected function checkDataParam()
    {
        parent::checkDataParam();

        if (empty($this->mch_id)) {
            throw new PayException('mch_id 不能为空');
        }
    }

    protected function getReqData()
    {
        $reqData = [
            'appid' => $this->appid,
            'mch_id' => $this->mch_id,
            'nonce_str' => $this->nonce_str,
            'sign' => $this->sign,
            'body' => $this->body,
            'attach' => '',
            'out_trade_no' => $this->out_trade_no,
            'fee_type' => $this->fee_type ?: QpayConfig::CHARGE_FEE_TYPE_CNY,
            'total_fee' => $this->total_fee, // <- 单位分，整型
            'spbill_create_ip' => $this->spbill_create_ip,
            'time_start' => $this->time_start,
            'time_expire' => $this->time_expire,
            'limit_pay' => $this->limit_pay,
            'contract_code' => $this->contract_code,
            'promotion_tag' => $this->promotion_tag,
            'trade_type' => $this->tradeType,
            'device_info' => $this->deviceInfo,
            'notify_url' => $this->notifyUrl,
        ];

        return $reqData;
    }

}
