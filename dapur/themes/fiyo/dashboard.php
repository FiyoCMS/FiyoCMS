<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
?>
<div id="app_header">
	<div class="warp_app_header">		
		<div class="app_title">Dashboard</div>
		<div class="app_link">			
			<a class="btn btn-default btn-primary" href="?app=article&act=add" title="<?php echo Add_New_Menu; ?>"><i class="icon-pencil"></i> <?php echo New_Article; ?></a>
			<a class="btn btn-default btn-sm btn-grad" title="<?php echo Add_New_Menu; ?>" href="?app=config"><i class="icon-cogs" style=""></i> <?php echo Configuration?></a>
		</div> 	
	</div>
</div>
<div style="padding-bottom: 10px; width: 100%;">
<div class="col-lg-12 full">	
	<div class="box">								
		<header>
			<a class="accordion-toggle" data-toggle="collapse" href="#page-configuration">
				<h5>Statistik Pengunjung</h5>
			</a>
		</header>								
		<div id="page-configuration" class="in">
			<div id="statistic"><div class="loading">Loading...</div>
			</div>	
		</div>
	</div>
	
	<div class="box statistic primary">	
		<div class="mini-box box-1 online-user"><h3><span class="data">Loading...</span><i class="icon-circle"></i></h3><span><?php echo Online_Visitor;?></span><i class="icon icon-bullseye"></i>
		</div>
		<div class="mini-box box-2 today-visitor"><h3>Loading...</h3><span><?php echo Today_Visitor;?></span><i class="icon icon-calendar-empty"></i>
		</div>
		<div class="mini-box box-3 monthly-visitor"><h3>Loading...</h3><span><?php echo Monthly_Visitor;?></span><i class="icon icon-calendar"></i>
		</div>
		<div class="mini-box box-4 total-visitor"><h3>Loading...</h3><span><?php echo Total_Visitor;?></span><i class="icon icon-signal"></i>
		</div>
	</div>	
</div>
<div class="clearfix"></div>
<div class="col-lg-6 box-left">	
	<div class="box">								
		<header>			
			<a class="accordion-toggle" data-toggle="collapse" href="#article-box">
			</a>	
			<ul class="nav nav-tabs">
			  <li class="active"><a data-target="#latest" data-toggle="tab" class='article-latest'><?php echo Latest_Article?></a></li>
			  <li><a data-target="#popular" data-toggle="tab" class='article-popular'><?php echo Popular_Article?></a></li>
			  <li><a data-toggle='tooltip' data-placement='top' title='<?php echo New_Article;?>' href="?app=article&act=add"><i class="icon-pencil"></i></a></li>
			</ul>	
		</header>								
		<div id="article-box" class="in">
		<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane active" id="latest"><div id="article-latest">
			  <div style="height:60px"><div class="loading">Loading...</div></div>
			  </div></div>
			  <div class="tab-pane" id="popular"><div id="article-popular">
			   <div style="height:60px"><div class="loading">Loading...</div></div>
			   </div></div>
			  <div class="tab-pane" id="write">  
				<textarea rows="8" placeholder="What's on your mind?" class="form-control" required></textarea>
				<footer> 
				<input placeholder="<?php echo Title;?>" required type="text" class="form-control"></textarea>
					<a href="#">Daftar konsep yang tersimpan</a> &nbsp;
					<button class="btn btn-default btn-sm btn-grad">Simpan ke Editor Lengkap</button>
					<button class="btn btn-success btn-sm btn-grad"><?php echo Save.' '.Draft;?></button>
				</footer>
			  </div>
			</div>
		</div>
	</div>		
	
	<div class="box">								
		<header>			
			<a class="accordion-toggle" data-toggle="collapse" href="#member-box">
			</a>	
			<ul class="nav nav-tabs">
			  <li class="active"><a data-target="#member-new" data-toggle="tab" class='member-new'><?php echo Latest_User?></a></li>
			  <li><a data-target="#member-log" data-toggle="tab" class='member-log'><?php echo Latest_Login?></a></li>
			  <li><a data-target="#member-online" data-toggle="tab"  class='member-online'><?php echo Online_User?></a></li>
			  <li><a href="?app=user&act=add"  data-toggle='tooltip' data-placement='top' title='			  <?php echo Register_New_Member?>'><i class="icon-plus" ></i></a></li>
			</ul>	
		</header>								
		<div id="member-box" class="in">
		<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane active" id="member-new"> <div style="height:60px"><div class="loading">Loading...</div></div></div>
			  <div class="tab-pane" id="member-log"> <div style="height:60px"><div class="loading">Loading...</div></div></div>
			  <div class="tab-pane" id="member-online"> <div style="height:60px"><div class="loading">Loading...</div></div></div>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-6 box-right">	
	<div class="box">								
		<header>
			<a class="accordion-toggle" data-toggle="collapse" href="#comment-box">
				<h5><?php echo Latest_Comment;?></h5>
			</a>
		</header>								
		<div id="comment-box" class="in">			
		<div class="tab-pane active" id="home">
			<div class="comment"> <div style="height:60px"><div class="loading">Loading...</div></div></div>	
		</div>
		</div>
	</div>		
	
	<div class="box">								
		<header>
			<a class="accordion-toggle" data-toggle="collapse" href="#feed-box">
				<h5><?php echo Fiyo_Feed; ?></h5>
			</a>
		</header>								
		<div id="feed-box" class="in">			
		<div class="tab-pane active" id="home">
			<div class="feed"> <div style="height:60px"><div class="loading">Loading...</div></div></div>	
		</div>
		</div>
	</div>
</div>
</div>
<script>
$(function () {	
	function loader(target) {
		$(target+ ' .loading').remove();
		$(target).prepend("<div class='loading'>Loading</div>");	
	}
	
	function loaded(target) {
		$(target+ ' .loading').fadeOut('fast');
		setInterval(function(){
			$(target+ ' .loading').remove();
		}, 1000);
	}
	
	function loadComment() {
		$.ajax({
			type : 'POST',
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/comments.php",
			success: function(data){
				$(".comment").html(data);
				loadNewMember();
			}
		});
		
		
	}
	
	function loadArticleLatest(click) {	
		$.ajax({
			type : "POST",
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/article_latest.php",
			success: function(data){	
				if(!click)	loadComment(click);
				$("#article-latest").html(data);
			}
		});
	};
	
	function loadArticlePopular() {	
		$.ajax({
			type : "POST",
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/article_popular.php",
			success: function(data){
				$("#article-popular").html(data);
			}
		});
	};

	
	function updateStat() {	
		$.ajax({
			url: "<?php echo AdminPath; ?>/module/statistic_data.php",
			data: "access",
			success: function(data){
				$("#statistic").html(data);
				loadArticleLatest();
				updateOnline();	
			}
		});
	}	
		
	function updateOnline() {	
		$.ajax({
			url: "<?php echo AdminPath; ?>/module/statistic_online.php",
			data: "access",
			success: function(data){
                var json = $.parseJSON(data);
				$(".online-user .data").html(json.online);
				$(".today-visitor h3").html(json.today);
				$(".monthly-visitor h3").html(json.month);
				$(".total-visitor h3").html(json.total);
				if(json.online > 0)
				$(".online-user h3 i").addClass('blink');
				else
				$(".online-user h3 i").removeClass('blink');
			}
		});
	}
	
	
		
	function loadNewMember(click) {	
		$.ajax({
			type : 'POST',
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/user_latest.php",
			success: function(data){
				$("#member-new").html(data);
				if(!click) loadFeeds();
			}
		});
	}
	function loadMemberLog() {	
		$.ajax({
			type : 'POST',
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/user_log.php",
			success: function(data){
				$("#member-log").html(data);
			}
		});
	}
	
	function loadMemberOnline() {	
		$.ajax({
			type : 'POST',
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/user_online.php",
			success: function(data){
				$("#member-online").html(data);
			}
		});
	}
	
	
	function loadFeeds() {	
		$.ajax({
			type : 'POST',
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo AdminPath; ?>/module/feeds.php",
			success: function(data){
				$(".feed").html(data);
			}
		});
	}
	
	$('.article-popular').click(function(){	
		loadArticlePopular();	
	});
	$('.article-latest').click(function(){	
		loadArticleLatest(click);
	});
	
	$('.member-log').click(function(){	
		loadMemberLog();	
	});
	
	$('.member-online').click(function(){
		loadMemberOnline();	
	});
	
	$('.member-new').click(function(){	
		loadNewMember();
	});	
	
	updateStat();

	var dt = new Date();
	var cH = dt.getHours();
	
	setInterval(function(){
		updateOnline();	
		var dS = new Date();
		var uH = dS.getHours();
		if(uH != cH) {
			updateStat();
			cH = uH;
		}
	}, 1000 * 10);	
	
	setInterval(function(){
		loadMemberLog();	
		loadNewMember();
	}, 1000*300);
	
	setInterval(function(){
		loadMemberOnline();	
	}, 1000*500);
});
</script>