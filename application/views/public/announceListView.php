<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/ymPrompt/ymPrompt.js"></script>
<link  href="<?php echo $base_url;?>js/ymPrompt/skin/qq/ymPrompt.css" rel="stylesheet" type="text/css" />
<?php echo $this->load->view('public/tableGg'); ?>
<table data-provides="rowlink" style="margin-bottom:8px;">
    <form method="post" action="" >
        <thead>
            <tr>
                <th valign="middle">
                    标题：<input type="text" name="title1" style="width:200px;" value="<?php if(!empty($title1)) echo $title1;?>" >
                    部门:<select name="department" class="span2">
                        <option value="">选择</option>
                        <?php foreach($org as $val) { ?>
                        <option value="<?php echo $val['sId'];?>" <?php if($sId == $val['sId']):?> selected<?php endif;?> style="<?php if($val['level']==1) {
                                echo 'font-weight:bold;color:black;';
                                    } ?>" <?php echo $val['sId']==$department?'selected':''; ?>>
                                        <?php
                                        for($i=1;$i<$val['level'];$i++) {
                                            echo "====";
                                        }
                                ?><?php echo $val['name'];?></option>
                            <?php }?>
                    </select>
                    发布时间：<input style="width:80px;" type="text"   name="cTime" id="cTime"  onClick="WdatePicker()" value="<?php if($cTime) echo $cTime;?>">至<input style="width: 80px;" type="text"  name="eTime" id="eTime"  onClick="WdatePicker()" value="<?php if($eTime) echo $eTime;?>" >
                </th>
                <th valign="middle">
                    <button type="submit" class="btn btn-success">
                        我要查询
                    </button>
                </th>
                <th><a href="<?php echo site_url("public/AnnounceController/announceAdd");?>">新建信息</a>&nbsp;&nbsp;</th>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="20%">标题</th>
                <th width="10%">类型</th>
                <th width="8%">发布时间</th>
                <th width="10%">部门</th>
                <th width="8%">点击数</th>
                <th width="10%">附件</th>
                <th width="15%">审批详情</th>
                <th width="8%">审批状态</th>
                <th width="10%">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($getResult)):?>
               <?php foreach($getResult as $value):?>
               <?php if($this->session->userdata('uId') == 329):?>
                    <tr class="rowlink">
                        <td width="10%">
                            <a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id']);?>"><?php echo $value['title']; ?>
                            <?php $click_name = explode(';', $value['click_name']);if(!in_array($uId,$click_name)):?>
                            <img src="<?php echo $base_url;?>img/new1.gif" border="0" align="absmiddle">
                            <?php endif;?>
                            </a>
                        </td>
                        <td width="10%"><?php echo $config_new[$value['type']]; ?></td>
                        <td width="8%"><?php echo date('Y-m-d',$value['createTime']); ?></td>
                        <td width="8%"><?php echo $value['orgName']; ?></td>
                        <td width="10%"><?php echo $value['count']; ?></td>
                        <td width="10%"><a href="<?php echo site_url("public/FileController/downloadApp/".$value['annex'])?>"><?php echo $value['origName'];?></a></td>
                        <td width="15%"><div id="validationCode" style="border:1px solid #F8C9A3;background-color:#FAF4E2;color:#000;padding:2px;">
                                        <?php foreach($value['flow'] as $ke => $va) {
                                            if($va['isOver']!=0) {
                                                if($va['isOver']==2) {
                                                    echo "<b>".$va['toName']."</b>"." <font color=red>拒绝</font>：";
                                                    echo $va['processIdea']?$va['processIdea']:'无';
                                                }else {
                                                    if($va['fromUid'] == $va['toUid']) {
                                                        echo "<b>".$va['toName']."</b>"." <font color=green>已确认</font>";
                                                    }else {
                                                        echo "<b>".$va['toName']."</b>"." <font color=green>批准</font>：";
                                                        echo $va['processIdea']?$va['processIdea']:'无';
                                                    }
                                                }
                                            }else {
                                                if($va['fromUid'] == $va['toUid']) {
                                                    echo "等待 <b>".$va['toName']."</b> "."进行确认。";
                                                }else {
                                                    echo "等待 <b>".$va['toName']."</b> "."进行审批。";
                                                }
                                            }
                                            echo "<br>";
                                        }?>
                            </div></td>
                        <td width="8%"><?php echo $this->load->view('index/approveState',array('state'=>$value['state']));?></td>
                        <td width="10%">
                                    <?php if($value['state'] == 0 && $value['operator']==$this->session->userdata('uId')) { ?><a href="<?=site_url('public/AnnounceController/announceEdit/'.$value['id'])?>"  class="sepV_a" title="修改"><i class="icon-pencil"></i></a><?php  }?>
                                    <?php if($value['state'] == 1):?>
                                    <a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id']);?>">&nbsp;查看</a>
                                    <?php endif;?>
                                    <?php if($value['operator']==$this->session->userdata('uId')) { ?><a href="javascript:deleteConFirm('<?php echo site_url('public/AnnounceController/announceDel/'.$value['id'].'/'.$value['type']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php }?>
                        </td>
                    </tr>
               <?php else:?>
                <?php if($value['operator'] == $uId):?>
                    <tr class="rowlink">
                        <td width="10%">
                            <a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id']);?>"><?php echo $value['title']; ?>
                            <?php $click_name = explode(';', $value['click_name']);if(!in_array($uId,$click_name)):?>
                            <img src="<?php echo $base_url;?>img/new1.gif" border="0" align="absmiddle">
                            <?php endif;?>
                            </a>
                        </td>
                        <td width="10%"><?php echo $config_new[$value['type']]; ?></td>
                        <td width="8%"><?php echo date('Y-m-d',$value['createTime']); ?></td>
                        <td width="8%"><?php echo $value['orgName']; ?></td>
                        <td width="10%"><?php echo $value['count']; ?></td>
                        <td width="10%"><a href="<?php echo site_url("public/FileController/downloadApp/".$value['annex'])?>"><?php echo $value['origName'];?></a></td>
                        <td width="15%"><div id="validationCode" style="border:1px solid #F8C9A3;background-color:#FAF4E2;color:#000;padding:2px;">
                                        <?php foreach($value['flow'] as $ke => $va) {
                                            if($va['isOver']!=0) {
                                                if($va['isOver']==2) {
                                                    echo "<b>".$va['toName']."</b>"." <font color=red>拒绝</font>：";
                                                    echo $va['processIdea']?$va['processIdea']:'无';
                                                }else {
                                                    if($va['fromUid'] == $va['toUid']) {
                                                        echo "<b>".$va['toName']."</b>"." <font color=green>已确认</font>";
                                                    }else {
                                                        echo "<b>".$va['toName']."</b>"." <font color=green>批准</font>：";
                                                        echo $va['processIdea']?$va['processIdea']:'无';
                                                    }
                                                }
                                            }else {
                                                if($va['fromUid'] == $va['toUid']) {
                                                    echo "等待 <b>".$va['toName']."</b> "."进行确认。";
                                                }else {
                                                    echo "等待 <b>".$va['toName']."</b> "."进行审批。";
                                                }
                                            }
                                            echo "<br>";
                                        }?>
                            </div></td>
                        <td width="8%"><?php echo $this->load->view('index/approveState',array('state'=>$value['state']));?></td>
                        <td width="10%">
                                    <?php if($value['state'] == 0 && $value['operator']==$this->session->userdata('uId')) { ?><a href="<?=site_url('public/AnnounceController/announceEdit/'.$value['id'])?>"  class="sepV_a" title="修改"><i class="icon-pencil"></i></a><?php  }?>
                                    <?php if($value['state'] == 1):?>
                                    <a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id']);?>">&nbsp;查看</a>
                                    <?php endif;?>
                           <!--<a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id'])?>" >&nbsp;查看</a>  -->
                                    <?php if($value['operator']==$this->session->userdata('uId')) { ?><a href="javascript:deleteConFirm('<?php echo site_url('public/AnnounceController/announceDel/'.$value['id'].'/'.$value['type']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php }?>
                        </td>
                    </tr>
                <?php else:?>
                  <?php if($value['state'] == 1):?>
                    <tr class="rowlink">
                        <td width="10%">
                            <a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id']);?>"><?php echo $value['title']; ?></a>
                            <?php $click_name = explode(';', $value['click_name']);if(!in_array($uId,$click_name)):?>
                            <img src="<?php echo $base_url;?>img/new1.gif" border="0" align="absmiddle">
                            <?php endif;?>
                        </td>
                        <td width="10%"><?php echo $config_new[$value['type']]; ?></td>
                        <td width="8%"><?php echo date('Y-m-d',$value['createTime']); ?></td>
                        <td width="8%"><?php echo $dep[$value['sId']]; ?></td>
                        <td width="10%"><?php echo $value['count']; ?></td>
                        <td width="10%"><a href="<?php echo site_url("public/FileController/downloadApp/".$value['annex'])?>"><?php echo $value['origName'];?></a></td>
                        <td width="15%"><div id="validationCode" style="border:1px solid #F8C9A3;background-color:#FAF4E2;color:#000;padding:2px;">
                                    <?php foreach($value['flow'] as $ke => $va) {
                                        if($va['isOver']!=0) {
                                            if($va['isOver']==2) {
                                                echo "<b>".$va['toName']."</b>"." <font color=red>拒绝</font>：";
                                                echo $va['processIdea']?$va['processIdea']:'无';
                                            }else {
                                                if($va['fromUid'] == $va['toUid']) {
                                                    echo "<b>".$va['toName']."</b>"." <font color=green>已确认</font>";
                                                }else {
                                                    echo "<b>".$va['toName']."</b>"." <font color=green>批准</font>：";
                                                    echo $va['processIdea']?$va['processIdea']:'无';
                                                }
                                            }
                                        }else {
                                            if($va['fromUid'] == $va['toUid']) {
                                                echo "等待 <b>".$va['toName']."</b> "."进行确认。";
                                            }else {
                                                echo "等待 <b>".$va['toName']."</b> "."进行审批。";
                                            }
                                        }
                                        echo "<br>";
                                    }?>
                        </div></td>
                        <td width="8%"><?php echo $this->load->view('index/approveState',array('state'=>$value['state']));?></td>
                        <td width="10%">
                                    <?php if($value['state'] == 0 && $value['operator']==$this->session->userdata('uId')) { ?><a href="<?=site_url('public/AnnounceController/announceEdit/'.$value['id'])?>"  class="sepV_a" title="修改"><i class="icon-pencil"></i></a><?php  }?>
                                    <?php if($value['state'] == 1):?>
                                    <a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id']);?>">&nbsp;查看</a>
                                    <?php endif;?>
                           <!--<a href="<?php echo site_url("public/AnnounceController/announceDetail/".$value['id'])?>" >&nbsp;查看</a>  -->
                                    <?php if($value['operator']==$this->session->userdata('uId')) { ?><a href="javascript:deleteConFirm('<?php echo site_url('public/AnnounceController/announceDel/'.$value['id'].'/'.$value['type']); ?>')" class="sepV_a" title="删除"><i class="icon-trash"></i></a><?php }?>
                        </td>
                    </tr>
                    <?php endif;?>
                <?php endif;?>
            <?php endif;?>
                    <?php endforeach;?>
            <?php else:?>
            <tr><td colspan="10" style="text-align:center">您查看的记录为空</td></tr>
            <?php endif;?>
        </tbody>
    </table>
    <div class="pageclass">
        <?php echo $pagination; ?><span style="float:right"><img src="<?php echo $base_url;?>/img/statistic.gif" border="0" align="absmiddle" /> 共<font color=red><b><?php echo $rows; ?></b></font>条记录</span>
    </div>
</div>
