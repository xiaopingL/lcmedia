<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form action="<?php echo site_url('/personnel/FalsesignController/falsesignInsert');?>" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
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
                <td width="10%"><b>误打卡事由</b></td>
                <td><textarea name="causef" id="causef" style="width:300px;" rows="2"></textarea>&nbsp;&nbsp;&nbsp;<span style="color:red">*</span></td>
            </tr>



            <tr>
                <td><b>误打卡时间</b></td>
                <td>
                    <input type="text" name="startDatet" id="startDatet" style="width:70px;" value="<?php echo date("Y-m-d");?>"  onClick="WdatePicker()">
                    <select name="typef" id="typef" style="width:70px;">
                        <option value="">选择</option>
                        <?php foreach($falsesignType as $key=>$val):?>
                            <option value="<?php echo $key;?>" <?php if($key == '1'):?> selected="selected"<?php endif;?>><?php echo $val;?></option>
                        <?php endforeach;?>
                    </select>&nbsp;&nbsp;<span style="color:red">*</span>
                </td>
            </tr>
            <tr>
                <td><b>备注</b></td>
                <td><span style="color:red;">误打卡申请单可当天或提前一天申请，最迟申请时间截至误打卡发生之后次日24点。</span></td>
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