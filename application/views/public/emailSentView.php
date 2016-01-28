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
                deleteConFirm('<?=$this->config->item('base_url')?>index.php/public/EmailController/getEmailDelte/'+str)
                return false;
            }else{
                alert('请最少选择一封邮件!');
                return false;
            }
        })
    })

    
    function deleteConFirm(tbl){
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
                    <td class="to_td" colspan="2" height="20" style="font-weight:bold"><a href="<?php echo site_url("/public/EmailController/emailSentView");?>" style="text-decoration:none; padding-left:20px"><img src="<?php echo $base_url;?>img/mail_sentbox.gif" border="0" />&nbsp;
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
            <table width="100%" height="100%" >

                <tr valign="top" align="center">
                    <td height="30px">
                        <table width="98%" height="100%" cellpadding="0" cellspacing="0">
                            <tr valign="middle">
                                <td style="text-align:left;"><img style="padding-left:10px" src="<?php echo $base_url;?>img/mail_sentbox.gif" width="20px" height="20px"/>&nbsp;
                                    <font color="#003366" style="font-size:16px"><b>已发送</b></font>&nbsp;<span style="color:red;">(收件人姓名绿色为收件人已读，黑色为未读)</span></td>
                        </table>
                    </td>
                </tr>

                <tr valign="top" align="center">
                    <td height="30px">
                        <table width="98%" height="100%" cellpadding="0" cellspacing="0">
                            <tr valign="middle">
                                <td align="left">
                                    <form method="post" action="" id="sSearch" name="sSearch">
                                        搜索：
                                        <select name="searchType" id="searchType" style="width:100px;">
                                            <option value="1" <?php if($searchType == 1):?> selected="selected"<?php endif;?>>主题</option>
                                            <option value="2" <?php if($searchType == 2):?> selected="selected"<?php endif;?>>收件人</option>
                                            <option value="3" <?php if($searchType == 3):?> selected="selected"<?php endif;?>>时间</option>
                                            <option value="4" <?php if($searchType == 4):?> selected="selected"<?php endif;?>>内容</option>
                                        </select>
                                        <span id="time">
                                            <input type="text" name="searchSdate" id="searchSdate"  value="<?php if(!empty($searchSdate)) echo $searchSdate;?>" style="width:100px;"  onClick="WdatePicker()">
                                            &nbsp;至&nbsp;
                                            <input type="text" name="searchEdate" id="searchEdate"  value="<?php if(!empty($searchEdate)) echo $searchEdate;?>" style="width:100px;"  onClick="WdatePicker()">
                                        </span>
                                        &nbsp;<input type="text" name="searchTitle" id="searchTitle" value="<?php if(!empty($searchTitle)):?><?php echo $searchTitle;?><?php endif;?>" size="20" />&nbsp;&nbsp;
                                        <input class="btn btn-gebo" type='submit'value="查  询" name="submitSearch" id="submitSearch">
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr valign="top" align="center">
                    <td colspan="2">
                        <div class=spaceborder style="WIDTH: 98%; BORDER-BOTTOM: medium none;margin-top: -15px;">
                            <TABLE cellSpacing=0 cellPadding=4 width="100%">
                                <TBODY>
                                    <TR class=mail_title>
                                        <TD align="center" width="5%">选择</TD>
                                        <TD align="left" width="5%"><img title="是否有附件" src="<?php echo $base_url;?>img/attachment.gif" border="0" align="absmiddle"></TD>
                                        <TD align="left" width="15%">收件人</TD>
                                        <TD align="left" width="25%">主题</TD>
                                        <TD align="left" width="20%">附件</TD>
                                        <TD align="left" width="5%">附件大小</TD>
                                        <TD align="center" width="20%">时间</TD>
                                    </TR>
                                    <?php if(!empty($arr)):?>
                                    <?php foreach($arr as $key=>$value):?>
                                    <TR onMouseOver="this.style.backgroundColor='#EFF7FF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="border-bottom:1px solid #d9e2e7;" >
                                        <TD align="center" width="5%"><input type="checkbox" id="id_list" name="id_list[]" class="id_list" value="<?php echo $value['id'];?>"></TD>
                                        <td width="5%" align="left">
                                            <?php if($value['include'] == 0):?>
                                            <?php else:?>
                                            <img border="0" align="absmiddle" src="<?php echo $base_url;?>img/attachment.gif" title="有附件">
                                            <?php endif;?>
                                        </td>
                                        <TD align="left" width="15%">
                                            <?php $number = count($value['CHILD']);?>
                                            <?php if($number > 1):?>
                                                <?php foreach($value['CHILD'] as $key=> $val):?>
                                                    <?php if($key < 2):?>
                                                        <?php if($val['state'] == 1):?>
                                                            <font color="#009900"><?php echo $userArray[$val['uId']].';';?></font>
                                                        <?php else:?>
                                                            <?php echo $userArray[$val['uId']].';';?>
                                                        <?php endif;?>
                                                   <?php endif;?>
                                                <?php endforeach;?>...
                                            <?php else:?>
                                                <?php foreach($value['CHILD'] as $val):?>
                                                        <?php if($val['state'] == 1):?>
                                                                <font color="#009900"><?php echo $userArray[$val['uId']].';';?></font>
                                                        <?php else:?>
                                                            <?php echo $userArray[$val['uId']].';';?>
                                                        <?php endif;?>
                                                <?php endforeach;?>
                                            <?endif;?>
                                            
                                        </TD>
                                        <TD align="left" width="25%"><a href="<?php echo site_url("/public/EmailController/emailDetailView/".$value['id']) ?>" ><?php echo $value['title'];?></a></TD>
                                        <TD align="left" width="20%">
                                           <?php if($value['include']!='0') { ?>
                                            <a href="<?php echo site_url("/public/FileController/emailLoad/".$value['include']."/".$value['id']) ?>">
                                                <img title="有附件" src="<?php echo $base_url;?>img/attachment.gif" border="0" align="absmiddle">
                                                <?php echo $value['origName'];?> &darr;
                                            </a>
                                           <?php }?>
                                        </TD>
                                        <TD align="center" width="8%"><?php if(!empty($value['include'])):?><?php echo $value['fileSize'].'<b>k</b>';?><?php endif;?></TD>
                                        <td align="center"><?php echo date("Y-m-d H:i:s",$value['post_date']);?></td>
                                    </TR>
                                    <?php endforeach;?>
                                    <?php else:?>
                                    <tr style="background-color: rgb(255, 255, 255);">
                                        <td colspan="7" align="center">您查看的记录为空</td>
                                    </tr>
                                    <?php endif;?>
                                    <!--
                                    -->
                                </TBODY>
                            </TABLE>
                        </div>

                        <div class="spaceborder spacebottom" style="width: 98%; border-top: none;text-align: left;">
                            <TABLE cellspacing="0" cellpadding="4" width="100%">
                                <TBODY>
                                    <TR>
                                        <TD><a href="javascript:void(0);" id="all_select">全选</a>&nbsp;&nbsp;<a href="javascript:void(0);" id="all_cancel">取消</a>&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0);" class="all_check" id="all_trash"><img width="16px" height="16px" src="<?php echo $base_url;?>img/delete.png" border="0" align="absmiddle"> &nbsp;<font color="#000"><b>删除</b></font></a>
                                            &nbsp;&nbsp;&nbsp;
                                        </TD>
                                    </TR>
                                </TBODY>
                            </TABLE>
                        </div>
                        <div class="spaceborder spacebottom" style="width: 98%; border-top: none; margin-bottom: 4px;">
                            <TABLE cellspacing="0" cellpadding="4" width="100%">
                                <TBODY>
                                    <TR>
                                        <TD>
                                            <div class="pageclass">
                                                <?php echo $pagination; ?><span style="float:right;width: 100px;">
                                                <img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
                                            </div>
                                        </TD>
                                    </TR>
                                </TBODY>
                            </TABLE>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </table>
</div>
