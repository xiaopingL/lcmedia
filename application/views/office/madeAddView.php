<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#name").val() == ''){
                alert('客户名称不能为空！'); $("#name").focus();
                return false;
            }
            if($("#tId").val() == ''){
                alert('回收票种不能为空！'); $("#tId").focus();
                return false;
            }
            if($("#madeDate").val() == ''){
                alert('购买时间不能为空！'); $("#madeDate").focus();
                return false;
            }
            if($("#lastDate").val() == ''){
                alert('有效期不能为空！'); $("#lastDate").focus();
                return false;
            }
            if($("#madeNum").val() == ''){
                alert('购买数量不能为空！'); $("#madeNum").focus();
                return false;
            }
    });

})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td><b>客户名称</b></td>
                <td><input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo('<?php echo $base_url;?>index.php','/business/CustomerController/getCustomerInfo','name')"></td>
                <div id="m_tagsItem" style="display:none"><div id="tagClose">关闭</div><p><font id="dvelopersInfo"></font></p></div>
            </tr>
            
            <tr>
                <td><b>票种</b></td>
                <td>
                    <select name="tId" id="tId">
                         <option value="">-请选择-</option>
                         <?php foreach($toolsList as $k=>$v){?>
                         <option value="<?php echo $v['tId'];?>"><?php echo $v['name'];?></option>
                         <?php } ?>
                    </select>
                </td>
            </tr>
 
            <tr>
                <td><b>购买时间</b></td>
                <td><input type="text" name="madeDate" id="madeDate" onClick="WdatePicker()"></td>
            </tr>
            
            <tr>
                <td><b>有效期</b></td>
                <td><input type="text" name="lastDate" id="lastDate" onClick="WdatePicker()"></td>
            </tr>
            
            <tr>
                <td><b>购买数量</b></td>
                <td><input type="text" name="madeNum" id="madeNum" class="span1"></td>
            </tr>
            
            <tr>
                <td><b>制版费</b></td>
                <td><input type="text" name="price" id="price" class="span1">&nbsp;元</td>
            </tr>
        
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">
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