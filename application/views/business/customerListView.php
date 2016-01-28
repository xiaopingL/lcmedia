<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;" >
<form method="post" action="" >
    <thead>
        <tr>
          <th valign="middle">客户名称
              <input type="text" name="name" id="name" style="width:150px;" value="<?php if(!empty($name)) echo $name;?>">
          </th>
          <th valign="middle">业务员
              <input type="text" name="salesman" id="salesman" class="input-medium search span1" value="<?php if(!empty($salesman)) echo $salesman;?>">
          </th>
          <th valign="middle">
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-success" onClick="">我要查询</button>
          </th>
          <th>&nbsp;<a href="<?php echo site_url("business/CustomerController/customerAddView")?>">新增客户</a></th>
        </tr>
    </thead>
</form>
</table>

<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>站点</th>
                <th>级别</th>
                <th>客户名称</th>
                <th>业务员</th>
                <th>所属行业</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $siteId[$value['siteId']]; ?></td>
                <td><?php echo $value['level']; ?></td>
                <td><a href="<?php echo site_url('business/CustomerController/customerDetail/'.$value['cId'])?>"><?php if(!empty($value['name'])) echo $value['name']; ?></a><?php if($value['status']==1){?><font color=red>[转交中]</font><?php } ?></td>
                <td><?php echo $value['userName'];?><?php if($value['isDel']==1){?><font color=red>[已离职]</font><?php } ?></td>
                <td><?php echo !empty($value['industry'])?$customer['industry'][$value['industry']]:''; ?></td>
                <td><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td>
                    <?php if(empty($value['isStop'])):?>
	                    <?php if($this->session->userdata('uId')==$value['salesmanId']):?>
	                        <a href="<?php echo site_url('business/CustomerController/customerEditView/'.$value['cId'])?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
	                        <a href="<?php echo site_url("business/CustomerController/customerHandover/$value[cId]")?>" class="sepV_a" title="客户转交"><i class="icon-hand-right"></i></a>
	                    <?php endif;?>
	                    <?php if(in_array('allCustomer',$userOpera)):?>
	                        <a href="javascript:deleteConFirm('<?php echo site_url('business/CustomerController/customerDel/'.$value['cId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
	                    <?php endif;?>
	                    <a href="<?php echo site_url('business/ContractController/contractAdd/'.$value['cId'])?>" class="sep_link">合同</a>&nbsp;&nbsp;
	                    <a href="<?php echo site_url('business/CustomerContactController/customerContactAddView/'.$value['cId']); ?>" class="sep_link">联系人</a>
                    <?php endif;?>
                    <br/>
                </td>
            </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr><td colspan="7" style="text-align:center">您查看的记录为空</td></tr>
            <?php endif;?>
        </tbody>
    </table>

    <div class="pageclass">
        <?php if(empty($auto)){?><?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span><?php }?>
    </div>
</div>
