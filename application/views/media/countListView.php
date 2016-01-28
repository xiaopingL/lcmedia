<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="">
    <thead>
        <tr>
          <th valign="middle">姓名：
              <input type="text" name="username" id="username" class="input-medium search span1" value="<?php if(!empty($username)) echo $username;?>">
          </th>
          <th valign="middle">影城名称：
              <input type="text" name="name" id="name" style="width:150px;" value="<?php if(!empty($name)) echo $name;?>">
          </th>
          <th align="center" valign="middle">时间段：</th>
          <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:75px" onClick="WdatePicker({dateFmt:'yyyy MM'})"> 到
              <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:75px" onClick="WdatePicker({dateFmt:'yyyy MM'})">
          </th>
          <th valign="middle">
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-success" onClick="">我要查询</button>
          </th>
          <th>&nbsp;<a href="<?php echo site_url("media/CountController/countAdd")?>">新增信息</a></th>
        </tr>
    </thead>
</form>
</table>

<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>填写人</th>
                <th>影城名称</th>
                <th>月份</th>
                <th>票房</th>
                <th>人次</th>
                <th>广告可覆盖人次</th>
                <th>场次</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $value['userName']; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo date('Y-m',$value['countDate']);?></td>
                <td><?php echo $value['box_num']; ?></td>
                <td><?php echo $value['person_num']; ?></td>
                <td><?php echo $value['advert_num'];?></td>
                <td><?php echo $value['film_num'];?></td>
                <td><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td>
                    <?php if($this->session->userdata('uId') == $value['operator']){?>
	                <a href="javascript:deleteConFirm('<?php echo site_url('media/CountController/countDel/'.$value['sId']); ?>')" title="删除"><i class="icon-trash"></i></a>
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
</div>
