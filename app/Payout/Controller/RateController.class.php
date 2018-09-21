<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Payout\Controller;


class RateController extends PayoutbaseController
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
        $Page = new \Think\Page($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出

        $payin_rate_list = D('payin_rate')->where($map)->order('id')->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->select();


        $this->assign('payin_rate_list', $payin_rate_list);
        $this->assign('page', $show);

        $this->display();
    }

    public function payin_rate_add()
    {
        if (IS_POST) {
            $payin_data = array(
                'p_id' => I('p_id'),
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
        $payin_rate_edit = M('payin_rate')->where(array('id' => I('id')))->find();
        $this->assign('payin_rate_edit', $payin_rate_edit);
        $this->assign('payment_name', $payment_name);
        $this->display();

    }

    public function payin_rate_runedit()
    {
        $payin_rate_data = array(
            'id' => I('id'),
            'p_id' => I('p_id'),
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
        $rst = M('payin_rate')->where(array('id' => I('id')))->delete();
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
        $Page = new \Think\Page($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出true

        $payout_rate_list = D('payout_rate')->where($map)->order('id')->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->select();


        $this->assign('payout_rate_list', $payout_rate_list);
        $this->assign('page', $show);

        $this->display();

    }

    public function payout_rate_add()
    {
        if (IS_POST) {
            $payout_data = array(
                'p_id' => I('p_id'),
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
        $payout_rate_edit = M('payout_rate')->where(array('id' => I('id')))->find();
        $this->assign('payout_rate_edit', $payout_rate_edit);
        $this->assign('payment_name', $payment_name);
        $this->display();

    }

    public function payout_rate_runedit()
    {
        $payout_rate_data = array(
            'id' => I('id'),
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
        $rst = M('payout_rate')->where(array('id' => I('id')))->delete();
        if ($rst) {
            $this->success('删除费率配置成功', U('Rate/payout_rate_list', array('p' => $p)), 1);
        } else {
            $this->error('删除费率配置失败', U('Rate/payout_rate_list', array('p' => $p)), 0);
        }

    }

}