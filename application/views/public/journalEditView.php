<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    function insertstep(){
        var count = $("#tbl_info tr").length-1;
        count++;
        $("#tbl_info").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;"><textarea name="logDescription[]" id="logDescription" style="width:140px;" rows="2"></textarea></td><td><input type="text" name="timeConsuming[]" id="timeConsuming" style="width:50px;"/></td><td><input type="text" name="completion[]" id="completion" style="width:50px;"/></td><td style="text-align: center;"><textarea name="noComplete[]" id="noComplete" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="improvementMeasures[]" id="improvementMeasures" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="deadline[]" id="deadline" style="width:140px;" rows="2"></textarea></td></tr>');
        return false;
    }

    function insertstep1(){
        var count = $("#tbl_info1 tr").length-1;
        count++;
        $("#tbl_info1").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;"><textarea name="logDescription_ls[]" id="logDescription_ls" style="width:140px;" rows="2"></textarea></td><td><input type="text" name="timeConsuming_ls[]" id="timeConsuming_ls" style="width:50px;"/></td><td><input type="text" name="completion_ls[]" id="completion_ls" style="width:50px;"/></td><td style="text-align: center;"><textarea name="noComplete_ls[]" id="noComplete_ls" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="improvementMeasures_ls[]" id="improvementMeasures_ls" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="deadline_ls[]" id="deadline_ls" style="width:140px;" rows="2"></textarea></td></tr>');
        return false;
    }

    function insertstep2(){
        var count = $("#tbl_info2 tr").length-1;
        count++;
        $("#tbl_info2").append('<tr><td style="text-align: center;">'+count+'</td><td style="text-align: center;"><textarea name="logDescription_mrjh[]" id="logDescription_mrjh" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><input type="text" name="timeConsuming_ls_mrjh[]" id="timeConsuming_ls_mrjh" style="width:50px;"/></td><td style="text-align: center;"><textarea name="cxwt_mrjh[]" id="cxwt_mrjh" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="ydcs_mrjh[]" id="ydcs_mrjh" style="width:140px;" rows="2"></textarea></td><td style="text-align: center;"><textarea name="gjcs_mrjh[]" id="gjcs_mrjh" style="width:140px;" rows="2"></textarea></td></tr>');
        return false;
    }
</script>

<form method="post" action="<?php echo site_url('/public/JournalController/journalModify');?>" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>

            <tr valign="middle">
                <td width="10%" style="text-align: center;"><span class="bold">日期</span></td>
                <td><input type="text" name="logDate" id="logDate" onClick="WdatePicker()" value="<?php echo date('Y-m-d',$arr['startDate']); ?>" class="span2" disabled></td>
                <td width="10%" style="text-align: center;"><span class="bold">日志标题</span></td>
                <td><input type="text" name="journalTitle" class="" id="journalTitle" value="<?php echo $arr['journalTitle']; ?>" disabled></td>
            </tr>
            
           <tr>
                <td width="5%" align="center" style="text-align: center;"><b>今日工作总结</b></td>
                <td colspan="5">
                    <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>工作项目描述</b></td>
                            <td style="text-align: center;"><b>耗时(/h)</b></td>
                            <td style="text-align: center;"><b>完成情况</b></td>
                            <td style="text-align: center;"><b>未完成差异分析</b></td>
                            <td style="text-align: center;"><b>改进措施</b></td>
                            <td style="text-align: center;"><b>完成期限</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info2' onClick="return insertstep()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <?php $i = 1;foreach($result as $value):?>
                        <tr>
                            <td style="text-align: center;"><?php echo $i;?></td>
                            <td style="text-align: center;"><textarea name="logDescription[]" id="logDescription" style="width:140px;" rows="2"><?php echo $value['logDescription'];?></textarea></td>
                            <td><input type="text" name="timeConsuming[]" id="timeConsuming" style="width:50px;" value="<?php echo $value['timeConsuming'];?>"/></td>
                            <td><input type="text" name="completion[]" id="completion" style="width:50px;" value="<?php echo $value['completion'];?>"/></td>
                            <td style="text-align: center;"><textarea name="noComplete[]" id="noComplete" style="width:140px;" rows="2"><?php echo $value['noComplete'];?></textarea></td>
                            <td style="text-align: center;"><textarea name="improvementMeasures[]" id="improvementMeasures" style="width:140px;" rows="2"><?php echo $value['improvementMeasures'];?></textarea></td>
                            <td style="text-align: center;"><textarea name="deadline[]" id="deadline" style="width:140px;" rows="2"><?php echo $value['deadline'];?></textarea></td>
                            
                        </tr>
                        <?php $i++;endforeach;?>
                    </table>
                </td>
            </tr>
            <tr>
                <td width="5%" align="center" style="text-align: center;"><b>临时工作项目</b></td>
                <td colspan="5">
                    <table id="tbl_info1" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td colspan="8"><b>增加临时工作项</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info2' onClick="return insertstep1()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <?php $i = 1;foreach($rows as $value):?>
                        <tr>
                            <td style="text-align: center;" width="6%"><?php echo $i;?></td>

                            <td style="text-align: center;"><textarea name="logDescription_ls[]" id="logDescription_ls" style="width:140px;" rows="2"><?php echo $value['logDescription'];?></textarea></td>
                            <td><input type="text" name="timeConsuming_ls[]" id="timeConsuming_ls" style="width:50px;" value="<?php echo $value['timeConsuming'];?>"/></td>
                            <td><input type="text" name="completion_ls[]" id="completion_ls" style="width:50px;" value="<?php echo $value['completion'];?>"/></td>
                            <td style="text-align: center;"><textarea name="noComplete_ls[]" id="noComplete_ls" style="width:140px;" rows="2"></textarea></td>
                            <td style="text-align: center;"><textarea name="improvementMeasures_ls[]" id="improvementMeasures_ls" style="width:140px;" rows="2"><?php echo $value['noComplete'];?></textarea></td>
                            <td style="text-align: center;"><textarea name="deadline_ls[]" id="deadline_ls" style="width:140px;" rows="2"><?php echo $value['deadline'];?></textarea></td>
                        </tr>
                        <?php $i++;endforeach;?>
                    </table>
                </td>
            </tr>

            <tr>
                <td width="5%" align="center" style="text-align: center;"><b>明日工作计划</b></td>
                <td colspan="5">
                    <table id="tbl_info2" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>工作计划内容</b></td>
                            <td style="text-align: center;"><b>耗时(/h)</b></td>
                            <td style="text-align: center;"><b>预计可能出现的问题</b></td>
                            <td style="text-align: center;"><b>应对措施</b></td>
                            <td style="text-align: center;"><b>改进措施</b>&nbsp;&nbsp;<a href="#" title="新增一行"><img id='add_info2' onClick="return insertstep2()" src="<?php echo $base_url;?>img/add.png" border="0" /></a></td>
                        </tr>
                        <?php $i = 1;foreach($getArray as $value):?>
                        <tr>
                            <td style="text-align: center;"><?php echo $i;?></td>
                            <td style="text-align: center;"><textarea name="logDescription_mrjh[]" id="logDescription_mrjh" style="width:140px;" rows="2"><?php echo $value['logDescription'];?></textarea></td>
                            <td style="text-align: center;"><input type="text" name="timeConsuming_ls_mrjh[]" id="timeConsuming_ls_mrjh" style="width:50px;" value="<?php echo $value['timeConsuming'];?>"/></td>
                            <td style="text-align: center;"><textarea name="cxwt_mrjh[]" id="cxwt_mrjh" style="width:140px;" rows="2"><?php echo $value['completion'];?></textarea></td>
                            <td style="text-align: center;"><textarea name="ydcs_mrjh[]" id="ydcs_mrjh" style="width:140px;" rows="2"><?php echo $value['noComplete'];?></textarea></td>
                            <td style="text-align: center;"><textarea name="gjcs_mrjh[]" id="gjcs_mrjh" style="width:140px;" rows="2"><?php echo $value['improvementMeasures'];?></textarea></td>
                        </tr>
                        <?php $i++; endforeach;?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>遇到的问题</b></td>
                <td colspan="8">
                    <textarea name="journalExperience" id="journalExperience" style="width:300px;" rows="2"><?php echo $arr['journalExperience'];?></textarea>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>解决办法</b></td>
                <td colspan="8">
                    <textarea name="journalSugges" id="journalSugges" style="width:300px;" rows="2"><?php echo $arr['journalSugges'];?></textarea>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="text-align:center;">
                    <input type="hidden" value="<?php echo $arr['pId'];?>" name="pId" id="pId" />
                    <input type="hidden" value="<?php echo $arr['operator'];?>" name="operator" id="operator"/>
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加" style="margin-right: 20px;">提交内容</button>
                    <button type="button" class="btn" onClick="javascript:history.go(-1)">我要返回</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
