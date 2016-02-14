<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = new FQuery();  	
$timeout 	= oneQuery("sitemap_setting","name","timeout","value");

?>	
<script type="text/javascript" charset="utf-8">
$(function() {	
	$(".search").click(function(e){
		e.preventDefault();	
		var t = $(this);
		var h = t.html();
		var web = $(".web").html();
		t.html("Loading...");  
		$.ajax({
			url: "apps/app_sitemap/controller/crawl.php",
			type: 'POST',
			data: "web=true",	
			timeout: <?php echo $timeout*1000; ?>, 
			error:function(data){ 
			
			},			
			success: function(data) {
                           console.log(data);
				$(".data").html(data);
				loadTable();
				t.html('Re-Clawler');
				$(".save.btn").remove();
				t.before("<button type='submit' name='save_crawler' class='save btn' value='<?php echo Save; ?>'><?php echo Save; ?></button>");
			}		
		});			
	});
	
	$("#form").submit(function(e){
		e.preventDefault();
		var ff = this;
		var checked = $('input[name="check[]"]:checked').length > 0;
		if(checked) {
			$('#confirmDelete').modal('show');	
			$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Item); ?>");
			$('input[name="check[]"]').next().addClass('input-error');
			return false;
		}
	});	
});
</script>
<form action="" method="POST">
<div class="box no-border "> 	
	<footer>
		<div style=" margin:0; padding:10px; width: 100%;"><p>
			Please remember! It will take a long time doing the tracking link on your site.<br>
			Please wait until the process is completed. If you understand you can start now.<br></p><button type="Submit" value="" name="getSettings" class="btn btn-grad btn-primary search">Start Now</button>
		</div>
	</footer>
	<div class="data table-sitemap">
	
	</div>
</div>
</form>