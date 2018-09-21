<?php
/**
 * 
 *  
 * PHP Version 5
 *
 * @category  Class
 * @file      YeepayServiceProvider.php
 * @package yeepayCbp
 * @author    chao.ma <chao.ma@ehking.com>

 */

namespace YeepayCbp;

class YeepayServiceProvider implements ServiceProviderInterface, ControllerProviderInterface{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {


        $app['ehking.onlinepay_controller'] = $app->share(function(){
            return  new OnlinePayController();
        });

    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" utils (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];


        $app->post('/onlinepay/order','ehking.onlinepay_controller:orderAction')
            ->bind('onlinepay_order');
        $app->post('/onlinepay/query','ehking.onlinepay_controller:queryAction')
            ->bind('onlinepay_query');
        $app->post('/onlinepay/refund','ehking.onlinepay_controller:refundAction')
            ->bind('onlinepay_refund');
        $app->post('/onlinepay/refundQuery','ehking.onlinepay_controller:refundQueryAction')
            ->bind('onlinepay_refund_query');

        return $controllers;
    }


} 