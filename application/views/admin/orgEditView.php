<script type="text/javascript">
    function upPhone(z)
    {
        var tel = /^((0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/;
        if(!tel.test(z))
        {
            alert('请输入有效的电话号码！');
            document.form1.mobile.focus();
            return false;
        }
    }
</script>
<div class="row-fluid">
    <div class="span8">
         <form class="form-horizontal form_validation_ttip" action="" method="post">
             <fieldset>
                 <div class="control-group formSep">
                     <label for="name" class="control-label">部门名称</label>
                     <div class="controls text_line">
                     <input type="text" name="name" class="input-xlarge" value="<?php echo $name; ?>" />
                     </div>
                 </div>
                 <div class="control-group formSep">
                      <label for="parentId" class="control-label">归属部门</label>
                      <div class="controls">
                      <select name="parentId" id="parentId">
				  		   <option value="">上级</option>
						   <?php foreach($org as $val){ ?>
				  		   <option value="<?php echo $val['sId'];?>" <?php if($val['sId']==$parentId) echo 'selected="selected"';?> style="<?php if($val['level']==1){echo 'font-weight:bold;color:black;';}elseif($val['level']==2){echo 'font-weight:bold;color:green;';} ?>">
						   <?php
						   for($i=1;$i<$val['level'];$i++)
						   {
							  echo "====";
						   }
						   ?><?php echo $val['name']?></option>
						  <?php }?>
						  </select>
                      </div>
                 </div>
                 <div class="control-group formSep">
                     <label for="name" class="control-label">电话号码</label>
                     <div class="controls text_line">
                     <input type="text" name="phoneNumber" class="input-xlarge" value="<?php echo $phoneNumber; ?>" onchange="upPhone(this.value)"/><span style="color:#F00;">*电话号码格式:</span>0551-65678923
                     </div>
                 </div>
                 <div class="control-group formSep">
                     <label for="weight" class="control-label">权重</label>
                     <div class="controls text_line">
                     <input type="text" name="weight" class="span2" value="<?php echo $weight; ?>" />
                     </div>
                 </div>
			     <div class="control-group">
			          <div class="controls"><button class="btn btn-gebo" type="submit" name="submitCreate" value="修改">修改部门</button></div>
			     </div>
		    </fieldset>
		</form>
	</div>
</div>