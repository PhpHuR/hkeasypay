<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/14
 * Time: 17:31
 */

namespace Admin\Controller;
use Common\Controller\AuthController;

class WalletController extends AuthController
{
    function wallet_list(){
        $wallet_data = M('wallet_list')->select();
        $this->assign('wallet_data',$wallet_data);
        $this->display();
    }

    public function wallet_add(){
        if(IS_POST){
            $post['user_id']  = I('user_id');
            $post['money'] = I('money');
            $post['create_time'] = date('Y-m-d H:i:s');
            $post['updata_time'] = date('Y-m-d H:i:s');
            $status = true;
            switch ($status){
                case $post['user_id'] == 0:
                    $this->error('商户不能为空');
                    break;
                default:
                   $status = false;
            }
            $res = M('wallet_list')->add($post);
            if($res){
                $this->success('添加成功',U('wallet_list'),1);
            }else{
                $this->error('添加失败',U('wallet_list'),0);
            }
        }
        $user_data = M('userinfo')->field('user_id,member_name')->select();
        $this->assign('userdata',$user_data);
        $this->display();
    }
    public function wallet_del(){
        $id = I('id');
        if($id){
            $res = M('wallet_list')->where(array('id'=>$id))->delete();
            if($res){
                $this->success('删除成功',U('wallet_list'),1);
            }else{
                $this->error('删除失败',U('wallet_list'),0);
            }
        }

    }
    public function wallet_edit(){
        $id = I('id');
        if(IS_POST){
            $post['id']  = $id;
            $post['user_id']  = I('user_id');
            $post['money'] = I('money');
            $post['updata_time'] = date('Y-m-d H:i:s');
            $status = true;
            switch ($status){
                case $post['user_id'] == 0:
                    $this->error('商户不能为空');
                    break;
                default:
                    $status = false;
            }
            $res = M('wallet_list')->save($post);

            $this->success('添加成功',U('wallet_list'),1);
        }
        $wallet_data = M('wallet_list')->where(array('id'=>$id))->field('user_id,money')->find();
        $user_data = M('userinfo')->field('user_id,member_name')->select();
        $this->assign('wallet_data',$wallet_data);
        $this->assign('id',$id);
        $this->assign('userdata',$user_data);
        $this->display();
    }
}