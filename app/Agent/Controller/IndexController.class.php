<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Agent\Controller;

use Think\Verify;

use Agent\Controller\AgentbaseController;

class IndexController extends AgentbaseController
{
    public function index()
    {

        if (session('hid')) {
            //读取总额以及每个子集下面的额度
            $mapsum['agent_pid'] = session('hid');
            $mapsum['update_time'] = array('gt', strtotime(date('Ymd')));
            $mapsum['_logic'] = 'AND';

            $mapPayinNetgate['_complex'] = $mapsum;
            $mapPayinNetgate['paybank'] = array(array('neq','weixin'),array('neq','alipay'));
            //今日網銀入金
            $payin_order_netgate_sum = M('agentpayin')->where($mapPayinNetgate)->sum('order_money');
            $this->assign('payin_order_netgate_sum',$payin_order_netgate_sum);
            //今日網銀手續費
            $payin_order_netgate_free = M('agentpayin')->where($mapPayinNetgate)->sum('agentfree');
            $this->assign('payin_order_netgate_free',$payin_order_netgate_free);

            //今日微信入金
            $mapPayinWeixin['_complex'] = $mapsum;
            $mapPayinWeixin['paybank'] = 'weixin';

            $payin_order_weixin_sum = M('agentpayin')->where($mapPayinWeixin)->sum('order_money');
            $this->assign('payin_order_weixin_sum',$payin_order_weixin_sum);

            $payin_order_weixin_free = M('agentpayin')->where($mapPayinWeixin)->sum('agentfree');
            $this->assign('payin_order_weixin_free',$payin_order_weixin_free);

            //今日支付寶
            $mapPayinAlipay['_complex'] = $mapsum;
            $mapPayinAlipay['paybank'] = 'alipay';

            $payin_order_alipay_sum = M('agentpayin')->where($mapPayinAlipay)->sum('order_money');
            $this->assign('payin_order_alipay_sum',$payin_order_alipay_sum);

            $payin_order_alipay_free =  M('agentpayin')->where($mapPayinAlipay)->sum('agentfree');
            $this->assign('payin_order_alipay_free',$payin_order_alipay_free);


            //今日总入金
            $payin_order_sum = M('agentpayin')->where($mapsum)->sum('order_money');
            $this->assign('payin_order_sum',$payin_order_sum);

            //今日总入金手续费
            $payin_order_free = $payin_order_netgate_free+$payin_order_weixin_free+$payin_order_alipay_free;
            $this->assign('payin_order_free',$payin_order_free);


            $this->display(':index');
        } else {
            $this->display("User:login");
        }

    }

    public function visit()
    {
        $id = I("get.id");
        $users_model = M("agent_list");
        $user = $users_model->where(array("agent_list_id" => $id))->find();
        if (empty($user)) {
            $this->error("查无此人！", 0, 0);
        }
        $this->assign($user);
        $this->display("User:index");
    }

    public function verify_msg()
    {
        ob_end_clean();
        $verify = new Verify (array(
            'fontSize' => 20,
            'imageH' => 40,
            'imageW' => 150,
            'length' => 4,
            'useCurve' => false,
        ));
        $verify->entry('msg');
    }

    public function addmsg()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', 0, 0);
        } else {
            $verify = new Verify ();
            if (!$verify->check(I('verify'), 'msg')) {
                $this->error('验证码错误', 0, 0);
            }
            $data = array(
                'plug_sug_name' => I('plug_sug_name'),
                'plug_sug_email' => I('plug_sug_email'),
                'plug_sug_content' => I('plug_sug_content'),
                'plug_sug_addtime' => time(),
                'plug_sug_open' => 0,
                'plug_sug_ip' => get_client_ip(0, true),
            );
            $rst = M('plug_sug')->data($data)->add();
            if ($rst !== false) {
                $this->success("留言成功", 1, 1);
            } else {
                $this->error('留言失败', 0, 0);
            }
        }
    }

}