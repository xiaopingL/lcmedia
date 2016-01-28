<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#payUnit").val() == ''){
                alert('付款单位不能为空！'); $("#payUnit").focus();
                return false;
            }
            if($("#retrieveTime").val() == ''){
                alert('实际回款日期不能为空！'); $("#retrieveTime").focus();
                return false;
            }
            if($("#paymentMoney").val() == ''){
                alert('回款金额不能为空！'); $("#paymentMoney").focus();
                return false;
            }
            if($("#type").val() == ''){
                alert('付款方式不能为空！'); $("#type").focus();
                return false;
            }
            if($("#retrieveBank").val() == ''){
                alert('收款银行不能为空！'); $("#retrieveBank").focus();
                return false;
            }
    });
   
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="12%"><b>客户名称</b></td>
                <td style="color:green"><?php echo $name;?></td>
                <td width="12%"><b>合同名称</b></td>
                <td style="color:green"><?php echo $title;?></td>
            </tr>

            <tr>
                <td width="12%"><b>合同编号</b></td>
                <td><?php echo $contractNumber;?></td>
                <td width="12%"><b>合同金额</b></td>
                <td><?php echo $contractMoney;?>&nbsp;<font color=red>（元）</font></td>
            </tr>
            
             <tr>
                <td width="12%"><b>开票时间</b></td>
                <td><?php echo date('Y-m-d',$billingDate);?></td>
                <td width="12%"><b>开票金额</b></td>
                <td><?php echo $money;?>&nbsp;<font color=red>（元）</font></td>
            </tr>
            
            <tr>
                <td><b>付款单位</b></td>
                <td><input type="text" name="payUnit" id="payUnit"></td>
                <td><b>实际回款日期</b></td>
                <td><input type="text" name="retrieveTime" id="retrieveTime" value="" onClick="WdatePicker()" style="width:100px;"></td>
            </tr>
            
            <tr>
                <td><b>回款金额</b></td>
                <td><input type="text" name="paymentMoney" id="paymentMoney" value="" class="span1">&nbsp;<font color=red>（元）</font></td>
                <td><b>付款方式</b></td>
                <td>
                    <select name="type" id="type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($payment['paymentMode'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><b>收款银行</b></td>
                <td colspan="3">
                    <select name="retrieveBank" id="retrieveBank">
                           <option value="">-请选择-</option>
                           <?php foreach($payment['bank'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><b>备注</b></td>
                <td colspan="3"><textarea name="remark" id="remark" class="span3"></textarea></td>
            </tr>
            
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交" style="margin-right: 20px;">
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