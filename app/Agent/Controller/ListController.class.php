<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Payout\Controller;
use Payout\Controller\PayoutbaseController;
/**
 * 文章列表
*/
class ListController extends PayoutbaseController {

	public function index() {
		$menu=M('menu')->find(I('id'));
		if(empty($menu)){
		    $this->error('此操作无效');
		}
		$tplname=$menu['menu_listtpl'];
    	$tplname=$tplname?$tplname:'list';
    	$this->assign('menu',$menu);
    	$this->assign('list_id', I('id'));
    	$this->display(":$tplname");
	}
    public function search() {
		$k = I("keyword");
		if (empty($k)) {
			$this -> error("关键词不能为空！请重新输入！");
		}
		$this -> assign("keyword", $k);
		$this -> display(":search");
    }
}
