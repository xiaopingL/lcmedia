<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ueditor/ueditor_config.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ueditor/ueditor.all.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/lang/zh_CN.js"></script>
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

function gbcount(message,total,used,remain)
{
   var max;
   max = total.value;
   if (message.value.length > max) {
    message.value = message.value.substring(0,max);
    used.value = max;
    remain.value = 0;
    alert("标题不能超过22个字!");
   }else {
      used.value = message.value.length;
      remain.value = max - used.value;
   }
}

</script>
<form action="<?php echo site_url('/office/ForumArtController/forumArtMod').'/'.$arr[id].'/'.$arr['aid'];?>" method="post" class="form_validation_ttip"  novalidate="novalidate" enctype="multipart/form-data" id="mainform" name="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr style="display:none">
                <td>版块导航</td>
                <td height="30px" align="left" style="padding-left:10px">
							<font style=" font-size:14px"><b><a href="<?php echo site_url('/office/ForumController/classList');?>">讨论区</a> -><a href="<?php echo site_url('/office/ForumArtController/forumArtList');?>/?cid=<?php echo $arr['aid'];?>"><?php echo $forumClass[$arr['aid']]['className'];?></a>-> 修改内容</b></font></td>
          </tr>
    
                <tr>
                <td>标题</td>
                <td>
					<span id="select"></span>&nbsp;<input id="title" type="text" onkeyup="gbcount(this.form.title,this.form.total,this.form.used,this.form.remain);" onkeydown="gbcount(this.form.title,this.form.total,this.form.used,this.form.remain);" wrap="PHYSICAL" style="width: 300px;" name="title" value="<?php echo $arr['title'];?>">
<input class="inputtext" type="hidden" value="22" size="3" name="total" maxlength="4" disabled="">
<input class="inputtext" type="hidden" value="9" size="3" name="used" maxlength="4" disabled="">
(还可以输入
<input type="text" readnoly="" style="border:none;color:red;font-size:18px;font-family:华文行楷;width: 20px;" value="<?php echo 22-mb_strlen($arr['title']);?>" size="1" name="remain">
个字) 
				
				</td>
                </tr>
                <tr>
                <td>内容</td>
                <td style="max-width:900px;">
					<textarea id="myEditor" name="content" style="width:100%;height:400px;">                                        
                                        <?php echo $arr['content'];?>
                                    </textarea>
					<script type="text/javascript">
					   KindEditor.ready(function(K) {
								window.editor = K.create('#myEditor');
						});
						KindEditor.options.filterMode = false;
					</script>
                </td>
            </tr>
			
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">
                        提交
                    </button>
                    <button type="reset" class="btn">
                        重置
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</form>