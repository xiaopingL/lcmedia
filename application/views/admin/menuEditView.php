<div class="row-fluid">
    <div class="span8">
         <form class="form-horizontal form_validation_ttip" action="" method="post">
             <fieldset>
                 <div class="control-group formSep">
                     <label for="nickname" class="control-label">权限名称</label>
                     <div class="controls text_line">
                     <input type="text" name="comeName" class="input-xlarge" value="<?php echo $comeName; ?>" />
                     </div>
                 </div>
                 <div class="control-group formSep">
                      <label for="password" class="control-label">权限代码</label>
                      <div class="controls">
                      <input type="text" name="comCode" class="input-xlarge" value="<?php echo $comCode; ?>" disabled />
                      </div>
                 </div>
                 <?php if(empty($isDel)){?>
                 <div class="control-group formSep">
                      <label for="codeUrl" class="control-label">菜单URl</label>
                      <div class="controls">
                      <input type="text" name="codeUrl" class="input-xlarge" value="<?php echo $codeUrl; ?>" />&nbsp;<font color=red>*（顶级请填写#）</font>
                      </div>
                 </div>
                 <?php } ?>
                 <div class="control-group formSep">
                      <label for="parent" class="control-label">父级菜单</label>
                      <div class="controls">
                      <select name="parent" id="parent">
                           <?php if($level == 1){ ?>
				  		   <option value="">顶级</option>
						   <?php
						   }
						   if($level != 1){
						   foreach($menu as $val){ ?>
				  		   <option value="<?php echo $val['comCode'];?>" <?php if($val['comCode']==$parent) echo 'selected="selected"';?>>
						   <?php
						   for($i=1;$i<$val['level'];$i++)
						   {
							  echo "===";
						   }
						   ?><?php echo $val['comeName'];?></option>
						  <?php }}?>
						  </select>
                      </div>
                 </div>
                 <?php if(empty($isDel)){?>
                 <div class="control-group">
					<label class="control-label">权重</label>
					<div class="controls text_line">
						<input type="text" name="weight" value="<?php echo $weight; ?>" class="span4" />
					</div>
				</div>
				<?php } ?>
				<div class="control-group">
					<label class="control-label">权限描述</label>
					<div class="controls text_line">
						<textarea name="description" id="description" cols="1" rows="3" class="ckeditor"><?php echo $description; ?></textarea>
					</div>
				</div>
			     <div class="control-group">
			          <div class="controls"><button class="btn btn-gebo" type="submit" name="submitCreate" value="修改">修改权限</button></div>
			     </div>
		    </fieldset>
		</form>
	</div>
</div>