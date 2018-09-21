<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Admin\Controller;


use Common\Controller\AuthController;

class CronController extends AuthController
{
    //機器人管理
    function index()
    {
        //默認條狀頁
        $this->display();
    }

    function telegram_user_list()
    {
        $telegram_user = M('telegram_user');
        $val = I('val');
        $this->assign('testval', $val);
        $map = array();
        if ($val) {
            $map['user_id'] = array('like', "%" . $val . "%");
        }

        $count = $telegram_user->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出

        $telegram_user_list = D('telegram_user')->where($map)->order('telegram_id')->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->select();


        $this->assign('telegram_user_list', $telegram_user_list);
        $this->assign('page', $show);

        $this->display();
    }

    function telegram_user_add()
    {
        if (IS_POST) {
            $telegram_user_data = array(
                'user_id' => I('user_id'),
                'telegram_user_id' => I('telegram_user_id'),
                'telegram_user_name' => I('telegram_user_name'),
                'telegram_type' => I('telegram_type'),
                'status' => I('status'),
                'created_at' => time(),
                'update_at' => time(),
                'remark' => I('remark'),
            );
            $telegram_user = M('telegram_user');
            if ($telegram_user->add($telegram_user_data)) {
                $this->success('添加成功', U('Cron/telegram_user_list'), 1);
            } else {
                $this->error('添加失败', U('Cron/telegram_user_list'), 0);
            }

        }else{
            //關聯用戶列表
            $user_list = M('userinfo')->select();
            $this->assign('user_list', $user_list);

            $this->display();
        }

    }
    function telegram_user_edit()
    {
        //獲取當前列表信息
        $telegram_user_edit = M('telegram_user')->where(array('telegram_id' => I('telegram_id')))->find();
        $this->assign('telegram_user_edit', $telegram_user_edit);
        //獲取用戶列表
        $user_list = M('userinfo')->select();
        $this->assign('user_list', $user_list);

        $this->display();
    }
    function runtelegram_user_edit()
    {
        $telegram_user_data = array(
            'telegram_id' => I('telegram_id'),
            'user_id' => I('user_id'),
            'telegram_user_id' => I('telegram_user_id'),
            'telegram_user_name' => I('telegram_user_name'),
            'telegram_type' => I('telegram_type'),
            'status' => I('status'),
            'created_at' => time(),
            'update_at' => time(),
            'remark' => I('remark'),
        );
        $telegram_user = M('telegram_user');
        if ($telegram_user->save($telegram_user_data)) {
            $this->success('編輯成功', U('Cron/telegram_user_list'), 1);
        } else {
            $this->error('編輯失败', U('Cron/telegram_user_list'), 0);
        }
    }
    function telegram_user_del()
    {
        $p = I('p');
        $rst = M('telegram_user')->where(array('telegram_id' => I('telegram_id')))->delete();
        if ($rst) {
            $this->success('删除汇率配置成功', U('Cron/telegram_user_list', array('p' => $p)), 1);
        } else {
            $this->error('删除汇率配置失败', U('Cron/telegram_user_list', array('p' => $p)), 0);
        }
    }
    function telegram_user_status()
    {
        $id=I('x');
        $status=M('telegram_user')->where(array('telegram_id'=>$id))->getField('status');//判断当前状态情况
        if($status==1){
            $statedata = array('status'=>0);
            $auth_group=M('telegram_user')->where(array('telegram_id'=>$id))->setField($statedata);
            $this->success('状态禁止',1,1);
        }else{
            $statedata = array('status'=>1);
            $auth_group=M('telegram_user')->where(array('telegram_id'=>$id))->setField($statedata);
            $this->success('状态开启',1,1);
        }
    }

    //任務管理板塊

}