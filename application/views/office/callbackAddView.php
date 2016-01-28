<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#type").val() == ''){
                alert('回收类型不能为空！'); $("#type").focus();
                return false;
            }
            if($("#tId").val() == ''){
                alert('回收票种不能为空！'); $("#tId").focus();
                return false;
            }
            if($("#type").val() == 1 && $("#name").val() == ''){
                alert('回收影城不能为空！'); $("#name").focus();
                return false;
            }
            if($("#type").val() == 2 && $("#department").val() == ''){
                alert('业务员不能为空！'); $("#department").focus();
                return false;
            }
            if($("#callbackDate").val() == ''){
                alert('回收时间不能为空！'); $("#callbackDate").focus();
                return false;
            }
            if($("#callbackNum").val() == ''){
                alert('回收数量不能为空！'); $("#callbackNum").focus();
                return false;
            }
    });

    $("#type").change(function(){
        if($(this).val() == 1){
            $("#client_arg").css('display','');
            $("#salesman_arg").css('display','none');
        }else if($(this).val() == 2){
        	$("#client_arg").css('display','none');
        	$("#salesman_arg").css('display','');
        }else{
        	$("#client_arg").css('display','none');
        	$("#salesman_arg").css('display','none');
        }
	});

    $("#department").change(function(){
        if($(this).val()!='')
        {
            $("#receiveId").css('display','');
            $("#receiveId").empty();
            $("#receiveId").append('<option value=>姓名</option>');
            $.ajax({
                type:"post",
                data: "orgid=" + $(this).val(),
                url:"<?php echo $base_url;?>index.php/admin/UserController/getDepUser",
                success: function(result)
                {
                    $("#receiveId").append(result);
                }
            });

        }
    })
})
</script>
<form action="" method="post" id="mainform" name="mainform" class="form_validation_ttip" novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%"><b>回收类型</b></td>
                <td>
                    <select name="type" id="type">
                         <option value="">-请选择-</option>
                         <option value="1">影城票务回收</option>
                         <option value="2">个人票务回收</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><b>回收票种</b></td>
                <td>
                    <select name="tId" id="tId">
                         <option value="">-请选择-</option>
                         <?php foreach($toolsList as $k=>$v){?>
                         <option value="<?php echo $v['tId'];?>"><?php echo $v['name'];?></option>
                         <?php } ?>
                    </select>
                </td>
            </tr>

            <tr id="client_arg" style="display:none">
                <td><b>回收影城</b></td>
                <td><input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo('<?php echo $base_url;?>index.php','/media/StudioController/getStudioInfo','name')"></td>
                <div id="m_tagsItem" style="display:none"><div id="tagClose">关闭</div><p><font id="dvelopersInfo"></font></p></div>
            </tr>
            
            <tr id="salesman_arg" style="display:none">
                <td><span class="bold">业务员</span></td>
                <td>
                    <select name="department" id="department">
                           <option value="">--请选择--</option>
                           <?php foreach($org as $val){ ?>
                           <option value="<?php echo $val['sId'];?>" style="<?php if($val['level']==1){echo 'font-weight:bold;color:black;';} ?>" <?php echo $val['sId']==$dep[0]['sId']?'selected':''; ?>>
                           <?php
                           for($i=1;$i<$val['level'];$i++){
                              echo "====";
                           }
                           ?><?php echo $val['name'];?></option>
                          <?php }?>
                    </select>&nbsp;--&nbsp;
                    <select name="receiveId" id="receiveId" class="span1">
                    <?php foreach($uIdArr as $value){ ?>
                    <option value="<?php echo $value['uId']; ?>"><?php echo $value['name']; ?></option>
                    <?php } ?>
                    </select>
                 </td>
            </tr>
            
            <tr>
                <td><b>回收时间</b></td>
                <td><input type="text" name="callbackDate" id="callbackDate" style="width:90px" onClick="WdatePicker({dateFmt:'yyyy MM'})"></td>
            </tr>
            
            <tr>
                <td><b>回收数量</b></td>
                <td><input type="text" name="callbackNum" id="callbackNum" class="span1"></td>
            </tr>
            
            <tr>
                <td><b>合计金额</b></td>
                <td><input type="text" name="totalPrice" id="totalPrice" class="span1">&nbsp;元</td>
            </tr>
            
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">
						提交内容
                    </button>
                    <button type="reset" class="btn">
						重置
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</form>