<?php

namespace Payment\Common\Qpay\Data;

use Payment\Common\BaseData;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

/**
 * @author: benny
 * @createTime: 2019-01-08 18:45
 * @description: qpay 支付接口
 */
abstract class QpayBaseData extends BaseData
{

    /**
     * 请求数据签名算法的实现
     * @param string $signStr
     * @return string
     */
    protected function makeSign($signStr)
    {
        switch ($this->signType) {
            case 'SHA-256':
                $sign = hash('sha256', "$signStr&{$this->merKey}");
                break;
            default:
                $sign = '';
        }

        return $sign;
    }

    /**
     * 构建数据
     */
    protected function buildData()
    {
        $signData = [
            // 公共参数
            'version'       => $this->version,
            'charset'       => $this->charset,
            'signType'      => $this->signType,
            'reqData'       => $this->getReqData(),
        ];

        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }

    /**
     * 检查基本数据
     */
    protected function checkDataParam()
    {
//        $branchNo = $this->branchNo;
//        $merchantNo = $this->merchantNo;
//
//        if (empty($branchNo) || mb_strlen($branchNo) !== 4) {
//            throw new PayException('商户分行号，4位数字');
//        }
//
//        if (empty($merchantNo) || mb_strlen($merchantNo) !== 6) {
//            throw new PayException('商户号，6位数字');
//        }
    }

    /**
     * 请求数据
     *
     * @return array
     */
    abstract protected function getReqData();
}
