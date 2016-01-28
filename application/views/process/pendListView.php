<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">
                事项类型：<input type="text" name="pendingType" class="input-medium span2" value="<?php if(!empty($pendingType)) echo $pendingType;?>" >
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
            </th>
            <th><a href="<?php echo site_url("process/PendController/pendAdd")?>">处理事项新增</a></th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="10%">主表表名</th>
                <th width="15%">事项类型</th>
                <th width="25%">url地址</th>
                <th width="25%">指派流程</th>
                <th width="15%">创建时间</th>
                <th width="8%">操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $value['proTable']; ?></td>
                <td><?php echo $value['pendingType']; ?></td>
                <td><?php echo $value['urlAdress']; ?></td>
                <td><?php echo $value['processName']; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$value['createTime']); ?></td>
                <td>
                    <a href="<?php echo site_url('process/PendController/pendEdit/'.$value['pId']); ?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
                    <a href="javascript:deleteConFirm('<?php echo site_url('process/PendController/pendDel/'.$value['pId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
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