<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/13
 * Time: 10:28
 */

namespace Home\Controller;


class CheckController extends HomebaseController
{
    public function check_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $check_data = M('check_list')->where(array('u_id'=>$uid))->find();
        $wallet_data = M('wallet_list')->where(array('user_id'=>$uid))->field('money')->find();
        if(IS_POST){
            $money = I('money');
            if(isset($money)){
                $int_count = intval($money/$check_data['money_num']);
                if($int_count == 0){
                    $this->error('请填写足够的金额',U('check_list'),0);
                }
                if($money > $wallet_data['money']){
                    $this->error('可用餘額不夠，請重新核對金額後填寫！',U('check_list'),0);
                }
//                增加条数
                $yx_count = $check_data['number'] + $int_count;
                //条数乘以单价
                $ch_money = $int_count * $check_data['money_num'];
//                扣除钱包余额
                $yx_money = $wallet_data['money'] - $ch_money;

//                组装数据
                $data1 = array('money' =>$yx_money);
                $data2 = array('number' =>$yx_count,);
                $res1 = M('wallet_list')->where(array('user_id'=>$uid))->save($data1);

                if(!$res1){
                    $this->error('扣除金额失败',U('check_list'),0);
                }
                $res2 = M('check_list')->where(array('u_id'=>$uid))->save($data2);
                if($res2){
                    //写入日志信息
                    $recharge_id = 'r'.createOrder($uid);
                    $content = '充值条数记录写入成功。订单号：' . $recharge_id . '###充值条数' . $yx_count .'钱包金额'.$yx_money;
                    $logResult = recharge_addLog($uid,$recharge_id, 1, 'check', '充值金额', $content);
                    $this->success('成功充值',U('check_list'), 1);
                }else{
                    $recharge_id = 'r'.createOrder($uid);
                    $content = '充值条数记录写入失败。订单号：' . $recharge_id . '###充值条数' . $yx_count .'钱包金额'.$yx_money;
                    $logResult = recharge_addLog($uid,$recharge_id, 2, 'check', '充值金额', $content);
                    $this->error('充值失敗',U('check_list'),0);
                }
            }else{
                $this->error('请填写充值金额',U('check_list'),0);
            }
        }
        $this->assign('wallet_data',$wallet_data);
        $this->assign('check_data',$check_data);
        $this->display();
    }

    public function idcard_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $datatime = I('reservation');
        if($datatime){
            $arr = explode(" - ",$datatime);
            $begin_time = strtotime($arr[0]);
            $end_time = strtotime($arr[1]);
            $map['datetime'] = array(array('egt', $begin_time), array('elt', $end_time), 'AND');

        }else{
            $begin_time = time() - 2592000;
            $end_time = time();
            $datatime = date('Y-m-d',$begin_time).' - '.date('Y-m-d',$end_time);
        }
        $map['user_id'] = $uid;
        $count = M('idcard')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $idcard_data = M('idcard')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('id desc')->select();
        $this->assign('page',$show);
        $this->assign('idcard_data',$idcard_data);
        $this->assign('sldate',$datatime);
        $this->display();
    }

    public function bankcard_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $datatime = I('reservation');
        if($datatime){
            $arr = explode(" - ",$datatime);
            $begin_time = strtotime($arr[0]);
            $end_time = strtotime($arr[1]);
            $map['datetime'] = array(array('egt', $begin_time), array('elt', $end_time), 'AND');

        }else{
            $begin_time = time() - 2592000;
            $end_time = time();
            $datatime = date('Y-m-d',$begin_time).' - '.date('Y-m-d',$end_time);
        }
        $map['user_id'] = $uid;
        $count = M('bankcard')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $bankcard_data = M('bankcard')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('id desc')->select();
        $this->assign('bankcard_data',$bankcard_data);
        $this->assign('page',$show);
        $this->assign('sldate',$datatime);
        $this->display();
    }
    public function fanqizha_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $datatime = I('reservation');
        if($datatime){
            $arr = explode(" - ",$datatime);
            $begin_time = strtotime($arr[0]);
            $end_time = strtotime($arr[1]);
            $map['datetime'] = array(array('egt', $begin_time), array('elt', $end_time), 'AND');

        }else{
            $begin_time = time() - 2592000;
            $end_time = time();
            $datatime = date('Y-m-d',$begin_time).' - '.date('Y-m-d',$end_time);
        }
        $map['user_id'] = $uid;
        $count = M('fanqizha')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $fanqizha_data = M('fanqizha')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('id desc')->field('realname,mobile,idcard,datetime,id')->select();
        $this->assign('fanqizha_data',$fanqizha_data);
        $this->assign('page',$show);
        $this->assign('sldate',$datatime);
        $this->display();
    }
    public function jiedai_list(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $datatime = I('reservation');
        if($datatime){
            $arr = explode(" - ",$datatime);
            $begin_time = strtotime($arr[0]);
            $end_time = strtotime($arr[1]);
            $map['datetime'] = array(array('egt', $begin_time), array('elt', $end_time), 'AND');
        }else{
            $begin_time = time() - 2592000;
            $end_time = time();
            $datatime = date('Y-m-d',$begin_time).' - '.date('Y-m-d',$end_time);
        }
        $map['user_id'] = $uid;
        $count = M('jiedai')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $jiedai_data = M('jiedai')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('id desc')->field('mobile,datetime,id')->select();

        $this->assign('jiedai_data',$jiedai_data);
        $this->assign('page',$show);
        $this->assign('sldate',$datatime);
        $this->display();
    }

    public function fanqizha_select(){
        $id = I('id');
        if(!$id){
            $this->error('请选择查看的订单',U('fanqizha_list'),0);
        }
        $fan_data = M('fanqizha')->where(array('id'=>$id))->find();
        switch ($fan_data['mobile_status_code']) {
            case $fan_data['mobile_status_code'] == '0':
                $fan_data['mobile_status_str'] = '正常使用';
                $fan_data['mobile_status_str'] = '正常使用';
                break;
            case $fan_data['mobile_status_code'] == 1:
                $fan_data['mobile_status_str'] = '停机';
                break;
            case $fan_data['mobile_status_code'] == 2:
                $fan_data['mobile_status_str'] = '在网但不可用';
                break;
            case $fan_data['mobile_status_code'] == 3:
                $fan_data['mobile_status_str'] = '不在网/销号/未启用/异常';
                break;
            case $fan_data['mobile_status_code'] == 4:
                $fan_data['mobile_status_str'] = '预销户';
                break;
            default:
                $fan_data['mobile_status_str'] = '';
        }

        switch ($fan_data['mobile_time_code']){
            case $fan_data['mobile_time_code'] == '(0,3]':
                $fan_data['mobile_time_str'] = '0-3个月';
                break;
            case $fan_data['mobile_time_code'] == '(3,6]':
                $fan_data['mobile_time_str'] = '3-6个月';
                break;
            case $fan_data['mobile_time_code'] == '(6,12]':
                $fan_data['mobile_time_str'] = '6-12个月';
                break;
            case $fan_data['mobile_time_code'] == '(12,24]':
                $fan_data['mobile_time_str'] = '12-24个月';
                break;
            case $fan_data['mobile_time_code'] == '(24,+)':
                $fan_data['mobile_time_str'] = '24个月以上';
                break;
            default:
                $fan_data['mobile_time_str'] = '';
        }
//是否查询到账号
        switch ($fan_data['found']){
            case $fan_data['found'] == 1:
                $fan_data['found_str'] = '是';
                break;
            case $fan_data['found'] == 2:
                $fan_data['found_str'] = '否';
                break;
            default:
                $fan_data['found_str'] = '';
        }
//风险
        switch ($fan_data['risk_code']) {
            case $fan_data['risk_code'] == 1001:
                $fan_data['risk__str'] = '信贷中介';
                break;
            case $fan_data['risk_code'] == 1002:
                $fan_data['risk__str'] = '存在违法行为';
                break;
            case $fan_data['risk_code'] == 1003:
                $fan_data['risk__str'] = '存在恶意申请操作';
                break;
            case $fan_data['risk_code'] == 1004:
                $fan_data['risk__str'] = '羊毛党';
                break;
            case $fan_data['risk_code'] == 1005:
                $fan_data['risk__str'] = '存在骗贷行为';
                break;
            case $fan_data['risk_code'] == 1006:
                $fan_data['risk__str'] = '失信名单';
                break;
            case $fan_data['risk_code'] == 1007:
                $fan_data['risk__str'] = '存在支付异常行为';
                break;
            case $fan_data['risk_code'] == 1008:
                $fan_data['risk__str'] = '疑似团伙骗贷';
                break;
            case $fan_data['risk_code'] == 1009:
                $fan_data['risk__str'] = '可能存在催债困难等风险';
                break;
            case $fan_data['risk_code'] == 1010:
                $fan_data['risk__str'] = '其他异常行为,如被盗风险较高、社交圈子不固定等   ';
                break;
            case $fan_data['risk_code'] == 2001:
                $fan_data['risk__str'] = '手机号归属地为高风险地区';
                break;
            case $fan_data['risk_code'] == 2002:
                $fan_data['risk__str'] = '身份证归属地为高风险地区';
                break;
            case $fan_data['risk_code'] == 2003:
                $fan_data['risk__str'] = '操作ip为高风险地区';
                break;
            case $fan_data['risk_code'] == 2004:
                $fan_data['risk__str'] = '所在地为高风险地区';
                break;
            case $fan_data['risk_code'] == 3001:
                $fan_data['risk__str'] = '设备使用过多身份证申请，疑似中介代办';
                break;
            case $fan_data['risk_code'] == 3002:
                $fan_data['risk__str'] = '身份证被多设备申请，疑似中介代办';
                break;
            case $fan_data['risk_code'] == 3003:
                $fan_data['risk__str'] = '非本人常用设备';
                break;case $fan_data['risk_code'] == 3004:
            $fan_data['risk__str'] = '黑名单设备';
            break;
            case $fan_data['risk_code'] == 3005:
                $fan_data['risk__str'] = '疑似代理设备，包括使用虚拟机、代理设备、代理IP、猫池等';
                break;
            case $fan_data['risk_code'] == 3006:
                $fan_data['risk__str'] = '手机环境异常';
                break;case $fan_data['risk_code'] == 4001:
            $fan_data['risk__str'] = '身份证在短时间内多次申请借贷，疑似多头借贷';
            break;
            case $fan_data['risk_code'] == 4002:
                $fan_data['risk__str'] = '手机号在短时间内多次申请借贷，疑似多头借贷';
                break;
            case $fan_data['risk_code'] == 4003:
                $fan_data['risk__str'] = '银行卡在短时间内多次申请借贷，疑似多头借贷';
                break;
            case $fan_data['risk_code'] == 4004:
                $fan_data['risk__str'] = 'IMEI在短时间内多次申请借贷，疑似多头借贷';
                break;
            default:
                $fan_data['risk__str'] = '';
        }

        switch ($fan_data['risk_value']){
            case $fan_data['risk_value'] == 'low':
                $fan_data['risk_value_str'] = '低';
                break;
            case $fan_data['risk_value'] == 'middle':
                $fan_data['risk_value_str'] = '中等';
                break;
            case $fan_data['risk_value'] == 'high':
                $fan_data['risk_value_str'] = '高';
                break;
            default:
                $fan_data['risk_value_str'] = '';
        }


        $this->assign('fan_data',$fan_data);
        $this->display();
    }
    public function jiedai_select(){
        $id = I('id');
        if(!$id){
            $this->error('请选择查看的订单',U('jiedai_list'),0);
        }
        $jie_data = M('jiedai')->where(array('id'=>$id))->find();
        $this->assign('jie_data',$jie_data);
        $this->display();
    }

    public function warring_state(){
        $id = I('id');
        $status = I('status');
        if($status==1){
            $statedata = array('warring_state'=>2);
            $auth_group=M('check_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('报警已禁用',U('check_list'),1);
        }else{
            $statedata = array('warring_state'=>1);
            $auth_group=M('check_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('报警已启用',U('check_list'),1);
        }
    }

    public function warring_count(){
        $uid = $_SESSION['user']['member_list_userinfoid'];
        $post = I('warring_count');
        if(!$post){
            $this->error('请填写数目',U('check_list'),0);
        }
        $postData['warring_count'] = $post;
        $res = M('check_list')->where(array('u_id'=>$uid))->save($postData);
        $this->success('填写成功',U('check_list'),1);

    }
}