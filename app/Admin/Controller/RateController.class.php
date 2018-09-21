<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Common\Controller\AuthController;

class RateController extends AuthController
{
    public function payin_rate_list()
    {
        $payin_rate = M('payin_rate');
        $val = I('val');
        $this->assign('testval', $val);
        $map = array();
        if ($val) {
            $map['p_id'] = array('like', "%" . $val . "%");
        }
        $count = $payin_rate->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数
        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出
        $payin_rate_list = D('payin_rate')->where($map)->order('payin_rate_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->select();
        $this->assign('payin_rate_list', $payin_rate_list);
        $this->assign('page', $show);

        $this->display();
    }

    public function payin_rate_add()
    {
        if (IS_POST) {
            $payin_data = array(
                'p_id' => I('p_id'),
                'payin_rate_title' => I('payin_rate_title'),
                'inrate' => I('inrate') / 100,
                'inprice' => I('inprice') / 100,
                'ag_rate' => I('ag_rate') / 100,
                'time' => time()

            );
            $payin_rate = M('payin_rate');
            if ($payin_rate->add($payin_data)) {
                $this->success('入金费率添加成功', U('Rate/payin_rate_list'), 1);
            } else {
                $this->error('入金费率添加失败', U('Rate/payin_rate_list'), 0);
            }

        } else {
            $payment_name = M('payment_name')->select();

            $this->assign('payment_name', $payment_name);

            $this->display();
        }


    }

    public function payin_rate_edit()
    {
        $payment_name = M('payment_name')->select();
        $payin_rate_edit = M('payin_rate')->where(array('payin_rate_id' => I('payin_rate_id')))->find();
        $this->assign('payin_rate_edit', $payin_rate_edit);
        $this->assign('payment_name', $payment_name);
        $this->display();

    }

    public function payin_rate_runedit()
    {
        $payin_rate_data = array(
            'payin_rate_id' => I('payin_rate_id'),
            'p_id' => I('p_id'),
            'payin_rate_title' => I('payin_rate_title'),
            'inrate' => I('inrate') / 100,
            'inprice' => I('inprice') / 100,
            'ag_rate' => I('ag_rate') / 100,
            'time' => time(),

        );
        $payin_rate_edit = M('payin_rate');
        if ($payin_rate_edit->save($payin_rate_data)) {
            $this->success('入金费率编辑成功', U('Rate/payin_rate_list'), 1);
        } else {
            $this->error('入金费率编辑失败', U('Rate/payin_rate_list'), 0);
        }

    }

    public function payin_rate_del()
    {
        $p = I('p');
        $rst = M('payin_rate')->where(array('payin_rate_id' => I('payin_rate_id')))->delete();
        if ($rst) {
            $this->success('删除费率配置成功', U('Rate/payin_rate_list', array('p' => $p)), 1);
        } else {
            $this->error('删除费率配置失败', U('Rate/payin_rate_list', array('p' => $p)), 0);
        }

    }

    /**
     * 出金费率设置
     */

    public function payout_rate_list()
    {
        $payout_rate = M('payout_rate');
        $val = I('val');
        $this->assign('testval', $val);
        $map = array();
        if ($val) {
            $map['p_id'] = array('like', "%" . $val . "%");
        }

        $count = $payout_rate->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出

        $payout_rate_list = D('payout_rate')->where($map)->order('payout_rate_id')->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->select();


        $this->assign('payout_rate_list', $payout_rate_list);
        $this->assign('page', $show);

        $this->display();

    }

    public function payout_rate_add()
    {
        if (IS_POST) {
            $payout_data = array(
                'p_id' => I('p_id'),
                'payout_rate_title' => I('payout_rate_title'),
                'outrate' => I('outrate'),
                'outprice' => I('outprice'),
                'outmin' => I('outmin'),
                'outmax' => I('outmax'),
                'time' => time(),
            );
            $payout_rate = M('payout_rate');
            if ($payout_rate->add($payout_data)) {
                $this->success('出金费率添加成功', U('Rate/payout_rate_list'), 1);
            } else {
                $this->error('出金费率添加失败', U('Rate/payout_rate_list'), 0);
            }

        } else {
            $payment_name = M('payment_name')->select();
            $this->assign('payment_name', $payment_name);
            $this->display();
        }

    }

    public function payout_rate_edit()
    {
        $payment_name = M('payment_name')->select();
        $payout_rate_edit = M('payout_rate')->where(array('payout_rate_id' => I('payout_rate_id')))->find();
        $this->assign('payout_rate_edit', $payout_rate_edit);
        $this->assign('payment_name', $payment_name);
        $this->display();

    }

    public function payout_rate_runedit()
    {
        $payout_rate_data = array(
            'payout_rate_id' => I('payout_rate_id'),
            'payout_rate_title' => I('payout_rate_title'),
            'p_id' => I('p_id'),
            'outrate' => I('outrate'),
            'outprice' => I('outprice'),
            'outmin' => I('outmin'),
            'outmax' => I('outmax'),
            'time' => time(),

        );
        $payout_rate_edit = M('payout_rate');
        if ($payout_rate_edit->save($payout_rate_data)) {
            $this->success('入金费率编辑成功', U('Rate/payout_rate_list'), 1);
        } else {
            $this->error('入金费率编辑失败', U('Rate/payout_rate_list'), 0);
        }

    }

    public function payout_rate_del()
    {
        $p = I('p');
        $rst = M('payout_rate')->where(array('payout_rate_id' => I('payout_rate_id')))->delete();
        if ($rst) {
            $this->success('删除费率配置成功', U('Rate/payout_rate_list', array('p' => $p)), 1);
        } else {
            $this->error('删除费率配置失败', U('Rate/payout_rate_list', array('p' => $p)), 0);
        }

    }

    /**
     * 汇率设置
     */

    public function overseas_rate_list()
    {
        $overseas_rate = M('curoffer');
        $val = I('val');
        $this->assign('testval', $val);
        $map = array();
        if ($val) {
            $map['currency_code'] = array('like', "%" . $val . "%");
        }

        $count = $overseas_rate->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出

        $overseas_rate_list = $overseas_rate->where($map)->order('curoffer_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();


        $this->assign('overseas_rate_list', $overseas_rate_list);
        $this->assign('page', $show);

        $this->display();

    }

    public function overseas_rate_add()
    {
        if (IS_POST) {
            $overseas_data = array(
                'currency_code' => I('currency_code'),
                'user_id' => I('user_id'),
                'cursell' => I('cursell'),
                'curbuy' => I('curbuy'),
                'status' => I('status'),
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => time(),
                'remark' => I('remark'),
            );
            $overseas_rate = M('curoffer');
            if ($overseas_rate->add($overseas_data)) {
                $this->success('汇率添加成功', U('Rate/overseas_rate_list'), 1);
            } else {
                $this->error('汇率添加失败', U('Rate/overseas_rate_list'), 0);
            }

        } else {
            $userList = M('userinfo')->select();
            $this->assign('userList', $userList);
            $this->display();
        }

    }

    public function overseas_rate_edit()
    {
        $overseas_rate_edit = M('curoffer')->where(array('curoffer_id' => I('curoffer_id')))->find();
        $this->assign('overseas_rate_edit',$overseas_rate_edit);
        $userList = M('userinfo')->select();
        $this->assign('userList', $userList);
        $this->display();
    }

    public function runoverseas_rate_edit()
    {

        $overseas_data = array(
            'curoffer_id' => I('curoffer_id'),
            'user_id' => I('user_id'),
            'currency_code' => I('currency_code'),
            'cursell' => I('cursell'),
            'curbuy' => I('curbuy'),
            'status' => I('status'),
            'update_at' => time(),
            'remark' => I('remark'),
        );
        $overseas_rate = M('curoffer');
        if ($overseas_rate->save($overseas_data)) {
            $this->success('汇率编辑成功', U('Rate/overseas_rate_list'), 1);
        } else {
            $this->error('汇率编辑失败', U('Rate/overseas_rate_list'), 0);
        }

    }

    public function overseas_rate_del()
    {
        $p = I('p');
        $rst = M('curoffer')->where(array('curoffer_id' => I('curoffer_id')))->delete();
        if ($rst) {
            $this->success('删除汇率配置成功', U('Rate/overseas_rate_list', array('p' => $p)), 1);
        } else {
            $this->error('删除汇率配置失败', U('Rate/overseas_rate_list', array('p' => $p)), 0);
        }

    }

    public function overseas_rate_status()
    {
        $id=I('x');
        $status=M('curoffer')->where(array('curoffer_id'=>$id))->getField('status');//判断当前状态情况
        if($status==1){
            $statedata = array('status'=>0);
            $auth_group=M('curoffer')->where(array('curoffer_id'=>$id))->setField($statedata);
            $this->success('状态禁止',1,1);
        }else{
            $statedata = array('status'=>1);
            $auth_group=M('curoffer')->where(array('curoffer_id'=>$id))->setField($statedata);
            $this->success('状态开启',1,1);
        }

    }
}