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
                <td width="10%" style="text-align: center;font-weight: bold;">下单日期</td>
                <td width="40%"><?php echo date('Y-m-d');?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">下单人</td>
                <td width="40%"><?php echo $this->session->userdata('userName')?></td>
            </tr>
            
		    <tr>
                <td style="text-align: center;font-weight: bold;">客户名称</td>
                <td>
                    <input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo('<?php echo $base_url;?>index.php','/business/CustomerController/getCustomerInfo','name')">
                    <a href="javascript:void(0)" style="color:red" onclick="getContractInfo($('#name').val(),'<?php echo site_url("/business/ContractController/getContractInfo")?>')"><b>点击载入合同</b></a>
                </td>
                <div id="m_tagsItem" style="display:none">
	                <div id="tagClose">关闭</div>
	                <p><font id="dvelopersInfo"></font></p>
                </div>
                <td style="text-align: center;font-weight: bold;">关联合同</td>
                <td id="details_name"><select name="dNumber" id="dNumber" onclick="" class="span4"></select></td>
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
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: center;" width="35%">
	                            <select name="title[]" class="span3">
			                           <option value="">-请选择-</option>
			                           <?php foreach($studio as $key=>$val){?>
			                           <option value="<?php echo $val['sId'];?>"><?php echo $val['name'];?></option>
			                           <?php } ?>
			                    </select>
                            </td>
                            <td style="text-align: center;">开始时间：<input type="text" name="startDate[]" value="" style="width:75px" onClick="WdatePicker()">&nbsp;结束时间：<input type="text" name="endDate[]" value="" style="width:75px" onClick="WdatePicker()"></td>
                            <td style="text-align: center;"><input type="text" name="weekNum[]" class="span1">&nbsp;周</td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">广告形式</td>
                <td>
                    <select name="ad_type" id="ad_type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['ad_type'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                    <span id="other" style="display:none">&nbsp;其他形式：<input type="text" name="ad_other" id="ad_other" style="width:80px"></span>
                </td>
                <td width="10%" style="text-align: center;font-weight: bold;">支付方式</td>
                <td>
                    <select name="pay_type" id="pay_type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['pay_type'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">备注</td>
                <td colspan="3"><textarea name="remark" class="span4"></textarea></td>
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
