<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;

use Home\Controller\HomebaseController;

/**
 * 文章列表
 */
class ListController extends HomebaseController
{

    public function index()
    {
        $menu = M('menu')->find(I('id'));
        if (empty($menu)) {
            $this->error('此操作无效');
        }
        $tplname = $menu['menu_listtpl'];
        $tplname = $tplname ? $tplname : 'list';
        $this->assign('menu', $menu);
        $this->assign('list_id', I('id'));
        $this->display(":$tplname");
    }

    public function search()
    {
        $k = I("keyword");
        if (empty($k)) {
            $this->error("关键词不能为空！请重新输入！");
        }
        $this->assign("keyword", $k);
        $this->display(":search");
    }

    function product()
    {
        $this->display(":product");
    }

    function aboutus()
    {
        $this->display(":aboutus");
    }

    function contactus()
    {
        if (IS_POST) {
            $to = "info@globalspeedlink.com";
//            $to = "yangjingyang@globalspeedlink.com";
            $title = I('Nickname');
            if (!(filter_var(I('email'), FILTER_VALIDATE_EMAIL))) {
                $this->error('郵箱地址不合法，請重新輸入！',U('contactus'),0);
            }
            $ip = get_client_ip();

            $content = "發件人：" .I('email')."--發件人 IP：".$ip."--發件內容：".I('body');

            $res = sendMail($to, $title, $content);
            if ($res['error']==0) {
                $this->success('郵件發送成功！',U('contactus'),1);
            } else {
                $this->error('郵件發送失敗，請直接電話聯繫客服！',U('contactus'),0);
            }
        }else{
            $this->display(":contactus");
        }
    }

    function privacy()
    {
        $this->display(":privacy");
    }

    function disclaimer()
    {
        $this->display(":disclaimer");
    }

    function terms()
    {
        $this->display(":terms");
    }
}
