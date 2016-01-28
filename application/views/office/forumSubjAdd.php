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
                                <td style="text-align:left;"><img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;<strong>新增主题</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td>
                        <form action="<?php echo site_url('/office/ForumController/forumSubjAdd');?>" method="post" enctype="multipart/form-data" id="mainform" onsubmit="if(!passSet())return false;" name="mainform" class="form_validation_ttip" novalidate="novalidate" >
                            <table width="98%" height="100%" border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=0 style="margin-left:8px;">

                                <tr valign="middle">
                                    <td width="10%" style="text-align: right;"><b>主题名称：</b></td>
                                    <td style="padding-left:5px;">
                                        <select name="pid" class="span2">
                                            <option  value="选择主题类别">选择主题类别</option>
                                            <?php

                                            foreach($forumClass as $key=>$val) {
                                                if($key == 1) {
                                                    echo '<option value="'.$key.'" selected>'.$val['className'].'</option>';
                                                }else {
                                                    echo '<option value="'.$key.'">'.$val['className'].'</option>';
                                                }
                                            }

                                            ?>
                                        </select>

                                        <input type="text" name="className" id="className" class="span2" value="" />&nbsp;&nbsp;
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
                                    <?php foreach($arr as $value):?>

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
