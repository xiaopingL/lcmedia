<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>

            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle;"><span class="bold">设置日期</span></td>
                <td><input type="text" name="setDate" id="setDate" onClick="WdatePicker()" value="<?php echo date('Y-m-d'); ?>" class="span2"></td>
            </tr>

            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle;"><span class="bold">设置类型</span></td>
                <td><input type="radio" name="setStatus" value="1" checked>公休&nbsp;<input type="radio" name="setStatus" value="2">正常上班</td>
            </tr>
            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle;"><span class="bold">是否法定节假日</span></td>
                <td><input type="radio" name="setType" value="1" checked>是&nbsp;<input type="radio" name="setType" value="2">否</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
