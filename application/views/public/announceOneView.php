<form method="post" action="" class="form_validation_ttip"  novalidate="novalidate">
    <table class="table table-bordered table-striped" id="smpl_tbl">
        <tbody>
            <tr>
                <td> 提报人</td>
                <td><?=$info[$operator]?></td>
            </tr>
            <tr>
                <td width="15%">标题</td>
                <td><?php echo $title;?></td>
            </tr>
            <tr>
                <td width="15%">内容</td>
                <td>
                    <?php echo $content;?>
                </td>
            </tr>
            <tr>
                <td width="15%">创建时间</td>
                <td><?php echo date('Y-m-d h:i:s',$createTime)?></td>
            </tr>
            <tr>
                <td width="15%">类别</td>
                <td><?php echo $config_new[$type]; ?></td>
            </tr>
            <tr>
                <td width="15%">附件</td>
                <td><a href="<?php echo site_url("public/FileController/downloadApp/".$annex)?>"><?php echo $origName;?></a></td>
            </tr>
             <tr>
                <td>审批详情</td>
                <td ><?php echo $this->load->view('index/approveDetail'); ?></td>
            </tr>
        </tbody>
    </table>
</form>