<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
	        if($("#month").val() == ''){
	            alert('标题月份不能为空！'); $("#month").focus();
	            return false;
	        }
	        if($("#days").val() == ''){
	            alert('标题日期不能为空！'); $("#days").focus();
	            return false;
	        }
            if($("#content").val() == ''){
                alert('排期广告内容不能为空！'); $("#content").focus();
                return false;
            }
            if($("#overplus_min").val() == ''){
                alert('剩余广告时长(分)不能为空！'); $("#overplus_min").focus();
                return false;
            }
            if($("#overplus_sec").val() == ''){
                alert('剩余广告时长(秒)不能为空！'); $("#overplus_sec").focus();
                return false;
            }
    });
})
</script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
		    <tr>
		        <td style="text-align: center;font-weight: bold;">标题</td>
		        <td>领程传媒 <input type="text" name="month" id="month" class="span1"> 月 <input type="text" name="days" id="days" class="span1"> 日广告排期表</td>
		    </tr>
            
		    <tr>
                <td style="text-align: center;font-weight: bold;">影城名称</td>
                <td>
                    <input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo('<?php echo $base_url;?>index.php','/media/StudioController/getStudioInfo','name')">
                </td>
                <div id="m_tagsItem" style="display:none">
	                <div id="tagClose">关闭</div>
	                <p><font id="dvelopersInfo"></font></p>
                </div>
            </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">排期时间</td>
                <td>
                    <input type="text" name="startDate" id="startDate" style="width:90px" onClick="WdatePicker()">&nbsp;至&nbsp;
                    <input type="text" name="endDate" id="endDate" style="width:90px" onClick="WdatePicker()">
                </td>
            </tr>
             
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">排期广告</td>
                <td><textarea name="content" id="content" class="span5"></textarea></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">剩余广告时长</td>
                <td><input type="text" name="overplus_min" id="overplus_min" class="span1">&nbsp;分&nbsp;<input type="text" name="overplus_sec" id="overplus_sec" class="span1">&nbsp;秒</td>
            </tr>
            
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
