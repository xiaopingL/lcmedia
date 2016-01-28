<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="">
        <thead>
            <tr>
                <th align="center" valign="middle">票务名称：</th>
                <th align="center" valign="middle">
                <select name="tId" class="span2">
                <option value="">-请选择-</option>
                <?php if(!empty($goodsList)){foreach($goodsList as $val){?>
                <option value="<?php echo $val['tId']?>" <?php echo $tId==$val['tId']?'selected':'';?>><?php echo $val['name']?></option>
                <?php } }?>
                </select>
                </th>
                <th align="center" valign="middle">影城名称：</th>
                <th align="center" valign="middle"><input type="text" name="clientName" id="clientName" class="span2" value="<?php if(!empty($clientName)) echo $clientName;?>" class="span1" ></th>
                <th align="center" valign="middle">时间段：</th>
                <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:80px" onClick="WdatePicker()"> 到
                    <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:80px" onClick="WdatePicker()"> </th>
                <th valign="top">
                    <button type="submit" class="btn btn-success" >我要查询</button>
                </th>
                <th><a href="<?php echo site_url('/office/CallbackController/callbackAddView'); ?>"><b>票务回收</b></a></th>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>类型</th>
                <th>回收票种</th>
                <th>回收时间</th>
                <th>领取数量</th>
                <th>回收数量</th>
                <th>合计金额</th>
                <th>创建时间</th>
                <th>填写人</th>
                <th>业务员</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($arr)){?>
            <?php foreach($arr as $value){?>
            <tr>
                <td>
                   <?php echo $value['type']==1?'影城票务':'个人票务';?>
                   <?php if($value['type']==1){?>[<font color=green><?php echo $value['clientName'];?></font>]<?php } ?>
                </td>
                <td><?php echo $value['name'];?></td>
                <td><?php echo date('Y-m',$value['callbackDate']);?></td>
                <td><?php echo $value['actNum'];?></td>
                <td><?php echo $value['callbackNum'];?></td>
                <td><?php echo $value['totalPrice'];?></td>
                <td><?php echo date('Y-m-d',$value['createTime']);?></td>
                <td><?php echo $value['userName'];?></td>
                <td><?php if(!empty($value['salesman'])){echo $userInfo[$value['salesman']];}?></td>
                <td>
                    <?php if($value['operator']==$this->session->userdata('uId')){ ?><a href="javascript:deleteConFirm('<?php echo site_url('office/CallbackController/callbackDel/'.$value['backId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php }?>
                </td>
            </tr>
            <?php } ?>
            <?php if(!empty($profit)){?>
            <tr>
                <td colspan="10" style="color:red;text-align:left"><?php echo $toolsInfo['name']?>回收率：<?php echo $profit;?>%</td>
            </tr>
            <?php }else{ ?>
            <tr>
                <td colspan="10" style="color:blue;text-align:left">说明：查看票务回收率，请选择票务名称和时间段查询。</td>
            </tr>
            <?php } }else{?>
            <tr>
                <td colspan="10" style="color:red;">没有查找到相关信息</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>


