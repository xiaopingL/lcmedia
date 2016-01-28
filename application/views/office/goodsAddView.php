<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#type").val() == ''){
                alert('申请种类不能为空！'); $("#type").focus();
                return false;
            }
            if($("#type").val() == 1){
                if($("#category").val() == ''){
                    alert('票务类型不能为空！'); $("#category").focus();
                    return false;
                }
            }
            if($("#tId").val() == ''){
                alert('物料名称不能为空！'); $("#tId").focus();
                return false;
            }
            if($("#num").val() == ''){
                alert('领取数量不能为空！'); $("#num").focus();
                return false;
            }
    });

    $("#type").change(function(){
        if($(this).val() == 1){
             $("#category_arg").css('display','');
        }else{
        	$("#category_arg").css('display','none');
        }

        if($(this).val() != ''){
	        $.ajax({
	            type:"post",
	            data: "type=" + $(this).val(),
	            url:"<?php echo $base_url;?>index.php/office/GoodsController/getTools",
	            success: function(result)
	            {
	            	$("#tId").empty();
	                $("#tId").append(result);
	            }
	        });
        }
    });

    $("#tId").change(function(){
        if($(this).val() != ''){
	        $.ajax({
	            type:"post",
	            data: "tId=" + $(this).val(),
	            url:"<?php echo $base_url;?>index.php/office/GoodsController/getStock",
	            success: function(result)
	            {
	                $("#stock_arg").css('display','');
	                $("#stock_arg").empty();
	                $("#stock_arg").append(result);
	            }
	        });
        }else{
        	$("#stock_arg").css('display','none');
        }
    });

    $("#category").change(function(){
        if($(this).val() == 1 || $(this).val() == 2){
            $.ajax({
                type:"post",
                data: "category=" + $(this).val(),
                url:"<?php echo $base_url;?>index.php/office/GoodsController/getCategory",
                success: function(result)
                {
                    $("#client_arg").css('display','');
                    $("#client").empty();
                    $("#client").append(result);
                }
            });
        }else{
            $("#client_arg").css('display','none');
        }
    });
    
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%"><b>申请种类</b></td>
                <td>
                    <select name="type" id="type">
                         <option value="">-请选择-</option>
                         <option value="1">票务申请</option>
                         <option value="2">其他申请</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><b>物料名称</b></td>
                <td>
                    <select name="tId" id="tId">
                         <option value="">-请选择-</option>
                         <?php foreach($toolsList as $k=>$v){?>
                         <option value="<?php echo $v['tId'];?>"><?php echo $v['name'];?></option>
                         <?php } ?>
                    </select>
                    &nbsp;&nbsp;<span id="stock_arg" style="color:red"></span>
                </td>
            </tr>
            
            <tr id="category_arg" style="display:none">
                <td><b>票务类型</b></td>
                <td>
                    <select name="category" id="category">
                         <option value="">-请选择-</option>
                         <option value="1">合同赠票</option>
                         <option value="2">客户购买</option>
                         <option value="3">个人申领</option>
                    </select>
                </td>
            </tr>
            
            <tr id="client_arg" style="display:none">
                <td><b>客户信息</b></td>
                <td id="client"></td>
                <div id="m_tagsItem" style="display:none"><div id="tagClose">关闭</div><p><font id="dvelopersInfo"></font></p></div>
            </tr>
            
            <tr>
                <td><b>领取数量</b></td>
                <td><input type="text" name="num" id="num" class="span1"></td>
            </tr>
            
            <tr>
                <td><b>备注说明</b></td>
                <td><textarea name="note" id="note" class="span4"></textarea></td>
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