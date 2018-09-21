<?php
/**
 * User: zhouding
 * Date: 2016/9/12
 * Time: 22:03
 */

namespace Admin\Controller;

use Common\Controller\AuthController;

class ReportController extends AuthController
{
    public $begin; //开始时间
    public $end;   //结束时间
    public $uid;

    public function _initialize()
    {
        parent::_initialize();
        $timegap = I('reservation', '');  //传递过来的时间
        if ($timegap) {
            $gap = explode(' - ', $timegap);
            $begin = $gap[0];
            $end = $gap[1];
        } else {
//            $lastweek = date('Y-m-d',strtotime("-1 month"));//30天前
            $lastweek = date('Y-m-d', strtotime("-1 week"));//7天前
            $begin = I('begin', $lastweek);
            $end = I('end', date('Y-m-d'));
        }
        $this->begin = strtotime($begin);
        $this->end = strtotime($end) + 86399;
        $this->assign('timegap', date('Y-m-d', $this->begin) . ' - ' . date('Y-m-d', $this->end));
    }

    public function profit_loss()
    {
        $this->display();

    }

    function rate_line()
    {
        $key = I('key');
        $map['tel'] = array('like', "%" . $key . "%");
        $map['member_name'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'OR';
        $count = M('userinfo')->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $userinfo_list = D('userinfo')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->order('time desc')->select();

        foreach ($userinfo_list as $key => $value) {

            //产品ID需要转换成为MID 每一个产品ID代表的MID
            $product_id = json_decode($value['product_id']);
            $product_list = array();
            foreach ($product_id as $k => $val) {
                $product_line = M('product_list')->where(array('product_id' => $val))->find();
                array_push($product_list, $product_line);
            }

            $userinfo_list[$key]['product_line'] = $product_list;

        }
//        dump($userinfo_list);
//        die();
        $this->assign('userinfo_list', $userinfo_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();

    }

    function commission_report()
    {
        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree,sum(payin_commission_c) as ifee_c,sum(payin_commission_ag) as ifee_ag, uid as gap from  __PREFIX__payin_order_list ";
        $sql .= " where begin_time>$this->begin and begin_time<$this->end AND status=1 ";
        $sql .= " group by gap";
        $res = M()->query($sql);//订单数,交易额
        $map['begin_time'] = array(array('gt', $this->begin), array('lt', $this->end), 'and');
        $map['status'] = 1;
        $res_a = M('payin')->where($map)->field("sum(`ordermoney`) as `aiordermoney`,sum(`free`) as `aifree`")->find();

        $inum = "";
        $ifree = "";
        $iordermoney = "";
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['inum'];
            $brr[$val['gap']] = $val['iordermoney'];
            $crr[$val['gap']] = $val['ifree'];
            $drr[$val['gap']] = $val['ifee_c'];
            $err[$val['gap']] = $val['ifee_ag'];
            $inum += $val['inum'];  //数量
            $ifree += $val['ifree'];  //数量
            $iordermoney += $val['iordermoney']; // 金额
        }

        //出金统计
        $osql = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree,sum(payout_commission_c) as ofree_c,sum(payout_commission_ag) as ofree_ag, uid as gap from  __PREFIX__payout ";
        $osql .= " where begin_time>$this->begin and begin_time<$this->end AND status=4 ";
        $osql .= " group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt', $this->begin), array('lt', $this->end), 'and');
        $map1['status'] = 4;

        $res_o_a = M('payout')->where($map1)->field("sum(`transfermoney`) as `aotransfermoney`,sum(`free`) as `aofree`")->find();

        $ounm = "";
        $ofree = "";
        $otransfermoney = "";
        foreach ($ores as $oval) {
            $frr[$oval['gap']] = $oval['onum'];
            $grr[$oval['gap']] = $oval['otransfermoney'];
            $hrr[$oval['gap']] = $oval['ofree'];
            $irr[$oval['gap']] = $oval['ofree_c'];
            $jrr[$oval['gap']] = $oval['ofree_ag'];
            $ounm += $oval['onum'];  //数量
            $ofree += $oval['otransfermoney'];  //数量
            $otransfermoney += $oval['ofree']; // 金额
        }
        //分段統計

        //入金统计报表
        $sqll = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree,sum(payin_commission_c) as ifee_c,sum(payin_commission_ag) as ifee_ag, uid as gap,product_attribute as attribute from  __PREFIX__payin_order_list ";
        $sqll .= " where begin_time>$this->begin and begin_time<$this->end AND status=1 ";
        $sqll .= " group by gap,product_attribute";
        $resl = M()->query($sqll);//订单数,交易额
        //出金统计
        /*        $osqll = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree,sum(payout_commission_c) as ofree_c,sum(payout_commission_ag) as ofree_ag, uid as gap from  __PREFIX__payout ";
                $osqll .= " where begin_time>$this->begin and begin_time<$this->end AND status=4 ";
                $osqll .= " group by gap";
                $oresl = M()->query($osqll);//订单数,交易额
                $res_resualt = array_merge($resl, $oresl);*/
        $res_id = new \Org\Util\ArrayGroupBy();
        $list_l = $res_id->array_group_by($resl, 'gap');


        //获取代理ID -》计算用户ID，并查询



        $user_list = M('userinfo')->select();



        foreach ($user_list as $key => $value) {
            $tmp_inum = empty($arr[$value['user_id']]) ? 0 : $arr[$value['user_id']];
            $tmp_iordermoney = empty($brr[$value['user_id']]) ? 0 : $brr[$value['user_id']];
            $tmp_ifree = empty($crr[$value['user_id']]) ? 0 : $crr[$value['user_id']];
            $tmp_ifree_c = empty($drr[$value['user_id']]) ? 0 : $drr[$value['user_id']];
            $tmp_ifree_ag = empty($err[$value['user_id']]) ? 0 : $err[$value['user_id']];
            $tmp_ounm = empty($frr[$value['user_id']]) ? 0 : $frr[$value['user_id']];
            $tmp_otransfermoney = empty($grr[$value['user_id']]) ? 0 : $grr[$value['user_id']];
            $tmp_ofree = empty($hrr[$value['user_id']]) ? 0 : $hrr[$value['user_id']];
            $tmp_ofree_c = empty($irr[$value['user_id']]) ? 0 : $irr[$value['user_id']];
            $tmp_ofree_ag = empty($jrr[$value['user_id']]) ? 0 : $jrr[$value['user_id']];
            $inum_arr[] = $tmp_inum;
            $iordermoney_arr[] = $tmp_iordermoney;
            $ifree_arr[] = $tmp_ifree;
            $ounm_arr[] = $tmp_ounm;
            $otransfermoney_arr[] = $tmp_otransfermoney;
            $ofree_arr[] = $tmp_ofree;
            $tmp_list_l = array();

            $userAgentRate = getUserAgentRateList($value['user_id']);

            foreach ($userAgentRate as $kr=>$vr) {
                foreach ($vr as $kvr=>$vvr) {
                    $userAgentRate[$kr][$kvr]['total'] = getAgentTotal($kr,$kvr,$this->begin,$this->end);
                }

            }

            foreach ($list_l as $k => $v) {
                if ($k == $value['user_id']) {
                    $tmp_list_l= array_merge($tmp_list_l, $v);
                }
            }
            $list[] = array(
                'uid' => $value['user_id'],
                'inum' => $tmp_inum,
                'iordermoney' => $tmp_iordermoney,
                'ifree' => $tmp_ifree,
                'ifree_c' => $tmp_ifree_c,
                'ifree_ag' => $tmp_ifree_ag,
                'list_l' => $tmp_list_l,
                'agentListRate' => $userAgentRate,
                'ounm' => $tmp_ounm,
                'otransfermoney' => $tmp_otransfermoney,
                'ofree' => $tmp_ofree,
                'ofree_c' => $tmp_ofree_c,
                'ofree_ag' => $tmp_ofree_ag,
            );
        }

        $list_all = array(
            'aiordermoney' => $res_a['aiordermoney'],
            'aifree' => $res_a['aifree'],
            'aotransfermoney' => $res_o_a['aotransfermoney'],
            'aofree' => $res_o_a['aofree'],
        );
        //导出结果
        $action = I('action');
        if ($action == 'export') {
            if (!$list) {
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list, 'daily');
        }

        $this->assign('list', $list);
        $this->assign('list_all', $list_all);

        $this->display();
    }

    function commission_detail_payin()
    {
        $key = I('key');
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

        $map['orderid|transid|ordermoney|free'] = array('like', "%" . $key . "%");;
        $map['status'] = '1';
        $map['_logic'] = 'AND';
        $count = M('payin_order_list')->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $this->assign('page', $show);
        $select_list = M('payin_order_list')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();
        $select_list_e = M('payin_order_list')->where($map)->order('begin_time desc')->select();

        $a_income = "";
        $a_free = "";
        $a_payin_commission_c = "";
        $a_payin_commission_ag = "";
        foreach ($select_list as $k=>$v) {
            if ($v['status'] == '1') {
                $a_income = $a_income + $v['factmoney'];
                $a_free = $a_free + $v['free'];
                $a_payin_commission_c = $a_payin_commission_c + $v['payin_commission_c'];
                $a_payin_commission_ag = $a_payin_commission_ag + $v['payin_commission_ag'];
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
        $this->assign('a_income', $a_income);
        $this->assign('a_free', $a_free);
        $this->assign('a_payin_commission_c', $a_payin_commission_c);
        $this->assign('a_payin_commission_ag', $a_payin_commission_ag);
        $this->assign('sldate', $sldate);
        $this->assign('keyy', $key);
        $this->assign('select_list', $select_list);
        $this->display();
    }

    function commission_detail_payout()
    {
        $key = I('key');
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
        $map['payout_orderid|uid|api_china_name|title'] = array('like', "%" . $key . "%");;
        $map['uid'] = array('like', "%" . $key . "%");
        $map['status'] = "4";
        $map['_logic'] = 'AND';
        /*
         * 分页操作
         */
        $count = M('payout_list')->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $payout_list = M('payout_list')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payout_id desc')->select();
        $payout_list_e = M('payout_list')->where($map)->order('begin_time desc')->select();

        $a_transfermoney = "";
        $a_free = "";
        $a_payout_commission_c = "";
        $a_payout_commission_ag = "";
        foreach ($payout_list as $k=>$v) {
            if ($v['status'] == '1') {
                $a_transfermoney = $a_transfermoney + $v['transfermoney'];
                $a_free = $a_free + $v['free'];
                $a_payout_commission_c = $a_payout_commission_c + $v['a_payout_commission_c'];
                $a_payout_commission_ag = $a_payout_commission_c + $v['a_payout_commission_c'];
            }
        }

        //导出结果
        $action = I('action');
        if($action == 'export'){
            if(!$payout_list_e){
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($payout_list_e,'OrderPage');
        }
        $this->assign('a_transfermoney', $a_transfermoney);
        $this->assign('a_free', $a_free);
        $this->assign('a_payout_commission_c', $a_payout_commission_c);
        $this->assign('a_payout_commission_ag', $a_payout_commission_ag);
        $this->assign('sldate', $sldate);
        $this->assign('keyy', $key);
        $this->assign('payout_list', $payout_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();
    }

    public function index()
    {

        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y-%m-%d') as gap from  __PREFIX__payin ";
        $sql .= " where begin_time>$this->begin and begin_time<$this->end AND status=1 ";
        if ($this->uid) {
            $sql .= "and uid = $this->uid";
        }
        $sql .= " group by gap";

        $res = M()->query($sql);//订单数,交易额

        $map['end_time'] = array(array('gt', $this->begin), array('lt', $this->end), 'and');
        $map['status'] = 1;
        if ($this->uid) {
            $map1['uid'] = $this->uid;
        }
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
        $osql .= " where begin_time>$this->begin and begin_time<$this->end AND status=4 ";
        if ($this->uid) {
            $osql .= " and uid = $this->uid";
        }
        $osql .= " group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt', $this->begin), array('lt', $this->end), 'and');
        $map1['status'] = 4;
        if ($this->uid) {
            $map1['uid'] = $this->uid;
        }

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
        if ($action == 'export') {
            if (!$list) {
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list, 'daily');
        }
        $this->assign('list', $list);
        $this->assign('list_all', $list_all);

        $this->display();
    }

    public function daily()
    {

        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(end_time,'%Y-%m-%d') as gap from  __PREFIX__payin ";
        $sql .= " where end_time>$this->begin and end_time<$this->end AND status=1 ";

        $sql .= " group by gap";

        $res = M()->query($sql);//订单数,交易额

        $map['end_time'] = array(array('gt', $this->begin), array('lt', $this->end), 'and');
        $map['status'] = 1;

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
        $osql = "SELECT COUNT(*) as onum,sum(transfermoney) as otransfermoney,sum(free) as ofree, FROM_UNIXTIME(result_time,'%Y-%m-%d') as gap from  __PREFIX__payout ";
        $osql .= " where result_time>$this->begin and result_time<$this->end AND status=4 ";

        $osql .= " group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['result_time'] = array(array('gt', $this->begin), array('lt', $this->end), 'and');
        $map1['status'] = 4;

        $res_o_a = M('payout')->where($map1)->field("sum(`transfermoney`) as `aotransfermoney`,sum(`free`) as `aofree`")->find();
        

        $ounm = "";
        $ofree = "";
        $otransfermoney = "";
        foreach ($ores as $oval) {
            $drr[$oval['gap']] = $oval['onum'];
            $err[$oval['gap']] = $oval['otransfermoney'];
            $frr[$oval['gap']] = $oval['ofree'];
            $ounm += $oval['onum'];  //数量
            $otransfermoney += $oval['otransfermoney'];  //数量
            $ofree += $oval['ofree']; // 金额

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
        if ($action == 'export') {
            if (!$list) {
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list, 'daily');
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
        $timegap = I('reservation', '');  //传递过来的时间
        if ($timegap) {
            $gap = explode(' - ', $timegap);
            $begin = $gap[0];
            $end = $gap[1];
        } else {
            $lastweek = date('Y-m', strtotime("-3 month"));//30天前
//            $lastweek = date('Y-m-d',strtotime("-1 week"));//7天前
            $begin = I('begin', $lastweek);
            $end = I('end', date('Y-m'));
        }
        $begin = strtotime($begin);

        $end = strtotime($end) + 86399 * date("t");

        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y-%m') as gap from  __PREFIX__payin ";
        $sql .= " where begin_time>$begin and begin_time<$end AND status=1 ";
        if ($this->uid) {
            $sql .= "and uid = $this->uid";
        }
        $sql .= "group by gap";
        $res = M()->query($sql);//订单数,交易额
        $map['begin_time'] = array(array('gt', $begin), array('lt', $end), 'and');
        $map['status'] = 1;
        if ($this->uid) {
            $map1['uid'] = $this->uid;
        }
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
        $osql .= " where begin_time>$begin and begin_time<$end AND status=4 ";
        if ($this->uid) {
            $osql .= "and uid = $this->uid";
        }
        $osql .= " group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt', $begin), array('lt', $end), 'and');
        $map1['status'] = 4;
        if ($this->uid) {
            $map1['uid'] = $this->uid;
        }

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
        if ($action == 'export') {
            if (!$list) {
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list, 'monthly');
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
        $begin = strtotime(date('Y', time()) . '-01-01 00:00:00');

        $end = strtotime(date('Y-m-d', time()) . ' 00:00:00') + 86400;

        //入金统计报表
        $sql = "SELECT COUNT(*) as inum,sum(ordermoney) as iordermoney,sum(free) as ifree, FROM_UNIXTIME(begin_time,'%Y') as gap from  __PREFIX__payin ";
        $sql .= " where begin_time>$begin and begin_time<$end AND status=1 ";
        if ($this->uid) {
            $sql .= "and uid = $this->uid";
        }
        $sql .= " group by gap";
        $res = M()->query($sql);//订单数,交易额
        $map['begin_time'] = array(array('gt', $begin), array('lt', $end), 'and');
        $map['status'] = 1;
        if ($this->uid) {
            $map['uid'] = $this->uid;
        }
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
        $osql .= " where begin_time>$begin and begin_time<$end AND status=4 ";
        if ($this->uid) {
            $osql .= "and uid = $this->uid";
        }
        $osql .= " group by gap";
        $ores = M()->query($osql);//订单数,交易额
        //all
        $map1['begin_time'] = array(array('gt', $begin), array('lt', $end), 'and');
        $map1['status'] = 4;

        if ($this->uid) {
            $map1['uid'] = $this->uid;
        }

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
                'end' => date('Y', $i + 24 * 3600 * 31 * 12));
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
        if ($action == 'export') {
            if (!$list) {
                $this->error('没有搜索结果，无法导出数据');
            }
            $this->goods_export($list, 'year');
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
    protected function goods_export($goods_list = array(), $filename)
    {
        //print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][day] = $goods_info['day'];
            $data[$k][iordermoney] = $goods_info['iordermoney'];
            $data[$k][ifree] = $goods_info['ifree'];
            $data[$k][balance] = $goods_info['iordermoney'] - $goods_info['ifree'];
            $data[$k][otransfermoney] = $goods_info['otransfermoney'];
            $data[$k][ofree] = $goods_info['ofree'];
            $data[$k][vfree] = $goods_info['0'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'day') {
                $headArr[] = '日期';
            }

            if ($field == 'iordermoney') {
                $headArr[] = '總入金金額';
            }

            if ($field == 'ifree') {
                $headArr[] = '總入金手續費';
            }

            if ($field == 'balance') {
                $headArr[] = '結算金額';
            }

            if ($field == 'otransfermoney') {
                $headArr[] = '總出金金額';
            }

            if ($field == 'ofree') {
                $headArr[] = '總出金手續費';
            }

            if ($field == 'vfree') {
                $headArr[] = '總出金失敗手續費';
            }

        }

        $filename = $filename;

        getExcel($filename, $headArr, $data);
    }


    function bak_sum()
    {
        $this->title = '月份统计';
        $mouth = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $y = I('post.year') + 0;
        $y_time = getYearTime($y);
        $year = date('Y', time());
        if ($y != 0) {
            $year = $y;
        }
        $time = M('payout')->where('status=4 and time>=' . $y_time)->getField('transfermoney', 'free');
        foreach ($time as $key => $value) {
            switch (date('Ym', $value)) {
                case $year . '01':
                    $mouth[0]++;
                    break;
                case $year . '02':
                    $mouth[1]++;
                    break;
                case $year . '03':
                    $mouth[2]++;
                    break;
                case $year . '04':
                    $mouth[3]++;
                    break;
                case $year . '05':
                    $mouth[4]++;
                    break;
                case $year . '06':
                    $mouth[5]++;
                    break;
                case $year . '07':
                    $mouth[6]++;
                    break;
                case $year . '08':
                    $mouth[7]++;
                    break;
                case $year . '09':
                    $mouth[8]++;
                    break;
                case $year . '10':
                    $mouth[9]++;
                    break;
                case $year . '11':
                    $mouth[10]++;
                    break;
                case $year . '12':
                    $mouth[11]++;
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