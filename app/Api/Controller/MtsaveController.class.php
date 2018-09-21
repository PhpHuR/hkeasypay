<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/06/26
 * Time: 17:20
 */
namespace Api\Controller;
use Think\Controller;
class MtsaveController extends Controller
{
    private $userinfo;
    protected function _initialize()
    {
        //必须传输的字段
        $company_code = I('company_code'); //由我們提供，於系統中的公司代碼。

        $user_id = I('consumer_id');//用户ID
        $realname = I('realname');//用户真实名
        $idcard = I('idcard');//银行卡号
        $phone = I('phone');//电话。
        $email = I('email');//邮箱。
        $bankname = I('bankname');//银行名。
        $bankcard = I('bankcard');//银行账号。
        $bankaddress = I('bankaddress');//银行地址
        $idcard_zheng = I('idcard_zheng');
        $idcard_fan = I('idcard_fan');
        $bankcard_photo = I('bankcard_photo');
        $big_tou = I('big_tou');
        $timestamp = I('timestamp');//订单发起时间-時間郵戳
        $base64_memo = I('base64_memo');//備注。
        $sign = I('sign');//签名

        if($company_code){
            $this->userinfo = M('userinfo')->where(array('user_id' => $company_code))->find();
        }else{
            $error = array('errorCode'=>'1','msg'=>'company_code.invalid');
            echo json_encode($error);
            die();
        }

        $data = array();
        if(!$user_id){
            $error = array('errorCode'=>'1','msg'=>'user_id.invalid');
            echo json_encode($error);
            die();
        }else{
            $data['consumer_id'] = $user_id;
        }
//        名字检验

        if($realname){
            $data['realname'] = $realname;
        }
        //        银行卡号
        if($idcard){
            $data['idcard'] = $idcard;
        }
        //        电话
        if($phone){
            $data['phone'] = $phone;
        }
        //        邮箱
        if($email){
            $data['email'] = $email;
        }
        //        银行名
        if($bankname){
            $data['bankname'] = $bankname;

        }
        //        银行账号
        if($bankcard){
            $data['bankcard'] = $bankcard;

        }

        //        银行地址
        if($bankaddress){
            $data['bankaddress'] = $bankaddress;
        }

        if($base64_memo){
            $data['base64'] = $base64_memo;
        }

        if($timestamp){
            $data['timestamp'] = $timestamp;
        }else{
            $error = array('errorCode'=>'1','msg'=>'timestamp.invalid');
            echo json_encode($error);
            die();
        }

        $MARK = "&";


        //当前两个固定值：$sign_type = 'SHA256';  $version = '1.0';
        $string = $company_code . $MARK .$user_id . $MARK .$realname . $MARK . $idcard . $MARK . $phone . $MARK . $bankname . $MARK . $bankcard . $MARK . $timestamp . $MARK . 'SHA256' . $MARK . $this->userinfo['md5key'];

        $Signature = hash('sha256', $string);

        if ($sign != $Signature) {
            $error = array('errorCode'=>'1','msg'=>'sign.invalid');
            echo json_encode($error);
            die();
        }
            $photo_path = M('mtfour')->where(array('consumer_id'=>$user_id))->field('idcard_z_path,idcard_f_path,bankphoto_path,bigphoto_path')->find();
//        身份证正面
        if($idcard_zheng){


//            限制为2M
            $size = file_get_contents($idcard_zheng);
            if(strlen($size)/1024/1024 > 2){
                $error = array('errorCode'=>'3','msg'=>'idcard_zheng_photo.big_error');
                echo json_encode($error);
                die();
            };
//            生成新图片
            $idcard_z_path = $this->base64_image_content($idcard_zheng,'id_z_');
            if(!$idcard_z_path){
                $error = array('errorCode'=>'2','msg'=>'idcard_zheng_photo.invalid');
                echo json_encode($error);
                die();
            }else{
                $data['idcard_z_path'] = $idcard_z_path;
//                删除旧的图片
                unlink($photo_path['idcard_z_path']);
            }
        }

        //        身份证反面
        if($idcard_fan){
            $size = file_get_contents($idcard_fan);
            //            限制为2M
            if(strlen($size)/1024/1024 > 2){
                $error = array('errorCode'=>'3','msg'=>'idcard_zheng_photo.big_error');
                echo json_encode($error);
                die();
            };
            //            生成新图片
            $idcard_f_path =$this->base64_image_content($idcard_fan,'id_f_');
            if(!$idcard_f_path){
                $error = array('errorCode'=>'2','msg'=>'idcard_fan_photo.invalid');
                echo json_encode($error);
                die();
            }else{
                $data['idcard_f_path'] = $idcard_f_path;
//                删除旧的图片
                unlink($photo_path['idcard_f_path']);
            }
        }

        //        银行卡图片
        if($bankcard_photo){
            $size = file_get_contents($bankcard_photo);
            //            限制为2M
            if(strlen($size)/1024/1024 > 2){
                $error = array('errorCode'=>'3','msg'=>'idcard_zheng_photo.big_error');
                echo json_encode($error);
                die();
            };
            //            生成新图片
            $bank_path = $this->base64_image_content($bankcard_photo,'bank_');
            if(!$bank_path){
                $error = array('errorCode'=>'2','msg'=>'bankcard_photo.invalid');
                echo json_encode($error);
                die();
            }else{
                $data['bankphoto_path'] = $bank_path;
//                删除旧的图片
                unlink($photo_path['bankphoto_path']);
            }
        }

//        大头照
        if($big_tou){
            $size = file_get_contents($big_tou);
            //            限制为2M
            if(strlen($size)/1024/1024 > 2){
                $error = array('errorCode'=>'3','msg'=>'idcard_zheng_photo.big_error');
                echo json_encode($error);
                die();
            };
            //            生成图片
            $bt_path = $this->base64_image_content($big_tou,'bt_');
            if(!$bt_path){
                $error = array('errorCode'=>'2','msg'=>'big_tou.invalid');
                echo json_encode($error);
                die();
            }
            else{
                $data['bigphoto_path'] = $bt_path;
//                删除旧的图片
                unlink($photo_path['bigphoto_path']);
            }
        }

        $res = M('mtfour')->where(array('consumer_id'=>$user_id))->save($data);


        if(!$res){
            $error = array('errorCode'=>'1','msg'=>'save_user.false');
            echo json_encode($error);
            die();
        }else{
            $error = array('errorCode'=>'0','msg'=>'success');
            echo json_encode($error);
            die();
        }

    }

    public function index(){

    }

    /**
     * [将Base64图片转换为本地图片并保存]
     * @E-mial wuliqiang_aa@163.com
     * @TIME   2017-04-07
     * @WEB    http://blog.iinu.com.cn
     * @param  [Base64] $base64_image_content [要保存的Base64]
     * @param  [目录] $path [要保存的路径]
     */
    private function base64_image_content($base64_image_content,$label){
        //匹配出图片的格式
        if ($base64_image_content){
            $new_file = "data/userphoto/".date('Y-m-d',time())."/";
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0777);
            }
            $new_file = $new_file.$label.time().".jpg";
            if (file_put_contents($new_file, base64_decode($base64_image_content))){
                return $new_file;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}