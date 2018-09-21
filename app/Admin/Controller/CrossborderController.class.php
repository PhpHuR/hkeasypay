<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Admin\Controller;

use Common\Controller\AuthController;

class CrossborderController extends AuthController
{

    function index()
    {
        $this->display('turnFoOrderPage');
    }
    public function turnOneToBankPage()
    {

        if (IS_POST) {
            //获取商户信息
            $currency_id = I('currency_id');
            $user_balance = M('user_balance')->where(array('user_id' => $this->user['member_list_userinfoid'],'currency_id'=>$currency_id));
            $user = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();
            $user_balance_list = $user_balance->find();
            $sumcount = floatval($user_balance_list['sumcount']);  //总金额
            $availablecount = floatval($user_balance_list['availablecount']); //可用余额
            $unsettlement = floatval($user_balance_list['unsettlement']); //未结算金额
            //获取出金手续费
            $payout_rate_list = getPayoutRate($user['payout_rate']);

            $free = floatval($payout_rate_list['outrate']); //手续费
            $outmax = floatval($payout_rate_list['outmax']);
            //确认是否可以出金
            $transfermoney = I('transfermoney');
            $oneTransferMoney = getOrderNumber($transfermoney, $outmax);
            $payout_num = count($oneTransferMoney);
            //计算总的出金费率
            $allfree = $free * $payout_num;
            $alltransfermoney = $allfree + $transfermoney;

            if ($alltransfermoney < $availablecount) {
                //单笔超过最大限额，拆分订单
                if ($payout_num > 1) {
                    //拆分出金数量
//                    $sumcount = $userinfo_list['sumcount'] - $transfermoney - $allfree;  //总金额
                    $availablecount = $user_balance_list['availablecount'] - $transfermoney - $allfree; //可用余额
                    $unsettlement = $user_balance_list['unsettlement'] + $transfermoney + $allfree; //未结算金额
                    $userinfo_data = array(
                        'availablecount' => $availablecount,
                        'unsettlement' => $unsettlement,
                    );
                    $u_userinfo = $user_balance->where(array('user_id' => $this->user['member_list_userinfoid'],'currency_id'=>$currency_id))->save($userinfo_data);
                    if ($u_userinfo) {
                        for ($i = 0; $i < $payout_num; $i++) {
                            //批量插入数据库
                            $payout_orderid = 'o' . createOrder($this->user['member_list_id']);
                            $batchnum = $this->user['member_list_id'] . 'o' . 'p' . date('YmdHis');
                            $payout_data = array(
                                'uid' => $this->user['member_list_userinfoid'],
                                'member_name' => $user['member_name'],
                                'payout_orderid' => $payout_orderid,
                                'batchnum' => $batchnum,
                                'type' => 1,
                                'currency_id' => $currency_id,
                                'reaccname' => I('reaccname'),
                                'reaccno' => I('reaccno'),
                                'bankname' => I('bankname'),
                                'proname' => I('proname'),
                                'cityname' => I('cityname'),
                                'townname' => I('townname'),
                                'reaccdept' => I('reaccdept'),
                                'transfermoney' => $oneTransferMoney[$i],
                                'status' => 1,
                                'free' => $free,
                                'begin_time' => time(),
                                'remark' => I('remark'),
                            );
                            //存入数据到表单
                            if (checkPayoutOrderId($payout_orderid)) {
                                if (M('payout')->add($payout_data)) {
                                    //写入日志信息
                                    $content = '出金记录写入成功。订单号：' . $payout_orderid . '###出金金额' . $oneTransferMoney[$i] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                                    $logResult = addLog($this->user['member_list_id'], 1, 'payout', '单笔出金', $content);
                                } else {
                                    //写入失败日志信息
                                    $content = '出金记录写入失败。订单号：' . $payout_orderid . '###出金金额' . $oneTransferMoney[$i] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                                    $logResult = addLog($this->user['member_list_id'], 2, 'payout', '单笔出金', $content);
                                }

                            } else {
                                $this->error('订单错误，请重新提交', U('turnFoOrderPage'), 0);
                            }
                        }
                        $this->success('订单提交成功', U('turnFoOrderPage'), 1);
                    } else {
                        $this->error('订单提交失败', U('turnOneToBankPage'), 0);
                    }

                } else {
                    //单笔出金没超过最大限额的情况
                    $payout_orderid = 'o' . createOrder($this->user['member_list_id']);
                    $batchnum = $this->user['member_list_id'] . 'o' . 'p' . date('YmdHis');
                    $payout_data = array(
                        'uid' => $this->user['member_list_userinfoid'],
                        'member_name' => $user['member_name'],
                        'payout_orderid' => $payout_orderid,
                        'batchnum' => $batchnum,
                        'type' => 1,
                        'currency_id' => $currency_id,
                        'reaccname' => I('reaccname'),
                        'reaccno' => I('reaccno'),
                        'bankname' => I('bankname'),
                        'proname' => I('proname'),
                        'cityname' => I('cityname'),
                        'townname' => I('townname'),
                        'reaccdept' => I('reaccdept'),
                        'transfermoney' => $transfermoney,
                        'status' => 1,
                        'free' => $free,
                        'begin_time' => time(),
                        'remark' => I('remark'),
                    );
                    //写入记录，更新总额，写入日志
                    if (checkPayoutOrderId($payout_orderid) and M('payout')->add($payout_data)) {
                        //扣去总金额更新用户信息表
//                        $sumcount = $userinfo_list['sumcount'] - $transfermoney - $free;  //总金额
                        $availablecount = $user_balance_list['availablecount'] - $transfermoney - $free; //可用余额
                        $unsettlement = $user_balance_list['unsettlement'] + $transfermoney + $free; //未结算金额
                        $userinfo_data = array(
                            'availablecount' => $availablecount,
                            'unsettlement' => $unsettlement,
                        );
                        $u_userinfo = $user_balance->where(array('user_id' => $this->user['member_list_userinfoid'],'currency_id'=>$currency_id))->save($userinfo_data);
                        if ($u_userinfo) {
                            //写入日志信息
                            $content = '出金记录写入成功。订单号：' . $payout_orderid . '###出金金额' . $oneTransferMoney[$i] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                            $logResult = addLog($this->user['member_list_id'], 1, 'payout', '单笔出金', $content);
                            $this->success('出金信息提交成功', U('turnFoOrderPage'), 1);
                        } else {
                            //写入失败日志信息
                            $content = '出金记录写入失败。订单号：' . $payout_orderid . '###出金金额' . $oneTransferMoney[$i] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                            $logResult = addLog($this->user['member_list_id'], 2, 'payout', '单笔出金', $content);
                            $this->error('出金信息提交失败', U('turnFoOrderPage'), 0);
                        }
                    }

                }

            } else {
                $this->error('可用金额不足，请核对金额总数重新提交！', U('turnOneToBankPage'), 0);
            }
            //初始状态，未提交数据
        } else {
            //获取用户配置信息
            $province = M('region')->where(array('parent_id' => 0, 'level' => 1))->select();
            $this->assign('province', $province);
            //
            $currency_list = M('currency')->select();
            $this->assign('currency_list', $currency_list);
            //
            $userinfo = M('userinfo')->select();  //获取用户的配置信息

            foreach ($userinfo as $key => $value) {

                $user_id = $value['user_id'];
                $sub_user_list = M('sub_user_balance')->field('attribute,sub_user_balance')->where(array('user_id' => $user_id))->select();

                $userinfo[$key]['sub_user_list'] = $sub_user_list;

            }
            //获取出款的费率配置
            $payout_rate_list = M('payout_rate')->where(array('payout_rate_id' => $userinfo['payout_rate']))->find();
            $payout_rate = $payout_rate_list['outrate'];
            $this->assign('payout_rate', $payout_rate);
            $this->assign('userinfo', $userinfo);
            $this->display();
        }
    }

    //批量出金
    public function turnListToBankPage()
    {
        if ($_FILES) {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 3145728;// 设置附件上传大小
            $upload->exts = array('xls', 'xlsx');// 设置附件上传类
            $upload->rootPath = './public/Excel/'; // 设置附件上传根目录
            $upload->savePath = $this->user['member_list_userinfoid'] . '/'.$this->user['member_list_id'].'/'; // 设置附件上传（子）目录  I('p_id').' /'.I('memberid')
            $upload->autoSub = true;//自动使用子目录保存上传文件
            $upload->saveName = '';//上传文件的保存规则
            $upload->subName = date('Ymd');
            $upload->saveRule = '';
            // 上传文件
            $info = $upload->uploadOne($_FILES['file_stu']);
            $filename = './public/Excel/' .$info['savepath'] . $info['savename'];
            $exts = $info['ext'];
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功
                $res = $this->read($filename, $exts);
            }
            if (!$res){
                $this->error ('数据处理失败',U('turnListToBankPage'),0);
            }

            //获取商户信息
            $userinfo = M('user_balance')->where(array('user_id' => $this->user['member_list_userinfoid'],'currency_id'=>1));
            $user = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();
            $userinfo_list = $userinfo->find();
            $sumcount = floatval($userinfo_list['sumcount']);  //总金额
            $availablecount = floatval($userinfo_list['availablecount']); //可用余额
            $unsettlement = floatval($userinfo_list['unsettlement']); //未结算金额
            //获取出金手续费
            $payout_rate_list = getPayoutRate($user['payout_rate']);
            $free = floatval($payout_rate_list['outrate']); //手续费
            $outmax = floatval($payout_rate_list['outmax']);
            //确认是否可以出金
            $countProName = array_column($res, 2);
            $countCityName = array_column($res, 3);
            $countBankName = array_column($res, 5);
            $countMoney = array_column($res, 6);

            $num = count($countMoney)-1;
            $all = array_sum($countMoney)+$free*$num;

            if ($all <= $availablecount) {
                for ($i=1;$i<count($countMoney);$i++) {
                    //循環檢查excel最大金額
                    if ($countMoney[$i]>$outmax) {
                        //刪除excel文件
                        unlink($filename);
                        $this->error('出金金額大於單筆最高限額，請核對后從新提交！', U('turnListToBankPage'), 0);
                        break;
                    }
                    if (is_null(getRegionId($countProName[$i]))) {
                        //刪除excel文件
                        unlink($filename);
                        $this->error('出金銀行省份填寫錯誤，請核對后從新提交！', U('turnListToBankPage'), 0);
                        break;
                    }
                    if (is_null(getRegionId($countCityName[$i]))) {
                        //刪除excel文件
                        unlink($filename);
                        $this->error('出金銀行市區填寫錯誤，請核對后從新提交！', U('turnListToBankPage'), 0);
                        break;
                    }
                    if (is_null(getBankCode($countBankName[$i]))) {
                        //刪除excel文件
                        unlink($filename);
                        $this->error('出金銀行填寫錯誤，請核對后從新提交！', U('turnListToBankPage'), 0);
                        break;
                    }
                }//檢查結束
                $begin_time = time();
                foreach ( $res as $k => $v ){
                    if ($k != 1){
                        $payout_orderid = 'o' . createOrder($this->user['member_list_id']);
                        $batchnum = $this->user['member_list_id'] . 'o' . 'p' . date('YmdHis');
                        $data ['uid'] = $this->user['member_list_userinfoid'];
                        $data ['member_name'] = $user['member_name'];
                        $data ['payout_orderid'] = $payout_orderid;
                        $data ['batchnum'] = $batchnum;
                        $data ['type'] = 2;
                        $data ['currency_id'] = 1;
                        $data ['reaccname'] = $v[0];
                        $data ['reaccno'] = $v[1];
                        $data ['bankname'] = getBankCode($v[5]);
                        $data ['proname'] = getRegionId($v[2]);
                        $data ['cityname'] = getRegionId($v[3]);
                        $data ['reaccdept'] = $v[4];
                        $data ['operato'] = $this->user['member_list_id'];
                        $data ['filename'] = $info['savename'];
                        $data ['transfermoney'] = $v[6];
                        $data ['free'] = $free;
                        $data ['status'] = 1;
                        $data ['begin_time'] = $begin_time;
                        $data ['remark'] = $v[7];
                        $result = M ('payout')->add ($data);
                        if (!$result){
                            $this->error ('导入数据库失败',U('turnListToBankPage'),0);
                        } else {

                            if (payoutOrderApply($this->user['member_list_userinfoid'],$v[6],$free)) {
                                //写入日志信息
                                $content = '出金记录写入成功。订单号：' . $payout_orderid . '###出金金额' . $v[6] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                                $logResult = addLog($this->user['member_list_id'], 1, 'payout', '单笔出金', $content);
                            } else {
                                //写入失败日志信息
                                $content = '出金记录写入失败。订单号：' . $payout_orderid . '###出金金额' . $v[6] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                                $logResult = addLog($this->user['member_list_id'], 2, 'payout', '单笔出金', $content);

                                $this->error('出金信息提交失败', U('turnFoOrderPage'), 0);
                            }
                        }
                    }
                }
                $this->success ('导入数据库成功',U('turnListToBankPage'),1);
            } else{
                //刪除excel文件
                unlink($filename);
                $this->error('可用餘額不足，請核對后從新提交！', U('turnListToBankPage'), 0);
            }

        } else if(IS_POST AND IS_AJAX) {

            $id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = getBankName($payout_audit['bankname']);
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['remark'] = $payout_audit['remark'];
            $sl_data['ok'] = 1;
            $this->ajaxReturn($sl_data, 'json');

        }else{
            $key = I('key');
//                $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
            $begin_time = I('begin_time', '');
            $end_time = I('end_time', '');
            if (empty($begin_time) and empty($end_time)) {
                $begin_time = date('Y-m-d');
                $end_time = date('Y-m-d');
            }
            $sldate = $begin_time . ' - ' . $end_time;
            if (strpos($sldate, '+')) {
                $sldate = preg_replace('/\+/', ' ', $sldate);
            }
            $arr = explode(" - ", $sldate);//转换成数组
            if (count($arr) == 2) {
                $arrdateone = strtotime($arr[0]);
                $arrdatetwo = strtotime($arr[1] . ' 23:55:55');
                $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
            }
            $map['payout_orderid'] = array('like', "%" . $key . "%");
            $map['uid'] = $this->user['member_list_userinfoid'];
            $map['status'] = 0;
            $map['type'] = 4;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();
            $this->assign('sldate', $sldate);
            $this->assign('keyy', $key);
            $this->assign('audit_list', $audit_list);
            $this->assign('page', $show);
            $this->assign('val', $key);
            $this->display();

        }

    }

    function audit()
    {
        if (IS_POST AND IS_AJAX) {
            $payout_id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $payout_id))->find();
            $sl_data['payout_id'] = $payout_id;
            $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = getBankName($payout_audit['bankname']);
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['status'] = $payout_audit['status'];
            $this->ajaxReturn($sl_data, 'json');
        } else {
            $key = I('key');
//            $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
            $begin_time = I('begin_time', '');
            $end_time = I('end_time', '');
            if (empty($begin_time) and empty($end_time)) {
                $begin_time = date('Y-m-d');
                $end_time = date('Y-m-d');
            }
            $sldate = $begin_time . ' - ' . $end_time;
            if (strpos($sldate, '+')) {
                $sldate = preg_replace('/\+/', ' ', $sldate);
            }
            $arr = explode(" - ", $sldate);//转换成数组
            if (count($arr) == 2) {
                $arrdateone = strtotime($arr[0]);
                $arrdatetwo = strtotime($arr[1] . ' 23:55:55');
                $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
            }
            $map['type'] = 4;
            $map['batchnum|reaccname|reaccno'] = array('like', "%" . $key . "%");
            $map['uid'] = $this->user['member_list_userinfoid'];
            $map['status'] = 0;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();
            $this->assign('sldate', $sldate);
            $this->assign('keyy', $key);
            $this->assign('audit_list', $audit_list);
            $this->assign('page', $show);
            $this->assign('val', $key);
            $this->display();

        }


    }

    function runaudit()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('turnFoOrderPage'), 0);
        } else {
            $status = I('status');
            $end_time = time();
            $transfermoney = I('transfermoney');
            $free = I('free');
            $remark = I('remark');
            $userinfo = M('userinfo');
            $userinfo_list = $userinfo->where(array('user_id' => I('uid')))->find();
            //通过是1 修改状态便可
            if (I('status') == 1) {
                $sl_data = array(
                    'payout_id' => I('payout_id'),
                    'audit_time' => $end_time,
                    'remark' => $remark,
                    'status' => $status,
                );
                $rst = M('payout')->save($sl_data);
                if ($rst !== false) {
                    $this->success('订单审核完毕', U('turnFoOrderPage'), 1);
                } else {
                    $this->error('订单审核失败', U('turnFoOrderPage'), 0);
                }
            }

            if (I('status') == 2) {
                //失败2  归还用户资金
                //归还出金金额以及手续费，并更新userinfo表的总额
                $sumcount = $userinfo_list['sumcount'] + $transfermoney + $free;  //总金额
                $availablecount = $userinfo_list['availablecount'] + $transfermoney + $free; //可用余额
                $unsettlement = $userinfo_list['unsettlement'] - $transfermoney - $free; //未结算金额

                //更新userinfo表的可用余额，总金额，未结算金额
                $userinfo_data = array(
                    'sumcount' => $sumcount,
                    'availablecount' => $availablecount,
                    'unsettlement' => $unsettlement,
                );

                $u_userinfo = $userinfo->where(array('user_id' => I('uid')))->save($userinfo_data);
                if ($u_userinfo) {
                    //更新订单状态
                    $sl_data = array(
                        'payout_id' => I('payout_id'),
                        'audit_time' => $end_time,
                        'remark' => $remark,
                        'status' => $status,
                    );
                    $rst = M('payout')->save($sl_data);
                    if ($rst !== false) {
                        $this->success('訂單審核完畢', U('turnFoOrderPage'), 1);
                    } else {
                        $this->error('訂單審核失敗', U('turnFoOrderPage'), 0);
                    }
                }
            }

        }

    }


    public function turnFoOrderPage()
    {
        //出金员显示所有
        if (IS_AJAX) {
            $id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
            $sl_data['currency_id'] = $payout_audit['currency_id'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = $payout_audit['bankname'];
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['ok']=1;
            $this->ajaxReturn($sl_data, 'json');
        } else {
            $key = I('key');
            $mid = I('mid');
            $payment_id = I('payment_id');
            if ($mid) {
                $map['uid'] = $mid;
            }
            if ($payment_id) {
                $map['payment_id'] = $payment_id;
            }
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
            $map['type'] = 4;

            $map['payout_orderid'] = array('like', "%" . $key . "%");;
            $map['status'] = array('like', "%" . $key . "%");
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $payout_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payout_id desc')->select();
            $payout_list_e = M('payout')->where($map)->order('begin_time desc')->select();

            $num = "";
            $a_OrderMoney = "";
            $a_free = "";
            foreach ($payout_list_e as $k => $r) {
                if ($r['status'] == '4') {
                    $num = $num + 1;
                    $a_OrderMoney = $a_OrderMoney + $r['transfermoney'];
                    $a_free = $a_free + $r['free'];
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
            $this->assign('num', $num);
            $this->assign('a_OrderMoney', $a_OrderMoney);
            $this->assign('a_free', $a_free);
            $this->assign('midd', $mid);

            $payment_list = M('payment_name')->order('api_id desc')->select();
            $this->assign('payment_list', $payment_list);

            $this->assign('payment_idd', $payment_id);
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
            $p = I('p');
            $ids = I('n_id');
            if($ids){
                if(is_array($ids)){//判断获取文章ID的形式是否数组
                    $where = 'payout_id in('.implode(',',$ids).')';
                }else{
                    $where = 'payout_id='.$ids;
                }
                M('payout')->where($where)->setField('status',3);//转入回收站
                $this->success("成功转移到处理中！",U('turnFoAuditOrderPage',array('p'=>$p)),1);
                die();
            }
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
            $sl_data['currency_id'] = $payout_audit['currency_id'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = $payout_audit['bankname'];
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['ok']=1;
            $this->ajaxReturn($sl_data, 'json');
        } else {

            $key = I('key');
            $map['payout_orderid|uid'] = array('like', "%" . $key . "%");
            $map['status'] = 1;
            $map['type'] = 4;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payout_id desc')->select();
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
            $this->error('提交方式不正确', U('turnFoAuditOrderPage'), 0);
        } else {
            $status = I('status');
            if ($status ==5) {
                //归还出金金额以及手续费，并更新userinfo表的总额
            }
            $sl_data = array(
                'payout_id' => I('payout_id'),
                'audit_time'=>time(),
                'result_time'=>time(),
                'status' => I('status'),
            );
            $rst = M('payout')->save($sl_data);
            if ($rst !== false) {
                $this->success('订单审核成功', U('turnFoAuditOrderPage'), 1);
            } else {
                $this->error('订单审核失败', U('turnFoAuditOrderPage'), 0);
            }
        }

    }
    public function turnFoOrderIng()
    {
        //把订单送入处理成功   处理失败 状态  顺带扣款
        if (IS_POST and IS_AJAX) {
            $id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['uid'] = $payout_audit['uid'];
            $sl_data['payout_mid'] = $payout_audit['payout_mid'];
            $sl_data['attribute'] = $payout_audit['attribute'];
            $sl_data['payout_orderid'] = $payout_audit['payout_orderid'];
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['currency_id'] = $payout_audit['currency_id'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = $payout_audit['bankname'];
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
            $map['type'] = 4;
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = getpage($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payout_id desc')->select();

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
            $this->error('提交方式不正确', U('turnFoOrderIng'), 0);
        } else {
            $status = I('status');
            $end_time = time();
            $transfermoney = I('transfermoney');
            $currency_id = I('currency_id');
            $free = I('free');
            $remark = I('remark');
            $user_id = I('uid');
            $attribute = I('attribute');

            $balance = M('user_balance');
            $balance_list = $balance->where(array('user_id' => I('uid')))->find();
            $sumcount = $balance_list['sumcount'];  //总金额
            if ($status ==4) {
                //扣去出金金额以及手续费，并更新userinfo表的总额
                $sumcount = $balance_list['sumcount'] - $transfermoney - $free;  //总金额
                $unsettlement = $balance_list['unsettlement'] - $transfermoney - $free; //未结算金额
                $userinfo_data = array(
                    'sumcount' =>$sumcount,
                    'unsettlement' => $unsettlement,
                );
                $u_userinfo = $balance->where(array('user_id' => I('uid')))->save($userinfo_data);
                if ($u_userinfo) {
                    //写入交易记录中
                    $order_log_data_transfermoney = array(
                        'uid' => I('uid'),
                        'orderid' => I('payout_orderid'),
                        't_type' => '4',
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
                            'orderid' => I('payout_orderid'),
                            't_type' => 5,
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
                        $this->success('出金成功', U('turnFoOrderIng'), 1);
                    } else {
                        $this->error('出金保存失败', U('turnFoOrderIng'), 0);
                    }


                }

            }
            if ($status ==5) {
                //归还出金金额以及手续费，并更新userinfo表的总额
                $sumcount = $balance_list['sumcount'] + $transfermoney + $free;  //总金额
                $availablecount = $balance_list['availablecount'] + $transfermoney + $free; //可用余额
                if ($balance_list['unsettlement']>0) {
                    $unsettlement = $balance_list['unsettlement'] - $transfermoney - $free; //未结算金额
                }else{
                    $fp = @fopen("unsettlement_error.txt", "a+");
                    fwrite($fp, I('payout_id'));
                    fclose($fp);
                    $this->error('账户错误，请联系管理员紧急处理！', U('turnFoOrderIng'), 0);
                }
                //更新userinfo表的可用余额，总金额，未结算金额
                $userinfo_data = array(
                    'availablecount' => $availablecount,
                    'unsettlement' => $unsettlement,
                );

                $sl_data = array(
                    'payout_id' => I('payout_id'),
                    'audit_time'=>time(),
                    'result_time'=>$end_time,
                    'status' => I('status'),
                    'remark' => $remark,
                );

                $u_userinfo = $balance->where(array('user_id' => $user_id,'currency_id'=>$currency_id))->save($userinfo_data);

                if ($u_userinfo) {
                    //歸還賬戶子賬戶餘額
                    $sub_user_balance = M('sub_user_balance')->where(array('user_id' => $user_id,  'attribute' => $attribute))->find();

                    if ($sub_user_balance) {
                        $sub_balance = $sub_user_balance['sub_user_balance']+$transfermoney + $free;

                        $sub_result = M('sub_user_balance')->where(array('user_id' => $user_id, 'attribute' => $attribute))->save(array('sub_user_balance'=>$sub_balance));
                        if ($sub_result) {
                            //更新订单记录
                            $rst = M('payout')->save($sl_data);
                            if ($rst !== false) {
                                $this->success('订单修改状态成功', U('turnFoOrderIng'), 1);
                            } else {
                                $this->error('订单修改状态失败', U('turnFoOrderIng'), 0);
                            }
                        } else {
                            $fp = @fopen("payout_order_ing_sub_error.txt", "a+");
                            fwrite($fp, var_export($sl_data, true));
                            fclose($fp);
                            $this->error('子账号修改失败，请联系管理员紧急处理！', U('turnFoOrderIng'), 0);
                        }

                    } else {
                        $fp = @fopen("payout_order_ing_sub.txt", "a+");
                        fwrite($fp, var_export($sl_data, true));
                        fclose($fp);
                        $this->error('订单查询失败，请联系管理员紧急处理！', U('turnFoOrderIng'), 0);
                    }

                } else {

                    $fp = @fopen("payout_order_ing_error.txt", "a+");
                    fwrite($fp, var_export($sl_data, true));
                    fclose($fp);
                    $this->error('处理失败，请联系管理员紧急处理！', U('turnFoOrderIng'), 0);
                }
            }


        }

    }
    //货币兑款
    function exchange()
    {
        $this->display();
    }
    //结算申请
    function addOrder()
    {
        if (IS_POST) {

        } else {
            $this->display();
        }

    }

//结算审核
    function auditOrder()
    {
        $this->display();
    }
//结算清单
    function listOrder()
    {
        $this->display();
    }


}