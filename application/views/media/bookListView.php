<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;" >
<form method="post" action="" >
    <thead>
        <tr>
          <th valign="middle">姓名：
              <input type="text" name="username" id="username" class="input-medium search span1" value="<?php if(!empty($username)) echo $username;?>">
          </th>
          <th valign="middle">客户名称
              <input type="text" name="name" id="name" style="width:150px;" value="<?php if(!empty($name)) echo $name;?>">
          </th>
          <th align="center" valign="middle">时间段：</th>
          <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:75px" onClick="WdatePicker()"> 到
              <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:75px" onClick="WdatePicker()">
          </th>
          <th valign="middle">
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-success" onClick="">我要查询</button>
          </th>
          <th>&nbsp;<a href="<?php echo site_url("media/BookController/bookAdd")?>">新增信息</a></th>
        </tr>
    </thead>
</form>
</table>

<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>申请人</th>
                <th>客户名称</th>
                <th>影院名称</th>
                <th>活动性质</th>
                <th>执行票价</th>
                <th>审批详情</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
            <?php foreach($getResult as $value):?>
            <tr class="rowlink">
                <td><?php echo $value['userName']; ?><br /><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['studioName']; ?></td>
                <td><?php echo $advert['nature'][$value['nature']];?></td>
                <td><?php echo $value['film_price'];?>（元/张）</td>
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
                    <a href="<?php echo site_url('/media/BookController/bookDetail/'.$value['sId']);?>" title="查看"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;
                    <?php if($value['flow'][0]['isOver'] == 0){?>
                    <a href="<?php echo site_url('/media/BookController/bookEdit/'.$value['sId']); ?>" title="修改"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
	                <a href="javascript:deleteConFirm('<?php echo site_url('media/BookController/bookDel/'.$value['sId']); ?>')" title="删除"><i class="icon-trash"></i></a>
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
