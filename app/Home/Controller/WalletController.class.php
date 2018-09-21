<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/15
 * Time: 10:53
 */

namespace Home\Controller;


class WalletController extends HomebaseController
{
    public function wallet_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $sum_money = M('sub_user_balance')->where(array('user_id'=>$uid))->select();
        $wallet_data = M('wallet_list')->where(array('user_id'=>$uid))->field('money')->find();
        if(IS_POST){
            $money = I('money');
            $sum_money = M('user_balance')->where(array('user_id'=>$uid))->field('availablecount,sumcount')->find();
            if(!isset($money)){
                $this->error('请填写金额');
            }
//            扣金额
            $sumcount = $sum_money['sumcount'] - $money;
            $availablecount = $sum_money['availablecount'] -$money;
            $check_id = 'c'.createOrder($uid);
            $data = array(
                'sumcount' =>$sumcount,
                'availablecount' => $availablecount,
                'update_at' => date('Y-m-d H-i-s')
            );
            $res = M('user_balance')->where(array('user_id'=>$uid))->save($data);

            if($res){
                if(payoutSubUserBalanceUpdate(I('sub_balance'),$money)){
                    //            充值金额
                    $wallet_money['money'] = $wallet_data['money'] + $money;
                    $res = M('wallet_list')->where(array('user_id'=>$uid))->save($wallet_money);
                    if(!$res){
                        $this->error('充值金额失敗',U('wallet_list'), 0);
                    }
                    //写入日志信息
                    $content = '充值记录写入成功。订单号：' . $check_id . '###充值金額' . $money .'可用餘額'.$availablecount.'总金额'.$sumcount;
                    $logResult = wallet_addLog($uid,$check_id, 1, 'wallet', '充值金额', $content);
                    $this->success('成功充值',U('wallet_list'), 1);
                }else{
                    //写入日志信息
                    $content = '充值记录写入失败。订单号：' . $check_id . '###充值金額' . $money .'可用餘額'.$availablecount.'总金额'.$sumcount;
                    $logResult = wallet_addLog($uid, $check_id,2, 'wallet', '充值金额', $content);
                    $this->error('子账号金额扣除失敗',U('wallet_list'),1);
                }

            }else{
                $this->error('金额扣除失敗',U('wallet_list'), 0);
            }
        }



        $this->assign('sum_money',$sum_money);
        $this->assign('wallet_data',$wallet_data);
        $this->display();
    }
}