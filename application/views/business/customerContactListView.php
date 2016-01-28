<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript">
    $(function(){
        $("#all_select").click(function(){
            $(".id_list").attr('checked',true);
        })

        $("#all_cancel").click(function(){
            $(".id_list").attr('checked',false);
        })
    })
 </script>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="" >
    <thead>
        <tr>
            <th valign="top">
                客户名称：<input type="text" name="name" id="name" style="width:100px;" value="<?php if(!empty($name)) echo $name;?>">
            </th>
            <th valign="top">
                创建人：<input type="text" name="userName" id="userName" value="<?php if(!empty($userName)) echo $userName;?>" style="width:100px;">
            </th>
            <th align="center" valign="middle" id="st2">
              创建时间：<input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:75px;"  onClick="WdatePicker()"> 到
              <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:75px;"  onClick="WdatePicker()">
            </th>
            <th valign="top">
                <button type="submit" class="btn btn-success" >
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
                <th>客户名称</th>
                <th>行业</th>
                <th>联系人姓名</th>
                <th>联系人电话</th>
                <th>联系人职务</th>
                <th>创建人</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)){ foreach($getResult as $value) { ?>
            <tr class="rowlink">
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $customerIndustry[$value['industry']];?></td>
                <td><?php echo $value['telName']; ?></td>
                <td><?php echo $value['telNumber']; ?></td>
                <td><?php echo $value['telPosition']; ?></td>
                <td><?php echo $value['userName']; ?></td>
                <td><?php if(!empty($value['createTime'])):?><?php echo date("Y-m-d H:i",$value['createTime']); ?><?php endif;?></td>
                <td>
                    <?php if($value['operator']==$this->session->userdata('uId') || in_array('allCustomer',$userOpera)):?>
                    <a href="javascript:deleteConFirm('<?php echo site_url('/business/CustomerContactController/customerContactDel/'.$value['id']); ?>')" title="删除"><i class="icon-trash"></i></a>
                    <a href="<?php echo site_url("/business/CustomerContactController/customerContactEditView/$value[id]")?>" class="sepV_a" title="修改"><i class="icon-pencil"></i></a>
                   <?php endif;?>
                   <a href="<?php echo site_url("/business/CustomerContactController/customerDetail/$value[id]")?>" class="sepV_a" title="查看"><i class="icon-eye-open"></i></a>
                </td>
            </tr>
                <?php } }else{ ?>
                <tr><td colspan="5" style="text-align:center">您查看的记录为空</td></tr>
            <?php } ?>
           </form>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>
