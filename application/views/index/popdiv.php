<script src="<?php echo $base_url;?>js/tipswindown.js"></script>
<script type="text/javascript">
/*
*弹出本页指定ID的内容于窗口
*id 指定的元素的id
*title:	window弹出窗的标题
*width:	窗口的宽,height:窗口的高
*/
function showTipsWindown(title,id,width,height){
	tipsWindown(title,"id:"+id,width,height,"true","","true",id);
}

function confirmTerm(s) {
	parent.closeWindown();
	if(s == 1) {
		parent.document.getElementById("isread").checked = true;
	}
}

//弹出层调用
function popTips(){
	showTipsWindown('<?php echo $poptitle;?>', 'simTestContent', 700, 800);
	$("#isread").attr("checked", false);
}

$(document).ready(function(){

	$("#isread").click(popTips);
	$("#isread-text").click(popTips);

});
</script>
<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
body{font:12px/180% Arial, Helvetica, sans-serif;}
label{cursor:pointer;}
.democode{width:400px;margin:30px auto 0 auto;line-height:24px;}
.democode h2{font-size:14px;color:#3366cc;height:28px;}
.agree{margin:40px auto;width:400px;font-size:16px;font-weight:800;color:#3366cc;}
.mainlist{padding:10px;}
.mainlist li{height:25px;line-height:25px;font-size:12px;}
.mainlist li span{margin:0 5px 0 0;font-family:"宋体";font-size:12px;font-weight:400;color:#ddd;}
.btnbox{text-align:center;height:30px;padding-top:10px;background:#ECF9FF;}

#windownbg{display:none;position:absolute;width:100%;height:100%;background:#000;top:0;left:0;}
#windown-box{position:fixed;_position:absolute;border:5px solid #E9F3FD;background:#FFF;text-align:left;}
#windown-title{position:relative;height:30px;border:1px solid #A6C9E1;overflow:hidden;background:url(images/tipbg.png) 0 0 repeat-x;}
#windown-title h2{position:relative;left:10px;top:5px;font-size:14px;color:#666;}
#windown-close{position:absolute;right:10px;top:8px;width:10px;height:16px;text-indent:-10em;overflow:hidden;background:url(images/tipbg.png) 100% -49px no-repeat;cursor:pointer;}
#windown-content-border{position:relative;top:-1px;border:1px solid #A6C9E1;padding:5px 0 5px 5px;}
#windown-content img,#windown-content iframe{display:block;}
#windown-content .loading{position:absolute;left:50%;top:50%;margin-left:-8px;margin-top:-8px;}
</style>