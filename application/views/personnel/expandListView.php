<script type="text/javascript">
function showImg(id,type){
	var objDiv = $("#"+id+"");
	if(type == 1){
	    $(objDiv).css('display','block');
	}else{
	   	$(objDiv).css('display','none');
	}
}
</script>
<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">
                姓名：<input type="text" name="userName" class="input-medium span1" value="<?php if(!empty($userName)) echo $userName;?>" >
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
                状态：<select name="status" id="status" class="span1">
                     <option value="0" <?php echo $status==0?'selected':''; ?>>在职</option>
                     <option value="1" <?php echo $status==1?'selected':''; ?>>离职</option>
                     </select>
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
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
                <th width="7%">姓名</th>
                <th>性别</th>
                <th>部门</th>
                <th>入职时间</th>
                <th>出生年月</th>
                <th>学历</th>
                <th>毕业院校</th>
                <th>联系方式</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td class="character_image" onMouseOver="javascript:showImg('cont<?php echo $value['uId']; ?>',1);" onMouseOut="showImg('cont<?php echo $value['uId']; ?>',2)">
                    <font color=green><?php echo $value['userName'];?></font>
                    <div class="character_cont" style="display:none" id="cont<?php echo $value['uId']; ?>">
	                <img class="character_img" src="<?php echo $value['photoImg'];?>" /><br />
	                </div>
                </td>
                <td><?php if($value['sex']==1){echo '男';}elseif($value['sex']==2){echo '女';}; ?></td>
                <td><?php echo $value['orgName']; ?></td>
                <td><?php echo !empty($value['createTime'])?date('Y-m-d',$value['createTime']):''; ?></td>
                <td><?php echo !empty($value['birthday'])?date('Y-m-d',$value['birthday']):''; ?></td>
                <td><?php echo $educationType[$value['education']];?></td>
                <td><?php echo $value['graduateFrom'];?></td>
                <td><?php if(!empty($value['phone'])):?><?php echo $value['phone'];?><?php endif;?></td>
                <td><a href="<?php echo site_url('/personnel/ExpandController/expandEdit/'.$value['uId']); ?>" title="修改"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
                    <a href="<?php echo site_url('/personnel/ExpandController/expandDetail/'.$value['uId']);?>" title="查看"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;
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