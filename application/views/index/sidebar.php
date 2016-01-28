<!--LEFT-->
<?php foreach($allRole as $key=>$value){
	if(in_array($value['comCode'],$userRole)){
?>

<div class="accordion-group ">
	<div class="accordion-heading">
		<a href="#collapse<?php echo $key; ?>" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
			<i class="icon-th"></i> <?php echo $value['comeName']; ?>
		</a>
	</div>
	<div class="accordion-body collapse <?php if($type == $value['comCode']) echo $in;?>" id="collapse<?php echo $key; ?>" >
		<div class="accordion-inner">
			<ul class="nav nav-list">
			    <?php foreach($value['child'] as $val){
			        if(in_array($val['comCode'],$userRole)){
			          $class = explode('/',$val['codeUrl']);
			          $style = ($inClass == $class[2])?'icon-star':'icon-star-empty';
			    ?>
				<li><a href="<?php echo site_url($val['codeUrl'])?>"><i class="<?php echo $style; ?>"></i> <?php echo $val['comeName'] ?></a></li>
			    <?php } }?>
			</ul>
		</div>
	</div>
</div>
<?php } }?>



