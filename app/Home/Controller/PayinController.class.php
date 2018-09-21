<?php
/**
 * Created by PhpStorm.
 * User: zhouding
 * Date: 2016/9/12
 * Time: 16:26
 */

namespace Home\Controller;

use Home\Controller\HomebaseController;

class PayinController extends HomebaseController
{
    function payin_list()
    {
        //订单管理功能 计算金额和补单
        $this->display();
    }
    function select()
    {
        if (IS_POST and IS_AJAX) {
            $payin_id = I('id');
            $payin_list = M('payin')->where(array('payin_id' =>$payin_id))->find();
            $sl_data['payin_id'] = $payin_id;
            $sl_data['orderid'] = $payin_list['orderid'];
            $sl_data['transid'] = $payin_list['transid'];
            $sl_data['remark'] = $payin_list['remark'];
            $sl_data['paybank'] = getBankName($payin_list['paybank']);
            $sl_data['ordermoney'] = $payin_list['ordermoney'];
            $sl_data['begin_time'] = date('Y-m-d H:i:s',$payin_list['begin_time']);
            $sl_data['end_time'] = date('Y-m-d H:i:s',$payin_list['end_time']);
            $sl_data['free'] = $payin_list['free'];
            $sl_data['status'] = getPayinStatus($payin_list['status']);
            $this->ajaxReturn($sl_data, 'json');
        } else {
            $key = I('key');
            $status = I('status', '');

            $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18

//            $begin_time = I('begin_time', '');
//            $end_time = I('end_time', '');
//            if (empty($begin_time) and empty($end_time)) {
//                $begin_time = date('Y-m-d');
//                $end_time = date('Y-m-d');
//            }
//            $sldate = $begin_time . ' - ' . $end_time;

            if (empty($sldate)) {
                $sldate = date('Y-m-d') . ' - ' . date('Y-m-d'); //初始化时间段
            }
            if (strpos($sldate, '+')) {
                $sldate = preg_replace('/\+/', ' ', $sldate);
            }
            $arr = explode(" - ", $sldate);//转换成数组
            if (count($arr) == 2) {
                $arrdateone = strtotime($arr[0]);
                $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
                $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
            }
            if ($status!=''){
                $map['status']= array('eq',$status);
            }
            $map['orderid|transid|ordermoney|free'] = array('like', "%" . $key . "%");;
            $map['uid'] = $this->user['member_list_userinfoid'];
            $map['_logic'] = 'AND';
            $count = M('payin')->where($map)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $this->assign('page', $show);
            $select_list = M('payin')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();
            $select_list_e = M('payin')->where($map)->order('begin_time desc')->select();
            $num = "";
            $a_OrderMoney = "";
            $a_free = "";
            foreach ($select_list_e as $k => $r) {
                if ($r['status'] == '1') {
                    $num = $num + 1;
                    $a_OrderMoney = $a_OrderMoney + $r['ordermoney'];
                    $a_free = $a_free + $r['free'];
                }
            }
            //导出结果
            $action = I('action');
            if ($action == 'export') {
                if (!$select_list_e) {
                    $this->error('没有搜索结果，无法导出数据');
                }
                $this->goods_export($select_list_e, 'payin_list');
            }
            $this->assign('num', $num);
            $this->assign('a_OrderMoney', $a_OrderMoney);
            $this->assign('a_free', $a_free);

            $this->assign('status',$status);
            $this->assign('sldate', $sldate);
            $this->assign('sldate', $sldate);
            $this->assign('keyy', $key);
            $this->assign('select_list', $select_list);
            if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                $this->display("select-hkd");
                die;
            }
            $this->display();
        }

    }

    function orderInfo()
    {
        $id = I('id');
        $transid = I('transid');
        $info = M('payininfo')->where(array('payin_id' => $id))->find();
        if ($info) {
            $payin_info = M('payin')->where(array('payin_id' => $id))->field('transid,orderid,ordermoney,free,status,remark,ordermoney_hkd')->find();
            $this->assign('order_info', $info);
            $this->assign('transid', $transid);
            $this->assign('payin_info', $payin_info);
            if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                $this->display("orderinfo-hkd");
            }else{
                $this->display();
            }
        }else{
            $this->display();
        }

    }

    //订单补充通知
    function select_state(){
        $id=I('x');
        if (empty($id)){
            $this->error('訂單ID不存在',U('select'),0);
        }
        $status=M('payin')->where(array('payin_id'=>$id))->getField('notice_status');//判断当前状态情况
        if($status==1){
            $this->success('已通知',1,1);
        }else{
            if (payinOrderNoticeState($id)) {
                $statedata = array('notice_status'=>1);
                M('payin')->where(array('payin_id'=>$id))->setField($statedata);
                $this->success('通知完毕',1,1);
            } else {
                $this->error('通知失敗，請聯繫管理員！',1,1);
            }

        }

    }



    //导出数据方法
    protected function goods_export($goods_list = array(), $filename)
    {
        //print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][begin_time] = date('Y-m-d H:i:s',$goods_info['begin_time']);
            $data[$k][end_time] = is_null($goods_info['end_time'])?'':date('Y-m-d H:i:s',$goods_info['end_time']);
            $data[$k][orderid] = $goods_info['orderid'];
            $data[$k][transid] = $goods_info['transid'];
            $data[$k][CNY] = 'CNY';
            $data[$k][ordermoney] = number_format($goods_info['ordermoney'],2,'.',',');
            $data[$k][free] = number_format($goods_info['free'],2,'.',',');
            $data[$k][status] = getPayinStatus($goods_info['status']);
            $data[$k][paybank] = getBankName($goods_info['paybank']);
            $data[$k][remark] = $goods_info['remark'];
            $data[$k][API] = $goods_info['payin_method'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'begin_time') {
                $headArr[] = '創建時間';
            }
            if ($field == 'end_time') {
                $headArr[] = '結束時間';
            }
            if ($field == 'orderid') {
                $headArr[] = '系統訂單號碼';
            }

            if ($field == 'transid') {
                $headArr[] = '客戶訂單號碼';
            }

            if ($field == 'CNY') {
                $headArr[] = '貨幣';
            }

            if ($field == 'ordermoney') {
                $headArr[] = '入金金額';
            }

            if ($field == 'free') {
                $headArr[] = '入金手續費';
            }

            if ($field == 'status') {
                $headArr[] = '訂單狀態';
            }
            if ($field == 'paybank') {
                $headArr[] = '入金銀行';
            }

            if ($field == 'remark') {
                $headArr[] = '備註';
            }
            if ($field == 'API') {
                $headArr[] = '提交方式';
            }

        }

        $filename = $filename;

        getExcel($filename, $headArr, $data);
    }


}