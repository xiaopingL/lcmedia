<script language="javascript">
$(function(){
    $("#type").change(function(){
       if($(this).val() == 2){
           $("#menu_url").css('display','none');
           $("#menu_weight").css('display','none');
       }else{
           $("#menu_url").css('display','');
           $("#menu_weight").css('display','');
       }
    })

    $("#mainform").submit(function(){
        if($("#type").val() == 2){
            if($("#parent").val() == ''){
                alert('父级菜单不能为顶级！');
                $("#parent").focus();
                return false;
            }
        }
    })
})
</script>
<div class="row-fluid">
    <div class="span8">
         <form class="form-horizontal form_validation_ttip" action="" method="post" id="mainform">
             <fieldset>
                 <div class="control-group formSep">
                     <label for="comeName" class="control-label">权限类型</label>
                     <div class="controls text_line">
                     <select name="type" id="type">
                            <option value="1">菜单权限</option>
                            <option value="2">操作权限</option>
                     </select>
                     </div>
                 </div>
                 <div class="control-group formSep">
                     <label for="comeName" class="control-label">权限名称</label>
                     <div class="controls text_line">
                     <input type="text" name="comeName" class="input-xlarge" value="" />
                     </div>
                 </div>
                 <div class="control-group formSep">
                      <label for="comCode" class="control-label">权限代码</label>
                      <div class="controls">
                      <input type="text" name="comCode" class="input-xlarge" value="" />
                      </div>
                 </div>
                 <div class="control-group formSep" id="menu_url">
                      <label for="codeUrl" class="control-label">菜单URl</label>
                      <div class="controls">
                      <input type="text" name="codeUrl" class="input-xlarge" value="" />&nbsp;<font color=red>*（顶级请填写#）</font>
                      </div>
                 </div>
                 <div class="control-group formSep">
                      <label for="parent" class="control-label">父级菜单</label>
                      <div class="controls">
                      <select name="parent" id="parent">
				  		   <option value="">顶级</option>
						   <?php foreach($menu as $val){ ?>
				  		   <option value="<?php echo $val['comCode'];?>">
						   <?php
						   for($i=1;$i<$val['level'];$i++)
						   {
							  echo "===";
						   }
						   ?><?php echo $val['comeName'];?></option>
						  <?php }?>
						  </select>
                      </div>
                 </div>
				<div class="control-group" id="menu_weight">
					<label class="control-label">权重</label>
					<div class="controls text_line">
						<input type="text" name="weight" value="" class="span4" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">权限描述</label>
					<div class="controls text_line">
						<textarea name="description" id="description" cols="1" rows="3"   class="ckeditor" ></textarea>
					</div>
				</div>
			     <div class="control-group">
			          <div class="controls"><button class="btn btn-gebo" type="submit" name="submitCreate" value="添加">添加菜单</button></div>
			     </div>
		    </fieldset>
		</form>
	</div>
</div>