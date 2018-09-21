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
        <!--主题-->
        <div class="row">
            <div class="liangzipao">
                <?php if(is_array($menus_child)): foreach($menus_child as $k=>$v): if($k == 0): ?><div class="mega" style="background-color: rgba(255,255,255,0.1)"><a href="<?php echo U(''.$v['name'].'');?>" class="freedom" ><?php echo ($v['title']); ?></a></div>
                        <?php else: ?>
                        <div class="mega"><a href="<?php echo U(''.$v['name'].'');?>" class="freedom"><?php echo ($v['title']); ?></a></div><?php endif; endforeach; endif; ?>
                <div class="clear"></div>
            </div>
            <div class="box_chujin white">
                <form class="form-horizontal ajaxForm2" name="turnOneToBankPage" method="post"
                      action="<?php echo U('turnOneToBankPage');?>">
                    <div class="fl_left w50">
                        <input type="hidden" name="type" id="id" value="1"/>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 所属商户： </label>
                            <div class="col-sm-10">
                                <select name="member_list_userinfoid"  class="w93 selector bgtouming radius4" id="user_id" >
                                    <option value="">请选择所属商户</option>
                                    <?php if(is_array($userinfo)): foreach($userinfo as $key=>$v): ?><option value="<?php echo ($v["user_id"]); ?>" <?php if($v['user_id'] == $member_list_edit.member_list_userinfoid): ?>selected<?php endif; ?>><?php echo ($v["member_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 貨幣類型： </label>
                            <div class="col-sm-10">
                                <select name="currency_id"  class="w93 selector bgtouming radius4" id="currency_id">
                                    <option value="">请选择貨幣類型</option>
                                    <?php if(is_array($currency_list)): foreach($currency_list as $key=>$va): ?><option value="<?php echo ($va["ccy_id"]); ?>" ><?php echo ($va["ccy_code"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 可用餘額： </label>
                            <div class="col-sm-10">
                                <input type="text" name="balance" id="balance" value=""
                                       class="col-xs-10 bgtouming w93" readonly/>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 子账号： </label>
                            <div class="col-sm-10">
                                <select name="sub_balance" style="border-radius: 4px" class="bgtouming w93 selector" id="sub_balance">
                                    <option value="">请选择子账号</option>
                                    <?php if(is_array($sub_user_list)): foreach($sub_user_list as $key=>$vb): ?><option value="<?php echo ($vb["ccy_id"]); ?>" ><?php echo ($vb["ccy_code"]); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1">子账号-可用餘額： </label>
                            <div class="col-sm-10">
                                <input type="text" name="user_sub_balance" id="user_sub_balance" value=""
                                       class="bgtouming col-xs-10 w93" readonly/>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <!-- #section:plugins/input.chosen -->

                        <!-- #section:plugins/input.chosen -->
                        <div class="form-group" style="padding-top: 5px">
                            <div class="no-padding-right fl_left" style="font-size: 14px" for="form-field-select-3"> 收款方银行名称： </div>
                            <!--<label for="form-field-select-3">Chosen</label>-->
                            <div class="col-sm-10 fl_left">
                                <select name="bankname" class="yinghang col-xs-10 col-sm-4" id="form-field-select-3" data-placeholder="選擇收款银行...">
                                    <option value="">选择收款银行</option>
                                    <option value="gonghang">工商银行</option>
                                    <option value="jianhang">建设银行</option>
                                    <option value="nonghang">农业银行</option>
                                    <option value="zhaohang">招商银行</option>
                                    <option value="zhonghang">中国银行</option>
                                    <option value="pufa">浦发银行</option>
                                    <option value="jiaohang">交通银行</option>
                                    <option value="minsheng">民生银行</option>
                                    <option value="xingye">兴业银行</option>
                                    <option value="guangda">光大银行</option>
                                    <option value="guangfa">广发银行</option>
                                    <option value="zhongxin">中信银行</option>
                                    <option value="chuxu">邮政储蓄</option>
                                    <option value="shenfa">平安银行</option>
                                    <option value="beijing">北京银行</option>
                                    <option value="shanghai">上海银行</option>
                                    <option value="bjnongshang">北京农商银行</option>
                                    <option value="huaxia">华夏银行</option>
                                    <option value="nanjing">南京银行</option>
                                    <option value="bohai">渤海银行</option>
                                    <option value="hangzhou">杭州银行</option>
                                    <option value="shnongshang">上海农村商业银行</option>
                                    <option value="zheshang">浙商银行</option>
                                    <option value="other">其他银行</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <!-- /section:plugins/input.chosen -->
                    </div>
                    <div class="fl_left w50">
                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 收款方开户行： </label>
                            <div class="col-sm-10">
                                <select name="proname" class="bgtouming radius4" id="province"
                                        onChange="loadRegion('province',2,'city','<?php echo U('Ajax/getRegion');?>');">
                                    <option value="0" selected>省份/直辖市</option>
                                    <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <select name="cityname" class="bgtouming radius4" id="city"
                                        onchange="loadRegion('city',3,'town','<?php echo U('Ajax/getRegion');?>');">
                                    <option value="0">市/县</option>
                                </select>
                                <select name="townname" class="bgtouming radius4" id="town">
                                    <option value="0">镇/区</option>
                                </select>
                                <input type="text" name="reaccdept" class="bgtouming fenhang" id="reaccdept" placeholder="分行名"/>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 收款方银行开户名： </label>
                            <div class="col-sm-10">
                                <input type="text" name="reaccname" id="reaccname" placeholder="收款方-银行-开户名"
                                       class="col-xs-10 bgtouming w93" required/>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group">
                            <label class="w20 no-padding-right" for="form-field-1"> 收款方银行帐号： </label>
                            <div class="col-sm-10">
                                <input type="text" name="reaccno" id="reaccno" placeholder="收款方银行帐号"
                                       class="col-xs-10 bgtouming w93" required/>
                            </div>
                        </div>
                        <div class="space-4"></div>
                    <div class="form-group">
                        <label class="w20 no-padding-right" for="form-field-1"> 付款金额 (元)： </label>
                        <div class="col-sm-10">
                            <input type="text" name="transfermoney" id="transfermoney" placeholder="付款金额 (元)"
                                   class="col-xs-10 bgtouming w93" required/>
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="w20 no-padding-right" for="form-field-1"> 备注： </label>
                        <div class="col-sm-10">
                            <input type="text" name="remark" id="remark" placeholder="备注"
                                   class="col-xs-10 bgtouming w93"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                保存
                            </button>
                            &nbsp; &nbsp; &nbsp;
                            <button class="btn" type="reset">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                重置
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- /.page-content -->

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

    <script type="text/javascript" src="/public/others/region.js"></script>
    <script type="text/javascript" src="/public/chosen/chosen.jquery.js"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect: true});
                //resize the chosen on window resize
                $(window)
                        .off('resize.chosen')
                        .on('resize.chosen', function () {
                            $('.chosen-select').each(function () {
                                var $this = $(this);
                                $this.next().css;
                            })
                        }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function (e, event_name, event_val) {
                    if (event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function () {
                        var $this = $(this);
                        $this.next().css;
                    })
                });

            }

        });

        $(document).ready(function () {
            $("#currency_id").bind('input', function () {
                $.post("/Admin/Ajax/getBalance", {
                            user_id: $("#user_id").val(),
                            currency_id: $(this).val(),
                        },
                        function (data, status) {
                            if (status == "success") {
                                $("#balance").val(data.availablecount);
                            } else {
                                alert("数据: \n" + data + "\n状态: " + status);
                            }
                        });
            });
        });

        $(document).ready(function () {
            $("#user_id").bind('input', function () {
                $.post("/Admin/Ajax/getSubuser", {
                            currency_id: $("#currency_id").val(),
                            user_id: $(this).val(),
                        },
                        function (data, status) {
                            if (status == "success") {
                                alert(data);
                            } else {
                                alert("数据: \n" + data + "\n状态: " + status);
                            }
                        });
            });
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