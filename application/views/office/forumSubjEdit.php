<script language="javascript" charset="utf-8" src="http://photoport.xkhouse.com/dantu/js/uploadImg.js"></script>
<!--<script type="text/javascript" src="<?php echo $base_url;?>js/ymPrompt/ymPrompt.js"></script>
<link  href="<?php echo $base_url;?>js/ymPrompt/skin/qq/ymPrompt.css" rel="stylesheet" type="text/css" />-->
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
    
function showdiv(str)
{
	var msgw,msgh,bordercolor;
	msgw=400;//提示窗口的宽度
	msgh=100;//提示窗口的高度
	bordercolor="#336699";//提示窗口的边框颜色
	titlecolor="#99CCFF";//提示窗口的标题颜色
	var sWidth,sHeight;
	sWidth=document.body.offsetWidth;
	sHeight='400';
	var bgObj=document.createElement("div");
	bgObj.setAttribute('id','bgDiv');
	bgObj.style.position="absolute";
	bgObj.style.top="0";
	bgObj.style.background="";
	bgObj.style.filter="progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=25,finishOpacity=75";
	bgObj.style.opacity="0.6";
	bgObj.style.left="0";
	bgObj.style.width=sWidth + "px";
	bgObj.style.height=sHeight + "px";
	document.body.appendChild(bgObj);
	var msgObj=document.createElement("div")
	msgObj.setAttribute("id","msgDiv");
	msgObj.setAttribute("align","center");
	msgObj.style.position="absolute";
	msgObj.style.background="white";
	msgObj.style.font="12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif";
	msgObj.style.border="1px solid " + bordercolor;
	msgObj.style.width=msgw + "px";
	msgObj.style.height=msgh + "px";
        msgObj.style.top=(document.documentElement.scrollTop + (sHeight-msgh)/2) + "px";
        msgObj.style.left=(sWidth-msgw)/2 + "px";
        var title=document.createElement("h4");
        title.setAttribute("id","msgTitle");
        title.setAttribute("align","right");
        title.style.margin="0";
        title.style.padding="3px";
        title.style.background=bordercolor;
        title.style.filter="progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";
        title.style.opacity="0.75";
        title.style.border="1px solid " + bordercolor;
        title.style.height="18px";
        title.style.font="12px Verdana, Geneva, Arial, Helvetica, sans-serif";
        title.style.color="white";
        title.style.cursor="pointer";

        document.body.appendChild(msgObj);
        document.getElementById("msgDiv").appendChild(title);
        var txt=document.createElement("p");
        txt.setAttribute("id","msgTxt");
        txt.innerHTML=str;
        document.getElementById("msgDiv").appendChild(txt);

}
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

function gbcount(message,total,used,remain)
{
   var max;
   max = total.value;
   if (message.value.length > max) {
    message.value = message.value.substring(0,max);
    used.value = max;
    remain.value = 0;
    alert("标题不能超过16个字!");
   }else {
      used.value = message.value.length;
      remain.value = max - used.value;
   }
}
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
                                <td style="text-align:left;"><img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;<strong>新增主题</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                

                <tr>
                    <td>
                        <form action="<?php echo site_url('/office/ForumController/forumSubjEdit');?>" method="post" enctype="multipart/form-data" id="mainform" onsubmit="if(!passSet())return false;" name="mainform" class="form_validation_ttip" novalidate="novalidate" >
                        <table width="98%" height="100%" border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=0 style="margin-left:8px;">
						
							<tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>主题名称：</b></td>
                                <td style="padding-left:5px;">
								<select name="pid" class="span2" id="pid">
								<option  value="选择主题类别">选择主题类别</option>
								<?php
								
								foreach($forumClass as $key=>$val){
									if($key == $claDet['pid']){										
										echo '<option value="'.$key.'" selected>'.$val['className'].'</option>';
									}else{										
										echo '<option value="'.$key.'">'.$val['className'].'</option>';
									}
								}
								
								?>
								</select> 									
								 <input type="hidden" id="id" name="id" value="<?php echo $claDet['id'];?>" />
								 <input type="text" name="className" id="className" class="span2" value="<?php echo $claDet['className'];?>" />&nbsp;&nbsp;                                      
                                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">
                                                                确认
                                    </button>
                                    
                                </td>
                            </tr>  
                           <tr>
                                
                            </tr>
                        </table>
                      </form>
                    </td>
                </tr>
				<tr>
					<td colspan="10" style="text-align:center;">  
						<table class="table table-condensed">
							<thead>
								<tr>
									<th width="35%">&nbsp;&nbsp;主题名称</th>
									<th width="25%">添加时间</th>
									<th width="25%">父类名称</th>
									<th width="15%">操作</th> 
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($arr)):?>
									<?php  foreach($arr as $key=>$value):?>
									
								<tr class="rowlink">
									
								<td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url("office/ForumArtController/forumArtList/"."?subcid=".$value['id']);?>"><?php echo $value['className']; ?></a></td>
									<td width="10%"><?php echo date('Y-m-d H:i',$value['postDate']); ?></td>
									<td width="10%"><?php echo $forumClass[$value['pid']]['className'];?></td>
									<td width="10%"><a href="<?php echo site_url("office/ForumController/classDel/".$value['id']);?>">删除</a>|<a href="<?php echo site_url("office/ForumController/forumSubjEdit/".$value['id']);?>">修改</a></td>
									 
								</tr>           
										<?php endforeach;?>
								<?php else:?>
								<tr><td colspan="7" style="text-align:center">您查看的记录为空</td></tr>
								<?php endif;?>
							</tbody>
						</table>
	
	
	
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
