<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;" >
<form method="post" action="" >
    <thead>
        <tr>
          <th valign="middle">姓名：
              <input type="text" name="username" id="username" class="input-medium search span1" value="<?php if(!empty($username)) echo $username;?>">
          </th>
          <th align="center" valign="middle">部门：</th>
                <th align="center" valign="middle"><select name="sId" class="span1" style="width:180px">
                        <option value="">选择</option>
                        <?php foreach($org as $val) { ?>
                        <option value="<?php echo $val['sId'];?>" <?php if($sId == $val['sId']):?> selected<?php endif;?> style="<?php if($val['level']==1) {
                                echo 'font-weight:bold;color:black;';
                                    } ?>">
                                        <?php
                                        for($i=1;$i<$val['level'];$i++) {
                                            echo "====";
                                        }
                                ?><?php echo $val['name'];?></option>
                            <?php }?>
                    </select>
                </th>
          <th align="center" valign="middle">时间段：</th>
          <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:75px" onClick="WdatePicker()"> 到
              <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:75px" onClick="WdatePicker()">
          </th>
          <th valign="middle">
              &nbsp;&nbsp;
              <button type="submit" class="btn btn-success" onClick="">我要查询</button>
          </th>
          <th>&nbsp;<a href="<?php echo site_url("media/PositionController/positionAdd")?>">新增信息</a></th>
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
                <th>合同名称</th>
                <th>广告形式</th>
                <th>支付方式</th>
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
                <td><?php echo $value['title']; ?></td>
                <td><?php echo $advert['ad_type'][$value['ad_type']];?><?php echo $value['ad_type']==9?'('.$value['ad_other'].')':''?></td>
                <td><?php echo $advert['pay_type'][$value['pay_type']];?></td>
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
                    <a href="<?php echo site_url('/media/PositionController/positionDetail/'.$value['sId']);?>" title="查看"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;
                    <?php if($value['flow'][0]['isOver'] == 0){?>
                    <a href="<?php echo site_url('/media/PositionController/positionEdit/'.$value['sId']); ?>" title="修改"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
	                <a href="javascript:deleteConFirm('<?php echo site_url('media/PositionController/positionDel/'.$value['sId']); ?>')" title="删除"><i class="icon-trash"></i></a>
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
