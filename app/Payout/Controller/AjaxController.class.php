<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Payout\Controller;
use Payout\Controller\PayoutbaseController;
class AjaxController extends PayoutbaseController{
	/*
     * 返回行政区域json字符串
     */
	public function getRegion(){
		$Region=M("region");
		$map['pid']=I('pid');
		$map['type']=I('type');
		$list=$Region->where($map)->select();
		echo json_encode($list);
	}

	/*
	 * 获取支付公司以及对应的MID
	 */

    public function getMid()
    {

        $payment_mid = M('payment_mid');
        $map['p_id'] = I('pid');
        $list_mid = $payment_mid->where($map)->select();
        echo json_encode($list_mid);


    }
}