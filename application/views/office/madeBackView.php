<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#getDate").val() == ''){
                alert('回收时间不能为空！'); $("#getDate").focus();
                return false;
            }
            if($("#getNum").val() == ''){
                alert('回收数量不能为空！'); $("#getNum").focus();
                return false;
            }
    });

})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td><b>客户名称</b></td>
                <td><?php echo $arr['clientName'];?></td>
            </tr>
            
            <tr>
                <td><b>票种</b></td>
                <td><?php echo $arr['name'];?></td>
            </tr>
 
            <tr>
                <td><b>回收时间</b></td>
                <td><input type="text" name="getDate" id="getDate" onClick="WdatePicker()"></td>
            </tr>
            
            <tr>
                <td><b>回收数量</b></td>
                <td><input type="text" name="getNum" id="getNum" class="span1"></td>
            </tr>
            
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">
						提交内容
                    </button>
                    <button type="reset" class="btn">
						重置
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<?php if(!empty($detail)){ ?>
<table class="table table-bordered table-striped">
        <tr>
            <td align="center" class="bold">客户名称</td>
            <td align="center" class="bold">购买时间</td>
            <td align="center" class="bold">票种</td>
            <td align="center" class="bold">数量</td>
            <td align="center" class="bold">回收时间</td>
            <td align="center" class="bold">回收数量</td>
        </tr>
         <?php foreach($detail as $key=>$v) { ?>
            <tr>
                <td align="center">&nbsp;<?php echo $arr['clientName'];?></td>
                <td align="center">&nbsp;<?php echo date('Y-m-d',$arr['madeDate']);?></td>
                <td align="center">&nbsp;<?php echo $arr['name']?></td>
                <td align="center">&nbsp;<?php echo $arr['madeNum']?></td>
                <td align="center">&nbsp;<?php echo date('Y-m-d',$v['getDate'])?></td>
                <td align="center">&nbsp;<?php echo $v['getNum']?></td>
            </tr>
        <?php }?>
        <tr>
            <td colspan="6"><font color=red>回收总量：<?php echo $total;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;回收比例：<?php echo $profit;?>%</font></td>
        </tr>
</table>
<?php } ?>