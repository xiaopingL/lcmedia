<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;" >
<form method="post" action="">
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
                <th>客户姓名</th>
                <th>业务员</th>
                <th>拜访时间</th>
                <th>拜访形式</th>
                <th width="20%">洽谈内容</th>
                <th width="20%">下次行动计划</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $value['name'];?></td>
                <td><?php echo $value['userName']; ?></td>
                <td><?php echo $value['username']; ?></td>
                <td><?php echo $arr_month[date('w',$value['createTime'])]; ?>&nbsp;<?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td><?php echo $dailyShape[$value['shape']]; ?></td>
                <td><?php echo nl2br($value['content']);?></td>
                <td><?php echo nl2br($value['plan']);?></td>
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
