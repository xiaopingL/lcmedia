<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>事项类型</th>
                <th>姓名</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td><a href="<?php echo site_url($value['urlAdress'].'/'.$value['tableId']); ?>" class="sepV_a" title="查看详情"><?php echo $value['pendingType']; ?></a></td>
                <td><?php echo $value['username']; ?></td>
                <td><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td>
                    <a href="<?php echo site_url($value['urlAdress'].'/'.$value['tableId']); ?>" class="sepV_a" title="查看详情"><i class="icon-eye-open"></i></a>
                    <a href="javascript:deleteConFirm('<?php echo site_url('panel/PanelController/panelDel/'.$value['pendId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
                </td>
            </tr>
            <?php } }else{ ?>
                <tr><td colspan="4" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>