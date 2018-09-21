<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/26
 * Time: 17:17
 */

namespace Admin\Controller;
use Common\Controller\AuthController;

class MtfourController extends AuthController
{
    public function mt_list(){
        $count = M('mtfour')->count();
        $page = getpage($count,10);
        $show = $page->show();// 分页显示输出
        $this->assign('page', $show);
        $mtdata = M('mtfour')->field('id,realname,phone,user_id,bankname')->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();

        $this->assign('mtdata',$mtdata);
        $this->display();
    }
    public function mt_select(){
        $id = I('id');
        $mtdata = M('mtfour')->where(array('id'=>$id))->find();
        $this->assign('mtdata',$mtdata);
        $this->display();
    }
    public function mt_del(){
        $id = I('id');
        $res = M('mtfour')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功',U('index'),1);
        }else{
            $this->error('删除成功',U('index'),0);
        }
    }
}