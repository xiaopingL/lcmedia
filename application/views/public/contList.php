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
                <th align="center" valign="middle">姓名：</th>
                <th align="center" valign="middle"><input type="text" name="userName" id="userName" value="<?php echo $userName;?>" style="width:80px" /></th>
                <th align="center" valign="middle">手机：</th>
                <th align="center" valign="middle"><input type="text" name="phone" id="phone" value="<?php echo $phone;?>" style="width:120px" /></th>
                <th align="center" valign="middle">部门：<select name="sId" class="span1" style="width:180px">
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
                <th valign="top">
                    <button type="submit" class="btn btn-success" >
                        我要查询
                    </button>
                </th>
                <th></th>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>用户名</th>
                <th>性别</th>
                <th>部门</th>
                <th width="20%">城市</th>
                <th>手机</th>
                <th>QQ号码</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty ($arr)):?>
            <tr><td colspan="5" style="color:red;">没有查找到相关信息</td></tr>
            <?php else:?>
                <?php foreach($arr as $value):?>
            <tr>
                <td class="character_image" onMouseOver="javascript:showImg('cont<?php echo $value['uId']; ?>',1);" onMouseOut="showImg('cont<?php echo $value['uId']; ?>',2)">
                    <font color=green><?php echo $value['userName'];?></font>
                    <div class="character_cont" style="display:none" id="cont<?php echo $value['uId']; ?>">
	                <img class="character_img" src="<?php echo $value['photoImg'];?>" /><br />
	                </div>
                </td>
                <td><?php if($value['sex']==1){echo '男';}elseif($value['sex']==2){echo '女';}; ?></td>
                <td><?php echo $value['name'];?></td>
                <td><?php echo $value['siteName'];?></td>
                <td><?php echo $value['phone'];?></td>
                <td><?php echo $value['workqq'];?></td>
            </tr>
                <?php endforeach;?>
            <?php endif;?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>


