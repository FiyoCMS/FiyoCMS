<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="canonical" href="{getUrl}" />
<title>{siteTitle}</title>
<meta name="author" content="{MetaAuthor}" />
<meta name="robots" content="{MetaRobots}" />
<meta name="keywords" content="{MetaKeys}" />
<meta name="description" content="{MetaDesc;  ?>" />
<meta name="generator" content="Fiyo CMS id Very Simple Content Management System!" />

<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" />
<link rel="stylesheet" href="css/style.css" media="screen" />
<link rel="stylesheet" href="css/easyprint.css" media="print" />

<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/easy.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>

	
	<script type="text/javascript" src="js/script/shCore.js"></script>
	<script type="text/javascript" src="js/script/shBrushJScript.js"></script>	
	<script type="text/javascript" src="js/script/shBrushCpp.js"></script>	
	<script type="text/javascript" src="js/script/shBrushVb.js"></script>	
	<script type="text/javascript" src="js/script/shBrushCss.js"></script>
	<script type="text/javascript" src="js/script/shBrushPhp.js"></script>	
	<link type="text/css" rel="stylesheet" href="styles/shCore.css"/>
	
	<script type="text/javascript">SyntaxHighlighter.all();</script>
	
	
<script>
$(function() {
    var $sidebar   = $("#navigation"), 
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 0;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            });
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            });
        }
    });
    
});
</script>
</head>
<body>
<div id="header">			
	<div id="container">
		<div id="logo"><h1><a href="{siteurl}">{siteTitle}</a></h1></div>
		<div class="right top">
			
		{module:top}
			
		</div>
		
	</div>
	
</div>	

<div id="container">
	<div id="navigation">
		{module:mainmenu}
	</div>
</div>

<div id="container">
	{module:slide}
	<div class="content">	
		{chkmod:right}			
			<div class="main box">
		{else:}		
			<div class="full box">
		{/chkmod}		
	
		{module:top-content}
			{loadApps}		
			
		</div>
		 
		{chkmod:right} 
		<div class="secondary">				
			{module:top-right}	
			{module:right}	
			
		</div>
		{/chkmod}	
		
		{module:bottom}
	</div>
	
	
<div class="clear">
	
</div>		 
	{chkmod:bottom1} 
	<div id="bottom">
		<div class="cols cols3"style="padding-bottom:20px;">			
			<div class="col first testimoni">
				{module:bottom1}
			</div>
					
			<div class="col">
				{module:bottom2}
			</div>	

			<div class="col">
				{module:bottom3}
			</div>	
			
		</div>
	</div>
	{/chkmod}
</div>




<div id="footer">	
	<div id="container">
		{chkmod:footer1}
	<div id="footer">
		<div class="cols cols4" >			
			<div class="col first" style="width: 248px;">
				{module:footer1}
			</div>
					
			<div class="col">
				{module:footer2}
			</div>	

			<div class="col">
				{module:footer3}
			</div>
			
			<div class="col">
				{module:footer4}
			</div>	
		
		</div>
	</div>
	{/chkmod}
	</div>	
</div>
</body>
</html>