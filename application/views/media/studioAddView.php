<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<form method="post" action="" class="form_validation_ttip" novalidate="novalidate" id="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="15%" style="vertical-align: middle;text-align: center;font-weight: bold;">站点</td>
                <td width="35%" style="vertical-align: middle;">
                    <select name="siteId" id="siteId" style="width:100px;">
                   <?php foreach($siteId as $key => $value):?>
                      <?php foreach($siteIdArray as $v):?>
                         <?php if($value['siteId'] == $v):?>
                            <option value="<?php echo $value['siteId']?>" ><?php echo $value['name']?></option>
                        <?php endif;?>
                     <?php endforeach;?>
                  <?php endforeach;?>
                 </select>
                </td>
                <td width="15%" style="text-align: center;font-weight: bold;">影城名称</td>
                <td><input type="text" name="name" id="name" value=""></td>
		    </tr>
		    
		    <tr>
                <td width="15%" style="text-align: center;font-weight: bold;">厅数</td>
                <td><input type="text" name="room_num" id="room_num" value="" class="span1">&nbsp;（个）</td>
                <td width="15%" style="text-align: center;font-weight: bold;">座位数</td>
                <td><input type="text" name="seat_num" id="seat_num" value="" class="span1">&nbsp;（个）</td>
            </tr>

		    <tr>
                <td width="15%" style="text-align: center;font-weight: bold;">月均场次</td>
                <td><input type="text" name="month_market_num" id="month_market_num" value="" class="span1">&nbsp;（次）</td>
                <td width="15%" style="text-align: center;font-weight: bold;">月均人次</td>
                <td><input type="text" name="month_person_num" id="month_person_num" value="" class="span1">&nbsp;（次）</td>
            </tr>
            
            <tr>
                <td width="15%" style="text-align: center;font-weight: bold;">刊例价(15秒)</td>
                <td><input type="text" name="publish_price_fifteen" id="publish_price_fifteen" value="" class="span1">&nbsp;（元）</td>
                <td width="15%" style="text-align: center;font-weight: bold;">刊例价(30秒)</td>
                <td><input type="text" name="publish_price_thirty" id="publish_price_thirty" value="" class="span1">&nbsp;（元）</td>
            </tr>
            
            <tr>
                <td width="15%" style="text-align: center;font-weight: bold;">影院代理情况</td>
                <td><input type="text" name="situation" id="situation" value=""></td>
                <td width="15%" style="text-align: center;font-weight: bold;">所属院线</td>
                <td><input type="text" name="chain" id="chain" value=""></td>
            </tr>
            
            <tr>
                <td width="15%" style="text-align: center;font-weight: bold;">地址</td>
                <td colspan="3"><input type="text" name="address" id="address" value="" class="span4"></td>
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
