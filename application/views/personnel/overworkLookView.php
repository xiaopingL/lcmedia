<form action="" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
           
            <tr>
                <td width="15%"><b>申请人</b></td>
                <td colspan="5"><?php echo $userInfoArray[$arr['operator']];?></td>
            </tr>

            <tr>
                <td width="15%"><b>加班地点</b></td>
                <td><?php echo $arr['addr'];?></td>
            </tr>

            <tr>
                <td><b>加班内容</b></td>
                <td colspan="5"><?php echo $arr['oContent'];?></td>
            </tr>

            <tr>
                <td><b>加班时间</b></td>
                <td><?php echo $arr['sTime'];?>&nbsp;<?php echo $arr['start_hour'];?>点&nbsp;至&nbsp;<?php echo $arr['eTime'];?>&nbsp;<?php echo $arr['end_hour'];?>点</td>
            </tr>

            <tr>
                <td><b>共计时间</b></td>
                <td colspan="5"><?php echo $arr['allDay'];?>天<?php echo $arr['allHour'];?>小时</td>
            </tr>

            <tr>
                <td><b>备注</b></td>
                <td colspan="5"><?php echo $arr['overContent'];?></td>
            </tr>

            <tr>
                <td>审批详情</td>
                <td colspan="10"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
            
        </tbody>
    </table>
</form>