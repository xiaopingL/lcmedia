<!--<script type="text/javascript" src="<?php echo $base_url;?>js/fckeditor/fckeditor.js"></script>-->
<style type="text/css">
img.photoImg{
   width:60px; height:60px;
}
</style>
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
                <tr>
                    <td>
                        <form action="<?php echo site_url('/public/EmailController/emailInsert');?>" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate" onSubmit="return checkInfo();">
                        <table width="98%" height="100%" border="1" bordercolor="#bdebff" cellSpacing=0 cellPadding=0 style="margin-left:8px;">
                            <tr valign="middle">
                               <td width="10%" style="text-align: right;"><b>邮件主题：</b></td>
                               <td width="90%" height="35px;" style="padding-left:5px;">
                                   <?php echo $arr['title'];?>
                               </td>
                           </tr>
                           <tr valign="middle">
                               <td width="10%" style="text-align: right;"><b>时间：</b></td>
                               <td width="90%" height="35px;" style="padding-left:5px;">
                                   <?php echo date("Y-m-d H:i:s",$arr['post_date']);?>
                               </td>
                           </tr>
                           <tr valign="middle">
                               <td width="10%" style="text-align: right;"><b>发件人：</b></td>
                               <td width="90%" height="35px;" style="padding-left:5px;">
                                   <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                     <tr>
                                       <td width="60px" align="left"><img class="photoImg" src="<?php if(empty($arr['photoImg'])){ ?><?php echo $base_url;?>img/nopic2.jpg<?php }else{echo $arr['photoImg'];} ?>" /></td>
                                       <td align="left"><?php echo $userArray[$arr['from_uid']];?> </td>
                                     </tr>
                                   </table>
                               </td>
                           </tr>
                           <tr valign="middle">
                                <td width="10%" style="text-align: right;"><b>收件人：</b></td>
                                <td width="90%" height="35px" style="padding-left:5px;">
                                    <div class="input">
                                        <?php foreach($arr['CHILD'] as $val):?>
                                                    <?php if($val['state'] == 1):?>
                                                        <?php if($eNumber == 1):?>
                                                        <?php if($arr['to_uid'] == $val['uId']):?>
                                                        <font color="#009900"><?php echo $userArray[$val['uId']].';';?></font>
                                                        <?php endif;?>
                                                        <?php else:?>
                                                        <font color="#009900"><?php echo $userArray[$val['uId']].';';?></font>
                                                        <?php endif;?>
                                                    <?php else:?>
                                                        <?php if($eNumber == 1):?>
                                                        <?php if($arr['to_uid'] == $val['uId']):?>
                                                        <?php echo $userArray[$val['uId']].';';?>
                                                        <?php endif;?>
                                                        <?php else:?>
                                                        <?php echo $userArray[$val['uId']].';';?>
                                                        <?php endif;?>
                                                    <?php endif;?>
                                        <?php endforeach;?>
                                    </div>
                                </td>
                           </tr>
                           <!--."/".$arr['id']-->
                           <?php if(!empty($arr['include'])):?>
                           <tr valign="middle">
                               <td width="10%" style="text-align: right;"><b>附件：</b></td>
                               <td height="35px;" style="padding-left:5px;">
                                  <a href="<?php echo site_url("/public/FileController/emailLoad/".$arr['include']) ?>">
                                     <img title="有附件" src="<?php echo $base_url;?>img/attachment.gif" border="0" align="absmiddle">
                                     <?php echo $arr['origName'];?> &darr;
                                  </a>
                               </td>
                           </tr>
                           <?php endif;?>
                           <tr valign="middle">
                               <td width="10%" style="text-align: right;"><b>邮件内容：</b></td>
                               <td width="90%" height="auto;">
                                    <div style="width:98%;font-size:12px; background-color:#FDF5DB;OVERFLOW-X: hidden; MARGIN-BOTTOM: 1px; OVERFLOW: scroll; HEIGHT: 450px;padding:8px;">
                                    <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                    <td align="left" valign="middle">
                                        <span style="width: 650px;max-width: 650px; height: auto;display: block;"><?php echo $arr['content'];?></span>
                                    </td>
                                    </tr>
                                    </table>
                                    </div>
                               </td>
                           </tr>
                           <tr>
                               <td colspan="10" style="text-align:center;" height="35px;">
                                    <button class="btn" type="reset" style="margin-right: 20px;width:80px;" onClick="window.location='<?php echo site_url("/public/EmailController/emailReplyView/".$arr['id']);?>'">
                                                                回复
                                    </button>
                                    <button type="reset" class="btn" style="margin-right: 20px;width:80px;" onClick="window.location='<?php echo site_url("/public/EmailController/emailTurnlistView/".$arr['id']);?>'">
                                                                转发
                                    </button>
                                   <button type="reset" class="btn" onClick="javascript:history.go(-1)" style="width:80px;">
                                                                返回
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-bottom:1px solid #FFF;height: 20px;"> 上一封: <?php
                                    if($result){
                                    if($result['status']==1){echo '[已阅]';}else{echo '<span style="color:red">[未阅]</span>'; }?> <a href="<?php echo site_url("/public/EmailController/emailDetailView/".$result['id'])?>"><?php echo $result['title'];?></a>  发件人:<?php echo $userArray[$result['from_uid']];?>
                                    <?php }else{
                                    echo '无';
                                    }?>
                                </td>
                           </tr>
                           <tr>
                               <td colspan="4" style="height: 20px;">下一封: <?php
                                    if($rows){
                                    if($rows['status']==1){echo '[已阅]';}else{echo '<span style="color:red">[未阅]</span>'; }?> <a href="<?php echo site_url("/public/EmailController/emailDetailView/".$rows['id'])?>"><?php echo $rows['title']?></a>  发件人:<?php echo $userArray[$rows['from_uid']];?>
                                    <?php }else{
                                        echo ' 无';
                                    }?>
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
