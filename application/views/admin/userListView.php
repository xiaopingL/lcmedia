<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">
                用户名：<input type="text" name="username" class="input-medium span1" value="<?php if(!empty($username)) echo $username;?>" >
            </th>
            <th valign="middle">
                岗位级别：<select name="jobId" class="span1">
                         <option value="">选择</option>
                         <?php foreach($position as $key=>$value){ ?>
                         <option value="<?php echo $key; ?>" <?php if(!empty($jobId)) echo $jobId==$key?'selected':''; ?>><?php echo $value; ?></option>
                         <?php } ?>
                         </select>
            </th>
            <th valign="middle">
                角色：<select name="roleId" class="span2">
                         <option value="">选择</option>
                         <?php foreach($role as $key=>$value){ ?>
                         <option value="<?php echo $value['roreId']; ?>" <?php if(!empty($roleId)) echo $roleId==$value['roreId']?'selected':''; ?>><?php echo $value['roleName']; ?></option>
                         <?php } ?>
                         </select>
            </th>
            <th valign="middle">部门：
              <select name="sId" id="sId" class="span2">
				  		   <option value="">--请选择--</option>
						   <?php foreach($org as $val){ ?>
				  		   <option value="<?php echo $val['sId'];?>" <?php echo $val['sId']==$sId?'selected':''; ?> style="<?php if($val['level']==1){echo 'font-weight:bold;color:black;';} ?>">
						   <?php
						   for($i=1;$i<$val['level'];$i++)
						   {
							  echo "====";
						   }
						   ?><?php echo $val['name'];?></option>
						  <?php }?>
						  </select>
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">我要查询</button>
            </th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>岗位级别</th>
                <th>组织架构</th>
                <th width="15%">站点</th>
                <th>最后登录时间</th>
                <th>状态</th>
                <th>注册时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr>
                <td><?php echo $value['uId']; ?></td>
                <td><?php echo $value['userName']; ?></td>
                <td><?php if(!empty($value['position'])) echo $value['position']; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td width="15%"><?php echo $value['siteName']; ?></td>
                <td><?php echo $value['lastTime']!=''?date('Y-m-d H:i:s',$value['lastTime']):''; ?></td>
                <td><?php echo $value['isDisabled']==0?'正常':'<font color=red>审核</font>'; ?></td>
                <td><?php echo date('Y-m-d',$value['createTime']); ?></td>
                <td >
                    <a href="<?php echo site_url('admin/UserController/userEdit/'.$value['uId']); ?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
                    <a href="javascript:deleteConFirm('<?php echo site_url('admin/UserController/userDel/'.$value['uId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a>
                </td>
            </tr>
            <?php } }else{ ?>
                <tr><td colspan="9" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>