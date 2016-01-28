<script type="text/javascript">
$(function(){
        $("#city").change(function(){

            $("#staff_email").empty();
            $.ajax({
                type:"post",
                data: "cid=" + $(this).val(),
                url:"<?=$this->config->item('base_url')?>index.php/personnel/TrainController/ajaxGetDep/",

                beforeSend: function() {
                    $("#staff_email").empty();
                    $("#staff_email").append('<option value=>读取中……</option>');
                },

                success: function(result)
                {
                    //alert(result);return false;
                    if($("#city").val()=='0' || $("#city").val()=='1000')
                    {
                        $("#staff_email").empty();
                        $("#cc_staff").empty();
                        $("#cc_staff").val(result);
                    }else{
                        $("#staff_email").empty();
                        $("#staff_email").append(result);
                    }
                }
            });
        })
    })
  

$(function(){
	$("#staff_email").change(function(){

		str=$('#mail_value').val();
		//alert($("#staff option").size());return false;
		if($(this).val()=='0')
		{
			//alert($("#staff").get(0).options[i].value);return false;

			for(var i=0;i<$("#staff_email option").size();i++)
			{

				if($("#staff_email").get(0).options[i].value !='0')
				{
					staff_str	= $(str).val();
					//alert($("#staff").get(0).options[i].text);return false;
                                        
					if(staff_str.indexOf($("#staff_email").get(0).options[i].text+'-'+$("#staff_email").get(0).options[i].value)<0)
					{
                                            $(str).val(staff_str+$("#staff_email").get(0).options[i].value+';');
                                            //$(str).val(staff_str+$("#staff").get(0).options[i].text+''+$("#staff").get(0).options[i].value+';');
					}
				}
			}
		}else{

			if($("#staff_email option[selected]").length>1)
			{
				return false;
			}

			staff_str	= $(str).val();

			if(staff_str.indexOf($("#staff_email option[selected]").text()+''+$(this).val())<0)
			{
				$(str).val(staff_str+$("#staff_email option[selected]").text()+''+$(this).val()+';');
			}
		}
		return false;
	})

	$("#staff_email").dblclick(function(){

        str=$('#mail_value').val();
		staff_str	= $(str).val();

		if(staff_str.indexOf($("#staff_email option[selected]").text()+''+$(this).val())>=0)
		{
			$(str).val(staff_str.replace($("#staff_email option[selected]").text()+''+$(this).val()+';',''));
			$("#staff").val('');
		}
		return false;
	})

})
 
    $(function(){
        $("#mail_ca").click(function(){
            $("#cc_staff").val('');
            return false;
        })

    })
    
</script>
<script type="text/javascript">
   
	function passSet(){
		if(document.getElementById("className").value != ''){			
				if(document.getElementById("cc_staff").value != ''){			
					if(document.getElementById("classMemo").value != ''){			
							return true;		
					}else{
						alert("请输入讨论区介绍！");
						document.getElementById("classMemo").focus();
						return false;
					}		
				}else{
					alert("请选择版主！");
					document.getElementById("cc_staff").focus();
					return false;
				}		
		}else{
			alert("请输入讨论区名称！");
			document.getElementById("className").focus();
			return false;
		}
		
		
		
		
	}
</script>
<div class=spaceborder style="WIDTH: 100%;">
    <table width="100%" height="100%" border="0" bordercolor="#bdebff" cellSpacing=0 cellPadding=0>
        
        <td>
            <table width="100%" height="100%">
                <tr valign="top" align="center">
                    <td height="30px">
                        <table width="98%" height="100%" cellpadding="0" cellspacing="0">
                            <tr valign="middle">
                                <td style="text-align:left;"><img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;<strong>新建讨论区</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                

                <tr>
                    <td>
                        <form action="<?php echo site_url('/office/ForumController/forumClassAdd');?>" method="post" enctype="multipart/form-data" id="mainform" onsubmit="if(!passSet())return false;" name="mainform" class="form_validation_ttip" novalidate="novalidate" >
                        <table width="98%" height="100%" border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=0 style="margin-left:8px;">
						
							<tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>板块名称：</b></td>
                                <td style="padding-left:5px;"> <input type="text" name="className" id="className" value="" />                                      
                                </td>
                            </tr>
                            <tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>选择版主：</b></td>
                                <td class="altbg2" colspan="3" height="100px;" style="padding-left:5px; padding-top:5px;"><select name="city" id="city" style="width:300px;height:150px;" size="5" multiple >
                                        <option style="color:#F00" value="0">全部</option>
                                        <?php foreach($org as $val) { ?>
                                        <option value="<?php echo $val['sId'];?>" style="<?php if($val['level']=='1') {
                                                echo 'font-weight:bold;color:black;';
                                                    } ?>">
                                                        <?php
                                                        for($i=1;$i<$val['level'];$i++) {
                                                            echo "====";
                                                        }
                                                ?><?php echo $val['name'];?></option>
                                         <?php }?>
                                    </select>
                                    <select name="staff_email" id="staff_email" style="width:150px;height:150px;" size="5" multiple></select>
                                    
                                   </td>
                            </tr>
                            <tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>版主：</b></td>
                                <td height="100px;" style="padding-left:5px;">
                                    <div class="input">
                                        <textarea name="cc_staff" id="cc_staff" cols="66" rows="3" style="width: 300px;"></textarea>
                                        <input type="hidden" value="" id="arr_staff" />
                                        <input type="hidden" value="#cc_staff" id="mail_value" />
                                        <a href="#" id="mail_ca"><span class="forum_edit"><b>清空</b></span></a>
                                    </div>
                                </td>
                            </tr>
                            <tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>板块简介：</b></td>
                                <td height="100px;" style="padding-left:5px;">
                                    <div class="input">
                                        <textarea name="classMemo" id="classMemo" cols="66" rows="3" style="width: 300px;"></textarea>
                                       
                                    </div>
                                </td>
                            </tr>
                           
                           
                           
                           
                           <tr>
                                <td colspan="10" style="text-align:center;">
                                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">
                                                                提交内容
                                    </button>
                                    <button type="reset" class="btn">
                                                                重置
                                    </button>
                                </td>
                            </tr>
                        </table>
                      </form>
                    </td>
                </tr>
            </table>
        </td>
    </table>
</div>
<script>
var photo_id = '';
function callback(filePath){
	if ( reobj(photo_id) ) {
		reobj(photo_id).value = filePath;
	}
}
function check_photo(photo_id_){
	photo_id = photo_id_;
	
}
function callback1(origName){
		var oriName = origName
		document.getElementById("origName").value = oriName;
}
function callback2(fileName){
		var filName = fileName
		document.getElementById("fileName").value = filName;
}
function callback3(fileExt){
		var extType = fileExt
		document.getElementById("fileExt").value = extType;
}
function callback4(fileSize){
		var size = fileSize
		document.getElementById("fileSize").value = size;
}
</script>
