<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="">
        <thead>
            <tr>
                <th align="center" valign="middle">物料名称：</th>
                <th align="center" valign="middle"><input type="text" name="toolsName" id="toolsName" class="span2" value="<?php if(!empty($toolsName)) echo $toolsName;?>" class="span1" ></th>
                <th valign="top">
                    <button type="submit" class="btn btn-success" >我要查询</button>
                </th>
                <th><a href="<?php echo site_url('/office/ToolsController/toolsAddView'); ?>"><b>新增物料</b></a></th>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="10%">物料名称</th>
                <th width="5%">物料类别</th>
                <th width="6%">入库数量</th>
                <th width="6%">剩余数量</th>
                <th width="7%">物料单价</th>
                <th width="7%">创建时间</th>
                <th width="6%">创建人</th>
                <th width="16%">备注</th>
                <th width="8%">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($arr)):?>
            <?php foreach($arr as $value):?>
            <tr>
                <td><font style="color:green"><?php echo $value['name'];?></font></td>
                <td><?php echo $value['type']==1?'票务':'其他';?></td>
                <td><?php echo $value['num'];?></td>
                <td><?php echo $value['stockNum'];?></td>
                <td><?php echo $value['price'];?>元(/<?php echo $value['unit'];?>)</td>
                <td><?php echo date('Y-m-d',$value['createTime']);?></td>
                <td><?php echo $userInfoArray[$value['operator']];?></td>
                <td><?php echo $value['remark'];?></td>
                <td>
                    <a href="<?php echo site_url('/office/ToolsController/toolsEdit/'.$value['tId']); ?>" title="修改">编辑</a>&nbsp;|&nbsp;
                    <a href="<?php echo site_url('/office/ToolsController/toolsStock/'.$value['tId']); ?>">新增</a>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?>
            <tr>
                <tr><td colspan="9" style="color:red;">没有查找到相关信息</td></tr>
            </tr>
            <?php endif;?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>


