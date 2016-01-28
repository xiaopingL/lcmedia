<table class="table table-bordered table-striped" id="smpl_tbl">
    <tbody>
        <tr>
            <td width="10%" style="font-weight: bold;vertical-align: middle;text-align: center;">站点</td>
            <td width="30%" style="vertical-align: middle;"><?php echo $siteId[$client['siteId']];?></td>
            <td width="10%" style="font-weight: bold;vertical-align: middle;text-align: center;">影城名称</td>
            <td width="50%" style="vertical-align: middle;"><?php echo $client['name']?></td>
        </tr>
        <tr id="qtkh">
            <td colspan="4">
                <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                    <tr>
                        <td style="font-weight: bold;vertical-align: middle;text-align: center;width:15%">厅数</td>
                        <td style="vertical-align: middle;width:25%"><?php echo $client['room_num'];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;width:15%">座位数</td>
                        <td style="vertical-align: middle;">
                            <span id="projectSize_2"><?php echo $client['seat_num'];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">月均场次</td>
                        <td style="vertical-align: middle;"><?php echo $client['month_market_num'];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">月均人次</td>
                        <td style="vertical-align: middle;"><?php echo $client['month_person_num'];?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">刊例价(15秒)</td>
                        <td style="vertical-align: middle;"><?php echo $client['publish_price_fifteen'];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">刊例价(30秒)</td>
                        <td style="vertical-align: middle;"><?php echo $client['publish_price_thirty'];?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">影院代理情况</td>
                        <td style="vertical-align: middle;"><?php echo $client['situation'];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">所属院线</td>
                        <td style="vertical-align: middle;"><?php echo $client['chain'];?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">地址</td>
                        <td style="vertical-align: middle;" colspan="3"><?php echo $client['address'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<?php if(!empty($contact)) { ?>
<table  class="table table-bordered table-striped" id="smpl_tbl_1">
    <tr>
        <td colspan="7" style="color:red;font-weight: bold;font-size: 16px;vertical-align: middle;height: 35px;"><?php echo $client['name']?></td>
    </tr>
<tr>
    <td colspan="7"><strong>影城联系人</strong></td>
</tr>
<tr>
    <td colspan="7">
        <table id="tbl_info2" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
            <tr>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">姓名</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">职位</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">电话</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">性别</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">生日</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">籍贯</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;" width="25%">备注</td>
            </tr>
            
              <?php foreach($contact as $value) {?>
            <tr>
                <td style="vertical-align: middle;text-align: center;"><?php echo $value['telName']; ?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo $value['telPosition'];?></td>
                <td style="vertical-align: middle;text-align: center;">&nbsp;<?php echo $value['telNumber']; ?></td>
                <td style="vertical-align: middle;text-align: center;"><?php if($value['sex']==1){echo '男';}else{echo '女';}?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo $value['birthday'];?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo $value['nativePlace'];?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo $value['hobby'];?></td>
            </tr>
              <?php } ?>
        </table>
    </td>
</tr>
</table>
<?php } ?>