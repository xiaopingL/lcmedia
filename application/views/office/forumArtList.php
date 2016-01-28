<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
    $(function(){
        $(".to_td").mouseover(function(){
            $(this).attr('bgcolor','#D6DBE9')
        })
        $(".to_td").mouseout(function(){
            $(this).attr('bgcolor','')
        })
    })

    $(function(){
        $(".mail_bg").mouseover(function(){
            $(this).attr('background','<?php echo $base_url;?>img/mail_bg2.gif')
        })

        $(".mail_bg").mouseout(function(){
            $(this).attr('background','<?php echo $base_url;?>img/mail_bg1.gif')
        })
    })

    $(function(){
        $("#all_select").click(function(){
            $(".id_list").attr('checked',true);
        })

        $("#all_cancel").click(function(){
            $(".id_list").attr('checked',false);
        })
    })

    $(function(){
        $("#all_trash").click(function(){
            var info	= '0';
            var	str	= '';

            $(".id_list").each(function(){
                if($(this).attr('checked')=='checked')
                {
                    info	= '1'
                    str += $(this).val()+'-';
                }
            })
            if(info == '1')
            {
                oprConFirm('<?=$this->config->item('base_url')?>index.php/office/ForumArtController/forumArtDelete/'+str+'/'+'<?php echo $cid;?>')
                return false;
            }else{
                alert('请最少选择一篇帖子!');
                return false;
            }
        })
    })

    $(function(){
        $("#all_top").click(function(){
            var info	= '0';
            var	str	= '';

            $(".id_list").each(function(){
                if($(this).attr('checked')=='checked')
                {
                    info	= '1'
                    str += $(this).val()+'-';
                }
            })
            if(info == '1')
            {
                oprConFirm('<?=$this->config->item('base_url')?>index.php/office/ForumArtController/forumArtSetPro/1/'+str+'/'+'<?php echo $cid;?>')
                return false;
            }else{
                alert('请最少选择一篇帖子版内置顶!');
                return false;
            }
        })
    })
    $(function(){
        $("#qj_all_top").click(function(){
            var info	= '0';
            var	str	= '';

            $(".id_list").each(function(){
                if($(this).attr('checked')=='checked')
                {
                    info	= '1'
                    str += $(this).val()+'-';
                }
            })
            if(info == '1')
            {
                oprConFirm('<?=$this->config->item('base_url')?>index.php/office/ForumArtController/forumArtSetPro/3/'+str+'/'+'<?php echo $cid;?>')
                return false;
            }else{
                alert('请最少选择一篇帖子设置全局置顶!');
                return false;
            }
        })
    })
    $(function(){
        $("#esc_top").click(function(){
            var info	= '0';
            var	str	= '';

            $(".id_list").each(function(){
                if($(this).attr('checked')=='checked')
                {
                    info	= '1'
                    str += $(this).val()+'-';
                }
            })
            if(info == '1')
            {
                oprConFirm('<?=$this->config->item('base_url')?>index.php/office/ForumArtController/forumArtSetPro/0/'+str+'/'+'<?php echo $cid;?>')
                return false;
            }else{
                alert('请最少选择一篇帖子取消置顶!');
                return false;
            }
        })
    })
    $(function(){
        $("#all_jh").click(function(){
            var info	= '0';
            var	str	= '';

            $(".id_list").each(function(){
                if($(this).attr('checked')=='checked')
                {
                    info	= '1'
                    str += $(this).val()+'-';
                }
            })
            if(info == '1')
            {
                oprConFirm('<?=$this->config->item('base_url')?>index.php/office/ForumArtController/forumArtSetPro/2/'+str+'/'+'<?php echo $cid;?>')
                return false;
            }else{
                alert('请最少选择一篇帖子设为精华!');
                return false;
            }
        })
    })


    function oprConFirm(tbl){
        //alert(tbl);return false;
        if(window.confirm("您确认进行此操作吗？")){
            window.location = tbl;
        }

    }

    $(function(){
        if($("#searchType").val()!=3)
        {
            $("#time").css('display','none');
            $("#searchTitle").css('display','');
        }else{
            $("#time").css('display','');
            $("#searchTitle").css('display','none');
        }

        $("#searchType").change(function(){
            if($("#searchType").val()!=3)
            {
                $("#time").css('display','none');
                $("#searchTitle").css('display','');
            }else{
                $("#time").css('display','');
                $("#searchTitle").css('display','none');
            }
        })
    })
</script>
<!--<script type="text/javascript">

    function passSet(){
        if(document.getElementById("title").value != ''){

            return true;

        }else{
            alert("搜索不能为空！");
            document.getElementById("title").focus();
            return false;
        }
    }
</script>-->
<script language="javascript">
    //实例化ajax
    function xml(){
        var xmlhttp
        if(window.ActiveXObject){
            xmlHttp= new ActiveXObject('Microsoft.XMLHTTP');
        }else if(window.XMLHttpRequest){
            xmlHttp= new XMLHttpRequest();
        }
    }
    function ajaxWqk(){
        var value = document.getElementById('select').value;
        xml();
        if(value!=""){
            ran=Math.ceil(Math.random()*10000);
            url="<?php echo site_url('/office/ForumController/forumSubClass');?>"+"/ran/"+ran;
            //document.write(url);
            xmlHttp.open("GET",url,true);
            xmlHttp.onreadystatechange=jsWqk;
            document.getElementById('select').innerHTML='正在加载...';
            xmlHttp.send(null);
        }

    }

    function jsWqk(){
        //alert(xmlHttp.readyState);
        if(xmlHttp.readyState == 4){

            if(xmlHttp.status == 200){
                document.getElementById('select').innerHTML=xmlHttp.responseText;
            }
        }
    }
    window.onload=function(){
        ajaxWqk();
    }
    $(function(){
        if($("#department").val()!=3)
        {
            $("#time").css('display','none');
            $("#title").css('display','');
        }else{
            $("#time").css('display','');
            $("#title").css('display','none');
        }
        $("#department").change(function(){
            if($("#department").val()!=3)
            {
                $("#time").css('display','none');
                $("#title").css('display','');
            }else{
                $("#time").css('display','');
                $("#title").css('display','none');
            }
        })
        
    })
</script>
<table style="margin-bottom:0px;">
    <tr valign="top" align="center">
        <td height="30px" width="20%">
            <table width="98%" height="100%" cellpadding="0" cellspacing="0">
                <tr valign="middle">
                    <td height="30px" style="padding-left:0px;"  align="left" colspan="2">版块导航：&nbsp;
                    <?php  foreach($forumClass as $key=>$val){
                       echo "<a href=\"".site_url('/office/ForumArtController/forumArtList')."/?cid={$key}\" title=\"{$val[className]}\">{$val[className]}</a>&nbsp;|&nbsp;";
                    }?>
                    </td>
                </tr>
                <tr valign="middle">
                    <td height="30px" align="left" style="padding-left:0px">
                       <img style="padding-left:0px" src="<?php echo $base_url;?>img/forum_tl.png" width="20px" height="20px"/>&nbsp;
                       <font style=" font-size:14px"><b><a href="<?php echo site_url('/office/ForumController/classList');?>">讨论区</a> -><a href="<?php echo site_url('/office/ForumArtController/forumArtList/?cid='.$cid);?>"><?php echo $forumClass[$cid]['className'];?></a></b></font>
                    </td>
                    <td width="15%" align="left"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr valign="middle" align="center">
        <td height="30px">
            <table width="98%" height="100%" cellpadding="0" cellspacing="0">
               <thead>
                   <form onsubmit="if(!passSet())return false;" method="post" action="">
                <tr valign="middle" style="float: left;margin-bottom: 8px;">
                    <th>
                        搜索:&nbsp;&nbsp;
                        <select name="department" id="department" style="width:100px;">
                                <option value="1" <?php if($inptype == 1):?>selected<?php endif;?>>标题</option>
                                <option value="2" <?php if($inptype == 2):?>selected<?php endif;?>>作者</option>
                                <?php if($this->session->userdata('sId') == 14):?>
                                <option value="3" <?php if($inptype == 3):?>selected<?php endif;?>>时间段</option>
                                <?php endif;?>
                         </select>
                    <th>
                    <th>&nbsp;&nbsp;<input type="text" name="title" id="title" class="input-medium span2" value="<?php if(!empty($title1)) echo $title1;?>" ></th>
                    <th id="time">
                        <input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:100px;"  onClick="WdatePicker()"> 到
                        <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:100px;"  onClick="WdatePicker()">
                    </th>
                    <th>&nbsp;&nbsp;<button type="submit" class="btn btn-success">搜索</button></th>
                    <th>&nbsp;&nbsp;<button class="btn btn-success" type="button" onclick="window.location.href='<?php echo site_url('/office/ForumArtController/forumArtAdd/'.$cid);?>'">发表新帖</button></th>
                </tr>
                </form>
                </thead>
                
            </table>
        </td>
    </tr>
</table>
<div class="well well_classmar">
    <span style="float:left; margin-left:4px; display:none">该类别共有<font color=red><b><?php echo $rows; ?></b></font>条帖子</span>
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <?php if($isBanZhu) {?><th width="8%">选择</th><?php }?>
                <th width="35%">标题</th>
                <th width="20%">作者[部门]</th>
                <th width="7%">回/阅</th>
                <th width="12%">最新回复</th>
                <th width="12%">最新回复时间</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty ($arr)):?>
            <tr><td colspan="<?php if($isBanZhu) {
        echo 6;
    }else {
        echo 5;
    }?>" style="color:red;">没有查找到相关信息</td></tr>
<?php else:?>
    <?php foreach($arr as $value):?>
            <tr>
        <?php if($isBanZhu) {?><td><input type="checkbox" id="id_list" name="id_list[]" class="id_list" value="<?php echo $value['id'];?>"></td><?php }?>
                <td  style="line-height:30px"><a href="<?php echo site_url("office/ForumArtController/artDet/".$value['id']);?>" target="_blank"><?php if($value[type]) {
            if($value['type']==2) {
                echo '<b style="color:#FF6600; font-size:13px">';
            }elseif($value['type']==3) {
                echo '<b style="color:#FF0000; font-size:13px">';
            }elseif($value['type']==1) {
                echo '<b style="color:#009933; font-size:13px">';
            } echo
            $value['title']; ?></b><?php }else {
            echo $value['title'];
        }?></a><?php if(time()-$value['post_date']<864000 && $value['isClick']!=1) {?> <img src="<?php echo $base_url;?>img/new1.gif" border="0" align="absmiddle"> <?php } if
        ($value['type']==2) {
            echo '&nbsp;&nbsp;<b style="color:#FF0000; font-size:13px">精华</b>';
        }?></td>
                <td><?php echo $value['real_name'];?><font style="color:#009900"><?php if(!empty($value['orgName'])) {?>[<?php echo $value['orgName'].']';
        }?></font>&nbsp;<?php echo date('m-d H:i',$value['post_date']); ?></td>

                <td><?php echo $value['comments_num'],'&nbsp;/&nbsp;',$value['click_num'];?></td>
                <td><?php if(!empty($value['lastReser'])) {
            echo $value['lastReser'];
        }?></td>
                <?php if($value['post_date'] == $value['lastTime']):?>
                <td></td>
                <?php else:?>
                <td><?php if(!empty($value['lastTime'])) {echo date('Y-m-d H:i',$value['lastTime']);}?></td>
                <?php endif;?>
            </tr>
            <?php endforeach;?>
<?php endif;?>
<?php if($isBanZhu) {?><TR>
                <TD colspan="<?php if($isBanZhu) {
        echo 6;
    }else {
        echo 5;
    }?>"><a href="javascript:void(0);" id="all_select">全选</a>&nbsp;&nbsp;<a href="javascript:void(0);" id="all_cancel">取消</a>&nbsp;&nbsp;&nbsp;

                    <a id="all_top" class="all_check" href="javascript:void(0);">
                        <img border="0" src="<?php echo $base_url;?>img/urgent_00.gif">
                        <font color="#009933">
                            <b>版内置顶</b>
                        </font>
                    </a>
                    <a id="qj_all_top" class="all_check" href="javascript:void(0);">
                        <img border="0" src="<?php echo $base_url;?>img/urgent_0.gif">
                        <font color="#FF0000"><b>全局置顶</b>
                        </font>
                    </a>
                    <a id="esc_top" class="all_check" href="javascript:void(0);">
                        <img border="0" src="<?php echo $base_url;?>img/zd_c.gif">
                        <font color="#000"><b>取消置顶</b>
                        </font>
                    </a>
                    <a id="all_jh" class="all_check" href="javascript:void(0);">
                        <img width="12" height="13" border="0" style="margin-top:3px;" src="<?php echo $base_url;?>img/cpanellogo_png.png">
                        <font color="#000"><b>精华帖</b>
                        </font>
                    </a>&nbsp;&nbsp;&nbsp;
                    <a id="all_trash" class="all_check" href="javascript:void(0);">
                        <img border="0" style="margin-top:3px;" src="<?php echo $base_url;?>img/zd_s.gif">
                        <font color="#000"><b>删除</b>
                        </font>
                    </a></TD>
            </TR><?php }?>
        </tbody>
    </table>

    <div class="pageclass">
<?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>


