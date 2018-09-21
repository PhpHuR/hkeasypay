<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="app">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo ($site_seo_title); ?> <?php echo ($site_name); ?></title>
    <meta name="keywords" content="<?php echo ($site_seo_keywords); ?>" />
    <meta name="description" content="<?php echo ($site_seo_description); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link href="/public/touming/images/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" href="/public/touming/js/datepicker/datepicker.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/animate.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/icon.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/font.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/xin.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/style.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/js/calendar/bootstrap_calendar.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/js/chosen/chosen.css" type="text/css"/>
    <link rel="stylesheet" href="/public/touming/css/style-themecolor.css" type="text/css"/>
    <link rel="stylesheet" href="/public/sldate/daterangepicker-bs3.css" />

    <!--自定义页面样式-->
    <link rel="stylesheet" href="/public/yfcmf/yfcmf.css" />
    <!-- 此页相关css -->
    <!--[if lt IE 9]>
    <script src="/public/touming/js/ie/html5shiv.js"></script>
    <script src="/public/touming/js/ie/respond.min.js"></script>
    <script src="/public/touming/js/ie/excanvas.js"></script>
    <![endif]-->

    <script type="text/javascript">
        function initArray() {
            for (i = 0; i < initArray.arguments.length; i++)
                this[i] = initArray.arguments[i];
        }
        today = new Date();
        hrs = today.getHours();
        min = today.getMinutes();
        sec = today.getSeconds();
        clckh = "" + ((hrs > 12) ? hrs - 12 : hrs);
        clckm = ((min < 10) ? "0" : "") + min;
        clcks = ((sec < 10) ? "0" : "") + sec;
        clck = (hrs >= 12) ? "下午" : "上午";
        var stnr = "";
        var ns = "0123456789";
        var a = "";

        function getFullYear(d) {
            yr = d.getYear();
            if (yr < 1000)
                yr += 1900;
            return yr;
        }
    </script>

</head>
<body class="">
<div class="bgback"></div>
<section class="vbox">
    <header >
        <!--<div class="navbar-header aside-md dk">-->
            <!--<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">-->
                <!--<i class="fa fa-bars"></i>-->
            <!--</a>-->

            <!--<a href="/" class="navbar-brand">-->
                <!--<?php if(!empty($site_logo)): ?>-->
                    <!--&lt;!&ndash;<img src="<?php echo ($site_logo); ?>" alt="logo" class="clogo">&ndash;&gt;-->
                    <!--<?php else: ?>-->
                    <!--<img src="<?php echo ($yf_theme_path); ?>Public/images/logo.png" alt="logo" class="clogo">-->
                <!--<?php endif; ?>-->
            <!--</a>-->

            <!--<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">-->
                <!--<i class="fa fa-cog"></i>-->
            <!--</a>-->
        <!--</div>-->
        <!--<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">-->

            <!--<?php if($user['member_list_id'] > 0): ?>-->

                <!--<li class="dropdown">-->
                    <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
             <!--<span class="thumb-sm avatar pull-left">-->
                 <!--<?php if(empty($user['member_list_headpic'])): ?>-->
                     <!--<img src="/public/touming/images/avatar.png">-->
                     <!--<?php elseif(stripos($user['member_list_headpic'],'://')): ?>-->
                     <!--<img src="/data/upload/avatar/<?php echo ($user["member_list_headpic"]); ?>" class="img-thumbnail headicon"/>-->
                 <!--<?php endif; ?>-->
            <!--</span>-->
                        <!--<?php echo ($user['member_list_username']); ?> - <?php echo (getUserinfoName($user['member_list_userinfoid'])); ?><b class="caret"></b><span class="systemdt">-->
			<!--<script type="text/javascript">-->
                <!--document.write((getFullYear(today) + "").substring(0, 4) + "-" + (today.getMonth() + 1) + "-" + today.getDate() + "&nbsp;");-->
                <!--document.write(hrs + ":" + clckm + ":" + clcks);-->
            <!--</script></span><br>-->

                    <!--</a>-->
                    <!--<ul class="dropdown-menu animated fadeInDown">-->
                        <!--<span class="arrow top"></span>-->
                        <!--<li>-->
                        <!--<li class="divider"></li>-->
                        <!--<li style="padding-left:15px">-->
                            <!--<a href="#" class="inline no-padder"><img src="/public/touming/images/lang_hk.png"></a>-->
                            <!--<a href="#" class="inline no-padder"><img src="/public/touming/images/lang_cn.png"></a>-->
                            <!--<a href="#" class="inline no-padder"><img src="/public/touming/images/lang_en.png"></a>-->
                        <!--</li>-->
                        <!--<li class="divider"></li>-->
                        <!--<li>-->
                            <!--<a href="<?php echo UU('Login/logout');?>" style="font-weight:bold">登出</a>-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</li>-->

                <!--<?php else: ?>-->

                <!--<li class="dropdown">-->
                    <!--<a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
             <!--<span class="thumb-sm avatar pull-left">-->
              <!--<img src="/public/touming/images/avatar.png">-->
            <!--</span>-->
                        <!--登錄 <b class="caret"></b><span class="systemdt">-->
			<!--<script type="text/javascript">-->
                <!--document.write((getFullYear(today) + "").substring(0, 4) + "-" + (today.getMonth() + 1) + "-" + today.getDate() + "&nbsp;");-->
                <!--document.write(hrs + ":" + clckm + ":" + clcks);-->
            <!--</script></span><br>-->

                    <!--</a>-->
                    <!--<ul class="dropdown-menu animated fadeInDown">-->
                        <!--<span class="arrow top"></span>-->

                        <!--<li>-->
                            <!--<a href="<?php echo UU('Login/index');?>" style="font-weight:bold">登錄</a>-->
                        <!--</li>-->
                    <!--</ul>-->
                <!--</li>-->

            <!--<?php endif; ?>-->

        <!--</ul>-->
    </header>
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-black aside-md hidden-print" id="nav">
                <section class="vbox">
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0"
                             data-size="10px" data-railOpacity="0.2">

<!-- nav -->
<nav class="nav-primary hidden-xs">
    <div>
        <!-- 导航左侧正常样式开始 -->
        <div style="padding: 5px 0">
            <!-- logo -->
            <a href="<?php echo U('Index/index');?>" class="hkeasypay">
                <div>
                    <i class="fa fa-leaf"></i>
                    HKEASYPAY
                </div>
            </a>
        </div><!-- 导航左侧正常样式结束 -->
        <div class="user-img">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <?php if($_SESSION['admin_avatar'] != ''): ?><img class="nav-user-photo radius-img" style="margin: 10px 0" src="/data/upload/avatar/<?php echo ($_SESSION['admin_avatar']); ?>" alt="<?php echo ($_SESSION['admin_username']); ?>" />
                    <?php else: ?>
                    <img class="nav-user-photo radius-img" style="margin: 10px 0" src="/public/img/girl.jpg" alt="<?php echo ($_SESSION['admin_username']); ?>" /><?php endif; ?>
                <div class="user-info">
                    <small>欢迎,</small>
                    <?php echo ($_SESSION['user']['member_list_username']); ?>
                </div>
            </a>
            <ul class="dropdown-menu animated fadeInDown">
                <span class="arrow top"></span>
                <li>
                <li class="divider"></li>
                <li style="padding-left:15px">
                    <a href="#" class="inline no-padder"><img src="/public/touming/images/lang_hk.png"></a>
                    <a href="#" class="inline no-padder"><img src="/public/touming/images/lang_cn.png"></a>
                    <a href="#" class="inline no-padder"><img src="/public/touming/images/lang_en.png"></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo UU('Login/logout');?>" style="font-weight:bold">登出</a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="nav nav-main" data-ride="collapse">
        <!--一级菜单遍历开始-->

        <?php if(is_array($menus)): foreach($menus as $key=>$v): if(!empty($v['_child'])): ?><li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa <?php echo ($v["css"]); ?>"></i>
                <span class="font-bold"><?php echo ($v["title"]); ?></span>
            </a>
            <ul class="nav dk">
                <!--二级菜单遍历开始-->
                <?php if(is_array($v["_child"])): foreach($v["_child"] as $key=>$vv): if(!empty($vv['_child'])): ?><li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active<?php endif; ?>">
                    <a href="#" class="dropdown-toggle">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <span><?php echo ($vv["title"]); ?></span>
                    </a>
                    <ul class="nav dk">
                        <!--三级菜单遍历开始-->
                        <?php if(is_array($vv["_child"])): foreach($vv["_child"] as $key=>$vvv): ?><li class="<?php if((count($menus_curr) >= 3) AND ($menus_curr[2] == $vvv['id'])): ?>active<?php endif; ?>">
                            <a href="<?php echo U($vvv['name']);?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                <span><?php echo ($vvv["title"]); ?></span>
                            </a>
                            </li><?php endforeach; endif; ?><!--三级菜单遍历结束-->
                    </ul>
                    </li>
                    <?php else: ?>
                    <li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active<?php endif; ?>">
                    <a href="<?php echo U($vv['name']);?>">
                        <i class="menu-icon fa fa-caret-right"></i>
                        <?php echo ($vv["title"]); ?>
                    </a>
                    <b class="arrow"></b>
                    </li><?php endif; endforeach; endif; ?><!--二级菜单遍历结束-->
            </ul>
            </li>
            <?php else: ?>
            <li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">
            <a href="<?php echo U($v['name']);?>">
                <i class="fa fa-angle-right icon"></i>
                 <span class="font-bold"><?php echo ($v["title"]); ?></span>
            </a>
            <b class="arrow"></b>
            </li><?php endif; endforeach; endif; ?><!--一级菜单遍历结束-->

       <!-- <li class="active"> <a href="balance.php" class="auto"> <i class="i i-stack icon"></i> <span class="font-bold">帳戶餘額</span> </a> </li>
        <li> <a href="payin-history.php" class="auto"> <i class="i i-login icon"></i> <span class="font-bold">入金紀錄</span> </a> </li>
        <li> <a href="payout-history.php" class="auto"> <i class="i i-logout icon"></i> <span class="font-bold">出金紀錄</span> </a> </li>
        <li>
            <a href="#" class="auto">
                <i class="fa fa-calendar"></i>
                <span class="font-bold">報告</span>
            </a>
            <ul class="nav dk">
                <li>
                    <a href="daily-report.php" class="auto">
                        <i class="fa fa-angle-right icon"></i>
                        <span>每日報告</span>
                    </a>
                </li>

                <li>
                    <a href="monthly-report.php" class="auto">
                        <i class="fa fa-angle-right icon"></i>
                        <span>每月報告</span>
                    </a>
                </li>

                <li>
                    <a href="total-report.php" class="auto">
                        <i class="fa fa-angle-right icon"></i>
                        <span>累計報告</span>
                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="#" class="auto">
                <i class="i i-retweet icon"></i>
                <span class="font-bold">出金訂單</span>
            </a>
            <ul class="nav dk">
                <li>
                    <a href="payout-order.php" class="auto">
                        <i class="fa fa-angle-right icon"></i>
                        <span>出金訂單</span>
                    </a>
                </li>

                <li>
                    <a href="payout-order-batch.php" class="auto">
                        <i class="fa fa-angle-right icon"></i>
                        <span>批量出金</span>
                    </a>
                </li>

                <li>
                    <a href="payout-order-history.php" class="auto">
                        <i class="fa fa-angle-right icon"></i>
                        <span>出金紀錄</span>
                    </a>
                </li>

            </ul>
        </li>-->
        <!--<li> <a href="cross-border-settlement-report.php" class="auto"> <i class="fa fa-random"></i> <span class="font-bold">跨境結算報表</span> </a> </li>-->
    </ul>





</nav>
<!-- / nav -->
</section>
<footer class="footer hidden-xs no-padder text-center-nav-xs">
    <div class="pd-md copyright hidden-nav-xs hide" id="moreless-copyright"><span class="hidden-nav-xs">&copy; <script>document.write(new Date().getFullYear())</script> HKEASYPAY. <br>All rights reserved.</span></div>
    <a href="#moreless-copyright" data-toggle="class:show" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs hidden-nav-xs">
        <i class="i i-info"></i>
    </a>
    <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive pull-right m-l-xs m-r-xs">
        <i class="i i-circleleft text"></i>
        <i class="i i-circleright text-active"></i>
    </a>
</footer>
</section>
</aside>
<!-- / aside -->

<section id="content" class="modal-open">
    <section class="hbox stretch">
        <section class="vbox">

            <section class="scrollable padder remittance-form">
                <div class="m-b-md">
                    <span class="white font20">帳戶餘額</span>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="m-b-md">
                            <span class="white font20">结余</span>
                        </div>
                        <section class="panel-default">
                            <div class="table-responsive evenodd tabledata" style="overflow:auto">
                                <table class="urllist white">
                                    <thead>
                                    <tr>
                                        <th width="16%"><div class="border_top border_dashed text-center">貨幣</div></th>
                                        <th width="29%"><div class="border_top border_dashed text-center">帳面餘額</div></th>
                                        <th width="29%"><div class="border_top text-center">可用餘額</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($userinfo)): $i = 0; $__LIST__ = $userinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td><div class="border_margin text-center"><?php echo (getCurrencyName($vo["currency_id"])); ?></div></td>
                                            <td><div class="border_margin text-center"><?php echo (number_format($vo["sumcount"],2,'.',',')); ?></div></td>
                                            <td><div class="border_margin text-center"><?php echo (number_format($vo["availablecount"],2,'.',',')); ?></div></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <div class="m-b-md">
                            <span class="white font20">今日匯價</span>
                        </div>
                        <section class="panel-default">
                            <div class="table-responsive evenodd tabledata" style="overflow:auto">
                                <table class="urllist white">
                                    <thead>
                                    <tr>
                                        <th width="16%"><div class="border_top border_dashed text-center">貨幣</div></th>
                                        <th width="29%"><div class="border_top border_dashed text-center">賣出價</div></th>
                                        <th width="29%"><div class="border_top text-center">買入價</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($curofferList)): $i = 0; $__LIST__ = $curofferList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                            <td><div class="border_margin text-center"><?php echo ($v["currency_code"]); ?></div></td>
                                            <td><div class="border_margin text-center"><?php echo ($v["cursell"]); ?></div></td>
                                            <td><div class="border_margin text-center"><?php echo ($v["curbuy"]); ?></div></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <div class="m-b-md">
                            <span class="white font20">子賬號</span>
                        </div>
                        <section class="panel-default">
                            <div class="table-responsive evenodd tabledata" style="overflow:auto">
                                <table class="urllist white">
                                    <thead>
                                    <tr>
                                        <th width="16%"><div class="border_top border_dashed text-center">貨幣</div></th>
                                        <th width="29%"><div class="border_top border_dashed text-center">名稱</div></th>
                                        <th width="29%"><div class="border_top text-center">可用餘額</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($sub_userinfo)): $i = 0; $__LIST__ = $sub_userinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><tr>
                                            <td><div class="border_margin text-center"><?php echo (getCurrencyName($va["currency_id"])); ?></div></td>
                                            <td><div class="border_margin text-center"><?php echo (getSubUserBalanceAttributeName($va["attribute"])); ?></div></td>
                                            <td><div class="border_margin text-center"><?php echo (number_format($va["sub_user_balance"],2,'.',',')); ?></div></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>


                        <div class="m-b-md">
                            <span class="white font20">今日收支</span>
                        </div>
                        <section class="panel-default">
                            <div class="table-responsive evenodd tabledata" style="overflow:auto">
                                <table class="urllist white">
                                    <thead>
                                    <tr>
                                        <th style="min-width:80px"><div class="border_top border_dashed text-center">入金</div></th>
                                        <th style="min-width:80px"><div class="border_top border_dashed text-center">入金手續費</div></th>
                            <th style="min-width:80px"><div class="border_top border_dashed text-center">出金</div></th>
                            <th style="min-width:80px"><div class="border_top text-center">出金手續費</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div class="border_margin text-center"><?php echo (getCurrencyName($vo["currency_id"])); ?> <?php echo (number_format($payin_order_sum,2,'.',',')); ?></div></td>
                                        <td><div class="border_margin text-center"><?php echo (getCurrencyName($vo["currency_id"])); ?> <?php echo (number_format($payin_order_free,2,'.',',')); ?></div></td>
                                        <td><div class="border_margin text-center"><?php echo (getCurrencyName($vo["currency_id"])); ?> <?php echo (number_format($payout_order_sum,2,'.',',')); ?></div></td>
                                        <td><div class="border_margin text-center"><?php echo (getCurrencyName($vo["currency_id"])); ?> <?php echo (number_format($payout_order_free,2,'.',',')); ?></div></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <div class="m-b-md">
                            <span class="white font20">帳戶明細</span>
                        </div>
                        <div style="width: 100%;position: relative;min-height: 1px">
                            <form name="admin_list_sea" class="form-search" method="post" action="<?php echo U('info');?>">
                                <div class="main-top" style="margin-top: 20px">
                                    <div class="hidden-xs btn-sespan fl_left">
                                        <div class="input-group">
                        <span class="back_wh1 dis_pad">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar" style="color: #fff;"></i></span>
                                            <input type="text" name="reservation" id="reservation" class="sl-date back_wh1" style="color: #fff;padding-left: 15px;margin-left: 15px" value="<?php echo ($sldate); ?>"
                                                   placeholder="点击选择日期范围"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-1 hidden-xs btn-sespan">
                                        <div class="input-group">
                                            <select name="status" class="form-control search-query admin_sea back_wh1" style="border-radius: 2px;">
                                                <?php if(is_array($userinfo)): $i = 0; $__LIST__ = $userinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><option value="<?php echo (getCurrencyName($v1["currency_id"])); ?>"><?php echo (getCurrencyName($v1["currency_id"])); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 hidden-xs btn-sespan" style="width: 18%;">
                                        <div class="input-group" style="width: 100%;">
                                            <input type="text" name="key" class="back_wh1 white" value="<?php echo ($keyy); ?>" style="padding:5px;width: 100%;" placeholder="输入订单ID" />

                                        </div>
                                    </div>
                                    <div class="fl_left">
                                        <button type="submit" class="btn-default back_wh1 inline btn-square" style="margin-left: 7px;font-size: 18px;width: 30px;height: 30px;border-radius: 2px">
                                            <i class="fa fa-search" style="color:#fff"></i>
                                        </button>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        <section class="panel-default">
                            <div class="table-responsive evenodd tabledata" style="overflow:auto">
                                <table class="urllist white" id="dynamic-table">
                                    <thead>
                                    <tr>
                                        <th style="min-width:80px"><div class="border_top">日期</div></th>
                                        <th style="min-width:80px"><div class="border_top">時間</div></th>
                                        <th style="min-width:80px"><div class="border_top">訂單號</div></th>
                                        <th><div class="border_top">貨幣</div></th>
                                        <th><div class="border_top">入金</div></th>
                                        <th><div class="border_top">出金</div></th>
                                        <th><div class="border_top">交易類型</div></th>
                                        <th><div class="border_top">帳面餘額</div></th>
                                        <th class="text-center"><div class="border_top">備註</div></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($order_log_list)): foreach($order_log_list as $key=>$v): ?><tr>
                                            <td><div class="border_margin"><?php echo (date("Y-m-d",$v["end_time"])); ?></div></td>
                                            <td><div class="border_margin"><?php echo (date("H:i:s",$v["end_time"])); ?></div></td>
                                            <td><div class="border_margin"><?php echo ($v["orderid"]); ?></div></td>
                                            <td><div class="border_margin"><?php echo (getCurrencyName($v["currency_id"])); ?></div></td>
                                            <td><div class="border_margin"><?php echo (number_format($v["income"],2,'.',',')); ?></div></td>
                                            <td><div class="border_margin"><?php echo (number_format($v["outlay"],2,'.',',')); ?></div></td>
                                            <td>
                                                <div class="border_margin">
                                                <?php switch($v["t_type"]): case "1": ?><span class="text-success">入金</span><?php break;?>
                                                    <?php case "2": ?><span class="red">出金</span><?php break;?>
                                                    <?php case "3": ?><span class="text-error">手續費</span><?php break; endswitch;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="border_margin">
                                                <?php echo (number_format($v["balance"],2,'.',',')); ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="border_margin">
                                                    <?php echo ($v["remark"]); ?>
                                                </div>
                                            </td>
                                        </tr><?php endforeach; endif; ?>
                                    <tr>
                                        <td height="50" colspan="12" align="left"><?php echo ($page); ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</section>




</section><!--END hbox stretch-->

<!-- 基本的js -->
<!--[if !IE]> -->
<script src="/public/others/jquery.min-2.2.1.js"></script>
<!-- <![endif]-->
<!-- 如果为IE,则引入jq1.12.1 -->
<!--[if IE]>
<script src="/public/others/jquery.min-1.12.1.js"></script>
<![endif]-->
<!-- jquery.form、layer、yfcmf的js -->
<script src="/public/others/jquery.form.js"></script>
<script src="/public/layer/layer.js"></script>
<script src="/public/yfcmf/yfcmf.js"></script>


<script src="/public/touming/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/public/touming/js/bootstrap.js"></script>

<!-- slider -->
<script src="/public/touming/js/slider/bootstrap-slider.js"></script>

<!-- App -->
<script src="/public/touming/js/app.js"></script>
<script src="/public/touming/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/public/touming/js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
<script src="/public/touming/js/charts/sparkline/jquery.sparkline.min.js"></script>
<script src="/public/touming/js/charts/flot/jquery.flot.min.js"></script>
<script src="/public/touming/js/charts/flot/jquery.flot.tooltip.min.js"></script>
<script src="/public/touming/js/charts/flot/jquery.flot.spline.js"></script>
<script src="/public/touming/js/charts/flot/jquery.flot.pie.min.js"></script>
<script src="/public/touming/js/charts/flot/jquery.flot.resize.js"></script>
<script src="/public/touming/js/charts/flot/jquery.flot.grow.js"></script>
<script src="/public/touming/js/charts/flot/demo.js"></script>

<!-- wizard -->
<script src="/public/touming/js/parsley/parsley.min.js"></script>
<script src="/public/touming/js/wizard/jquery.bootstrap.wizard.js"></script>

<!-- datepicker -->
<script src="/public/touming/js/datepicker/bootstrap-datepicker.js"></script>

<!-- file input -->
<script src="/public/touming/js/file-input/bootstrap-filestyle.min.js"></script>


<script src="/public/touming/js/calendar/bootstrap_calendar.js"></script>
<script src="/public/touming/js/calendar/demo.js"></script>
<script src="/public/touming/js/sortable/jquery.sortable.js"></script>

<!-- wysiwyg -->
<script src="/public/touming/js/wysiwyg/jquery.hotkeys.js"></script>
<script src="/public/touming/js/wysiwyg/bootstrap-wysiwyg.js"></script>
<script src="/public/touming/js/wysiwyg/demo.js"></script>

<!-- markdown -->
<script src="/public/touming/js/markdown/epiceditor.min.js"></script>
<script src="/public/touming/js/markdown/demo.js"></script>

<script src="/public/touming/js/chosen/chosen.jquery.min.js"></script>
<script src="/public/touming/js/app.plugin.js"></script>
<!--Region-->
<script type="text/javascript" src="/public/others/region.js"></script>
<!-- themes color -->
<script type="text/javascript" src="/public/touming/js/changeskin.js"></script>

<!--彈出插件-->
<script src="/public/others/jquery.form.js"></script>
<script src="/public/layer/layer.js"></script>
<script src="/public/yfcmf/yfcmf.js"></script>
<script src="/public/plugins/jquery.blockUI.js"></script>

<script type="text/javascript">
    // When the document is ready
    $(document).ready(function () {
        $('#datepicker-months-start').datepicker({

            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"

        });
    });
</script>
<script type="text/javascript">
    // When the document is ready
    $(document).ready(function () {
        $('#datepicker-months-end').datepicker({
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        });
    });

</script>
<script type="text/javascript" src="/public/sldate/moment.js"></script>
<script type="text/javascript" src="/public/sldate/daterangepicker.js"></script>
<script type="text/javascript">
    $('#reservation').daterangepicker(null, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
    });

    var height = new Array();
    $("#dynamic-table").children("tbody").children("tr").each(function(){
        $(this).children('td').each(function(key){
            var hgt = $(this).height();
            height[key] = hgt;
        });

//        获取数组最大值
        var hgt = Math.max.apply(null,height);
        console.log(hgt);
        $(this).children("td").children(".border_margin").height(hgt);
//        $(this).children("td").children(".border_margin").css('line-height',hgt+'px');
    });

    $("#dynamic-table").children("thead").children("tr").each(function(){
        $(this).children('th').each(function(key){
            var hgt = $(this).height();
            height[key] = hgt;
        });

//        获取数组最大值
        var hgt = Math.max.apply(null,height);
        console.log(hgt);
        $(this).children("th").children(".border_top").height(hgt);
//        $(this).children("td").children(".border_margin").css('line-height',hgt+'px');
    });
</script>
</body>
</html>