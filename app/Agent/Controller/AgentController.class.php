<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Agent\Controller;


class AgentController extends AgentbaseController
{
    //账号申请
    function userApply()
    {
        if (IS_POST) {
            //构建数组
            $sub_value = I('options');
            foreach ($sub_value as $k => $v) {
                switch ($k) {
                    case 'weixin':
                        $wx = $_SESSION['user']['agent_list_weixin_rate']*100 + $v['agent'] + $v['agent1'] + $v['agent2'];
                        $sub_value[$k]['client']=$wx;
                        break;
                    case 'alipay':
                        $alipay = $_SESSION['user']['agent_list_alipay_rate']*100 + $v['agent'] + $v['agent1'] + $v['agent2'];
                        $sub_value[$k]['client']=$alipay;
                        break;
                    case 'netgate':
                        $netgate = $_SESSION['user']['agent_list_payin_rate']*100 + $v['agent'] + $v['agent1'] + $v['agent2'];
                        $sub_value[$k]['client']=$netgate;
                        break;
                }
            }
            $data = array(
                'agent_list_memberid' => $_SESSION['hid'],
                'agent_sub_name' => I('sub_name'),
                'agent_sub_industry' => I('sub_industry'),
                'agent_sub_pay_type' => I('sub_pay_type'),
                'agent_sub_expect' => I('sub_expect'),
                'agent_sub_value' => json_encode($sub_value),
                'agent_sub_status' => '0',
                'update_time' => time(),
            );
            $rst = M('agent_sub')->add($data);

            if ($rst !== false) {
                $this->success('客户申请提交成功', U('aglist'), 1);
            } else {
                $this->error('客户申请提交失败', U('aglist'), 0);
            }

        } else {

            $this->display();
        }
    }

    //账号列表
    function aglist()
    {
        $aglist_list = M('agent_sub')->where(array('agent_list_memberid' => $_SESSION['hid']))->select();

        foreach ($aglist_list as $key => $value) {
            $sub_value = json_decode(str_replace("'", "", $value['agent_sub_value']), true);

            foreach ($sub_value as $k => $v) {

                $aglist_list[$key][str_replace("'", "", $k)] = $v;

            }
        }

//        dump($aglist_list);
//        dump($aglist_list[0]['netgate']);
//        die();

        $this->assign('aglist_list', $aglist_list);

        $this->display();
    }

}