<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒影讯广告执行单</td>
		    </tr>

		    <tr>
                <td style="text-align: center;font-weight: bold;">客户名称</td>
                <td><?php echo $name;?></td>
                <td style="text-align: center;font-weight: bold;">位置要求</td>
                <td><?php echo $advert['position'][$position];?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">合同编号</td>
                <td><?php echo $contractNumber;?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">支付形式</td>
                <td><?php echo $advert['pay_type'][$pay_type];?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">影讯期号</td>
                <td colspan="3"><?php echo $issue?str_replace(' ','年',$issue).'月':''; ?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">备注说明</td>
                <td colspan="3"><?php echo $remark;?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">审批详情</td>
                <td colspan="3"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>
