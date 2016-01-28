<form action="" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            
            <tr>
                <td width="10%"><b>请假事由</b></td>
                <td><?php echo $arr['cause'];?></td>
            </tr>

            <tr>
                <td><b>请假类别</b></td>
                <td>
                    <?php echo $leaveType[$arr['type']];?>&nbsp;&nbsp;<?php echo $arr['allDay'];?>天
                </td>
            </tr>

            <tr>
                <td><b>请假时间</b></td>
                <td>
                    <?php echo date("Y-m-d H:i",$arr['startDate']);?>
                    至
                    <?php echo date("Y-m-d H:i",$arr['endDate']);?>
                </td>
            </tr>
            <tr>
                <td><b>创建时间</b></td>
                <td><?php echo date("Y-m-d H:i:s",$arr['createTime']);?></td>
            </tr>
            <tr>
                <td><b>附件：</b></td>
                <?php if(!empty($arr['annex'])):?>
                <td colspan="5">
                    <a href="<?php echo site_url("/personnel/LeaveController/downloadApp/".$arr['leaveId']) ?>" title="下载">
                        <img title="有附件" src="<?php echo base_url();?>img/attachment.gif" border="0" align="absmiddle">
                            <?php echo $arr['origName']?></a>
                </td>
                <?php else:?>
                <td>无</td>
                <?php endif;?>
            </tr>

            <tr>
                <td>审批详情</td>
                <td colspan="10"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>