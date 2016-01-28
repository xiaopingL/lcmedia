<script language="javascript">
    $(function(){
        if($(".isInherit:checked").val()==1){
            $("#role").css('display','');
            $("#menu").css('display','none');
            $("#opera").css('display','none');
        }else{
            $("#role").css('display','none');
            $("#menu").css('display','');
            $("#opera").css('display','');
        }

        $(".isInherit").click(function(){
            if($(this).val() == 1){
                $("#role").css('display','');
                $("#menu").css('display','none');
                $("#opera").css('display','none');
            }else{
                $("#role").css('display','none');
                $("#menu").css('display','');
                $("#opera").css('display','');
            }
        })
    })

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
            <label for="userName" class="control-label">用户名</label>
            <div class="controls text_line">
                <input type="text" name="userName" class="input-xlarge" value="<?php echo $userName; ?>" />
            </div>
        </div>
        <div class="control-group formSep">
            <label for="pwd" class="control-label">密 码</label>
            <div class="controls">
                <input type="password" name="pwd" class="input-xlarge" value="" />&nbsp;<font color=red>*（留空表示不对密码修改）</font>
            </div>
        </div>
        <div class="control-group formSep">
            <label for="phone" class="control-label">岗位级别</label>
            <div class="controls">
                <?php foreach($position as $key=>$value) { ?>
                <label class="radio inline"><input type="radio" value="<?php echo $key; ?>" name="jobId" <?php echo $key==$jobId?'checked':''; ?> /><?php echo $value; ?></label>
                    <?php } ?>
            </div>
        </div>
        <div class="control-group formSep">
            <label for="phone" class="control-label">归属组织</label>
            <div class="controls">
                <select name="sId[]" id="sId" multiple="multiple" style="width:280px;height:200px">
                    <option value="">--请选择--</option>
                    <?php foreach($org as $val) { ?>
                    <option value="<?php echo $val['sId'];?>" <?php echo $val['sId']==$val['orgId']?'selected':''; ?> style="<?php if($val['level']==1) {
                            echo 'font-weight:bold;color:black;';
                        }elseif($val['level']==2) {
                            echo 'font-weight:bold;color:green;';
                                } ?>">
                                    <?php
                                    for($i=1;$i<$val['level'];$i++) {
                                        echo "====";
                                    }
                            ?><?php echo $val['name'];?></option>
                        <?php }?>
                </select>&nbsp;<span style="color:#FF0000">*（按Ctrl键多选）</span>
            </div>
        </div>
        <div class="control-group formSep">
            <label for="phone" class="control-label">归属站点</label>
            <div class="controls">
                <?php foreach($site as $value) {  ?>
                <input type="checkbox" name="siteId[]" value="<?php echo $value['siteId']?>" <?php echo $value['siteId']==$value['sitd']?'checked':''; ?>><?php echo $value['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;
                    <? } ?>
            </div>
        </div>
        
        <div class="control-group formSep">
            <label for="qq" class="control-label">继承角色权限</label>
            <div class="controls">
                <label class="radio inline"><input type="radio" value="1"  name="isInherit" class="isInherit" <?php echo $isInherit==1?'checked':''; ?> />开启</label>
                <label class="radio inline"><input type="radio" value="0" name="isInherit"class="isInherit" <?php echo $isInherit==0?'checked':''; ?> />关闭</label>
            </div>
        </div>
        <div class="control-group formSep" id="role">
            <label for="qq" class="control-label">角色组分配</label>
            <div class="controls">
                <select name="roreId" id="roreId" class="span2">
                    <option value="">--请选择--</option>
                    <?php foreach($role as $value) {  ?>
                    <option value="<?php echo $value['roreId'];?>" <?php echo $roleId==$value['roreId']?'selected':''; ?>><?php echo $value['roleName'];?></option>
                        <?php } ?>
                </select>
            </div>
        </div>
        <div class="control-group" style="display:none;" id="menu">
            <label class="control-label">菜单权限分配</label>
            <div class="controls text_line">
                <table cellspacing='1' class="table table-bordered">
                    <tr>
                        <td>
                    <?php foreach($menu as $key=>$value) {
                        echo $value['level']==1?"<tr><td width='18%' valign='top'>":"<div style='width:130px;float:left;'><label for='article_cat'>";
                        ?>
                    <input type="checkbox" name="comCode[]" <?php if($value['level'] == 1) {?>onclick="selectComCode(<?php echo $key?>)"<?php }?> class="all<?php echo $value['level']==1?$key:$value['comCode'];?>" value="<?php echo $value['comCode'];?>" <?php echo $value['comCode']==$value['codeId']?'checked':''; ?>><?php echo $value['level']==1?"<font style='font-weight:bold'>".$value['comeName']."</font></td><td>":$value['comeName']."</label></div>";?>
                        <?
                        $k = ($key<count($menu)-1)?$key+1:$key;
                        echo $menu[$k]['level']==1?"</td></tr>":"";
                    } ?>
                       </td>
                   </tr>
                </table>
            </div>
        </div>
        <?php if(!empty($opera)) { ?>
        <div class="control-group formSep" id="opera">
            <label for="phone" class="control-label">操作权限分配</label>
            <div class="controls">
                <table cellspacing='1' class="table table-bordered">
                    <tr>
                        <td>
                        <?php foreach($opera as $key=>$value) {
                            echo $value['level']==1?"<tr><td width='18%' valign='top'>":"<div style='width:130px;float:left;'><label for='article_cat'>";
                            ?>
                    <input type="checkbox" name="operaid[]" <?php if($value['level'] == 1) {?>onclick="selectOpera(<?php echo $key?>)"<?php }?> class="opera<?php echo $value['level']==1?$key:$value['comCode'];?>" value="<?php echo $value['comCode'];?>" <?php echo $value['comCode']==$value['operaid']?'checked':''; ?>><?php echo $value['level']==1?"<font style='font-weight:bold'>".$value['comeName']."</font></td><td>":$value['comeName']."</label></div>";?>
                            <?
                            $ke = ($key<count($opera)-1)?$key+1:$key;
                            echo $opera[$ke]['level']==1?"</td></tr>":"";
                        } ?>
                    </td></tr>
                </table>
            </div>
        </div>
        <?php } ?>
        <div class="control-group formSep">
            <label for="qq" class="control-label">禁用设置</label>
            <div class="controls">
                <label class="radio inline"><input type="radio" value="0"  name="isDisabled" class="isDisabled" <?php echo $isDisabled==0?'checked':''; ?> />正常</label>
                <label class="radio inline"><input type="radio" value="1" name="isDisabled"class="isDisabled" <?php echo $isDisabled==1?'checked':''; ?> />禁用</label>
            </div>
        </div>
        <div class="control-group">
            <div class="controls"><button class="btn btn-gebo" type="submit" name="submitCreate" value="修改">修改用户</button></div>
        </div>

    </fieldset>
</form>