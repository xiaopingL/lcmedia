<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?php echo $base_url;?>js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    KindEditor.ready(function(K) {
        window.editor = K.create('#editor_id');
    });
    KindEditor.options.filterMode = false;

    function insertstep(){
        var count = $("#tbl_info tr").length-1;
        count++;
        $("#tbl_info").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;"><select name="service[]"><option value="">-请选择-</option><?php foreach($contract['service'] as $key=>$val){?><option value="<?php echo $key;?>"><?php echo $val;?></option><?php } ?></select></td><td style="text-align: center;"><input type="text" name="remark[]" class="span4"></tr>');
        return false;
    }
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
                <td><input type="text" name="title" id="title" value="<?php echo $title;?>"></td>
                <td width="12%"><b>合同金额</b></td>
                <td><input type="text" name="money" id="money" value="<?php echo $money;?>" class="span1">&nbsp;<font color=red>（元）</font></td>
            </tr>
            
            <tr>
                <td><b>上刊时间</b></td>
                <td><input type="text" name="issueDate" id="issueDate" value="<?php echo date('Y-m-d',$issueDate);?>" onClick="WdatePicker()"></td>
                <td><b>下刊时间</b></td>
                <td><input type="text" name="underDate" id="underDate" value="<?php echo date('Y-m-d',$underDate);?>" onClick="WdatePicker()"></td>
            </tr>
            
            <tr>
                <td><b>折扣</b></td>
                <td><input type="text" name="discount" id="discount" value="<?php echo $discount;?>"></td>
                <td><b>营销费用</b></td>
                <td><input type="text" name="market" id="market" value="<?php echo $market;?>" class="span1">&nbsp;<font color=red>（元）</font>
                                                    备注：<input type="text" name="markeyNote" id="markeyNote" value="<?php echo $markeyNote;?>" class="span2">
                </td>
            </tr>
            
            <tr>
                <td><b>增值服务</b></td>
                <td colspan="3">
                    <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>服务类型</b></td>
                            <td style="text-align: center;"><b>备注</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info' onClick="return insertstep()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <?php if(!empty($serviceList)){foreach($serviceList as $k=>$v){?>
                        <tr>
                            <td style="text-align: center;"><?php echo $k+1;?></td>
                            <td style="text-align: center;">
	                            <select name="service[]">
			                           <option value="">-请选择-</option>
			                           <?php foreach($contract['service'] as $key=>$val){?>
			                           <option value="<?php echo $key;?>" <?php echo $v['service']==$key?'selected':'';?>><?php echo $val;?></option>
			                           <?php } ?>
			                    </select>
                            </td>
                            <td style="text-align: center;"><input type="text" name="remark[]" class="span4" value="<?php echo $v['remark'];?>"></td>
                        </tr>
                        <?php } }?>
                    </table>
                </td>
            </tr>

            <tr>
                <td><b>合同内容</b></td>
                <td style="max-width:900px;" colspan="3">
                    <textarea id="editor_id" name="content" style="width: 85%;height:400px;">
                        <?php echo str_replace("&", "&amp;", $content);?>
                    </textarea>
		        </td>
            </tr>
            
            <tr>
                <td><b>备注说明</b></td>
                <td colspan="3">
                    <textarea name="description" class="span4"><?php echo $description; ?></textarea>
		        </td>
            </tr>
            
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交" style="margin-right: 20px;">
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