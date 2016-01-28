<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/ymPrompt/ymPrompt.js"></script>
<link  href="<?php echo $base_url;?>js/ymPrompt/skin/qq/ymPrompt.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script type="text/javascript">
    function passSet(){
        if(document.getElementById("title").value != ''){
            return true;
        }else{
            alert("搜索不能为空！");
            document.getElementById("title").focus();
            return false;
        }
    }
</script>
<script language="javascript">
    //实例化ajax
    function xml(){
        var xmlhttp
        if(window.ActiveXObject){
            xmlHttp= new ActiveXObject('Microsoft.XMLHTTP');
        }else if(window.XMLHttpRequest){
            xmlHttp= new XMLHttpRequest();
        }
    }
    function ajaxWqk(){
        var value = document.getElementById('select').value;
        xml();
        if(value!=""){
            ran=Math.ceil(Math.random()*10000);
            url="<?php echo site_url('/office/ForumController/forumSubClass');?>"+"/ran/"+ran;
            //document.write(url);
            xmlHttp.open("GET",url,true);
            xmlHttp.onreadystatechange=jsWqk;
            document.getElementById('select').innerHTML='正在加载...';
            xmlHttp.send(null);
        }

    }

    function jsWqk(){
        //alert(xmlHttp.readyState);
        if(xmlHttp.readyState == 4){

            if(xmlHttp.status == 200){
                document.getElementById('select').innerHTML=xmlHttp.responseText;
            }
        }
    }
    window.onload=function(){
        ajaxWqk();
    }
</script>
<table data-provides="rowlink" style="margin-bottom:4px;">
    <form method="post" action="<?php echo site_url('/office/ForumArtController/forumArtList');?>" onsubmit="if(!passSet())return false;">
        <thead>
            <tr>
                <th valign="middle">
                    搜索:&nbsp;&nbsp;<select name="department" class="span1">
                        <option value="1">标题</option>
                        <option value="2">作者</option>


                    </select>
                    <input type="text" name="title" id="title" class="input-medium span2" value="<?php if(!empty($title1)) echo $title;?>" >


                </th>
                <th valign="middle">
                    <button type="submit" class="btn btn-success">
                        搜&nbsp;&nbsp;索
                    </button>
                </th>
                <?php if(in_array('addForum',$userOpera)) {?><th>&nbsp;<button type="button" class="btn btn-success" onclick="location.href='<?php echo site_url("office/ForumController/forumClassAdd");?>'">新建讨论区</button></th><?php } ?>
            </tr>
        </thead>
    </form>
</table>
<div class="well well_classmar">
    <!-- 列表 -->
    <table class="table table-condensed">
        <thead>
            <tr>
                <th width="50%">讨论区</th>
                <th width="5%">主题数</th>
                <th width="5%">评论数</th>
                <th width="15%">最后发表</th>
                <th width="25%">最后评论</th> 
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($arr)):?>
                <?php foreach($arr as $value):?>

            <tr class="rowlink">

                <td width="10%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url("office/ForumArtController/forumArtList/"."?cid=".$value['id']);?>"><?php echo $value['className']; ?></a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF6600"><?php echo $value['classMemo'];?></font>							

                </td>
                <td width="10%"><?php echo $value['topicNum']; ?></td>
                <td width="10%"><?php echo $value['commentNum']; ?></td> 
                <td width="10%"><?php if(!empty($value['lasttopicStaff'])){echo date('Y-m-d H:i',$value['lasttopicDate']),'<br />&nbsp;&nbsp;&nbsp;&nbsp;by&nbsp;',$value['lasttopicStaff'];} ?></td>
                <td width="10%"><?php if(!empty($value['lastcommentStaff'])){echo date('Y-m-d H:i',$value['lastcommentDate']),'<br />&nbsp;&nbsp;&nbsp;&nbsp;by&nbsp;',$value['lastcommentStaff'];} ?></td>

            </tr>           
                <?php endforeach;?>
            <?php else:?>
            <tr><td colspan="7" style="text-align:center">您查看的记录为空</td></tr>
            <?php endif;?>
        </tbody>
    </table>

</div>
