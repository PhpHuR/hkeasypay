<?php
/**
 * User: zhouding
 * Date: 2016/9/12
 * Time: 22:04
 */

namespace Home\Controller;
use Org\Util\Stringnew;
use Home\Controller\HomebaseController;
class UserinfoController extends HomebaseController
{
    function userinfo_list()
    {
        /**
         * 商户管理
         */
        $key = I('key');
        $map['tel'] = array('like', "%" . $key . "%");
        $map['member_name'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'OR';
        /*
         * 分页操作
         */
        $count = M('userinfo')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $userinfo_list = D('userinfo')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('end_time desc')->relation(true)->select();
        $this->assign('userinfo_list', $userinfo_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();
    }

    function userinfo_add()
    {
        if (IS_POST) {
            $userinfo_salt = Stringnew::randString(10);
            $md5key = Stringnew::randString(16);
            $userinfo_data = array(
                'member_name' => I('member_name'),
                'type' => 1,
                'tel' => I('tel'),
                'industry' => I('industry'),
                'address' => I('address'),
                'md5key' => $md5key,
                'paypsd_salt' => $userinfo_salt,
                'paypsd' => encrypt_password(I('paypsd'), $userinfo_salt),
                'payin_rate' => I('payin_rate'),
                'payin_id' => I('payin_id'),
                'payin_mid' => I('payin_mid'),
                'payout_id' => I('payout_id'),
                'payout_mid' => I('payout_mid'),
                'payout_rate' => I('payout_rate'),
                'payout_auto' => I('payout_auto'),
                'time' => time()

            );
            $userinfo = M('userinfo');
            if ($userinfo->where(array('member_name' => I('member_name')))->find()) {
                $this->error('商户名称重复，请重新填写', U('Userinfo/userinfo_list'), 0);
            } else {
                $rst = $userinfo->add($userinfo_data);
                if ($rst) {
                    $this->success('商户添加成功', U('Userinfo/userinfo_list'), 1);
                } else {
                    $this->error('商户添加失败', U('Userinfo/userinfo_list'), 0);
                }
            }

        } else {
            $payment_name = M('payment_name')->select();
            $payin_rate = M('payin_rate')->select();
            $payout_rate = M('payout_rate')->select();
            $this->assign('payment_name', $payment_name);
            $this->assign('payin_rate', $payin_rate);
            $this->assign('payout_rate', $payout_rate);
            $this->display();
        }
    }

    public function userinfo_edit()
    {
        $userinfo_edit = M('userinfo')->where(array('user_id' => I('user_id')))->find();
        $payment_name = M('payment_name')->select();
        $payin_rate = M('payin_rate')->select();
        $payout_rate = M('payout_rate')->select();
        $this->assign('payment_name', $payment_name);
        $this->assign('payin_rate', $payin_rate);
        $this->assign('payout_rate', $payout_rate);
        $this->assign('userinfo_edit', $userinfo_edit);
        $this->display();
    }

    public function userinfo_runedit()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('userinfo_list'), 0);
        } else {

            $sl_data['id'] = I('id');
            $sl_data['member_name'] = I('member_name');

            $pwd = I('paypsd');
            if (!empty($pwd)) {
                $userinfo_salt = Stringnew::randString(10);
                $sl_data['userinfo_salt'] = $userinfo_salt;
                $sl_data['paypsd'] = encrypt_password($pwd, $userinfo_salt);
            }

            $sl_data['tel'] = I('tel');
            $sl_data['industry'] = I('industry');
            $sl_data['address'] = I('address');
            $sl_data['payin_rate'] = I('payin_rate');
            $sl_data['payin_id'] = I('payin_id');
            $sl_data['payin_mid'] = I('payin_mid');
            $sl_data['payout_id'] = I('payout_id');
            $sl_data['payout_mid'] = I('payout_mid');
            $sl_data['payout_rate'] = I('payout_rate');
            $sl_data['payout_auto'] = I('payout_auto');

            $u_access = M('userinfo')->save($sl_data);

            if ($u_access) {
                $this->success('商户修改成功', U('userinfo_list'), 1);
            } else {
                $this->error('商户修改失败', U('userinfo_list'), 0);
            }

        }


    }

    function info()
    {
        $key = I('key');
            $sldate = I('reservation','');
        if (empty($sldate)) {
            $begin_time = date('Y-m-d');
            $end_time = date('Y-m-d');
            $sldate = $begin_time . ' - ' . $end_time;
        }

        if (strpos($sldate,'+')) {
            $sldate=preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ",$sldate);//转换成数组
        if(count($arr)==2){
            $arrdateone=strtotime($arr[0]);
            $arrdatetwo=strtotime($arr[1].' 23:59:59');
            $map['begin_time'] = array(array('egt',$arrdateone),array('elt',$arrdatetwo),'AND');
        }
        $map['orderid']= array('like',"%".$key."%");
        //用户余额读取
        $userinfo = M('user_balance')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();
//        dump($userinfo);die;
        //子賬戶餘額
        $sub_userinfo = M('sub_user_balance')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();


        //统计入金结果 - 按照货币类型
        $begin = strtotime(date('Ymd'));
        $end = strtotime(date('Ymd'.' 23:59:59'));
        $sql = "SELECT sum(ordermoney) as iordermoney,sum(free) as ifree,currency_id from  __PREFIX__payin ";
        $sql .= " where begin_time>$begin and begin_time<$end AND status=1 group by currency_id";
        $res = M()->query($sql);//订单数,交易额

        //出金统计
        $osql = "SELECT sum(transfermoney) as otransfermoney,sum(free) as ofree,currency_id from  __PREFIX__payout ";
        $osql .= " where begin_time>$begin and begin_time<$end AND status=4 group by currency_id";
        $ores = M()->query($osql);//订单数,交易额

        $list_res = array_merge($res, $ores);
//        dump($res);
//        dump($ores);
//        dump($list_res);
//        die();
//        if(I('aciton'=='export')){
//            $this->upload_agentpayin();
//        }
        $payin_order_sum = M('payin')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 1, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('ordermoney');//入金总金额
        $payin_order_free = M('payin')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 1, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('free');//入金总手续费
        $payout_order_sum = M('payout')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 4, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('transfermoney');//出金总金额
        $payout_order_cny_sum = M('payout')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 4, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('transfermoney_hkd');//出金总金额
        $payout_order_free = M('payout')->where(array('uid' => $this->user['member_list_userinfoid'],'status' => 4, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('free');//出金总手续费
        /*
         * 交易记录列表
         */
        $map['uid'] = $this->user['member_list_userinfoid'];
        $map['_logic'] = 'AND';

        $count = M('order_log')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        
        $order_log_list = M('order_log')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('order_log_id desc')->select();
        $curofferList = M('curoffer')->where(array('user_id' => $this->user['member_list_userinfoid']))->select();
        $this->assign('curofferList', $curofferList);

        $this->assign('order_log_list', $order_log_list);
        $this->assign('page', $show);
        $this->assign('sldate', $sldate);
        $this->assign('begin_time', $begin_time);
        $this->assign('end_time', $end_time);
        $this->assign('keyy', $key);
        $this->assign('userinfo', $userinfo);
        $this->assign('sub_userinfo', $sub_userinfo);
        $this->assign('payin_order_sum', $payin_order_sum);
        $this->assign('payin_order_free', $payin_order_free);
        $this->assign('payout_order_sum', $payout_order_sum);
        $this->assign('payout_order_cny_sum',$payout_order_cny_sum);
        $this->assign('payout_order_free', $payout_order_free);
        $this->assign('user_id',$_SESSION['user']['member_list_userinfoid']);
        if(in_array($_SESSION['user']['member_list_userinfoid'],C('TMPL_HKD'))){
            $this->assign('user_id', $_SESSION['user']['member_list_userinfoid']);
            $this->display("info1");
            die;
        }
        $this->display();
    }

    function order_details()
    {
        $key = I('key');
        $begin_time = I('begin_time', '');
        $end_time = I('end_time', '');
        if (empty($begin_time) and empty($end_time)) {
            $begin_time = date('Y-m-d');
            $end_time = date('Y-m-d');
        }
        $sldate = $begin_time . ' - ' . $end_time;
        if (strpos($sldate,'+')) {
            $sldate=preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ",$sldate);//转换成数组
        if(count($arr)==2){
            $arrdateone=strtotime($arr[0]);
            $arrdatetwo=strtotime($arr[1].' 23:55:55');
            $map['begin_time'] = array(array('egt',$arrdateone),array('elt',$arrdatetwo),'AND');
        }
        $map['orderid']= array('like',"%".$key."%");
        /*
         * 交易记录列表
         */
        $map['uid'] = $this->user['member_list_userinfoid'];
        $map['_logic'] = 'AND';
        $count = M('order_log')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $order_log_list = M('order_log')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('order_log_id desc')->select();
        $this->assign('order_log_list', $order_log_list);
        $this->assign('page', $show);
        $this->assign('sldate', $sldate);
        $this->assign('begin_time', $begin_time);
        $this->assign('end_time', $end_time);
        $this->assign('keyy', $key);
        $this->display();
    }


    function center()
    {
        $this->display();
    }

    function password()
    {
        $this->assign($this->user);
        $this->display();
    }

    function runchangepwd()
    {
        if (IS_POST) {
            $old_password = I('old_password');
            $password = I('password');
            $repassword = I('repassword');
            if (empty($old_password)) {
                $this->error("原始密码不能为空！", 0, 0);
            }
            if (empty($password)) {
                $this->error("新密码不能为空！", 0, 0);
            }
            if ($password !== $repassword) {
                $this->error("2次密码不一致！", 0, 0);
            }
            $member = M('member_list');
            $user = $member->where(array('member_list_id' => $this->userid))->find();
            $member_list_salt = $user['member_list_salt'];
            if (encrypt_password($old_password, $member_list_salt) === $user['member_list_pwd']) {
                if (encrypt_password($password, $member_list_salt) == $user['member_list_pwd']) {
                    $this->error("新密码不能和原始密码相同！", 0, 0);
                } else {
                    $data['member_list_pwd'] = encrypt_password($password, $member_list_salt);
                    $data['member_list_id'] = $this->userid;
                    $rst = $member->save($data);
                    if ($rst !== false) {
                        $this->success("修改成功！", U('Userinfo/password'), 1);
                    } else {
                        $this->error("修改失败！", 0, 0);
                    }
                }
            } else {
                $this->error("原始密码不正确！", 0, 0);
            }
        }
    }
//    导出支付列表
    protected function upload(){
        $goods_list = M('order_log')->where(array("uid"=>8847))->select();
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][order_log_id] = $goods_info['order_log_id'];
            $data[$k][uid] = $goods_info['uid'];
            $data[$k][orderid] = $goods_info['orderid'];
            $data[$k][currency_id] = $goods_info['currency_id'];
            $data[$k][t_type] = $goods_info['t_type'];
            $data[$k][income] = $goods_info['income'];
            $data[$k][outlay] = $goods_info['outlay'];
            $data[$k][balance] = $goods_info['balance'];
            $data[$k][begin_time] = $goods_info['begin_time'];
            $data[$k][end_time] = $goods_info['end_time'];
            $data[$k][remark] = $goods_info['remark'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'order_log_id') {
                $headArr[] = 'id';
            }
            if ($field == 'uid') {
                $headArr[] = '商户id';
            }
            if ($field == 'orderid') {
                $headArr[] = '系統訂單號碼';
            }

            if ($field == 'currency_id') {
                $headArr[] = '货币id';
            }

            if ($field == 't_type') {
                $headArr[] = '交易类型';
            }

            if ($field == 'income') {
                $headArr[] = '收入';
            }

            if ($field == 'outlay') {
                $headArr[] = '支出';
            }

            if ($field == 'balance') {
                $headArr[] = '账户余额';
            }
            if ($field == 'begin_time') {
                $headArr[] = '创建时间';
            }

            if ($field == 'end_time') {
                $headArr[] = '结束时间';
            }
            if ($field == 'remark') {
                $headArr[] = '备注';
            }

        }

        $filename = 'order';

        getExcel($filename, $headArr, $data);
    }
//    导出出金excel
    protected function upload_payout(){
        $goods_list = M('payout')->where(array("uid"=>8847))->select();
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][payout_id] = $goods_info['payout_id'];
            $data[$k][uid] = $goods_info['uid'];
            $data[$k][member_name] = $goods_info['member_name'];
            $data[$k][payout_mid] = $goods_info['payout_mid'];
            $data[$k][attribute] = $goods_info['attribute'];
            $data[$k][payout_orderid] = $goods_info['payout_orderid'];
            $data[$k][batchnum] = $goods_info['batchnum'];
            $data[$k][currency_id] = $goods_info['currency_id'];
            $data[$k][type] = $goods_info['type'];
            $data[$k][reaccname] = $goods_info['reaccname'];
            $data[$k][reaccno] = $goods_info['reaccno'];
            $data[$k][bankname] = $goods_info['bankname'];
            $data[$k][proname] = $goods_info['proname'];
            $data[$k][cityname] = $goods_info['cityname'];
            $data[$k][townname] = $goods_info['reaccno'];
            $data[$k][reaccdept] = $goods_info['reaccdept'];
            $data[$k][operato] = $goods_info['operato'];
            $data[$k][filename] = $goods_info['filename'];
            $data[$k][transfermoney] = $goods_info['transfermoney'];
            $data[$k][settlementmoney] = $goods_info['settlementmoney'];
            $data[$k][free] = $goods_info['free'];
            $data[$k][payout_commission_c] = $goods_info['payout_commission_c'];
            $data[$k][payout_commission_ag] = $goods_info['payout_commission_ag'];
            $data[$k][status] = $goods_info['status'];
            $data[$k][begin_time] = $goods_info['begin_time'];
            $data[$k][audit_time] = $goods_info['audit_time'];
//            $data[$k][result_time] = $goods_info['result_time'];
//            $data[$k][remark] = $goods_info['remark'];
//            $data[$k][result_remark] = $goods_info['result_remark'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'payout_id') {
                $headArr[] = 'payout_id';
            }
            if ($field == 'uid') {
                $headArr[] = '商户id';
            }
            if ($field == 'member_name') {
                $headArr[] = 'member_name';
            }

            if ($field == 'payout_mid') {
                $headArr[] = 'payout_mid';
            }

            if ($field == 'attribute') {
                $headArr[] = 'attribute';
            }

            if ($field == 'payout_orderid') {
                $headArr[] = 'payout_orderid';
            }

            if ($field == 'batchnum') {
                $headArr[] = 'batchnum';
            }

            if ($field == 'currency_id') {
                $headArr[] = 'currency_id';
            }
            if ($field == 'reaccdept') {
                $headArr[] = 'reaccdept';
            }
            if ($field == 'type') {
                $headArr[] = 'type';
            }

            if ($field == 'reaccname') {
                $headArr[] = 'reaccname';
            }
            if ($field == 'reaccno') {
                $headArr[] = 'reaccno';
            }
            if ($field == 'bankname') {
                $headArr[] = 'bankname';
            }
            if ($field == 'proname') {
                $headArr[] = 'proname';
            }
            if ($field == 'cityname') {
                $headArr[] = 'cityname';
            }
            if ($field == 'townname') {
                $headArr[] = 'townname';
            }
            if ($field == 'filename') {
                $headArr[] = 'filename';
            }
            if ($field == 'operato') {
                $headArr[] = 'operato';
            }
            if ($field == 'transfermoney') {
                $headArr[] = 'transfermoney';
            }
            if ($field == 'settlementmoney') {
                $headArr[] = 'settlementmoney';
            }
            if ($field == 'free') {
                $headArr[] = 'free';
            }
            if ($field == 'payout_commission_c') {
                $headArr[] = 'payout_commission_c';
            }
            if ($field == 'payout_commission_ag') {
                $headArr[] = 'payout_commission_ag';
            }
            if ($field == 'status') {
                $headArr[] = 'status';
            } if ($field == 'begin_time') {
                $headArr[] = 'begin_time';
            }
            if ($field == 'audit_time') {
                $headArr[] = 'audit_time';
            }
//            if ($field == 'result_time') {
//                $headArr[] = 'result_time';
//            } if ($field == 'remark') {
//                $headArr[] = 'remark';
//            } if ($field == 'result_remark') {
//                $headArr[] = 'result_remark';
//            }

        }

        $filename = 'payout';

        getExcel($filename, $headArr, $data);
    }
//    导出入金excel
    protected function upload_payin(){
        $goods_list = M('payin')->where(array("uid"=>8847))->select();
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][payin_id] = $goods_info['payin_id'];
            $data[$k][uid] = $goods_info['uid'];
            $data[$k][payment_mid] = $goods_info['payment_mid'];
            $data[$k][orderid] = $goods_info['orderid'];
            $data[$k][pay_orderid] = $goods_info['pay_orderid'];
            $data[$k][transid] = $goods_info['transid'];
            $data[$k][currency_id] = $goods_info['batchnum'];
            $data[$k][product_id] = $goods_info['product_id'];
            $data[$k][remark] = $goods_info['remark'];
            $data[$k][paybank] = $goods_info['paybank'];
            $data[$k][payment_id] = $goods_info['payment_id'];
            $data[$k][ordermoney] = $goods_info['ordermoney'];
            $data[$k][begin_time] = $goods_info['begin_time'];
            $data[$k][end_time] = $goods_info['end_time'];
            $data[$k][factmoney] = $goods_info['factmoney'];
            $data[$k][free] = $goods_info['free'];
            $data[$k][settlement] = $goods_info['settlement'];
            $data[$k][payin_commission_c] = $goods_info['payin_commission_c'];
            $data[$k][payin_commission_ag] = $goods_info['payin_commission_ag'];
            $data[$k][status] = $goods_info['status'];
            $data[$k][m_status] = $goods_info['m_status'];
            $data[$k][notice_status] = $goods_info['notice_status'];
            $data[$k][payin_method] = $goods_info['payin_method'];
            $data[$k][returnurl] = $goods_info['returnurl'];
            $data[$k][notifyurl] = $goods_info['notifyurl'];
            $data[$k][source] = $goods_info['source'];
//            $data[$k][settlements_status] = $goods_info['settlements_status'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'payin_id') {
                $headArr[] = 'payin_id';
            }
            if ($field == 'uid') {
                $headArr[] = '商户id';
            }
            if ($field == 'payment_mid') {
                $headArr[] = 'payment_mid';
            }

            if ($field == 'orderid') {
                $headArr[] = 'orderid';
            }

            if ($field == 'pay_orderid') {
                $headArr[] = 'pay_orderid';
            }

            if ($field == 'transid') {
                $headArr[] = 'transid';
            }

            if ($field == 'currency_id') {
                $headArr[] = 'currency_id';
            }

            if ($field == 'product_id') {
                $headArr[] = 'product_id';
            }
            if ($field == 'remark') {
                $headArr[] = 'remark';
            }
            if ($field == 'paybank') {
                $headArr[] = 'paybank';
            }

            if ($field == 'payment_id') {
                $headArr[] = 'payment_id';
            }
            if ($field == 'ordermoney') {
                $headArr[] = 'ordermoney';
            }
            if ($field == 'begin_time') {
                $headArr[] = 'begin_time';
            }
            if ($field == 'end_time') {
                $headArr[] = 'end_time';
            }
            if ($field == 'factmoney') {
                $headArr[] = 'factmoney';
            }
            if ($field == 'free') {
                $headArr[] = 'free';
            }
            if ($field == 'settlement') {
                $headArr[] = 'settlement';
            }
            if ($field == 'payin_commission_c') {
                $headArr[] = 'payin_commission_c';
            }
            if ($field == 'payin_commission_ag') {
                $headArr[] = 'payin_commission_ag';
            }
            if ($field == 'status') {
                $headArr[] = 'status';
            }
            if ($field == 'm_status') {
                $headArr[] = 'm_status';
            }
            if ($field == 'notice_status') {
                $headArr[] = 'notice_status';
            }
            if ($field == 'payin_method') {
                $headArr[] = 'payin_method';
            }
            if ($field == 'returnurl') {
                $headArr[] = 'returnurl';
            }
            if ($field == 'notifyurl') {
                $headArr[] = 'notifyurl';
            }
            if ($field == 'source') {
                $headArr[] = 'source';
            }
//            if ($field == 'settlements_status') {
//                $headArr[] = 'settlements_status';
//
//        }
        }

        $filename = 'payin';

        getExcel($filename, $headArr, $data);
    }
    //    导出入金info_excel
    protected function upload_payin_info(){
        $goods_list = M('payininfo')->where(array("uid"=>8847))->select();
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][payininfo_id] = $goods_info['payininfo_id'];
            $data[$k][payin_id] = $goods_info['payin_id'];
            $data[$k][uid] = $goods_info['uid'];
            $data[$k][customer_name] = $goods_info['customer_name'];
            $data[$k][customer_id] = $goods_info['customer_id'];
            $data[$k][cert_type] = $goods_info['cert_type'];
            $data[$k][cert_number] = $goods_info['cert_number'];
            $data[$k][email] = $goods_info['email'];
            $data[$k][tel] = $goods_info['tel'];
            $data[$k][bank_number] = $goods_info['bank_number'];
            $data[$k][update_time] = $goods_info['update_time'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'payininfo_id') {
                $headArr[] = 'payininfo_id';
            }
            if ($field == 'uid') {
                $headArr[] = '商户id';
            }
            if ($field == 'payin_id') {
                $headArr[] = 'payin_id';
            }

            if ($field == 'customer_name') {
                $headArr[] = 'customer_name';
            }

            if ($field == 'customer_id') {
                $headArr[] = 'customer_id';
            }

            if ($field == 'cert_type') {
                $headArr[] = 'cert_type';
            }

            if ($field == 'cert_number') {
                $headArr[] = 'cert_number';
            }

            if ($field == 'email') {
                $headArr[] = 'email';
            }
            if ($field == 'tel') {
                $headArr[] = 'tel';
            }
            if ($field == 'bank_number') {
                $headArr[] = 'bank_number';
            }

            if ($field == 'update_time') {
                $headArr[] = 'update_time';
            }
        }

        $filename = 'payininfo';

        getExcel($filename, $headArr, $data);
    }
    //    导出关联管理员数据
    protected function upload_agentpayin(){
        $goods_list = M('agentpayin')->where(array("user_id"=>8847))->select();
        $data = array();
        foreach ($goods_list as $k => $goods_info) {
            $data[$k][agentpayin_id] = $goods_info['agentpayin_id'];
            $data[$k][user_id] = $goods_info['user_id'];
            $data[$k][agent_id] = $goods_info['agent_id'];
            $data[$k][agent_pid] = $goods_info['agent_pid'];
            $data[$k][agentpayin_order_id] = $goods_info['agentpayin_order_id'];
            $data[$k][payin_order_id] = $goods_info['payin_order_id'];
            $data[$k][order_money] = $goods_info['order_money'];
            $data[$k][agentfree] = $goods_info['agentfree'];
            $data[$k][agent_rate] = $goods_info['agent_rate'];
            $data[$k][paybank] = $goods_info['paybank'];
            $data[$k][attribute] = $goods_info['attribute'];
            $data[$k][update_time] = $goods_info['update_time'];
        }

        //print_r($goods_list);
        //print_r($data);exit;
        foreach ($data as $field => $v) {
            if ($field == 'agentpayin_id') {
                $headArr[] = 'agentpayin_id';
            }
            if ($field == 'user_id') {
                $headArr[] = '商户id';
            }
            if ($field == 'agent_id') {
                $headArr[] = 'agent_id';
            }

            if ($field == 'agent_pid') {
                $headArr[] = 'agent_pid';
            }

            if ($field == 'agentpayin_order_id') {
                $headArr[] = 'agentpayin_order_id';
            }

            if ($field == 'payin_order_id') {
                $headArr[] = 'payin_order_id';
            }

            if ($field == 'order_money') {
                $headArr[] = 'order_money';
            }

            if ($field == 'agentfree') {
                $headArr[] = 'agentfree';
            }
            if ($field == 'agent_rate') {
                $headArr[] = 'agent_rate';
            }
            if ($field == 'paybank') {
                $headArr[] = 'paybank';
            }

            if ($field == 'attribute') {
                $headArr[] = 'attribute';
            }
            if ($field == 'update_time') {
                $headArr[] = 'update_time';
            }
        }

        $filename = 'agentpayin';

        getExcel($filename, $headArr, $data);
    }
}