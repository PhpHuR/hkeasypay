<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Agent\Controller;

use Agent\Controller\LoginbaseController;
use Think\Verify;
use Org\Util\Stringnew;

class LoginController extends LoginbaseController
{

    function index()
    {

        if (session('hid')) {
            redirect(__ROOT__ . "/Agent");
        } else {
            $this->display("User:login");
        }
    }

    //验证码
    public function verify()
    {
        if (session('hid')) {
            redirect(__ROOT__ . "/Agent");
        }
        ob_end_clean();
        $verify = new Verify (array(
            'fontSize' => 20,
            'imageH' => 40,
            'imageW' => 150,
            'length' => 4,
            'useCurve' => false,
        ));
        $verify->entry('hid');
    }

    /*
     * 退出登录
     */
    public function logout()
    {
        session('hid', null);
        session('user', null);
        redirect(__ROOT__ . "/Agent");
    }

    //登录验证
    function runlogin()
    {
        $agent_list_username = I('agent_list_username');
        $agent_list_pwd = I('agent_list_pwd');
        $verify = new Verify ();
        if (!$verify->check(I('verify'), 'hid')) {
            $this->error('验证码错误', 0, 0);
        }
        $agent_model = M("agent_list");
        $rules = array(
            //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
            array('agent_list_username', 'require', '用户名不能为空！', 1),
            array('agent_list_pwd', 'require', '密码不能为空！', 1),

        );
        if ($agent_model->validate($rules)->create() === false) {
            $this->error($agent_model->getError(), 0, 0);
        }
        $where['agent_list_username'] = $agent_list_username;
        $agent = $agent_model->where($where)->find();


        if (!$agent || encrypt_password($agent_list_pwd, $agent['agent_list_salt']) !== $agent['agent_list_pwd']) {
            $this->error('用户名或者密码错误，重新输入', 0, 0);
        } else {
            session('hid', $agent['agent_list_id']);
            session('user', $agent);
            $this->success('登陆成功', U('/Agent'), 1);
        }
    }

    function forgot_pwd()
    {
        $this->display("User:forgot_pwd");
    }

    //验证码
    public function verify_forgot()
    {
        if (session('hid')) {
            redirect(__ROOT__ . "/");
        }
        ob_end_clean();
        $verify = new Verify (array(
            'fontSize' => 20,
            'imageH' => 40,
            'imageW' => 150,
            'length' => 4,
            'useCurve' => false,
        ));
        $verify->entry('forgot');
    }

    function runforgot_pwd()
    {
        if (IS_POST) {
            $member_list_email = I('member_list_email');
            $member_list_username = I('member_list_username');
            $verify = new Verify ();
            if (!$verify->check(I('verify'), 'forgot')) {
                $this->error('验证码错误', 0, 0);
            }
            $users_model = M("member_list");
            $rules = array(
                //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
                array('member_list_email', 'require', '邮箱不能为空！', 1),
                array('member_list_email', 'email', '邮箱格式不正确！', 1), // 验证email字段格式是否正确
            );
            if ($users_model->validate($rules)->create() === false) {
                $this->error($users_model->getError(), 0, 0);
            } else {
                $find_user = $users_model->where(array("member_list_username" => $member_list_username))->find();
                if ($find_user) {
                    if (empty($find_user['member_list_email'])) {
                        //先更新字段邮箱
                        $users_model->where(array("member_list_username" => $member_list_username))->setField('member_list_email', $member_list_email);
                        $find_user['member_list_email'] = $member_list_email;
                    }
                    if ($find_user['member_list_email'] == $member_list_email) {
                        //发送重置密码邮件
                        $activekey = md5($find_user['member_list_id'] . time() . uniqid());//激活码
                        $result = $users_model->where(array("member_list_id" => $find_user['member_list_id']))->save(array("user_activation_key" => $activekey));
                        if (!$result) {
                            $this->error('激活码生成失败！', 0, 0);
                        }
                        //生成激活链接
                        $url = U('Login/pwd_reset', array("hash" => $activekey), "", true);
                        $template = <<<hello
									#username#，你好！<br>
									请点击或复制下面链接进行密码重置：<br>
									<a href="http://#link#">http://#link#</a>
hello;
                        $content = str_replace(array('http://#link#', '#username#'), array($url, $member_list_username), $template);
                        $send_result = sendMail($member_list_email, 'YFCMF密码重置', $content);
                        if ($send_result['error']) {
                            $this->error('密码重置发送失败，请尝试登录后，手动发送激活邮件！', 0, 0);
                        } else {
                            $this->success('密码重置发送成功,请查收邮件并激活', U('Index/index'), 1);
                        }
                    } else {
                        $this->error("邮箱与注册邮箱不一致", 0, 0);
                    }
                } else {
                    $this->error("用户不存在！", 0, 0);
                }
            }
        }
    }

    function pwd_reset()
    {
        $users_model = M("member_list");
        $hash = I("get.hash");
        $find_user = $users_model->where(array("user_activation_key" => $hash))->find();
        if (empty($find_user)) {
            $this->error('重置码无效！', U('Index/index'), 0);
        } else {
            $this->assign("hash", $hash);
            $this->display("User:pwd_reset");
        }
    }

    //验证码
    public function verify_reset()
    {
        if (session('hid')) {
            redirect(__ROOT__ . "/");
        }
        ob_end_clean();
        $verify = new Verify (array(
            'fontSize' => 20,
            'imageH' => 40,
            'imageW' => 150,
            'length' => 4,
            'useCurve' => false,
        ));
        $verify->entry('pwd_reset');
    }

    function runpwd_reset()
    {
        if (IS_POST) {
            $verify = new Verify ();
            if (!$verify->check(I('verify'), 'pwd_reset')) {
                $this->error('验证码错误', 0, 0);
            }
            $users_model = M("member_list");
            $rules = array(
                //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
                array('password', 'require', '密码不能为空！', 1),
                array('password', 'number', '密码长度最小5位,最大20位！', 1, '5,20'),
                array('repassword', 'require', '重复密码不能为空！', 1),
                array('repassword', 'password', '确认密码不正确', 0, 'confirm'),
                array('hash', 'require', '重复密码激活码不能空！', 1),
            );
            if ($users_model->validate($rules)->create() === false) {
                $this->error($users_model->getError(), 0, 0);
            } else {
                $password = I('password');
                $hash = I('hash');
                $member_list_salt = Stringnew::randString(10);
                $member_list_pwd = encrypt_password($password, $member_list_salt);
                $result = $users_model->where(array("user_activation_key" => $hash))->save(array('member_list_pwd' => $member_list_pwd, 'user_activation_key' => '', 'member_list_salt' => $member_list_salt));
                if ($result) {
                    $this->success("密码重置成功，请登录！", U("Login/index"), 1);
                } else {
                    $this->error("密码重置失败，重置码无效！", 0, 0);
                }
            }
        }
    }
//	function check_active(){
//		$this->check_login();
//		if($this->user['user_status']){
//			if ($this->user['member_list_groupid'] == '4') {
//				redirect(U('Payout/turnFoAuditOrderPage'));
//			}else{
//				session('hid',null);
//				session('user',null);
//				$this->error("登陆失败，请确认登陆地址！",U("Login/index"),0);
//			}
//
//		}else{
//			//判断是否激活
//			$this->display("User:active");
//		}
//	}
    //重发激活邮件
    function resend()
    {
        $this->check_login();
        $current_user = $this->user;
        $users_model = M('member_list');
        if ($current_user['user_status'] == 0) {
            if ($current_user['member_list_email']) {
                $active_options = get_active_options();
                $activekey = md5($current_user['member_list_id'] . time() . uniqid());//激活码
                $result = $users_model->where(array("member_list_id" => $current_user['member_list_id']))->save(array("user_activation_key" => $activekey));
                if (!$result) {
                    $this->error('激活码生成失败！', 0, 0);
                }
                //生成激活链接
                $url = U('Register/active', array("hash" => $activekey), "", true);
                $template = $active_options['email_tpl'];
                $content = str_replace(array('http://#link#', '#username#'), array($url, $current_user['member_list_username']), $template);
                $send_result = sendMail($current_user['member_list_email'], $active_options['email_title'], $content);
                if ($send_result['error']) {
                    $this->error('激活邮件发送失败，请尝试登录后，手动发送激活邮件！', 0, 0);
                } else {
                    $this->success('激活邮件发送成功,请查收邮件并激活', U('Login/index'), 1);
                }
            } else {
                $this->error('您的账号未设置邮箱，无法激活！', U('Login/index'), 0);
            }
        } else {
            $this->error('您的账号已经激活，无需再次激活！', U('Index/index'), 0);
        }
    }
}