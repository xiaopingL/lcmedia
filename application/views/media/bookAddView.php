<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $public_view_js;?>
<script language="javascript">
$(function(){
    $("#mainform").submit(function(){
            if($("#nature").val() == ''){
                alert('活动性质不能为空！'); $("#nature").focus();
                return false;
            }
            if($("#studioId").val() == ''){
                alert('执行影院不能为空！'); $("#studioId").focus();
                return false;
            }
            if($("#film_type").val() == ''){
                alert('影片类型不能为空！'); $("#film_type").focus();
                return false;
            }
            if($("#film_name").val() == ''){
                alert('片名不能为空！'); $("#film_name").focus();
                return false;
            }
            if($("#hallNumber").val() == ''){
                alert('厅号不能为空！'); $("#hallNumber").focus();
                return false;
            }
            if($("#follow_date").val() == ''){
                alert('执行时间不能为空！'); $("#follow_date").focus();
                return false;
            }
            if($("#person_num").val() == ''){
                alert('人数不能为空！'); $("#person_num").focus();
                return false;
            }
            if($("#film_price").val() == ''){
                alert('执行票价不能为空！'); $("#film_price").focus();
                return false;
            }
            if($("#demand_price").val() == ''){
                alert('卖品需求不能为空！'); $("#demand_price").focus();
                return false;
            }
            if($("#demand_num").val() == ''){
                alert('卖品份数不能为空！'); $("#demand_num").focus();
                return false;
            }
    });

    $("#nature").change(function(){
            if($(this).val() == 3 || $(this).val() == ''){
                $("#showContract").css('display','none');
            }else{
            	$("#showContract").css('display','');
            }
    })
})

function countOffer(){
    var offer1 = $("#offer1").val();
    var offer2 = $("#offer2").val();
    var offer3 = $("#offer3").val();
    var offer4 = $("#offer4").val();
    var offer5 = $("#offer5").val();
    var offer6 = $("#offer6").val();
    if(offer1 == ''){
    	offer1 = 0;
    }
    if(offer2 == ''){
    	offer2 = 0;
    }
    if(offer3 == ''){
    	offer3 = 0;
    }
    if(offer4 == ''){
    	offer4 = 0;
    }
    if(offer5 == ''){
    	offer5 = 0;
    }
    if(offer6 == ''){
    	offer6 = 0;
    }
    var countNum = parseFloat(offer1)+parseFloat(offer2)+parseFloat(offer3)+parseFloat(offer4)+parseFloat(offer5)+parseFloat(offer6);
    $("#total").val(countNum);

}
</script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td colspan="4" style="text-align: center;font-weight: bold;font-size:18px;color:green">领程传媒包场活动确认单</td>
		    </tr>
		    
		    <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">下单日期</td>
                <td width="40%"><?php echo date('Y-m-d');?></td>
                <td width="10%" style="text-align: center;font-weight: bold;">下单人</td>
                <td width="40%"><?php echo $this->session->userdata('userName')?></td>
            </tr>
            
		    <tr>
                <td style="text-align: center;font-weight: bold;">客户名称</td>
                <td>
                    <input type="text" name="name" id="name" autocomplete="off" class="span3" onKeyUp="getInfo('<?php echo $base_url;?>index.php','/business/CustomerController/getCustomerInfo','name')">
                </td>
                <div id="m_tagsItem" style="display:none">
	                <div id="tagClose">关闭</div>
	                <p><font id="dvelopersInfo"></font></p>
                </div>
                <td style="text-align: center;font-weight: bold;">活动性质</td>
                <td>
                    <select name="nature" id="nature" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['nature'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr id="showContract" style="display:none">
                <td style="text-align: center;font-weight: bold;">关联合同</td>
                <td id="details_name" colspan="3">
                    <select name="dNumber" id="dNumber" onclick="" class="span4"></select>
                    <a href="javascript:void(0)" style="color:red" onclick="getContractInfo($('#name').val(),'<?php echo site_url("/business/ContractController/getContractInfo")?>')"><b>点击载入合同</b></a>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">执行影院</td>
                <td>
	                <select name="studioId" id="studioId" class="span3">
						<option value="">-请选择-</option>
						<?php foreach($studio as $key=>$val){?>
						<option value="<?php echo $val['sId'];?>"><?php echo $val['name'];?></option>
						<?php } ?>
				    </select>
                </td>
                <td width="10%" style="text-align: center;font-weight: bold;">影片类型</td>
                <td>
                    <select name="film_type" id="film_type" style="width:100px">
                           <option value="">-请选择-</option>
                           <?php foreach($advert['film_type'] as $key=>$val){?>
                           <option value="<?php echo $key;?>"><?php echo $val;?></option>
                           <?php } ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">片名</td>
                <td><input type="text" name="film_name" id="film_name" class="span2"></td>
                <td width="10%" style="text-align: center;font-weight: bold;">厅号</td>
                <td><input type="text" name="hallNumber" id="hallNumber" class="span1"></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">执行时间</td>
                <td><input type="text" name="follow_date" id="follow_date" class="span2" onClick="WdatePicker()"></td>
                <td width="10%" style="text-align: center;font-weight: bold;">人数</td>
                <td><input type="text" name="person_num" id="person_num" class="span1"></td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">执行票价</td>
                <td><input type="text" name="film_price" id="film_price" class="span1">&nbsp;（元/张）</td>
                <td width="10%" style="text-align: center;font-weight: bold;">卖品需求</td>
                <td><input type="text" name="demand_price" id="demand_price" class="span1">&nbsp;（元/套）
                &nbsp;&nbsp;（<input type="text" name="demand_num" id="demand_num" class="span1">份）</td>
            </tr>
            
            <tr>
                <td style="text-align: center;font-weight: bold;">客户报价情况</td>
                <td colspan="3">
                    <table cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td style="text-align: center;"><b>影票报价(元/张)</b></td>
                            <td style="text-align: center;"><b>卖品报价(元/套)</b></td>
                            <td style="text-align: center;"><b>税费(元)</b></td>
                            <td style="text-align: center;"><b>服务费(元)</b></td>
                            <td style="text-align: center;"><b>物料制作费(元)</b></td>
                            <td style="text-align: center;"><b>其他(元)</b></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><input type="text" name="offer1" id="offer1" class="span1" value="" onClick="countOffer()"></td>
                            <td style="text-align: center;"><input type="text" name="offer2" id="offer2" class="span1" value="" onClick="countOffer()"></td>
                            <td style="text-align: center;"><input type="text" name="offer3" id="offer3" class="span1" value="" onClick="countOffer()"></td>
                            <td style="text-align: center;"><input type="text" name="offer4" id="offer4" class="span1" value="" onClick="countOffer()"></td>
                            <td style="text-align: center;"><input type="text" name="offer5" id="offer5" class="span1" value="" onClick="countOffer()"></td>
                            <td style="text-align: center;"><input type="text" name="offer6" id="offer6" class="span1" value="" onClick="countOffer()"></td>
                        </tr>
                        <tr>
                            <td colspan="6">费用总计：<input type="text" name="total" id="total" class="span1" onClick="countOffer()">&nbsp;（元）</td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="10%" style="text-align: center;font-weight: bold;">合同赠送（包场）情况说明</td>
                <td colspan="3"><textarea name="remark" class="span4"></textarea></td>
            </tr>
            
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button class="btn btn-gebo" type="submit" name="submitCreate" value="提交内容" style="margin-right: 20px;">提交内容</button>
                    <button type="reset" class="btn">重置</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
