<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id');
    });
    KindEditor.options.filterMode = false;
</script>

<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="12%"><b>客户名称</b></td>
                <td colspan="3" style="color:green"><?php echo $name;?></td>
            </tr>

            <tr>
                <td width="12%"><b>合同名称</b></td>
                <td><?php echo $title;?></td>
                <td width="12%"><b>合同金额</b></td>
                <td><?php echo $money;?>&nbsp;<font color=red>（元）</font></td>
            </tr>
            
            <tr>
                <td><b>上刊时间</b></td>
                <td><?php echo date('Y-m-d',$issueDate);?></td>
                <td><b>下刊时间</b></td>
                <td><?php echo date('Y-m-d',$underDate);?></td>
            </tr>
            
            <tr>
                <td><b>折扣</b></td>
                <td><?php echo $discount;?></td>
                <td><b>营销费用</b></td>
                <td><?php echo $market;?>&nbsp;<font color=red>（元）</font>
                    <?php if(!empty($markeyNote)){?>备注：<?php echo $markeyNote;?><?php } ?>
                </td>
            </tr>
            
            <?php if(!empty($serviceList)){?>
            <tr>
                <td><b>增值服务</b></td>
                <td colspan="3">
                    <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td width="20%" style="text-align: center;"><b>服务类型</b></td>
                            <td style="text-align: center;"><b>备注</b></td>
                        </tr>
                        <?php foreach($serviceList as $k=>$v){?>
                        <tr>
                            <td style="text-align: center;"><?php echo $k+1;?></td>
                            <td style="text-align: center;"><?php echo $contract['service'][$v['service']];?></td>
                            <td style="text-align: center;"><?php echo $v['remark'];?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
            <?php } ?>

            <tr>
                <td><b>合同内容</b></td>
                <td style="max-width:900px;" colspan="3"><?php echo str_replace("&", "&amp;", $content);?></td>
            </tr>
            
            <tr>
                <td><b>备注说明</b></td>
                <td colspan="3"><?php echo nl2br($description); ?></td>
            </tr>
            
            <tr>
                <td>审批详情</td>
                <td colspan="3"><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>