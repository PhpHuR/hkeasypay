<?php
/**
 * yeepay-简单工厂工具
 * Created by PhpStorm.
 * author    yinquan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/25
 * Time: 上午9:08
 */

namespace YeepayCbp\utils;


use YeepayCbp\exception\NullPointerException;

class FactoryUtils {
    private static $factory = null;

    public function __construct(){}

    public static function getObjectByClassName($className)
    {
        if (is_null($className)) {
            throw new NullPointerException([ 'error_description'=> 'Factory className is null']);
        }
        //工厂创建结果
        if (is_null(self::$factory)) {
            try {
                //反射方式，根据类名创建具体类
                $classExample = new \ReflectionClass($className);
                self::$factory = $classExample->newInstanceArgs();
            } catch (\Exception $e) {
                $e->getMessage();
                return null;
            }
        }
        return self::$factory;
    }
}