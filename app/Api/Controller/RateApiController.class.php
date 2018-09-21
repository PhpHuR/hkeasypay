<?php

namespace Api\Controller;


use Think\Controller;

class RateApiController extends Controller{
    public function curbuy(){
        echo 'success';
        $data['curbuy']=I('post.curbuy');
        $data['cursell']=I('post.cursell');
        $data['update_at']=I('post.update_at');
        if($data['curbuy'] != 0 || $data['cursell'] != 0){
            $res = M('curoffer')->where(array('user_id'=>8813))->save($data);
            $res1 = M('curoffer')->where(array('user_id'=>8814))->save($data);
        }
    }
}