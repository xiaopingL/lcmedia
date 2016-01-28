<script type="text/javascript">
    function checkInfo()
    {
        if($("#cc_staff").val()=='')
        {
            alert('对不起，收件人不能为空！');
            return false;
        }
        if($("#title_email").val()=='')
        {
            alert('对不起，标题不能为空！');
            return false;
        }

        if($("#include").val()=='' && $("#bfs").val()!='100')
        {
            alert('附件正在上传中，请稍后提交！');
            return false;
        }


        $(document).ready(function(){
        	$("#mainform").submit(function(){
                $(":submit",this).attr("disabled","disabled");
                $(":submit",this).attr("value","正在发送...");
            });
        });
        showdiv('<img src=<?php echo $base_url;?>img/loading.gif border=0 />&nbsp;&nbsp;'+'正在发送，请稍候……');
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

    function getgroupvalue(obj)
    {
        str=$('#mail_value').val();
        $(str).empty();
        $.ajax({
            type:"post",
            data: "groupid=" + $(obj).attr('value'),
            url:"<?=$this->config->item('base_url')?>index.php/public/EmailController/emailGroupNews/",
            beforeSend: function() {
                str=$('#mail_value').val();
                $(str).append('<option value=>读取中……</option>');
            },
            success: function(result)
            {
                $(str).empty();
                $(str).append(result);
            }
        });

    }
    $(function(){
        $("#staff_email").change(function(){

            str=$('#mail_value').val();
            if($(this).val()=='0')
            {
                for(var i=0;i<$("#staff_email option").size();i++)
                {

                    if($("#staff_email").get(0).options[i].value !='0')
                    {
                        staff_str	= $(str).val();

                        if(staff_str.indexOf($("#staff_email").get(0).options[i].text+'-'+$("#staff_email").get(0).options[i].value)<0)
                        {
                            $(str).val(staff_str+$("#staff_email").get(0).options[i].value+';');
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
            alert("标题不能超过25个字!");
        }else {
            used.value = message.value.length;
            remain.value = max - used.value;
        }
    }
</script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/lang/zh_CN.js"></script>
<script>

    KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id');
    });
    KindEditor.options.filterMode = false;
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
                                <td style="text-align:left;"><img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;<font style="font-size:16px"><b>写邮件</b></font></td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td>
                        <form action="<?php echo site_url('/public/EmailController/emailInsert');?>" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate" onSubmit="return checkInfo();">
                            <table width="98%" height="100%" border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=0 style="margin-left:8px;">
                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>选择：</b></td>
                                    <td class="altbg2" colspan="3" height="100px;" style="padding-left:5px; padding-top:5px;"><select name="city" id="city" style="width:300px;height:150px;" size="5" multiple >
                                            <option style="color:#F00" value="0">全部</option>
                                            <?php foreach($org as $val) { ?>
                                            <option value="<?php echo $val['sId'];?>" <?php if($sId == $val['sId']):?> selected<?php endif;?> style="<?php if($val['level']==1) {
                                                    echo 'font-weight:bold;color:black;';
                                                        }elseif($val['level']==2){echo 'font-weight:bold;color:green;';} ?>">
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
                                        <a href="<?= site_url("/public/EmailController/emailGroupList") ?>"><b>自定义分组</b><img src="<?php echo $base_url;?>img/new1.gif" border="0" align="absmiddle"></a>
                                    </td>
                                </tr>

                                <?php if(!empty($group)):?>
                                <tr valign="middle">
                                    <td style="text-align: right;"><span class="bold">自定义分组：</span></td>
                                    <td class="altbg2" height="35px;">
                                        <div class="input">
                                                <?php foreach($group as $value):?>
                                            <a href="#" onclick="javascript:getgroupvalue(this);" value="<?php echo $value['group_id'];?>">[<B><?php echo $value['grouptitle'];?></B>]</a>
                                                <?php endforeach;?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif;?>
                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>收件人：</b></td>
                                    <td height="100px;" style="padding-left:5px;">
                                        <div class="input">
                                            <textarea name="cc_staff[]" id="cc_staff" cols="66" rows="3" style="width: 300px;"></textarea>
                                            <input type="hidden" value="" id="arr_staff" />
                                            <input type="hidden" value="#cc_staff" id="mail_value" />
                                            <a href="#" id="mail_ca"><span class="forum_edit"><b>清空</b></span></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>邮件主题：</b></td>
                                    <td height="35px;" style="padding-left:5px;">
                                        <input type="text" name="title_email" id="title_email" style="width: 300px;" wrap=PHYSICAL onKeyDown="gbcount(this.form.title_email,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.title_email,this.form.total,this.form.used,this.form.remain);"/>
                                        <input disabled maxLength="4" type="hidden" name="total" size="3" value="25" class="inputtext">
                                        <input disabled maxLength="4" type="hidden" name="used" size="3" value="0" class="inputtext">
                                        (你还可以输入<input type="text" id="nameLength" name="remain" size="1" value="25" style="border:none;color:red;font-size:18px;font-family:华文行楷;width: 20px;" readnoly>个字)
                                    </td>
                                </tr>
                                <!--
                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>附件：</b></td>
                                    <td height="35px;" style="padding-left:5px;">
                                        <input type="hidden" name="isUserfile" id="isUserfile">
                                        <input type="file" name="userfile" size="25" value="" onChange="javascript:document.mainform.isUserfile.value = document.mainform.userfile.value" />
                                        <span style="color:red;">邮件附件不得超过10M</span>
                                    </td>
                                </tr>
                                -->
                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>附件：</b></td>
                                    <td height="35px;">
                                        <div id="main">
                                            <div class="demo">
                                                <!--<input type="file"><br/>-->
                                                <div class="aa" style="width:65%;height: auto;float:left;">
                                                    <div class="btn" style="margin-left:5px;color: black;"><span>添加附件</span><input id="fileupload" type="file" name="mypic"></div>
                                                    <div class="progress" style="float:left;">
                                                        <span class="bar"></span><span class="percent">0%</span>
                                                    </div>
                                                </div>
                                                <div class="files" style="margin-left:5px;float:left;width:70%;height:25px;margin-top:-5px;">&nbsp;</div>
                                                <div id="showimg"></div>
                                            </div>
                                        </div>
                                        <b style="color:red;">上传附件大小请在8M以内。</b>

                                    </td>
                                </tr>
                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>邮件内容：</b></td>
                                    <td valign="top">
                                        <textarea id="editor_id" name="content" style="width:100%;height:400px;">
                                        您好：<br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        <br />
                                        &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;致<br />
                                        礼!
                                        </textarea>
                                    </td>
                                </tr>

                                <!--<tr>
                                    <td width="10%" style="text-align: right;"><b>短信提醒：</b></td>
                                    <td height="35px;" style="padding-left:5px;">
                                        <input type="checkbox" value="1" name="email_type" id="email_type" checked>使用系统短信提醒 &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" value="1" name="sms" id="sms">使用手机短信提醒 </td>
                                </tr>-->
                                <script type="text/javascript">
                                </script>
                                <tr>
                                    <td colspan="10" style="text-align:center;">
                                        <input type="submit" name="submit" id="submit" class="btn1 btn-gebo" value="提交内容" style="margin-right: 20px;border-radius: 4px;height: 30px;width:80px;"/>
                                        <input type="reset" name="submit" id="submit" class="btn1 btn-gebo" value="重置"  style="margin-right: 20px;border-radius: 4px;height: 30px;width:60px;"/>
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
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.form.js"></script>
<script type="text/javascript">
    $(function () {
        var bar = $('.bar');           //进度条宽度
        var percent = $('.percent');   //进度条进度
        var showimg = $('#showimg');
        var progress = $(".progress"); //显示进度条
        var files = $(".files");       //文件名称
        var btn = $(".btn span");      //上传附件按钮
        $("#fileupload").wrap("<form id='myupload' action='<?php echo site_url("/public/EmailController/upload");?>' method='post' enctype='multipart/form-data'></form>");
        $("#fileupload").change(function(){ //选择文件
            $("#myupload").ajaxSubmit({
                dataType:  'json', //数据格式为json
                beforeSend: function() { //开始上传
                    showimg.empty(); //清空显示的图片
                    progress.show(); //显示进度条
                    var percentVal = '0%'; //开始进度为0%
                    bar.width(percentVal); //进度条的宽度
                    percent.html(percentVal); //显示进度为0%
                    btn.html("上传中..."); //上传按钮显示上传中
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%'; //获得进度
                    bar.width(percentVal); //上传进度条宽度变宽
                    percent.html(percentVal); //显示上传进度百分比
                },
                success: function(data) { //成功
                    //获得后台返回的json数据，显示文件名，大小，以及删除按钮
                    files.html("<b><a href='<?php echo site_url("/public/FileController/emailLoad");?>/"+data.fid+"'>"+data.origName+"</a>("+data.fileSize+"k)<input type='hidden' value='"+data.fid+"' id='include' name='include'/><input type='hidden' value='"+data.bfs+"' id='bfs' name='bfs'/></b>  <span class='delimg' rel='"+data.pic+"'>删除</span>");
                    if(data.fid != ''){
                        bar.width(data.bfs+'%');
                        percent.html(data.bfs+'%');
                        if($("#title_email").val() == ''){
                            $("#title_email").val(data.nameTitle);
                            $("#nameLength").val(data.length);
                        }
                        
                    }
                    //显示上传后的图片
                    //var img = "http://demo.helloweba.com/upload/files/"+data.pic;
                    //showimg.html("<img src='"+img+"'>");
                    btn.html("添加附件");
                },
                error:function(xhr){ //上传失败
                    btn.html("上传失败");
                    bar.width('0');
                    files.html(xhr.responseText); //返回失败信息
                }
            });
        });
        $(".delimg").live('click',function(){
            var pic = $(this).attr("rel");
            $.post("<?php echo site_url("/public/EmailController/upload");?>?act=delimg",{imagename:pic},function(msg){
                if(msg==1){
                    files.html("删除成功.");
                    showimg.empty();
                    progress.hide();
                }else{
                    alert(msg);
                }
            });
        });

    });
</script>
<style type="text/css">
    .btn{position: relative;overflow:hidden;display:
             block;width:100px; height: 20px;margin-right: 4px;display:inline-
             block;padding:4px 10px 4px;font-size:14px;color:#fff;text-
         align:center;vertical-align:middle;cursor:pointer;border:1px solid
             #cccccc;float: left;margin-bottom:8px;}
    .btn input {position: absolute;top: 0; right: 0;margin:
                    0;border: solid transparent;opacity: 0;filter:alpha(opacity=0);
                cursor: pointer;}
    .progress { position:relative; margin-left:5px;  width:200px;padding: 1px;  border-radius:3px; display:none;margin-top: 5px;}
    .bar {background-color: green; display:block; width:0%;
          height:20px;  }
    .percent { position:absolute; height:20px; display:inline-block;
               top:3px; left:2%; color:#fff }
    .files{height:22px; line-height:22px; margin-top:5px;}
    .delimg{margin-left:20px; color:#090; cursor:pointer}
</style>