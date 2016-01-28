<style type="text/css">
#winpop { width:300px; background-color:#FFF; height:0px; position:fixed; right:1px; bottom:0; border:1px solid #1598CA; margin:0; padding:1px; overflow:hidden; display:none;}
#winpop .title { width:100%; height:27px; line-height:25px; background:#1598CA; font-weight:bold; text-align:left; font-size:14px; color:#FFF; padding-left:10px}
#winpop td{margin: 0px; font: 12px Arial, Helvetica, sans-serif; text-align: left;}
#winpop .con { width:100%; height:200px; line-height:200px; font-weight:bold; font-size:12px; color:#06C;}
#silu { font-size:12px; color:#666; position:absolute; right:0; text-align:right; text-decoration:underline; line-height:22px;}
.closeWindow { position:absolute; right:4px; top:-1px; color:#fff; cursor:pointer}
.word { position:absolute; top:2px; text-align:left; color:#fff; cursor:pointer}
#num { position:absolute; top:2px; left:110px; text-align:left; color:#fff; cursor:pointer}
#t_content{ font-size:13px}

/* 讨论区开始 */
#tab tbody { display:none;}

#tab .block { display:table-row-group;*display:block;}
#tab .up { color:#666; font-weight: bold;}
/* 讨论区结束 */
</style>
<SCRIPT type="text/javascript">
function isNew(){
	$.ajax({
			type:"post",
			url:"<?php echo site_url('panel/WelcomeController/newMsg') ?>",
			success: function(result)
			{
				if(result != ''){
					var data = result.split('||');
					if(data[0] != '')
					{
						$("#t_type").text(data[0]);
						$("#t_content").text(data[1]);
						$("#t_time").text(data[4]);
						$("#t_link").attr('href',data[2]);
						$("#t_detail").attr('href',data[2]);
						$("#pmid").val(data[3]);
						document.getElementById('winpop').style.height='0px';
						tips_pop();
					}
				}
			}
		});
}
function delInfo(){
	$.ajax({
			type:"post",
			url:"<?php echo site_url('panel/WelcomeController/delMsgInfo') ?>",
			data:"delid="+$("#pmid").val(),
			success: function(result)
			{
			}
		});
}

function delAll(){
	$.ajax({
			type:"post",
			url:"<?php echo site_url('panel/WelcomeController/delMsgAll') ?>",
			success: function(result)
			{
			}
		});

}

$(function(){
	$("#t_del").click(function(){
			tips_pop();
			delInfo();
			return false;
	})

	$("#close").click(function(){
			tips_pop();
			delInfo();
			return false;
	})

	$("#del_all").click(function(){
			tips_pop();
			delAll();
			return false;
	})

	$("#t_detail").click(function(){
			tips_pop();
			delInfo();

	})

	$("#t_link").click(function(){
			tips_pop();
			delInfo();
	})

	$("#next").click(function(){
			delInfo();
			isNew();
			return false;
	})
})

function tips_pop(){
	var MsgPop=document.getElementById("winpop");
	var popH=parseInt(MsgPop.style.height);//将对象的高度转化为数字
	if (popH==0){
		MsgPop.style.display="block";//显示隐藏的窗口
		show=setInterval("changeH('up')",2);
	}
	else {
		hide=setInterval("changeH('down')",2);
	}
}
function changeH(str) {
	var MsgPop=document.getElementById("winpop");
	var popH=parseInt(MsgPop.style.height);
	if(str=="up"){
		if (popH<=200){
			MsgPop.style.height=(popH+4).toString()+"px";
		}
		else{
			clearInterval(show);
		}
	}
	if(str=="down"){
		if (popH>=4){
			MsgPop.style.height=(popH-4).toString()+"px";
		}
		else{
			clearInterval(hide);
			MsgPop.style.display="none";  //隐藏DIV
		}
	}
}
function setContentTab(name,curr,n) {
    for (i = 1; i <= n; i++) {
        var menu = document.getElementById(name + i);
        var cont = document.getElementById("con_" + name + "_" + i);
        menu.className = i == curr ? "up" : "";
        if (i == curr) {
            if(window.ActiveXObject){
            	var browser=navigator.appName
		        var b_version=navigator.appVersion
		        var version=b_version.split(";");
		        var trim_Version=version[1].replace(/[ ]/g,"");
		        if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE7.0")
		        {
		           cont.style.display = "block";
		        }else{
		           cont.style.display = "table-row-group";
		        }
            }else{
                cont.style.display = "table-row-group";
            }
        } else {
            cont.style.display = "none";
        }
    }
}
<?php if(empty($userInfo['isPms'])){ ?>
/*window.onload=function(){
	isNew();
}
setInterval("isNew();",900*1000);*/
<?php } ?>
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top">
<?php if(!empty($birthday)){ ?>
<!-- 生日提醒 -->
<div class="tab_notice">
   <table class="table table-bordered table-striped tab_mb10" id="smpl_tbl">
     <thead>
      <tr>
        <th colspan="5">生日提醒：
        <?php echo "<font color=red>亲爱的".$this->session->userdata('userName')."，祝您生日快乐！^_^</font>"; ?>
        </th>
      </tr>
     </thead>
   </table>
</div>
<?php } ?>

<?php if(!empty($dailyInfo)){ ?>
<!-- 长时间未拜访客户提醒 -->
<div class="tab_notice">
   <table class="table table-bordered table-striped tab_mb10" id="smpl_tbl">
     <thead>
      <tr>
        <th colspan="5">超30天未拜访客户：
        <font color=red><?php echo implode('、',$dailyInfo);?></font>
        </th>
      </tr>
     </thead>
   </table>
</div>
<?php } ?>

<?php if(!empty($applyList)){ ?>
<!-- 我的申请单 -->
<div class="tab_notice">
   <table class="table table-bordered table-striped tab_mb10" id="smpl_tbl">
     <thead>
      <tr>
        <th colspan="5">我的申请单</th>
      </tr>
     </thead>
     <tbody>
      <tr class="line_grey2">
        <td>表单名称</td>
        <td>申请时间</td>
        <td>审批详情</td>
        <td>审批步骤</td>
        <td>操作</td>
      </tr>
      <?php foreach($applyList as $key=>$value){ ?>
      <tr>
        <td><?php echo $value['pendingType']; ?></td>
        <td><?php echo date('Y-m-d H:i:s',$value['createTime']); ?></td>
        <td><?php echo $value['username']; ?> <font color=green><?php echo ($value['username']==$this->session->userdata('userName') || $value['jobId']==5)?'确认':'审批'; ?>中</font></td>
        <td>第 <font color=red><?php echo $value['flowNode']; ?></font> 步</td>
        <td><a href="<?php echo site_url($value['urlAdress'].'/'.$value['tableId']); ?>" class="sepV_a" target="_blank">查看详情</a></td>
      </tr>
      <?php } ?>
     </tbody>
   </table>
</div>
<?php } ?>

<!-- 公告 -->
<div class="tab_notice">
     <table class="table table-bordered table-striped line_grey tab_mb10" width="100%">
      <thead>
       <tr>
         <th>公告</th>
         <th class="date_grey"><a href="<?php echo site_url('public/AnnounceController/announceList?type=1'); ?>" target="_blank">更多</a></th>
       </tr>
      </thead>
      <tbody>
      <?php foreach($newsListGg as $value){ ?>
       <tr>
         <td><i class="splashy-arrow_state_blue_right"></i><a href="<?php echo site_url('public/AnnounceController/announceDetail/'.$value['id']); ?>"><?php echo $value['title']; ?></a></td>
         <td class="date_grey"><?php echo date("m-d H:i",$value['createTime']); ?></td>
       </tr>
      <?php } ?>
      </tbody>
     </table>
</div>

<!-- 通知 -->
<div class="tab_notice">
     <table class="table table-bordered table-striped line_grey tab_mb10" width="100%">
      <thead>
       <tr>
         <th>通知</th>
         <th class="date_grey"><a href="<?php echo site_url('public/AnnounceController/announceList?type=2'); ?>" target="_blank">更多</a></th>
       </tr>
      </thead>
      <tbody>
      <?php foreach($voiceListTz as $value){ ?>
       <tr>
         <td><i class="splashy-arrow_state_blue_right"></i><a href="<?php echo site_url('public/AnnounceController/announceDetail/'.$value['id']); ?>"><?php echo $value['title']; ?></a></td>
         <td class="date_grey"><?php echo date("m-d H:i",$value['createTime']); ?></td>
       </tr>
      <?php } ?>
      </tbody>
     </table>
</div>

<!-- 讨论区 -->
<div class="tab_notice" id="tab">
     <table class="table table-bordered table-striped line_grey tab_mb10" width="100%">
      <thead>
       <tr>
         <th style="font-weight:normal;">
             <a href="javascript:void(0)" style="font-weight:bold;color:#000;" id="two1" class="up" onclick="setContentTab('two',1,8)">讨论区</a>&nbsp;&nbsp;&nbsp;
             <?php $i = 2; foreach($forumClass as $key=>$val){ ?>
             <a href="javascript:void(0)" id="two<?php echo $i; ?>" onclick="setContentTab('two',<?php echo $i; ?>,8)"><?php echo $val['className']; ?></a>&nbsp;&nbsp;
             <?php $i++; } ?>
         </th>
         <th class="date_grey"><a href="<?php echo site_url('office/ForumController/classList'); ?>" target="_blank">更多</a></th>
       </tr>
      </thead>
      <tbody class="block" id="con_two_1">
      <?php foreach($forumList as $value){ ?>
       <tr>
         <td><i class="splashy-arrow_state_blue_right"></i><a href="<?php echo site_url('office/ForumArtController/artDet/'.$value['id']); ?>" target="_blank" <?php if($value['type']=='2'){?>style="color:#FF0000;"<?php }?>><?php if($value['type']=='2'){echo '<b>精华:&nbsp;'.$value['title'].'</b>';}else {echo $value['title'];} ?></a>&nbsp;&nbsp;</td>
         <td class="date_grey"><?php echo $value['staff_name']; ?>&nbsp;<?php echo date('m-d H:i',$value['post_date']); ?></td>
       </tr>
      <?php } ?>
      </tbody>

      <?php
      for($a=0;$a<count($forumClass);$a++){ ?>
      	<tbody id="con_two_<?php echo $a+2; ?>">
        <?php foreach($forumArea[$a] as $key=>$value){ ?>
	       <tr>
	         <td><i class="splashy-arrow_state_blue_right"></i><a href="<?php echo site_url('office/ForumArtController/artDet/'.$value['id']); ?>" target="_blank"><?php echo $value['title']; ?></a>&nbsp;&nbsp;</td>
	         <td class="date_grey"><?php echo $value['staff_name']; ?>&nbsp;<?php echo date('m-d H:i',$value['post_date']); ?></td>
	       </tr>
       <?php } ?>
       </tbody>
     <?php } ?>
     </table>
</div>
</td>

<td width="350" align="left" valign="top"><!-- 个人办公 -->
<div class="tab_geren">
  <?php if(empty($deviceType)){ ?>
  <div class="well well_geren">
   <table width="100%" class="tab_gerenmin">
      <tbody>
       <tr>
           <td>
               <?php echo $nowDate; ?><br />
               <iframe width="200" scrolling="no" height="55" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=35&icon=1&num=3"></iframe>
           </td>
       </tr>
      </tbody>
   </table>
  </div>
  <?php } ?>

  <div class="well well_geren">
   <table width="100%" class="tab_gerenmin">
      <thead>
       <tr>
         <th align="left">个人办公</th>
       </tr>
      </thead>
      <tbody>
       <tr>
         <td>
             <table>
	             <tr>
	               <td><a href="<?php echo site_url('personnel/LeaveController/leaveListView'); ?>" target="_blank">本月已经请假<span class="geren_red"><?php if(!empty($numberLeave)):?><?php echo $numberLeave;?><?php else:?>0<?php endif;?></span>次</a></td>
	               <td><a href="<?php echo site_url('personnel/FalsesignController/falsesignListView'); ?>" target="_blank">本月已经误打卡<span class="geren_red"><?php if(!empty($numberFaslesign)):?><?php echo $numberFaslesign;?><?php else:?>0<?php endif;?></span>次</a></td>
	             </tr>
             </table>
         </td>
       </tr>
      </tbody>
   </table>
  </div>

  <div id="accordion2" class="accordion">
	  <div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseOne2" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle">
			<span class="geren_red">待处理事项：</span>&nbsp;您有<span class="geren_red"><?php echo $panelNum; ?></span>条事项等待处理</a>
		</div>
		<div class="accordion-body collapse" id="collapseOne2">
			<div class="accordion-inner">
			<?php if(!empty($panelList)){
				foreach($panelList as $key=>$value){
		    ?>
				<p><a href="<?php echo site_url($value['urlAdress'].'/'.$value['tableId']); ?>"><?php echo $value['pendingType']; ?>（<?php echo $value['username'].' '.date('Y-m-d H:i:s',$value['createTime']); ?>）</a></p>
			<?php }
			    if($panelNum>6){
			 ?>
                <p><a href="<?php echo site_url('panel/PanelController/panelList'); ?>" target="_blank" class="geren_red">进入查看更多</a></p>
			<?php } }?>
			</div>
		</div>
	  </div>
	  
      <div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapseThree2" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle <?php if(!empty($emailNum)):?>acc-in<?php endif;?>">
			<span class="geren_red">待查看邮件：</span>&nbsp;您有<span class="geren_red"><?php if(!empty($emailNum)):?><?php echo $emailNum;?><?php else:?>0<?php endif;?></span>封内部邮件未读</a>
		</div>
		<div class="accordion-body collapse <?php if(!empty($emailNum)):?>in<?php endif;?>" id="collapseThree2">
			<div class="accordion-inner">
				<?php if(!empty($emailNews)){
				foreach($emailNews as $key=>$value){ ?>
				<p><a href="<?php echo site_url("/public/EmailController/emailDetailView/".$value['id']."/1");?>"><span style="color:#09F"><?php echo $userArray[$value['from_uid']];?></span> <?php echo mb_substr($value['title'],0,16,'utf-8');?> (<?php echo date("m-d",$value['post_date']);?>)</a></p>
                <?php }
			    if($emailNum>6){ ?>
                <p><a href="<?php echo site_url("/public/EmailController/emailNreadView");?>" target="_blank" class="geren_red">进入查看更多</a></p>
                <?php } }?>
			</div>
		</div>
	  </div>
  </div>

  <div class="well well_geren">
   <table class="tab_line tab_list">
            <tr>
                <td colspan="4" class="tab_linetit">人事表单</td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('personnel/LeaveController/leaveListView'); ?>">请 假</a></td>
                <td><a href="<?php echo site_url('personnel/OverworkController/overworkListView'); ?>">加 班</a></td>
                <td><a href="<?php echo site_url('personnel/FalsesignController/falsesignListView'); ?>">误打卡</a></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="tab_linetit">公共表单</td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('public/UpdatebaseController/baseInfoEdit'); ?>">个人设置</a></td>
                <td><a href="<?php echo site_url('public/EmailController/emailListView'); ?>">内部邮件</a></td>
                <td><a href="<?php echo site_url('public/AnnounceController/announceList/?type=1'); ?>">公告通知</a></td>
                <td><a href="<?php echo site_url('public/JournalController/journalListView'); ?>">工作日志</a></td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('public/ContactsController/contList'); ?>">内部通讯</a></td>
                <td><a href="<?php echo site_url('office/ForumController/classList'); ?>">讨论专区</a></td>
                <td><a href="<?php echo site_url('panel/PanelController/panelList'); ?>">待办事项</a></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="tab_linetit">行政表单</td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('office/GoodsController/goodsList'); ?>">领料</a></td>
                <td><a href="<?php echo site_url('office/ToolsController/toolsList'); ?>">库存</a></td>
                <td><a href="<?php echo site_url('office/CallbackController/callbackList'); ?>">票务回收</a></td>
                <td><a href="<?php echo site_url('office/MadeController/madeList'); ?>">票务定制</a></td>
            </tr>
            <tr>
                <td colspan="4" class="tab_linetit">业务表单</td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('business/CustomerController/customerList'); ?>">客户管理</a></td>
                <td><a href="<?php echo site_url('business/ContractController/contractList'); ?>">合同管理</a></td>
                <td><a href="<?php echo site_url('business/BillingController/billingList'); ?>">开票管理</a></td>
                <td><a href="<?php echo site_url('business/CustomerContactController/customerContactListView'); ?>">客户联系人</a></td>
            </tr>
            <tr>
                <td><a href="<?php echo site_url('business/RetrieveController/retrieveList'); ?>">应收账款</a></td>
                <td><a href="<?php echo site_url('business/PaymentController/paymentList'); ?>">回款管理</a></td>
                <td><a href="<?php echo site_url('business/VisitController/visitList'); ?>">拜访管理</a></td>
                <td></td>
            </tr>
    </table>
  </div>
</div></td>
  </tr>
</table>

<div id="winpop">
	<div class="title"><img style="padding-top:5px" src="<?php echo base_url();?>img/lb.gif" border="0" />&nbsp;&nbsp; &nbsp;  <span class="word">系统信息</span><span class="closeWindow" id="close">[关闭]</span></div>
	<div class="con">
    <table width="100%">
    <tr>
    <td style="line-height:30px">
    <font color="#1598CA"><strong>&nbsp;&nbsp;&nbsp;<span id="t_type">站内短信</span>:</strong><strong>&nbsp;&nbsp;&nbsp;<span id="t_time"></span></strong></font>
    </td></tr>
    <tr valign="top">
    <td style="text-align:left; padding:10px" height="100">
    	<a href="#" target="_blank" id="t_link">
        	<font color="#FF6600"><b><span id="t_content"></span></b></font>
        </a>
    </td></tr>
    <tr>
    <td style="text-align:right">
    <font color="#FF0000"><strong>
    	<a href="" id="t_detail" target="_blank">
        	<font color="#ff0000">查看详情</font>
        </a>
        <input type="hidden" value="" name="pmid" id="pmid">
    	&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="" id="del_all">
        	<font color="#ff0000">全部已读</font>
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="" id="next">
        	<font color="#ff0000">下一条</font>
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="" id="t_del">
        	<font color="#ff0000">我知道了</font>
        </a>&nbsp;

    </strong></font>
    </td></tr>
    </table>
	</div>
</div>