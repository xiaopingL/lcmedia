<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">
                权限名称：<input type="text" name="menuName" class="input-medium span2" value="<?php if(!empty($menuName)) echo $menuName;?>" >
            </th>
            <th valign="middle">
                权限代码：<input type="text" name="comCode" class="input-medium span1" value="<?php if(!empty($comCode)) echo $comCode;?>" >
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
            </th>
            <th><a href="<?php echo site_url("admin/MenuController/menuAdd")?>">权限新增</a></th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>权限名称</th>
                <th>权限代码</th>
                <th>上级</th>
                <th>菜单URL</th>
                <th>权限类型</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $value['comeName']; ?></td>
                <td><?php echo $value['comCode']; ?></td>
                <td><?php echo $value['parentName']; ?></td>
                <td><?php echo $value['codeUrl']; ?></td>
                <td><?php echo $value['isDel']==0?'菜单':'操作'; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$value['createTime']); ?></td>
                <td>
                    <a href="<?php echo site_url('admin/MenuController/menuEdit/'.$value['comCode']); ?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
                    <a href="javascript:deleteConFirm('<?php echo site_url('admin/MenuController/menuDel/'.$value['comCode']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
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