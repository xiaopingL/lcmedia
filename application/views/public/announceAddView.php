<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<!--<script type="text/javascript" src="<?php echo $base_url;?>js/ueditor/ueditor_config.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ueditor/ueditor.all.js"></script>-->
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    $(function(){
        $(".form_validation_ttip").submit(function(){
                if($("#department").val() == ''){
                    alert('审核人不能为空');
                    $("#department").focus();
                    return false;
                }
        })
        })

        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_id');
        });
        KindEditor.options.filterMode = false;

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

<form action="" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td style="width:5%"><b>类型</b></td>
                <td>
                    <?php foreach($config_new as $k=>$v){?>
                     <input type="radio"  name="type" id="type" value="<?php echo $k;?>"  <?php if($type==$k){ ?>checked="checked"<?php }?>/><?php echo $v;?>&nbsp;&nbsp;&nbsp;&nbsp;
                     <?php }?>
                <span style="color:#FF0000"><?=form_error('type');?></span>
                </td>
            </tr>

            <tr>
                <td style="width:5%"><b>标题</b></td>
                <td width="30%"><input type="text" name="title" id="title" style="width:280px;" value="<?php echo set_value('title',$title,true);?>">
                <span style="color:#FF0000"><?=form_error('title');?></span>
                </td>
            </tr>

            <tr>
                <td style="width:5%"><b>内容</b></td>
                <td style="max-width:900px;">
                    <textarea id="editor_id" name="content" style="width: 85%;height:500px;">
                        <?php echo str_replace("&", "&amp;", $content);?>
                    </textarea>
                 <!--<textarea name="content" id="myEditor"><?php echo $content;?></textarea>
					<script type="text/javascript">
					    var editor = new UE.ui.Editor();
					    editor.render("myEditor");
					    //1.2.4以后可以使用一下代码实例化编辑器
					    //UE.getEditor('myEditor')
					</script>
					<span style="color:#FF0000"><?=form_error('content');?></span>-->
		</td>
            </tr>
            <tr>
                <td class="altbg1"style="width:5%" align="center"><span class="bold">附件</span></td>
                <td class="altbg2">
                    <div class="input">
                        <input type="hidden" name="isUserfile" id="isUserfile">
                    	<input type="file" name="userfile" size="25" value="" onChange="javascript:document.mainform.isUserfile.value = document.mainform.userfile.value" />
                        <br/>
                        <span style="color:#FF0000"><?php echo form_error('isUserfile');?></span>
                    </div>
                </td>
            </tr>
            <?php if(empty($id)):?>
            <tr>
                    <td><span class="bold">审核人</span></td>
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
             <?php endif;?>
            <tr>
                <td colspan="2" style="text-align:center;">
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