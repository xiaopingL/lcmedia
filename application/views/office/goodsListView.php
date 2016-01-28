<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="">
        <thead>
            <tr>
                <th align="center" valign="middle">申请人：</th>
                <th align="center" valign="middle"><input type="text" name="userName" id="userName" class="span1" value="<?php if(!empty($userName)) echo $userName;?>" class="span1" ></th>
                <th align="center" valign="middle">物品名称：</th>
                <th align="center" valign="middle"><input type="text" name="goodsName" id="goodsName" class="span2" value="<?php if(!empty($goodsName)) echo $goodsName;?>" class="span1" ></th>
                <th align="center" valign="middle">票务类型：</th>
                <th align="center" valign="middle">
                    <select name="category" style="width:100px">
                            <option value="">--请选择--</option>
                            <option value="1" <?php echo $category==1?'selected':'';?>>合同赠票</option>
                            <option value="2" <?php echo $category==2?'selected':'';?>>客户购买</option>
                            <option value="3" <?php echo $category==3?'selected':'';?>>个人申领</option>
                    </select>
                </th>
                <th align="center" valign="middle">时间段：</th>
                <th align="center" valign="middle"><input type="text" name="sTime" id="sTime"  value="<?php if(!empty($sTime)) echo $sTime;?>" style="width:80px" onClick="WdatePicker()"> 到
                    <input type="text" name="eTime" id="eTime"  value="<?php if(!empty($eTime)) echo $eTime;?>" style="width:80px" onClick="WdatePicker()"> </th>
                <th valign="top">
                    <button type="submit" class="btn btn-success" >我要查询</button>
                </th>
                <th><a href="<?php echo site_url('/office/GoodsController/goodsAddView'); ?>"><b>领料申请</b></a></th>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>申请人</th>
                <th>部门</th>
                <th>物料名称</th>
                <th>单位</th>
                <th>领用数量</th>
                <th>实领数量</th>
                <th>创建时间</th>
                <th width="17%">审批详情</th>
                <th>状态</th>
                <th>本次领用截止编号</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($arr)):?>
            <?php foreach($arr as $value):?>
            <tr>
                <td><font style="color:green"><?php echo $value['userName'];?></font></td>
                <td><?php echo $value['orgName'];?></td>
                <td>
                    <?php echo $value['name'];?>
                    <?php if(!empty($value['category'])){
                    	if($value['category'] == 1){
                    		echo '[合同赠票]';
                    	}elseif($value['category'] == 2){
                    		echo '[客户购买]';
                    	}else{
                    		echo '[个人申领]';
                    	}
                    }?>
                </td>
                <td><?php echo $value['unit']; ?></td>
                <td><?php echo $value['num'];?></td>
                <td><?php echo $value['actNum'];?></td>
                <td><?php echo date('Y-m-d',$value['createTime']);?></td>
                <td><div id="validationCode" style="border:1px solid #F8C9A3;background-color:#FAF4E2;color:#000;padding:2px;">
                    <?php foreach($value['flow'] as $ke => $va){
                            if($va['isOver']!=0){

                                if($va['isOver']==2){
                                    echo "<b>".$va['toName']."</b>"." <font color=red>拒绝</font>：";
                                    echo $va['processIdea']?$va['processIdea']:'无';
                                }else{
                                    if($va['fromUid'] == $va['toUid']){
                                      echo "<b>".$va['toName']."</b>"." <font color=green>已确认</font>";
                                    }else{
                                      echo "<b>".$va['toName']."</b>"." <font color=green>批准</font>：";
                                      echo $va['processIdea']?$va['processIdea']:'无';
                                    }
                                }
                            }else{
                                if($va['fromUid'] == $va['toUid']){
                                    echo "等待 <b>".$va['toName']."</b> "."进行确认。";
                                }else{
                                    echo "等待 <b>".$va['toName']."</b> "."进行审批。";
                                }
                            }
                        echo "<br>";
                    }?>
                </div></td>
                <td><?php echo $this->load->view('index/approveState',array('state'=>$value['state']));?></td>
                <td><?php echo $value['number']; ?></td>
                <td>
                    <a href="<?php echo site_url("office/GoodsController/goodsDetailView/$value[gId]")?>" class="sepV_a" title="查看"><i class="icon-eye-open"></i></a>
                    <?php if($value['flow'][0]['isOver'] == 0 && $value['operator']==$this->session->userdata('uId')){ ?><a href="javascript:deleteConFirm('<?php echo site_url('office/GoodsController/goodsDel/'.$value['gId']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php }?>
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


