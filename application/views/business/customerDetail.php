<table class="table table-bordered table-striped" id="smpl_tbl">
    <tr>
        <td class="bold"><?php echo $status==1?'影城':'客户';?>名称</td>
        <td colspan="7"><?php echo $info['name']?></td>
    </tr>
    <tr>
        <td class="bold">姓名</td>
        <td><?php echo $info['telName']?></td>
        <td class="bold">号码</td>
        <td>
            <?php echo $info['telNumber']?></td>
        <td class="bold">职位</td>
        <td>
            <?php echo $info['telPosition']?></td>
        <td class="bold">性别</td>
        <td>
            <?php if($info['sex']==1){echo '男';}else{echo '女';}?>
        </td>
    </tr>
    <tr>
        <td class="bold">生日</td>
        <td><?php echo $info['birthday']?></td>
        <td class="bold">属相</td>
        <td>
            <?php foreach($CustomerArray['zodiac'] as $key=>$val){
                if($info['zodiac'] == $key){echo $val;}
            }?>
        </td>
        <td class="bold">星座</td>
        <td>
            <?php foreach($CustomerArray['constellatory'] as $key=>$val){
                if($info['constellatory'] == $key){echo $val;}
            }?>
        </td>
        <td class="bold">血型</td>
        <td>
            <?php foreach($CustomerArray['bloodType'] as $key=>$val){
                if($info['bloodType'] == $key){echo $val;}
            }?>
        </td>
    </tr>
    <tr>
        <td class="bold">籍贯</td>
        <td><?php echo $info['nativePlace']?></td>
        <td class="bold">毕业院校</td>
        <td><?php echo $info['academy']?></td>
        <td class="bold">备注</td>
        <td colspan="3"><?php echo $info['hobby']?></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
</table>