<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Org\Util\Stringnew;
use Home\Controller\HomebaseController;
class MemberController extends HomebaseController
{
    public function member_list()
    {
        $key=I('key');
        $map['member_list_username'] = array('like',"%".$key."%");
        $map['member_list_email'] = array('like',"%".$key."%");
        $map['_logic'] = 'OR';
        /*
         * 分页操作
         */
        $count= M('member_list')->where($map)->count();// 查询满足要求的总记录数
        $Page= new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
        $show= $Page->show();// 分页显示输出
        $member_list=D('Member_list')->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('member_list_addtime desc')->relation(true)->select();

        $this->assign('member_list',$member_list);
        $this->assign('page',$show);
        $this->assign('val',$key);
        $this->display();

    }

    public function member_add()
    {
        if (IS_POST) {
            if (!IS_AJAX){
                $this->error('提交方式不正确',U('member_list'),0);
            }else {
                $access=M('auth_group_access');
                $member_list_salt = Stringnew::randString(10);
                $sl_data = array(
                    'member_list_groupid' => I('member_list_groupid'),
                    'member_list_username' => I('member_list_username'),
                    'member_list_userinfoid' => I('member_list_userinfoid'),
                    'member_list_salt' => $member_list_salt,
                    'member_list_pwd' => encrypt_password(I('member_list_pwd'), $member_list_salt),
                    'member_list_nickname' => I('member_list_nickname'),
                    'member_list_province' => I('member_list_province'),
                    'member_list_city' => I('member_list_city'),
                    'member_list_town' => I('member_list_town'),
                    'member_list_sex' => I('member_list_sex'),
                    'member_list_tel' => I('member_list_tel'),
                    'member_list_email' => I('member_list_email'),
                    'member_list_open' => I('member_list_open'),
                    'user_url' => I('user_url'),
                    'member_list_addtime' => time(),
                    'user_status' => I('user_status'),
                    'signature' => I('signature'),
                    'score' => I('score', 0, 'intval'),
                    'coin' => I('coin', 0, 'intval'),
                );
                $rst = M('member_list')->add($sl_data);
                $accdata=array(
                    'uid'=>$rst,
                    'group_id'=>I('member_list_groupid'),
                );
                $access->add($accdata);
                if ($access !== false) {
                    $this->success('会员添加成功', U('member_list'), 1);
                } else {
                    $this->error('会员添加失败', U('member_list'), 0);
                }
            }
        }else{
            $province = M('Region')->where ( array('pid'=>1) )->select ();
            $this->assign('province',$province);
            $userinfo = M('userinfo')->select();
            $auth_group=M('auth_group')->where(array('id'=>array('gt',2)))->select();
            $this->assign('auth_group',$auth_group);
            $this->assign('userinfo',$userinfo);
            $this->display();
        }


    }

    /*
     * 修改用户信息界面
     */
    public function member_edit(){
        $province = M('Region')->where ( array('pid'=>1) )->select ();
//		$member_group=M('member_group')->order('member_group_order')->select();
        $member_list_edit=M('member_list')->where(array('member_list_id'=>I('member_list_id')))->find();
//        $map['uid']  = array(array('eq',$member_list_edit['member_list_groupid']),array('gt',10000),'and');
        $auth_group_access=M('auth_group_access')->where(array('uid'=>array('gt',10000),'group_id'=>$member_list_edit['member_list_groupid']))->getField('group_id');

        $userinfo = M('userinfo')->select();
        $this->assign('member_list_edit',$member_list_edit);
        $this->assign('province',$province);
        $auth_group=M('auth_group')->where(array('id'=>array('gt',2)))->select();
        $this->assign('auth_group',$auth_group);
        $this->assign('userinfo',$userinfo);
        $this->assign('auth_group_access',$auth_group_access);
//		$this->assign('member_group',$member_group);
        $this->display();
    }

    /*
     * 修改用户操作
     */
    public function member_runedit(){
        if (!IS_AJAX){
            $this->error('提交方式不正确',U('member_list'),0);
        }else{

            $user_access = M('auth_group_access');

            $group_id = I('member_list_groupid');


            $sl_data['member_list_id']=I('member_list_id');
            $sl_data['member_list_groupid']=$group_id;
            $sl_data['member_list_username']=I('member_list_username');

            $pwd=I('member_list_pwd');
            if (!empty($pwd)){
                $member_list_salt=Stringnew::randString(10);
                $sl_data['member_list_salt']=$member_list_salt;
                $sl_data['member_list_pwd']=encrypt_password($pwd,$member_list_salt);
            }

            $sl_data['member_list_nickname']=I('member_list_nickname');
            $sl_data['member_list_userinfoid']=I('member_list_userinfoid');
            $sl_data['member_list_province']=I('member_list_province');
            $sl_data['member_list_city']=I('member_list_city');
            $sl_data['member_list_town']=I('member_list_town');
            $sl_data['member_list_sex']=I('member_list_sex');
            $sl_data['member_list_tel']=I('member_list_tel');
            $sl_data['member_list_email']=I('member_list_email');
            $sl_data['user_status']=I('user_status');
            $sl_data['member_list_open']=I('member_list_open');
            $sl_data['user_url']=I('user_url');
            $sl_data['signature']=I('signature');
            $sl_data['score']=I('score',0,'intval');
            $sl_data['coin']=I('coin',0,'intval');

            M('member_list')->save($sl_data);

            if ($group_id) {
                $u_access = $user_access->where(array('uid' => I('member_list_id')))->find();
                if ($u_access) {
                    //修改
                    $u_access = $user_access->where(array('uid' => I('member_list_id')))->setField('group_id', $group_id);
                } else {
                    //新增
                    $accdata = array(
                        'uid' => I('member_list_id'),
                        'group_id'=>I('member_list_groupid')
                    );
                    $u_access = $user_access->add($accdata);

                }
            }
            if($u_access!==false){
                $this->success('会员修改成功',U('member_list'),1);
            }else{
                $this->error('会员修改失败',U('member_list'),0);
            }

        }
    }

    public function member_state(){
        $id=I('x');
        $status=M('member_list')->where(array('member_list_id'=>$id))->getField('member_list_open');//判断当前状态情况
        if($status==1){
            $statedata = array('member_list_open'=>0);
            $auth_group=M('member_list')->where(array('member_list_id'=>$id))->setField($statedata);
            $this->success('状态禁止',1,1);
        }else{
            $statedata = array('member_list_open'=>1);
            $auth_group=M('member_list')->where(array('member_list_id'=>$id))->setField($statedata);
            $this->success('状态开启',1,1);
        }
    }

    public function member_active(){
        $id=I('x');
        $status=M('member_list')->where(array('member_list_id'=>$id))->getField('user_status');//判断当前状态情况
        if($status==1){
            $statedata = array('user_status'=>0);
            $auth_group=M('member_list')->where(array('member_list_id'=>$id))->setField($statedata);
            $this->success('未激活',1,1);
        }else{
            $statedata = array('user_status'=>1);
            $auth_group=M('member_list')->where(array('member_list_id'=>$id))->setField($statedata);
            $this->success('已激活',1,1);
        }
    }

    /*
 * 会员删除
 */
    public function member_del(){
        $p=I('p');
        $rst=M('member_list')->where(array('member_list_id'=>I('member_list_id')))->delete();
        if($rst!==false){
            $this->success('会员删除成功',U('member_list', array('p' => $p)),1);
        }else{
            $this->error('会员删除失败',U('member_list', array('p' => $p)),0);
        }
    }

}