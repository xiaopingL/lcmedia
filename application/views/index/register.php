<!DOCTYPE html>
<html lang="zh-CN" class="login_page">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>领程传媒企业资源管理系统用户注册</title>
<script type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/validate-ex.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $base_url;?>css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $base_url;?>css/style.css" />
<style type="text/css">
.mytable{width:760px; margin:20px auto; border:2px solid #ccc}
.mytable td{padding:4px 6px; border-bottom:1px dotted #d3d3d3; color:#333}
.mytable td p{line-height:16px; color:#999}
.input{width:220px; height:18px; padding:2px 2px 0 2px; border:1px solid #ccc}
label.error{color:#ea5200; margin-left:4px; padding:0px 20px; background:url(<?php echo $base_url;?>img/unchecked.gif) no-repeat 2px 0 }
label.right{margin-left:4px; padding-left:20px; background:url(<?php echo $base_url;?>img/checked.gif) no-repeat 2px 0}
</style>
<script type="text/javascript">
function insertstep(){
	var count = $("#tbl_info tr").length-1;
	count++;
	$("#tbl_info").append('<tr><td>'+count+'</td><td><input type="text" name="danwei[]" id="danwei" class="span3" value=""></td><td><input type="text" name="position[]" id="position" class="span2" value=""></td><td><input type="text" name="workDate[]" id="workDate" class="span2" value=""></td></tr>');
	return false;
}

function insertstep2(){
	var count = $("#tbl_info2 tr").length-1;
	count++;
	$("#tbl_info2").append('<tr><td>'+count+'</td><td><input type="text" name="conName[]" id="conName" class="span2" value=""></td><td><input type="text" name="contract[]" id="contract" class="span2" value=""></td><td><input type="text" name="conTel[]" id="conTel" class="span2" value=""></td></tr>');
	return false;
}

$(function(){
	var validate = $("#mainform").validate({
		rules:{
			user:{
				maxlength:4,
				minlength:2,
				userName:true,
				remote: {
                   url: "<?php echo $base_url;?>index.php/home/checkUser",
                   type: "post",
                   data: { user: function() { return encodeURIComponent($("#user").val());}}
               }
			},
			pass:{
				maxlength:16,
				minlength:6
			},
			repass:{
				maxlength:16,
				minlength:6,
				equalTo:"#pass"
			},
			sex:"required",
			siteId:"required",
			idcard:"isIdCardNo",
			phone:{isMobile:true},
			birthday:"dateISO",
			photo:{
				accept:"gif|jpg|png|jpeg|pjpeg|jpe"
			},
		},
		messages:{
			user:{
				remote:"该姓名已存在，请换个其他的昵称！"
			},
			repass:{
				equalTo:"两次密码输入不一致！"
			},
			sex:"请选择性别！",
			birthday:{
				dateISO:"日期格式不对!"
			},
		},
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo ( element.parent() );
			else if ( element.is(":checkbox") )
				error.appendTo ( element.parent() );
			else if ( element.is("input[name=captcha]") )
				error.appendTo ( element.parent() );
			else
				error.insertAfter(element);
		},
	    success: function(label) {
		   label.html("&nbsp;").addClass("right");
	    }
	});

	$("input:reset").click(function(){
		validate.resetForm();
	});
});
</script>
</head>
<body>
<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate" enctype="multipart/form-data" id="mainform" name="mainform">
    <table class="table table-bordered table-striped table-condensed" id="smpl_tbl" style="width:80%;margin-left:125px;" class="mytable">
        <tbody>
            <tr>
				<td colspan="4" style="font-size:24px;color:red;padding:10px;text-align:center;background:gray url(<?php echo $base_url;?>img/kx_logo.png) no-repeat 10px center;">领程传媒企业资源管理系统用户注册</td>
			</tr>

            <tr>
				<td colspan="4" style="color:green;">帐号基本信息：</td>
			</tr>
            <tr>
				<td width="10%"><span class="bold">姓名</span></td>
				<td width="90%" colspan="3"><input type="text" name="user" id="user" class="input required span2">&nbsp;<font color=red>(请填写您的真实姓名)</font></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">密码</span></td>
				<td width="90%" colspan="3"><input type="password" name="pass" id="pass" class="input required span3">&nbsp;<font color=red>(数字+字母组合，不少于6位数)</font></td>
			</tr>
            <tr>
				<td width="10%"><span class="bold">确认密码</span></td>
				<td width="90%" colspan="3"><input type="password" name="repass" class="input required span3"></td>
			</tr>
            <tr>
				<td width="10%"><span class="bold">归属站点</span></td>
				<td width="90%" colspan="3">
				<?php foreach($site as $key=>$value){
					if($key == 12){ echo "<br />"; }
			    ?>
				<input type="checkbox" name="siteId[]" class="input required" value="<?php echo $value['siteId']?>"><?php echo $value['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;
				<? } ?></td>
			</tr>
            <tr>
				<td colspan="4" style="color:green;">个人详细信息：</td>
			</tr>
            <tr>
				<td width="10%"><span class="bold">性别</span></td>
				<td width="40%"><input type="radio" name="sex" value="1">男&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" value="2">女</td>
				<td width="10%"><span class="bold">出生年月</span></td>
				<td width="40%"><input type="text" name="birthday" id="birthday" onClick="WdatePicker()" class="input required span2"></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">身份证号码</span></td>
				<td width="40%"><input type="text" name="idcard" class="input required span3"></td>
				<td width="10%"><span class="bold">政治面貌</span></td>
				<td width="40%"><?php foreach($politicalType as $key=>$val){ ?>
				                <input type="radio" name="political" value="<?php echo $key; ?>" <?php echo $key==1?'checked':''; ?>><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				                <?php } ?></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">籍贯</span></td>
				<td width="40%"><input type="text" name="nativePlace" class="input required span3"></td>
				<td width="10%"><span class="bold">婚否</span></td>
				<td width="40%"><?php foreach($marriageType as $key=>$val){ ?>
				                <input type="radio" name="isMarriage" value="<?php echo $key; ?>" <?php echo $key==1?'checked':''; ?>><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				                <?php } ?></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">视力</span></td>
				<td width="40%"><input type="text" name="vision" class="input required span1"></td>
				<td width="10%"><span class="bold">血型</span></td>
				<td width="40%"><?php foreach($bloodType as $key=>$val){ ?>
				                <input type="radio" name="bloodType" value="<?php echo $key; ?>"><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				                <?php } ?></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">身高</span></td>
				<td width="40%"><input type="text" name="height" class="input required span1">&nbsp;<font color=red>(单位:厘米)</font></td>
				<td width="10%"><span class="bold">体重</span></td>
				<td width="40%"><input type="text" name="weight" class="input required span1">&nbsp;<font color=red>(单位:公斤)</font></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">毕业院校</span></td>
				<td width="40%"><input type="text" name="graduateFrom" class="input required span3"></td>
				<td width="10%"><span class="bold">专业</span></td>
				<td width="40%"><input type="text" name="professional" class="input required span3"></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">毕业时间</span></td>
				<td width="40%"><input type="text" name="graduateTime" id="graduateTime" onClick="WdatePicker()" class="input required span2"></td>
				<td width="10%"><span class="bold">学历</span></td>
				<td width="40%"><select name="education" class="required span2">
				                <option value="">-选择-</option>
				                <?php foreach($educationType as $key=>$val){ ?>
				                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
				                <?php } ?>
				                </select></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">联系方式</span></td>
				<td width="90%" colspan="3">
				<table cellpadding="4" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed">
				<tr>
				    <td>手机号码：<input type="text" name="phone" class="input required span2"></td>
				    <td>身份证地址：<input type="text" name="cardAddr" class="input required span4"></td>
				</tr>
				<tr>
				    <td>家庭住址：<input type="text" name="address" class="input required span2"></td>
				    <td>当前居住地：<input type="text" name="currentAddress" class="input required span4"></td>
				</tr>
			    </table>
			    </td>
			</tr>

            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
           </tr>
        </tbody>
    </table>
</form>
</body>
</html>
