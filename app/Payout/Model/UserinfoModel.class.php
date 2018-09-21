<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Payout\Model;

use Think\Model\RelationModel;

class UserinfoModel extends RelationModel
{
    protected $_link=array(
        'Payment_name' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_name',
            'foreign_key'   => 'payin_id',
            'as_fields'  => 'api_china_name',
        ),
        'Payment_mid' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_mid',
            'foreign_key'   => 'payin_mid',
            'as_fields'  => 'title',
        ),
        'Payin_rate' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payin_rate',
            'foreign_key'   => 'payin_rate',
            'as_fields'  => 'inrate',
        ),
        'Payment_name' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_name',
            'foreign_key'   => 'payout_id',
            'as_fields'  => 'api_china_name',
        ),
        'Payment_mid' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_mid',
            'foreign_key'   => 'payout_mid',
            'as_fields'  => 'title',
        ),
        'Payout_rate' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payout_rate',
            'foreign_key'   => 'payout_rate',
            'as_fields'  => 'outrate',
        ),
    );

}