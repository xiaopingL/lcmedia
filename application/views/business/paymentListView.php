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
          <th align="center" valign="middle">时间段：</th>
          <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:75px" onClick="WdatePicker()"> 到
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
                <th>客户名称</th>
                <th>合同名称</th>
                <th>合同编号</th>
                <th>回款金额(元)</th>
                <th>付款方式</th>
                <th>回款时间</th>
                <th>业务员</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['title']; ?></td>
                <td><?php echo $value['contractNumber'];?></td>
                <td><?php echo $value['retrieveMoney'];?></td>
                <td><?php echo $payment['paymentMode'][$value['type']];?></td>
                <td><?php echo date('Y-m-d',$value['retrieveTime']); ?></td>
                <td><?php echo $value['userName'];?></td>
                <td><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td>
                    <?php if($this->session->userdata('uId') == $value['operator']){?>
	                <a href="javascript:deleteConFirm('<?php echo site_url('business/PaymentController/paymentDel/'.$value['paymentId']); ?>')" title="删除"><i class="icon-trash"></i></a>
	                <?php } ?>
                </td>
            </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td colspan="9" style="text-align:center">您查看的记录为空</td></tr>
            <?php endif;?>
        </tbody>
    </table>

    <div class="pageclass">
        <?php if(empty($auto)){?><?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span><?php }?>
    </div>
    <div>
        <?php if($getMoney['totalMoney'] != 0){?>
        <font color="red">回款总金额：<?php echo $getMoney['totalMoney']?>(元)</font>
        <?php }?>
    </div>
</div>
