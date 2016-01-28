<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;" >
<form method="post" action="" >
    <thead>
        <tr>
          <th valign="middle">姓名
              <input type="text" name="username" id="username" class="input-medium search span1" value="<?php if(!empty($username)) echo $username;?>">
          </th>
          <th valign="middle">客户名称
              <input type="text" name="name" id="name" style="width:150px;" value="<?php if(!empty($clientname)) echo $clientname;?>">
          </th>
          <th valign="middle">行业
              <select name="industry" id="industry" class="span1">
                    <option value="">选择</option>
                    <?php foreach ($customer['industry'] as $key => $value):?>
                        <option value="<?php echo $key?>" <?php echo $key==$industry?'selected':'';?>><?php echo $value?></option>
                        <?php endforeach;?>
              </select>
          </th>
          <th align="center" valign="middle">上刊时间
              <input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:75px" onClick="WdatePicker()">
          </th>
          <th align="center" valign="middle">下刊时间
              <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:75px" onClick="WdatePicker()">
          </th>
          <th valign="middle">
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-success" onClick="">我要查询</button>
          </th>
        </tr>
    </thead>
</form>
</table>

<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="6%">申请人</th>
                <th width="11%">客户名称</th>
                <th width="11%">合同名称</th>
                <th width="6%">合同额</th>
                <th width="6%">未开票额</th>
                <th width="6%">上刊时间</th>
                <th width="6%">合同编号</th>
                <th width="6%">行业</th>
                <th width="17%">审批详情</th>
                <th width="6%">状态</th>
                <th width="7%">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $value['userName']; ?><br><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['title']; ?></td>
                <td><?php echo $value['money'];?></td>
                <td><?php echo $value['noBilling'];?></td>
                <td><?php echo date('Y-m-d',$value['issueDate']);?></td>
                <td><?php echo $value['contractNumber'];?></td>
                <td><?php echo !empty($value['industry'])?$customer['industry'][$value['industry']]:''; ?></td>
                                <td width="17%"><div id="validationCode" style="border:1px solid #F8C9A3;background-color:#FAF4E2;color:#000;padding:2px;">
                                <?php foreach($value['flow'] as $ke => $va) {
                                    if($va['isOver']!=0) {

                                        if($va['isOver']==2) {
                                            echo "<b>".$va['toName']."</b>"." <font color=red>拒绝</font>：";
                                            echo $va['processIdea']?$va['processIdea']:'无';
                                        }else {
                                            if($va['fromUid'] == $va['toUid']) {
                                                echo "<b>".$va['toName']."</b>"." <font color=green>已确认</font>";
                                            }else {
                                                echo "<b>".$va['toName']."</b>"." <font color=green>批准</font>：";
                                                echo $va['processIdea']?$va['processIdea']:'无';
                                            }
                                        }
                                    }else {
                                        if($va['fromUid'] == $va['toUid']) {
                                            echo "等待 <b>".$va['toName']."</b> "."进行确认。";
                                        }else {
                                            echo "等待 <b>".$va['toName']."</b> "."进行审批。";
                                        }
                                    }
                                    echo "<br>";
                                }?>
                    </div>
                </td>
                <td>
                    <?php echo $this->load->view('index/approveState',array('state'=>$value['state']));?>
                </td>
                <td>
                    <a href="<?php echo site_url('/business/ContractController/contractDetail/'.$value['contractId']);?>" title="查看"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;
                    <?php if($value['flow'][0]['isOver'] == 0){?>
                    <a href="<?php echo site_url('/business/ContractController/contractEdit/'.$value['contractId']); ?>" title="修改"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
	                <a href="javascript:deleteConFirm('<?php echo site_url('business/ContractController/contractDel/'.$value['contractId']); ?>')" title="删除"><i class="icon-trash"></i></a>
	                <?php }else{ ?>
	                <a href="<?php echo site_url('/business/ContractController/contractFileView/'.$value['contractId']); ?>" style="color:red"><b>拍照</b></a>&nbsp;&nbsp;
	                <a href="<?php echo site_url('business/BillingController/billingAdd/'.$value['contractId'])?>" class="sep_link">开票</a>
	                <?php } ?>
                </td>
            </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td colspan="10" style="text-align:center">您查看的记录为空</td></tr>
            <?php endif;?>
        </tbody>
    </table>

    
    <div class="pageclass">
        <?php if(empty($auto)){?><?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span><?php }?>
    </div>
    <div>
        <?php if($getMoney['totalMoney'] != 0){?>
        <font color="red">合同总金额：<?php echo $getMoney['totalMoney']?>(元)</font>
        <?php }?>
    </div>
</div>
