<script language="javascript" type="text/javascript" src="<?php echo $base_url;;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    function chktextnum(num,obj){
        var sum=0,values;
        str=obj.value;
        for(i=0;i<str.length;i++){
            values=str.substr(0,i);
            if ((str.charCodeAt(i)>=0) && (str.charCodeAt(i)<=255)){
                sum=sum+1;
            }else{
                sum=sum+2;
            }
            if(sum>num){obj.value=values;break;}
        }
    }

</script>
<body>
        <br />
        <DIV class=spaceborder style="WIDTH: 98%;" align="left">
            <table cellpadding="4" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td colspan="2" align="center" class="altbg1" style="line-height:20px; border-bottom:0px; font-size:16px; color:#036;BACKGROUND: #eff7ff;"><span class="bold"><?php echo $title;?></span></td>
                    </tr>

                    <tr>
                        <td class="altbg1" align="right" style="color:#036;BACKGROUND: #eff7ff;" colspan="2">
                            <?php echo $info[$operator];?>&nbsp;&nbsp;&nbsp;&nbsp;发布于： <em><?php echo date('Y-m-d',$createTime);?></em>&nbsp;&nbsp;&nbsp;&nbsp;点击<?php echo $count;?>次&nbsp;&nbsp;&nbsp;&nbsp;审批人：<?php echo $info[$approve];;?></td>
                    </tr>


                    <tr>
                        <td colspan="2" align="left" style=" padding-top:10px; overflow: hidden;"><?php echo $content;;?></td>
                    </tr>

                    <?php if($annex!='0') { ;?>
                    <tr>
                        <td colspan="2" align="left" style=" padding-top:10px;">
                            <a href="<?php echo  site_url("public/FileController/downloadApp/".$annex) ;?>">
                                <img title="有附件" src="<?php echo $base_url;;?>img/attachment.gif" border="0" align="absmiddle">
                                    <?php echo $origName;?> &darr;
                            </a>
                        </td>
                    </tr>
                    <?php };?>

                </tbody>
            </table>
        </DIV>

    