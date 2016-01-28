
<?php if($state == 0){?>
<span style="color:#06F;">审批中</span>
<?php }elseif($state == 1){?>
<span style="color:green;">审批成功</span>
<?php }else{?>
<span style="color:red;">申请失败</span>
<?php }?>