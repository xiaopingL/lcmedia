<script type="text/javascript">
	function passSet(){
		if(document.getElementById("password").value != ''){
			if(document.getElementById("oldpassword").value == ''){
				alert("原密码不能为空！");
				return false;
			}else{
				return true;
			}
			if(document.getElementById("password").value != document.getElementById("confirmpassword").value){
				alert("新密码前后不一致，请重新输入！");
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
</script>
<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form action="<?php echo site_url('/public/UpdatebaseController/baseInfoModify');?>" method="post" id="mainform" name="mainform" novalidate="novalidate" onsubmit="if(!passSet())return false;">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>

            <tr>
                <td class="bold" width="15%">原 密 码</td>
                <td width="85%"><input id="oldpassword" type="password" value="" size="25" name="oldpassword">(<font color="#FF0000">修改密码需要输入原密码</font>)</td>
            </tr>
            <tr>
                <td class="bold">新 密 码</td>
                <td><input id="password" type="password" value="" size="25" name="password">
					<input type="hidden" id="eId" value="<?php echo $arr['eId'] ;?>" name="eId" />
					<input type="hidden" id="uId" value="<?php echo $arr['uId'];?>" name="uId" />(<font color="#FF0000">留空表示不对密码进行修改</font>)</td>
            </tr>
            <tr>
                <td class="bold">确认新密码</td>
                <td><input id="confirmpassword" type="password" value="" size="25" name="confirmpassword"></td>
            </tr>

            <tr>
                <td class="bold">手   机</td>
                <td><input id="phone" type="text" value="<?php echo $arr['phone'];?>" size="25" name="phone"></td>
            </tr>

            <tr>
                <td class="bold">QQ号码</td>
                <td><input id="phone" type="text" value="<?php echo $arr['workqq'];?>" size="25" name="workqq"></td>
            </tr>
            
            <tr>
                <td class="bold">系统弹窗提示</td>
                <td><input type="radio" name="isPms" value="0" <?php echo $userList['isPms']==0?'checked':''; ?> />&nbsp;开启&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="isPms" value="1" <?php echo $userList['isPms']==1?'checked':''; ?> />&nbsp;关闭</td>
            </tr>

            <tr>
                <td colspan="10" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">
						提交内容
                    </button>
                    <button type="reset" class="btn">
						重置
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</form>