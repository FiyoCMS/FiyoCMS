<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$article = new article;
$article -> item($id);
$text = @$article -> article;

if(isset($text)) :
	$category 	= $article-> category;
	$catlink	= $article-> catlink;
	$comment 	= $article-> comment;
	$author 	= $article-> author;
	$autmail 	= $article-> autmail;
	$title		= $article-> title;
	$hits 		= $article-> hits;
	$comment 	= $article-> comment;
	$panel 		= $article-> panel;
	$scategory 	= $article-> scategory;
	$sauthor 	= $article-> sauthor;
	$shits 		= $article-> shits;
	$sdate 		= $article-> sdate;
	$srate		= $article-> srate;
	$stag		= $article-> stag;
	$tags		= $article-> tags;
	$voter		= $article-> voter;
	$rate		= $article-> rate;
	
	$editable = "class=title";
	$editable2 = null;
	if($_SESSION['USER_LEVEL'] <= 3 OR (!empty($_SESSION['USER_EMAIL']) AND $_SESSION['USER_EMAIL'] == $autmail)) {
		$editable = ' class="title editordb" title="Click to edit"';
		$editable2 = ' class="editordb"  id="article-main" title="Click to edit"';
		addJs (FUrl."plugins/plg_ckeditor/ckeditor.js");
		addJs (FUrl."apps/app_article/theme/js/scrollfixed.js");
		$_SESSION["ARTICLE_EDITOR_$id"] = "$text";
		?>
				
		<div>
			<input type="hidden" value="<?php echo $id; ?>" id="article-id" />
			<input type="hidden" value="<?php echo $_SESSION["ARTICLE_EDITOR_$id"]; ?>" id="article-revert" />
		</div>
		<div id="editor-panel"> 
			<input type="submit" value="Save" class="save editor-button" title="Save"/>	
			<input type="submit" value="Revert" class="revert editor-button" title="Revert to last saved"/>	
		</div>
		
		<?php
	}
?>

<div id="article">
	
	<?php if(!empty($article->stitle)) : ?>
	<h1  <?php echo $editable; ?>><?php echo $title; ?></h1>	
	<?php endif; ?>
	<?php if(!empty($article->tpanel)) {
		echo "<div class='article-panel'>";
		echo $panel;
		loadModule('article-panel'); 
		echo "</div>";
	} ?>
			
	<div class="article-main">
		<?php loadModule('article-top');  ?>
		<div class="article-warp">
			<div <?php echo $editable2; ?>>
				<?php echo $text; ?>
			</div>
			<a class='limit-editor-panel'></a>
		</div>	
	</div>
		
	<?php if(!empty($article->bpanel)) : ?>
	<?php if($shits or $stag or $srate) : ?>	
	<div class='panel-bottom'>
		<?php if($shits) : ?>	
		<div class='article-read'>		
			<?php echo Reads;?> <?php echo "<b>$hits</b>";  ?> <?php echo times;?>	
		</div>	
		<?php endif; ?>				
		<?php if($srate) : ?>
		<div class='article-rating'>
		<span style='float:left'>Rates</span>
		<div class='box-rating'>
			<ul class='star-rating'> 
			  <li class="current-rating" id="current-rating" style="width:<?php echo $rate; ?>%"><!-- will show current rating --></li>
			  <?php if(!isset($_SESSION["article_rate_$id"]) or $voter == 0) :?>
			  <span id="ratelinks">
			  <li><a href="javascript:void(0)" title="1 star out of 5" class="one-star">1</a></li>
			  <li><a href="javascript:void(0)" title="2 stars out of 5" class="two-stars">2</a></li>
			  <li><a href="javascript:void(0)" title="3 stars out of 5" class="three-stars">3</a></li>
			  <li><a href="javascript:void(0)" title="4 stars out of 5" class="four-stars">4</a></li>
			  <li><a href="javascript:void(0)" title="5 stars out of 5" class="five-stars">5</a></li>
			  </span>
			  <?php endif; ?>
			</ul> 
		</div>
		<span class='valRates'>(<span><?php echo $voter ?></span> <?php if($voter<2) echo 'Vote'; else echo 'Votes'; ?>)</span>	
		</div>
		<?php endif; ?>
		<?php if($stag AND !empty($tags)) : ?>
		<div style="clear:both"> </div>
			<ul class="tags">
				<li class="tag">Tags : </li>
				<?php echo $tags; ?>
			</ul>
		<?php endif; ?>
	</div>	
	<?php endif; ?>
	
	<?php loadModule('article-mid'); ?>
	
	
	<?php if($sauthor) : ?>
	<div class='article-author'>
			
		<?php
		$autmail=	md5($autmail);
			echo "<span class='gravatar' data-gravatar-hash=\"$autmail\"></span>";
		?>
		<div class='author-nb'>
			<div class='author-name'><?php echo $article->author; ?></div>
			<div class='author-bio'><?php echo $article-> autbio ; ?></div>
		</div>
	</div>
	<?php endif; ?>
	
	<?php endif; ?>
	<?php loadModule('article-bottom'); ?>
	
	<?php if($comment AND !checkModule('article-comment')) : ?>
	<div id="comment">	
		<?php 
			loadComment();
		?>
	<?php loadModule('article-comment'); ?>	
	</div>		
	<?php endif; ?>
	
</div>


<script>
$(function() {	
	var hash = $('.gravatar[data-gravatar-hash]').attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=100' ,
		type : 'GET',
		timeout: 5000, 
		error:function(data){
			$('.gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="100" height="100" alt="" src="../apps/app_article/theme/images/stock.png" >'; 
			});	
		},
		success: function(data){
			$('.gravatar[data-gravatar-hash]').prepend(function(){
				var img = $(this).find("img").length ;
				if(img > 0) img.remove();
				var hash = $(this).attr('data-gravatar-hash')
				return '<img width="100" height="100" alt="" src="http://gravatar.com/avatar.php?size=100&gravatar_id=' + hash + '">';
			});
		}
	});	
	
		getRating();
		// get rating function
		function getRating(){
			$.ajax({
				type: "POST",
				url: '<?php echo FUrl; ?>apps/app_article/controller/rating.php',
				data: 'id=<?php echo $id; ?>&do=getrate',
				cache: false,
				async: false,
				success: function(result) {
					// apply star rating to element
					$('#current-rating').css({ width: '' + result + '%' });
				},
				error: function(result) {
				
				}
			});
		}
		// link handler
		$('#ratelinks li a').click(function(){
			$.ajax({
				type: 'POST',
				url: '<?php echo FUrl; ?>/apps/app_article/controller/rating.php',
				data: 'id=<?php echo $id; ?>&rating='+$(this).text()+'&do=rate',
				cache: false,
				async: false,
				success: function(result) {
					// remove #ratelinks element to prevent another rate
					$('#ratelinks').remove();
					// get rating after click	
					var x = parseInt($('.valRates span').text(),10);
					++x;
					var v ='';
					if(x<2) v ='Vote'; else v = 'Votes';
					$('.valRates').html('('+x+' '+v+')');
					getRating();
				},
				error: function(result) {
				
				}
			});
			
		});
	});	
	
	<?php 
	if($_SESSION['USER_LEVEL'] <= 3 AND (!empty($_SESSION['USER_EMAIL']) or $_SESSION['USER_EMAIL'] == $autmail)) :
		?>
		
	$("#article-main").focus(function(){
		$('.editor-button').show();
		$('.editor-button').attr("style","display: block !important");
		$('.article-warp').addClass("display");			
	});
		

	$(".editor-button").focus(function(){			
		$('#article-main').focus();
		$('.article-warp').focus();			
	});
	
	var flag = false;
	$('.editor-button').mouseover(function() {flag = true;});
	$('.editor-button').mouseout(function() {flag = false; });	
	
	
	$("#article-main").focusout(function(){		
		if(!flag)	{
			$('.editor-button').hide();
			$('.editor-button').attr("style","display: hide !important");
			$('.article-warp').removeClass("display");	
		}		
	});		
				
	$("h1.title").focus(function(){			
		$(this).attr('title','Press enter to save title');
	});
		
	$("h1.title").focusout(function(){			
		$(this).attr('title','Click to edit title');
	});
				
	$('#editor-panel').scrollToFixed({ marginTop: 40, limit: $('.limit-editor-panel').offset().top } );
	
	$('.editordb').dblclick(function() {
		$(this).attr('contenteditable','true');
		$(this).focus();
		CKEDITOR.disableAutoInline = true;
		var editor = CKEDITOR.inline( 'article-main' );
			
		
	});
	// We need to turn off the automatic editor creation first.
	var id = $('#article-id').attr('value');
	
	$(".title").keypress(function(e){
		var title = $('#article h1.title').html();
		title = encodeURIComponent(title);
		if (e.which == 13){
			$(".saved.title-saving").remove();
			$(this).parent().prepend("<span class='saved title-saving'>a</span>");
			$(".title-saving").show();
			$(".title-saving").html("Saving...");
			$.ajax({			
				url: "<?php echo FUrl; ?>apps/app_article/controller/editor.php",
				type: "POST",
				data: "art_title="+title+"&id="+id+"&uid=+<?php echo USER_ID; ?>",
				success: function(data){
					$(".title-saving").html(data);
					$(".title-saving").show();
					setTimeout(function(){
						$('.title-saving').fadeOut(500, function() {
						});				
					}, 2000);								
				}
			});	
			e.preventDefault();
			document.selection.createRange().pasteHTML("<br/>");
		}					
	});
	
	$(".editor-button.save").click(function(){	
		$('.editor-button').show();
		$('.article-warp').addClass("display");	
		var content = $('#article-main').html();
	
		content = encodeURIComponent(content);
		$(".editor-button.save").attr('value','Saving');	
		$("#article-main").css({opacity: "0.5"});
		$("#article-main").addClass("saving");
		$("#article-main").removeAttr("contenteditable");
		$.ajax({			
			url: "<?php echo FUrl; ?>apps/app_article/controller/editor.php",
			type: "POST",
			data: "flocal=<?php echo FLocal; ?>&_content_article="+content+"&id="+id+"&uid=+<?php echo USER_ID; ?>",
			success: function(data){		
				$(".editor-button.save").attr('value','Saved');			
				$("#article-main").css({opacity: "1"});
				$("#article-main").removeClass("saving");
				$("#article-main").attr('contenteditable','true');
				if(data == 'Failed!')
				alert(data);
				setTimeout(function(){
					$(".editor-button.save").attr('value','Save');				
				}, 2000);								
				$("#article-main").focus();
			}
		});			
	});
	
	$(".editor-button.revert").click(function(){
		var content_r = $('#article-revert').attr('value');
		$("#article-main").html(content_r);			
		$("#article-main").focus();
	});
	/*
	$("#article .article-main img").after(function(){
		var title = $(this).attr('alt');
		return "<div>"+title+"</div>";
	});*/
	<?php endif; ?>
	
</script>
<?php 
else :
	echo _404_;
endif;