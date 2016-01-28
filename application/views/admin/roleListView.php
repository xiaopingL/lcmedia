<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">
                角色名称：<input type="text" name="roleName" class="input-medium span1" value="<?php if(!empty($roleName)) echo $roleName;?>" >
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
            </th>
            <th><a href="<?php echo site_url("admin/RoleController/roleAdd")?>">角色新增</a></th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>编号</th>
                <th>角色名称</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $value['roreId']; ?></td>
                <td><?php echo $value['roleName']; ?></td>
                <td><?php echo $value['description']; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$value['createTime']); ?></td>
                <td>
                    <a href="<?php echo site_url('admin/RoleController/roleEdit/'.$value['roreId']); ?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
                    <a href="<?php echo site_url('admin/RoleController/roleBind/'.$value['roreId']); ?>" class="sepV_a" title="分配权限"><i class="icon-check"></i></a>
                    <a href="javascript:deleteConFirm('<?php echo site_url('admin/RoleController/roleDel/'.$value['roreId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
                </td>
            </tr>
            <?php } }else{ ?>
                <tr><td colspan="5" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>