<div style="width:100%;">
    <?php foreach($attendance as $k=>$v) {?>
         <?php if($v!=$carname) {?>
         <span>|&nbsp;&nbsp;<a href="<?= site_url("public/$k");?>" ><font style="font-weight:bold"><?=$v?></font></a>&nbsp;&nbsp;</span>
         <?php }elseif($v==$carname) {?>
         <span>|&nbsp;&nbsp;<a href="<?= site_url("public/$k");?>" ><font style="color:gray;font-weight:bold"><?=$v?></font></a>&nbsp;&nbsp;</span>
         <?php }?>
    <?php }?>
</div><br>