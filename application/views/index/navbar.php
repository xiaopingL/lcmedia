<!--TOP-->
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
	  <div class="container-fluid" style="position: relative;">
	    <div style="float:left;">
		  <a class="brand" href="<?php echo site_url('panel/WelcomeController/welcome') ?>"><img style="float:left;" src="<?php echo base_url(); ?>img/kx_logo.png" alt="" border="0" /></a>
		</div>
		
		  <ul class="nav user_menu pull-right" style="position: absolute;top: 0px;left:90%">
              <li class="divider-vertical hidden-phone hidden-tablet"></li>
              <li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata('userName'); ?> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					  <li><a href="<?php echo site_url('home/logOut') ?>">退出系统</a></li>
				  </ul>
			  </li>
		  </ul>
    </div>
  </div>
</div>