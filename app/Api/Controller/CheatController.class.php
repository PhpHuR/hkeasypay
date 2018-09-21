<?php

namespace Api\Controller;

use \Think\Controller;

class CheatController extends Controller{
    public $token_url = 'https://zx-api.juhe.cn/oauth2/token';
    public $multi_url = 'https://zx-api.juhe.cn/multiple/v1/tasks';
    public $anti_url = 'https://zx-api.juhe.cn/antifraud/v1/tasks';

    protected $cnf = [
        'grant_type' => 'client_credentials',
        'client_id' => 'da7cecb20d0947f7a1e8c23830e1bdad',
        'client_secret' => '19bbbde9c2284ecfa5c8204df81a3062',
        'scopes' => 'carrier',
        'expires_in' => '7200',
    ];

    public $headers = [
        'token' => ['content-type:application/x-www-form-urlencoded'],
    ];

    protected $key = [
        'multiCredit' => 'Isg74987dfaSDF87dfgPsdg',
        'antiFraud' => 'ZsdgSafg4897SDFdfga264',
    ];

    public $header_app = [];

    public $token;

    public $api;

    public $input = [];

    public $allow_apis = ['multiCredit','antiFraud'];

    function _initialize()
    {
        $api = I('post.api');
        if(!in_array($api, $this->allow_apis)){
            $error = array('error_code'=>'1','msg'=>"you input a wrong api");
            echo json_encode($error);
            die;
        }

        if($api == 'multiCredit' ){
            $data['multiCredit'] = array('mobile'=>I('post.mobile'));
            $sign = strtoupper(md5($api.I('post.mobile').$this->key[$api]));
        }else{
            $data['antiFraud'] = [
                'mobile' => I('post.mobile'),//must
                'id_card' => I('post.id'),//must
                'bank' => I('post.bank'),
                'ip' => I('post.ip'),
                'name' => I('post.realname'),
            ];
            $sign = strtoupper(md5($api.I('post.mobile').I('post.id').$this->key[$api]));
        }
//        检验秘钥
        if(I('post.sign') !== $sign){
            $error = array('error_code'=>'1','msg'=>"wrong sign");
            echo json_encode($error);
            die;
        }
        $this->api = $api ;
        $this->token = $this->getToken();
        $token = $this->token;

        $this->header_app = [
            "accept: application/json",
            "authorization: Bearer {$token}",
            "content-type: application/json"
        ];

        $this->input = $data[$api];

    }


    function index()
    {
        switch ($this->api) {

            case 'multiCredit':
                $resp = $this->multiCredit();
                break;

            case 'antiFraud':
                $resp = $this->antiFraud();
                break;

            default:
                break;

        }
        echo $resp;
    }

    protected function getToken()
    {

        $post_str = build_post_str($this->cnf);
        $null = '';
        $data = go_curl($this->token_url,'post',$post_str,$null,20,array(),$this->headers['token']);
        if(!$data){
            return false;
        }

        return json_decode($data,true)["access_token"];
    }

    protected function multiCredit()  //多头借贷
    {
        if(!isset($this->input['mobile'])){
            $error = array('error_code'=>'1','msg'=>"no mobile");
            echo json_encode($error);
            die;
        }

        $header = $this->header_app;

        $post_data2 = [];
        $post_data2["mobile"] =  $this->input['mobile'];
        $post_data2["user_id"] = $this->cnf['client_id'];
        $post_data2["origin"] = 2;

        $url = $this->multi_url;
        $json = json_encode($post_data2);
        $res = $this->curlSendJson($json,$url,$header);

        return $res;

    }

    protected function antiFraud()		//反欺诈
    {
        if(!isset($this->input['mobile'])){
            $error = array('error_code'=>'1','msg'=>"no mobile");
            echo json_encode($error);
            die;
        }

        $header = $this->header_app;

        $post_data2 = [];

        $post_data2["mobile"] =  $this->input['mobile'];
        $post_data2["id_card"] = $this->input['id_card'];
        $post_data2["bank"] = $this->input['bank'];
        $post_data2["ip"] = $this->input['ip'];
        $post_data2["name"] = $this->input['name'];

        $post_data2["user_id"] = $this->cnf['client_id'];
        $post_data2["origin"] = 0;

        $url = $this->anti_url;
        $json = json_encode($post_data2);
        $res = $this->curlSendJson($json,$url,$header);


        return $res;

    }

    protected function curlSendJson($json,$url,$header)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        return $result;
    }
}