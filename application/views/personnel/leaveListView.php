<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $this->load->view('personnel/attenceTab'); ?>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="" >
        <thead>
            <tr>
                <th align="center" valign="middle">姓名：</th>
                <th align="center" valign="middle"><input type="text" name="userName" id="userName"  value="<?php if(!empty($userName)) echo $userName;?>" class="span1" ></th>
                <th align="center" valign="middle">请假类型：</th>
                <th align="center" valign="middle">
                    <select name="type" id="type" style="width:100px;">
                        <option value="">选择</option>
                        <?php foreach($leaveType as $key=>$value):?>
                        <option value="<?php echo $key;?>" <?php if($type == $key):?> selected="selected"<?php endif;?>><?php echo $value;?></option>
                        <?php endforeach;?>
                    </select>
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
                <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" class="span1"  onClick="WdatePicker()"> 到
                    <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" class="span1"  onClick="WdatePicker()"> </th>
                <th valign="top">
                    <button type="submit" class="btn btn-success" >
                        我要查询
                    </button>
                </th>
                <th><a href="<?php echo site_url('/personnel/LeaveController/leaveAddView/'); ?>"><b>新建表单</b></a>&nbsp;&nbsp;</th>
                <!--<th><a href="<?php echo site_url('/personnel/AublicController/getLeavePub/'); ?>" style="color:red;"><b>请假单数据更新</b></a>&nbsp;&nbsp;</th>-->
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>姓名</th>
                <th>填写时间</th>
                <th>请假类型</th>
                <th width="60px;">开始时间</th>
                <th width="60px;">结束时间</th>
                <th width="150px;">请假事由</th>
                <th>共计时间</th>
                <th>审批详情</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($arr)):?>
            <?php foreach($arr as $value):?>
            <tr>
                <td><?php echo $userInfoArray[$value['operator']];?></td>
                <td><?php echo date("Y-m-d",$value['createTime']);?></td>
                <td><?php echo $leaveType[$value['type']];?></td>
                <td><?php echo date("Y-m-d H:i",$value['startDate']);?></td>
                <td><?php echo date("Y-m-d H:i",$value['endDate']);?></td>
                <td><?php echo mb_substr($value['cause'],0,25,'utf-8');?></td>
                <td><?php echo $value['allDay'];?>天</td>
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
                <td><?php if($value['flow'][0]['isOver'] == 0):?>
                    <a href="<?php echo site_url('/personnel/LeaveController/leaveEditView/'.$value['leaveId']); ?>" title="修改"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
                    <?php else:?>
                     <?php if(in_array('allLeave',$userOpera)):?><a href="<?php echo site_url('/personnel/LeaveController/leaveEditView/'.$value['leaveId']); ?>" title="修改"><i class="icon-pencil"></i></a><?php endif;?>&nbsp;&nbsp;
                    <?php endif;?>
                    <a href="<?php echo site_url('/personnel/LeaveController/leaveLookView/'.$value['leaveId']);?>" title="查看"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;
                    <?php if($value['flow'][0]['isOver'] == 0):?>
                    <a href="javascript:deleteConFirm('<?php echo site_url('/personnel/LeaveController/leaveUdelView/'.$value['leaveId']); ?>')" title="删除"><i class="icon-trash"></i></a> &nbsp;&nbsp;
                    <?php else:?>
                     <?php if(in_array('allLeave',$userOpera)):?><a href="javascript:deleteConFirm('<?php echo site_url('/personnel/LeaveController/leaveUdelView/'.$value['leaveId']); ?>')" title="删除"><i class="icon-trash"></i></a><?php endif;?> &nbsp;&nbsp;
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?>
            <tr>
                <tr><td colspan="10" style="color:red;">没有查找到相关信息</td></tr>
            </tr>
            <?php endif;?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>


