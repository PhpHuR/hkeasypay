<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Payout\Controller;

use Think\Verify;
use Home\Controller\HomebaseController;

class IndexController extends PayoutbaseController
{
    public function index()
    {

        if (session('hid')) {
            if ($this->user['user_status']) {
                /*
                 * 首页业务代码
                 * 当天时间：strtotime(date('Ymd'))
                 */
                $key=I('key');
                $sldate=I('reservation','');//获取格式 2015-11-12 - 2015-11-18
                if (strpos($sldate,'+')) {
                    $sldate=preg_replace('/\+/', ' ', $sldate);
                }
                $arr = explode(" - ",$sldate);//转换成数组
                if(count($arr)==2){
                    $arrdateone=strtotime($arr[0]);
                    $arrdatetwo=strtotime($arr[1].' 23:55:55');
                    $map['begin_time'] = array(array('egt',$arrdateone),array('elt',$arrdatetwo),'AND');
                }
                $map['orderid']= array('like',"%".$key."%");

                if ($this->user['member_list_groupid'] == '5') {
                    //跳转到管理员首页
                    redirect(U('Userinfo/userinfo_list'));
                    die();

                }

                if ($this->user['member_list_groupid'] == '4') {
                    //跳转到出金员首页
                    redirect(U('Payout/turnFoAuditOrderPage'));
                    die();
                }


                $userinfo = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();
                $payin_order_sum = M('payin')->where(array('status' => 1, 'end_time' => array('gt', strtotime(date('Ymd')))))->sum('ordermoney');//入金总金额
                $payin_order_free = M('payin')->where(array('status' => 1, 'end_time' => array('gt', strtotime(date('Ymd')))))->sum('free');//入金总手续费
                $payout_order_sum = M('payout')->where(array('status' => 4, 'result_time' => array('gt', strtotime(date('Ymd')))))->sum('transfermoney');//出金总金额
                $payout_order_free = M('payout')->where(array('status' => 4, 'result_time' => array('gt', strtotime(date('Ymd')))))->sum('free');//出金总手续费
                /*
                 * 交易记录列表
                 */
                $map['uid'] = $this->user['member_list_userinfoid'];
                $map['end_time'] = array('gt', strtotime(date('Ymd')));
                $map['_logic'] = 'AND';
                $count = M('order_log')->where($map)->count();// 查询满足要求的总记录数
                $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
                $show = $Page->show();// 分页显示输出
                $order_log_list = M('order_log')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();
                $this->assign('order_log_list', $order_log_list);
                $this->assign('page', $show);
                $this->assign('sldate',$sldate);
                $this->assign('keyy',$key);
                $this->assign('userinfo', $userinfo);
                $this->assign('payin_order_sum', $payin_order_sum);
                $this->assign('payin_order_free', $payin_order_free);
                $this->assign('payout_order_sum', $payout_order_sum);
                $this->assign('payout_order_free', $payout_order_free);
                $this->display(':index');
            } else {
                $this->display("User:active");
            }
        } else {
            $this->display("User:login");
        }


    }

    public function visit()
    {
        $id = I("get.id");
        $users_model = M("member_list");
        $user = $users_model->where(array("member_list_id" => $id))->find();
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