<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ymPrompt/ymPrompt.js"></script>
<link  href="<?php echo $base_url;?>js/ymPrompt/skin/qq/ymPrompt.css" rel="stylesheet" type="text/css" />
<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
/* star */
#star{position:relative;width:600px;margin:20px auto;height:24px;}
#star ul,#star span{float:left;display:inline;height:19px;line-height:19px;}
#star ul{margin:0 10px;}
#star li{float:left;width:24px;cursor:pointer;text-indent:-9999px;background:url(<?php echo $base_url;?>img/star.png) no-repeat;}
#star strong{color:#f60;padding-left:10px;}
#star li.on{background-position:0 -28px;}
#star p{position:absolute;top:20px;width:159px;height:60px;display:none;background:url(<?php echo $base_url;?>img/icon.gif) no-repeat;padding:7px 10px 0;}
#star p em{color:#f60;display:block;font-style:normal;}
</style>
<script type="text/javascript">
window.onload = function (){
	var oStar = document.getElementById("star");
	var aLi = oStar.getElementsByTagName("li");
	var oUl = oStar.getElementsByTagName("ul")[0];
	var oSpan = oStar.getElementsByTagName("span")[1];
	var oP = oStar.getElementsByTagName("p")[0];
	var i = iScore = iStar = 0;


	for (i = 1; i <= aLi.length; i++){
		aLi[i - 1].index = i;
		<?php if(!empty($arr['score'])){ ?>
		fnPoint(<?php echo $arr['score']; ?>);
		<?php } ?>

		<?php if(empty($arr['score'])){ ?>
		//鼠标移过显示分数
		aLi[i - 1].onmouseover = function (){
			fnPoint(this.index);
			//浮动层显示
			oP.style.display = "block";
			//计算浮动层位置
			oP.style.left = oUl.offsetLeft + this.index * this.offsetWidth - 254 + "px";
			//匹配浮动层文字内容
			oP.innerHTML = "<em><b>" + this.index + "</b> 分 </em>";
		};

		//鼠标离开后恢复上次评分
		aLi[i - 1].onmouseout = function (){
			fnPoint();
			//关闭浮动层
			oP.style.display = "none"
		};

		//点击后进行评分处理
		aLi[i - 1].onclick = function (){
			iStar = this.index;
            $.ajax({
              type:"post",
              data:"score="+iStar+"&pId="+<?php echo $arr['pId']; ?>,
              async: false,
              url:"<?php echo $base_url;?>index.php/public/DailyController/setScore",
              success:function(result){
              	 if(result == 'N'){
              	 	alert('暂无评分权限！');
              	 }else if(result == 'Y'){
              	 	alert('打分成功！');
              	 }
              }
            });
			oP.style.display = "none";
			oSpan.innerHTML = "<strong>" + (this.index) + " 分</strong> (" + aMsg[this.index - 1].match(/\|(.+)/)[1] + ")"
		}
		<?php } ?>
	}

	//评分处理
	function fnPoint(iArg){
		//分数赋值
		iScore = iArg || iStar;
		for (i = 0; i < aLi.length; i++) aLi[i].className = i < iScore ? "on" : "";
	}

};


</script>
<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>

            <tr valign="middle">
                <td width="10%" style="text-align: center;"><span class="bold">日期</span></td>
                <td><?php echo date('Y-m-d',$arr['startDate']); ?></td>
                <td width="10%" style="text-align: center;"><span class="bold">日志标题</span></td>
                <td><?php echo $arr['dailyTitle']; ?></td>
            </tr>
            
           <tr>
                <td width="5%" align="center" style="text-align: center;"><b>拜访情况</b></td>
                <td colspan="5">
                    <table id="tbl_info" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;width: 150px;"><b>客户名称</b></td>
                            <td style="text-align: center;"><b>客户姓名</b></td>
                            <td style="text-align: center;"><b>拜访形式</b></td>
                            <td style="text-align: center;"><b>洽谈内容</b></td>
                            <td style="text-align: center;"><b>下次行动计划(限期)</b></td>
                        </tr>
                        <?php $i = 1;foreach($result as $value):?>
                        <tr>
                            <td style="text-align: center;"><?php echo $i;?></td>
                            <td><?php echo $clientArray[$value['clientName']];?></td>
                            <td><?php echo $value['userName'];?></td>
                            <td><?php echo $shape[$value['shape']];?></td>
                            <td><?php echo $value['content'];?></td>
                            <td><?php echo $value['plan'];?></td>
                        </tr>
                        <?php $i++;endforeach;?>
                    </table>
                </td>
            </tr>

            <tr>
                <td width="5%" align="center" style="text-align: center;"><b>明日计划</b></td>
                <td colspan="5">
                    <table id="tbl_info2" cellpadding="4" cellspacing="0" width="100%" border="1" bordercolor="#bdebff">
                        <tr>
                            <td width="6%" style="text-align: center;"><b>序号</b></td>
                            <td style="text-align: center;"><b>上午</b></td>
                            <td style="text-align: center;"><b>目标</b></td>
                            <td style="text-align: center;"><b>下午</b></td>
                            <td style="text-align: center;"><b>目标</b></td>
                        </tr>
                        <?php $i = 1;foreach($rows as $value):?>
                        <tr>
                            <td style="text-align: center;"><?php echo $i;?></td>
                            <td><?php echo $value['morning'];?></td>
                            <td><?php echo $value['mTarget'];?></td>
                            <td><?php echo $value['afternoon'];?></td>
                            <td><?php echo $value['aTarget'];?></td>
                        </tr>
                        <?php $i++; endforeach;?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>其他工作</b></td>
                <td colspan="8">
                    <?php echo nl2br($arr['other']);?>
                </td>
            </tr>
            <tr>
                <td width="10%" style="text-align:center;"><b style="color:red">工作日志打分</b></td>
                <td colspan="3"><span id="star">
		        <ul>
			        <li><a href="javascript:;">1</a></li>
			        <li><a href="javascript:;">2</a></li>
			        <li><a href="javascript:;">3</a></li>
			        <li><a href="javascript:;">4</a></li>
			        <li><a href="javascript:;">5</a></li>
			        <li><a href="javascript:;">6</a></li>
			        <li><a href="javascript:;">7</a></li>
			        <li><a href="javascript:;">8</a></li>
			        <li><a href="javascript:;">9</a></li>
			        <li><a href="javascript:;">10</a></li>
		       </ul>
                   <span></span>
		           <p></p>
	            </span></td>
            </tr>
            <tr>
                <td width="10%" style="text-align:center;"><b style="color:red">工作日志评价</b></td>
                <?php if(!empty($arr['remarks'])):?>
                <td colspan="8">
                    <?php echo $arr['remarks'];?>
                </td>
                <?php else:?>
                <td colspan="8">
                    <textarea name="remarks" id="remarks" style="width:300px;" rows="2"></textarea>
                </td>
                <?php endif;?>
            </tr>
            <?php if(!empty($arr['score'])):?>
            <tr>
                <td width="10%" style="text-align:center;"><b style="color:red">评价人</b></td>
                <td colspan="4"><?php if(!empty($arr['uId'])):?><?php echo $userArray[$arr['uId']];?>&nbsp;于&nbsp;<?php echo date("Y-m-d H:i:s",$arr['evaTime']);?>评价<?php endif;?></td>
            </tr>
            <?php endif;?>

            <tr>
                <td colspan="4" style="text-align:center;">
                <input type="hidden" value="<?php echo $arr['pId'];?>" name="pId" id="pId" />
                <?php if(empty($score) && $this->session->userdata('jobId')<5){ ?>
                <button class="btn btn-gebo" type="submit" name="submitCreate" value="添加" style="margin-right: 20px;">保存内容</button>
                <?php } ?>
                <button type="button" class="btn" onClick="javascript:history.go(-1)">我要返回</button></td>
           </tr>
        </tbody>
    </table>
</form>
