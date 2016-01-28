<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#duration").val() == ''){
                alert('广告片时长不能为空！'); $("#duration").focus();
                return false;
            }
            if($("#supplier").val() == ''){
                alert('广告片提供方不能为空！'); $("#supplier").focus();
                return false;
            }
    });
})

function insertstep(){
    var count = $("#tbl_info tr").length-1;
    count++;
    $("#tbl_info").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;" width="35%"><select name="title[]" class="span3"><option value="">-请选择-</option><?php foreach($studio as $key=>$val){?><option value="<?php echo $val['sId'];?>"><?php echo $val['name'];?></option><?php } ?></select></td><td style="text-align: center;">开始时间：<input type="text" name="startDate[]" value="" style="width:75px" onClick="WdatePicker()">&nbsp;结束时间：<input type="text" name="endDate[]" value="" style="width:75px" onClick="WdatePicker()"></td><td style="text-align: center;"><input type="text" name="weekNum[]" class="span1">&nbsp;周</td></tr>');
    return false;
}
</script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒广告播出确认单</td>
		    </tr>
            
		    <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">客户名称</td>
                <td width="40%"><?php echo $name;?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">关联合同</td>
                <td width="40%"><?php echo $title;?></td>
            </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">影院信息</td>
                <td colspan="3">
                    <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>执行影院</b></td>
                            <td style="text-align: center;"><b>执行时间</b></td>
                            <td style="text-align: center;"><b>周期</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info' onClick="return insertstep()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <?php if(!empty($contentList)){foreach($contentList as $k=>$v){?>
                        <tr>
                            <td style="text-align: center;"><?php echo $k+1;?></td>
                            <td style="text-align: center;" width="35%">
	                            <select name="title[]" class="span3">
			                           <option value="">-请选择-</option>
			                           <?php foreach($studio as $key=>$val){?>
			                           <option value="<?php echo $val['sId'];?>" <?php echo $v['title']==$val['sId']?'selected':'';?>><?php echo $val['name'];?></option>
			                           <?php } ?>
			                    </select>
                            </td>
                            <td style="text-align: center;">开始时间：<input type="text" name="startDate[]" value="<?php echo $v['startDate'];?>" style="width:75px" onClick="WdatePicker()">&nbsp;结束时间：<input type="text" name="endDate[]" value="<?php echo $v['endDate'];?>" style="width:75px" onClick="WdatePicker()"></td>
                            <td style="text-align: center;"><input type="text" name="weekNum[]" value="<?php echo $v['weekNum'];?>" class="span1">&nbsp;周</td>
                        </tr>
                        <?php } }?>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">广告片时长</td>
                <td><input type="text" name="duration" id="duration" value="<?php echo $duration;?>" class="span3"></td>
                <td width="10%" style="text-align: center;font-weight: bold;">广告片提供方</td>
                <td><input type="text" name="supplier" id="supplier" value="<?php echo $supplier;?>" class="span3"></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">位置要求</td>
                <td><textarea name="position" class="span3"><?php echo $position;?></textarea></td>
                <td width="10%" style="text-align: center;font-weight: bold;">监播要求</td>
                <td><textarea name="monitor" class="span3"><?php echo $monitor;?></textarea></td>
            </tr>
            
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
