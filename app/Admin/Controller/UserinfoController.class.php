<?php
/**
 * User: zhouding
 * Date: 2016/9/12
 * Time: 21:16
 */

namespace Admin\Controller;

use Common\Controller\AuthController;
use Org\Util\Stringnew;

class UserinfoController extends AuthController
{

    public function userinfo_list()
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
        $Page = getpage($count, 30);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $userinfo_list = D('userinfo')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->order('time desc')->select();
        $this->assign('userinfo_list', $userinfo_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();
    }

    public function userinfo_add()
    {
        if (IS_POST) {
            $userinfo_salt = Stringnew::randString(10);
            $md5key = Stringnew::randString(16);
            $currency_1 = I('currency');
            $product_1 = I('product');
            if (I('payout_mid')) {
                $paymenttmp = explode('-', I('payout_mid'));
                $payment_id = $paymenttmp[0];
                $payment_mid = $paymenttmp[1];
            } else {
                $this->error('请选择出金通道', U('Userinfo/userinfo_list'), 0);
            }
            $userinfo_data = array(
                'brand' => I('brand'),
                'member_name' => I('member_name'),
                'type' => 1,
                'tel' => I('tel'),
                'agent_id' => I('agent_id'),
                'industry' => I('industry'),
                'address' => I('address'),
                'md5key' => $md5key,
                'paypsd_salt' => $userinfo_salt,
                'paypsd' => encrypt_password(I('paypsd'), $userinfo_salt),
                'currency_id' => json_encode($currency_1),
                'product_id' => json_encode($product_1),

//                'payin_rate' => I('payin_rate'),
//                'payin_id' => I('payin_id'),
//                'payin_mid' => I('payin_mid'),
                'payout_id' => $payment_id,
                'payout_mid' => $payment_mid,

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
                    //添加商户余额列表  检查余额表没重复值，就写入！
                    foreach ($currency_1 as $v) {
                        $user_balance_list = M('user_balance')->where(array('user_id' => $rst, 'currency_id' => $v))->find();
                        if (!$user_balance_list) {
                            //写入用户余额表
                            $balance_data = array(
                                'user_id' => $rst,
                                'currency_id' => $v,
                                'created_at' => date('Y-m-d H:i:s'),
                                'update_at' => date('Y-m-d H:i:s'),
                            );
                            $balance_rst = M('user_balance')->add($balance_data);
                        }
                    }
                    $this->success('商户添加成功', U('Userinfo/userinfo_list'), 1);
                } else {
                    $this->error('商户添加失败', U('Userinfo/userinfo_list'), 0);
                }
            }

        } else {
            //读取代理商列表
            $agent_list = M('agent_list')->select();
            $this->assign('agent_list', $agent_list);
            //读取产品数组
            $product = M('product')->select();
            $this->assign('product', $product);
            //读取货币数组
            $currency = M('currency')->select();
            $this->assign('currency', $currency);
            //出金MID配置
            $payment_mid = M('payment_mid')->select();
            $this->assign('payment_mid', $payment_mid);
            //出金手续费
            $payout_rate = M('payout_rate')->select();
            $this->assign('payout_rate', $payout_rate);


            $this->display();
        }
    }

    public function userinfo_edit()
    {
        //产品ID
        $product = M('product')->select();
        $this->assign('product', $product);
        //货币ID
        $currency = M('currency')->select();
        $this->assign('currency', $currency);
        //原有用户基础信息
        $userinfo_edit = M('userinfo')->where(array('user_id' => I('user_id')))->find();
        $this->assign('userinfo_edit', $userinfo_edit);
        //原有出金费率
        $payout_rate_list = M('payout_rate')->where(array('payout_rate_id' => $userinfo_edit['payout_rate']))->find();
        $this->assign('payout_rate_list', $payout_rate_list);
        //现有出金费率列表
        $payout_rate = M('payout_rate')->select();
        $this->assign('payout_rate', $payout_rate);
        //获取原有MID值
        $payment_mid = M('payment_mid')->where(array('m_id' => $userinfo_edit['payout_mid']))->getField('m_id');
        $this->assign('payment_mid', $payment_mid);
        //取现有MID值
        $payment_mid_list = M('payment_mid')->select();
        $this->assign('payment_mid_list', $payment_mid_list);
        //原有代理ID
        $agent_list = M('agent_list')->select();
        $this->assign('agent_list', $agent_list);

        $this->display();
    }

    public function userinfo_runedit()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('userinfo_list'), 0);
        } else {
//            $userinfo_edit = M('userinfo')->where(array('user_id' => I('user_id')))->find();
            $sl_data['user_id'] = I('user_id');
            $sl_data['member_name'] = I('member_name');

            $currency_1 = I('currency');
            $product_1 = I('product');

            if (I('payout_mid')) {
                $paymenttmp = explode('-', I('payout_mid'));
                $payment_id = $paymenttmp[0];
                $payment_mid = $paymenttmp[1];
            } else {
                $this->error('请选择出金通道', U('Userinfo/userinfo_list'), 0);
            }

            $pwd = I('paypsd');
            if (!empty($pwd)) {
                $userinfo_salt = Stringnew::randString(10);
                $sl_data['userinfo_salt'] = $userinfo_salt;
                $sl_data['paypsd'] = encrypt_password($pwd, $userinfo_salt);
            }
            $sl_data['tel'] = I('tel');
            $sl_data['agent_id'] = I('agent_id');
            $sl_data['brand'] = I('brand');
            $sl_data['industry'] = I('industry');
            $sl_data['address'] = I('address');
            $sl_data['currency_id'] = json_encode($currency_1);
            $sl_data['product_id'] = json_encode($product_1);
            $sl_data['payin_rate'] = I('payin_rate');
            $sl_data['payin_id'] = I('payin_id');
            $sl_data['payin_mid'] = I('payin_mid');
            $sl_data['payout_id'] = $payment_id;
            $sl_data['payout_mid'] = $payment_mid;
            $sl_data['payout_rate'] = I('payout_rate');
            $sl_data['payout_auto'] = I('payout_auto');
            $u_access = M('userinfo')->save($sl_data);
            if ($u_access) {
                //添加商户余额列表  检查余额表没重复值，就写入！
                foreach ($currency_1 as $v) {
                    $user_balance_list = M('user_balance')->where(array('user_id' => I('user_id'), 'currency_id' => $v))->find();
                    if (!$user_balance_list) {
                        //写入用户余额表
                        $balance_data = array(
                            'user_id' => I('user_id'),
                            'currency_id' => $v,
                            'created_at' => date('Y-m-d H:i:s'),
                            'update_at' => date('Y-m-d H:i:s'),
                        );
                        $balance_rst = M('user_balance')->add($balance_data);
                    } else {
                        M('user_balance')->where(array('user_id' => I('user_id'), 'currency_id' => array('neq', $v)))->delete();
                    }
                }
                $this->success('商户修改成功', U('userinfo_list'), 1);
            } else {
                $this->error('商户修改失败', U('userinfo_list'), 0);
            }

        }


    }

    public function userinfo_del()
    {
        $rst=M('userinfo')->where(array('user_id'=>I('user_id')))->delete();
        if($rst!==false){
            $p=I('p',1,'intval');
            $this->success('商户删除成功',U('userinfo_list',array('p'=>$p)),1);
        }else{
            $this->error('商户删除失败',U('userinfo_list'),0);
        }
    }

    public function info()
    {
        $key = I('key');
        $map['user_id'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'OR';
        /*
         * 分页操作
         */
        $count = M('user_balance')->where($map)->count();// 查询满足要求的总记录数
        $Page = getpage($count, 30);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $userinfo_list = D('user_balance')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->relation(true)->order('user_id desc')->select();

        foreach ($userinfo_list as $key => $value) {

            $user_id = $value['user_id'];
            $sub_user_list = M('sub_user_balance')->field('attribute,sub_user_balance')->where(array('user_id' => $user_id))->select();

            $userinfo_list[$key]['sub_user_list'] = $sub_user_list;

        }

        $this->assign('userinfo_list', $userinfo_list);

        $this->assign('page', $show);
        $this->assign('val', $key);
        $this->display();
    }

    public function order_details()
    {

        $key = I('key');
        $sldate = I('reservation', '');//获取格式 2015-11-12 - 2015-11-18
        if (strpos($sldate, '+')) {
            $sldate = preg_replace('/\+/', ' ', $sldate);
        }
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }
        $map['uid|orderid'] = array('like', "%" . $key . "%");
        $map['_logic'] = 'AND';
        /*
         * 交易记录列表
         */
        $count = M('order_log')->where($map)->count();// 查询满足要求的总记录数

        $Page = getpage($count, 50);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出
        $order_log_list = M('order_log')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('order_log_id desc')->select();

        $this->assign('order_log_list', $order_log_list);
        $this->assign('page', $show);
        $this->assign('sldate', $sldate);
        $this->assign('begin_time', $arrdateone);
        $this->assign('end_time', $arrdatetwo);
        $this->assign('keyy', $key);
        $this->display();

    }

    //商戶中心部分
    function center()
    {
        $this->display();
    }

    function password()
    {
        $this->display();
    }

    function runchangepwd()
    {
        $this->display();
    }

    function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     9437184 ;// 设置附件上传大小
        $upload->exts      =     array('xls');// 设置附件上传类型
        $upload->savePath = 'excel/';// 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $info['excelfile']['urlpath'] = substr($info['excelfile']['urlpath'],1);
            $this->readExcel( $info['excelfile']['urlpath'],$info['excelfile']['ext'] );
        }
    }
//创建一个读取excel函数
    protected function readExcel($path)
    {
        //载入文件
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Reader.Excel5");
        $objPHPExcel = new \PHPExcel_Reader_Excel5();
        $PHPExcel = $objPHPExcel->load($path);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $toArray = $PHPExcel->getSheet(0)->toArray();

        @unlink($path); //删除上传的文件
        //循环到空数据就不要
        foreach ($toArray as $k => $v){
            if($v[0] != ''){
                $excelArr[$k] = $v;
            }
        }
        $this->importData($excelArr);
    }

    //保存数据到数据库
    protected function importData($data){
        //设置响应时间
//        ini_set('max_execution_time','0');
        ini_set('memory_limit','-1');
        set_time_limit('0');
        /*
           重要代码 解决Thinkphp M、D方法不能调用的问题
           如果在thinkphp中遇到M 、D方法失效时就加入下面一句代码
           */
        //spl_autoload_register ( array ('Think', 'autoload' ) );
        foreach ($data as $k => $v) {
            //增加时间不一致
            $hour = rand(0,86400);
            $dataList = '';
            if ($k > 0) {
                $dataList['id'] = '';
                $dataList['order_time'] = (strtotime($v['0']) + $hour);
                $dataList['pay_time'] = (strtotime($v['0']) + $hour);
                $dataList['freight_id'] = $v['1'];
                $dataList['pay_name'] = $v['2'];
                $dataList['consignee_name'] = $v['2'];
                $dataList['consignee_phone'] = $v['3'];
                $dataList['pay_phone'] = $v['3'];
                $dataList['twon'] = 0;
                $dataList['address'] = $v['4'];
                $dataList['paper_type'] = "身份证";
                $dataList['paper_id'] = $v['5'];
                $dataList['logis_company'] = $v['6'];
                $dataList['money_code'] = "HKD";
                $dataList['IP'] = getIP();        //获取客户端IP
                $dataList['surface_money'] = null;
                $dataList['tax'] = 0;         //是否保税货物项下付款 1 是 0否
                $dataList['set_money'] = 2;   //定义类型1为外币，2为RMB
//                foreach ($dataList[$num] as $k1 => $v1){
//                    if($dataList[$num][$k1] == null){
//                        $dataList[$num][$k1] = '';
//                    }
//                }
                $dataList['add_time'] = time();
                $rs = M('logis')->add($dataList);
                unset($data[$k]);
                unset($dataList);
            }
        }
        if ($rs){
            $this->success('成功');die;
        }else{
            $this->error('失败');die;
        }
    }
}