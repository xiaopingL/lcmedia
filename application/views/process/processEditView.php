<script type="text/javascript">
function show_level(val)
{
	var str;
	str="";
	if(val<2) {$("#show_level").empty('');return false;}
	else {
	$("#show_level").empty('');
	$("#show_level").show();
	for(i=1;i<=val;i++)
	{
		str = str+"<p><font color=green>第"+i+"级</font>&nbsp;&nbsp;	岗位级别：<select name='level"+i+"' class='span2' onchange='show_info(this.value,"+i+");'>";
		if(i==1) str = str+"<option value=''>无</option>";
		if(i!=1) str = str+"<option value=''>==选择==</option>";
		if(i!=1) str = str+"<?php foreach($position as $key=>$value){ ?><option value='<?php echo $key; ?>'><?php echo $value; ?></option><?php } ?>";
		str = str+"</select><span id='show_info"+i+"'></span>";
		str = str+"<span style='margin-left:30px'>组织架构：</span><select name='sid"+i+"'><option value=''>无</option>";
		if(i!=val) str = str+"<?php foreach($org as $k=>$val){ ?><option value='<?php echo $val['sId']; ?>'><?php for($i=1;$i<$val['level'];$i++){echo "====";} ?><?php echo $val['name']; ?></option><?php } ?>";
		str = str+"</select>";
		if(i!=val && i!=val-1) str = str+"<span style='margin-left:30px'>限额：</span><input type='text' name='price"+i+"' size='10' class='span1'>";
	}
	$("#show_level").append(str);
	}
}

function show_info(val,val1)
{
	var str="",strx="",strxx="";
	str='show_info'+val1;

	if(val==5){
		$("#"+str).empty('');
		$("#"+str).append('&nbsp;<font color=red>用户名：</font><input type="text" name="username'+val1+'" class="span1">');
	}else{
		document.getElementById(str).innerHTML='';
	}
}

function insertstep(){
		var count = $("#tbl_info tr").length-2;
		//alert(count);
		count++;
		$("#tbl_info").append('<tr><td align="center"><input type="text" name="approve[]" size="10" class="span2"></td><td align="center"><select name="orgId[]" class="span2"><option value="">--请选择--</option><?php foreach($orgs as $value){ ?><option value="<?php echo $value['sId']; ?>" style="<?php if($value['level']==1){echo 'font-weight:bold;color:black;';} ?>"><?php for($i=1;$i<$value['level'];$i++){echo "====";}?><?php echo $value['name']; ?></option><?php } ?></select></td><td align="center"><input type="text" name="limits[]" size="10" class="span1"></td></tr>');

		return false;
}

</script>

<form class="form_validation_ttip" action="" method="post">
      <table id="smpl_tbl" class="table table-bordered table-striped">
            <tbody>
                 <tr>
                     <td width="15%">流程名称</td>
                     <td><input type="text" name="processName" class="input-xlarge" value="<?php echo $processName; ?>" /></td>
                 </tr>
                 <tr>
                     <td>流程级数</td>
                     <td><select name="level_num" id="level_num" onchange='show_level(this.value)' class="span1">
						<option value="">选择</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
                        </select>&nbsp;<font color=red>（不选择，表示原流程设置不变）</font></td>
                 </tr>
                 <tr>
                     <td>流程设置</td>
                     <td><div id='show_level' style="display:none;"></div></td>
                 </tr>
                 <tr>
                     <td>单流程扩展</td>
                     <td><table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                         <tr>
                             <td colspan="3"><b>节点位置</b>：<select name="position" id="position" class="span2">
                                                    <option value="">--请选择--</option>
                                                    <option value="0" <?php echo $level==0?'selected':'' ?>>第一级审批前</option>
                                                    <option value="1" <?php echo $level==1?'selected':'' ?>>第二级审批前</option>
                                                    <option value="2" <?php echo $level==2?'selected':'' ?>>第三级审批前</option>
                                                    <option value="3" <?php echo $level==3?'selected':'' ?>>第四级审批前</option>
                                                    <option value="4" <?php echo $level==4?'selected':'' ?>>第五级审批前</option>
                                                    <option value="5" <?php echo $level==5?'selected':'' ?>>第六级审批前</option>
                                                    <option value="6" <?php echo $level==6?'selected':'' ?>>第七级审批前</option>
                                                    <option value="7" <?php echo $level==7?'selected':'' ?>>第八级审批前</option>
                                                    </select></td>
                        </tr>
			            <tr>
			                <td align="center" width="30%"><b>审批人</b></td>
			                <td align="center" width="30%"><b>关联组织架构</b></td>
			                <td align="center" width="40%"><b>限额</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info' onClick="return insertstep()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
		                </tr>
		                <?php foreach($extension as $val){ ?>
			            <tr>

			                <td align="center"><input type="text" name="approve[]" size="10" class="span2" value="<?php echo $val['uId'] ?>"></td>
			                <td align="center"><select name="orgId[]" class="span2">
			                         <option value="">--请选择--</option>
			                         <?php foreach($orgs as $value){ ?>
                                     <option value="<?php echo $value['sId']; ?>" style="<?php if($value['level']==1){echo 'font-weight:bold;color:black;';} ?>" <?php echo $val['sId']==$value['sId']?'selected':'' ?>>
                                     <?php
						             for($i=1;$i<$value['level'];$i++)
						             {
							            echo "====";
						             }
						             ?><?php echo $value['name']; ?></option>
			                         <?php } ?>
			                         </select></td>
			                <td align="center"><input type="text" name="limits[]" size="10" class="span1" value="<?php echo $val['limits'] ?>"></td>
		               </tr><? } ?></table></td>
                 </tr>
                 <tr>
                     <td>多流程扩展<br><font color=red>(只能选择一个条件)</font></td>
                     <td><table cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                         <tr>
                             <td colspan="3"><b>发起人岗位级别</b>：<select name="jobId" id="jobId" class="span2">
                                                    <option value="">--请选择--</option>
                                                    <option value="5" <?php echo $jobId==5?'selected':'' ?>>员工或主管</option>
                                                    <option value="3" <?php echo $jobId==3?'selected':'' ?>>经理或总监</option>
                                                    <option value="1" <?php echo $jobId==1?'selected':'' ?>>总经理</option>
                                                    </select></td>
                        </tr>
                         <tr>
                             <td colspan="3"><b>申请单条件数量</b>：<select name="numType" id="numType" class="span2">
                                                    <option value="">--请选择--</option>
                                                    <option value="4" <?php echo $numType==4?'selected':'' ?>>条件数量四</option>
                                                    <option value="3" <?php echo $numType==3?'selected':'' ?>>条件数量三</option>
                                                    <option value="2" <?php echo $numType==2?'selected':'' ?>>条件数量二</option>
                                                    <option value="1" <?php echo $numType==1?'selected':'' ?>>条件数量一</option>
                                                    </select></td>
                        </tr>
                        </table></td>
                 </tr>
			     <tr>
			          <td colspan="2" style="text-align:center;">
			          <button class="btn btn-gebo" type="submit" name="submitCreate" value="修改">修改流程</button>&nbsp;
			          <button class="btn" type="reset">重置</button></td>
			     </tr>
			</tbody>
	</table>
</form>