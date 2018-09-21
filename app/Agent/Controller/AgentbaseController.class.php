<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Agent\Controller;

use Think\Auth;
use Common\Controller\CommonController;
class AgentbaseController extends CommonController{
	protected $user_model;
	protected $user;
	protected $userid;
	protected $yf_theme_path;
	protected $userIdArray;
	protected $agentIdArray;
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
		//獲取子集
		$agentIdArray = array();
		$agentIdArray[] = session('hid');
        $arr_ag_sub = getAgentSub(session('hid'));
//        dump(getUserAgentRate('8813','90005'));

        $this->agentIdArray = array_merge($agentIdArray,$arr_ag_sub);

		foreach ($arr_ag_sub as $k => $v) {
			array_push($agentIdArray, $v['agent_list_id']);
		}
		//获取代理名下用户ID
		$mapAgentId['agent_id'] = array('in',$agentIdArray);
		$userArray = M('userinfo')->where($mapAgentId)->field('user_id')->order('user_id')->select();

		$userIdArray = array();
		foreach ($userArray as $ku=>$vu) {
			array_push($userIdArray, $vu['user_id']);
		}
        $this->userIdArray = $userIdArray;
//		獲取子集結束

		/*
		 *
		 *
		 *,'Login/index','Login/verify','Login/runlogin','Login/check_active','Login/out'
		 * begin menus
		 * */
		//已登录，不需要验证的权限
		$not_check = array('Sys/clear','Index/index','List/Index','List/product','List/aboutus','List/contactus','list/contactus','List/terms','List/disclaimer','List/privacy','Ajax/getRegion','Ajax/getMid','Ajax/getBalance','Ajax/curoffer');//不需要检测的控制器/方法

		//当前操作的请求                 模块名/方法名
		//不在不需要检测的控制器/方法时,检测
		if(!in_array(CONTROLLER_NAME.'/'.ACTION_NAME, $not_check)){
			$auth = new Auth();
			if(!$auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,session('hid')) && session('hid')!= 1){
				$this->error('没有权限访问该页面',redirect(__ROOT__."/"),0);
			}
		}
		//获取有权限的菜单tree
		$menus=F('menus_admin_'.session('hid'));

		if(empty($menus)){
			$m = M('auth_rule');
			$auth = new Auth();
			$data = $m->where(array('status'=>1))->order('sort')->select();
			foreach ($data as $k=>$v){
				if(!$auth->check($v['name'], session('hid')) && session('hid') != 1){
					unset($data[$k]);
				}
			}
			$menus=node_merge($data);
			F('menus_admin_'.session('hid'),$menus);
		}


		$this->assign('menus',$menus);
		//当前方法倒推到顶级菜单数组
		$menus_curr=get_menus_admin();
		//如果$menus_curr为空,则根据'控制器/方法'取status=0的menu
		if(empty($menus_curr)){
			$rst=M('auth_rule')->where(array('status'=>0,'name'=>CONTROLLER_NAME.'/'.ACTION_NAME))->order('level desc,sort')->limit(1)->select();
			if($rst){
				$pid=$rst[0]['pid'];
				//再取父级
				$rst=M('auth_rule')->where(array('id'=>$pid))->find();
				$menus_curr=get_menus_admin($rst['name']);
			}
		}
		$this->assign('menus_curr',$menus_curr);
		//取当前操作菜单父ID
		if(count($menus_curr)>=4){
			$pid=$menus_curr[1];
			$id_curr=$menus_curr[2];
		}elseif(count($menus_curr)>=2){
			$pid=$menus_curr[count($menus_curr)-2];
			$id_curr=end($menus_curr);
		}else{
			$pid='0';
			$id_curr=(count($menus_curr)>0)?end($menus_curr):'';
		}
		//取$pid下子菜单
		$menus_child=M('auth_rule')->where(array('status'=>1,'pid'=>$pid))->order('sort')->select();
		$this->assign('menus_child',$menus_child);
		$this->assign('id_curr',$id_curr);

		/*
		 * end menus
		 *
		 * */

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