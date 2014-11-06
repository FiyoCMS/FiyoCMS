<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');
$db = new FQuery();  
$db->connect(); 
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
				<table class="table  tools">
				  <tbody>
					<?php	
						$sql = $db->select(FDBPrefix."article","*,DATE_FORMAT(date,'%W, %b %d %Y') as dates","",'date DESC LIMIT 10'); 
						$no = 0;		
						while($qr=mysql_fetch_array($sql)) {
							$no++;			
							$read = check_permalink("link","?app=article&view=item&id=$qr[id]","permalink");
							$edit = "?app=article&act=edit&id=$qr[id]";						
							$auth = userInfo("name","$qr[author_id]");
							$info = "$qr[date]";
							$read_article = Read;
							$edit_article = Edit;
							echo "<tr><td class='no-tabs'>#$no</td><td width='100%'>$qr[title] <a class='tooltips icon-time' title='$info' data-placement='right'></a> 
							<div class='tool-box'>
								<a href='$read' target='_blank'  class='btn btn-tools tips' title='$read_article'>$read_article</a>";				
							$editor_level 	= mod_param('editor_level',$qr['parameter']);
							if($editor_level >= USER_LEVEL or empty($editor_level)) echo "<a href='$edit' class='btn btn-tools tips' title='$edit_article'>$edit_article</a>";
							echo "</div>			
							</td></tr>";
						}	
						if($no == 0) { 
							echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Article."</td></tr>";
						}				
						?>				
					   </tbody>			
				</table>			  			  
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
			  <div class="tab-pane active" id="member-new"> 
			  
<table class="table table-striped tools">
  <tbody>
	<?php	
		$db = new FQuery();  
		$db->connect(); 
		$sql = $db->select(FDBPrefix."user","*,DATE_FORMAT(time_reg,'%W, %Y-%m-%d %H:%i') as date","level >= $_SESSION[USER_LEVEL]",'time_reg DESC LIMIT 10'); 
		$no = 1;
		while($qr=mysql_fetch_array($sql)) {
			$id = $qr['id'];
			$edit = Edit;
			$read = Read;
			$hide = Set_disable;	
			$delete = Delete;
			$approve = Set_enable;		
			$sql2 = $db->select(FDBPrefix."user_group","*","level=$qr[level]"); 
			
			$output = oneQuery('session_login','user_id',"'$id'");				
			$log = "";			
			if($output) $log = "
			<a data-toggle='tooltip' data-placement='right' title='Online' class=' icon-circle blink icon-mini tooltips'></a>&nbsp;&nbsp;&nbsp;";
			$red = '';
			if($qr['status']) 
				$approven = "<a class='btn-tools btn btn-danger btn-sm btn-grad disable-user' data-id='$qr[id]' title='$hide'>$hide</a><a class='btn-tools btn btn-success btn-sm btn-grad approve-user' data-id='$qr[id]' title='$approve' style='display:none;'>$approve</a>";
			else {
				$approven = "<a class='btn-tools btn btn-success btn-sm btn-grad approve-user' data-id='$qr[id]' title='$approve'>$approve</a><a class='btn-tools btn btn-danger btn-sm btn-grad disable-user' data-id='$qr[id]' title='$hide' style='display:none;'>$hide</a>";
				$red = "class='unapproved'";
			}
			if($id == USER_ID) $approven ='';
			$group = mysql_fetch_array($sql2);
			$group = $group['group_name'];			
			$ledit = "?app=user&act=edit&id=$id";					
			echo "<tr $red><td>$qr[name] <span>($qr[user])</span>$log
			<a data-toggle='tooltip' data-placement='right' title='$qr[date]' class=' icon-time tooltips'></a>
			<a data-toggle='tooltip' data-placement='right' title='$group' class=' icon-info-sign tooltips'></a>
			<br/>
			<div class='tool-box'>
				$approven
				<a href='$ledit' class='btn btn-tools tips' title='$edit'>$edit</a>
			</div></td>
			<td align='right'>$qr[email]</td>
			</tr>";
			$no++;	
		}					
		?>			

       </tbody>			
</table>
			  </div>
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
			<div class="comment">

<table class="table table-striped tools">
  <tbody>
	<?php	
		$db = new FQuery();  
		$db->connect(); 
		$user_id = USER_ID;
		if($_SESSION['USER_LEVEL'] > 3)
			$sql = $db->select(FDBPrefix."comment","*,DATE_FORMAT(date,'%W, %b %d %Y') as dates","parent_user_id = $user_id OR thread_user_id = $user_id",'date DESC LIMIT 10');
		else
			$sql = $db->select(FDBPrefix."comment","*,DATE_FORMAT(date,'%W, %b %d %Y') as dates","",'date DESC LIMIT 10'); 
		$no = 0;		
		while($qr=mysql_fetch_array($sql)) {					
			$id = "$qr[id]";
			$auth = "$qr[name]";
			$info = "$qr[date]";
			$imgr = md5("$qr[email]");
			$foto = " <span class='c_gravatar' data-gravatar-hash=\"$imgr\"></span>";
			$comment = cutWords(htmlToText($qr['comment']),10);
			$hide = Hide;
			$cedit = Edit;
			$read = Read;
			$delete = Delete;
			$approve = Approve;
			$app = link_param('app',"$qr[link]");	
			$aid = link_param('id',"$qr[link]");	
			$app = "$qr[apps]";
			if(empty($app)) $app = 'article';
			$lread = check_permalink("link","?app=article&view=item&id=$aid","permalink");
			$edit = "?app=$app&view=comment&act=edit&id=$id";			
			$title = oneQuery('article','id',$aid ,'title');
			$red = '';
			if($qr['status']) 
				$approven = "<a class='btn-tools btn btn-danger btn-sm btn-grad disable-user' title='$hide' data-id='$id'>$hide</a><a class='btn-tools btn btn-success btn-sm btn-grad approve-user' title='$approve' style='display:none;' data-id='$id'>$approve</a>";
			else {
				$approven = "<a data-id='$id' class='btn-tools btn btn-success btn-sm btn-grad approve-user' title='$approve'>$approve</a><a data-id='$id' class='btn-tools btn btn-danger btn-sm btn-grad disable-user' title='$hide'  style='display:none;'>$hide</a>";
				$red = "class='unapproved'";
			}
			echo "<tr $red><td style='text-align: center; vertical-align: middle;  padding: 7px 8px 6px 10px;'>$foto</td><td style='width: 97%; padding: 7px 8px 8px 0;'><b>$qr[name]</b> <span>on</span> $title <a data-toggle='tooltip' data-placement='right' title='$info' class='icon-time tooltips'></a> <a data-toggle='tooltip' data-placement='left' title='$qr[email]' class='icon-envelope-alt tooltips'></a>
			<br/><span>$comment ...</span><br/>
			<div class='tool-box tool-$no'>
				$approven
				<a href='$edit' class='btn btn-tools tips' title='$cedit'>$cedit</a>
				<a href='$lread#comment-$qr[id]' target='_blank'  class='btn btn-tools tips' title='$read'>$read</a>
				<!--a class='btn btn-tools tips' title='$delete'>$delete</a-->
			</div>
			</td></tr>";
			$no++;	
		}
		if($no < 1) { 
			echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Comment."</td></tr>";
		}
	?>
    </tbody>			
</table>
			</div>	
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
<script language="javascript" type="text/javascript">
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
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/comments.php",
			success: function(data){
				$(".comment").html(data);
			}
		});
		
		
	}
	
	function loadArticleLatest() {	
		$.ajax({
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/article_latest.php",
			success: function(data){	
				$("#article-latest").html(data);
			}
		});
	};
	
	function loadArticlePopular() {	
		$.ajax({
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/article_popular.php",
			success: function(data){
				$("#article-popular").html(data);
			}
		});
	};

	function updateStat() {	
		$.ajax({
			url: "<?php echo FAdminPath; ?>/module/statistic_data.php",
			data: "access",
			success: function(data){
				$("#statistic").html(data);				
				updateOnline();	
			}
		});
	}	
		
	function updateOnline() {	
		$.ajax({
			url: "<?php echo FAdminPath; ?>/module/statistic_online.php",
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
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/user_latest.php",
			success: function(data){
				$("#member-new").html(data);
			}
		});
	}
	function loadMemberLog() {	
		$.ajax({
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/user_log.php",
			success: function(data){
				$("#member-log").html(data);
			}
		});
	}
	
	function loadMemberOnline() {	
		$.ajax({
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/user_online.php",
			success: function(data){
				$("#member-online").html(data);
			}
		});
	}
	
	
	function loadFeeds() {	
		$.ajax({
			data: "url=<?php echo FUrl; ?>",
			url: "<?php echo FAdminPath; ?>/module/feeds.php",
			success: function(data){
				$(".feed").html(data);
			}
		});
	}
	
	$('.article-popular').click(function(){	
		loadArticlePopular();	
	});
	$('.article-latest').click(function(){	
		loadArticleLatest(true);
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
	
	$('.c_gravatar[data-gravatar-hash]').each(function () {
	var th = $(this);
	var hash = th.attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=32' ,
		type : 'GET',
		timeout: 5000, 
		error:	function(data){			
			th.html('<img width="32" height="32" alt="" src="../apps/app_comment/images/user.png" >');	
		},
		success: function(data){
			th.html('<img width="32" height="32" alt="" src="http://gravatar.com/avatar/' + hash + '">');
			loadFeeds();
		}
	});
	});
});
</script>