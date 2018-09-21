<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;


use Common\Controller\AuthController;

class ProductController extends AuthController
{
    function index()
    {
        $this->display();
    }

    /**
     * 产品分类处理部分
     */
    function addcategory()
    {
        if (IS_POST) {
            $data=array(
                'category_title'=>I('category_title'),
                'parentid'=>I('parentid'),
                'status'=>I('status',0),
                'priority'=>I('priority'),
                'created_at'=>date('Y-m-d H:i:s'),

            );
            $rst=M('product_category')->add($data);
            if($rst!==false){
                $this->success('产品分类添加成功',U('category_list'),1);
            }else{
                $this->error('产品分类添加失败',U('category_list'),0);
            }

        } else {
            $parentid=I('category_id',0);
            $this->assign('parentid',$parentid);
            $this->display();
        }

    }

    function editcategory()
    {
        $this->display();
    }

    function runeditcategory()
    {
        $this->display();
    }

    function category_list()
    {
        $nav = new \Org\Util\Leftnav;
        $menus=M('product_category')->order('priority')->select();
        $arr = $nav::menu_k($menus);
        $this->assign('arr',$arr);
        $this->display();
    }

    function category_del()
    {

    }

    /**
     * 产品部分
     */

    function addproduct()
    {
        if (IS_POST AND IS_AJAX) {

            $data=array(
                'product_category_id'=>I('product_category_id'),
                'payin_rate_id'=>I('payin_rate_id'),
                'payment_mid'=>I('payment_mid'),
                'product_title'=>I('product_title'),
                'product_description'=>I('product_description'),
//                'product_attribute'=>I('product_attribute'),
                'product_attribute'=>empty(I('product_attribute'))? '0':I('product_attribute'),
                'status'=>I('status',0),
                'priority'=>I('priority'),
                'created_at'=>date('Y-m-d H:i:s'),
                'update_at'=>date('Y-m-d H:i:s'),
            );
            $rst=M('product')->add($data);
            if($rst!==false){
                $this->success('产品添加成功',U('product_list'),1);
            }else{
                $this->error('产品添加失败',U('product_list'),0);
            }

        }else{
            //读取产品属性
            $product_attribute = M('product_attribute')->select();
            $this->assign('product_attribute',$product_attribute);
            //读取产品分类
            $category_list = M('product_category')->order('category_id')->select();
            $this->assign('category_list',$category_list);
            //读取产品价格 -- 费率清单
            $payin_rate_list = M('payin_rate')->order('payin_rate_id')->select();
            $this->assign('payin_rate_list',$payin_rate_list);
            //读取支付工具--支付通道
            $payment_mid_list = M('payment_mid')->order('m_id')->select();
            $this->assign('payment_mid_list',$payment_mid_list);

            $this->display();
        }

    }

    function editproduct()
    {
        $product_id = I('product_id');
        //读取产品当前
        $product_list = M('product')->where(array('product_id' => $product_id))->find();
        $this->assign('product_list', $product_list);
        //读取产品所属分类
        $category_list = M('product_category')->select();
        $this->assign('category_list', $category_list);
        //读取产品价格
        $payin_rate_list = M('payin_rate')->select();
        $this->assign('payin_rate_list', $payin_rate_list);
        //读取产品属性
        $attribute_list = M('product_attribute')->select();
        $this->assign('attribute_list', $attribute_list);
        //读取产品通道
        $payment_mid_list = M('payment_mid')->select();
        $this->assign('payment_mid_list', $payment_mid_list);

        $this->display();
    }

    function runeditproduct()
    {
        $data=array(
            'product_id' => I('product_id'),
            'product_category_id'=>I('product_category_id'),
            'payin_rate_id'=>I('payin_rate_id'),
            'payment_mid'=>I('payment_mid'),
            'product_title'=>I('product_title'),
            'product_description'=>I('product_description'),
            'product_attribute'=>empty(I('product_attribute'))? '0':I('product_attribute'),
            'status'=>I('status',0),
            'priority'=>I('priority'),
            'created_at'=>date('Y-m-d H:i:s'),
            'update_at'=>date('Y-m-d H:i:s'),
        );
        $rst=M('product')->save($data);
        if($rst!==false){
            $this->success('产品编辑成功',U('product_list'),1);
        }else{
            $this->error('产品编辑失败',U('product_list'),0);
        }
    }

    function product_list()
    {
        $key = I('key');
        $map['product_id'] = array('like', "%" . $key . "%");
        $map['product_title'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'OR';
        /*
         * 分页操作
         */
        $count = M('product')->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $product_list = D('product')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->order('product_id desc')->select();
        $this->assign('product_list', $product_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();
    }

    function status()
    {
        $this->display();
    }
    function product_state()
    {
        $product = M('product')->where(array('product_id'=>I('product_id')))->find();
        if($product){
            $result = M('product')->where(array('product_id'=>I('product_id')))->save(array('status'=>I('status')));
            if($result!==false){
                $this->success('操作成功',U('product_list'),1);
            }else{
                $this->error('操作失败1',U('product_list'),0);
            }
        }else{
            $this->error(I('status'),U('product_list'),0);
        }

    }

    function product_del()
    {
        $rst=M('product')->where(array('product_id'=>I('product_id')))->delete();
        if($rst!==false){
            $p=I('p',1,'intval');
            $this->success('产品删除成功',U('product_list',array('p'=>$p)),1);
        }else{
            $this->error('产品删除失败',U('product_list'),0);
        }
    }

}