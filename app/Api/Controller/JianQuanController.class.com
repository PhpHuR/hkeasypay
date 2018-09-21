<?php

namespace Api\Controller;

use \Think\Controller;

class JianQuanController extends Controller{


    protected $app_key = [
        'idcard' => 'e7a6f1111b4b6178028d387118ee77ed',//身份证实名认证
        'verifybankcard4' => 'afd7f6ce42f3e4dc5cb80c67fcf97159'// 银行卡四元素校验

    ];
    protected $urls = [
        'idcard' => 'http://op.juhe.cn/idcard/query',
        'verifybankcard4' => 'http://v.juhe.cn/verifybankcard4/query'

    ];

    protected $key = [
        'idcard' => 'Gdgs657DFgsrHSD8549ASDffgh88',
        'verifybankcard4' => 'Ada48Qdf549adfQER6548Aadf6579',
    ];

    protected $api = '';

    protected $input = [];

    protected $params = [];

    function _initialize()
    {
        $api = I('POST.api');
        if(!isset($this->app_key[$api])){
            $error = array('error_code'=>'1','msg'=>"wrong api");
            echo json_encode($error);
            die;
        }

        $curl_sign = I('post.sign');
        $fields = [];
        $fields['idcard'] = ['realname','idcard'];
        $fields['verifybankcard4'] = ['realname','idcard','bankcard','mobile'];
        $postData = array();
        $sign_str = $api;
        foreach($fields[$api] as $k => $v){
            if(!isset($_POST[$v])||$_POST[$v]==''){
                $error = array('error_code'=>'1','msg'=>"wrong input {$v}");
                echo json_encode($error);
                die;
            }
            $postData[$v] = $_POST[$v];
            $sign_str .= $_POST[$v];
        }
        $sign_str .= $this->key[$api];

        $sign_md5 = strtoupper(MD5($sign_str));
        if($curl_sign !== $sign_md5){
            $error = array('error_code'=>'1','msg'=>"wrong sign");
            echo json_encode($error);
            die;
        }
        $this->api = $api;
        $this->input = $postData;
    }

    public function index()
    {
        $this->setParams();
        $post_str = build_post_str($this->params);
        $url = $this->urls[$this->api];
        $resp = go_curl($url,'post',$post_str);

        echo $resp;
    }

    protected function setParams()
    {
        $data = [];
        $data['key'] = $this->app_key[$this->api];

        switch ($this->api) {

            case 'youshu':
                $data['name'] = urlencode($this->input['name']);
                break;

            case 'verifyface':
                $data['realname'] = $this->input['realname'] ;
                $data['idcard'] = $this->input['idcard'] ;
                $data['image'] = $this->input['image'] ;
                break;

            case 'telecom':
                $data['realname'] = $this->input['realname'] ;
                $data['idcard'] = $this->input['idcard'] ;
                $data['mobile'] = $this->input['mobile'] ;
                break;

            case 'idimage':
                $data['image'] = $this->input['image'] ;
                $data['side'] = $this->input['side'] ;
                break;

            case 'idcard':
                $data['realname'] = $this->input['realname'] ;
                $data['idcard'] = $this->input['idcard'] ;
                break;

            case 'verifybankcard4':
                $data['realname'] = $this->input['realname'] ;
                $data['idcard'] = $this->input['idcard'] ;
                $data['bankcard'] = $this->input['bankcard'] ;
                $data['mobile'] = $this->input['mobile'] ;
                break;

            default:

                break;

        }

        $this->params = $data;

    }

}