<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Agent\Controller;

use Think\Auth;
use Common\Controller\CommonController;
class LoginbaseController extends CommonController{
    protected $user_model;
    protected $user;
    protected $userid;
    protected $yf_theme_path;
    protected function _initialize(){
        parent::_initialize();
        $site_options=get_site_options();
        C('DEFAULT_THEME', $site_options['site_tpl']);
        $site_options['site_copyright']=htmlspecialchars_decode($site_options['site_copyright']);
        $this->assign($site_options);
        $this->theme(C('DEFAULT_THEME'));
        $this->userid=0;
        $this->user=array();
        $this->user_model=M('agent_list');
        $address='';
        if(session('hid')){
            $this->userid=session('hid');
            $this->user=$this->user_model->find(session('hid'));
        }

        $this->yf_theme_path=__ROOT__."/app/".MODULE_NAME.'/'.C('DEFAULT_V_LAYER').'/'.C('DEFAULT_THEME').'/';
        $this->user['address']=$address;
        $this->assign("yf_theme_path",$this->yf_theme_path);
        $this->assign("user",$this->user);
    }
    /**
     * 检查用户登录
     */
    protected function check_login(){
        if(!session('hid')){
            $this->error('您还没有登录！',__ROOT__."/Agent");
        }
    }
    /**
     * 检查操作频率
     * @param int $t_check 距离最后一次操作的时长
     */
    protected function check_last_action($t_check){
        $action=MODULE_NAME."-".CONTROLLER_NAME."-".ACTION_NAME;
        $time=time();
        if(!empty($_SESSION['last_action']['action']) && $action==$_SESSION['last_action']['action']){
            $t=$time-$_SESSION['last_action']['time'];
            if($t_check>$t){
                $this->error("操作太频繁，请喝杯咖啡后再试!",0,0);
            }else{
                $_SESSION['last_action']['time']=$time;
            }
        }else{
            $_SESSION['last_action']['action']=$action;
            $_SESSION['last_action']['time']=$time;
        }
    }
}