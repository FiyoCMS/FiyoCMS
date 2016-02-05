<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
$db = new FQuery(); 
$xml = oneQuery("sitemap_setting","name","xml","value");
$txt = oneQuery("sitemap_setting","name","txt","value");
?>

<script type="text/javascript" charset="utf-8">
$(function() {	
	$(".create-xml").click(function(e){
		e.preventDefault();	
		var t = $(this);
		var h = t.html();
		var web = $(".web").html();
		t.html("Loading...");  
		$.ajax({
			url: "apps/app_sitemap/controller/create.php",
			type: 'POST',
			data: "type=xml",	
			timeout: 3000, 
			error:function(data){ 
				t.html('Create XML Sitemap');
			},			
			success: function(data) {
				t.html('XML Sitemap').addClass("save");
					notice(data);
			}		
		});			
	});
	
	$(".create-txt").click(function(e){
		e.preventDefault();	
		var t = $(this);
		var h = t.html();
		var web = $(".web").html();
		t.html("Loading...");  
		$.ajax({
			url: "apps/app_sitemap/controller/create.php",
			type: 'POST',
			data: "type=txt",	
			timeout: 3000, 
			error:function(data){ 
				t.html('Create TXT Sitemap');			
			},			
			success: function(data) {
				t.html('TXT Sitemap').addClass("save");
					notice(data);
			}		
		});			
	});
});
</script>
<header>
	<h5><?php echo sitemapTitle;?></h5>
	
	<?php if(!file_exists("../$xml")) : ?>
	<button type="submit" data-name="bluestrap" class="btn  theme-btn create-xml save-file-theme  cancel" id="save-file"><i class="icon-pencil"></i> Create XML Sitemap</button>
	<?php else : ?>	
	<a type="submit" data-name="bluestrap" href="<?php echo FUrl.$xml;?>" target="blank" class="btn theme-btn  save-file-theme  btn-metis-2 save tips create-xml" id="save-file">XML Sitemap</a>
	<?php endif; ?>	
	
	<?php if(!file_exists("../$txt")) : ?>
	<button type="submit" data-name="bluestrap" class="btn  theme-btn create-txt save-file-theme  cancel" id="save-file"><i class="icon-pencil"></i> Create TXT Sitemap</button>
	<?php else : ?>	
	<a data-name="bluestrap" href="<?php echo FUrl.$txt;?>" target="blank" class="btn  theme-btn top-btn-file save-file-theme  btn-metis-2 save tips create-txt" id="save-file">TXT Sitemap</a>
	<?php endif; ?>
</header>
<div class='info table-sitemap link-table-sitemap'>
<script>
	$(function() {
		$(".upd-sitemap").change(function() {
			var t = $(this);			
			$.ajax({
				url: "apps/app_sitemap/controller/update.php",
				type: 'POST',
				data: "type="+t.data("type")+"&id="+t.data("id")+"&val="+t.val(),
				timeout: 10000, 
				error:function(data){ 
					alert("Error update sitemap!");
				},			
				success: function(data) {
					notice(data);
				}		
			});		
		});
		loadTable();
	});
</script>
<table class='data data dataTable'>
	<thead>
		<tr>
			<th style='width: 50%;'>URL</th>
			<th style='width: 15%;'>Date Modified</th>
			<th style='width: 13%;' >Change Freq.</th>
			<th style='width: 5%;'>Priority</th>
		</tr>
	</thead>
	<tbody>
	<?php			
				 				
		$sql = $db->select(FDBPrefix.'sitemap','*',"","url ASC");	
		$no=1;				
		foreach($sql as $row){
			$f0 = $f1 = $f2=$f3=$f4=$f5=$f6 = null;
			if($row['freq'] == 0) {
				$f0 = "selected";
				$f = "never";
			} else if($row['freq'] == 1) {
				$f1 = "selected";
				$f = "mothly";		
			} else if($row['freq'] == 2) {
				$f2 = "selected";
				$f = "weekly";			
			} else if($row['freq'] == 3) {
				$f3 = "selected";
				$f = "daily";		
			} else if($row['freq'] == 4) {
				$f4 = "selected";
				$f = "hourly";		
			} else if($row['freq'] == 5) {
				$f5 = "selected";
				$f = "always";		
			} else if($row['freq'] == 6) {
				$f6 = "selected";
				$f = "yearly";		
			}
			
			$pa = $pb = $pc = $pd = $pe = null;
			if($row['priority'] == 0.2) {
				$pa = "selected";
			} else if($row['priority'] == 0.3) {
				$pb = "selected";		
			} else if($row['priority'] == 0.5) {
				$pc = "selected";			
			} else if($row['priority'] == 0.8) {
				$pd = "selected";		
			} else if($row['priority'] == 1) {
				$pe = "selected";		
			}
			
			$f = "<select class='freq upd-sitemap' data-type='freq' data-id='$row[id]'>
			<option value='0' $f0>Never</option>
			<option value='4' $f4>Hourly</option>
			<option value='3' $f3>Daily</option>
			<option value='2' $f2>Weekly</option>
			<option value='1' $f1>Monthly</option>
			<option value='6' $f6>Yearly</option>
			<option value='5' $f5>Always</option>
			</select>";
			
			$p = "<select class='prio upd-sitemap' data-type='priority' data-id='$row[id]'>
			<option value='0.2' $pa>0.2</option>
			<option value='0.3' $pb>0.3</option>
			<option value='0.5' $pc>0.5</option>
			<option value='0.8' $pd>0.8</option>
			<option value='1' $pe>1</option>
			</select>";
		echo "<tr>
			<td>$row[url]</td><td>$row[time]</td><td >$f</td><td>$p</td></tr>";
		}
	?>
	</tbody>
</table>
</div>