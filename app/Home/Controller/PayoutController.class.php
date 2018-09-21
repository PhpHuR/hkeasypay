<?php
/**
 * Date: 2016/9/12
 * Time: 22:03
 */

namespace Home\Controller;

use Org\Util\Stringnew;
use Home\Controller\HomebaseController;

class PayoutController extends HomebaseController
{
    public function turnOneToBankPage()
    {

        if (IS_POST) {
            //获取商户信息

            if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                $currency_id = '3';
            }else{
                $currency_id = '1';
            }
            $transfermoney = I('transfermoney');
            $cnymoney = I('cnymoney');
            if ($transfermoney < 1) {
                $this->error('請填寫正確的訂單金額！', U('turnOneToBankPage'), 0);
            }
            $user_balance = M('user_balance')->where(array('user_id' => $this->user['member_list_userinfoid'], 'currency_id' => $currency_id));
            $user = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();
            $user_balance_list = $user_balance->find();
            $sub_user_balance_list = M('sub_user_balance')->where(array('sub_balance_id' => I('sub_balance')))->find();
            if ($sub_user_balance_list) {
                $sub_sumcount = $sub_user_balance_list['sub_user_balance'];
                $attribute = $sub_user_balance_list['attribute'];
                $mid = $sub_user_balance_list['m_id'];
            } else {
                $this->error('請選擇子賬戶', U('turnOneToBankPage'), 0);
            }
            $sumcount = floatval($user_balance_list['sumcount']);  //总金额
            $availablecount = floatval($user_balance_list['availablecount']); //可用余额
            //获取出金手续费
            $payout_rate_list = getPayoutRate($user['payout_rate']);
            $free = floatval($payout_rate_list['outrate']); //手续费
            $free_c = floatval($payout_rate_list['outrate'] - $payout_rate_list['outprice']); //公司佣金
            $free_ag = floatval($payout_rate_list['outrate'] - $payout_rate_list['outprice']); //代理佣金
            $outmax = floatval($payout_rate_list['outmax']);
            //确认是否可以出金
            $oneTransferMoney = getOrderNumber($transfermoney, $outmax);
            $cnyTransferMoney = getOrderNumber($cnymoney,$outmax);
            $payout_num = count($oneTransferMoney);
            //计算总的出金费率
            $allfree = $free * $payout_num;
            $alltransfermoney = $allfree + $transfermoney;
//            dump($alltransfermoney);die;
            if ($alltransfermoney <= $availablecount && $alltransfermoney <= $sub_sumcount) {
                //单笔超过最大限额，拆分订单
                if ($payout_num > 1) {
                    //拆分出金数量
                    $availablecount = $user_balance_list['availablecount'] - $transfermoney - $allfree; //可用余额
                    $unsettlement = $user_balance_list['unsettlement'] + $transfermoney + $allfree; //未结算金额
                    $userinfo_data = array(
                        'availablecount' => $availablecount,
                        'unsettlement' => $unsettlement,
                    );
                    if (payoutSubUserBalanceUpdate(I('sub_balance'), $transfermoney + $allfree)) {
                        $u_userinfo = $user_balance->where(array('user_id' => $this->user['member_list_userinfoid'], 'currency_id' => $currency_id))->save($userinfo_data);
                    } else {
                        $this->error('子賬戶餘額不夠，請重新填寫訂單！', U('turnOneToBankPage'), 0);
                    }
                    if ($u_userinfo) {
                        for ($i = 0; $i < $payout_num; $i++) {
                            //批量插入数据库
                            $payout_orderid = 'o' . createOrder($this->user['member_list_id']);
                            $batchnum = $this->user['member_list_id'] . 'o' . 'p' . date('YmdHis');
                            if(in_array($this->user['member_list_userinfoid'],C("TMPL_HKD"))){
                                $cnyTransferMoney_hkd = cursell_cny($cnyTransferMoney[$i],$this->user['member_list_userinfoid']);
                                $payout_data = array(
                                    'uid' => $this->user['member_list_userinfoid'],
                                    'member_name' => $user['member_name'],
                                    'payout_orderid' => $payout_orderid,
                                    'payout_mid' => $mid,
                                    'attribute' => $attribute,
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
                                    'transfermoney_hkd' => $oneTransferMoney[$i],
                                    'transfermoney' => isset($cnyTransferMoney_hkd) ? $cnyTransferMoney_hkd : 0,
                                    'status' => 1,
                                    'free' => $free,
                                    'payout_commission_c' => $free_c,
                                    'payout_commission_ag' => $free_ag,
                                    'begin_time' => time(),
                                    'remark' => I('remark'),
                                );
                            }else{
                                $payout_data = array(
                                    'uid' => $this->user['member_list_userinfoid'],
                                    'member_name' => $user['member_name'],
                                    'payout_orderid' => $payout_orderid,
                                    'payout_mid' => $mid,
                                    'attribute' => $attribute,
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
                                    'payout_commission_c' => $free_c,
                                    'payout_commission_ag' => $free_ag,
                                    'begin_time' => time(),
                                    'remark' => I('remark'),
                                );
                            }

                            //存入数据到表单
                            if (checkPayoutOrderId($payout_orderid)) {
                                if (M('payout')->add($payout_data)) {

                                    //發送給自己組

                                    $userChatId = getChatId($this->user['member_list_userinfoid'],1);
                                    if (isset($userChatId)) {
                                        if(in_array($this->user['member_list_userinfoid'],C('TMPL_HKD'))){
                                            $message_master = "<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: hkd " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";
                                        }else{
                                            $message_master = "<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: CNY " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";
                                        }
                                        telegramSendMessage($userChatId, $message_master,2);
                                    }

                                    $chatId_master = '-180465380';
                                    if(in_array($this->user['member_list_userinfoid'],C('TMPL_HKD'))){
                                        $message_master = "<code>供應商: " . getPaymentName($user['payout_id']) . "</code>%0A<code>MID: " . getMidName($user['payout_mid']) . "</code>%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: hkd " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";

                                    }else{
                                        $message_master = "<code>供應商: " . getPaymentName($user['payout_id']) . "</code>%0A<code>MID: " . getMidName($user['payout_mid']) . "</code>%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: CNY " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";

                                    }

                                    telegramSendMessage($chatId_master, $message_master,2);


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
                    if(in_array($this->user['member_list_userinfoid'],C('TMPL_HKD'))){
                        $payout_data = array(
                            'uid' => $this->user['member_list_userinfoid'],
                            'member_name' => $user['member_name'],
                            'payout_mid' => $mid,
                            'attribute' => $attribute,
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
                            'transfermoney_hkd' => $transfermoney,
                            'transfermoney' => $cnymoney,
                            'status' => 1,
                            'free' => $free,
                            'payout_commission_c' => $free_c,
                            'payout_commission_ag' => $free_ag,
                            'begin_time' => time(),
                            'remark' => I('remark'),
                        );
                    }else{
                        $payout_data = array(
                            'uid' => $this->user['member_list_userinfoid'],
                            'member_name' => $user['member_name'],
                            'payout_mid' => $mid,
                            'attribute' => $attribute,
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
                            'payout_commission_c' => $free_c,
                            'payout_commission_ag' => $free_ag,
                            'begin_time' => time(),
                            'remark' => I('remark'),
                        );
                    }

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
                        if (payoutSubUserBalanceUpdate(I('sub_balance'), $transfermoney + $allfree)) {
                            $u_userinfo = $user_balance->where(array('user_id' => $this->user['member_list_userinfoid'], 'currency_id' => $currency_id))->save($userinfo_data);
                        } else {
                            $this->error('子賬戶餘額不夠，請重新填寫訂單！', U('turnOneToBankPage'), 0);
                        }

                        if ($u_userinfo) {
                            //發送給自己組
                            $userChatId = getChatId($this->user['member_list_userinfoid'],1);

                            if (isset($userChatId)) {
                                if(in_array($this->user['member_list_userinfoid'],C('TMPL_HKD'))){
                                    $message_master = "%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: HKD " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";

                                }else{
                                    $message_master = "%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: CNY " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";

                                }

                                telegramSendMessage($userChatId, $message_master,2);

                            }

                                $chatId_master = '-180465380';
                                if(in_array($this->user['member_list_userinfoid'],C('TMPL_HKD'))){

                                    $message_master = "<code>供應商: " . getPaymentName($user['payout_id']) . "</code>%0A<code>MID: " . getMidName($user['payout_mid']) . "</code>%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: hkd " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";
                                }else{
                                    $message_master = "<code>供應商: " . getPaymentName($user['payout_id']) . "</code>%0A<code>MID: " . getMidName($user['payout_mid']) . "</code>%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: CNY " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";
                                }
                                $message_master = "<code>供應商: " . getPaymentName($user['payout_id']) . "</code>%0A<code>MID: " . getMidName($user['payout_mid']) . "</code>%0A<code>銀行:" . getBankName(I('bankname')) . "</code>%0A<code>收款人: " . I('reaccname') . "</code>%0A<code>銀行賬號: " . I('reaccno') . "</code>%0A<code>金額: CNY " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $user['member_name'] . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $payout_orderid . "</code>";

                                telegramSendMessage($chatId_master, $message_master,2);




                            //写入日志信息
                            $content = '出金记录写入成功。订单号：' . $payout_orderid . '###出金金额' . $transfermoney . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                            $logResult = addLog($this->user['member_list_id'], 1, 'payout', '单笔出金', $content);

                            $this->success('出金信息提交成功', U('turnFoOrderPage'), 1);
                        } else {
                            //写入失败日志信息
                            $content = '出金记录写入失败。订单号：' . $payout_orderid . '###出金金额' . $transfermoney . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                            $logResult = addLog($this->user['member_list_id'], 2, 'payout', '单笔出金', $content);
                            $this->error('出金信息提交失败', U('turnFoOrderPage'), 0);
                        }
                    }

                }

            } else {
                $this->error('可用金额不足，请核对金额总数重新提交！', U('turnOneToBankPage'), 0);
            }
        } else {
            //获取用户配置信息
            $province = M('region')->where(array('parent_id' => 0, 'level' => 1))->select();
            $this->assign('province', $province);
            //
            $currency_list = M('currency')->select();
            $this->assign('currency_list', $currency_list);
            //
            $userinfo = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();  //获取用户的配置信息
            //获取出款的费率配置
            //子賬戶餘額
            $sub_balance_list = M('sub_user_balance')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();
            $this->assign('sub_balance_list', $sub_balance_list);

            $payout_rate_list = M('payout_rate')->where(array('payout_rate_id' => $userinfo['payout_rate']))->find();
            $payout_rate = $payout_rate_list['outrate'];
            $this->assign('payout_rate', $payout_rate);
            $this->assign('userinfo', $userinfo);
            if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                $this->display("turnOneToBankPage-hkd");
                die;
            }
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
            $upload->savePath = $this->user['member_list_userinfoid'] . '/' . $this->user['member_list_id'] . '/'; // 设置附件上传（子）目录  I('p_id').' /'.I('memberid')
            $upload->autoSub = true;//自动使用子目录保存上传文件
            $upload->saveName = '';//上传文件的保存规则
            $upload->subName = date('Ymd');
            $upload->saveRule = '';
            // 上传文件
            $info = $upload->uploadOne($_FILES['file_stu']);
            $filename = './public/Excel/' . $info['savepath'] . $info['savename'];
            $exts = $info['ext'];
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功
                $res = $this->read($filename, $exts);
            }
            if (!$res) {
                $this->error('数据处理失败', U('turnListToBankPage'), 0);
            }
            //获取商户信息
            $userinfo = M('user_balance')->where(array('user_id' => $this->user['member_list_userinfoid'], 'currency_id' => 1));
            $user = M('userinfo')->where(array('user_id' => $this->user['member_list_userinfoid']))->find();
            $userinfo_list = $userinfo->find();
            $sumcount = floatval($userinfo_list['sumcount']);  //总金额
            $availablecount = floatval($userinfo_list['availablecount']); //可用余额
            $unsettlement = floatval($userinfo_list['unsettlement']); //未结算金额
            //獲取子賬戶
            $sub_user_balance_list = M('sub_user_balance')->where(array('sub_balance_id' => I('sub_balance')))->find();
            if ($sub_user_balance_list) {
                $sub_sumcount = $sub_user_balance_list['sub_user_balance'];
                $attribute = $sub_user_balance_list['attribute'];
                $mid = $sub_user_balance_list['m_id'];
            } else {
                unlink($filename);
                $this->error('請選擇子賬戶', U('turnListToBankPage'), 0);
            }
            //获取出金手续费
            $payout_rate_list = getPayoutRate($user['payout_rate']);
            $free = floatval($payout_rate_list['outrate']); //手续费
            $free_c = floatval($payout_rate_list['outrate'] - $payout_rate_list['outprice']); //公司佣金
            $free_ag = floatval($payout_rate_list['outrate'] - $payout_rate_list['outprice']); //代理佣金
            $outmax = floatval($payout_rate_list['outmax']);
            //确认是否可以出金
            $countProName = array_column($res, 2);
            $countCityName = array_column($res, 3);
            $countBankName = array_column($res, 5);
            $countMoney = array_column($res, 6);

//            if (count($res) > 20) {
//                unlink($filename);
//                $this->error('單次允許最多20條數據，請核對后從新提交！', U('turnListToBankPage'), 0);
//            }
            $num = count($countMoney) - 1;
            $all = array_sum($countMoney) + $free * $num;

            if ($all <= $availablecount && $all <= $sub_sumcount) {
                for ($i = 1; $i < count($countMoney); $i++) {
                    //循環檢查excel最大金額
                    if ($countMoney[$i] > $outmax) {
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
                foreach ($res as $k => $v) {
                    if ($k != 1) {
                        $payout_orderid = 'o' . createOrder($this->user['member_list_id']);
                        $batchnum = $this->user['member_list_id'] . 'o' . 'p' . date('YmdHis');
                        $data ['uid'] = $this->user['member_list_userinfoid'];
                        $data ['member_name'] = $user['member_name'];
                        $data ['payout_mid'] = $mid;
                        $data ['attribute'] = $attribute;
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
                        $data ['payout_commission_c'] = $free_c;
                        $data ['payout_commission_ag'] = $free_ag;
                        $data ['status'] = 1;
                        $data ['begin_time'] = $begin_time;
                        $data ['remark'] = $v[7];
                        $result = M('payout')->add($data);
                        if (!$result) {
                            $this->error('导入数据库失败', U('turnListToBankPage'), 0);
                        } else {
                            if (payoutSubUserBalanceUpdate(I('sub_balance'), $v[6] + $free)) {
                                if (payoutOrderApply($this->user['member_list_userinfoid'], 1, $v[6], $free)) {
                                    //写入日志信息
                                    $content = '出金记录写入成功。订单号：' . $payout_orderid . '###出金金额' . $v[6] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                                    $logResult = addLog($this->user['member_list_id'], 1, 'payout', '批量出金', $content);
                                } else {
                                    //写入失败日志信息
                                    $content = '出金记录写入失败。订单号：' . $payout_orderid . '###出金金额' . $v[6] . '###手续费' . $free . '###总额：' . $sumcount . '###可用余额：' . $availablecount . '###未结算金额：' . $unsettlement . '';
                                    $logResult = addLog($this->user['member_list_id'], 2, 'payout', '批量出金', $content);

                                    $this->error('出金信息提交失败', U('turnFoOrderPage'), 0);
                                }
                            } else {
                                $this->error('子賬戶餘額不夠，請重新填寫訂單！', U('turnListToBankPage'), 0);
                            }
                        }
                    }
                }
                $this->success('导入数据库成功', U('turnListToBankPage'), 1);
            } else {
                //刪除excel文件
                unlink($filename);
                $this->error('可用餘額不足，請核對后從新提交！', U('turnListToBankPage'), 0);
            }

        } else {
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
            $map['status'] = 1;
            $map['type'] = 2;
            $map['_logic'] = 'AND';
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $audit_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('begin_time desc')->select();
//            装换余额
            //子賬戶餘額
            $sub_balance_list = M('sub_user_balance')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();
            $this->assign('sub_balance_list', $sub_balance_list[0]['sub_user_balance']);

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
            $map['batchnum|reaccname|reaccno'] = array('like', "%" . $key . "%");
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


    function turnFoOrderPage()
    {
        //公共页面，判断权限
        if (IS_POST and IS_AJAX) {
            $id = I('id');
            $payout_audit = M('payout')->where(array('payout_id' => $id))->find();
            $sl_data['payout_id'] = $id;
            $sl_data['batchnum'] = $payout_audit['batchnum'];
            $sl_data['reaccname'] = $payout_audit['reaccname'];
            $sl_data['reaccno'] = $payout_audit['reaccno'];
            $sl_data['bankname'] = getBankName($payout_audit['bankname']);
            $sl_data['transfermoney'] = $payout_audit['transfermoney'];
            $sl_data['free'] = $payout_audit['free'];
            $sl_data['remark'] = $payout_audit['remark'];
            $sl_data['ok'] = 1;
            $this->ajaxReturn($sl_data, 'json');
        } else {
            $key = I('key');
            $status = I('status', '');
            $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
//            $begin_time = I('begin_time', '');
//            $end_time = I('end_time', '');
            if (empty($sldate)) {
                $begin_time = date('Y-m-d');
                $end_time = date('Y-m-d');
                $sldate = $begin_time . ' - ' . $end_time;
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
            if ($status != '') {
                $map['status'] = array('eq', $status);
            }
            $map['payout_orderid|reaccname|reaccno'] = array('like', "%" . $key . "%");
            $map['uid'] = $this->user['member_list_userinfoid'];
            $map['_logic'] = 'AND';
            /*
             * 分页操作
             */
            $count = M('payout')->where($map)->count();// 查询满足要求的总记录数
            $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
            $show = $Page->show();// 分页显示输出
            $payout_list = M('payout')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('payout_id desc')->select();
            $payout_list_e = M('payout')->where($map)->order('payout_id desc')->select();

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
            if ($action == 'export') {
                if (!$payout_list_e) {
                    $this->error('没有搜索结果，无法导出数据');
                }
                $this->goods_export($payout_list_e, 'turnFoOrderPage');
            }

            $this->assign('num', $num);
            $this->assign('a_OrderMoney', $a_OrderMoney);
            $this->assign('a_free', $a_free);

            $this->assign('status', $status);
            $this->assign('sldate', $sldate);
            $this->assign('keyy', $key);
            $this->assign('payout_list', $payout_list);
            $this->assign('page', $show);
            $this->assign('val', $key);
            if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                $this->display('turnFoOrderPage-hkd');
            }else{
                $this->display();
            }

        }

    }

    function orderinfo()
    {
        $id = I('id');
        $info = M('payout')->where(array('payout_id' => $id))->find();
        if ($info) {
            $this->assign('order_info', $info);
            if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
                $this->display("orderinfo-hkd");
            }else{
                $this->display();
            }
        } else {
            $this->display();
        }
    }

//导出数据方法
    function goods_export($goods_list = array(), $filename)
    {
//        print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][begin_time] = '' . ' ' . date('Y-m-d H:i:s', $goods_info['begin_time']);
            $data[$k][result_time] = '' . ' ' . is_null($goods_info['result_time']) ? '' : date('Y-m-d H:i:s', $goods_info['result_time']);
            $data[$k][payout_orderid] = '' . ' ' . $goods_info['payout_orderid'];
            $data[$k][bankname] = '' . ' ' . getBankName($goods_info['bankname']);
            $data[$k][reaccname] = '' . ' ' . $goods_info['reaccname'];
            $data[$k][reaccno] = '' . ' ' . $goods_info['reaccno'];
            $data[$k][proname] = getRegionName($goods_info['proname']);
            $data[$k][cityname] = getRegionName($goods_info['cityname']);
            $data[$k][reaccdept] = $goods_info['reaccdept'];
            $data[$k][transfermoney] = '' . ' ' . number_format($goods_info['transfermoney'], 2, '.', ',');
            $data[$k][free] = '' . ' ' . number_format($goods_info['free'], 2, '.', ',');
            $data[$k][status] = getPayoutStatusName($goods_info['status']);
            $data[$k][remark] = '' . ' ' . $goods_info['remark'];
        }
        //print_r($goods_list);
//        print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'begin_time') {
                $headArr[] = '創建時間';
            }

            if ($field == 'result_time') {
                $headArr[] = '成功時間';
            }

            if ($field == 'payout_orderid') {
                $headArr[] = '客戶訂單號碼';
            }

            if ($field == 'bankname') {
                $headArr[] = '收款銀行';
            }

            if ($field == 'reaccname') {
                $headArr[] = '收款人名';
            }

            if ($field == 'reaccno') {
                $headArr[] = '銀行帳號';
            }


            if ($field == 'proname') {
                $headArr[] = '省';
            }

            if ($field == 'cityname') {
                $headArr[] = '市';
            }
            if ($field == 'reaccdept') {
                $headArr[] = '開戶網點';
            }

            if ($field == 'transfermoney') {
                $headArr[] = '出金金額';
            }

            if ($field == 'free') {
                $headArr[] = '出金手續費';
            }

            if ($field == 'status') {
                $headArr[] = '狀態';
            }
            if ($field == 'remark') {
                $headArr[] = '備註';
            }

        }

        $filename = $filename;

        getExcel($filename, $headArr, $data);
    }

    /**
     * Excel 读取转换成为数组
     * @param $filename
     * @param string $encode
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    private function read($filename, $encode = 'utf-8')
    {
        import("Org.Util.PHPExcel");
        $PHPExcel = new \PHPExcel();
        import("Org.Util.PHPExcel.Reader.Excel5");
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
                $excelData[$row][] = (string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }


}