<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/14
 * Time: 17:03
 */

namespace Home\Controller;


class SmsController extends HomebaseController
{
    public function sms_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $sms_data = M('sms_list')->where(array('u_id'=>$uid))->find();
        $wallet_data = M('wallet_list')->where(array('user_id'=>$uid))->field('money')->find();
        if(IS_POST){
            if(empty($sms_data)){
                $this->error('请联系客服开通SMS短信通知',U('sms_list'),0);
            };
            $money = I('money');
            $mobile = I('mobile');
            if(isset($money)){
                $int_count = intval($money/$sms_data['sms_money']);
                if($int_count == 0){
                    $this->error('请填写足够的金额',U('sms_list'),0);
                }
                if($money > $wallet_data['money']){
                    $this->error('可用餘額不夠，請重新核對金額後填寫！',U('sms_list'),0);
                }
//                增加条数
                $yx_count = $sms_data['sms_count'] + $int_count;
                //条数乘以单价
                $sms_money = $int_count * $sms_data['sms_money'];
//                扣除钱包余额
                $yx_money = $wallet_data['money'] - $sms_money;
//                组装数据

                $data1 = array('money' =>$yx_money);
                $data2 = array(
                    'sms_count' =>$yx_count,
                    'mobile' => $mobile,
                    );


                $res1 = M('wallet_list')->where(array('user_id'=>$uid))->save($data1);
                if(!$res1){
                    $this->error('扣除金额失败',U('sms_list'),0);
                }
                $res2 = M('sms_list')->where(array('u_id'=>$uid))->save($data2);
                if($res2){
                    //写入日志信息
                    $recharge_id = 'sms'.createOrder($uid);
                    $content = '充值条数记录写入成功。订单号：' . $recharge_id . '###充值条数' . $yx_count .'钱包金额'.$yx_money;
                    $logResult = sms_addLog($uid,$recharge_id, 1, 'sms', '充值金额', $content);
                    $this->success('成功充值',U('sms_list'), 1);
                }else{
                    $recharge_id = 'r'.createOrder($uid);
                    $content = '充值条数记录写入失败。订单号：' . $recharge_id . '###充值条数' . $yx_count .'钱包金额'.$yx_money;
                    $logResult = sms_addLog($uid,$recharge_id, 2, 'sms', '充值金额', $content);
                    $this->error('充值失敗',U('sms_list'),0);
                }
            }else{
                $this->error('请填写充值金额',U('sms_list'),0);
            }
        }
        $this->assign('wallet_data',$wallet_data);
        $this->assign('sms_data',$sms_data);
        $this->display();
    }

    public function sms_state(){
        $id = I('id');
        $status = I('status');
//        $status=M('sms_list')->where(array('id'=>$id))->getField('sms_state');//判断当前状态情况
        if($status==1){
            $statedata = array('sms_state'=>1);
            $auth_group=M('sms_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('状态已开启',U('sms_list'),1);
        }else{
            $statedata = array('sms_state'=>2);
            $auth_group=M('sms_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('状态已禁止',U('sms_list'),1);
        }
    }
}