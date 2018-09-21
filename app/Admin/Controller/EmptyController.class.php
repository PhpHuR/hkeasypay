<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Common\Controller\CommonController;
class EmptyController extends CommonController{
    public function index(){
        $this->error('此操作无效');
    }
}