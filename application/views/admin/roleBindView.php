<script language="javascript">
function selectComCode(classId){
         $.ajax({
         	type:"post",
         	data:"parent=" + $('.all'+classId).val(),
         	url:"<?php echo $base_url;?>index.php/admin/UserController/getCompetence/0",
         	success:function(result)
         	{
                var codeArray = Array();
                codeArray = result.split('#');
                for(i=0;i<codeArray.length-1;i++){
                	if($(".all"+codeArray[i]).val() == codeArray[i]){
                	    if($(".all"+classId).attr('checked')=='checked'){
                		   $(".all"+codeArray[i]).attr('checked',true);
                		}else{
                		   $(".all"+codeArray[i]).attr('checked',false);
                		}
                	}
                }
         	}
         });
}

function selectOpera(classId){
    $.ajax({
       type:"post",
       data:"parent=" + $('.opera'+classId).val(),
       url:"<?php echo $base_url;?>index.php/admin/UserController/getCompetence/2",
       success:function(result)
       {
           var codeArray = Array();
           codeArray = result.split('#');
           for(i=0;i<codeArray.length-1;i++){
               if($(".opera"+codeArray[i]).val() == codeArray[i]){
                   if($(".opera"+classId).attr('checked')=='checked'){
                      $(".opera"+codeArray[i]).attr('checked',true);
                   }else{
                      $(".opera"+codeArray[i]).attr('checked',false);
                   }
               }
           }
       }
    });
}
</script>
<form class="form-horizontal form_validation_ttip" action="" method="post">
             <fieldset>
                 <div class="control-group formSep">
                     <label for="roleName" class="control-label">角色名称</label>
                     <div class="controls text_line">
                     <input type="text" name="roleName" class="input-xlarge" value="<?php echo $roleName; ?>" disabled />
                     </div>
                 </div>
				<div class="control-group">
					<label class="control-label">菜单权限分配</label>
					<div class="controls text_line">
					    <table cellspacing='1' id="list-table" class="table table-bordered">
					    <?php foreach($menuList as $key=>$value){
					    	echo $value['level']==1?"<tr><td width='18%' valign='top'>":"<div style='width:130px;float:left;'><label for='article_cat'>";
					    ?>
						<input type="checkbox" name="comCode[]" <?php if($value['level'] == 1){?>onclick="selectComCode(<?php echo $key?>)"<?php }?> class="all<?php echo $value['level']==1?$key:$value['comCode'];?>" value="<?php echo $value['comCode'];?>" <?php if(in_array($value['comCode'],$userRole)){echo "checked"; } ?>><?php echo $value['level']==1?"<font style='font-weight:bold'>".$value['comeName']."</font></td><td>":$value['comeName']."</label></div>";?>
						<?php
						   $k = ($key<count($menuList)-1)?$key+1:$key;
						   echo $menuList[$k]['level']==1?"</td></tr>":"";
						  } ?>
						</td></tr>
						</table>
					</div>
				</div>
				 <?php if(!empty($operaList)){ ?>
                 <div class="control-group formSep">
                      <label for="phone" class="control-label">操作权限分配</label>
                      <div class="controls">
                        <table cellspacing='1' class="table table-bordered">
                        <?php foreach($operaList as $key=>$value){
                            echo $value['level']==1?"<tr><td width='18%' valign='top'>":"<div style='width:130px;float:left;'><label for='article_cat'>";
                        ?>
                        <input type="checkbox" name="operaid[]" <?php if($value['level'] == 1){?>onclick="selectOpera(<?php echo $key?>)"<?php }?> class="opera<?php echo $value['level']==1?$key:$value['comCode'];?>" value="<?php echo $value['comCode'];?>" <?php if(in_array($value['comCode'],$userOpera)){echo "checked"; } ?>><?php echo $value['level']==1?"<font style='font-weight:bold'>".$value['comeName']."</font></td><td>":$value['comeName']."</label></div>";?>
                        <?
                           $ke = ($key<count($operaList)-1)?$key+1:$key;
                           echo $operaList[$ke]['level']==1?"</td></tr>":"";
                          } ?>
                        </td></tr>
                        </table>
                      </div>
                 </div>
                 <?php } ?>
			     <div class="control-group">
			          <div class="controls"><button class="btn btn-gebo" type="submit" name="submitCreate" value="分配">分配权限</button></div>
			     </div>
		    </fieldset>
</form>