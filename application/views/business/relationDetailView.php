<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr id="TLink" class="">
                <td width="15%">客户名称</td>
                <td><?php echo $client['name']?></td>
            </tr>
            <?php if(!empty($client['proname'])){?>
            <tr id="TLink" class="">
                <td width="15%">项目名称</td>
                <td><?php echo $client['proname'];?></td>
            </tr>
            <?php } ?>
            <?php if(!empty($client['industry'])){?>
            <tr id="TLink" class="">
                <td width="15%">所属行业</td>
                <td><?php echo $customer['industry'][$client['industry']];?></td>
            </tr>
            <?php } ?>
            <tr id="TLink" class="">
                <td width="15%">客户地址</td>
                <td><?php echo $client['address'] ?></td>
            </tr>
            
            <tr id="TLink" class="">
                <td width="15%">转出业务员</td>
                <td><?php echo $userInfo[$oldRelation['salesmanId']] ?></td>
            </tr>

            <tr id="TLink" class="">
                <td width="15%">接收业务员</td>
                <td><?php echo $userInfo[$relation['salesmanId']] ?></td>
            </tr>

            <tr>
                <td width="15%">服务开始日期</td>
                <td><?php echo date('Y-m-d',$relation['startDate']); ?></td>
            </tr>
            
            <tr>
                <td>审批详情</td>
                <td><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>