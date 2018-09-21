<?php
/**
 *
 *
 * PHP Version 5
 *
 * @category  Class
 * @file      query.php
 * @package ${NAMESPACE}
 * @author    chao.ma <chao.ma@ehking.com>
 */

require_once __DIR__ . '/../bootstrap.php';

$controller = new Controller\OnlinePayController();
$result = $controller->refundAction();
print_r($result);