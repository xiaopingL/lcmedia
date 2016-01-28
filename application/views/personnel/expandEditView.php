<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
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
</script>
<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate" enctype="multipart/form-data" id="mainform" name="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
				<td colspan="4" style="font-size:24px;padding:10px;text-align:center;background:gray 10px center;font-weight:bold"><?php echo $userDetail[0]['userName']; ?>个人详细档案编辑</td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">性别</span></td>
				<td width="40%"><input type="radio" name="sex" value="1" <?php echo $sex==1?'checked':''; ?>>男&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" value="2" <?php echo $sex==2?'checked':''; ?>>女</td>
				<td width="10%"><span class="bold">出生年月</span></td>
				<td width="40%"><input type="text" name="birthday" id="birthday" onClick="WdatePicker()" class="span2" value="<?php echo !empty($birthday)?date('Y-m-d',$birthday):''; ?>"></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">身份证号码</span></td>
				<td width="40%"><input type="text" name="idcard" class="span3" value="<?php echo $idcard; ?>"></td>
				<td width="10%"><span class="bold">政治面貌</span></td>
				<td width="40%"><?php foreach($politicalType as $key=>$val){ ?>
				                <input type="radio" name="political" value="<?php echo $key; ?>" <?php echo $key==$political?'checked':''; ?>><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				                <?php } ?></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">籍贯</span></td>
				<td width="40%"><input type="text" name="nativePlace" class="span3" value="<?php echo $nativePlace; ?>"></td>
				<td width="10%"><span class="bold">婚否</span></td>
				<td width="40%"><?php foreach($marriageType as $key=>$val){ ?>
				                <input type="radio" name="isMarriage" value="<?php echo $key; ?>" <?php echo $key==$isMarriage?'checked':''; ?>><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				                <?php } ?></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">视力</span></td>
				<td width="40%"><input type="text" name="vision" class="span1" value="<?php echo $vision; ?>"></td>
				<td width="10%"><span class="bold">血型</span></td>
				<td width="40%"><?php foreach($bloodsType as $key=>$val){ ?>
				                <input type="radio" name="bloodType" value="<?php echo $key; ?>" <?php echo $key==$bloodType?'checked':''; ?>><?php echo $val; ?>&nbsp;&nbsp;&nbsp;&nbsp;
				                <?php } ?></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">身高</span></td>
				<td width="40%"><input type="text" name="height" class="span1" value="<?php echo $height; ?>">&nbsp;<font color=red>(单位:厘米)</font></td>
				<td width="10%"><span class="bold">体重</span></td>
				<td width="40%"><input type="text" name="weight" class="span1" value="<?php echo $weight; ?>">&nbsp;<font color=red>(单位:公斤)</font></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">毕业院校</span></td>
				<td width="40%"><input type="text" name="graduateFrom" class="span3" value="<?php echo $graduateFrom; ?>"></td>
				<td width="10%"><span class="bold">专业</span></td>
				<td width="40%"><input type="text" name="professional" class="span3" value="<?php echo $professional; ?>"></td>
			</tr>

            <tr>
				<td width="10%"><span class="bold">毕业时间</span></td>
				<td width="40%"><input type="text" name="graduateTime" id="graduateTime" onClick="WdatePicker()" class="span2" value="<?php echo !empty($graduateTime)?date('Y-m-d',$graduateTime):''; ?>"></td>
				<td width="10%"><span class="bold">学历</span></td>
				<td width="40%"><select name="education" class="span2">
				                <option value="">-选择-</option>
				                <?php foreach($educationType as $key=>$val){ ?>
				                <option value="<?php echo $key; ?>" <?php echo $key==$education?'selected':''; ?>><?php echo $val; ?></option>
				                <?php } ?>
				                </select></td>
			</tr>
			
            <tr>
				<td width="10%"><span class="bold">联系方式</span></td>
				<td width="90%" colspan="3">
				<table cellpadding="4" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed">
				<tr>
				    <td>手机号码：<input type="text" name="telphone" class="span2" value="<?php echo $phone; ?>"></td>
				    <td>身份证地址：<input type="text" name="cardAddr" class="span4" value="<?php echo $cardAddr; ?>"></td>
				</tr>
				<tr>
				    <td>家庭住址：<input type="text" name="family" class="span2" value="<?php echo $address; ?>"></td>
				    <td>当前居住地：<input type="text" name="currentAddress" class="span4" value="<?php echo $currentAddress; ?>"></td>
				</tr>
			    </table>
			    </td>
			</tr>
			
			<tr>
				<td width="10%"><span class="bold">个人证件</span></td>
				<td width="90%" colspan="3">
				<table cellpadding="4" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed">
				<tr>
				    <td>个人照片：<input type="hidden" name="isUserfile1" id="isUserfile1">
                                 <input type="file" name="userfile1" size="25" value="" onChange="javascript:document.mainform.isUserfile1.value = document.mainform.userfile1.value" />&nbsp;<font color=red>(图片大小：100*100像素)</font>
                                 <?php if(!empty($photo)){ ?>
                                 <br /><a href="<?php echo site_url("public/FileController/downloadApp/".$photo) ?>" title="下载">
                                 <img title="有附件" src="<?php echo base_url();?>img/attachment.gif" border="0" align="absmiddle"><?php echo $origName; ?></a>
                                 <?php } ?></td>
				</tr>
			    </table>
			    </td>
			</tr>
			
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加" style="margin-right: 20px;">提交内容</button>
                    <button type="button" class="btn" onClick="javascript:history.go(-1)">我要返回</button>
                </td>
           </tr>
        </tbody>
    </table>
</form>
