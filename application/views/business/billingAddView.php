<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#class").val() == ''){
                alert('类别不能为空！'); $("#class").focus();
                return false;
            }
            if($("#type").val() == ''){
                alert('发票性质不能为空！'); $("#type").focus();
                return false;
            }
            if($("#ourCompany").val() == ''){
                alert('我方开票公司不能为空！'); $("#ourCompany").focus();
                return false;
            }
            if($("#cate").val() == ''){
                alert('发票类型不能为空！'); $("#cate").focus();
                return false;
            }
            if($("#company").val() == ''){
                alert('客户开票名称不能为空！'); $("#company").focus();
                return false;
            }
            if($("#money").val() == ''){
                alert('开票金额不能为空！'); $("#money").focus();
                return false;
            }
    });

    $("#cate").change(function(){
        if($(this).val() == 3){
            $("#other").css('display','');
        }else{
            $("#other").css('display','none');
        }
    })
   
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
                <td><?php echo $money;?>&nbsp;<font color=red>（元）</font></td>
            </tr>
            
            <tr>
                <td><b>类别</b></td>
                <td>
                    <select name="class" id="class" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($billing['billingClass'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
                <td><b>发票性质</b></td>
                <td>
                    <select name="type" id="type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($billing['billingType'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><b>我方开票公司</b></td>
                <td>
                    <select name="ourCompany" id="ourCompany" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($billing['billingOur'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
                <td><b>发票类型</b></td>
                <td>
                    <select name="cate" id="cate" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($billing['billingCate'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                    <span id="other" style="display:none">&nbsp;备注：<input type="text" name="cate_other" id="cate_other" style="width:80px"></span>
                </td>
            </tr>
            
            <tr>
                <td><b>客户开票名称</b></td>
                <td><input type="text" name="company" id="company"></td>
                <td><b>开票金额</b></td>
                <td><input type="text" name="money" id="money" value="" class="span1">&nbsp;<font color=red>（元）</font></td>
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