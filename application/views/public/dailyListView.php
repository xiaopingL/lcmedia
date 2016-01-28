<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $this->load->view('public/tab'); ?>
<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">
                姓名：<input type="text" name="username" class="input-medium span1" value="<?php if(!empty($username)) echo $username;?>" >
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
            <th valign="middle">日志时间：
              <input type="text" name="btime" id="btime" onClick="WdatePicker()" class="input-medium search" style="width:75px" value="<?php if(!empty($btime)) echo $btime;?>">至
              <input type="text" name="etime" id="etime" onClick="WdatePicker()" class="input-medium search" style="width:75px" value="<?php if(!empty($etime)) echo $etime;?>">
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
            </th>
            <th><a href="<?php echo site_url("public/DailyController/dailyAddView")?>">新建日志</a></th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="15%">日期</th>
                <th width="8%">姓名</th>
                <th width="15%">日志标题</th>
                <th width="13%">填写时间</th>
                <th width="7%">分数</th>
                <th width="8%">评价人</th>
                <th width="13%">评价时间</th>
                <th width="10%">操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($result)){ foreach($result as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $arr_month[date('w',$value['startDate'])]; ?>&nbsp;<strong><?php echo date('Y-m-d',$value['startDate']); ?></strong></td>
                <td><?php echo $value['userName']; ?></td>
                <td><a href="<?php echo site_url("/public/DailyController/dailyDetailView/".$value['pId'])?>" class="sepV_a" title="详情"><?php echo $value['dailyTitle']; ?></a></td>
                <td><?php echo date('Y-m-d H:i',$value['createTime']); ?></td>
                <td><?php echo !empty($value['score'])?$value['score']:''; ?></td>
                <td><?php if(!empty($value['uId'])):?><?php echo $userArray[$value['uId']];?><?php endif;?></td>
                <td><?php echo !empty($value['evaTime'])?date('Y-m-d H:i',$value['evaTime']):''; ?></td>
                <td>
                    <?php if($this->session->userdata('uId')==$value['operator'] && $value['score'] == ''):?><a href="<?php echo site_url("/public/DailyController/dailyEditView/".$value['pId'])?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a><?php endif; ?>
                    <a href="<?php echo site_url("/public/DailyController/dailyDetailView/".$value['pId'])?>" class="sepV_a" title="查看"><i class="icon-eye-open"></i></a>
                    <?php if($this->session->userdata('uId')==$value['operator'] && $value['score'] == ''):?><a href="javascript:deleteConFirm('<?php echo site_url("/public/DailyController/dailyDel/".$value['pId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php endif; ?>
                </td>
            </tr>
            <?php }}else{ ?>
                <tr><td colspan="9" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>