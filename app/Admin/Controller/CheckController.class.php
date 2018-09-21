<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/12
 * Time: 15:32
 */

namespace Admin\Controller;
use Common\Controller\AuthController;
use Org\Util\Stringnew;
class CheckController extends AuthController
{
    public function check_list(){
        $count = M('check_list')->count();
        $page = getpage($count,10);
        $show = $page->show();// 分页显示输出
        $this->assign('page', $show);

        $check_data = M('check_list')->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('check_data',$check_data);
        $this->display();
    }
    public function check_add(){
        if(IS_POST){
            $post['u_id']  = I('user_id');
            $post['money_num'] = I('price');
            $post['status'] = I('check_status');
            $status = true;
            switch ($status){
                case $post['u_id'] == 0:
                    $this->error('商户不能为空');
                    break;
                case !isset($post['money_num']):
                    $this->error('金额不能为空');
                    break;
                default:
                    $status = false;
            }
            $res = M('check_list')->add($post);
            if($res){
                $this->success('添加成功',U('check_list'),1);
            }else{
                $this->error('添加失败',U('check_list'),0);
            }
        }
        $user_data = M('userinfo')->field('user_id,member_name')->select();
        $this->assign('userdata',$user_data);
        $this->display();
    }
    public function check_del(){
        $id = I('id');
        if($id){
            $res = M('check_list')->where(array('id'=>$id))->delete();
            if($res){
                $this->success('删除成功',U('check_list'),1);
            }else{
                $this->error('删除失败',U('check_list'),0);
            }
        }

    }
    public function check_edit(){
        $id = I('id');
        if(IS_POST){
            $post['id']  = $id;
            $post['u_id']  = I('user_id');
            $post['money_num'] = I('price');
            $post['status'] = I('check_status');
            $status = true;
            switch ($status){
                case $post['u_id'] == 0:
                    $this->error('商户不能为空');
                    break;
                case !isset($post['money_num']):
                    $this->error('金额不能为空');
                    break;
                default:
                    $status = false;
            }
            $res = M('check_list')->save($post);
            $this->success('添加成功',U('check_list'),1);

        }
        $check_data = M('check_list')->where(array('id'=>$id))->field('u_id,money_num')->find();
        $user_data = M('userinfo')->field('user_id,member_name')->select();
        $this->assign('check_data',$check_data);
        $this->assign('id',$id);
        $this->assign('userdata',$user_data);
        $this->display();
    }
    public function check_state(){
        $id = I('x');
        $status=M('check_list')->where(array('id'=>$id))->getField('status');//判断当前状态情况
        if($status==1){
            $statedata = array('status'=>2);
            $auth_group=M('check_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('状态禁止',1,1);
        }else{
            $statedata = array('status'=>1);
            $auth_group=M('check_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('状态开启',1,1);
        }
    }
    public function idcard_list(){
        //搜索条件
        $text = I('val');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
        if (empty($sldate)) {
            $time = time()-2592000;
            $sldate = date('Y-m-d',$time) . ' - ' . date('Y-m-d'); //初始化时间段
        }

        if (strpos($sldate, '+')) {
            $sldate = preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $data['datetime'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }

        if($text){
            $data['realname|idcard|user_id'] = array('like', $text . "%");
        }


        $count = M('idcard')->where($data)->count();
        $page = getpage($count,10);
        $show = $page->show();// 分页显示输出
        $this->assign('page', $show);

        $idcard_data = M('idcard')->where($data)->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('idcard_data',$idcard_data);
        $this->assign('sldate', $sldate);
        $this->assign('testval', $text);
        $this->display();
    }

    public function bankcard_list(){
        //搜索条件
        $text = I('val');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
        if (empty($sldate)) {
            $time = time()-2592000;
            $sldate = date('Y-m-d',$time) . ' - ' . date('Y-m-d'); //初始化时间段
        }

        if (strpos($sldate, '+')) {
            $sldate = preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $data['datetime'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }

        if($text){
            $data['realname|mobile|idcard|user_id|bankcard'] = array('like', $text . "%");
        }


        $count = M('bankcard')->where($data)->count();
        $page = getpage($count,10);
        $show = $page->show();// 分页显示输出
        $this->assign('page', $show);

        $bankcard_data = M('bankcard')->where($data)->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('bankcard_data',$bankcard_data);
        $this->assign('sldate', $sldate);
        $this->assign('testval', $text);
        $this->display();
    }
    public function fanqizha_list(){
//        搜索条件
        $text = I('val');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
        if (empty($sldate)) {
            $time = time()-2592000;
            $sldate = date('Y-m-d',$time) . ' - ' . date('Y-m-d'); //初始化时间段
        }

        if (strpos($sldate, '+')) {
            $sldate = preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $data['datetime'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }

        if($text){
            $data['realname|mobile|idcard|user_id'] = array('like', $text . "%");
        }

        $count = M('fanqizha')->where($data)->count();
        $page = getpage($count,10);
        $show = $page->show();// 分页显示输出
        $this->assign('page', $show);

        $fanqizha_data = M('fanqizha')->where($data)->field('realname,mobile,idcard,datetime,user_id,id')->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('fanqizha_data',$fanqizha_data);
        $this->assign('sldate', $sldate);
        $this->assign('testval', $text);
        $this->display();
    }
    public function jiedai_list(){
        //搜索条件
        $text = I('val');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
        if (empty($sldate)) {
            $time = time()-2592000;
            $sldate = date('Y-m-d',$time) . ' - ' . date('Y-m-d'); //初始化时间段
        }

        if (strpos($sldate, '+')) {
            $sldate = preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $data['datetime'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }

        if($text){
            $data['mobile|user_id'] = array('like', $text . "%");
        }

        $count = M('jiedai')->where($data)->count();
        $page = getpage($count,10);
        $show = $page->show();// 分页显示输出
        $this->assign('page', $show);

        $jiedai_data = M('jiedai')->where($data)->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('jiedai_data',$jiedai_data);
        $this->assign('sldate', $sldate);
        $this->assign('testval', $text);
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
        $status=M('check_list')->where(array('id'=>$id))->getField('warring_state');//判断当前状态情况
        if($status==1){
            $statedata = array('warring_state'=>2);
            $auth_group=M('check_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('报警已禁用',1,1);
        }else{
            $statedata = array('warring_state'=>1);
            $auth_group=M('check_list')->where(array('id'=>$id))->setField($statedata);
            $this->success('报警已启用',1,1);
        }
    }
    public function warring_count(){}
}