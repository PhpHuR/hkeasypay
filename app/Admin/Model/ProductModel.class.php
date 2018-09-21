<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;


use Think\Model\RelationModel;

class ProductModel extends RelationModel
{
    protected $_link=array(
        'Product_category' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Product_category',
            'foreign_key'   => 'product_category_id',
            'as_fields'  => 'category_title',
        ),
        'Payin_rate' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payin_rate',
            'foreign_key'   => 'payin_rate_id',
            'as_fields'  => 'inrate',
        ),
        'Payment_mid' => array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'    => 'Payment_mid',
            'foreign_key'   => 'payment_mid',
            'as_fields'  => 'title',
        ),
    );

}