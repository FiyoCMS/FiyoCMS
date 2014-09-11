<?php
/**
* @name			Fi Search
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');


$q = url_param('q');
if(isset($_POST['q'])) {
	$query = $_POST['q'];
	$query = str_replace("`","",$query);
	$query = str_replace("\\","",$query);
	$query = str_replace("/","",$query);
	$query = str_replace("&","",$query);
	$query = str_replace("'","",$query);
	$query = str_replace('"',"",$query);
	$query = trim($query);	
	 $_SESSION['search'] = $query;
	 }
else if(!empty($q)) {
	$q = str_replace("+"," ",$q);
	$_SESSION['search'] = $q;
}
else if(_Page < 1 AND empty($_SESSION['search']))
	$_SESSION['search'] = null;
	

$query = $_SESSION['search'];

?>
<div id="app-search">	
<h1>Search Page</h1>
<form action="" method="POST">
	<input type="text" name="q" value="<?php if(!empty($query)) echo $query;?>" size="40" placeholder="Search..." /> 
	<input type="submit" name="s" value="Search" class="button btn search-button"/> 
</form>
<?php
if(empty($_SESSION['search'])) :
	echo alert("error",Please_fill_keyword,true);
elseif(strlen($_SESSION['search'])<3) :
	echo alert("error",Minimum_keywords,true);
else :
	$article = new searchArticle;
	$article -> item($_SESSION['search'],Page_ID);
	$category 	= @$article-> category;
	$catlink	= @$article-> catlink;
	$pagelink 	= @$article-> pglink;
	$perrows 	= @$article-> perrows;
	$text  		= @$article-> article;
	$author 	= @$article-> author;
	$total 		= @$article-> total;
	$title		= @$article-> title;
	$date 		= @$article-> date;
		
	if(!isset($text)) :
		echo alert("error",Not_found_keyowrd." <b><i>$query</i></b>",true);	
	else :
		echo alert("info",Found_1." <b>$total</b> ".Found_2." <b><i>$query</i></b>",true);		
		echo "<div id='article'>";
		
		for($i=0; $i < $perrows ;$i++) : 		
			?>		
			<div class="article-box">	
				<h2 class="title"><?php echo $title[$i]; ?></h2>				
				<?php 
					echo "<div class='article-panel'><em>$author[$i]</em>, $date[$i] on <a href='$catlink[$i]' title='$category[$i]'>$category[$i]</a></div>";
				?>			
				<div class="article-main">
					<?php echo $text[$i]; ?>
				</div>	
				
				<div class="clear"></div>
			</div>	
		<?php	
			endfor;
		?>
		<div class="article-pagelink pagination">
			<?php echo $pagelink; ?>
		</div>
		</div>
		<?php
	endif;
endif;
?>
</div>