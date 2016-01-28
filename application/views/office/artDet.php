<style type="text/css">


    .forum_lou{
        background-color:#FFFFCA;
        border:1px #CCC solid;
        padding-left:3px;
        padding-right:4px;
    }
    .forum_edit{
        color:#FFF;
        font-weight:bold;
        background-color:#4797E8;
        border:1px #fff solid;
        padding-left:5px;
        padding-right:5px;
        padding-bottom:2px;
        padding-top:2px;
    }
    .forum_normal{
        border:1px #fff solid;
        padding-left:5px;
        padding-right:5px;
        padding-bottom:2px;
        padding-top:2px;
    }

    .content{ background-color: #fff;border: 1px solid #E3E3E3;border-radius: 4px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
              margin-bottom: 10px;min-height: 20px;padding: 19px;}

    .pan-nav{ background:#EBF2F6;}

</style>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/kindeditor.js"></script>
<table cellSpacing=0 cellPadding=4 width="100%">
    <tr valign="top">
        <td>
            <table width="100%" height="100%" cellpadding="0" cellspacing="0">
                <tr valign="middle">
                    <td height="40px" style="padding-left:10px"  align="left" colspan="2" class="pan-nav">版块导航：&nbsp;
                        <?php foreach($forumClass as $key=>$val) {
                            echo "<a href=\"".site_url('/office/ForumArtController/forumArtList')."?cid={$key}\" title=\"{$val}\">{$val[className]}</a>&nbsp;|&nbsp;";
                        }?>
                    </td>
                </tr>

                <tr valign="middle">
                    <td height="45px" align="left"><img style="padding-left:10px" src="<?php echo $base_url;?>img/forum_tl.png" width="20px" height="20px"/>&nbsp;
                        <font style=" font-size:14px"><b><a href="<?php echo site_url('/office/ForumController/classList');?>">讨论区</a> -><a href="<?php echo site_url('/office/ForumArtController/forumArtList');?>/?cid=<?php echo $arr['aid'];?>"><?php echo $forumClass[$arr['aid']]['className'];?></a> -> <?php echo $arr['title'];?></b></font></td>
                    <td width="15%" align="left"></td>
                </tr>
                <tr>
                    <td height="26px" align="left" class="altbg1" valign="top" style="color:#036; padding-left:15px;">
                        <span class="forum_lou">楼主#</span>
                        昵称：
                        <?php echo $arr['real_name'];?>[<?php if(!empty($depa)) {
                            echo $depa;
                        }else {
                            echo '暂无';
                        }?>]
                        &nbsp;&nbsp;&nbsp;&nbsp;发布于： <em><?php echo date('Y-m-d H:i',$arr['post_date']);?></em>&nbsp;&nbsp;&nbsp;&nbsp;点击<?php echo $arr['click_num'];?>次</td>
                    <td width="20%" align="left" class="altbg1" style="color:#036"><?php if($arr['real_name'] == $userName) {?><a href="<?php echo site_url('/office/ForumArtController/forumArtMod').'/'.$arr[id];?>"><span class="forum_edit">编辑</span></a>
                        &nbsp;<?php }?></td>
                </tr>

                <tr valign="top" align="center">
                    <td colspan="2" width="100%">
                        <DIV align="left" class="content">
                            <table cellpadding="4" cellspacing="0" width="100%" >
                                <tbody>

                                    <tr>
                                        <td colspan="2" align="center" class="altbg1" style="line-height:20px; border-bottom:0px; font-size:16px; color:#036"><span class="bold"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left" style=" padding-top:20px; padding-left:20px; padding-bottom:20px; padding-right:20px;">
                                            <?php echo $arr['content'];?>

                                        </td>
                                    </tr>



                                </tbody>
                            </table>
                        </DIV>

                        <DIV >
                            <form action="<?php echo site_url('/office/ForumArtController/forumComAdd').'/'.$arr[id].'/'.$arr['aid'];?>" method="post" id="mainform" name="mainform" >

                                <table cellpadding="4" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" align="left" class="altbg1" style="line-height:40px; border-bottom:0px; color:#036"><span class="bold">发表评论:</span>&nbsp;&nbsp;<span style="font-size:12px; color:#F00">[昵称：<?php echo $userName; ?>]</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2" align="center">
                                                <textarea id="myEditor" name="content" style="width:100%;height:200px;">
                                                </textarea>
                                                <script type="text/javascript">
                                                    KindEditor.ready(function(K) {
                                                        window.editor = K.create('#myEditor');
                                                    });
                                                    KindEditor.options.filterMode = false;
                                                </script>
                                                <input type="hidden" id="aid" name="aid" value="<?php echo $arr['aid'];?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <INPUT class="btn btn-gebo" type='submit'value="提&nbsp;&nbsp;交" name="submitCom">&nbsp;&nbsp;&nbsp;&nbsp;

                                                <input type="button" class="btn" value="返&nbsp;&nbsp;回" onClick="javascript:history.go(-1)" />		</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </DIV>

                        <br>
                        <DIV style="text-align:justify;" >
                            <?php $counts= count($comments);?>
                            <div style="line-height:40px; border-bottom:0px; color:#036; "><span class="bold">最新评论 (<font style="color:#FF0000"><?php echo $counts;?></font>)</span></div>
                            <?php ;
                            for($i=0;$i<$counts;$i++) {?>
                            <table cellpadding="4" cellspacing="0" width="100%" class="content">
                                <tbody>
                                    <TR style="color:#036; background-color:#F3F3F3;overflow:hidden">
                                        <TD align="left" width="50" style="line-height:10px; border-bottom:0px;padding-top:10px;">
                                            <span class="forum_lou"><?php echo $i+1;?>楼#</span>
                                        </TD>
                                        <TD align="left" width="15%" style="line-height:10px; border-bottom:0px;padding-top:10px;"><?php echo $comments[$i][staff_name];?></TD>
                                        <TD align="left" style="border-bottom:0px;padding-top:10px;">发表于 <?php echo date('Y-m-d H:i',$comments[$i]['post_date']);?>                         </TD>
                                        <TD align="right" style="border-bottom:0px;padding-top:10px;"><?php if($comments[$i][staff_name] == $userName) {?>
                                            <img src="<?php echo $base_url;?>img/edit.png" style="display:none"/>
                                            <a href="#<?php echo $comments[$i]['id'];?>" style="display:none">编辑</a>
                                            &nbsp;&nbsp;
                                            <img src="<?php echo $base_url;?>img/delete.png"/>
                                            <a href="<?php echo site_url('/office/ForumArtController/forumCommDel/'.$comments[$i]['id'].'/'.$arr[id]);?>">删除</a>
                                                    <?php }?>                 </TD>
                                    </TR>
                                    <TR>
                                        <TD colspan="4" align="left" style="border-top:0px; overflow:hidden">
                                            <table style="border-collapse: separate;table-layout:fixed;" class="row2">
                                                <tbody>
                                                    <tr>
                                                        <td style="border:0px;">
                                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $comments[$i][content];?></p>                                     	</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </TD>
                                    </TR>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </DIV>
                        <br>
                        <DIV align="left" class="well well_classmar">
                            <form action="" method="post" id="mainform" name="mainform">
                                <table cellpadding="4" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" align="left" class="altbg1" style="line-height:20px; border-bottom:0px; color:#036"><span class="bold">谁看过此帖:</span><?php echo $arr['click_name'];?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </DIV>
                        <br>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</DIV>