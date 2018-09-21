<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/07/12
 * Time: 15:50
 */

namespace Home\Controller;


class UpbankController extends HomebaseController
{
    public function banklist(){
        $uid = $_SESSION['user']['member_list_userinfoid'];//用户id
        $sldate = I('reservation','');
        if($sldate){
            $arr = explode(' - ',$sldate);
            $begin_time = strtotime($arr[0]);
            $end_time = strtotime($arr[1]);
            $map['timestamp'] = array(array('egt', $begin_time), array('elt', $end_time), 'AND');

        }else{

            $begin_time = time();
            $end_time = time();
            $sldate = date('Y-m-d',$begin_time).' - '.date('Y-m-d',$end_time);
            $map['timestamp'] = array(array('egt', $begin_time), array('elt', $end_time), 'AND');
        }
        $map['user_id'] = $uid;
        $count = M('upbank')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        $upbank = M('upbank')->field('id,realname,phone,state,timestamp')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('sldate',$sldate);
        $this->assign('upbank',$upbank);
        $this->display();
    }

    public function bankselect(){
        $id = I('id');
        if(!$id){
            $this->error('请选择水单号',U('banklist'),0);
        }
        $upbank = M('upbank')->where(array('id'=>$id))->find();
        $this->assign('upbank',$upbank);
        $this->display();
    }
}