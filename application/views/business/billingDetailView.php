<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#money").val() == ''){
                alert('开票金额不能为空！'); $("#money").focus();
                return false;
            }
            if($("#billingDate").val() == ''){
                alert('开票时间不能为空！'); $("#billingDate").focus();
                return false;
            }
            if($("#number").val() == ''){
                alert('发票编码不能为空！'); $("#number").focus();
                return false;
            }
    });
   
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="12%"><b>客户名称</b></td>
                <td style="color:green"><?php echo $name;?></td>
                <td width="12%"><b>合同名称</b></td>
                <td style="color:green"><?php echo $title;?></td>
            </tr>

            <tr>
                <td width="12%"><b>合同编号</b></td>
                <td><?php echo $contractNumber;?></td>
                <td width="12%"><b>合同金额</b></td>
                <td><?php echo $money;?>&nbsp;<font color=red>（元）</font></td>
            </tr>
            
            <tr>
                <td><b>类别</b></td>
                <td><?php echo $billing['billingClass'][$class]?></td>
                <td><b>发票性质</b></td>
                <td><?php echo $billing['billingType'][$type]?></td>
            </tr>
            
            <tr>
                <td><b>我方开票公司</b></td>
                <td><?php echo $billing['billingOur'][$ourCompany]?></td>
                <td><b>发票类型</b></td>
                <td>
                    <?php echo $billing['billingCate'][$cate]?>
                    <?php if(!empty($cate_other)){?>
                    &nbsp;&nbsp;(备注：<?php echo $cate_other;?>)
                    <?php } ?>
                </td>
            </tr>
            
            <tr>
                <td><b>客户开票名称</b></td>
                <td><?php echo $company;?></td>
                <td><b>开票金额</b></td>
                <td><?php echo $money;?>&nbsp;<font color=red>（元）</font></td>
            </tr>
            
            <?php if($state == 1){?>
            <tr>
                <td><b>开票时间</b></td>
                <td><?php echo date('Y-m-d',$billingDate);?></td>
                <td><b>发票编码</b></td>
                <td><?php echo $number;?></td>
            </tr>
            <?php } ?>
            
            <tr>
                <td><b>备注</b></td>
                <td colspan="3"><?php echo $remark;?></td>
            </tr>
            
            <?php if(count($flowlist)>1 && empty($state) && $this->session->userdata('uId')==$flowlist[1]['toUid']){?>
            <tr>
                <td><b style="color:red">开票金额</b></td>
                <td colspan="3"><input type="text" name="money" id="money" class="span1" value="<?php echo $money;?>">&nbsp;<font color=red>（元）</font></td>
            </tr>
            <tr>
                <td><b style="color:red">开票时间</b></td>
                <td colspan="3"><input type="text" name="billingDate" id="billingDate" style="width:100px" value="<?php echo date('Y-m-d');?>" onClick="WdatePicker()"></td>
            </tr>
            <tr>
                <td><b style="color:red">发票编码</b></td>
                <td colspan="3"><input type="text" name="number" id="number" class="span2"></td>
            </tr>
            <?php }?>
            
            <tr>
                <td>审批详情</td>
                <td colspan="3"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>