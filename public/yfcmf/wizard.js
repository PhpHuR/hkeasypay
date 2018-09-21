/**
 * Created by zhouding on 2016/11/29.
 */
+function ($) {

    $(function(){

        $('#wizardform').bootstrapWizard({
            'tabClass': 'nav nav-tabs',
            'onNext': function(tab, navigation, index) {
                var valid = true;
                //提交等待效果
                //popupLoading2();
                console.log($("#upload"));
                $("#wizardform").ajaxSubmit({
                    type: "post",
                    dataType: "script",  // 'xml', 'script', or 'json' (expected server response type)
                    url: "/Home/Payout/turnListToBankPage",
                    success: function (data) {
                        if(data.replace(/\s+/g,"")=="1"){
                            alert('导入成功');
                            location.reload();
                        }else{
                            alert(data1);
                        }
                    },
                    error: function (msg) {
                        alert("文件上传失败");
                    }
                });
                return valid;
            },
            onTabClick: function(tab, navigation, index) {
                return false;
            },
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#wizardform').find('.progress-bar').css({width:$percent+'%'});
            }
        });

    });
}(window.jQuery);