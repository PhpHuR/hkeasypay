<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Admin\Model;


use Think\Model\RelationModel;

class CronModel extends RelationModel
{
    protected $_link=array(
        'Userinfo' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Userinfo',
            'foreign_key'   => 'user_id',
            'as_fields'  => 'member_name',
        ),
    );

}