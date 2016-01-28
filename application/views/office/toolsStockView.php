<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#num").val() == ''){
                alert('本次入库数量不能为空！'); $("#num").focus();
                return false;
            }
    })
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%"><b>物料名称</b></td>
                <td><?php echo $arr['name']?></td>
            </tr>
            
            <tr>
                <td><b>本次入库数量</b></td>
                <td><input type="text" name="num" id="num" value="" class="span1" /></td>
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