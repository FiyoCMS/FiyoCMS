<?php
/**
* @version		1.5.0
* @package		Fi pdf
* @copyright	Copyright (C) 2012 Fiyo Developers.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$pdf = new pdf;
$pdf ->category(app_param('label'),Page_ID,1);

if(isset($pdf -> category)) :
$category 	= $pdf-> category;
$catlink	= $pdf-> catlink;
$text  		= $pdf-> desc;
$pagelink 	= $pdf-> pglink;
$link 		= $pdf-> link;
$perrows 	= $pdf-> perrows;
$author 	= $pdf-> author;
$title		= $pdf-> title;
$title		= $pdf-> title;
$labels 	= $pdf-> labels;
$hits 		= $pdf-> hits;
$date 		= $pdf-> date;
$label = ucfirst(app_param('label'));
if($title) : 
	if(!empty($label)) echo "<h1 class='title'>$label</h1>";
	else if(defined('Apps_Title')) echo "<h1 class='title'>".Apps_Title."</h1>";
	else echo "<h1>pdf<h1>";
 ?>
<div id="pdf-default">
	<?php for($i=0; $i < $perrows ;$i++) : 	?>
		<div class="pdf_item">	
			<div class="pdf_main">
				<a href="<?php echo $link[$i] ?>" class="pdf_img"></a>		
				
				<div class=""><h2 class="title"><?php echo $title[$i]; ?></h2>
				
				<div class='pdf_panel'>	
					<span>
					<?php echo "<b><i>$author[$i]</i></b> &#183;  $category[$i] &#183; Th.$date[$i]"; ?>
					</span>	
				</div>
			<div class="clear"></div>
				<?php echo cutWords(htmlToText($text[$i]),40);?>						
				</div>	
			</div>	
			
		</div>	
		<?php endfor; ?>		
		<div class="pdf_main">
			<?php echo $pagelink; ?>
		</div>
	</div>	
<?php	
endif;
endif;
?>