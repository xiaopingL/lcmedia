<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#position").val() == ''){
                alert('位置要求不能为空！'); $("#position").focus();
                return false;
            }
            if($("#contractNumber").val() == ''){
                alert('对应合同编号不能为空！'); $("#contractNumber").focus();
                return false;
            }
            if($("#pay_type").val() == ''){
                alert('支付形式不能为空！'); $("#pay_type").focus();
                return false;
            }
            if($("#issue").val() == ''){
                alert('影讯期号不能为空！'); $("#issue").focus();
                return false;
            }
    });
})
</script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒影讯广告执行单</td>
		    </tr>
		    
		    <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">下单日期</td>
                <td width="40%"><?php echo date('Y-m-d');?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">下单人</td>
                <td width="40%"><?php echo $this->session->userdata('userName')?></td>
            </tr>
            
		    <tr>
                <td style="text-align: center;font-weight: bold;">客户名称</td>
                <td><?php echo $name;?></td>
                <td style="text-align: center;font-weight: bold;">位置要求</td>
                <td>
                    <select name="position" id="position" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['position'] as $key=>$val){?>
                           <option value="<?php echo $key;?>" <?php echo $key==$position?'selected':'';?>><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">对应合同编号</td>
                <td><input type="text" name="contractNumber" id="contractNumber" class="span2" value="<?php echo $contractNumber;?>"></td>
                <td width="10%" style="text-align: center;font-weight: bold;">支付形式</td>
                <td>
                    <select name="pay_type" id="pay_type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['pay_type'] as $key=>$val){?>
                           <option value="<?php echo $key;?>" <?php echo $key==$pay_type?'selected':'';?>><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">影讯期号</td>
                <td colspan="3"><input type="text" name="issue" id="issue" class="span2" onClick="WdatePicker({dateFmt:'yyyy MM'})" value="<?php echo $issue;?>"></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">备注说明</td>
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
