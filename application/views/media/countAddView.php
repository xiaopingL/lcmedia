<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
	        if($("#countDate").val() == ''){
	            alert('月份不能为空！'); $("#countDate").focus();
	            return false;
	        }
	        if($("#box_num").val() == ''){
	            alert('票房不能为空！'); $("#box_num").focus();
	            return false;
	        }
	        if($("#person_num").val() == ''){
	            alert('人次不能为空！'); $("#person_num").focus();
	            return false;
	        }
            if($("#advert_num").val() == ''){
                alert('广告可覆盖人次不能为空！'); $("#advert_num").focus();
                return false;
            }
            if($("#film_num").val() == ''){
                alert('场次不能为空！'); $("#film_num").focus();
                return false;
            }
    });
})
</script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
		    <tr>
                <td style="text-align: center;font-weight: bold;">影城名称</td>
                <td colspan="3">
                    <input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo('<?php echo $base_url;?>index.php','/media/StudioController/getStudioInfo','name')">
                </td>
                <div id="m_tagsItem" style="display:none">
	                <div id="tagClose">关闭</div>
	                <p><font id="dvelopersInfo"></font></p>
                </div>
            </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">月份</td>
                <td colspan="3">
                    <input type="text" name="countDate" id="countDate" class="span2" onClick="WdatePicker({dateFmt:'yyyy MM'})">
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">票房</td>
                <td><input type="text" name="box_num" id="box_num" class="span1"></td>
                <td width="10%" style="text-align: center;font-weight: bold;">人次</td>
                <td><input type="text" name="person_num" id="person_num" class="span1"></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">广告可覆盖人次</td>
                <td><input type="text" name="advert_num" id="advert_num" class="span1"></td>
                <td width="10%" style="text-align: center;font-weight: bold;">场次</td>
                <td><input type="text" name="film_num" id="film_num" class="span1"></td>
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
