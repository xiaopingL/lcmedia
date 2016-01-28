<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
    	<?php if($sId == 3 && empty($arr['state']) && $approver==$this->session->userdata('uId')){?>
            if($("#actNum").val() == '' && $("#app_type").val() == 1){
                alert('实际领取数量不能为空！'); $("#actNum").focus();
                return false;
            }
        <?php } ?>
    });
   
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%"><b>物料名称</b></td>
                <td><?php echo $arr['name']?></td>
            </tr>
            
            <?php if(!empty($arr['category'])){?>
            <tr>
                <td width="15%"><b>票务类型</b></td>
                <td>
                    <?php if($arr['category']==1){
                    	echo '合同赠票';
                    }elseif($arr['category']==2){
                    	echo '客户购买';
                    }else{
                    	echo '个人申领';
                    }?>
                </td>
            </tr>
            <?php } ?>
            
            <?php if(in_array($arr['category'],array(1,2))){?>
            <tr>
                <td><b>客户信息</b></td>
                <td>客户名称：<?php echo $clientInfo[$arr['cId']]?>&nbsp;&nbsp;&nbsp;&nbsp;合同金额：<?php echo $arr['contractPrice']?>元&nbsp;&nbsp;&nbsp;&nbsp;合同上刊时间：<?php echo date('Y-m-d',$arr['contractDate'])?></td>
            </tr>
            <?php } ?>
            
            <?php if($arr['type']==1){?>
            <tr>
                <td><b>本次领用截止编号</b></td>
                <td><?php echo $arr['number']?></td>
            </tr>
            <?php } ?>

            <tr>
                <td><b>单位</b></td>
                <td><?php echo $arr['unit']?></td>
            </tr>
            
            <tr>
                <td><b>单价</b></td>
                <td><?php echo $arr['price']?>&nbsp;元</td>
            </tr>
            
            <tr>
                <td><b>领取数量</b></td>
                <td><?php echo $arr['num']?></td>
            </tr>
            
            <?php if(!empty($arr['actNum'])){?>
            <tr>
                <td><b>实际领取数量</b></td>
                <td><?php echo $arr['actNum']?>&nbsp;<font color=red>（行政发放）</font></td>
            </tr>
            <?php } ?>
            
            <tr>
                <td><b>备注说明</b></td>
                <td><?php echo $arr['note']?></td>
            </tr>
            
            <?php if($sId == 3 && empty($arr['state']) && $approver==$this->session->userdata('uId')){?>
            <tr>
                <td><b><font color=red>实际领取数量</font></b></td>
                <td><input type="text" name="actNum" id="actNum" class="span1"></td>
            </tr>
            <?php } ?>
            <tr>
                <td>审批详情</td>
                <td><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>