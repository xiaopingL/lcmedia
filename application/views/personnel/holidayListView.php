<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<?php echo $this->load->view('personnel/attenceTab'); ?>
<table data-provides="rowlink" style="margin-bottom:8px;">
<form method="post" action="" >
    <thead>
        <tr>
            <th valign="middle">设置日期：
              <input type="text" name="btime" id="btime" onClick="WdatePicker()" class="input-medium search span2" value="<?php if(!empty($btime)) echo $btime;?>">至
              <input type="text" name="etime" id="etime" onClick="WdatePicker()" class="input-medium search span2" value="<?php if(!empty($etime)) echo $etime;?>">
            </th>
            <th valign="middle">
                <button type="submit" class="btn btn-success">
                    我要查询
                </button>
            </th>
            <th><a href="<?php echo site_url("personnel/AttendController/holidayAdd")?>">日期设置</a></th>
        </tr>
    </thead>
</form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="10%">姓名</th>
                <th width="10%">设置日期</th>
                <th width="10%">法定节假日</th>
                <th width="10%">设置类型</th>
                <th width="13%">创建时间</th>
                <th width="10%">操作</th>
            </tr>
        </thead>
        <tbody>
           <?php if(!empty($getResult)){ foreach($getResult as $value){ ?>
            <tr class="rowlink">
                <td><?php echo $value['userName']; ?></td>
                <td style="color:green;font-weight:bold;"><?php echo date('Y-m-d',$value['setDate']); ?></td>
                <td><?php if($value['setType'] == 1):?><b style="color:red;">是</b><?php elseif($value['setType']):?>否<?php endif;?></td>
                <td><?php echo $value['setStatus']==1?'公休':'正常上班'; ?></td>
                <td><?php echo date('Y-m-d H:i:s',$value['createTime']); ?></td>
                <td><a href="javascript:deleteConFirm('<?php echo site_url('/personnel/AttendController/holidayDel/'.$value['hId']); ?>')" title="删除"><i class="icon-trash"></i></a></td>
            </tr>
            <?php }}else{ ?>
                <tr><td colspan="8" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>