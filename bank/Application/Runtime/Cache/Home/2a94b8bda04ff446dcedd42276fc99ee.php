<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>globalspeedlink</title>
    <link rel="stylesheet" href="/bank/Public/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="/bank/Public/css/jquery.fullPage.css">
    <style type="text/css">
        .container-thumbnails{
            margin-top: 60px;
        }
        .thumbnails li a{
            color: #888;
            font-weight: bold;
            height: 100px;
        }
        .thumbnails li a:hover,
        .thumbnails li a:focus{
            border-color:#f2f5e9;
            -webkit-box-shadow:none;
            box-shadow:none;
            text-decoration: none;
            background-color: #f2f5e9;
        }
    </style>
</head>

<body>
<div class="row header  ">
    <hr>

    <div class="container-thumbnails">
        <ul class="thumbnails">

                <li class="span3 text-center">
                    <a class="thumbnail" href="/home/item/show/item_id/3" title="bank_list">
                        <p class="my-item">bank_list</p>
                    </a>
                </li>

        </ul>
    </div>




    <div class="right pull-right">
        <ul class="inline pull-right">
            <?php if($login_user): ?><li><a href="<?php echo U('Home/Item/index');?>"><?php echo (L("my_item")); ?></a></li>
                <?php else: ?>
                <li><a href="<?php echo U('Home/User/login');?>"><?php echo (L("index_login_or_register")); ?></a></li><?php endif; ?>
        </ul>
    </div>
</div>


   
	<script src="/bank/Public/js/common/jquery.min.js"></script>
    <script src="/bank/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bank/Public/js/common/showdoc.js?v=1.1"></script>
    <div style="display:none">
    	<?php echo C("STATS_CODE");?>
    </div>
  </body>
</html> 

</body>
</html>