<form action="<?php echo site_url('/business/ContractController/contractFileUpload');?>" method="post" class="form_validation_ttip" enctype="multipart/form-data" id="mainform" name="mainform">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td width="10%"><b>图片文件上传</b></td>
                <td>
                    <div id="main">
                        <div class="demo">
                            <div class="aa" style="width:70%;height: auto;float:left;">
                                <div class="btn" style="margin-left:5px;color: black;"><span>添加附件</span><input id="fileupload" type="file" name="mypic"></div>
                                <div class="progress" style="float:left;">
                                    <span class="bar"></span><span class="percent">0%</span>
                                </div>
                            </div>
                            <div class="files" style="margin-left:5px;float:left;width:70%;height:25px;margin-top:-5px;">&nbsp;</div>
                            <div id="showimg"></div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align:center;">
                    <input type="hidden" value="<?php echo $contractId;?>" name="contractId" id="contractId"/>
                    <button class="btn1 btn-gebo" type="submit" style="margin-right: 20px;border-radius: 4px;height: 30px;width:80px;">
						保存内容
                    </button>
                    <button type="reset" class="btn1 btn-gebo" style="margin-right: 20px;border-radius: 4px;height: 30px;width:60px;">
						重置
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<style type="text/css">
    .contractfile{ width:100%; height:auto;}
    ul{list-style-type: none; width:800px;}
    .contractfile ul li{
        max-width: 350px;  height: auto; float:left; padding:5px; background: #CCC; margin-right: 5px;margin-top: 5px;
    }
    }
</style>
<table class="table table-bordered table-striped" id="smpl_tbl">
    <tbody>
        <tr>
            <td width="100%"><b>合同模板图册</b></td>
        </tr>
    </tbody>
</table>
<div class="contractfile">

    <?php foreach($contracArrayNew as $value):?>
    <ul>
        <li>
            <?php $pathArr = explode('application',$value['filePath']);?>
            <img src="<?php echo base_url();?>application<?php echo $pathArr['1'];?><?php echo $value['fileName'];?>"/><br/>
            <span style="display: block; width: auto;">
                <a href="<?php echo site_url("/public/FileController/downloadApp/".$value['fId']);?>"><?php echo mb_substr($value['origName'],0,15,'utf-8');?>&nbsp;&nbsp;<img border="0" align="absmiddle" src="<?php echo $base_url;?>img/attachment.gif" title="有附件">下载</a>&nbsp;&nbsp;
                <a href="<?php echo site_url('/business/ContractController/contractFileDel/'.$value['fileId']);?>" style="float: right;">删除</a>
            </span>
        </li>

    </ul>
    <?php endforeach;?>
</div>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.form.js"></script>
<script type="text/javascript">
    $(function () {
        var bar = $('.bar');           //进度条宽度
        var percent = $('.percent');   //进度条进度
        var showimg = $('#showimg');
        var progress = $(".progress"); //显示进度条
        var files = $(".files");       //文件名称
        var btn = $(".btn span");      //上传附件按钮
        $("#fileupload").wrap("<form id='myupload' action='<?php echo site_url("/public/EmailController/upload");?>' method='post' enctype='multipart/form-data'></form>");
        $("#fileupload").change(function(){ //选择文件
            $("#myupload").ajaxSubmit({
                dataType:  'json', //数据格式为json
                beforeSend: function() { //开始上传
                    showimg.empty(); //清空显示的图片
                    progress.show(); //显示进度条
                    var percentVal = '0%'; //开始进度为0%
                    bar.width(percentVal); //进度条的宽度
                    percent.html(percentVal); //显示进度为0%
                    btn.html("上传中..."); //上传按钮显示上传中
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%'; //获得进度
                    bar.width(percentVal); //上传进度条宽度变宽
                    percent.html(percentVal); //显示上传进度百分比
                },
                success: function(data) { //成功
                    //获得后台返回的json数据，显示文件名，大小，以及删除按钮
                    files.html("<b><a href='<?php echo site_url("/public/FileController/emailLoad");?>/"+data.fid+"'>"+data.origName+"</a>("+data.fileSize+"k)<input type='hidden' value='"+data.fid+"' id='include' name='include'/><input type='hidden' value='"+data.bfs+"' id='bfs' name='bfs'/></b>  <span class='delimg' rel='"+data.pic+"'>删除</span>");
                    if(data.fid != ''){
                        bar.width(data.bfs+'%');
                        percent.html(data.bfs+'%');
                    }
                    //显示上传后的图片
                    //var img = "http://demo.helloweba.com/upload/files/"+data.pic;
                    //showimg.html("<img src='"+img+"'>");
                    btn.html("添加附件");
                },
                error:function(xhr){ //上传失败
                    btn.html("上传失败");
                    bar.width('0');
                    files.html(xhr.responseText); //返回失败信息
                }
            });
        });
        $(".delimg").live('click',function(){
            var pic = $(this).attr("rel");
            $.post("<?php echo site_url("/public/EmailController/upload");?>?act=delimg",{imagename:pic},function(msg){
                if(msg==1){
                    files.html("删除成功.");
                    showimg.empty();
                    progress.hide();
                }else{
                    alert(msg);
                }
            });
        });

    });
</script>
<style type="text/css">
    .btn{position: relative;overflow:hidden;display:
             block;width:100px; height: 20px;margin-right: 4px;display:inline-
             block;padding:4px 10px 4px;font-size:14px;color:#fff;text-align:center;vertical-align:middle;cursor:pointer;border:1px solid
             #cccccc;float: left;margin-bottom:8px;}
    .btn input {position: absolute;top: 0; right: 0;margin:
                    0;border: solid transparent;opacity: 0;filter:alpha(opacity=0);
                cursor: pointer;}
    .progress { position:relative; margin-left:5px;  width:200px;padding: 1px;  border-radius:3px; display:none;margin-top: 5px;}
    .bar {background-color: green; display:block; width:0%;
          height:20px;  }
    .percent { position:absolute; height:20px; display:inline-block;
               top:3px; left:2%; color:#fff }
    .files{height:22px; line-height:22px; margin-top:5px;}
    .delimg{margin-left:20px; color:#090; cursor:pointer}
</style>
