<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>关联流程</th>
                <th>节点位置</th>
                <th>审批人</th>
                <th>组织架构</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $value['pNumber']; ?></td>
                <td><?php echo $value['level']; ?></td>
                <td><?php echo $value['uId']; ?></td>
                <td><?php echo $value['sId']; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$value['createTime']); ?></td>
                <td>
                    <a href="<?php echo site_url('process/ProcessController/extensionEdit/'.$value['eId']); ?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
                    <a href="javascript:deleteConFirm('<?php echo site_url('process/ProcessController/extensionDel/'.$value['eId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
                </td>
            </tr>
            <?php } }else{ ?>
                <tr><td colspan="6" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>