<div class=spaceborder style="WIDTH:100%;">
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
                    <td class="to_td" colspan="2" height="20" style="font-weight:bold"><a href="<?php echo site_url("/public/EmailController/emailListView");?>" style="text-decoration:none; padding-left:20px"><img src="<?php echo $base_url;?>img/mail_inbox.gif" border="0" />&nbsp;
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
                                <td style="text-align:left;">
                                    <img src="<?php echo $base_url;?>img/mail_xx.png" border="0" />&nbsp;<font style="font-size:16px"><b>邮件分组</b></font>
                                    <a href="<?php echo site_url("/public/EmailController/emailGroupAdd");?>">添加分组</a>
                                </td>
                        </table>
                    </td>
                </tr>
                <tr valign="top" align="center">
                    <td colspan="2">
                        <div class=spaceborder style="WIDTH: 98%; BORDER-BOTTOM: medium none">
                            <TABLE cellSpacing=0 cellPadding=4 width="100%">
                                <TBODY>
                                    <TR class=mail_title>
                                        <TD align="center" width="18%">分组名称</TD>
                                        <TD align="left" width="72%">成员</TD>
                                        <TD align="center" width="8%">操作</TD>
                                    </TR>
                                    <?php if(!empty($arr)):?>
                                    <?php foreach($arr as $key=>$value):?>
                                    <TR onMouseOver="this.style.backgroundColor='#EFF7FF'" onMouseOut="this.style.backgroundColor='#FFFFFF'" style="border-bottom:1px solid #d9e2e7;" >
                                        <td align="center"><?php echo $value['grouptitle'];?></td>
                                        <td align="left"><?php echo mb_substr($value['groupcontent'],0,99,'utf-8');?></td>
                                        <td align="center">
                                            <a href="<?php echo site_url('/public/EmailController/emailGroupEdit/'.$value['group_id']); ?>" class="sepV_a" title="编辑">编辑</a>
                                            <a href="javascript:deleteConFirm('<?php echo site_url('/public/EmailController/emailGroupDel/'.$value['group_id']); ?>')" class="sepV_a" title="删除">删除</a>
                                        </td>
                                    </TR>
                                    <?php endforeach;?>
                                    <?php else:?>
                                    <tr style="background-color: rgb(255, 255, 255);">
                                        <td colspan="3" align="center">您查看的记录为空</td>
                                    </tr>
                                    <?php endif;?>
                                    <!--
                                    -->
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
