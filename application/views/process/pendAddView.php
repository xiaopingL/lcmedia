<form class="form_validation_ttip" action="" method="post">
      <table id="smpl_tbl" class="table table-bordered table-striped">
            <tbody>
                 <tr>
                     <td>主表表名</td>
                     <td><input type="text" name="proTable" class="input-xlarge" value="" /></td>
                 </tr>
                 <tr>
                     <td>事项类型</td>
                     <td><input type="text" name="pendingType" class="input-xlarge" value="" /></td>
                 </tr>
                 <tr>
                     <td>url地址</td>
                     <td><input type="text" name="urlAdress" class="input-xlarge" value="" /></td>
                 </tr>
                 <tr>
                     <td>指派流程</td>
                     <td><select name="pNumber[]" id="pNumber" multiple="multiple" style="width:280px;height:150px">
                         <!--<option value="">--请选择--</option>-->
                         <?php foreach($process as $value){ ?>
                         <option value="<?php echo $value['pNumber']; ?>"><?php echo $value['processName']; ?></option>
                         <?php } ?>
                         </select></td>
                 </tr>
			     <tr>
			          <td colspan="2" style="text-align:center;">
			          <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加">添加处理事项</button>&nbsp;
			          <button class="btn" type="reset">重置</button></td>
			     </tr>
			</tbody>
	</table>
</form>