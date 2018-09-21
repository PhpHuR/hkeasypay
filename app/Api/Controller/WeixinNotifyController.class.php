<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/29
 * Time: 10:25
 */

namespace Api\Controller;

use \Think\Controller;

class WeixinNotifyController extends Controller
{
    public function return_url(){
        $path = I('wei_path');
        $order = I('order');
        $amount = I('amount');
        $this->assign('wei_path',$path);
        $this->assign('order',$order);
        $this->assign('amount',$amount);
        $this->display();
    }
}