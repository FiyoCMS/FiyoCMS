<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo SiteTitle; ?></title>
<meta name="robots" content="index, follow" />
<meta name="keywords" content="<?php echo MetaKeys;  ?>" />
<meta name="description" content="<?php echo MetaDesc;  ?>" />
<meta name="generator" content="Fiyo CMS id Very Simple Content Management System!" />

<link rel="shortcut icon" href="<?php echo FThemePath; ?>/favicon.png" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo FThemePath; ?>/css/m_style.css" media="screen" />
<link rel="stylesheet" href="<?php echo FThemePath; ?>/css/easyprint.css" media="print" />

<script src="<?php echo FThemePath;?>/js/jquery.min.js" type="text/javascript" ></script>
<script src="<?php echo FThemePath;?>/js/easy.js" type="text/javascript"></script>
<script src="<?php echo FThemePath;?>/js/main.js" type="text/javascript" ></script>

</head>
<body>
<div id="container">
		
	<div id="header" class="full">			
		<a href="<?php echo FUrl; ?>"><?php if(app_param('view')!='item') echo "<h1>"; else echo "<h2>" ?><div id="logo"><?php echo SiteName ?></div><span><?php echo MetaDesc ?></span><?php if(app_param('view')!='item') echo "</h1>"; else echo "</h2>" ?></a>
		
		<div class="full" >
				<?php echo modules('mainmenu') ?>
		</div>
	</div>
		<?php echo loadApps(); ?>
		<?php echo modules('footer') 
		
		
		
		
		
		?>			
	</div>
		
		<a href="?browser=desktop">Desktop View</a>
	
</body>
</html>