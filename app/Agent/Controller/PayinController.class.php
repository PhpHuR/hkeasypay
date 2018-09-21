<?php


namespace Agent\Controller;

use Agent\Controller\AgentbaseController;
class PayinController extends AgentbaseController
{
    function index()
    {
        $this->display();
    }

    function select()
    {
        //读取总额以及每个子集下面的额度
        $orderid = I('orderid', '');

        $status = I('status', '');
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
            $arrdatetwo = strtotime($arr[1] . ' 23:55:55');
            $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }
        if ($status!=''){
            $map['status']= array('eq',$status);
        }
        $map['orderid|transid|ordermoney'] = array('like', "%" . $orderid . "%");
        //需要一个根据代理ID获取手续费的机制

        if ($this->userIdArray) {
            $map['uid'] = array('in',$this->userIdArray);
        }else{
            $map['uid'] = '0';
        }
        $map['_logic'] = 'AND';
        $count = M('payin')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('page', $show);
        $select_list = M('payin')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();

        foreach ($select_list as $key => $value) {
            $agentPayinList = M('agentpayin')->where(array('agent_pid' => session('hid')))->select();
            foreach ($agentPayinList as $va) {
                if ($value['orderid'] == $va['payin_order_id']) {
                    $select_list[$key]['agentfree'] = $va['agentfree'];
                }
            }

        }
        $select_list_e = M('payin')->where($map)->order('begin_time desc')->select();
        $num = "";
        $a_OrderMoney = "";
        $a_free = "";
        foreach ($select_list_e as $k => $r) {
            if ($r['status'] == '1') {
                $num = $num + 1;
                $a_OrderMoney = $a_OrderMoney + $r['ordermoney'];
                $agentPayinList = M('agentpayin')->where(array('agent_pid' => session('hid')))->select();
                foreach ($agentPayinList as $vb) {
                    if ($r['orderid'] == $vb['payin_order_id']) {
                        $select_list_e[$k]['agentfree'] = $vb['agentfree'];
                        $a_free = $a_free + $vb['agentfree'];
                    }
                }

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
        $this->assign('begin_time', $begin_time);
        $this->assign('end_time', $end_time);
        $this->assign('orderidd', $orderid);
        $this->assign('select_list', $select_list);
        $this->display();

    }


    //导出数据方法
    protected function goods_export($goods_list=array(),$filename)
    {
        //print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k=>$goods_info){
            $data[$k][begin_time] = $goods_info['begin_time'];
            $data[$k][orderid] = $goods_info['orderid'];
            $data[$k][transid] = $goods_info['transid'];
            $data[$k][RMB]  = 'RMB';
            $data[$k][ordermoney]  = $goods_info['ordermoney'];
            $data[$k][free]  = $goods_info['free'];
            $data[$k][status]  = $goods_info['status'];
            $data[$k][paybank] = $goods_info['paybank'];
            $data[$k][remark] = $goods_info['remark'];
            $data[$k][API] = 'api';
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field=>$v){
            if($field == 'begin_time'){
                $headArr[]='创建时间';
            }

            if($field == 'orderid'){
                $headArr[]='訂單號碼';
            }

            if($field == 'transid'){
                $headArr[]='客戶訂單號碼';
            }

            if($field == 'RMB'){
                $headArr[]='貨幣';
            }

            if($field == 'ordermoney'){
                $headArr[]='入金金額';
            }

            if($field == 'free'){
                $headArr[]='入金手續費';
            }

            if($field == 'status'){
                $headArr[]='訂單狀態';
            }
            if($field == 'paybank'){
                $headArr[]='入金銀行';
            }

            if($field == 'remark'){
                $headArr[]='備註';
            }
            if($field == 'API'){
                $headArr[]='提交交式';
            }

        }

        $filename=$filename;

        getExcel($filename,$headArr,$data);
    }


}