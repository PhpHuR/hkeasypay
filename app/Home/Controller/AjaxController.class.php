<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;
use Home\Controller\HomebaseController;
class AjaxController extends HomebaseController{
	/*
     * 返回行政区域json字符串
     */
    public function getRegion(){
        $Region=M("region");
        $map['parent_id']=I('pid');
        $map['level']=I('type');
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

    public function getBalance()
    {

        $sub_user_id = I('id');
        if ($sub_user_id) {
            $sub_balance_list1 = M('sub_user_balance')->where(array('sub_balance_id' => $sub_user_id))->find();
            $this->ajaxReturn($sub_balance_list1);
        }

        //获取用户的余额，默认状态获取CNY
        $userId = I('user_id');
        $currency_id = I('currency_id');

        //        获取汇率
        $curoffer = M('curoffer')->where(array('user_id' => $userId, 'currency_code' => $currency_id))->find();
//        $cursell = number_format($cursell/100,);
        if ($currency_id=='CNY') {
            $currency_id = '1';
        }elseif($currency_id=='HKD'){
            $currency_id = '3';
        }

        //获取用户的出金限额以及出金手续费
        $userinfo = M('userinfo')->where(array('user_id' => $userId))->getField('payout_rate');
        $payout_rate = getPayoutRate($userinfo);

        //获取用户的余额
        $balance = M('user_balance')->where(array('user_id' => $userId, 'currency_id' => $currency_id))->find();
//        if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
//            $balance['availablecount'] = round($balance['availablecount']*1/$curoffer['cursell'],2);
//        }

        if ($balance) {
            $res_balance = array(
                'free'=>$payout_rate['outrate'],
                'max'=>$payout_rate['outmax'],
                'availablecount'=>$balance['availablecount'],
                'curbuy' => $curoffer['curbuy'],
                'cursell' => $curoffer['cursell'],
            );
            echo json_encode($res_balance);
        }else{
            echo null;
        }

    }

    public function curoffer()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
// 响应类型
        header('Access-Control-Allow-Methods:POST');
// 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $user_id = I('user_id');
        $curoffer_list = M('curoffer')->where(array('user_id' => $user_id))->select();
        if ($curoffer_list) {
            foreach ($curoffer_list as $v) {

                if ($v['currency_code']=='USD') {
                    $usd = 1 / $v['cursell'];
                }
                if ($v['currency_code']=='HKD') {
                    $hkd = 1 / $v['cursell'];
                }
            }
            $res_curoffer = array(

                'usd'=>number_format($usd,12,'.',','),
                'hkd'=>number_format($hkd,12,'.',','),
            );
            echo json_encode($res_curoffer);

        }else{
            //当天时间
            $time = strtotime(date('Y-m-d'));
            //查看当天的港币和美元的汇率是否存在活动的
            $where['status'] = 1;
            $where['currency_code'] = array('in', 'HKD,USD');
            $where['update_at'] = array('gt',$time);
            $curoffer_list_1 = M('curoffer')->where($where)->select();
            //汇率是否开启
            foreach ($curoffer_list_1 as $v) {

                if ($v['currency_code']=='USD') {
                    $usd = 1 / $v['cursell'];
                }
                if ($v['currency_code']=='HKD') {
                    $hkd = 1 / $v['cursell'];
                }
            }

            $res_curoffer = array(
                'usd'=>number_format($usd,12,'.',','),
                'hkd'=>number_format($hkd,12,'.',','),
            );
            echo json_encode($res_curoffer);

        }


    }
}