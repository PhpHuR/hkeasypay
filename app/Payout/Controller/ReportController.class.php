<?php
/**
 * User: zhouding
 * Date: 2016/9/12
 * Time: 22:03
 */

namespace Payout\Controller;

use Payout\Controller\PayoutbaseController;
class ReportController extends PayoutbaseController
{
    public $begin; //开始时间
    public $end;   //结束时间
    public $uid;
    public function _initialize(){
        parent::_initialize();
        $userinfo = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();
        $this->uid = $userinfo['id'];
        $timegap = I('reservation','');  //传递过来的时间
        if($timegap){
            $gap = explode(' - ', $timegap);
            $begin = $gap[0];
            $end = $gap[1];
        }else{
//            $lastweek = date('Y-m-d',strtotime("-1 month"));//30天前
            $lastweek = date('Y-m-d',strtotime("-1 week"));//7天前
            $begin = I('begin',$lastweek);
            $end =  I('end',date('Y-m-d'));
        }
        $this->begin = strtotime($begin);
        $this->end = strtotime($end)+86399;
        $this->assign('timegap',date('Y-m-d',$this->begin).' - '.date('Y-m-d',$this->end));
    }

    public function profit_loss()
    {
        $this->display();
        
    }
    public function index()
    {
        $now = strtotime(date('Y-m-d'));
        $today['today_amount'] = M('payin')->where("begin_time>$now AND status=1 ")->sum('ordermoney');//今日销售总额
        $today['today_order'] = M('payin')->where("begin_time>$now AND status=1 ")->sum('free');//今日订单数
        $today['cancel_order'] = M('payin')->where("begin_time>$now AND status=0")->count();//今日取消订单
        $this->assign('today', $today);
        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y-%m-%d') as gap from  __PREFIX__payin ";
        $sql .= " where begin_time>$this->begin and begin_time<$this->end AND status=1 group by gap";
        $res = M()->query($sql);//订单数,交易额

        $inum = "";
        $ifree = "";
        $iordermoney = "";
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['inum'];
            $brr[$val['gap']] = $val['iordermoney'];
            $crr[$val['gap']] = $val['ifree'];
            $inum += $val['inum'];  //数量
            $ifree += $val['ifree'];  //数量
            $iordermoney += $val['iordermoney']; // 金额
        }

        //出金统计
        $osql = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree, FROM_UNIXTIME(begin_time,'%Y-%m-%d') as gap from  __PREFIX__payout ";
        $osql .= " where begin_time>$this->begin and begin_time<$this->end AND status=1 group by gap";
        $ores = M()->query($osql);//订单数,交易额
        $ounm = "";
        $ofree = "";
        $otransfermoney = "";
        foreach ($ores as $oval) {
            $drr[$val['gap']] = $val['onum'];
            $err[$val['gap']] = $val['otransfermoney'];
            $frr[$val['gap']] = $val['ofree'];
            $ounm += $val['onum'];  //数量
            $ofree += $val['otransfermoney'];  //数量
            $otransfermoney += $val['ofree']; // 金额

        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_inum = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_iordermoney = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_ifree = empty($crr[date('Y-m-d', $i)]) ? 0 : $crr[date('Y-m-d', $i)];

            $tmp_ounm = empty($drr[date('Y-m-d', $i)]) ? 0 : $drr[date('Y-m-d', $i)];
            $tmp_otransfermoney = empty($err[date('Y-m-d', $i)]) ? 0 : $err[date('Y-m-d', $i)];
            $tmp_ofree = empty($frr[date('Y-m-d', $i)]) ? 0 : $frr[date('Y-m-d', $i)];
            $inum_arr[] = $tmp_inum;
            $iordermoney_arr[] = $tmp_iordermoney;
            $ifree_arr[] = $tmp_ifree;
            $ounm_arr[] = $tmp_ounm;
            $otransfermoney_arr[] = $tmp_otransfermoney;
            $ofree_arr[] = $tmp_ofree;
            $date = date('Y-m-d', $i);
            $list[] = array(
                'day' => $date,
                'inum' => $tmp_inum,
                'iordermoney' => $tmp_iordermoney,
                'ifree' => $tmp_ifree,
                'ounm' => $tmp_ounm,
                'otransfermoney' => $tmp_otransfermoney,
                'ofree' => $tmp_ofree,
                'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }

        $this->assign('list', $list);
//        dump($list);
//        die();
//        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
//        $this->assign('result', json_encode($result));
        $this->display();
    }

    public function daily()
    {

        $now = strtotime(date('Y-m-d'));
        $today['today_amount'] = M('payin')->where("begin_time>$now AND status=1 ")->sum('ordermoney');//今日销售总额
        $today['today_order'] = M('payin')->where("begin_time>$now AND status=1 ")->sum('free');//今日订单数
        $today['cancel_order'] = M('payin')->where("begin_time>$now AND status=0")->count();//今日取消订单
        $this->assign('today', $today);
        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y-%m-%d') as gap from  __PREFIX__payin ";
        $sql .= " where uid = $this->uid and begin_time>$this->begin and begin_time<$this->end AND status=1 group by gap";
        $res = M()->query($sql);//订单数,交易额
        $map['begin_time'] = array(array('gt',$this->begin),array('lt',$this->end),'and');
        $map['uid'] = $this->uid;
        $res_a = M('payin')->where($map)->field("sum(`ordermoney`) as `aiordermoney`,sum(`free`) as `aifree`")->find();

        $inum = "";
        $ifree = "";
        $iordermoney = "";
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['inum'];
            $brr[$val['gap']] = $val['iordermoney'];
            $crr[$val['gap']] = $val['ifree'];
            $inum += $val['inum'];  //数量
            $ifree += $val['ifree'];  //数量
            $iordermoney += $val['iordermoney']; // 金额
        }

        //出金统计
        $osql = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree, FROM_UNIXTIME(begin_time,'%Y-%m-%d') as gap from  __PREFIX__payout ";
        $osql .= " where uid = $this->uid and begin_time>$this->begin and begin_time<$this->end AND status=4 group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt',$this->begin),array('lt',$this->end),'and');
        $map1['status'] = 4;
        $map1['uid'] = $this->uid;

        $res_o_a = M('payout')->where($map1)->field("sum(`transfermoney`) as `aotransfermoney`,sum(`free`) as `aofree`")->find();

        $ounm = "";
        $ofree = "";
        $otransfermoney = "";
        foreach ($ores as $oval) {
            $drr[$val['gap']] = $val['onum'];
            $err[$val['gap']] = $val['otransfermoney'];
            $frr[$val['gap']] = $val['ofree'];
            $ounm += $val['onum'];  //数量
            $ofree += $val['otransfermoney'];  //数量
            $otransfermoney += $val['ofree']; // 金额

        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_inum = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_iordermoney = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_ifree = empty($crr[date('Y-m-d', $i)]) ? 0 : $crr[date('Y-m-d', $i)];

            $tmp_ounm = empty($drr[date('Y-m-d', $i)]) ? 0 : $drr[date('Y-m-d', $i)];
            $tmp_otransfermoney = empty($err[date('Y-m-d', $i)]) ? 0 : $err[date('Y-m-d', $i)];
            $tmp_ofree = empty($frr[date('Y-m-d', $i)]) ? 0 : $frr[date('Y-m-d', $i)];
            $inum_arr[] = $tmp_inum;
            $iordermoney_arr[] = $tmp_iordermoney;
            $ifree_arr[] = $tmp_ifree;
            $ounm_arr[] = $tmp_ounm;
            $otransfermoney_arr[] = $tmp_otransfermoney;
            $ofree_arr[] = $tmp_ofree;
            $date = date('Y-m-d', $i);
            $list[] = array(
                'day' => $date,
                'inum' => $tmp_inum,
                'iordermoney' => $tmp_iordermoney,
                'ifree' => $tmp_ifree,
                'ounm' => $tmp_ounm,
                'otransfermoney' => $tmp_otransfermoney,
                'ofree' => $tmp_ofree,
                'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }
        $list_all = array(
            'aiordermoney' => $res_a['aiordermoney'],
            'aifree' => $res_a['aifree'],
            'aotransfermoney' => $res_o_a['aotransfermoney'],
            'aofree' => $res_o_a['aofree'],
        );
        //导出结果
        $action = I('action');
        if($action == 'export'){
            if(!$list){
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list,'daily');
        }
        $this->assign('list', $list);
        $this->assign('list_all', $list_all);

//        dump($list);
//        die();
//        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
//        $this->assign('result', json_encode($result));
        $this->display();
    }

    public function monthly()
    {
        $timegap = I('reservation','');  //传递过来的时间
        if($timegap){
            $gap = explode(' - ', $timegap);
            $begin = $gap[0];
            $end = $gap[1];
        }else{
            $lastweek = date('Y-m',strtotime("-3 month"));//30天前
//            $lastweek = date('Y-m-d',strtotime("-1 week"));//7天前
            $begin = I('begin',$lastweek);
            $end =  I('end',date('Y-m'));
        }
        $begin = strtotime($begin);

        $end = strtotime($end)+86399*date("t");

        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y-%m') as gap from  __PREFIX__payin ";
        $sql .= " where uid = $this->uid and begin_time>$begin and begin_time<$end AND status=1 group by gap";
        $res = M()->query($sql);//订单数,交易额
        $map['begin_time'] = array(array('gt',$begin),array('lt',$end),'and');
        $map['uid'] = $this->uid;
        $res_a = M('payin')->where($map)->field("sum(`ordermoney`) as `aiordermoney`,sum(`free`) as `aifree`")->find();

        $inum = "";
        $ifree = "";
        $iordermoney = "";
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['inum'];
            $brr[$val['gap']] = $val['iordermoney'];
            $crr[$val['gap']] = $val['ifree'];
            $inum += $val['inum'];  //数量
            $ifree += $val['ifree'];  //数量
            $iordermoney += $val['iordermoney']; // 金额
        }

        //出金统计
        $osql = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree, FROM_UNIXTIME(begin_time,'%Y-%m') as gap from  __PREFIX__payout ";
        $osql .= " where uid = $this->uid and begin_time>$begin and begin_time<$end AND status=4 group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt',$begin),array('lt',$end),'and');
        $map1['status'] = 4;
        $map1['uid'] = $this->uid;

        $res_o_a = M('payout')->where($map1)->field("sum(`transfermoney`) as `aotransfermoney`,sum(`free`) as `aofree`")->find();

        $ounm = "";
        $ofree = "";
        $otransfermoney = "";
        foreach ($ores as $oval) {
            $drr[$oval['gap']] = $oval['onum'];
            $err[$oval['gap']] = $oval['otransfermoney'];
            $frr[$oval['gap']] = $oval['ofree'];
            $ounm += $oval['onum'];  //数量
            $ofree += $oval['otransfermoney'];  //数量
            $otransfermoney += $oval['ofree']; // 金额

        }
        for ($i = $begin; $i <= $end; $i = $i + 24 * 3600 * 31) {
            $tmp_inum = empty($arr[date('Y-m', $i)]) ? 0 : $arr[date('Y-m', $i)];
            $tmp_iordermoney = empty($brr[date('Y-m', $i)]) ? 0 : $brr[date('Y-m', $i)];
            $tmp_ifree = empty($crr[date('Y-m', $i)]) ? 0 : $crr[date('Y-m', $i)];
            $tmp_ounm = empty($drr[date('Y-m', $i)]) ? 0 : $drr[date('Y-m', $i)];
            $tmp_otransfermoney = empty($err[date('Y-m', $i)]) ? 0 : $err[date('Y-m', $i)];
            $tmp_ofree = empty($frr[date('Y-m', $i)]) ? 0 : $frr[date('Y-m', $i)];
            $inum_arr[] = $tmp_inum;
            $iordermoney_arr[] = $tmp_iordermoney;
            $ifree_arr[] = $tmp_ifree;
            $ounm_arr[] = $tmp_ounm;
            $otransfermoney_arr[] = $tmp_otransfermoney;
            $ofree_arr[] = $tmp_ofree;
            $date = date('Y-m', $i);
            $list[] = array(
                'day' => $date,
                'inum' => $tmp_inum,
                'iordermoney' => $tmp_iordermoney,
                'ifree' => $tmp_ifree,
                'ounm' => $tmp_ounm,
                'otransfermoney' => $tmp_otransfermoney,
                'ofree' => $tmp_ofree,
                'end' => date('Y-m-d', $i + 24 * 60 * 60 * 31));
            $day[] = $date;
        }
        $list_all = array(
            'aiordermoney' => $res_a['aiordermoney'],
            'aifree' => $res_a['aifree'],
            'aotransfermoney' => $res_o_a['aotransfermoney'],
            'aofree' => $res_o_a['aofree'],
        );
        //导出结果
        $action = I('action');
        if($action == 'export'){
            if(!$list){
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list,'monthly');
        }

        $this->assign('list', $list);
        $this->assign('list_all', $list_all);

//        dump($list);
//        die();
//        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
//        $this->assign('result', json_encode($result));
        $this->display();

    }

    public function total()
    {
        $begin = strtotime(date('Y',time()).'-01-01 00:00:00');

        $end = strtotime(date('Y-m-d',time()).' 00:00:00')+86400;

        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y') as gap from  __PREFIX__payin ";
        $sql .= " where uid = $this->uid and begin_time>$begin and begin_time<$end AND status=1 group by gap";
        $res = M()->query($sql);//订单数,交易额
        $map['begin_time'] = array(array('gt',$begin),array('lt',$end),'and');
        $map['uid'] = $this->uid;
        $res_a = M('payin')->where($map)->field("sum(`ordermoney`) as `aiordermoney`,sum(`free`) as `aifree`")->find();

        $inum = "";
        $ifree = "";
        $iordermoney = "";
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['inum'];
            $brr[$val['gap']] = $val['iordermoney'];
            $crr[$val['gap']] = $val['ifree'];
            $inum += $val['inum'];  //数量
            $ifree += $val['ifree'];  //数量
            $iordermoney += $val['iordermoney']; // 金额
        }

        //出金统计
        $osql = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree, FROM_UNIXTIME(begin_time,'%Y') as gap from  __PREFIX__payout ";
        $osql .= " where uid = $this->uid and begin_time>$begin and begin_time<$end AND status=4 group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt',$begin),array('lt',$end),'and');
        $map1['status'] = 4;
        $map1['uid'] = $this->uid;

        $res_o_a = M('payout')->where($map1)->field("sum(`transfermoney`) as `aotransfermoney`,sum(`free`) as `aofree`")->find();

        $ounm = "";
        $ofree = "";
        $otransfermoney = "";
        foreach ($ores as $oval) {
            $drr[$oval['gap']] = $oval['onum'];
            $err[$oval['gap']] = $oval['otransfermoney'];
            $frr[$oval['gap']] = $oval['ofree'];
            $ounm += $oval['onum'];  //数量
            $ofree += $oval['otransfermoney'];  //数量
            $otransfermoney += $oval['ofree']; // 金额

        }
        for ($i = $begin; $i <= $end; $i = $i + 24 * 3600 * 365) {
            $tmp_inum = empty($arr[date('Y', $i)]) ? 0 : $arr[date('Y', $i)];
            $tmp_iordermoney = empty($brr[date('Y', $i)]) ? 0 : $brr[date('Y', $i)];
            $tmp_ifree = empty($crr[date('Y', $i)]) ? 0 : $crr[date('Y', $i)];
            $tmp_ounm = empty($drr[date('Y', $i)]) ? 0 : $drr[date('Y', $i)];
            $tmp_otransfermoney = empty($err[date('Y', $i)]) ? 0 : $err[date('Y', $i)];
            $tmp_ofree = empty($frr[date('Y', $i)]) ? 0 : $frr[date('Y', $i)];
            $inum_arr[] = $tmp_inum;
            $iordermoney_arr[] = $tmp_iordermoney;
            $ifree_arr[] = $tmp_ifree;
            $ounm_arr[] = $tmp_ounm;
            $otransfermoney_arr[] = $tmp_otransfermoney;
            $ofree_arr[] = $tmp_ofree;
            $date = date('Y', $i);
            $list[] = array(
                'day' => $date,
                'inum' => $tmp_inum,
                'iordermoney' => $tmp_iordermoney,
                'ifree' => $tmp_ifree,
                'ounm' => $tmp_ounm,
                'otransfermoney' => $tmp_otransfermoney,
                'ofree' => $tmp_ofree,
                'end' => date('Y', $i + 24 * 3600 * 31*12));
            $day[] = $date;
        }
        $list_all = array(
            'aiordermoney' => $res_a['aiordermoney'],
            'aifree' => $res_a['aifree'],
            'aotransfermoney' => $res_o_a['aotransfermoney'],
            'aofree' => $res_o_a['aofree'],
        );
        //导出结果
        $action = I('action');
        if($action == 'export'){
            if(!$list){
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list,'year');
        }

        $this->assign('list', $list);
        $this->assign('list_all', $list_all);

//        dump($list);
//        die();
//        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
//        $this->assign('result', json_encode($result));
        $this->display();
    }



    //导出数据方法
    protected function goods_export($goods_list=array(),$filename)
    {
        //print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k=>$goods_info){
            $data[$k][day] = $goods_info['day'];
            $data[$k][iordermoney] = $goods_info['iordermoney'];
            $data[$k][ifree] = $goods_info['ifree'];
            $data[$k][balance]  = $goods_info['iordermoney']-$goods_info['ifree'];
            $data[$k][otransfermoney]  = $goods_info['otransfermoney'];
            $data[$k][ofree]  = $goods_info['ofree'];
            $data[$k][vfree] = $goods_info['0'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field=>$v){
            if($field == 'day'){
                $headArr[]='日期';
            }

            if($field == 'iordermoney'){
                $headArr[]='總入金金額';
            }

            if($field == 'ifree'){
                $headArr[]='總入金手續費';
            }

            if($field == 'balance'){
                $headArr[]='結算金額';
            }

            if($field == 'otransfermoney'){
                $headArr[]='總出金金額';
            }

            if($field == 'ofree'){
                $headArr[]='總出金手續費';
            }

            if($field == 'vfree'){
                $headArr[]='總出金失敗手續費';
            }

        }

        $filename=$filename;

        getExcel($filename,$headArr,$data);
    }








    function bak_sum()
    {
        $this->title='月份统计';
        $mouth = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $y = I('post.year') + 0;
        $y_time = getYearTime($y);
        $year = date('Y', time());
        if($y!=0){
            $year = $y;
        }
        $time = M('payout')->where('status=4 and time>=' . $y_time)->getField('transfermoney', 'free');
        foreach ($time as $key => $value) {
            switch (date('Ym', $value)) {
                case $year . '01':
                    $mouth[0] ++;
                    break;
                case $year . '02':
                    $mouth[1] ++;
                    break;
                case $year . '03':
                    $mouth[2] ++;
                    break;
                case $year . '04':
                    $mouth[3] ++;
                    break;
                case $year . '05':
                    $mouth[4] ++;
                    break;
                case $year . '06':
                    $mouth[5] ++;
                    break;
                case $year . '07':
                    $mouth[6] ++;
                    break;
                case $year . '08':
                    $mouth[7] ++;
                    break;
                case $year . '09':
                    $mouth[8] ++;
                    break;
                case $year . '10':
                    $mouth[9] ++;
                    break;
                case $year . '11':
                    $mouth[10] ++;
                    break;
                case $year . '12':
                    $mouth[11] ++;
                    break;
                default:
                    break;
            }
        }
        $this->year = $year;
        $this->all_year_num = array_sum($mouth);
        $this->mouth = $mouth;
        $this->display();
    }



}