function loadRegion(sel,type_id,selName,url){
	jQuery("#"+selName+" option").each(function(){
		jQuery(this).remove();
	});
	jQuery("<option value=0>请选择</option>").appendTo(jQuery("#"+selName));
	if(jQuery("#"+sel).val()==0){
		return;
	}
	jQuery.getJSON(url,{pid:jQuery("#"+sel).val(),type:type_id},
		function(data){
			if(data){
				jQuery.each(data,function(idx,item){
					jQuery("<option value="+item.id+">"+item.name+"</option>").appendTo(jQuery("#"+selName));
				});
			}else{
				jQuery("<option value='0'>请选择</option>").appendTo(jQuery("#"+selName));
			}
		}
	);
}


function loadPayInMid(sel,selName,url){
    jQuery("#"+selName+" option").each(function(){
        jQuery(this).remove();
    });
    jQuery("<option value=0>请选择</option>").appendTo(jQuery("#"+selName));
    if(jQuery("#"+sel).val()==0){
        return;
    }
    jQuery.getJSON(url, {pid: jQuery("#" + sel).val()},

        function(data){
            if(data){
                jQuery.each(data,function(idx,item){
                    jQuery("<option value="+item.m_id+">"+item.title+"</option>").appendTo(jQuery("#"+selName));
                });
            }else{
                jQuery("<option value='0'>请选择</option>").appendTo(jQuery("#"+selName));
            }
        }
    );
}


function loadPayOutMid(sel,selName,url){
    jQuery("#"+selName+" option").each(function(){
        jQuery(this).remove();
    });
    jQuery("<option value=0>请选择</option>").appendTo(jQuery("#"+selName));
    if(jQuery("#"+sel).val()==0){
        return;
    }
    jQuery.getJSON(url, {pid: jQuery("#" + sel).val()},
        function(data){
            if(data){
                jQuery.each(data,function(idx,item){
                    jQuery("<option value="+item.m_id+">"+item.title+"</option>").appendTo(jQuery("#"+selName));
                });
            }else{
                jQuery("<option value='0'>请选择</option>").appendTo(jQuery("#"+selName));
            }
        }
    );
}


//出金部分JS交互
//1、获取出金货币类型

function loadCurrency(url) {

}