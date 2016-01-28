<script type="text/javascript">
function upperPhone(p){
	var phone = /^(((13[0-9]{1})|159|153|158|157|156|150|152|151)+\d{8})$/;
        if(!phone.test(p))
        {
            alert('请输入有效的手机号码！');
            document.form1.mobile.focus();
            return false;
        }
}
</script>

<?php echo $public_view_js;?>
<form method="post" action="<?php echo $act; ?>" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
        <div id="m_tagsItem" style="display:none">
            <div id="tagClose">关闭</div>
            <p><font id="dvelopersInfo"></font></p>
        </div>
        <!--副标题-->
        <tr>
            <td class="bold"><?php echo $status==1?'影城':'客户';?>名称</td>
            <td colspan="7"><?php echo $name['name'];?></td>
        </tr>
        <tr>
            <td class="bold">姓名</td>
            <td>
                <input type="text" placeholder="" class="span2" name="telName" id="telName" value="<?php echo $info['telName'];?>" ></td>
            <td class="bold">号码</td>
            <td>
                <input type="text" placeholder="" class="span2" name="telNumber" id="telNumber" value="<?php echo $info['telNumber'];?>" onchange="upperPhone(this.value)"></td>
            <td class="bold">职位</td>
            <td><input type="text" placeholder="" class="span2" name="telPosition" id="telPosition" value="<?php echo $info['telPosition'];?>"  ></td>
            <td class="bold">性别</td>
            <td>
                <select name="sex" id="sex" class="span1">
                    <option value="1" <?php if($info['sex'] == '1'):?> selected<?php endif;?>>男</option>
                    <option value="2" <?php if($info['sex'] == '2'):?> selected<?php endif;?>>女</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="bold">生日</td>
            <td><input type="text" placeholder="" class="span2" name="birthday" id="birthday" value="<?php echo $info['birthday'];?>"  ></td>
            <td class="bold">属相</td>
            <td><select name="zodiac" id="zodiac" class="span1">
                    <?php foreach($CustomerArray['zodiac'] as $key=>$val):?>
                        <?php if(in_array($key,$info)):?>
                    <option value="<?php echo $key;?>" <?php if($key == $info['zodiac']):?> selected="selected"<?php endif;?>><?php echo $val;?></option>
                        <?php else:?>
                    <option value="<?php echo $key;?>"><?php echo $val;?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select></td>
            <td class="bold">星座</td>
            <td>
                <select name="constellatory" id="constellatory" class="span2">
                    <?php foreach($CustomerArray['constellatory'] as $key=>$val):?>
                        <?php if(in_array($key,$info)):?>
                    <option value="<?php echo $key;?>" <?php if($key == $info['constellatory']):?> selected="selected"<?php endif;?>><?php echo $val;?></option>
                        <?php else:?>
                    <option value="<?php echo $key;?>"><?php echo $val;?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
            </td>
            <td class="bold">血型</td>
            <td>
                <select name="bloodType" id="bloodType" class="span1">
                    <?php foreach($CustomerArray['bloodType'] as $key=>$val):?>
                        <?php if(in_array($key,$info)):?>
                    <option value="<?php echo $key;?>" <?php if($key == $info['bloodType']):?> selected="selected"<?php endif;?>><?php echo $val;?></option>
                        <?php else:?>
                    <option value="<?php echo $key;?>"><?php echo $val;?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="bold">籍贯</td>
            <td><input type="text" placeholder="" class="span2" name="nativePlace" id="nativePlace" value="<?php echo $info['nativePlace'];?>" ></td>
            <td class="bold">毕业院校</td>
            <td><input type="text" placeholder="" class="span2" name="academy" id="academy" value="<?php echo $info['academy'];?>" ></td>
            <td class="bold">备注</td>
            <td colspan="3"><input type="text" placeholder="" class="span3" name="hobby" id="hobby" value="<?php echo $info['hobby'];?>" ></td>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="8" style="text-align:center;">
                <input type="hidden" name="id" value="<?php echo $info['id'];?>" />
                <input type="hidden" name="cId" value="<?php echo $info['cId']?>" />
                <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">修改内容</button>
                <button type="reset" class="btn">重置</button>
            </td>
        </tr>
        </tbody>
    </table>
</form>
