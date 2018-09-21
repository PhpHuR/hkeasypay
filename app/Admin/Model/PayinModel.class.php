<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;


use Think\Model\RelationModel;

class PayinModel extends RelationModel
{
    protected $_link=array(
        'Payment_mid' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_mid',
            'foreign_key'   => 'payment_mid',
            'as_fields'  => 'title',
        ),
        'Payment_name' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_name',
            'foreign_key'   => 'payment_id',
            'as_fields'  => 'api_china_name',
        ),
    );

}