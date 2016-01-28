<table class="table table-bordered">
	<?php
       if(count($flowlist)!=0){
			foreach($flowlist as $key=>$value){
				$info_id = 0;
				if($value['isOver']==0){ ?>
					<input type="hidden" name="flowid" value="<?php echo $value['rId'];?>">
					<?php if($this->session->userdata('uId') == $value['toUid']){
						$info_id = 1;
						if(empty($value['status'])){
					?>
                    <tr><td>
                    审批：
                    <select name="app_type" id="app_type" class="span1">
                    <option value="1">同意</option>
                    <option value="2">拒绝</option>
                    </select> 意见：<input type="text" name="app_con" size="30">
                    </td></tr>
                    <? }else{ ?>
                    <tr><td>
                    <select name="app_type" id="app_type" class="span2">
                    <option value="1">我已确认</option>
                    </select>
                    </td></tr>
                    <? } }else{//如果不是审批人?>
					<tr><td>
					<?php if($value['fromUid'] != $value['toUid']){ ?>
					已于 [<?=date('Y-m-d H:i:s',$value['createTime'])?>] 提交到 <b><?php echo $value['toName']?></b>,<font color="#0066FF">等待审批。</font>
					<?php }else{ ?>
					已于 [<?=date('Y-m-d H:i:s',$value['createTime'])?>] 提交到 <b><?php echo $value['toName']?></b>,<font color="#0066FF">等待确认。</font>
					<?php } ?>
					</td></tr>
                    <? }
					}else{//已审批完?>
					<tr><td>
					<?php if($value['fromUid'] != $value['toUid']){ ?>
					<b><?=$value['toName']?></b> 于 [<?php echo date('Y-m-d H:i:s',$value['updateTime'])?>] 进行处理 [<?php echo $value['isOver']!=2?"<b><font color='green'>批准</font></b>":"<b><font color='red'>拒绝</font></b>"?>]：<?php echo $value['processIdea']==''?"无":$value['processIdea']?>。
					<?php } ?>
					</td></tr>
					<? }
				}
		} ?>
</table>
<br />
<?php if(!empty($info_id)){ ?>
<button class="btn btn-gebo" type="submit" style="margin-right: 20px;" name="submitCreate" value="提交">提交内容</button>
<?php }?>
<button type="button" class="btn" onClick="javascript:history.go(-1)">我要返回</button>