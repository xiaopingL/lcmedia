<table class="table table-bordered table-striped" id="smpl_tbl">
    <tbody>
        <tr>
            <td width="10%" style="font-weight: bold;vertical-align: middle;text-align: center;">站点</td>
            <td width="30%" style="vertical-align: middle;"><?php echo $siteId[$client['siteId']];?></td>
            <td width="10%" style="font-weight: bold;vertical-align: middle;text-align: center;">客户级别</td>
            <td width="50%" style="vertical-align: middle;"><?php echo $customer['Level'][$client['level']]?></td>
        </tr>
        <tr>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">客户名称</td>
            <td width="212" ><?php echo $client['name']?></td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;" id="khjb">公司名称</td>
            <td style="vertical-align: middle;"><?php echo $client['proname']?></td>
        </tr>
        <tr id="qtkh">
            <td colspan="4">
                <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                    <tr>
                        <td style="font-weight: bold;vertical-align: middle;text-align: center;width:15%">客户来源</td>
                        <td style="vertical-align: middle;width:25%"><?php echo $customer['Source'][$client['source']];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;width:15%">
                            <span id="projectSize_1">所属行业</span>
                        </td>
                        <td style="vertical-align: middle;">
                            <span id="projectSize_2"><?php echo $customer['industry'][$client['industry']];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">对接人</td>
                        <td style="vertical-align: middle;"><?php echo $client['dockName'];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">职务</td>
                        <td style="vertical-align: middle;"><?php echo $client['position'];?></td>
                    </tr>
                    <tr>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">联系方式</td>
                        <td style="vertical-align: middle;"><?php echo $client['phone'];?></td>
                        <td style="vertical-align: middle;text-align: center;font-weight: bold;">办公地址</td>
                        <td style="vertical-align: middle;"><?php echo $client['address'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<table  class="table table-bordered table-striped" id="smpl_tbl_1">
    <tr>
        <td colspan="7" style="color:red;font-weight: bold;font-size: 16px;vertical-align: middle;height: 35px;"><?php echo $client['name']?></td>
    </tr>
<?php if(!empty($visit)) { ?>
<tr>
    <td colspan="7"><strong>客户拜访记录明细</strong></td>
</tr>
<tr>
    <td colspan="7">
        <table id="tbl_info2" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
            <tr>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">拜访时间</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">业务员</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">拜访形式</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">洽谈内容</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">下次行动计划</td>
            </tr>
            
              <?php foreach($visit as $value) {?>
            <tr>
                <td style="vertical-align: middle;text-align: center;"><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo $userInfo[$value['operator']];?></td>
                <td style="vertical-align: middle;text-align: center;">&nbsp;<?php echo $dailyShape[$value['shape']]; ?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo $value['content'];?></td>
                <td style="vertical-align: middle;text-align: center;" width="30%"><?php echo $value['plan'];?></td>
            </tr>
              <?php } ?>
        </table>
    </td>
</tr>
<?php } ?>

<?php if(!empty($client_relation)) { ?>
<tr>
    <td colspan="4"><strong>业务员维护记录明细</strong></td>
</tr>
<tr>
    <td colspan="7">
        <table id="tbl_info2" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
            <tr>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">客户名称</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">业务员姓名</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">维护开始时间</td>
                <td style="font-weight: bold;vertical-align: middle;text-align: center;">维护结束</td>
            </tr>
            <?php foreach($client_relation as $value) {?>
            <tr>
                <td style="vertical-align: middle;text-align: center;">&nbsp;<?php echo $client['name']; ?></td>
                <td style="vertical-align: middle;text-align: center;">&nbsp;<?php echo $userInfo[$value['salesmanId']]; ?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo date('Y-m-d',$value['startDate']);?></td>
                <td style="vertical-align: middle;text-align: center;"><?php echo date('Y-m-d',$value['endDate']); ?></td>

            </tr>
            <?php } ?>
        </table>
    </td>
</tr>
<?php } ?>

</table>
