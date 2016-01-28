<form class="form_validation_ttip" action="" method="post">
      <table id="smpl_tbl" class="table table-bordered table-striped">
            <tbody>
                 <tr>
                     <td width="20%">关联流程</td>
                     <td><?php echo $pNumber; ?></td>
                 </tr>
                 <tr>
                     <td width="20%">节点位置</td>
                     <td><select name="position" id="position" class="span2">
                                                    <option value="">--请选择--</option>
                                                    <option value="0" <?php echo $level==0?'selected':'' ?>>第一级审批前</option>
                                                    <option value="1" <?php echo $level==1?'selected':'' ?>>第二级审批前</option>
                                                    <option value="2" <?php echo $level==2?'selected':'' ?>>第三级审批前</option>
                                                    <option value="3" <?php echo $level==3?'selected':'' ?>>第四级审批前</option>
                                                    <option value="4" <?php echo $level==4?'selected':'' ?>>第五级审批前</option>
                                                    <option value="5" <?php echo $level==5?'selected':'' ?>>第六级审批前</option>
                                                    <option value="6" <?php echo $level==6?'selected':'' ?>>第七级审批前</option>
                                                    <option value="7" <?php echo $level==7?'selected':'' ?>>第八级审批前</option>
                                                    </select></td>
                 </tr>
                 <tr>
                     <td width="20%">审批人</td>
                     <td><input type="text" name="approve" value="<?php echo $uId; ?>" class="span2" size="10" /></td>
                 </tr>
                 <tr>
                     <td width="20%">关联组织架构</td>
                     <td><select name="orgId" class="span2">
			                         <option value="">--请选择--</option>
			                         <?php foreach($orgs as $value){ ?>
                                     <option value="<?php echo $value['sId']; ?>" style="<?php if($value['level']==1){echo 'font-weight:bold;color:black;';} ?>" <?php echo $sId==$value['sId']?'selected':'' ?>>
                                     <?php
						             for($i=1;$i<$value['level'];$i++)
						             {
							            echo "====";
						             }
						             ?><?php echo $value['name']; ?></option>
			                         <?php } ?>
			                         </select></td>
                 </tr>
                 <tr>
                     <td width="20%">限额</td>
                     <td><input type="text" name="limits" value="<?php echo $limits; ?>" class="span1" /></td>
                 </tr>
			     <tr>
			          <td colspan="2" style="text-align:center;">
			          <button class="btn btn-gebo" type="submit" name="submitCreate" value="修改">修改扩展流程</button></td>
			     </tr>
			</tbody>
	</table>
</form>