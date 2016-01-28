<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form action="<?php echo site_url('/personnel/OverworkController/overworkModifyView');?>" method="post" enctype="multipart/form-data" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="10">
                    (<span style="color: red;">*</span> 为必填内容项目)
                    <b>
					[姓名：<?php echo $userInfoArray[$arr['operator']];?>]&nbsp;
					[填单日期：<?php echo date("Y-m-d",$arr['createTime']);?>]
                    </b>
                </td>
            </tr>

            <tr>
                <td><b>加班地点</b></td>
                <td><input type="text" name="addr" id="addr" value="<?php echo $arr['addr'];?>" /><span style="color:red">*</span></td>
            </tr>

            <tr>
                <td><b>工作内容</b></td>
                <td><textarea name="over_content" id="over_content" style="width:300px;" rows="2"><?php echo $arr['oContent'];?></textarea><span style="color:red">*</span></td>
            </tr>

            <tr>
                <td><b>加班时间</b></td>
                <td>
                    <input type="text" name="sTime" id="sTime"  value="<?php echo $arr['sTime'];?>" style="width:70px;"  onClick="WdatePicker()">
                    <select name="start_hour" id="start_hour" style="width:90px;">
                        <option>选择小时</option>
                        <?php foreach($getHours as $key=>$value):?>
                        <option value="<?php echo $value;?>" <?php if($value == $arr['start_hour']):?> selected<?php endif;?>><?php echo $value;?>点</option>
                        <?php endforeach;?>
                    </select>
                    至
                    <input type="text" name="eTime" id="eTime"  value="<?php echo $arr['eTime'];?>" style="width:70px;"  onClick="WdatePicker()">
                    <select name="end_hour" id="end_hour" style="width:90px;">
                        <option>选择小时</option>
                        <?php foreach($getHours as $key=>$value):?>
                        <option value="<?php echo $value;?>" <?php if($value == $arr['end_hour']):?>selected<?php endif;?>><?php echo $value;?>点</option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>

            <tr>
                <td><b>备注</b></td>
                <td><input type="text" name="overContent" id="overContent" value="<?php echo $arr['overContent'];?>" /></td>
            </tr>

            <tr>
                <td colspan="10" style="text-align:center;">
                    <input type="hidden" name="oId" id="oId" value="<?php echo $arr['oId'];?>" />
                    <input type="hidden" name="operator" id="operator" value="<?php echo $arr['operator'];?>" />
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