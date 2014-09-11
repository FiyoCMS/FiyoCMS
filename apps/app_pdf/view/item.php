<?php
/**
* @version		1.5.0
* @package		Fi pdf
* @copyright	Copyright (C) 2012 Fiyo Developers.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$pdf = new pdf;
$pdf -> item($id,Page_ID);

$file  = @$pdf-> pdf;
		
	if(isset($file))
	{	
		
	$pdff 		= $pdf-> pdff;
	$category 	= $pdf-> category;
	$author 	= $pdf-> author;
	$lecturer 	= $pdf-> lecturer;
	$title		= $pdf-> title;
	$hits 		= $pdf-> hits;
	$year 		= $pdf-> year;
	$desc		= $pdf-> desc;
	$pdfed		= $pdf-> pdfed;
	?>	
	<script>
	
$(function() {
	//checkFirstVisit();
    $('.baca').on('click', function(e){
		$('#pdf-box').fadeToggle();
		
    });  
	$(document).bind('keydown keyup', function(e) {
		if(e.which === 27) { 
		e.preventDefault();	
		$('#pdf-box').fadeOut();
		}
	});
	
	$('.xlose').click(function() {
		$('#pdf-box').fadeOut();
	
	});
});    
	
	</script>
	<div id="download-default">
		<div class="pdf_item">	
			<div class="pdf_main">	
				
				<h1 class='title'><?php echo $title; ?></h1>	
				<table class="pdf_panel_table">
				<tr>
					<th class='title' style=" vertical-align: top; width: 80px;">Penulis </th>
					<td colspan="3"  style="width: 100px; text-align: left;"><?php echo $author ?></td>
				</tr>
				<tr>
					<th class='title' style=" vertical-align: top; width: 80px;">Pembimbing </th>
					<td colspan="3"  style="width: 100px; text-align: left;"><?php echo $lecturer ?></td>
				</tr>
				<tr>
					<th class='title' style=" vertical-align: top ; width: 25%">Tahun </th>
					<td  style=" width: 25%"><?php echo $year ?></td>
					
					
					<th class='title' style=" vertical-align: top">Program Studi </th>
					<td><?php echo $category ?></td>
				</tr>
				<tr>
					
				</tr>
				<tr>
				</tr>
				</table>	
			</div>	
			
		</div>
		
		
		<div class="clear"></div>
			
		
			<div class="clear"></div>
			
		<div class="pdf_desc">
			<?php echo $desc; ?>
		</div>	
		
			<div class="clear"></div>
			<?php loadModule('pdf-mid'); ?>
			
					
			<!-- div class="pdf-comment">
				<?php 
					if(pdfConfig('comment')) require_once ("comment.php");
				?>
			</div -->
				
		<?php if(USER_LEVEL !== 99 ) : ?>
			<div class="comment label">
				<a href="#baca" class="baca">Baca Pustaka</a>
			</div>
		<?php else : ?>
			<div class="comment label" style='width: 80%;'>
				<a href="<?=make_permalink('?app=user&view=login'); ?>" class="baca">Login untuk Baca Pustaka</a>
			</div>
		<?php endif; ?>
	</div>	
	<?php if(USER_LEVEL !== 99 ) : ?>
	<div id="pdf-box"> 
			<embed src="<?php echo FUrl.$pdff; ?>/book.swf" style="width: 100%; height: 100%; overflow: hidden;"></embed>
			<div style="
    cursor: pointer;
    color: #444;
    font-weight: bold;
    right: 0;
    padding: 17px;
    top: 0;
    position: fixed;
	
    font-size: 26px;
" class="xlose">X</div>
			</div>
	<?php endif;
	
}
?>