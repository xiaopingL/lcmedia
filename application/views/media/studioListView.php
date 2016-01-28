<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;" >
<form method="post" action="" >
    <thead>
        <tr>
          <th valign="middle">影城名称
              <input type="text" name="name" id="name" style="width:150px;" value="<?php if(!empty($name)) echo $name;?>">
          </th>
          <th valign="middle">
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-success" onClick="">我要查询</button>
          </th>
          <th>&nbsp;<a href="<?php echo site_url("media/StudioController/studioAddView")?>">新增影城</a></th>
        </tr>
    </thead>
</form>
</table>

<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="3%">站点</th>
                <th width="9%">影城名称</th>
                <th width="5%">厅数</th>
                <th width="5%">座位数</th>
                <th width="5%">月均场次</th>
                <th width="5%">月均人次</th>
                <th width="13%">地址</th>
                <th width="8%">创建人</th>
                <th width="6%">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $siteId[$value['siteId']]; ?></td>
                <td><a href="<?php echo site_url('media/StudioController/studioDetail/'.$value['sId'])?>"><?php if(!empty($value['name'])) echo $value['name']; ?></a></td>
                <td><?php echo $value['room_num'];?></td>
                <td><?php echo $value['seat_num'];?></td>
                <td><?php echo $value['month_market_num'];?></td>
                <td><?php echo $value['month_person_num'];?></td>
                <td><?php echo $value['address'];?></td>
                <td><?php echo $value['userName'];?>/<?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td>
	                    <?php if($this->session->userdata('uId')==$value['operator']):?>
	                        <a href="<?php echo site_url('media/StudioController/studioEditView/'.$value['sId'])?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
	                        <a href="javascript:deleteConFirm('<?php echo site_url('media/StudioController/studioDel/'.$value['sId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
	                    <?php endif;?>
	                    <a href="<?php echo site_url('media/StudioContactController/studioContactAddView/'.$value['sId']); ?>" class="sep_link">联系人</a>
                    <br/>
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
</div>
