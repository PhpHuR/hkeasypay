<?php
/**
 * Date: 2016/9/12
 * Time: 22:03
 */

namespace Payout\Controller;

use Payout\Controller\PayoutbaseController;

class PayoutController extends PayoutbaseController
{
    function index()
    {
        $this->display('turnFoOrderPage');
    }

    //批量出金

    public function audit()
    {
        //客户显示当前自己的
        if (IS_POST) {
            if (!IS_AJAX) {
                $this->error('提交方式不正确', U('audit'), 0);
            } else {
                $id = I('id');
                $payout_audit = M('payout')->where(array('id' => $id))->find();
                $sl_data['id'] = $id;
                $sl_data['batchnum'] = $payout_audit['batchnum'];
                $sl_data['reaccname'] = $payout_audit['reaccname'];
                $sl_data['reaccno'] = $payout_audit['reaccno'];
                $sl_data['bankname'] = $payout_audit['bankname'];
                $sl_data['transfermoney'] = $payout_audit['transfermoney'];
                $sl_data['free'] = $payout_audit['free'];
                $sl_data['status'] = $payout_audit['status'];
                $this->ajaxReturn($sl_data, 'json');

            }
        } else {
            $key = I('key');
            $map['batchnum'] = array('like', "%" . $key . "%");
            $map['uid'] = $this->user['member_list_userinfoid'];
            $map['status'] = 0;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();

            $this->assign('audit_list', $audit_list);
            $this->assign('page', $show);
            $this->assign('val', $key);
            $this->display();

        }


    }

    public function runaudit()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('turnFoOrderPage'), 0);
        } else {
            //也是需要做成功或者失败判断的
            $sl_data = array(
                'id' => I('id'),
                'audit_time'=>time(),
                'status' => I('status'),
            );

            $rst = M('payout')->save($sl_data);
            if ($rst !== false) {
                $this->success('订单审核成功', U('turnFoOrderPage'), 1);
            } else {
                $this->error('订单审核失败', U('turnFoOrderPage'), 0);
            }
        }

    }


    public function turnFoOrderPage()
    {
            //出金员显示所有
            if (IS_POST and IS_AJAX) {
                $id = I('id');
                $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
                $sl_data['payout_id'] = $id;
                $sl_data['batchnum'] = $payout_audit['batchnum'];
                $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
                $sl_data['currency_id'] = $payout_audit['currency_id'];
                $sl_data['reaccname'] = $payout_audit['reaccname'];
                $sl_data['reaccno'] = $payout_audit['reaccno'];
                $sl_data['bankname'] = getBankName($payout_audit['bankname']);
                $sl_data['transfermoney'] = $payout_audit['transfermoney'];
                $sl_data['free'] = $payout_audit['free'];
                $sl_data['ok']=1;
                $this->ajaxReturn($sl_data, 'json');
            } else {
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
                    $arrdatetwo = strtotime($arr[1] . ' 23:55:55');
                    $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
                }

                $map['payout_orderid|uid|api_china_name|title'] = array('like', "%" . $key . "%");;
                $map['uid'] = array('like', "%" . $key . "%");
                $map['status'] = array('like', "%" . $key . "%");
                $map['_logic'] = 'AND';
                /*
                 * 分页操作
                 */
                $count = M('payout_list')->where($map)->count();// 查询满足要求的总记录数
                $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
                $show = $Page->show();// 分页显示输出
                $payout_list = M('payout_list')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payout_id desc')->select();
                $payout_list_e = M('payout_list')->where($map)->order('payout_id desc')->select();
                //导出结果
                $action = I('action');
                if($action == 'export'){
                    if(!$payout_list_e){
                        $this->error('没有搜索结果，无法导出数据');
                    }
                    $this->goods_export($payout_list_e,'OrderPage');
                }
                $this->assign('sldate', $sldate);
                $this->assign('keyy', $key);
                $this->assign('payout_list', $payout_list);
                $this->assign('page', $show);
                $this->assign('val', $key);
                $this->display();
            }


    }


    public function turnFoAuditOrderPage()
    {
        //把订单送入到处理中 -- 或者处理成功 状态 turnFoAuditOrderPage
        if (IS_POST and IS_AJAX) {
            $id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
            $sl_data['currency_id'] = $payout_audit['currency_id'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = getBankName($payout_audit['bankname']);
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['ok']=1;
            $this->ajaxReturn($sl_data, 'json');
        } else {

            $key = I('key');
            $map['payout_orderid|uid|api_china_name|title'] = array('like', "%" . $key . "%");
            $map['status'] = 1;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout_list')->where($map)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout_list')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('audit_time desc')->select();

            //导出结果
            $action = I('action');
            if($action == 'export'){
                if(!$audit_list){
                    $this->error('没有搜索结果，无法导出数据');
                }
                $this->goods_export($audit_list,'AuditOrderPage');
            }
            $this->assign('audit_list', $audit_list);
            $this->assign('page', $show);
            $this->assign('val', $key);
            $this->display();
        }

    }

    public function runAuditOrder()
    {
        //把订单送入到处理中 -- 或者处理成功 状态 turnFoAuditOrderPage
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('turnFoOrderPage'), 0);
        } else {
            $status = I('status');
            if ($status ==5) {
                //归还出金金额以及手续费，并更新userinfo表的总额
            }
            $sl_data = array(
                'payout_id' => I('payout_id'),
                'audit_time'=>time(),
                'status' => I('status'),
            );
            $rst = M('payout')->save($sl_data);
            if ($rst !== false) {
                $this->success('订单审核成功', U('turnFoOrderPage'), 1);
            } else {
                $this->error('订单审核失败', U('turnFoOrderPage'), 0);
            }
        }

    }
    public function turnFoOrderIng()
    {
        //把订单送入处理成功   处理失败 状态  顺带扣款
        if (IS_POST && IS_AJAX) {
            $id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['uid'] = $payout_audit['uid'];
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['currency_id'] = $payout_audit['currency_id'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = getBankName($payout_audit['bankname']);
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['begin_time'] = $payout_audit['begin_time'];
            $sl_data['audit_time'] = $payout_audit['audit_time'];
            $sl_data['result_time'] = $payout_audit['result_time'];
            $sl_data['remark'] = $payout_audit['remark'];
            $sl_data['result_remark'] = $payout_audit['result_remark'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['ok']=1;
            $this->ajaxReturn($sl_data, 'json');
        } else {
            $key = I('key');
            $map['batchnum'] = array('like', "%" . $key . "%");
            $map['uid'] = array('like', "%" . $key . "%");
            $map['status'] = 3;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout_list')->where($map)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout_list')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('audit_time desc')->select();

            //导出结果
            $action = I('action');
            if($action == 'export'){
                if(!$audit_list){
                    $this->error('没有搜索结果，无法导出数据');
                }
                $this->goods_export($audit_list,'orderPageIng');
            }
            $this->assign('audit_list', $audit_list);
            $this->assign('page', $show);
            $this->assign('val', $key);
            $this->display();
        }

    }

    public function runFoOrderIng()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('turnFoOrderPage'), 0);
        } else {
            $status = I('status');
            $end_time = time();
            $transfermoney = I('transfermoney');
            $currency_id = I('currency_id');
            $free = I('free');
            $balance = M('user_balance');
            $balance_list = $balance->where(array('user_id' => I('uid'),'currency_id'=>$currency_id))->find();
            $sumcount = $balance_list['sumcount'];  //总金额
            if ($status ==4) {
                //扣去出金金额以及手续费，并更新userinfo表的总额
                $sumcount = $balance_list['sumcount'] - $transfermoney - $free;  //总金额
                $unsettlement = $balance_list['unsettlement'] - $transfermoney - $free; //未结算金额
                $userinfo_data = array(
                    'sumcount' =>$sumcount,
                    'unsettlement' => $unsettlement,
                );
                $u_userinfo = $balance->where(array('user_id' => I('uid'),'currency_id'=>$currency_id))->save($userinfo_data);
                if ($u_userinfo) {
                    //写入交易记录中
                    $order_log_data_transfermoney = array(
                        'uid' => I('uid'),
                        'orderid' => I('batchnum'),
                        't_type' => '2',
                        'currency_id' => $currency_id,
                        'income' => '0.00',
                        'outlay' => $transfermoney,
                        'balance' => $sumcount+$free,
                        'begin_time' => I('begin_time'),
                        'end_time' => $end_time,
                        'remark' => I('remark'),

                    );
                    if (M('order_log')->add($order_log_data_transfermoney)) {
                        //写入交易记录
                        $order_log_data_free = array(
                            'uid' => I('uid'),
                            'orderid' => I('batchnum'),
                            't_type' => 3,
                            'currency_id' => $currency_id,
                            'income' => '0.00',
                            'outlay' => $free,
                            'balance' => $sumcount,
                            'begin_time' => I('begin_time'),
                            'end_time' => $end_time,
                            'remark' => I('remark'),
                        );
                        //写入手续费扣除记录
                        M('order_log')->add($order_log_data_free);
                    } else {
                        //记录到日志，写入失败
                        $log_data = array(
                            'uid' => $this->user['member_list_id'] . '&' . $balance_list['id'],
                            'log_type' => 2,
                            'model' => 'payout',
                            'action' => '单笔出金',
                            'content' => '出金记录日志写入失败。批次号：' . I('batchnum') . '出金金额' . $transfermoney . '手续费' . $free . '总额：' . $sumcount ,
                            'last_time' => date('Y-m-d H:i:s'),
                            'ip' => get_client_ip(0, true)
                        );
                        M('log')->add($log_data);
                    }

                    $sl_data = array(
                        'payout_id' => I('payout_id'),
                        'result_time'=>$end_time,
                        'status' => I('status'),
                    );
                    $rst = M('payout')->save($sl_data);
                    if ($rst !== false) {
                        $this->success('出金成功', U('turnFoOrderPage'), 1);
                    } else {
                        $this->error('出金保存失败', U('turnFoOrderPage'), 0);
                    }


                }

            }
            if ($status ==5) {
                //归还出金金额以及手续费，并更新userinfo表的总额
                $sumcount = $balance_list['sumcount'] + $transfermoney + $free;  //总金额
                $availablecount = $balance_list['availablecount'] + $transfermoney + $free; //可用余额
                $unsettlement = $balance_list['unsettlement'] - $transfermoney - $free; //未结算金额

                //更新userinfo表的可用余额，总金额，未结算金额
                $userinfo_data = array(
                    'availablecount' => $availablecount,
                    'unsettlement' => $unsettlement,
                );
                $u_userinfo = $balance->where(array('user_id' => I('uid'),'currency_id'=>$currency_id))->save($userinfo_data);
                if ($u_userinfo) {
                    //更新订单状态
                    $sl_data = array(
                        'payout_id' => I('payout_id'),
                        'audit_time'=>time(),
                        'status' => I('status'),
                    );
                    $rst = M('payout')->save($sl_data);
                    if ($rst !== false) {
                        $this->success('订单修改状态成功', U('turnFoOrderPage'), 1);
                    } else {
                        $this->error('订单修改状态失败', U('turnFoOrderPage'), 0);
                    }
                }
            }


        }
        
    }



    //导出数据方法
    protected function goods_export($goods_list=array(),$filename)
    {
//        print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][payout_id] = ''.' '.$goods_info['payout_id'];
            $data[$k][begin_time] = ''.' '.date('Y-m-d H:i:s',$goods_info['begin_time']);
            $data[$k][member_name] = ''.' '.$goods_info['member_name'];
            $data[$k][uid] = ''.' '.$goods_info['uid'];
            $data[$k][api_china_name] = ''.' '.$goods_info['api_china_name'];
            $data[$k][title] = ''.' '.$goods_info['title'];
            $data[$k][payout_orderid] = ''.' '.$goods_info['payout_orderid'];
            $data[$k][currency_id] = ''.' '.getCurrencyName($goods_info['currency_id']);
            $data[$k][bankname] = ''.' '.getBankName($goods_info['bankname']);
            $data[$k][reaccname] = ''.' '.$goods_info['reaccname'];
            $data[$k][reaccno] = ''.' '.$goods_info['reaccno'];
            $data[$k][proname] = getRegionName($goods_info['proname']);
            $data[$k][cityname] = getRegionName($goods_info['cityname']);
            $data[$k][reaccdept] = getRegionName($goods_info['reaccdept']);
            $data[$k][operato] = $goods_info['operato'];
            $data[$k][transfermoney] = ''.' '.number_format($goods_info['transfermoney'], 2, '.', ',');
            $data[$k][status] = getPayoutStatusName($goods_info['status']);
            $data[$k][remark] = ''.' '.$goods_info['remark'];
        }
        foreach ($data as $field=>$v){
            if($field == 'payout_id'){
                $headArr[]='ID';
            }
            if($field == 'begin_time'){
                $headArr[]='日期時間';
            }
            if($field == 'member_name'){
                $headArr[]='客戶名稱';
            }
            if($field == 'uid'){
                $headArr[]='商戶號MID';
            }
            if($field == 'api_china_name'){
                $headArr[]='商戶號MID';
            }
            if($field == 'title'){
                $headArr[]='支付公司MID';
            }

            if($field == 'payout_orderid'){
                $headArr[]='客戶訂單號碼';
            }
            if($field == 'currency_id'){
                $headArr[]='出金货币';
            }
            if($field == 'bankname'){
                $headArr[]='收款銀行';
            }
            if($field == 'reaccname'){
                $headArr[]='收款方账户名';
            }
            if($field == 'reaccno'){
                $headArr[]='收款方账号';
            }
            if($field == 'proname'){
                $headArr[]='开户行所在省';
            }
            if($field == 'cityname'){
                $headArr[]='开户行所在市';
            }
            if($field == 'reaccdept'){
                $headArr[]='开户行所在区';
            }
            if($field == 'operato'){
                $headArr[]='分行名称';
            }
            if($field == 'transfermoney'){
                $headArr[]='订单金额';
            }
            if($field == 'status'){
                $headArr[]='狀態';
            }
            if($field == 'remark'){
                $headArr[]='备注';
            }
        }
        $filename=$filename;
        getExcel($filename,$headArr,$data);
    }
    private function read($filename,$encode='utf-8'){
        $objReader = \PHPExcel_IOFactory::createReader(Excel5);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }


}