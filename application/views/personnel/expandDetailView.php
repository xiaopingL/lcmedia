<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">

</script>
<table class="table table-bordered table-striped" id="smpl_tbl">
    <tbody>
        <tr>
            <td colspan="6" style="font-size:24px;padding:10px;text-align:center;background:gray 10px center;font-weight:bold"><?php echo $userDetail[0]['userName']; ?>个人详细档案</td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">性别</span></td>
            <td width="35%">
                <?php if($sex==1) {
                    echo '男';
                }elseif($sex==2) {
                    echo '女';
                }; ?>
            </td>
            <td width="10%" style="text-align:center;"><span class="bold">出生年月</span></td>
            <td width="35%"><?php echo !empty($birthday)?date('Y-m-d',$birthday):''; ?></td>
            <td rowspan="4" colspan="2" width="110px" height="130px">
                <img src="<?php if(!empty($fileName)) {
                    echo $photoImg;
                }else {
                    echo $base_url.'img/nopic.gif';
                }?>" width="110px" height="130px" border="0" />
            </td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">身份证号码</span></td>
            <td width="35%"><?php echo $idcard; ?></td>
            <td width="10%" style="text-align:center;"><span class="bold">政治面貌</span></td>
            <td width="35%"><?php echo $politicalType[$political]; ?></td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">籍贯</span></td>
            <td width="35%"><?php echo $nativePlace; ?></td>
            <td width="10%" style="text-align:center;"><span class="bold">婚否</span></td>
            <td width="35%"><?php echo $marriageType[$isMarriage]; ?></td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">视力</span></td>
            <td width="35%"><?php echo $vision; ?></td>
            <td width="10%" style="text-align:center;"><span class="bold">血型</span></td>
            <td width="35%"><?php echo $bloodsType[$bloodType]; ?></td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">身高</span></td>
            <td width="35%"><?php echo !empty($height)?$height.'（厘米）':''; ?></td>
            <td width="10%" style="text-align:center;"><span class="bold">体重</span></td>
            <td width="35%"><?php echo !empty($weight)?$weight.'（公斤）':''; ?></td>
            <td colspan="2"></td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">毕业院校</span></td>
            <td width="35%"><?php echo $graduateFrom; ?></td>
            <td width="10%" style="text-align:center;"><span class="bold">专业</span></td>
            <td width="35%"><?php echo $professional; ?></td>
            <td colspan="2"></td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;"><span class="bold">毕业时间</span></td>
            <td width="35%"><?php echo !empty($graduateTime)?date('Y-m-d',$graduateTime):''; ?></td>
            <td width="10%" style="text-align:center;"><span class="bold">学历</span></td>
            <td width="35%"><?php echo $educationType[$education]; ?></td>
            <td colspan="2"></td>
        </tr>

        <tr>
            <td width="10%" style="text-align:center;vertical-align: middle;"><span class="bold">联系方式</span></td>
            <td width="90%" colspan="3">
                <table cellpadding="4" cellspacing="0" width="100%" class="table table-bordered table-striped table-condensed">
                    <tr>
                        <td><b>手机号码：</b><?php echo $phone; ?></td>
                        <td><b>身份证地址：</b><?php echo $cardAddr; ?></td>
                    </tr>
                    <tr>
                        <td><b>家庭住址：</b><?php echo $address; ?></td>
                        <td><b>当前居住地：</b><?php echo $currentAddress; ?></td>
                    </tr>
                </table>
            </td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-striped">
    <tbody>
        <tr><td style="text-align:center;"><button type="button" class="btn" onClick="javascript:history.go(-1)">我要返回</button></td></tr>
    </tbody>
</table>