<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>后台管理</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome必须的css -->
	<link rel="stylesheet" href="/public/ace/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/public/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="/public/ace/css/titatoggle-dist-min.css" />
	<link rel="stylesheet" href="/public/index/css/xiugai.css" />
	<link rel="stylesheet" href="/public/ace/icon/iconfont.css" />
	<link rel="stylesheet" href="/public/sldate/daterangepicker-bs3.css" />
	<!-- 此页插件css -->

	<!-- ace的css -->
	<link rel="stylesheet" href="/public/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
	<!-- IE版本小于9的ace的css -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" href="/public/ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
	<![endif]-->

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="/public/ace/css/ace-ie.css" />
	<![endif]-->

	<link rel="stylesheet" href="/public/yfcmf/yfcmf.css" />
	<!-- 此页相关css -->

	<!-- ace设置处理的css -->

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="/public/others/html5shiv.min.js"></script>
	<script src="/public/others/respond.min.js"></script>
	<![endif]-->
    <!-- 引入基本的js -->
    <script type="text/javascript">
        var admin_ueditor_handle = "<?php echo U('Sys/upload');?>";
        var admin_ueditor_lang ='zh-cn';
    </script>
    <!--[if !IE]> -->
    <script src="/public/others/jquery.min-2.2.1.js"></script>
    <!-- <![endif]-->
    <!-- 如果为IE,则引入jq1.12.1 -->
    <!--[if IE]>
    <script src="/public/others/jquery.min-1.12.1.js"></script>
    <![endif]-->

    <!-- 如果为触屏,则引入jquery.mobile -->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='/public/others/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/public/others/bootstrap.min.js"></script>
</head>

<body class="no-skin">
<div class="bgback"></div>
<!-- 导航栏开始 -->
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-container" id="navbar-container">
		<!-- 导航左侧按钮手机样式开始 -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button><!-- 导航左侧按钮手机样式结束 -->
		<button data-target="#sidebar2" data-toggle="collapse" type="button" class="pull-left navbar-toggle collapsed">
			<span class="sr-only">Toggle sidebar</span>
			<i class="ace-icon fa fa-dashboard white bigger-125"></i>
		</button>

		<!-- 导航栏开始 -->
		<div class="navbar-buttons navbar-header" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey">
					<i class="iconfont icon-tubiaozhizuomoban-1"></i>
					<a href="<?php echo U('Home/index/index');?>" target="_blank">
						前台首页
					</a>
				</li>

				<li class="green">
					<i class="iconfont icon-email"></i>
					<a href="<?php echo U('Sys/emailsys');?>">
						邮件连接
					</a>
				</li>
				<li class="white">
					<i class="iconfont icon-denglu-copy"></i>
					<a href="<?php echo U('Sys/oauthsys');?>">
						第三方登录
					</a>
				</li>
				<li class="gold">
					<i class="iconfont icon-shenqingchengweiVIP"></i>
					<a href="<?php echo U('Sys/profile');?>">
						会员中心
					</a>
				</li>
				<li class="blue">
					<i class="iconfont icon-3701mima"></i>
					<a href="<?php echo U('Userinfo/password');?>">
						修改密码
					</a>
				</li>
				<li class="red3">
					<i class="iconfont icon-dianyuan"></i>
					<a href="<?php echo U('Login/logout');?>">
						注销
					</a>
				</li>
			</ul>
		</div><!-- 导航栏结束 -->
	</div><!-- 导航栏容器结束 -->
</div><!-- 导航栏结束 -->

<!-- 整个页面内容开始 -->
<div class="main-container" id="main-container">
	<!-- 菜单栏开始 -->
	<div id="sidebar" class="sidebar blackbg responsive sidebar-fixed">
	<!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">-->
		<!--&lt;!&ndash;左侧顶端按钮&ndash;&gt;-->
		<!--<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">-->
			<!--<a class="btn btn-success" href="<?php echo U('News/news_list');?>" role="button" title="文章列表"><i class="ace-icon fa fa-signal"></i></a>-->
			<!--<a class="btn btn-info" href="<?php echo U('News/news_add');?>" role="button" title="添加文章"><i class="ace-icon fa fa-pencil"></i></a>-->
			<!--<a class="btn btn-warning" href="<?php echo U('Member/member_list');?>" role="button" title="会员列表"><i class="ace-icon fa fa-users"></i></a>-->
			<!--<a class="btn btn-danger" href="<?php echo U('Sys/sys');?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>-->
		<!--</div>-->
		<!--&lt;!&ndash;左侧顶端按钮（手机）&ndash;&gt;-->
		<!--<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">-->
			<!--<a class="btn btn-success" href="<?php echo U('News/news_list');?>" role="button" title="文章列表"></a>-->
			<!--<a class="btn btn-info" href="<?php echo U('News/news_add');?>" role="button" title="添加文章"></a>-->
			<!--<a class="btn btn-warning" href="<?php echo U('Member/member_list');?>" role="button" title="会员列表"></a>-->
			<!--<a class="btn btn-danger" href="<?php echo U('Sys/sys');?>" role="button" title="站点设置"></a>-->
		<!--</div>-->
	<!--</div>-->
	<!-- 用户菜单开始 -->
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
					<?php echo ($_SESSION['admin_username']); ?>
				</div>
			</a>
		</div>
	</div>
	<!-- 用户菜单结束 -->
	<!-- 菜单列表开始 -->
	<ul class="nav nav-list">
		<!--一级菜单遍历开始-->
		<?php if(is_array($menus)): foreach($menus as $key=>$v): if(!empty($v['_child'])): ?><li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>open<?php endif; ?>">
			<a href="#" class="dropdown-toggle">
				<i class="iconfont <?php echo ($v["css"]); ?>"></i>
				<span class="menu-text"><?php echo ($v["title"]); ?></span>
				<b class="arrow fa fa-angle-down"></b>
			</a>
			<ul class="submenu">
				<!--二级菜单遍历开始-->
				<?php if(is_array($v["_child"])): foreach($v["_child"] as $key=>$vv): if(!empty($vv['_child'])): ?><li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active open<?php endif; ?>">
					<a href="<?php echo U($vv['name']);?>" class="dropdown-toggle">
						<!--<i class="menu-icon fa fa-caret-right"></i>-->
						<?php echo ($vv["title"]); ?>
						<!--<b class="arrow fa fa-angle-down"></b>-->
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<!--三级菜单遍历开始-->
						<?php if(is_array($vv["_child"])): foreach($vv["_child"] as $key=>$vvv): ?><li class="<?php if((count($menus_curr) >= 3) AND ($menus_curr[2] == $vvv['id'])): ?>active<?php endif; ?>">
							<a href="<?php echo U($vvv['name']);?>">
								<!--<i class="menu-icon fa fa-caret-right"></i>-->
								<?php echo ($vvv["title"]); ?>
							</a>
							<b class="arrow"></b>
							</li><?php endforeach; endif; ?><!--三级菜单遍历结束-->
					</ul>
					</li>
					<?php else: ?>
					<li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active<?php endif; ?>">
					<a href="<?php echo U($vv['name']);?>">
						<!--<i class="menu-icon fa fa-caret-right"></i>-->
						<?php echo ($vv["title"]); ?>
					</a>
					<b class="arrow"></b>
					</li><?php endif; endforeach; endif; ?><!--二级菜单遍历结束-->
			</ul>
			</li>
			<?php else: ?>
			<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">
			<a href="<?php echo U($v['name']);?>">
				<i class="menu-icon fa fa-caret-right"></i>
				<?php echo ($v["title"]); ?>
			</a>
			<b class="arrow"></b>
			</li><?php endif; endforeach; endif; ?><!--一级菜单遍历结束-->
		<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">

		<a href="<?php echo U('Sys/clear');?>" class="confirm-rst-btn" data-info="确定要清理缓存吗？">
			<i class="menu-icon iconfont icon-qingchu"></i>
			清除缓存
		</a>
		<b class="arrow"></b>
		</li>
	</ul><!-- 菜单列表结束 -->

	<!-- 菜单栏缩进开始 -->
	<!--<div class="sidebar-collapse" id="sidebar-collapse">-->
		<!--<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>-->
	<!--</div>&lt;!&ndash; 菜单栏缩进结束 &ndash;&gt;-->
</div>
	<!-- 菜单栏结束 -->

	<!-- 主要内容开始 -->
	<div class="main-content">
		<div class="main-content-inner">
			<!-- 右侧主要内容页顶部标题栏开始 -->
			<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse sidebar-fixed menu-min" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
	<div class="nav-wrap-up pos-rel" style="color: #fff">
		<div class="nav-wrap">
			<ul class="nav nav-list">
				<li>
					<a href="/">
						<o class="font12">首页</o>
					</a>
					<i class="iconfont icon-youbian"></i>
				</li>
				<?php if($id_curr != ''): if(is_array($menus_name)): foreach($menus_name as $n=>$k): ?><li>
					<a href="<?php echo U(''.$k['name'].'');?>">
					<o class="font12"><?php echo ($k["title"]); ?></o>
					</a>
				<?php if($count != $n): ?><i class="iconfont icon-youbian"></i><?php endif; ?>
				</li><?php endforeach; endif; ?>
				<?php else: ?>
				<li>
					<a href="<?php echo U('Index/index');?>">
						<o style="font-size: 20px">hi 欢迎使用<?php echo ($sys["site_name"]); ?>后台系统管理</o>
					</a>
					<b class="arrow"></b>
				</li><?php endif; ?>
			</ul>
		</div>
	</div><!-- /.nav-list -->
</div>
			<!-- 右侧主要内容页顶部标题栏结束 -->

			<!-- 右侧下主要内容开始 -->
			
    <div class="page-content">

        <link rel="stylesheet" type="text/css" media="all" href="/public/sldate/daterangepicker-bs3.css"/>
        <form name="admin_list_sea" class="form-search form-horizontal" method="post" action="<?php echo U('payin_list');?>">
            <div class="row maintop">
                <div class="fl_right">
                    <div class="white" style="position:relative;z-index: 1050;top: -51px">
                        <input type="text" name="key" id="key" class="admin_search bgtouming" value="<?php echo ($keyy); ?>" placeholder="输入需查询的关键字" />
                        <span class="ace-icon fa fa-search icon-on-right bigger-110 ace-pos"></span>
                        <span>
							<button type="submit" class="select_search">
								显示全部
							</button>
						</span>
                    </div>
                </div>
                <div class="liangzipao">
                    <?php if(is_array($menus_child)): foreach($menus_child as $k=>$v): if($k == 0): ?><div class="mega"><a href="<?php echo U(''.$v['name'].'');?>" class="freedom" ><?php echo ($v['title']); ?></a></div>
                            <?php else: ?>
                            <div class="mega" style="background-color: rgba(255,255,255,0.1)"><a href="<?php echo U(''.$v['name'].'');?>" class="freedom"><?php echo ($v['title']); ?></a></div><?php endif; endforeach; endif; ?>
                    <div class="clear"></div>
                </div>
                <div style="margin-top: 30px">
                    <div class="col-xs-4 col-sm-2 hidden-xs btn-sespan">
                        <div class="input-group">
                        <span class="back_wh1 dis_pad">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar" style="color: #fff;"></i></span>
                            <input type="text" name="reservation" id="reservation" class="sl-date back_wh1" style="color: #fff;margin-left: 15px" value="<?php echo ($sldate); ?>"
                                   placeholder="点击选择日期范围"/>
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-1 hidden-xs btn-sespan">
                        <div class="input-group">
                            <select name="mid" class="form-control search-query admin_sea back_wh1" style="border-radius: 2px;color:#fff">
                                <option value="">商户名称</option>
                                <?php if(is_array($mid_list)): foreach($mid_list as $key=>$v): ?><option value="<?php echo ($v["user_id"]); ?>" <?php if($midd == $v['user_id']): ?>selected<?php endif; ?>><?php echo ($v["member_name"]); ?></option><?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-1 hidden-xs btn-sespan" style="margin-left: 15px">
                        <div class="input-group">
                            <select name="payment_id" class="form-control search-query admin_sea back_wh1" style="color:#fff;border-radius: 2px">
                                <option value="">支付公司名称</option>
                                <?php if(is_array($payment_list)): foreach($payment_list as $key=>$v): ?><option value="<?php echo ($v["api_id"]); ?>" <?php if($payment_idd == $v['api_id']): ?>selected<?php endif; ?>><?php echo ($v["api_china_name"]); ?></option><?php endforeach; endif; ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-xs-4 col-sm-1 hidden-xs btn-sespan">
                        <div class="input-group">
                            <select name="payment_mid" class="form-control search-query admin_sea back_wh1" style="color:#fff;border-radius: 2px">
                                <option value="">MID名称</option>
                                <?php if(is_array($payment_mid_list)): foreach($payment_mid_list as $key=>$v): ?><option value="<?php echo ($v["m_id"]); ?>" <?php if($payment_midd == $v['m_id']): ?>selected<?php endif; ?>><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
                            </select>

                        </div>
                    </div>

                    <div class="col-xs-2 col-sm-1 hidden-xs btn-sespan">
                        <div class="input-group">
                            <select name="paybank" class="form-control search-query admin_sea back_wh1" style="color:#fff;border-radius: 2px">
                                <option value="">入金方式</option>
                                <option value="alipay" <?php if($paybankk == 'alipay'): ?>selected="selected"<?php endif; ?>>支付寶</option>
                                <option value="weixin" <?php if($paybankk == 'weixin'): ?>selected="selected"<?php endif; ?> >微信</option>
                                <option value="netgate" <?php if($paybankk == 'netgate'): ?>selected="selected"<?php endif; ?> >網關</option>
                            </select>
                        </div>
                    </div>

                    <span>
                    <button type="submit" class="select_search white" style="font-size: 15px">
                        确认
                    </button>
                </span>
                    <a class="btn btn-sm btn-blue" style="margin-left: 15px" href="<?php echo U('select',array('action'=>'export','reservation'=>$sldate,'mid'=>$midd));?>"
                       title="导出报表">
                        <i class="iconfont icon-chakantiezigengduofenxiang"></i>
                        <span class="bigger-110 no-text-shadow">导出报表</span>
                    </a>
                </div>


            </div>
        </form>

        <div class="row">
            <div class="col-xs-12">
                <div>
                    <table class="urllist white" id="dynamic-table">
                        <thead>
                        <tr>
                            <td class="hidden-sm hidden-xs "><p>ID</p></td>
                            <th class="hidden-xs hidden-sm"><p>创建时间|交易时间</p></th>
                            <th class="hidden-xs hidden-sm"><p>平台訂單號|客戶訂單號碼</p></th>
                            <th class="hidden-xs hidden-sm"><p>商戶ID|商戶名稱</p></th>
                            <th class="hidden-xs hidden-sm"><p>支付公司 | 入金MID名稱</p></th>
                            <th class="hidden-sm hidden-xs "><p>貨幣</p></th>
                            <th class="hidden-sm hidden-xs "><p>入金金額</p></th>
                            <th class="hidden-sm hidden-xs "><p>入金手續費</p></th>
                            <th class="hidden-xs hidden-sm"><p>支付人姓名</p></th>
                            <th class="hidden-xs hidden-sm"><p>支付人电话</p></th>
                            <th class="hidden-xs hidden-sm"><p>支付人身份证</p></th>
                            <th class="hidden-xs hidden-sm"><p>支付人银行卡</p></th>
                            <th class="hidden-sm hidden-xs "><p>訂單狀態</p></th>
                            <th class="hidden-sm hidden-xs "><p>通知狀態</p></th>
                            <th class="hidden-sm hidden-xs "><p>入金銀行</p></th>
                            <th class="hidden-sm hidden-xs "><p>備註</p></th>
                            <th class="hidden-sm hidden-xs "><p>提交交式</p></th>
                            <th class="hidden-sm hidden-xs "><p>代理</p></th>
                            <th class="hidden-sm hidden-xs "><p>詳情</p></th>
                            <th class="hidden-sm hidden-xs "><p>补单</p></th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php if(is_array($select_list)): foreach($select_list as $key=>$v): ?><tr>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["payin_id"]); ?></p></td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                        <?php echo (date("Y-m-d H:i:s",$v["begin_time"])); ?>
                                        <br>
                                        <?php if(empty($v['end_time'])): else: ?>  <?php echo (date("Y-m-d H:i:s",$v["end_time"])); endif; ?>
                                    </div>
                                </td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                        <?php echo ($v["orderid"]); ?>
                                        <br />
                                        <?php echo ($v["transid"]); ?>
                                    </div>
                                </td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                        <?php echo ($v["uid"]); ?>
                                        <br />
                                        <?php echo (getUserinfoName($v["uid"])); ?>
                                    </div>
                                </td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                        <?php echo ($v["api_china_name"]); ?><br/>
                                        <?php echo ($v["title"]); ?>
                                    </div>
                                </td>
                                <td class="hidden-sm hidden-xs"><p><?php echo (getCurrencyName($v["currency_id"])); ?></p></td>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["ordermoney"]); ?></p></td>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["free"]); ?></p></td>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["realname"]); ?></p></td>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["mobile"]); ?></p></td>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["idcard"]); ?></p></td>
                                <td class="hidden-sm hidden-xs"><p><?php echo ($v["bankcard"]); ?></p></td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                        <?php switch($v["status"]): case "1": ?><span
                                                    class="">成功</span><?php break;?>
                                            <?php case "-1": ?><span class="label label-sm label-fiale">支付失败</span><?php break;?>
                                            <?php case "2": ?><span
                                                    class="label label-info arrowed-right arrowed-in">退款中</span><?php break;?>
                                            <?php case "3": ?><span class="label label-danger arrowed">退款失败</span><?php break;?>
                                            <?php case "4": ?><span class="label label-sm label-success">退款成功</span><?php break;?>
                                            <?php default: ?>
                                            <span class="label label-sm label-inverse arrowed-in">待支付</span><?php endswitch;?>
                                    </div>
                                </td>
                                <td class="hidden-sm">
                                    <div class="border_margin">
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <?php if($v['status'] == 1): if($v['notice_status'] == 1 ): ?><div>
                                                    <button class="btn btn-minier btn-yellow">已通知</button>
                                                </div>
                                                <?php else: ?>
                                                <a class="red payin-state-btn" href="<?php echo U('select_state');?>"
                                                   data-id="<?php echo ($v["payin_id"]); ?>" title="未通知">
                                                    <div id="zt<?php echo ($v["payin_id"]); ?>">
                                                        <button class="btn btn-minier btn-danger">未通知</button>
                                                    </div>
                                                </a><?php endif; endif; ?>
                                    </div>
                                    </div>
                                </td>
                                <td class="hidden-sm hidden-xs"><div class="border_margin"><?php echo (getBankName($v["paybank"])); ?></div></td>
                                <td class="hidden-sm hidden-xs"><div class="border_margin"><?php echo ($v["remark"]); ?></div></td>
                                <td class="hidden-sm hidden-xs"><div class="border_margin"><?php echo ($v["payin_method"]); ?></div></td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                    <?php if($v['agsettle_status'] == 1 ): ?><div>
                                            <span class="">已结算</span>
                                        </div>
                                        <?php else: ?>
                                        <div>
                                            <span class="label label-sm label-inverse arrowed-in">未结算</span>
                                        </div>
                                        </a><?php endif; ?>
                                    </div>
                                </td>
                                <td class="hidden-sm hidden-xs">
                                    <div class="border_margin">
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="green payin-btn" href="<?php echo U('select');?>" data-id="<?php echo ($v["payin_id"]); ?>"
                                           title="詳情">
                                            <i class="ace-icon fa fa-flag bigger-120"></i>
                                        </a>
                                    </div>
                                    <div class="hidden-md hidden-lg">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" data-position="auto">
                                                <i class="ace-icon fa fa-flag bigger-120"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="<?php echo U('select');?>" data-id="<?php echo ($v["payin_id"]); ?>"
                                                       class="tooltip-success payout-btn" data-rel="tooltip" title=""
                                                       data-original-title="詳情">
																	<span class="green">
																		<i class="ace-icon fa fa-pencil bigger-120"></i>
																	</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    </div>
                                </td>
                                <td class="hidden-sm" id="h<?php echo ($v["id"]); ?>">
                                    <div class="border_margin">
                                        <?php if($v['status'] == 0): ?><a class="red open-btn" href="<?php echo U('orderRepairRight');?>" data-id="<?php echo ($v["payin_id"]); ?>" title="未补单">
                                                <div id="zt<?php echo ($v["payin_id"]); ?>"><button class="btn btn-minier btn-yellow">未补单</button></div>
                                            </a>
                                            <?php else: ?>
                                            <a class="red open-btn" href="<?php echo U('orderRepairRight');?>" data-id="<?php echo ($v["payin_id"]); ?>" title="已补单">
                                                <div id="zt<?php echo ($v["payin_id"]); ?>"><button class="btn btn-minier btn-danger">已补单</button></div>
                                            </a><?php endif; ?>
                                    </div>
                                </td>
                            </tr><?php endforeach; endif; ?>
                        <tr>
                            <td class="hidden-sm hidden-xs"><p>成功</p></td>
                            <td class="hidden-sm hidden-xs"><p>訂單總數：<?php echo ($num); ?></p></td>
                            <td class="hidden-sm hidden-xs" colspan="2"><p>成功金額：<?php echo (number_format($a_OrderMoney,2,'.',',')); ?></p></td>
                            <td class="hidden-sm hidden-xs" colspan="3"><p>成功手續費：<?php echo (number_format($a_free,2,'.',',')); ?></p></td>
                            <td class="hidden-sm hidden-xs" colspan="3"><p>公司佣金：<?php echo (number_format($c_free,2,'.',',')); ?></p></td>
                            <td class="hidden-sm hidden-xs" colspan="2"><p>代理佣金：<?php echo (number_format($ag_free,2,'.',',')); ?></p></td>
                            <td class="hidden-sm hidden-xs" colspan="7"><p> 結算金額：<?php echo (number_format($a_OrderMoney-$a_free,2,'.',',')); ?></p></td>
                        </tr>
                        <tr>
                            <td height="50" colspan="15" align="left">

                                <?php echo ($page); ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div><!-- /.page-content -->

    <!-- 显示模态框（Modal） -->
    <div class="modal fade in" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-backdrop fade in" id="gbbb" style="height: 100%;"></div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="gb" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">
                        訂單詳情
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1">
                                    系統訂單號： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="orderid" id="orderid" value="" class="col-xs-10" readonly
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1">
                                    客戶訂單號： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="transid" id="transid" value="" class="col-xs-10 " readonly
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1">
                                    入金銀行： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="paybank" id="paybank" value="" class="col-xs-10 " readonly
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1">
                                    訂單金額： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="ordermoney" id="ordermoney" readonly class="col-xs-10 "
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1">
                                    訂單創建時間： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="begin_time" id="begin_time" value="" class="col-xs-10 "
                                           readonly required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1">
                                    訂單完成時間： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="end_time" id="end_time" value="" class="col-xs-10 "
                                           readonly required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> 手續費： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="free" id="free" value="" class="col-xs-10 " readonly
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> 狀態： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="status" id="status" value="" class="col-xs-10 " readonly
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> 備註： </label>
                                <div class="col-sm-8">
                                    <input type="text" name="remark" id="remark" value="" class="col-xs-10 " readonly
                                           required/>
                                </div>
                            </div>
                            <div class="space-4"></div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="gbb">
                        关闭
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


			<!-- 右侧下主要内容结束 -->
		</div>
	</div><!-- 主要内容结束 -->
	<!-- 页脚开始 -->
	<!--<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<span class="blue bolder">HKEASYPAY</span>
				后台管理系统 &copy; 2015-<?php echo date('Y');?>
			</span>
		</div>
	</div>
</div>-->
	<!-- 页脚结束 -->
	<!-- 返回顶端开始 -->
	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
	<!-- 返回顶端结束 -->
</div><!-- 整个页面内结束 -->
<!-- ace的js,可以通过打包生成,避免引入文件数多 -->
<script src="/public/ace/js/ace.min.js"></script>
<!-- jquery.form、layer、yfcmf的js -->
<script src="/public/others/jquery.form.js"></script>
<script src="/public/others/maxlength.js"></script>
<script src="/public/layer/layer.js"></script>
<?php $t=time(); ?>
<script src="/public/yfcmf/yfcmf.js?<?php echo ($t); ?>"></script>
<!-- 此页相关插件js -->

    <script type="text/javascript" src="/public/sldate/moment.js"></script>
    <script type="text/javascript" src="/public/sldate/daterangepicker.js"></script>
    <script type="text/javascript">
        $('#reservation').daterangepicker(null, function (start, end, label) {

        });
    </script>

<!-- 与此页相关的js -->
<script>
    var height = new Array();
    $("#dynamic-table").children("tbody").children("tr").each(function(){
        $(this).children('td').children('p').each(function(key){
            var hgt = $(this).height();
            height[key] = hgt;
        });
        if(hgt == undefined){{
            $(this).children('td').children('.border_margin').each(function(key){
                var hgt = $(this).height();
                height[key] = hgt;
            });
		}}

//        获取数组最大值
        var hgt = Math.max.apply(null,height);

        $(this).children("td").children(".border_margin").height(hgt);
        $(this).children("td").children("p").height(hgt);
//        $(this).children("td").children(".border_margin").css('line-height',hgt+'px');
    });
    $("#dynamic-table").children("thead").children("tr").each(function(){
        $(this).children('th').children('p').each(function(key){
            var hgt = $(this).height();
            height[key] = hgt;
        });
        if(hgt == undefined){{
            $(this).children('th').children('.border_margin').each(function(key){
                var hgt = $(this).height();
                height[key] = hgt;
            });
        }}
        //        获取数组最大值
        var hgt = Math.max.apply(null,height);

        $(this).children("th").children(".border_margin").height(hgt);
        $(this).children("th").children("p").height(hgt);
    });
</script>
</body>
</html>