<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒广告播出确认单</td>
		    </tr>
            
		    <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">客户名称</td>
                <td width="40%"><a href="<?php echo site_url('business/CustomerController/customerDetail/'.$cId)?>" target="_blank"><?php echo $name;?></a></td>
                <td width="10%" style="text-align: center;font-weight: bold;">关联合同</td>
                <td width="40%"><a href="<?php echo site_url('/business/ContractController/contractDetail/'.$contractId);?>" target="_blank"><?php echo $title;?></a></td>
            </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">影院信息</td>
                <td colspan="3">
                    <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>执行影院</b></td>
                            <td style="text-align: center;"><b>执行时间</b></td>
                            <td style="text-align: center;"><b>周期</b></td>
                        </tr>
                        <?php if(!empty($contentList)){foreach($contentList as $k=>$v){?>
                        <tr>
                            <td style="text-align: center;"><?php echo $k+1;?></td>
                            <td style="text-align: center;" width="35%"><?php echo $studioList[$v['title']];?></td>
                            <td style="text-align: center;"><?php echo $v['startDate'];?>&nbsp;至&nbsp;<?php echo $v['endDate'];?></td>
                            <td style="text-align: center;"><?php echo $v['weekNum'];?>&nbsp;周</td>
                        </tr>
                        <?php } }?>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">广告片时长</td>
                <td><?php echo $duration;?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">广告片提供方</td>
                <td><?php echo $supplier;?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">位置要求</td>
                <td><?php echo $position;?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">监播要求</td>
                <td><?php echo $monitor;?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">审批详情</td>
                <td colspan="3"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>
