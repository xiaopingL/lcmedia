<!DOCTYPE html>
<html lang="zh-CN" class="login_page">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="<?php echo $base_url;?>favicon.ico"/>
<title>领程传媒企业资源管理系统</title>
<link type="text/css" rel="stylesheet" href="<?php echo $base_url;?>img/2014/base.css?v=201412101616" />
<script src="<?php echo $base_url;?>js/jquery.js"></script>
</head>
<body>
<div class="erp-wrap"><div class="erp-top"></div></div>

<div class="erp-login">
	<div class="erp-wrap">
        <div class="login-box">

            <p style="padding-bottom:10px;"><img src="<?php echo $base_url;?>img/2014/lg.gif" width="270" height="85" /></p>
            <form action='' method='post' name="loginform" onSubmit="return checkLogin();" >
					<label for="username" class="inp_user"><input type='text' id='username' name='username' value="用户名"  onfocus="if(this.value=='用户名') this.value=''" onblur="if(value==''){value='用户名'}" /><span></span></label>
					<label for="password" class="inp_pws"><input type='password' id='password' name='password' value="******"  onfocus="if(this.value=='******') this.value=''" onblur="if(value==''){value='******'}" /><span></span></label>
                    <p class="error"><b><?php if(isset($error) && $error):?>
    <?=$error?>
	<?php endif;?></b></p>
					<label><input type='submit' name='submitCreate' value='登 陆' class="inp_sub"></label>
					<p class="register"><a href="<?php echo site_url("home/register")?>">我要注册</a></p>
            </form>
        </div>
    </div>
    <p class="login-bg1"></p><p class="login-bg2"></p><p class="login-bg3"></p><p class="login-bg4"></p><p class="login-bg5"></p><p class="login-bg6"></p>
</div>

<div class="erp-wrap">
    <div class="copy clearfix">领程传媒   Copyright &copy; <?php echo date('Y'); ?> <span class="fblu">lcmedia.com.cn All rights reserved.</span></div>
</div>
<script>
/* 输入框 */
function checkLogin(){
	if(document.loginform.username.value==""){
		alert('请填写登录用户名!');
		document.loginform.username.focus();
		return false;
	}
	if(document.loginform.password.value==""){
		alert('请填写登录密码!');
		document.loginform.password.focus();
		return false;
	}
}
</script>
</body>
 </html>
