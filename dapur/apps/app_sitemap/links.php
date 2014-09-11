<?php
/* 
	This is phpSitemapNG, a php script that creates your personal google sitemap
	It can be downloaded from http://enarion.net/google/
	License: GPL
	
	Tobias Kluge, enarion.net
*/

if(!$xml) :
?> 
	<h4 style='text-align:center; padding: 40px 0; color: #999; font-size: 1.5em'>Please setup your sitemap configuration and crawl your site.<br><small><a href='?app=sitemap&view=setup'>Setup Now!</a></small></h4>

<?php else :
?>
<div class='info table-sitemap link-table-sitemap'>
<script>
	$(function() {
		loadTable();
	});
</script>
<table class='data data dataTable'>
	<thead>
		<tr>
			<th style='width: 50%;'>URL</th>
			<th style='width: 15%;  text-align: center;'>Date Modified</th>
			<th style='width: 15%;  text-align: center;'>Change Freq.</th>
			<th style='width: 5%; text-align: center;'>Priority</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($xml->url as $url_list) {
		$url = $url_list->loc;
		$lastmod = $url_list->lastmod;
		$changefreq = $url_list->changefreq;
		$priority = $url_list->priority;
		echo "<tr>
			<td>$url</td><td style='text-align: center;'>$lastmod</td><td style='text-align: center;'>$changefreq</td><td style='text-align: center;'>$priority</td></tr>";
	}
	?>
	</tbody>
</table>
<?php endif; ?>
</div>