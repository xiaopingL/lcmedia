<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#industry").val() == ''){
                alert('所属行业不能为空！'); $("#industry").focus();
                return false;
            }
    });
   
})
</script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%" style="vertical-align: middle;text-align: center;font-weight: bold;">站点</td>
                <td width="85%" style="vertical-align: middle;">
                    <select name="siteId" id="siteId" style="width:100px;">
                   <?php foreach($siteId as $key => $value):?>
                      <?php foreach($siteIdArray as $v):?>
                         <?php if($value['siteId'] == $v):?>
                            <option value="<?php echo $value['siteId']?>" ><?php echo $value['name']?></option>
                        <?php endif;?>
                     <?php endforeach;?>
                  <?php endforeach;?>
                 </select>
                </td>
		    </tr>
		    
            <tr>
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">客户级别</td>
                <td style="vertical-align: middle;">
                    <select name="level" id="level" style="width:100px;">
                     <?php foreach ($customer['Level'] as $key => $value):?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                     <?php endforeach;?>
                   </select>
                </td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle; text-align: center; font-weight: bold;">客户来源</td>
                <td style="vertical-align: middle;">
                    <select name="source" id="source">
                    <?php foreach ($customer['Source'] as $key => $value):?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
		    
            <tr>
                <td style="vertical-align: middle;text-align:center;font-weight: bold;">客户名称</td>
                <td style="vertical-align: middle;"><input type="text" name="name" id="name" value=""></td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle;text-align:center;font-weight: bold;">公司名称</td>
                <td style="vertical-align: middle;"><input type="text" name="proname" id="proname" value=""></td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle;text-align:center;font-weight: bold;">所属行业</td>
                <td style="vertical-align: middle;">
                    <select name="industry" id="industry">
                    <option value="">-请选择行业-</option>
                    <?php foreach ($customer['industry'] as $key => $value):?>
                        <option value="<?php echo $key?>"><?php echo $value?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle;text-align: center;font-weight: bold;">办公地址</td>
                <td style="vertical-align: middle;"><input type="text" name="address" id="address" value="" class="span3"></td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle;text-align:center;font-weight: bold;">对接人</td>
                <td style="vertical-align: middle;"><input type="text" name="dockName" id="dockName" value="<?php echo $detail['dockName']?>" class="span1"></td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle;text-align:center;font-weight: bold;">职务</td>
                <td style="vertical-align: middle;"><input type="text" name="position" id="position" value="<?php echo $detail['position']?>"></td>
            </tr>
            
            <tr>
                <td style="vertical-align: middle;text-align:center;font-weight: bold;">联系方式</td>
                <td style="vertical-align: middle;"><input type="text" name="clientPhone" id="clientPhone" value=""></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
