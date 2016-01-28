<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="">
        <thead>
            <tr>
                <th align="center" valign="middle">票务名称：</th>
                <th align="center" valign="middle"><input type="text" name="goodsName" id="goodsName" class="span1" value="<?php if(!empty($goodsName)) echo $goodsName;?>" class="span1" ></th>
                <th align="center" valign="middle">客户名称：</th>
                <th align="center" valign="middle"><input type="text" name="clientName" id="clientName" class="span2" value="<?php if(!empty($clientName)) echo $clientName;?>" class="span1" ></th>
                <th align="center" valign="middle">购买时间：</th>
                <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:80px" onClick="WdatePicker()"> 到
                    <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:80px" onClick="WdatePicker()"> </th>
                <th valign="top">
                    <button type="submit" class="btn btn-success" >我要查询</button>
                </th>
                <th><a href="<?php echo site_url('/office/MadeController/madeAddView'); ?>"><b>新建信息</b></a></th>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>客户名称</th>
                <th>购买时间</th>
                <th>票种</th>
                <th>购买数量</th>
                <th>有效期</th>
                <th>制版费</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($arr)):?>
            <?php foreach($arr as $value):?>
            <tr>
                <td><?php echo $value['clientName'];?></td>
                <td><?php echo date('Y-m-d',$value['madeDate']);?></td>
                <td><?php echo $value['name'];?></td>
                <td><?php echo $value['madeNum'];?></td>
                <td><?php echo date('Y-m-d',$value['lastDate']);?></td>
                <td><?php echo $value['price'];?></td>
                <td><?php echo date('Y-m-d',$value['createTime']);?></td>
                <td>
                    <?php if($value['operator']==$this->session->userdata('uId')){ ?>
                    <a href="<?php echo site_url('/office/MadeController/madeBackView/'.$value['mId']); ?>" title="回收">回收</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="javascript:deleteConFirm('<?php echo site_url('office/MadeController/madeDel/'.$value['mId']); ?>')" title="删除">删除</a>
                    <?php }?>
                </td>
            </tr>
            <?php endforeach;?>
            <?php else:?>
            <tr>
                <tr><td colspan="11" style="color:red;">没有查找到相关信息</td></tr>
            </tr>
            <?php endif;?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>


