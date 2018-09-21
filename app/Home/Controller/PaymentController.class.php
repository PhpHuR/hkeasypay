<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Home\Controller;


class PaymentController extends HomebaseController
{
    /**
     * 支付通道列表
     */
    function payment_list()
    {
        $payment = M('payment_name');
        $val = I('val');
        $this->assign('testval', $val);
        $map = array();
        if ($val) {
            $map['api_china_name'] = array('like', "%" . $val . "%");
        }

        $count = $payment->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出

        $payment_list = $payment->where($map)->order('api_id')->limit($Page->firstRow . ',' . $Page->listRows)->select();


        $this->assign('payment_list', $payment_list);
        $this->assign('page', $show);

        $this->display();
    }

    /**
     * 添加支付通道
     */
    function payment_add()
    {

        if (empty($_POST)) {
            $this->display();
        } else {
            $payment = M('payment_name');
            $check_user = $payment->where(array('api_china_name' => I('api_china_name')))->find();
            if ($check_user) {
                $this->error('支付公司已存在，请重新输入', U('payment_list'), 0);
            }
            $sldata = array(
                'api_name' => I('api_name'),
                'api_china_name' => I('api_china_name'),
            );
            $result = $payment->add($sldata);

            if ($result) {
                $this->success('支付公司添加成功', U('payment_list'), 1);
            } else {
                $this->error('支付公司添加失败', U('payment_list'), 0);
            }


        }

    }

    /**
     * 编辑支付通道
     */
    function payment_edit()
    {

        $paymentdata['api_id'] = I('api_id');
        $payment_list = M('payment_name')->where($paymentdata)->find();
        $this->assign('payment_list', $payment_list);
        $this->display();

    }

    public function payment_runedit()
    {
        $payment_list = M('payment_name');
        $paymentdata['api_id'] = I('api_id');
        $paymentdata['api_name'] = I('api_name');
        $paymentdata['api_china_name'] = I('api_china_name');

        if ($payment_list->save($paymentdata)) {
            $this->success('支付公司修改成功', U('payment_list'), 1);
        } else {
            $this->error('支付公司修改失败', U('payment_list'), 0);
        }

    }

    /**
     * 删除支付通道
     */
    function payment_del()
    {
        $p = I('p');
        $rst = M('payment_name')->where(array('api_id' => I('api_id')))->delete();
        if ($rst !== false) {
            $this->success('支付公司删除成功', U('payment_list', array('p' => $p)), 1);
        } else {
            $this->error('支付公司删除失败', U('payment_list', array('p' => $p)), 0);
        }
    }


    function mid_list()
    {
        $payment_mid = M('payment_mid');
        $val = I('val');
        $this->assign('testval', $val);
        $map = array();
        if ($val) {
            $map['p_id'] = array('like', "%" . $val . "%");
        }

        $count = $payment_mid->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, C('DB_PAGENUM'));// 实例化分页类 传入总记录数和每页显示的记录数

        foreach ($map as $key => $val) {
            $Page->parameter[$key] = urlencode($val);
        }
        $show = $Page->show();// 分页显示输出

        $payment_mid_list = D('payment_mid')->where($map)->order('m_id')->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->select();

        $this->assign('payment_mid_list', $payment_mid_list);
        $this->assign('page', $show);

        $this->display();
    }

    /**
     * 添加银行路由
     */
    function mid_add()
    {
        if (IS_POST) {
            if (!IS_AJAX) {
                $this->error('提交方式不正确', U('Payment/mid_list'), 0);
            } else {

                if ($_FILES) {
                    //获取文件上传后路径
                    $upload = new \Think\Upload();// 实例化上传类
                    $upload->maxSize = 3145728;// 设置附件上传大小
                    $upload->exts = array('cer', 'pfx');// 设置附件上传类型
                    $upload->rootPath = C('UPLOAD_CERT'); // 设置附件上传根目录
                    $upload->savePath = I('p_id') . '/'; // 设置附件上传（子）目录  I('p_id').' /'.I('memberid')
                    $upload->autoSub = true;//自动使用子目录保存上传文件
                    $upload->saveName = '';//上传文件的保存规则
                    $upload->subName = I('memberid');
                    $upload->saveRule = '';
                    $info = $upload->upload();
                    if ($info) {

                        $public_cert = substr(C('UPLOAD_CERT'), 1) . $info['public_cert'][savepath] . $info['public_cert'][savename];

                        $private_cert = substr(C('UPLOAD_CERT'), 1) . $info['private_cert'][savepath] . $info['private_cert'][savename];

                    } else {
                        $this->error($upload->getError(), U('Payment/mid_list'), 0);//否则就是上传错误，显示错误原因
                    }
                }

                $mid_data['p_id'] = I('p_id');
                $mid_data['title'] = I('title');
                $mid_data['memberid'] = I('memberid');
                $mid_data['paypsd'] = I('paypsd');
                $mid_data['terminal'] = I('terminal');
                $mid_data['public_cert'] = $public_cert;
                $mid_data['private_cert'] = $private_cert;
                $mid_data['apishop'] = I('apishop');

                $rst = M('payment_mid')->where(array('p_id' => I('p_id'), 'memberid' => I('memberid')))->find();

                if ($rst) {
                    $this->error('MID重复，请重新添加', U('Payment/mid_list'), 0);
                } else {
                    M('payment_mid')->add($mid_data);
                    $this->success('MID添加成功', U('Payment/mid_list'), 1);
                }
            }

        } else {
            $payment_name = M('payment_name')->select();
            $this->assign('payment_name', $payment_name);
            $this->display();
        }


    }

    /**
     * 编辑银行路由
     */
    function mid_edit()
    {

        $payment_list = M('payment_name')->select();
        $payment_mid_edit = M('payment_mid')->where(array('m_id'=>I('m_id')))->find();
        $this->assign('payment_mid_edit',$payment_mid_edit);
        $this->assign('payment_name',$payment_list);
        $this->display();
    }

    function mid_runedit()
    {
        if ($_FILES) {
            //获取文件上传后路径
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('cer', 'pfx');// 设置附件上传类型
            $upload->rootPath = C('UPLOAD_CERT'); // 设置附件上传根目录
            $upload->savePath = I('p_id') . '/'; // 设置附件上传（子）目录  I('p_id').' /'.I('memberid')
            $upload->autoSub = true;//自动使用子目录保存上传文件
            $upload->saveName = '';//上传文件的保存规则
            $upload->subName = I('memberid');
            $upload->saveRule = '';
            $info = $upload->upload();
            if ($info) {
                $public_cert = substr(C('UPLOAD_CERT'), 1) . $info['public_cert'][savepath] . $info['public_cert'][savename];
                $private_cert = substr(C('UPLOAD_CERT'), 1) . $info['private_cert'][savepath] . $info['private_cert'][savename];
            } else {
                $this->error($upload->getError(), U('Payment/mid_list'), 0);//否则就是上传错误，显示错误原因
            }
        }
        $mid_data['m_id'] = I('m_id');
        $mid_data['p_id'] = I('p_id');
        $mid_data['title'] = I('title');
        $mid_data['memberid'] = I('memberid');
        $mid_data['paypsd'] = I('paypsd');
        $mid_data['terminal'] = I('terminal');
        $mid_data['public_cert'] = $public_cert;
        $mid_data['private_cert'] = $private_cert;
        $mid_data['apishop'] = I('apishop');

        $rst = M('payment_mid')->where(array('p_id' => I('p_id'), 'memberid' => I('memberid'),'m_id'=>array('neq',I('m_id'))))->find();

        if ($rst) {
            $this->error('MID重复，请重新添加', U('Payment/mid_list'), 0);
        } else {
            M('payment_mid')->save($mid_data);
            $this->success('MID修改成功', U('Payment/mid_list'), 1);
        }


    }

    /**
     * 删除银行路由
     */
    function mid_del()
    {
        $p = I('p');
        $rst = M('payment_mid')->where(array('m_id' => I('m_id')))->delete();
        if ($rst !== false) {
            $this->success('支付公司删除成功', U('mid_list', array('p' => $p)), 1);
        } else {
            $this->error('支付公司删除失败', U('mid_list', array('p' => $p)), 0);
        }
    }

}