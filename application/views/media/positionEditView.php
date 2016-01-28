<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#ad_type").val() == ''){
                alert('广告形式不能为空！'); $("#ad_type").focus();
                return false;
            }
            if($("#ad_type").val() == 9 && $("#ad_other").val() == ''){
                alert('请填写其他广告形式！'); $("#ad_other").focus();
                return false;
            }
            if($("#pay_type").val() == ''){
                alert('支付方式不能为空！'); $("#pay_type").focus();
                return false;
            }
    });

    $("#ad_type").change(function(){
            if($(this).val() == 9){
                $("#other").css('display','');
            }else{
            	$("#other").css('display','none');
            }
    })
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
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒阵地广告确认单</td>
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
                <td width="10%" style="text-align: center;font-weight: bold;">广告形式</td>
                <td>
                    <select name="ad_type" id="ad_type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['ad_type'] as $key=>$val){?>
                           <option value="<?php echo $key;?>" <?php echo $ad_type==$key?'selected':'';?>><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                    <span id="other" style="display:<?php echo $ad_type==9?'':'none'?>">&nbsp;其他形式：<input type="text" name="ad_other" id="ad_other" style="width:80px" value="<?php echo $ad_other;?>"></span>
                </td>
                <td width="10%" style="text-align: center;font-weight: bold;">支付方式</td>
                <td>
                    <select name="pay_type" id="pay_type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['pay_type'] as $key=>$val){?>
                           <option value="<?php echo $key;?>" <?php echo $pay_type==$key?'selected':'';?>><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">备注</td>
                <td colspan="3"><textarea name="remark" class="span4"><?php echo $remark;?></textarea></td>
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
