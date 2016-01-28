<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $this->load->view('public/tab'); ?>
<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="">
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
            <th valign="middle">填写时间：
              <input type="text" name="btime" id="btime" onClick="WdatePicker()" class="input-medium search" style="width:75px" value="<?php if(!empty($btime)) echo $btime;?>">至
              <input type="text" name="etime" id="etime" onClick="WdatePicker()" class="input-medium search" style="width:75px" value="<?php if(!empty($etime)) echo $etime;?>">
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
            </th>
            <th><a href="<?php echo site_url("public/ReportController/reportAddView/?type=".$type)?>">新建信息</a></th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="10%">标题</th>
                <th width="5%">姓名</th>
                <th width="10%">填写时间</th>
                <th width="17%">附件</th>
                <th width="18%">备注</th>
                <th width="5%">操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($result)){ foreach($result as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $value['title']; ?></td>
                <td><?php echo $value['userName']; ?></td>
                <td><?php echo date('Y-m-d H:i',$value['createTime']); ?></td>
                <td><?php if(!empty($value['fId'])) { ?>
                                            <a href="<?php echo site_url("/public/FileController/emailLoad/".$value['fId']) ?>">
                                                <img title="有附件" src="<?php echo $base_url;?>img/attachment.gif" border="0" align="absmiddle">
                                                <?php echo $value['origName'];?> &darr;
                                            </a>
                                           <?php }else{echo '无附件';}?>
                </td>
                <td><?php echo $value['remark'];?></td>
                <td>
                    <?php if($this->session->userdata('uId')==$value['operator']):?><a href="javascript:deleteConFirm('<?php echo site_url("/public/ReportController/reportDel/".$value['rId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php endif; ?>
                </td>
            </tr>
            <?php }}else{ ?>
                <tr><td colspan="6" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>