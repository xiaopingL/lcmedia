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
<form method="post" action="<?php echo $act;?>" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <div id="m_tagsItem" style="display:none">
            <div id="tagClose">关闭</div>
            <p><font id="dvelopersInfo"></font></p>
        </div>
            <!--副标题-->
            <tr>
                <td><?php echo $status==1?'影城':'客户';?>名称</td>
                <td><?php echo $name;?></td>
                <td></td>
                <td colspan="5"><a href="javascript:void(0)" onClick="contactApend()">新增联系人</a></td>
            </tr>
            <tr>
              <td>姓名</td>
              <td>
                  <input type="text" placeholder="" class="span2" name="telName[]" id="telName[]"  ></td>
              <td>手机号码</td>
              <td>
                  <input type="text" placeholder="" class="span2" name="telNumber[]" id="telNumber[]" onchange="upperPhone(this.value)"></td>
              <td>职位</td>
              <td><input type="text" placeholder="" class="span2" name="telPosition[]" id="telPosition[]"  ></td>
              <td>性别</td>
              <td>
                  <select name="sex[]" id="sex[]" class="span1">
                  <option value="1">男</option>
                  <option value="2">女</option>
              </select></td>
            </tr>
            <tr>
              <td>生日</td>
              <td><input type="text" placeholder="" class="span2" name="birthday[]" id="birthday[]"  ></td>
              <td>属相</td>
              <td><select name="zodiac[]" id="zodiac[]" class="span1">
                  <?php foreach($CustomerArray['zodiac'] as $key=>$val){?>
                      <option value="<?php echo $key;?>"><?php echo $val;?></option>
                  <?php }?>
              </select></td>
              <td>星座</td>
              <td>
                  <select name="constellatory[]" id="constellatory[]" class="span2">
                  <?php foreach($CustomerArray['constellatory'] as $key=>$val){?>
                      <option value="<?php echo $key;?>"><?php echo $val;?></option>
                  <?php }?>
              </select>
              </td>
              <td>血型</td>
              <td>
                   <select name="bloodType[]" id="bloodType[]" class="span1">
                 <?php foreach($CustomerArray['bloodType'] as $key=>$val){?>
                      <option value="<?php echo $key;?>"><?php echo $val;?></option>
                  <?php }?>
              </select>
              </td>
            </tr>
            <tr>
              <td>籍贯</td>
              <td><input type="text" placeholder="" class="span2" name="nativePlace[]" id="nativePlace[]"  ></td>
              <td>毕业院校</td>
              <td><input type="text" placeholder="" class="span2" name="academy[]" id="academy[]"  ></td>
              <td>备注</td>
              <td colspan="3"><input type="text" placeholder="" class="span3" name="hobby[]" id="hobby[]"  ></td>
            </tr>
            <tr><td colspan="8"></td></tr>

            <?php for($i=2;$i<=6;$i++){?>
            <tr id="contact1_<?php echo $i;?>" style="display: none;">
              <td>姓名</td>
              <td>
                  <input type="text" placeholder="" class="span2" name="telName[]" id="telName[]"></td>
              <td>手机号码</td>
              <td>
                  <input type="text" placeholder="" class="span2" name="telNumber[]" id="telNumber[]" onchange="upperPhone(this.value)"></td>
              <td>职位</td>
              <td><input type="text" placeholder="" class="span2" name="telPosition[]" id="telPosition[]"></td>
              <td>性别</td>
              <td>
                  <select name="sex[]" id="sex[]" class="span1">
                  <option value="1">男</option>
                  <option value="2">女</option>
              </select></td>
            </tr>
            <tr id="contact2_<?php echo $i;?>" style="display: none;">
              <td>生日</td>
              <td><input type="text" placeholder="" class="span2" name="birthday[]" id="birthday[]"  ></td>
              <td>属相</td>
              <td><select name="zodiac[]" id="zodiac[]" class="span1">
                  <option value="1">鼠</option>
                  <option value="2">牛</option>
                  <option value="3">虎</option>
                  <option value="4">兔</option>
                  <option value="5">龙</option>
                  <option value="6">蛇</option>
                  <option value="7">马</option>
                  <option value="8">羊</option>
                  <option value="9">猴</option>
                  <option value="10">鸡</option>
                  <option value="11">狗</option>
                  <option value="12">猪</option>
              </select></td>
              <td>星座</td>
              <td>
                  <select name="constellatory[]" id="constellatory[]" class="span2">
                  <option value="1">水瓶座1月20-2月18号</option>
                  <option value="2">双鱼座2月19-3月20号</option>
                  <option value="3">白羊座3月20-4月19号</option>
                  <option value="4">金牛座4月20-5月20号</option>
                  <option value="5">双子座5月21-6月21号</option>
                  <option value="6">巨蟹座6月22-7月22号</option>
                  <option value="7">狮子座7月23-8月22号</option>
                  <option value="8">处女座8月23-9月22号</option>
                  <option value="9">天平座9月23-10月23号</option>
                  <option value="10">天蝎座10月24-11月22号</option>
                  <option value="11">射手座11月23-12月21号</option>
                  <option value="12">魔蝎座12月22-1月19号</option>
              </select>
              </td>
              <td>血型</td>
              <td>
                   <select name="bloodType[]" id="bloodType[]" class="span1">
                  <option value="1">A型</option>
                  <option value="2">B型</option>
                  <option value="3">OB型</option>
                  <option value="4">AB型</option>
              </select>
              </td>
            </tr>
            <tr id="contact3_<?php echo $i;?>" style="display: none;">
              <td>籍贯</td>
              <td><input type="text" placeholder="" class="span2" name="nativePlace[]" id="nativePlace[]"></td>
              <td>毕业院校</td>
              <td><input type="text" placeholder="" class="span2" name="academy[]" id="academy[]"></td>
              <td>备注</td>
              <td colspan="3"><input type="text" placeholder="" class="span3" name="hobby[]" id="hobby[]"></td>
            </tr>
            <?php }?>

            <tr>
                <td colspan="8" style="text-align:center;">
                    <input type="hidden" name="contact" id="contact" value="2">
                    <input type="hidden" name="cId" id="cId" value="<?php echo $cIdStr;?>">
                    <button class="btn btn-gebo" type="submit" style="margin-right: 20px;">保存内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<?php if(!empty($info)){?>
<table class="table table-bordered table-striped">
	<tr>
	    <td><strong>客户联系人明细</strong></td>
	</tr>

    <tr>
        <td>
		<?php foreach($info as $key=> $value):?>
		<table class="table table-bordered table-striped" id="smpl_tbl">
		    <tr>
		        <td class="bold">姓名</td>
		        <td>
		            <?php echo $value['telName'];?></td>
		        <td class="bold">号码</td>
		        <td>
		            <?php echo $value['telNumber'];?></td>
		        <td class="bold">职位</td>
		        <td>
		            <?php echo $value['telPosition'];?></td>
		        <td class="bold">性别</td>
		        <td>
		            <?php if($value['sex']==1){echo '男';}else{echo '女';}?>
		        </td>
		    </tr>
		    <tr>
		        <td class="bold">生日</td>
		        <td>
		            <?php echo $value['birthday'];?></td>
		        <td class="bold">属相</td>
		        <td>
		        	<?php foreach($value['CustomerArray']['zodiac'] as $key => $val):?>
		        		<?php if($value['zodiac'] == $key):?>
		        		<?php echo $val;?>
		        		<?php else:?>
		        		<?php endif;?>
		        	<?php endforeach;?>
		
		        </td>
		        <td class="bold">星座</td>
		        <td>
					<?php foreach($value['CustomerArray']['constellatory'] as $key => $val):?>
		        		<?php if($value['constellatory'] == $key):?>
		        		<?php echo $val;?>
		        		<?php else:?>
		        		<?php endif;?>
		        	<?php endforeach;?>
		        </td>
		        <td class="bold">血型</td>
		        <td>
					<?php foreach($value['CustomerArray']['bloodType'] as $key => $val):?>
		        		<?php if($value['bloodType'] == $key):?>
		        		<?php echo $val;?>
		        		<?php else:?>
		        		<?php endif;?>
		        	<?php endforeach;?>
		        </td>
		    </tr>
		    <tr>
		        <td class="bold">籍贯</td>
		        <td>
		            <?php echo $value['nativePlace'];?></td>
		        <td class="bold">毕业院校</td>
		        <td>
		            <?php echo $value['academy'];?></td>
		        <td class="bold">备注</td>
		        <td colspan="3">
		            <?php echo $value['hobby'];?></td>
		    </tr>
		    <tr>
		        <td colspan="8"></td>
		    </tr>
		</table>
		<?php endforeach;?>
        </td>
    </tr>
</table>
<?php } ?>        
