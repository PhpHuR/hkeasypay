<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo ($item["item_name"]); ?> HKeasypay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/bank/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bank/Public/css/showdoc.css" rel="stylesheet">
      <script type="text/javascript">
      var DocConfig = {
          host: window.location.origin,
          app: "<?php echo U('/');?>",
          pubile:"/bank/Public",
      }

      DocConfig.hostUrl = DocConfig.host + "/" + DocConfig.app;
      </script>
      <script src="/bank/Public/js/lang.<?php echo LANG_SET;?>.js?v=21"></script>
  </head>
  <body>

<link href="/bank/Public/highlight/default.min.css" rel="stylesheet"> 
<link href="/bank/Public/css/page/index.css?v=1.1234" rel="stylesheet">
<h3 style="text-align: center;"><?php echo ($page["page_title"]); ?></h3>
<!-- 这里开始是内容 -->
<div id="page_md_content" ><textarea style="display:none;">
<?php echo ($page["page_md_content"]); ?></textarea></div>

<div id="page_html_content" style="display:none;"><?php echo ($page["page_html_content"]); ?></div>

    
	<script src="/bank/Public/js/common/jquery.min.js"></script>
    <script src="/bank/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bank/Public/js/common/showdoc.js?v=1.1"></script>
    <div style="display:none">
    	<?php echo C("STATS_CODE");?>
    </div>
  </body>
</html> 

 <script src="/bank/Public/highlight/highlight.min.js"></script>
 <script src="/bank/Public/editor.md/lib/marked.min.js"></script>
 <script src="/bank/Public/editor.md/lib/prettify.min.js"></script>
 <script src="/bank/Public/editor.md/lib/flowchart.min.js"></script>
 <script src="/bank/Public/editor.md/lib/raphael.min.js"></script>
 <script src="/bank/Public/editor.md/lib/underscore.min.js"></script>
 <script src="/bank/Public/editor.md/lib/sequence-diagram.min.js"></script>
 <script src="/bank/Public/editor.md/lib/jquery.flowchart.min.js"></script>
 <script src="/bank/Public/editor.md/editormd.min.js"></script>
<script src="/bank/Public/js/page/index.js?a=12"></script>