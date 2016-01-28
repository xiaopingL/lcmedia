<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>短信发送</title>
<link href="<?php echo $base_url;?>css/style_2014.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base_url;?>js/jquery-1.4.2.min.js" rel="stylesheet" type="text/css" />
</head>
<script language="JavaScript" type="text/javascript">
        $(document).ready(function() {
            function jump(count) {
                window.setTimeout(function(){
                    count--;
                    if(count >= 0) {
                        $('#time').html(count);
                        jump(count);
                        
                    } else {
                        $(".p3").css('display','');
                        $(".p2").css('display','none');
                        location.href="<?php echo site_url("/public/EmailController/duanxin/?str=".$str.'&content='.$content);?>";
                    }
                }, 1000);
            }
            jump(3);
        }); 
</script>
<body>
<div class="top1">
<div class="dx">
	<p class="p1">短信发送，还有<font><span id="time" style="font-size: 35px;font-weight: bold;">3</span></font>秒；</p>
        <p class="p3" style="display:none;"><b style="font-size: 20px;">短信正在发送</b><img src="<?php echo $base_url;?>/img/ddd.gif" width="69" height="34" /></p>
        <p class="p2"><b style="font-size: 20px;">如果不跳转，请点击下面的按钮</b><br/><a href="<?php echo site_url("/public/EmailController/duanxin/?str=".$str.'&content='.$content);?>" class="dxfs">  </a></p>
</div>
<div class="db"></div>
</div>
</body>
</html>
