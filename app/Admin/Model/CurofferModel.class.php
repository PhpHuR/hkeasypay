<?php

namespace Admin\Model;
use Think\Model\RelationModel;

class CurofferModel extends RelationModel{
    private $host = 'localhost';
    private $dataname = 'newhkeasypay';
    private $username = 'newhkeasypay';
    private $password = 'hkpay12138';

    public function close(){
        $this->db->close();
    }

    function reconnect(){
//            重新连接数据库
//        new \PDO('mysql:host=localhost;dbname='.$this->dataname, $this->username, $this->password);

    }
}