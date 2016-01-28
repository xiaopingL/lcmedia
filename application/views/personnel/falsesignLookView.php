<form action="" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <?php if(!empty($arr['address'])):?>
            <tr>
                <td width="10%"><b>地址定位</b></td>
                <td><?php echo $arr['address'];?></td>
            </tr>
            <?php endif;?>
            <tr>
                <td width="10%"><b>误打卡事由</b></td>
                <td><?php echo $arr['cause'];?></td>
            </tr>
            <tr>
                <td><b>申请时间</b></td>
                <td>
                    <?php echo date("Y-m-d",$arr['startDate']);?>&nbsp;/&nbsp;<?php echo $falsesignType[$arr['type']];?>
                </td>
            </tr>

            <tr>
                <td><b>误打卡次数</b></td>
                <td>
                    <?php echo $arr['num']."次";?>
                </td>
            </tr>

            <tr>
                <td><b>创建时间</b></td>
                <td>
                    <?php echo date("Y-m-d",$arr['createTime']);?>
                </td>
            </tr>

            <tr>
                <td>审批详情</td>
                <td><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>