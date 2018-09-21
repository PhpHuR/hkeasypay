<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Admin\Controller;


use Common\Controller\AuthController;
use Org\Util\Stringnew;

class AgentController extends AuthController
{
    function index()
    {
        $this->display();
    }

    function add()
    {
        if (IS_POST) {
            //构建数组
            $access = M('auth_group_access');
            $agent_list_salt = Stringnew::randString(10);
            $data = array(
                'agent_list_username' => I('username'),
                'agent_list_nickname' => I('nickname'),
                'agent_list_memberid' => I('agent_list_memberid'),
                'agent_list_salt' => $agent_list_salt,
                'agent_list_pwd' => encrypt_password(I('user_passwd'), $agent_list_salt),
                'agent_list_pid' => I('parentid'),
                'agent_list_payin_rate' => I('payin_rate') / 100,
                'agent_list_weixin_rate' => I('weixin_rate') / 100,
                'agent_list_alipay_rate' => I('alipay_rate') / 100,
                'agent_list_payout_rate' => empty(I('payout_rate'))?'0':I('payout_rate'),
                'agent_list_change_rate' => empty(I('change_rate'))?'0':I('change_rate'),
                'agent_list_cross_rate' => empty(I('cross_rate'))?'0':I('cross_rate'),
                'update_time' => time(),
            );

            $rst = M('agent_list')->add($data);

            $accdata = array(
                'uid' => $rst,
                'group_id' => I('agent_list_memberid'),
            );
            $access->add($accdata);



            if ($access !== false) {
                $this->success('添加代理商成功', U('aglist'), 1);
            } else {
                $this->error('添加代理商失败', U('aglist'), 0);
            }

        } else {
            //权限组
            $auth_group = M('auth_group')->where(array('id' => array('gt', 7)))->select();
            $this->assign('auth_group', $auth_group);

            $parentid = I('id', 0);
            $this->assign('parentid', $parentid);
            $this->display();
        }
    }

    function edit()
    {
        $agent_id = I('id');
        $agent_list = M('agent_list')->where(array('agent_list_id' => $agent_id))->find();
        $this->assign('agent_list', $agent_list);
        $auth_group = M('auth_group')->where(array('id' => array('gt', 7)))->select();
        $this->assign('auth_group', $auth_group);
        $this->display();
    }

    function runedit()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('aglist'), 0);
        } else {

            $user_access = M('auth_group_access');

            $group_id = I('agent_list_memberid');

            $sl_data['agent_list_id'] = I('agent_list_id');
            $sl_data['agent_list_nickname'] = I('nickname');
            $sl_data['agent_list_memberid'] = I('agent_list_memberid');
            $pwd = I('user_passwd');

            if (!empty($pwd)) {
                $agent_list_salt = Stringnew::randString(10);
                $sl_data['agent_list_salt'] = $agent_list_salt;
                $sl_data['agent_list_pwd'] = encrypt_password($pwd, $agent_list_salt);
            }
            $sl_data['agent_list_payin_rate'] = I('payin_rate') / 100;
            $sl_data['agent_list_weixin_rate'] = I('weixin_rate') / 100;
            $sl_data['agent_list_alipay_rate'] = I('alipay_rate') / 100;
            $sl_data['agent_list_payout_rate'] = I('payout_rate');
            $sl_data['agent_list_change_rate'] = I('change_rate');
            $sl_data['agent_list_cross_rate'] = I('cross_rate');
            $sl_data['update_time'] = time();


            $result = M('agent_list')->save($sl_data);


            if ($group_id) {
                $u_access = $user_access->where(array('uid' => I('agent_list_id')))->find();
                if ($u_access) {
                    //修改
                    $u_access = $user_access->where(array('uid' => I('agent_list_id')))->setField('group_id', $group_id);
                } else {
                    //新增
                    $accdata = array(
                        'uid' => I('agent_list_id'),
                        'group_id' => I('member_list_groupid')
                    );
                    $u_access = $user_access->add($accdata);

                }
            }
            if ($u_access !== false) {
                $this->success('代理商修改成功', U('aglist'), 1);
            } else {
                $this->error('代理商修改失败', U('aglist'), 0);
            }


        }

    }

    function aglist()
    {

        $nav = new \Org\Util\Leftnav;
        $menus = M('agent_list')->order('agent_list_id')->select();
        $arr = $nav::menu_j($menus);
        $this->assign('arr', $arr);
        $this->display();
    }

    function del()
    {
        $p = I('p');
        $rst = M('agent_list')->where(array('agent_list_id' => I('id')))->delete();
        if ($rst !== false) {
            $this->success('代理商删除成功', U('aglist', array('p' => $p)), 1);
        } else {
            $this->error('代理商删除失败', U('aglist', array('p' => $p)), 0);
        }

    }

    function userApply()
    {
        //账户申请
        $aglist_list = M('agent_sub')->order('agent_sub_id desc')->select();

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

    function select_state()
    {
        $id = I('x');
        if (empty($id)) {
            $this->error('訂單ID不存在', U('select'), 0);
        }
        $status = M('agent_sub')->where(array('agent_sub_id' => $id))->getField('agent_sub_status');//判断当前状态情况
        if ($status == 1) {
            $this->success('已处理', 1, 1);
        } else {

            $statedata = array('agent_sub_status' => 1);
            $result = M('agent_sub')->where(array('agent_sub_id' => $id))->setField($statedata);
            if ($result) {
                $this->success('处理完毕', 1, 1);
            } else {
                $this->success('处理失败', 1, 1);
            }



        }
    }


}