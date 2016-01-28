<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#name").val() == ''){
                alert('物料名称不能为空！'); $("#name").focus();
                return false;
            }
            if($("#unit").val() == ''){
                alert('物料单位不能为空！'); $("#unit").focus();
                return false;
            }
            if($("#price").val() == ''){
                alert('物料单价不能为空！'); $("#price").focus();
                return false;
            }
    })
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%"><b>物料类别</b></td>
                <td>
                    <input type="radio" name="type" value="1" <?php echo $arr['type']==1?'checked':'';?> />票务&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="type" value="2" <?php echo $arr['type']==2?'checked':'';?> />其他
                </td>
            </tr>

            <tr>
                <td><b>物料名称</b></td>
                <td><input type="text" name="name" id="name" value="<?php echo $arr['name']?>" placeholder="" /></td>
            </tr>
            
            <tr>
                <td><b>物料单位</b></td>
                <td><input type="text" name="unit" id="unit" value="<?php echo $arr['unit']?>" class="span1" /></td>
            </tr>

            <tr>
                <td><b>物料单价</b></td>
                <td><input type="text" name="price" id="price" value="<?php echo $arr['price']?>" class="span1" />&nbsp;元</td>
            </tr>
            
            <tr>
                <td><b>备注说明</b></td>
                <td><textarea name="remark" class="span3"><?php echo $arr['remark'];?></textarea></td>
            </tr>

            <tr>
                <td colspan="10" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">
						提交内容
                    </button>
                    <button type="button" class="btn" onClick="javascript:history.go(-1)">返回</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>