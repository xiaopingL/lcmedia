$(function(){	
    $.getJSON("http://bbs."+prefixUrl+".ahhouse.com/api/ahhouse/newsmanage.php?type="+type+"&jsoncallback=?",{keywords:encodeURI(keywords)},function(json){
    var jsonData = eval(json);
		$.each(jsonData,function(i,n){
		  if(type=='bz'){						 
			if(n.indexview==0){
			    kanjian ='<a href="/admin.php?s=/forum/thread/setIndexView/indexview/1/tid/'+n.tid+'" title="显示在首页"><i class="icon-eye-close"></i></a>';
			}else if(n.indexview==1){
			    kanjian ='<a href="/admin.php?s=/forum/thread/setIndexView/indexview/0/tid/'+n.tid+'" title="不显示在首页"><i class="icon-eye-open"></i></a>';
			}
			$("#Searchresult").append("<tr><td>"+n.tid+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/space-uid-"+n.authorid+".html\" target=\"_blank\">"+n.author+"</a></td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/thread-"+n.tid+"-1-1.html\" target=\"_blank\">"+n.subject+"</a></td><td>"+n.replies+"</td><td>"+n.views+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/forum-"+n.fid+"-1.html\" target=\"_blank\">"+n.fname+"</a></td><td>"+n.datestr+"</td><td>"+kanjian+"</td></tr>");  
		  }else if(type=='gg'){
			if(n.istop==0){
				topshow='<a href="/admin.php?s=/forum/thread/setTopView/topview/1/tid/'+n.tid+'" title="头条显示"><i class="icon-remove"></i></a>';
			}else if(n.istop==1){
				topshow='<a href="/admin.php?s=/forum/thread/setTopView/topview/0/tid/'+n.tid+'" title="取消头条"><i class="icon-ok"></i></a>';
			}
			if(n.indexview==0){
			    kanjian ='<a href="/admin.php?s=/forum/thread/setIndexView/indexview/1/tid/'+n.tid+'" title="显示在首页"><i class="icon-eye-close"></i></a>';
			}else if(n.indexview==1){
			    kanjian ='<a href="/admin.php?s=/forum/thread/setIndexView/indexview/0/tid/'+n.tid+'" title="不显示在首页"><i class="icon-eye-open"></i></a>';
			}
			$("#Searchresult").append("<tr><td>"+n.tid+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/space-uid-"+n.authorid+".html\" target=\"_blank\">"+n.author+"</a></td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/thread-"+n.tid+"-1-1.html\" target=\"_blank\">"+n.subject+"</a></td><td>"+n.replies+"</td><td>"+n.views+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/forum-"+n.fid+"-1.html\" target=\"_blank\">"+n.fname+"</a></td><td>"+n.datestr+"</td><td>"+topshow+"</td><td>"+kanjian+"</td></tr>");  
		  }else if(type=='htbz'){
			 $("#Searchresult").append("<tr><td>"+n.tid+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/space-uid-"+n.authorid+".html\" target=\"_blank\">"+n.author+"</a></td><td>"+n.message+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/forum-"+n.fid+"-1.html\" target=\"_blank\">"+n.fname+"</a></td><td>"+n.datestr+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/thread-"+n.tid+"-1-1.html\" target=\"_blank\">查看</a></td></tr>");  
		  }else if(type=='htgg'){
			  $("#Searchresult").append("<tr><td>"+n.tid+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/space-uid-"+n.authorid+".html\" target=\"_blank\">"+n.author+"</a></td><td>"+n.message+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/forum-"+n.fid+"-1.html\" target=\"_blank\">"+n.fname+"</a></td><td>"+n.datestr+"</td><td><a href=\"http://bbs."+prefixUrl+".ahhouse.com/thread-"+n.tid+"-1-1.html\" target=\"_blank\">查看</a></td></tr>"); 
		  }
		})
	var num_entries = $("#Searchresult tr").length;	
	var showCount = 12;
	$("#total").html("最多显示最新500条记录 显示 "+num_entries+" 条记录 每页显示"+showCount+"条");
	var initPagination = function() {
		
		// 创建分页
		$("#Pagination").pagination(num_entries, {
			num_edge_entries: 1, //边缘页数
			num_display_entries: 6, //主体页数
			callback: pageselectCallback,
			items_per_page:showCount //每页显示1项
		});
	 }();	 
	function pageselectCallback(page_index, jq){
		var max_elem = Math.min((page_index+1) *showCount, num_entries);		
		$("#htcList").html("");		
		for(var i=page_index*showCount;i<max_elem;i++){
			var new_content = $("#Searchresult tr:eq("+i+")").clone();
			$("#htcList").append(new_content); //装载对应分页的内容
		}
		return false;
	}
}); 
});
