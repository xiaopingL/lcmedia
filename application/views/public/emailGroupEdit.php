<script type="text/javascript">
    function checkInfo()
    {
        if($("#title_email").val()=='')
         {
              alert('对不起，分组名称不能为空！');return false;
         }
        if($("#cc_staff").val()=='')
          {
              alert('对不起，分组人员不能为空！');return false;
          }
        
    }
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

        $("#copy_ca").click(function(){
            $("#cp_staff").val('');
            return false;
        })

        $("#cc_staff").focus(function(){
            $('#mail_value').val('#cc_staff');

        })

        $("#cp_staff").focus(function(){
            $('#mail_value').val('#cp_staff');

        })


    })
    function checkWords(field){
        if(field.defaultValue==field.value){
        	field.value='';
        	field.style.color='black';
        }else if(field.value==''){
        	field.value=field.defaultValue;
        	field.style.color='gray';
        }
}
    function getSearchName(){
    $.ajax({
	type:"post",
	data: "username=" + encodeURI($("#searchName").val()),
	url:"<?php echo site_url("/public/EmailController/emailUser");?>",
	success: function(result)
	{
            $("#cc_staff").append(result);
	}
   });
}
function checktag(inputName,name){
    $('#'+inputName).val(name);
    getSearchName();
    $("#m_tagsItem").hide();
}

$(function(){
    $("#tagClose").click(function(){
       $("#m_tagsItem").hide();
    })
})
</script>
<div class=spaceborder style="WIDTH: 100%;">
    <table width="100%" height="100%" border="0" bordercolor="#bdebff" cellSpacing=0 cellPadding=0>
        <td valign="top" width="160px">
            <table border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=4 height="100%">
                <tr>
                    <td class="mail_bg" width="80" height="30" background="<?php echo $base_url;?>img/mail_bg1.gif">
                        <a href="<?php echo site_url("/public/EmailController/emailListView");?>" style="text-decoration:none"><img src="<?php echo $base_url;?>img/mail_wd.png" border="0" />&nbsp;
                            <font style="font-size:16px"><b>收信</b></font>
                        </a>
                    </td>
                    <td class="mail_bg" width="80" background="<?php echo $base_url;?>img/mail_bg1.gif">
                        <a href="<?php echo site_url('/public/EmailController/emailAddView/'); ?>" style="text-decoration:none"><img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;
                            <font style="font-size:16px"><b>写信</b></font>
                        </a>
                    </td>

                </tr>
                <tr>
                    <td class="to_td" colspan="2" height="20"><a href="<?php echo site_url("/public/EmailController/emailListView");?>" style="text-decoration:none; padding-left:20px"><img src="<?php echo $base_url;?>img/mail_inbox.gif" border="0" />&nbsp;
                            收件箱 (<?php echo $emailRecipient;?>)
                        </a></td>
                </tr>
                <tr>
                    <td class="to_td" colspan="2" height="20"><a href="<?php echo site_url("/public/EmailController/emailSentView");?>" style="text-decoration:none; padding-left:20px"><img src="<?php echo $base_url;?>img/mail_sentbox.gif" border="0" />&nbsp;
                            已发送 (<?php echo $emailSent;?>)
                        </a></td>
                </tr>
                <tr>
                    <td class="to_td" colspan="2" height="20"><a href="<?php echo site_url("/public/EmailController/emailDelView");?>" style="text-decoration:none; padding-left:20px"><img src="<?php echo $base_url;?>img/mail_trash.gif" border="0" />&nbsp;
                            已删除 (<?php echo $emailDel;?>)
                        </a></td>
                </tr>
                <tr>
                    <td class="to_td" colspan="2" height="20"><a href="<?php echo site_url("/public/EmailController/emailNreadView");?>" style="text-decoration:none; padding-left:20px; color:red">
                            未读邮件 (<?php echo $emailNoread;?>)
                        </a></td>
                </tr>

                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </td>

        <td>
            <table width="100%" height="100%">
                <tr valign="top" align="center">
                    <td height="30px">
                        <table width="98%" height="100%" cellpadding="0" cellspacing="0">
                            <tr valign="middle">
                                <td style="text-align:left;"><img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;<font style="font-size:16px"><b>邮件分组</b></font></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                

                <tr>
                    <td>
                        <form action="<?php echo site_url('/public/EmailController/emailModify');?>" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate" onSubmit="return checkInfo();">
                        <table width="98%" height="100%" border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=0 style="margin-left:8px;">
                            <tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>选择：</b></td>
                                <td class="altbg2" colspan="3" height="100px;" style="padding-left:5px; padding-top:5px;"><select name="city" id="city" style="width:300px;height:150px;" size="5" multiple >
                                        <option style="color:#F00" value="0">全部</option>
                                        <?php foreach($org as $val) { ?>
                                        <option value="<?php echo $val['sId'];?>" <?php if($sId == $val['sId']):?> selected<?php endif;?> style="<?php if($val['level']==1) {
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
                                    <input type="text" name="searchName" id="searchName" style="width:70px; margin-top: 115px;" value="输入收件人" onblur="checkWords(this)" onfocus="checkWords(this)" style="color:gray" onkeyup="getAllInfo('<?php echo site_url("admin/UserController/getSendInfo")?>','searchName')" onClick="if(this.value==''){this.value='';this.className='m_tagsname'}"/>
                                   <div id="m_tagsItem" style="display:none;margin-top: -115px;">
                                        <div id="tagClose">关闭</div>
                                        <p><font id="dvelopersInfo"></font></p>
                                   </div>
                                    <br> &nbsp;<br>（点击人员姓名添加至收件人栏目中，<font color="#FF0000">再次<b>双击</b>此人员，即可从收件人中删除，</font>点击全部添加全部人员)
                                    <a href="<?= site_url("/public/EmailController/emailGroupList") ?>"><b>分组列表</b><img src="<?php echo $base_url;?>img/new1.gif" border="0" align="absmiddle"></a>
                                </td>
                            </tr>
                            
                            <tr valign="middle">
                               <td width="10%" style="text-align: right;"><b>分组名称：</b></td>
                               <td height="35px;" style="padding-left:5px;">
                                   <input type="text" name="title_email" id="title_email" style="width: 300px;" value="<?php echo $arr['grouptitle'];?>" />
                               </td>
                           </tr>
                            <tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>收件人：</b></td>
                                <td height="100px;" style="padding-left:5px;">
                                    <div class="input">
                                        <textarea name="cc_staff[]" id="cc_staff" cols="66" rows="3" style="width: 300px;"><?php echo $arr['groupcontent'];?></textarea>
                                        <input type="hidden" value="" id="arr_staff" />
                                        <input type="hidden" value="#cc_staff" id="mail_value" />
                                        <a href="#" id="mail_ca"><span class="forum_edit"><b>清空</b></span></a>
                                        <!--<a href="#" id="add_copy_to"><span class="forum_edit">添加抄送</span></a>-->
                                        <?php
                                            foreach($mail_ca as $value) {
                                                echo $value;
                                            }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                           <tr>
                                <td colspan="10" style="text-align:center;">
                                    <input type="hidden" value="<?php echo $arr['group_id'];?>" name="group_id" id="group_id" />
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
