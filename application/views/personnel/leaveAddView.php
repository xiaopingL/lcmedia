<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form action="<?php echo site_url('/personnel/LeaveController/leaveInsert');?>" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="10">
                    (<span style="color: red;">*</span> 为必填内容项目)
                    <b>
					[姓名：<?php echo $userInfoArray[$uId];?>]&nbsp;
					[填单日期：<?php echo date("Y-m-d");?>]
                    </b>
                </td>
            </tr>

            <tr>
                <td width="10%"><b>请假事由</b></td>
                <td><textarea name="cause" id="cause" style="width:300px;" rows="2"></textarea>&nbsp;&nbsp;&nbsp;<span style="color:red">*</span></td>
            </tr>

            <tr>
                <td><b>请假类别</b></td>
                <td>
                    <?php foreach($leaveType as $key=>$value):?>
                    <input type="radio" name="type" id="type" value="<?php echo $key;?>" <?php if($key == '1'):?> checked="checked"<?php endif;?> /><?php echo $value;?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php endforeach;?>
                </td>
            </tr>

            <tr>
                <td><b>请假时间</b></td>
                <td>
                    <input type="text" name="sTimet" id="sTimet" style="width:70px;" value="<?php echo date("Y-m-d");?>"  onClick="WdatePicker()">
                    <select name="start_hour" id="start_hour" style="width:90px;">
                        <option value="08:30">08:30</option>
                        <option value="12:00">12:00</option>
                    </select>
                    至
                    <input type="text" name="eTimet" id="eTimet" style="width:70px;" value="<?php echo date("Y-m-d");?>"  onClick="WdatePicker()">
                    <select name="end_hour" id="end_hour" style="width:90px;">
                        <option value="12:00">12:00</option>
                        <option value="18:00" selected>18:00</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><b>附件：</b></td>
                <td>
                    <input type="hidden" name="isUserfile" id="isUserfile">
                    <input type="file" name="userfile" size="25" value="" onChange="javascript:document.mainform.isUserfile.value = document.mainform.userfile.value" />
                </td>
            </tr>

            <tr>
                <td colspan="10" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">
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