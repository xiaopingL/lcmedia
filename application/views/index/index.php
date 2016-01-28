<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title;?></title>
        <link rel="shortcut icon" href="<?php echo $base_url;?>favicon.ico"/>
        <!-- Bootstrap framework -->
        <link rel="stylesheet" href="<?php echo $base_url;?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $base_url;?>css/bootstrap-responsive.min.css" />
        <!-- gebo blue theme-->
        <link rel="stylesheet" href="<?php echo $base_url;?>css/blue.css" />
        <!-- tooltips-->
        <link rel="stylesheet" href="<?php echo $base_url;?>css/jquery.qtip.min.css" />
        <!-- main styles -->
        <link rel="stylesheet" href="<?php echo $base_url;?>css/style.css" />
        <!-- breadcrumbs-->
        <link rel="stylesheet" href="<?php echo $base_url;?>css/BreadCrumb.css" />
        <!-- pic -->
        <link rel="stylesheet" href="<?php echo $base_url;?>img/splashy/splashy.css" />
        <!--[if lte IE 8]>
        <link rel="stylesheet" href="<?php echo $base_url;?>/css/ie.css" />
            <script src="<?php echo $base_url;?>/js/ie/html5.js"></script>
                    <script src="<?php echo $base_url;?>/js/ie/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo $base_url;?>js/jquery.min.js"></script>
        <script>
            //* hide all elements & show preloader
            document.documentElement.className += 'js';
        </script>
        <block name="expandTop">
        </block>
    </head>
    <body>
        <!--<div id="loading_layer" style="display:"><img src="<?php echo $base_url;?>/img/ajax_loader.gif" alt="" /></div>-->
        <div id="maincontainer" class="clearfix">
		<table width="99%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td colspan="2" valign="top">
			<div style="height:41px;overflow:hidden;width: 100%;">
			<!-- header -->
			<?php echo $navbar;?>
			<!-- header end -->
			</div>
			</td>
		  </tr>
		  <tr>
		  <td width="200" align="left" valign="top">
			<!-- sidebar -->
			<!--<a href="javascript:void(0)" class="sidebar_switch on_switch ttip_r" title="Hide Sidebar">Sidebar switch</a>-->
			<div class="sidebar2">
			<div class="antiscroll-content">
				<div class="sidebar_inner">
					<!--<form action="" class="input-append" method="post" >
					</form>-->
					<div id="side_accordion" class="accordion">
						<?php echo $sidebar;?>
					</div>
				</div>
			</div>
			</div>
			<!-- sidebar end --></td>
			<td align="left" valign="top">
			<!-- main content -->
			<div id="contentwrapper">
				<div class="main_content">
					<nav>
						<div id="jCrumbs" class="breadCrumb module">
							<ul>
								<li>
									<a href="#"><i class="icon-home"></i></a>
								</li>
								<block name="navLI">
									<li><?php echo $directory; ?></li>
								</block>
							</ul>
						</div>
					</nav>
				   <?php if($this->session->flashdata('suggestion')): ?>
				   <DIV class="subtable suggest"  style="WIDTH: 98%">
				   <DIV style="MARGIN: 6px" align="center"><?php echo $this->session->flashdata('suggestion');?></DIV>
				   </DIV>
				   <br />
				   <?php endif;?>
				   <?php echo $content;?>
				</div>
			</div>
			<!-- main content end -->
			</td>
		  </tr>
		</table>
		</div>
        <script src="<?php echo $base_url;?>js/jquery-migrate.min.js"></script>
        <!-- smart resize event -->
        <script src="<?php echo $base_url;?>js/jquery.debouncedresize.min.js"></script>
        <!-- hidden elements width/height -->
        <script src="<?php echo $base_url;?>js/jquery.actual.min.js"></script>
        <!-- js cookie plugin -->
        <script src="<?php echo $base_url;?>js/jquery_cookie.min.js"></script>
        <!-- main bootstrap js -->
        <script src="<?php echo $base_url;?>js/bootstrap.js"></script>
        <!-- bootstrap plugins -->
        <script src="<?php echo $base_url;?>js/bootstrap.plugins.min.js"></script>
        <!-- tooltips -->
        <script src="<?php echo $base_url;?>js/jquery.qtip.min.js"></script>
        <!-- fix for ios orientation change -->
        <script src="<?php echo $base_url;?>js/ios-orientationchange-fix.js"></script>
        <!-- scrollbar -->
        <script src="<?php echo $base_url;?>js/antiscroll.js"></script>
        <script src="<?php echo $base_url;?>js/jquery-mousewheel.js"></script>
        <!-- mobile nav -->
        <script src="<?php echo $base_url;?>js/selectNav.js"></script>
        <!-- common functions -->
        <script src="<?php echo $base_url;?>js/gebo_common.js"></script>
        <script src="<?php echo $base_url;?>js/jquery.validate.min.js"></script>
        <script src="<?php echo $base_url;?>js/crm_validation.js"></script>
        <script src="<?php echo $base_url;?>js/base.js"></script>
        <script src="<?php echo $base_url;?>js/lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>
        <block name="expandBottom">
        </block>
        <script>
            $(document).ready(function() {
                setTimeout('$("html").removeClass("js")',0);
            });
        </script>
    </body>
</html>


