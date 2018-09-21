<?php
/**
 * User: zhouding
 * Date: 2016/9/12
 * Time: 11:14
 */

namespace Admin\Controller;


use Common\Controller\AuthController;

class PayinController extends AuthController
{

    public function select()
    {
        $key = trim(I('key'));
        $mid = I('mid');
        $paybank = I('paybank');
        $payment_id = I('payment_id');
        $payment_mid = I('payment_mid');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18

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
            $map['end_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }
        if ($paybank == 'alipay' || $paybank == 'weixin') {
            $map['paybank'] = $paybank;
        }
        if ($paybank == 'netgate') {
            $map['paybank'] = array(array('neq','alipay'),array('neq','weixin'),'and');
        }
        $map['status'] = '1';
        if ($mid) {
            $map['uid'] = $mid;
        }
        if ($payment_id) {
            $map['payment_id'] = $payment_id;
        }
        if ($payment_mid) {
            $map['payment_mid'] = $payment_mid;
        }
        $map['orderid|transid|ordermoney|free|payin_method'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'AND';

        $count = M('payin')->where($map)->count();// 查询满足要求的总记录数

        $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('page', $show);
        $select_list = D('payin')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payin_id desc')->relation(true)->select();
        $select_list_e = D('payin')->where($map)->order('payin_id desc')->relation(true)->select();
        $num = "";
        $a_OrderMoney = "";
        $a_free = "";
        $c_free = "";
        $ag_free = "";
        foreach ($select_list_e as $k => $r) {
            if ($r['status'] == '1') {
                $num = $num + 1;
                $a_OrderMoney = $a_OrderMoney + $r['ordermoney'];
                $a_free = $a_free + $r['free'];
                $c_free = $c_free + $r['payin_commission_c'];
                $ag_free = $ag_free + $r['payin_commission_ag'];
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
        $this->assign('c_free', $c_free);
        $this->assign('ag_free', $ag_free);
        $this->assign('sldate', $sldate);
        $this->assign('keyy', $key);
        $this->assign('paybankk', $paybank);
        //商户名称
        $mid_list = M('userinfo')->order('user_id desc')->select();
        $this->assign('mid_list', $mid_list);
        $this->assign('midd', $mid);
        //支付通道
        $payment_list = M('payment_name')->order('api_id desc')->select();
        $this->assign('payment_list', $payment_list);
        $this->assign('payment_idd', $payment_id);
        //支付MID
        $payment_mid_list = M('payment_mid')->order('m_id desc')->select();
        $this->assign('payment_mid_list', $payment_mid_list);
        $this->assign('payment_midd', $payment_mid);

        $this->assign('payment_idd', $payment_id);
        $this->assign('select_list', $select_list);
        $this->display();

    }

    public function payin_list()
    {
        $key = trim(I('key'));
        $mid = I('mid');
        $paybank = I('paybank');
        $payment_id = I('payment_id');
        $payment_mid = I('payment_mid');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18

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

        if ($paybank == 'alipay' || $paybank == 'weixin') {
            $map['paybank'] = $paybank;
        }
        if ($paybank == 'netgate') {
            $map['paybank'] = array(array('neq','alipay'),array('neq','weixin'),'and');
        }

        if ($mid) {
            $map['uid'] = $mid;
        }
        if ($payment_id) {
            $map['payment_id'] = $payment_id;
        }
        if ($payment_mid) {
            $map['payment_mid'] = $payment_mid;
        }
        $map['orderid|transid|ordermoney|free|payin_method'] = array('like', "%" . $key . "%");;
        $map['_logic'] = 'AND';
        $count = M('payin')->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('page', $show);
        $select_list = D('payin')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payin_id desc')->relation(true)->select();
        $select_list_e = D('payin')->where($map)->order('payin_id desc')->relation(true)->select();
        $num = "";
        $a_OrderMoney = "";
        $a_free = "";
        $c_free = "";
        $ag_free = "";
        foreach ($select_list_e as $k => $r) {
            if ($r['status'] == '1') {
                $num = $num + 1;
                $a_OrderMoney = $a_OrderMoney + $r['ordermoney'];
                $a_free = $a_free + $r['free'];
                $c_free = $c_free + $r['payin_commission_c'];
                $ag_free = $ag_free + $r['payin_commission_ag'];
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
        $this->assign('c_free', $c_free);
        $this->assign('ag_free', $ag_free);
        $this->assign('sldate', $sldate);
        $this->assign('keyy', $key);
        $this->assign('paybankk', $paybank);
        //商户名称
        $mid_list = M('userinfo')->order('user_id desc')->select();
        $this->assign('mid_list', $mid_list);
        $this->assign('midd', $mid);
        //支付通道
        $payment_list = M('payment_name')->order('api_id desc')->select();
        $this->assign('payment_list', $payment_list);
        $this->assign('payment_idd', $payment_id);
        //支付MID
        $payment_mid_list = M('payment_mid')->order('m_id desc')->select();
        $this->assign('payment_mid_list', $payment_mid_list);
        $this->assign('payment_midd', $payment_mid);

        $this->assign('select_list', $select_list);
        $this->display();

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

    //订单补单--修正订单状态

    function orderRepairRight()
    {
        $id=I('x');
        if (empty($id)){
            $this->error('訂單ID不存在',U('select'),0);
        }
        //成功訂單處理方法
        $status=M('payin')->where(array('payin_id'=>$id))->getField('status');//判断当前状态情况
        if($status==1){
            $this->success('已補單',1,1);
        }else{
            if (payinOrderRepairSuccess($id)) {
                $statedata = array('status'=>1);
                M('payin')->where(array('payin_id'=>$id))->setField($statedata);
                $this->success('已補單成功',1,1);
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
            $data[$k][end_time] = date('Y-m-d H:i:s',$goods_info['end_time']);
            $data[$k][orderid] = $goods_info['orderid'];
            $data[$k][transid] = $goods_info['transid'];
            $data[$k][uid] = $goods_info['uid'];
            $data[$k]['member_name'] = getUserinfoName($goods_info['uid']);
            $data[$k]['api_china_name'] = $goods_info['api_china_name'];
            $data[$k]['title'] = $goods_info['title'];
            $data[$k][RMB] = 'RMB';
            $data[$k][ordermoney] = number_format($goods_info['ordermoney'],2,'.',',');
            $data[$k][free] = number_format($goods_info['free'],2,'.',',');
            $data[$k][status] = getPayinStatus($goods_info['status']);
            $data[$k][paybank] = getBankName($goods_info['paybank']);
            $data[$k][remark] = $goods_info['remark'];
            $data[$k][API] = 'api';
        }

//        print_r($goods_list);
//        print_r($member_name);exit;
        foreach ($data as $field => $v) {
            if ($field == 'begin_time') {
                $headArr[] = '创建时间';
            }

            if ($field == 'end_time') {
                $headArr[] = '结束时间';
            }

            if ($field == 'orderid') {
                $headArr[] = '訂單號碼';
            }

            if ($field == 'transid') {
                $headArr[] = '客戶訂單號碼';
            }

            if ($field == 'uid') {
                $headArr[] = '商戶ID';
            }

            if ($field == 'member_name') {
                $headArr[] = '商戶名稱';
            }

            if ($field == 'api_china_name') {
                $headArr[] = '支付公司';
            }

            if ($field == 'title') {
                $headArr[] = '入金MID名稱';
            }

            if ($field == 'RMB') {
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
                $headArr[] = '提交交式';
            }

        }

        $filename = $filename;

        getExcel($filename, $headArr, $data);
    }

}