<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Payout\Model;


use Think\Model\RelationModel;

class PayinRateModel extends RelationModel
{
    protected $_link=array(
        'Payment_name' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_name',
            'foreign_key'   => 'p_id',
            'as_fields'  => 'api_china_name',
        ),
    );

}