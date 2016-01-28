<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#department").change(function(){
		if($(this).val()!='')
		{
			$("#receiveId").css('display','');
			$("#receiveId").empty();
			$("#receiveId").append('<option value=>姓名</option>');
			$.ajax({
				type:"post",
				data: "orgid=" + $(this).val(),
				url:"<?php echo $base_url;?>index.php/admin/UserController/getDepUser",
				success: function(result)
				{
					$("#receiveId").append(result);
				}
            });

		}
	})
})
</script>
<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%" style="font-weight: bold;vertical-align: middle;text-align: center;">客户名称</td>
                <td><?php echo $detail['name']?></td>
            </tr>

            <tr id="TLink" class="">
                <td width="15%" style="font-weight: bold;vertical-align: middle;text-align: center;">接收业务员</td>
                <td>
                    <select name="department" id="department">
				  		   <option value="">--请选择--</option>
						   <?php foreach($org as $val){ ?>
				  		   <option value="<?php echo $val['sId'];?>" style="<?php if($val['level']==1){echo 'font-weight:bold;color:black;';} ?>" <?php echo $val['sId']==$dep[0]['sId']?'selected':''; ?>>
						   <?php
						   for($i=1;$i<$val['level'];$i++)
						   {
							  echo "====";
						   }
						   ?><?php echo $val['name'];?></option>
						  <?php }?>
					</select>&nbsp;
                    --&nbsp;<select name="receiveId" id="receiveId" class="span1">
                    <?php foreach($uIdArr as $value){ ?>
                    <option value="<?php echo $value['uId']; ?>"><?php echo $value['name']; ?></option>
                    <?php } ?>
                    </select>
                 </td>
            </tr>

            <tr>
                <td width="15%" style="font-weight: bold;vertical-align: middle;text-align: center;">服务开始日期</td>
                <td><input type="text" style="width:100px;" name="startDate" value="<?php echo date('Y-m-d')?>"  onClick="WdatePicker()"></td>
            </tr>
            

            <tr>
                <td colspan="2" style="padding-left:100px;">
                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;" name="submitCreate" value="提交">我要转交</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>