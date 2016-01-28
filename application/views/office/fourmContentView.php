<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    	<style type="text/css">
	        *{margin:0;padding:0}
			p{padding:0 0 10px 0;}
			body{font-family:"Microsoft yahei";line-height:1.5;background:#f6f6f6;}
			.bbs_wrap{padding:20px;}
			.bbs_stitle { margin:10px 0 0 0; color:#999;}
			.bbs_stitle span { padding-right:30px;}
			.bbs_content{color:#333; padding:30px 0; }
			.bbs_content img{max-width:100%;}
			.bbs_reply ul li{ background:#fff; border:1px solid #ddd; padding:10px;list-style:none; margin-bottom:15px;}
			.bbs_reply p span{ padding-left:20px;}
			.bbs_reply p:first-child{ color:#666;}
        </style>
    </head>
    <body>
    <div class="bbs_wrap">
    	<h2><?php echo $discuss_title; ?></h2>
        <div class="bbs_stitle"><span><?php echo $user_name; ?>[<?php echo !empty($department_name)?$department_name:'暂无'; ?>]</span><span><?php echo date("Y-m-d H:i",$discuss_time);?></span><span>点击<font style=" color:#F00"><?php echo $click_number; ?></font>次</span></div>
        <div class="bbs_content">
        <?php echo $content;?>
        </div>
        <?php if(!empty($result)){ ?>
        <div class="bbs_reply">
        	<ul>
        	    <?php foreach($result as $value):?>
            	<li>
                	<p><?php echo $value['user_name']?>[<?php echo $value['department_name']?>]<span><?php echo date("Y-m-d H:i:s",$value['reply_time']);?></span></p>
                    <p><?php echo $value['reply_content']?></p>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php } ?>
    </div>

    </body>
</html>
