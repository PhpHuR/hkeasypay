<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/07
 * Time: 15:17
 */

namespace Admin\Controller;
use Common\Controller\AuthController;

class SmsController extends AuthController
{
    public function sms_list(){
//        sms数据获取
        $data = M('sms_list')->alias('t1')->join('left join um2_userinfo t2 on t1.u_id=t2.user_id')->field('t1.*,t2.member_name as m_name')->select();
        $this->assign('sms_data',$data);
        $this->display();
    }
    public function sms_edit(){

        $sms_id = I('id');
        if(IS_POST){
            $postData['u_id'] = I('user_id');
            $postData['sms_username'] = I('sms_username');
            $postData['sms_pass'] = I('sms_pass');
            $postData['sms_product_id'] = I('sms_product_id');
            $postData['sms_payin_text'] = I('payin_msg');
            $postData['sms_payout_text'] = I('payout_msg');
            $postData['mobile'] = I('sms_mobile');
            $postData['sms_money'] = I('sms_money');
            $postData['sms_count'] = I('sms_count');
            $postData['small_mobile'] = I('small_mobile');
            $status = true;
            switch ($status){
                case $postData['u_id'] == 0:
                    $this->error('商户不能为空');
                    break;
                case !isset($postData['sms_username']):
                    $this->error('用户名不能为空');
                    break;
                case !isset($postData['sms_pass']):
                    $this->error('密码不能为空');
                    break;
                case !isset($postData['sms_product_id']):
                    $this->error('产品id不能为空');
                    break;
                case !isset($postData['mobile']):
                    $this->error('手机号不能为空');
                    break;
                case !isset($postData['sms_payin_text']):
                    $this->error('入款通知不能为空');
                    break;
                case !isset($postData['sms_payout_text']):
                    $this->error('出金通知不能为空');
                    break;
                case !isset($postData['sms_money']):
                    $this->error('销售金额不能为空');
                    break;
                case !isset($postData['sms_count']):
                    $this->error('可用条数不能为空');
                    break;
                default:
                    $status = false;
            }
            M('sms_list')->where(array('id'=>$sms_id))->save($postData);
            $this->success('修改成功', U('Sms/sms_list'), 1);

        }

        $sms_data = M('sms_list')->alias('t1')->join('left join um2_userinfo t2 on t1.u_id=t2.user_id')->field('t1.*,t2.member_name as m_name,t2.user_id as u_id')->where(array('t1.id'=>$sms_id))->find();
        $data = M('userinfo')->field('member_name,user_id')->select();
        $this->assign('userdata',$data);
        $this->assign('sms_id',$sms_id);
        $this->assign('sms_data',$sms_data);
        $this->display();
    }
    public function sms_add(){
        if(IS_POST){
            $postData['sms_username'] = I('sms_username');
            $postData['u_id'] = I('user_id');
            $postData['sms_pass'] = I('sms_pass');
            $postData['sms_product_id'] = I('sms_product_id');
            $postData['mobile'] = I('sms_mobile');
            $postData['sms_payin_text'] = I('payin_msg');
            $postData['sms_payout_text'] = I('payout_msg');
            $postData['small_mobile'] = I('small_mobile');
            $postData['sms_count'] = I('sms_count');
            $postData['sms_money'] = I('sms_money');
            $status = true;
            switch ($status){
                case $postData['u_id'] == 0:
                    $this->error('商户不能为空');
                    break;
                case !isset($postData['sms_username']):
                    $this->error('用户名不能为空');
                    break;
                case !isset($postData['sms_pass']):
                    $this->error('密码不能为空');
                    break;
                case !isset($postData['sms_product_id']):
                    $this->error('产品id不能为空');
                    break;
                case !isset($postData['sms_payin_text']):
                    $this->error('入款通知不能为空');
                    break;
                case !isset($postData['mobile']):
                    $this->error('手机号不能为空');
                    break;
                case !isset($postData['sms_payout_text']):
                    $this->error('出金通知不能为空');
                    break;
                case !isset($postData['sms_money']):
                    $this->error('销售金额不能为空');
                    break;
                case !isset($postData['sms_count']):
                    $this->error('可用条数不能为空');
                default:
                    $status = false;
            }

            $res = M('sms_list')->add($postData);
            if($res){
                $this->success('添加成功', U('Sms/sms_list'), 1);
            }else{
                $this->success('添加失败', U('Sms/sms_list'), 0);
            }
        }
        $data = M('userinfo')->field('member_name,user_id')->select();
        $this->assign('userdata',$data);
        $this->display();
    }
    public function sms_del(){
        $sms_id = I('id');
        if($sms_id < 0){
            $this->error('请选择SMS用户');
        }
        $sms_data = M('sms_list')->where(array('id'=>$sms_id))->delete();
        if($sms_data){
            $this->success('成功删除');
        }else{
            $this->error('删除失败');
        }
    }
    public function sms_state(){
        $id = I('x');
        $status=M('sms_list')->where(array('id'=>$id))->getField('sms_state');//判断当前状态情况
        if($status==1){
            $statedata = array('sms_state'=>2);
            $auth_group=M('sms_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('状态禁止',1,1);
        }else{
            $statedata = array('sms_state'=>1);
            $auth_group=M('sms_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('状态开启',1,1);
        }
    }
}