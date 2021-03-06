<?php

/**
 * 通用支付接口类
 */

namespace Think;


class Pay {

    /**
     * 支付驱动实例
     * @var Object
     */
    private $payer;

    /**
     * 配置参数
     * @var type 
     */
    private $config;

    /**
     * 构造方法，用于构造上传实例
     * @param string $driver 要使用的支付驱动
     * @param array  $config 配置
     */
    public function __construct($driver, $config = array()) {
        /* 配置 */
        $pos = strrpos($driver, '\\');
        $pos = $pos === false ? 0 : $pos + 1;
        $apitype = strtolower(substr($driver, $pos));
        $this->config['notify_url'] = U("Api/Notify/notify", array('apitype' => $apitype, 'method' => 'notify'), false, true);
        $this->config['return_url'] = U("Api/Notify/notify", array('apitype' => $apitype, 'method' => 'return'), false, true);

        $config = array_merge($this->config, $config);

        /* 设置支付驱动 */
        $class = strpos($driver, '\\') ? $driver : 'Think\\Pay\\Driver\\' . ucfirst(strtolower($driver));
        $this->setDriver($class, $config);
    }

    public function buildRequestForm(Pay\PayVo $vo) {
        $this->payer->check();
        //生成本地记录数据
        $check = M("payin")->add(array(
            'uid' => $vo->getOrderNo(),
            'orderid' => $vo->getOrderNo(),
            'transid' => $vo->getOrderNo(),
            'product_name' => $vo->getOrderNo(),
            'remark' => $vo->getOrderNo(),
            'paybank' => $vo->getFee(),
            'status' => 0,
            'notifyurl' => $vo->getCallback(),
            'returnurl' => $vo->getUrl(),
            'payment_id' => serialize($vo->getParam()),
            'begin_time' => time(),
            'ordermoney' => '',
            'free' => ''
        ));

        if ($check !== false) {
            return $this->payer->buildRequestForm($vo);
        } else {
            E(M("Pay")->getDbError());
        }
    }

    /**
     * 设置支付驱动
     * @param string $class 驱动类名称
     */
    private function setDriver($class, $config) {
        $this->payer = new $class($config);
        if (!$this->payer) {
            E("不存在支付驱动：{$class}");
        }
    }

    public function __call($method, $arguments) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array(&$this, $method), $arguments);
        } elseif (!empty($this->payer) && $this->payer instanceof Pay\Pay && method_exists($this->payer, $method)) {
            return call_user_func_array(array(&$this->payer, $method), $arguments);
        }
    }

}
