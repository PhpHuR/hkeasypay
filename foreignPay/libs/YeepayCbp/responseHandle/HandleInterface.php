<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午7:00
 */

namespace YeepayCbp\responseHandle;


interface HandleInterface {
    public function handle($data=array());
} 