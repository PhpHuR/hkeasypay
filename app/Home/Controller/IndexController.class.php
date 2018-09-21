<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Home\Controller;

use Think\Verify;
use Home\Controller\HomebaseController;

class IndexController extends HomebaseController
{
    public function index()
    {
//        $this->display(':index');

        if (session('hid')) {
            if ($this->user['user_status']) {
                /*
                 * 首页业务代码
                 * 当天时间：strtotime(date('Ymd'))
                 */

                $key = I('key');
                $sldate = I('reservation','');
                if (empty($sldate)) {
                    $begin_time = date('Y-m-d');
                    $end_time = date('Y-m-d');
                    $sldate = $begin_time . ' - ' . $end_time;
                }

                if (strpos($sldate,'+')) {
                    $sldate=preg_replace('/\+/', ' ', $sldate);
                }
                $arr = explode(" - ",$sldate);//转换成数组
                if(count($arr)==2){
                    $arrdateone=strtotime($arr[0]);
                    $arrdatetwo=strtotime($arr[1].' 23:59:59');
                    $map['begin_time'] = array(array('egt',$arrdateone),array('elt',$arrdatetwo),'AND');
                }
                $map['orderid']= array('like',"%".$key."%");
                //用户余额读取
                $userinfo = M('user_balance')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();

                //统计入金结果 - 按照货币类型
                $begin = strtotime(date('Ymd'));
                $end = strtotime(date('Ymd'.' 23:59:59'));
                $sql = "SELECT sum(ordermoney) as iordermoney,sum(free) as ifree,currency_id from  __PREFIX__payin ";
                $sql .= " where begin_time>$begin and begin_time<$end AND status=1 group by currency_id";
                $res = M()->query($sql);//订单数,交易额

                //出金统计
                $osql = "SELECT sum(transfermoney) as otransfermoney,sum(free) as ofree,currency_id from  __PREFIX__payout ";
                $osql .= " where begin_time>$begin and begin_time<$end AND status=4 group by currency_id";
                $ores = M()->query($osql);//订单数,交易额

                $list_res = array_merge($res, $ores);
//        dump($res);
//        dump($ores);
//        dump($list_res);
//        die();

                $payin_order_sum = M('payin')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 1, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('ordermoney');//入金总金额
                $payin_order_free = M('payin')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 1, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('free');//入金总手续费
                $payout_order_sum = M('payout')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 4, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('transfermoney');//出金总金额
                $payout_order_free = M('payout')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 4, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('free');//出金总手续费
                /*
                 * 交易记录列表
                 */
                $map['uid'] = $this->user['member_list_userinfoid'];
                $map['_logic'] = 'AND';
                $count = M('order_log')->where($map)->count();// 查询满足要求的总记录数
                $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
                $show = $Page->show();// 分页显示输出
                $order_log_list = M('order_log')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('order_log_id desc')->select();
                $curofferList = M('curoffer')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();
                $this->assign('curofferList', $curofferList);
                $this->assign('order_log_list', $order_log_list);
                $this->assign('page', $show);
                $this->assign('sldate', $sldate);
                $this->assign('keyy', $key);
                $this->assign('userinfo', $userinfo);
                $this->assign('payin_order_sum', $payin_order_sum);
                $this->assign('payin_order_free', $payin_order_free);
                $this->assign('payout_order_sum', $payout_order_sum);
                $this->assign('payout_order_free', $payout_order_free);
                if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                    $payout_order_cny_sum = M('payout')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 4, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('transfermoney_hkd');//出金总金额
                    $this->assign('payout_order_cny_sum',$payout_order_cny_sum);
                    $this->assign('user_id', $_SESSION['user']['member_list_userinfoid']);
                    $this->display(":index-hkd");
                }else{
                    $this->display(":index");
                }
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