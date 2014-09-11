<?php defined('_FINDEX_') or die('Access Denied!'); ?>
<!DOCTYPE html>
<html lang="<?php echo SiteLang;  ?>">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />
	<title><?php echo FTitle; ?></title>
	<meta name="robots" content="<?php echo MetaRobots;  ?>" />
	<meta name="keywords" content="<?php echo MetaKeys;  ?>" />
	<meta name="description" content="<?php echo MetaDesc;  ?>" />
	<meta name="generator" content=" Fiyo CMS Integrate Design Easily!" />
	<?php loadAppsCss(); ?>
	<?php loadModuleCss(); ?>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo FThemePath; ?>/css/images/favicon.ico" />
	<link rel="stylesheet" href="<?php echo FThemePath; ?>/css/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo FThemePath; ?>/css/font.css" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo FThemePath; ?>/js/jquery-2.0.3.min.js"></script>
	<script src="<?php echo FThemePath; ?>/js/functions.js" type="text/javascript"></script>
</head>
<body>
	<!-- wraper -->
	<div id="wrapper">
		<!-- shell -->
		<div class="shell">
			<!-- container -->
			<div class="container">
				<!-- header -->
				<header id="header">
					<div id="logo"><a href="<?php echo FUrl; ?>"><?php echo SiteName; ?></a>
					<span><?php echo SiteTitle; ?></span></div>
					<!-- search -->
					<div class="search">
						<?php echo loadModule('search') ?>
					</div>
					<!-- end of search -->
				</header>
				<!-- end of header -->
				<!-- navigation -->
				<nav id="navigation">	
					<a href="#" class="nav-btn">HOME<span class="arr"></span></a>
					<?php echo loadModule('mainmenu') ?>
				</nav>
				<!-- end of navigation -->
				<!-- slider -->
				<div class="m-slider">
					<?php loadModule('slide');?>
				</div>		
				<!-- end of slider -->
				
				<!-- main -->
				<div class="main">
				<?php if(checkModule('top')) : ?>		
					<section class="cols">
						<div class="col">							
							<?php loadModule('top1');?>
						</div>
						<div class="col">				
							<?php loadModule('top2');?>
						</div>
						<div class="col">				
							<?php loadModule('top3');?>
						</div>
						<div class="cl"></div>
					</section>
				<?php endif; ?>
					<section class="post">
						<?php if(checkModule('right')) : ?>
						<div class="col left-box">
						<?php else : ?>
						<div class="col">
						<?php endif; ?>
							<?php loadApps(); ?>
						</div>		
						<?php if(checkModule('right')) : ?>
						<div class="col  right-box">			
							<?php loadModule('right');?>
						</div>
						<?php endif; ?>
						
					</section>

						<div class="cl"></div>
				
				</div>
				<!-- end of main -->
				
				<?php if(checkModule('breadchumb')) : ?>	
				<div class="socials">
					<div class="socials-inner">									
							<?php loadModule('breadchumb');?>						
						<div class="cl"></div>
					</div>
				</div>					
				<?php endif; ?>	
				
				<div id="footer">
					<div class="footer-bottom">
						<p class="copy">© Copyright <?php echo siteConfig('site_name')." ".date("Y"); ?><br/><strong>My Engine is <a href="http://www.fiyo.org" target="_blank">Fiyo CMS</a></strong></p>
						<div class="cl"></div>
					</div>
				</div>
			</div>
			<!-- end of container -->	
		</div>
		<!-- end of shell -->	
	</div>
	<!-- end of wrapper -->
</body>
</html>