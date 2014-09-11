<?php
/**
* @version		v.1.2.2
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$article = new articleCategory;
$article ->item($id,Page_ID);

if(isset($article-> category)) {
$category 	= $article-> category;
$catlink	= $article-> catlink;
$text  		= $article-> article;
$pagelink 	= $article-> pglink;
$link 		= $article-> link;
$comment	= $article-> comment;
$perrows 	= $article-> perrows;
$author 	= $article-> author;
$title		= $article-> title;
$hits 		= $article-> hits;
$date 		= $article-> date;
	
if($text)
{	
?>	
<?php if(defined('Apps_Title')) echo "<h2>".Apps_Title."</h2>"; ?>
<div id="article">
	<?php 
	for($i=0; $i < $perrows ;$i++)
	{ 
	?>		
	<div class="article_body">	
		<h2><?php echo $title[$i]; ?></h2>
		
		<?php if(!empty($article->show_panel)) {
			echo "<div class='article_panel'>Written by $author[$i] on $date[$i] | <a href='$catlink[$i]' title='$category[$i]'>$category[$i]</a> | Hits : $hits[$i]</div>";
		} ?>
	
		<div class="article_main">
			<?php echo $text[$i]; ?>
			<?php if(com_query('comment')) { ?>
			
			<a class="nof_comment readmore" href="<?php echo $link[$i];?>#comments">
				<?php if($comment[$i]>1) echo $comment[$i]." Comments"; ?>
				<?php if($comment[$i]==1) echo $comment[$i]." Comment"; ?>
				<?php if($comment[$i]<1) {echo "Send Comment";} ?>
			</a>
			<?php } ?>
		</div>	
		<div class="clear"></div>
	</div>	
	<?php	
	}
	?>		
	<div class="article_main">
		<?php echo $pagelink; ?>
	</div>
</div>	
<?php
}
}
?>