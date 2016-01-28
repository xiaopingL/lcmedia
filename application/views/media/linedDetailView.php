<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td style="text-align: center;font-weight: bold;">影城名称</td>
                <td><?php echo $name;?></td>
            </tr>
            
		    <tr>
		        <td style="text-align: center;font-weight: bold;">标题</td>
		        <td>领程传媒 <?php echo $month;?>月 <?php echo $days;?> 日广告排期表</td>
		    </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">排期时间</td>
                <td><?php echo date('Y-m-d',$startDate);?>&nbsp;至&nbsp;<?php echo date('Y-m-d',$endDate);?></td>
            </tr>
             
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">排期广告</td>
                <td><?php echo nl2br($content);?></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">剩余广告时长</td>
                <td><?php echo $overplus_min;?>&nbsp;分&nbsp;<?php echo $overplus_sec;?>&nbsp;秒</td>
            </tr>
            
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button type="button" class="btn" onClick="javascript:history.go(-1)">返回</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
