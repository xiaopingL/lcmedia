<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    function insertstep1(){
        var count = $("#tbl_info1 tr").length-1;
        count++;
        $("#tbl_info1").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;"><select name="clientName[]" id="clientName" class="span2"><option value="">-选择客户名称-</option><?php foreach($client as $key=>$val){?><option value="<?php echo $val['cId'];?>"><?php echo $val['name'];?></option><?php } ?></select></td><td><input type="text" name="userName[]" id="userName" style="width:50px;"/></td><td><select name="shape[]" id="shape" class="span1"><option value="">-选择-</option><?php foreach($shape as $key=>$val){?><option value="<?php echo $key;?>"><?php echo $val;?></option><?php } ?></select></td><td style="text-align: center;"><textarea name="content[]" id="content" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="plan[]" id="plan" style="width:140px;" rows="2"></textarea></td></tr>');
        return false;
    }

    function insertstep2(){
        var count = $("#tbl_info2 tr").length-1;
        count++;
        $("#tbl_info2").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;"><textarea name="morning[]" id="morning" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea type="text" name="mTarget[]" id="mTarget" style="width:140px;" rows="2"/></textarea></td><td style="text-align: center;"><textarea name="afternoon[]" id="afternoon" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="aTarget[]" id="aTarget" style="width:140px;" rows="2"></textarea></td></tr>');
        return false;
    }
</script>

<form method="post" action="<?php echo site_url('/public/DailyController/dailyInsertView');?>" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>

            <tr valign="middle">
                <td width="10%" style="text-align: center;"><span class="bold">日期</span></td>
                <td><input type="text" name="logDate" id="logDate" onClick="WdatePicker()" value="<?php echo date('Y-m-d'); ?>" class="span2"></td>
                <td width="10%" style="text-align: center;"><span class="bold">日志标题</span></td>
                <td><input type="text" name="logTitle" class="" id="logTitle" value="工作日志 <?php echo date('Y-m-d'); ?>"></td>
            </tr>
            
           <tr>
                <td width="5%" align="center" style="text-align: center;"><b>拜访情况</b></td>
                <td colspan="5">
                    <table id="tbl_info1" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;width: 150px;"><b>客户名称</b></td>
                            <td style="text-align: center;"><b>客户姓名</b></td>
                            <td style="text-align: center;"><b>拜访形式</b></td>
                            <td style="text-align: center;"><b>洽谈内容</b></td>
                            <td style="text-align: center;"><b>下次行动计划(限期)</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info2' onClick="return insertstep1()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: center;">
                                <select name="clientName[]" id="clientName" class="span2">
                                      <option value="">-选择客户名称-</option>
                                      <?php foreach($client as $key=>$val){?>
                                      <option value="<?php echo $val['cId'];?>"><?php echo $val['name'];?></option>
                                      <?php } ?>
                                </select>
                            </td>
                            <td><input type="text" name="userName[]" id="userName" style="width:50px;"/></td>
                            <td>
                                <select name="shape[]" id="shape" class="span1">
                                      <option value="">-选择-</option>
                                      <?php foreach($shape as $key=>$val){?>
                                      <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                      <?php } ?>
                                </select>
                            </td>
                            <td style="text-align: center;"><textarea name="content[]" id="content" style="width:140px;" rows="2"></textarea></td>
                            <td style="text-align: center;"><textarea name="plan[]" id="plan" style="width:140px;" rows="2"></textarea></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td width="5%" align="center" style="text-align: center;"><b>明日计划</b></td>
                <td colspan="5">
                    <table id="tbl_info2" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>上午</b></td>
                            <td style="text-align: center;"><b>目标</b></td>
                            <td style="text-align: center;"><b>下午</b></td>
                            <td style="text-align: center;"><b>目标</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info2' onClick="return insertstep2()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td style="text-align: center;"><textarea name="morning[]" id="morning" style="width:140px;" rows="2"></textarea></td>
                            <td style="text-align: center;"><textarea type="text" name="mTarget[]" id="mTarget" style="width:140px;" rows="2"/></textarea></td>
                            <td style="text-align: center;"><textarea name="afternoon[]" id="afternoon" style="width:140px;" rows="2"></textarea></td>
                            <td style="text-align: center;"><textarea name="aTarget[]" id="aTarget" style="width:140px;" rows="2"></textarea></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>其他工作</b></td>
                <td colspan="8">
                    <textarea name="other" id="other" class="span5"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
