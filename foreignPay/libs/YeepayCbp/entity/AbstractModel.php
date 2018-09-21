<?php
/**
 * 
 *  
 * PHP Version 5
 *
 * @category  Class
 * @file      Model.php
 * @package yeepayCbp\entity
 * @author    chao.ma <chao.ma@ehking.com>

 */

namespace YeepayCbp\entity;


abstract class AbstractModel {

    public function __toArray()
    {
        return get_object_vars($this);
    }
} 