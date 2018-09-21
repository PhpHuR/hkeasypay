<?php
/**
 * User: zhouding
 * Date: 2016/9/12
 * Time: 22:04
 */

namespace Agent\Controller;
use Org\Util\Stringnew;
use Agent\Controller\AgentbaseController;
class UserinfoController extends AgentbaseController
{
    function userinfo_list()
    {
        /**
         * 商户管理
         */
        $key = I('key');
        $map['tel'] = array('like', "%" . $key . "%");
        $map['member_name'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'OR';
        /*
         * 分页操作
         */
        $count = M('userinfo')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $userinfo_list = D('userinfo')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('time desc')->relation(true)->select();
        $this->assign('userinfo_list', $userinfo_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();
    }

    function userinfo_add()
    {
        if (IS_POST) {
            $userinfo_salt = Stringnew::randString(10);
            $md5key = Stringnew::randString(16);
            $userinfo_data = array(
                'member_name' => I('member_name'),
                'type' => 1,
                'tel' => I('tel'),
                'industry' => I('industry'),
                'address' => I('address'),
                'md5key' => $md5key,
                'paypsd_salt' => $userinfo_salt,
                'paypsd' => encrypt_password(I('paypsd'), $userinfo_salt),
                'payin_rate' => I('payin_rate'),
                'payin_id' => I('payin_id'),
                'payin_mid' => I('payin_mid'),
                'payout_id' => I('payout_id'),
                'payout_mid' => I('payout_mid'),
                'payout_rate' => I('payout_rate'),
                'payout_auto' => I('payout_auto'),
                'time' => time()

            );
            $userinfo = M('userinfo');
            if ($userinfo->where(array('member_name' => I('member_name')))->find()) {
                $this->error('商户名称重复，请重新填写', U('Userinfo/userinfo_list'), 0);
            } else {
                $rst = $userinfo->add($userinfo_data);
                if ($rst) {
                    $this->success('商户添加成功', U('Userinfo/userinfo_list'), 1);
                } else {
                    $this->error('商户添加失败', U('Userinfo/userinfo_list'), 0);
                }
            }

        } else {
            $payment_name = M('payment_name')->select();
            $payin_rate = M('payin_rate')->select();
            $payout_rate = M('payout_rate')->select();
            $this->assign('payment_name', $payment_name);
            $this->assign('payin_rate', $payin_rate);
            $this->assign('payout_rate', $payout_rate);
            $this->display();
        }
    }


    public function userinfo_edit()
    {
        $userinfo_edit = M('userinfo')->where(array('user_id' => I('user_id')))->find();
        $payment_name = M('payment_name')->select();
        $payin_rate = M('payin_rate')->select();
        $payout_rate = M('payout_rate')->select();
        $this->assign('payment_name', $payment_name);
        $this->assign('payin_rate', $payin_rate);
        $this->assign('payout_rate', $payout_rate);
        $this->assign('userinfo_edit', $userinfo_edit);
        $this->display();
    }

    public function userinfo_runedit()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('userinfo_list'), 0);
        } else {

            $sl_data['id'] = I('id');
            $sl_data['member_name'] = I('member_name');

            $pwd = I('paypsd');
            if (!empty($pwd)) {
                $userinfo_salt = Stringnew::randString(10);
                $sl_data['userinfo_salt'] = $userinfo_salt;
                $sl_data['paypsd'] = encrypt_password($pwd, $userinfo_salt);
            }

            $sl_data['tel'] = I('tel');
            $sl_data['industry'] = I('industry');
            $sl_data['address'] = I('address');
            $sl_data['payin_rate'] = I('payin_rate');
            $sl_data['payin_id'] = I('payin_id');
            $sl_data['payin_mid'] = I('payin_mid');
            $sl_data['payout_id'] = I('payout_id');
            $sl_data['payout_mid'] = I('payout_mid');
            $sl_data['payout_rate'] = I('payout_rate');
            $sl_data['payout_auto'] = I('payout_auto');

            $u_access = M('userinfo')->save($sl_data);

            if ($u_access) {
                $this->success('商户修改成功', U('userinfo_list'), 1);
            } else {
                $this->error('商户修改失败', U('userinfo_list'), 0);
            }

        }


    }

    function info()
    {
        if (session('hid')) {
            //读取总额以及每个子集下面的额度

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

    function order_details()
    {
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

        $this->assign('userinfo', $userinfo);
        $this->assign('payin_order_sum', $payin_order_sum);
        $this->assign('payin_order_free', $payin_order_free);
        $this->assign('payout_order_sum', $payout_order_sum);
        $this->assign('payout_order_free', $payout_order_free);
        $this->display();
    }

    function userApply()
    {
        //账户申请

        $this->display();
    }

}