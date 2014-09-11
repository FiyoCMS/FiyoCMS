<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/


defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die; 

//set GET id 
if(isset($_GET['id']))
	$id=$_GET['id'];
else
	$id = null;
if(!isset($id)) {
	$_GET['id']=0;	
	$qr = null;
	$new =1;	
	$show_comment = $panel_top = $show_title = $panel_bottom = $show_author = $show_date = $show_category = $show_hits=$show_tags = $show_rate = 2; 
	$rate_value = $rate_counter = 0;
}
else {
	$sq = $db->select(FDBPrefix.'article','*','id='.$id); 
	$qr = @mysql_fetch_array($sq);
		
	$show_comment	= mod_param('comment',$qr['parameter']);
	$panel_top 		= mod_param('panel_top',$qr['parameter']);
	$panel_bottom 	= mod_param('panel_bottom',$qr['parameter']);
	$show_author 	= mod_param('show_author',$qr['parameter']);
	$show_date  	= mod_param('show_date',$qr['parameter']);
	$show_category	= mod_param('show_category',$qr['parameter']);
	$show_hits  	= mod_param('show_hits',$qr['parameter']);
	$show_tags  	= mod_param('show_tags',$qr['parameter']);
	$show_rate	 	= mod_param('show_rate',$qr['parameter']);
	$show_title	 	= mod_param('show_title',$qr['parameter']);
	$rate_value		= mod_param('rate_value',$qr['parameter']);
	$rate_counter 	= mod_param('rate_counter',$qr['parameter']);
	$editor_level 	= mod_param('editor_level',$qr['parameter']);
}	
$article = $qr['article'];
if(checkLocalhost()) {
	$article = str_replace("media/",FLocal."media/",$article);			
}
if(!is_numeric($rate_value) or empty($rate_value)) $rate_value = 0;			
if(!is_numeric($rate_value) or empty($rate_counter)) $rate_counter = 0;	

if(empty($rate_counter)) $rates = $rate_counter = $rate_value = 0;
else if(($rate_value/$rate_counter) >= $rate_counter) $rates = 10;
else $rates = angka2($rate_value/$rate_counter);


if($_GET['id']) :
?>
<?php endif; ?>
<script type="text/javascript">
$(function() {		
	CKEDITOR.replace('editor');	
	$('#datetimepicker').datetimepicker({
		language: 'pt-BR'
	});
	
	$("#content form").submit(function(e){
		e.preventDefault();
		var ff = this;
		var text = CKEDITOR.instances.editor.getData();
		if(text && $("#content form").valid()) {
			$(".inner .alert").remove();
			ff.submit();
		}else if(!text) {
			noticeabs("<?php echo alert('error',Please_write_some_text); ?>");
			CKEDITOR.instances.editor.focus();
		}
	});
	
	$("#datepicker").mask("9999-99-99 99:99:99");
	
	$('.chosen-with-drop').hide();
});
</script>	
<div id="article">
<div class="col-lg-9 box-left">
	<div class="box article-editor">								
		<div>
			<input value="<?php echo $qr['id'];?>" type="hidden" name="id">
					<input <?php formRefill('title',$qr['title']);?> placeholder="<?php echo Enter_title_here; ?>" type="text" name="title" required>
		</div>
		<div style="padding:10px 0 0; overflow: hidden;">
			<div class="load-editor">
				<textarea required id="editor" name="editor" rows="30" cols="90" style="opacity:0"><?php formRefill('editor',htmlentities($article),'textarea'); ?></textarea>
			</div>					
		</div>
	</div>
</div>
			


<div class="panel-group col-lg-3 box-right article-box" id="accordion">
 <div class="panel box"> 		
	<header>
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			<h5>Umum</h5>
		</a>
	</header>
	<div id="collapseOne" class="panel-collapse in">
		<table class="data2">
			<tr>
				<td class="row-title" style="width: 35%; min-width:90px;"><span class="tips" title="<?php echo Hits; ?>"><?php echo Category.$qr['category']; ?></span></td>
				<td> <select name="cat" class="chosen-select" data-placeholder="<?php echo Choose_category; ?>" style="min-width:120px;" required="required">
				<option value=""></option>
					<?php	
						$_GET['id']=0;
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'article_category','*','parent_id=0'); 
						while($qrs=mysql_fetch_array($sql)){
							if($qrs['level'] >= $_SESSION['USER_LEVEL']){
								if($qr['category']==$qrs['id']) $s="selected";else$s="";
								echo "<option value='$qrs[id]' $s>$qrs[name]</option>";
								option_sub_cat($qrs['id'],'');
							}
						}						
					?>
				</select></td>
			</tr>			
			<tr>
				<td class="row-title" title="<?php echo Active_Status; ?>">Status</td>
				<td>
				<?php 
					if($qr['status'] or $_GET['act'] == 'add'){$status1="selected checked"; $status0 = "";}
					else {$status0="selected checked"; $status1= "";}
					?>
					<p class="switch">
						<input id="radio15" value="1" name="status" type="radio" <?php echo $status1;?> class="invisible">
						<input id="radio16" value="0" name="status" type="radio" <?php echo $status0;?> class="invisible">
						<label for="radio15" class="cb-enable <?php echo $status1;?>"><span><?php echo Enable; ?></span></label>
						<label for="radio16" class="cb-disable <?php echo $status0;?>"><span><?php echo Disable; ?></span></label>
					</p>
				</td>
			</tr>
			<tr>
				<td class="row-title" title="<?php echo Featured; ?>"><?php echo Featured; ?></td>
				<td>
				<?php 
					if($qr['featured'] or $_GET['act'] == 'add'){$status1="selected checked"; $status0 = "";}
					else {$status0="selected checked"; $status1= "";}
					?>
					<p class="switch">
						<input id="radio3" value="1" name="featured" type="radio" <?php echo $status1;?> class="invisible">
						<input id="radio4" value="0" name="featured" type="radio" <?php echo $status0;?> class="invisible">
						<label for="radio3" class="cb-enable <?php echo $status1;?>"><span><?php echo Yes; ?></span></label>
						<label for="radio4" class="cb-disable <?php echo $status0;?>"><span><?php echo No; ?></span></label>
					</p>
				</td>
			</tr>	
					
			<tr>
				<td class="row-title" title="<?php echo Article_level_tip; ?>" style="width:30%"><?php echo Access_Level; ?></td>
				<td><select name="level" placeholder="">
				<option value=""></option>
					<?php
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'user_group');
						while($qrs=mysql_fetch_array($sql)){
							if($qrs['level']==$qr['level']){
								echo "<option value='$qrs[level]' selected>$qrs[group_name]</option>";}
							else {
								echo "<option value='$qrs[level]'>$qrs[group_name]</option>";
							}
						}
						if($qr['level']==99 or !$qr['level']) $s="selected"; else $s="";
						echo "<option value='99' $s>"._Public."</option>"
					?>
					</select>
				</td>
			</tr>	
			<tr>
				<td class="row-title" title="<?php echo Tags_tip; ?>"><?php echo Tags; ?></td>
				<td> <select name="tags[]" class="chosen-select w-max" data-placeholder="<?php echo Choose_tags; ?>" style="min-width:150px; width:100%;" multiple>
				<option value=""></option>
					<?php	
						$_GET['id']=0;
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'article_tags'); 
						while($qrs=mysql_fetch_array($sql)){
							$sel = multipleSelected($qr['tags'],$qrs['name']);
							echo "<option value='$qrs[name]' $sel>$qrs[name]</option>";
						}						
					?>
				</select></td>
			</tr>
			<?php if($_GET['act'] != 'add') : ?>
			<tr>
				<td class="row-title" title="<?php echo Hits; ?>"><?php echo Hits; ?></td>
				<td><span id="hits"><?php echo $qr['hits']; ?></span>
				<input name="viewed" type="hidden" value="<?php echo $qr['hits']; ?>"/> 
				<?php if(userInfo('level') < 3 AND !empty($qr['hits'])) : ?><label class="reset" title="<?php echo Hits_Reset; ?>" style="margin-left:5px; cursor: pointer;"><input type="checkbox" value="1" name="hits_reset">Reset</label><?php else : ?><?php endif; ?></td>
			</tr>
			<tr>
				<td class="row-title" title="<?php echo Rate; ?>"><?php echo Rate; ?></td>
				<td><span id="hits"><b><?php echo $rates; ?></b>/10 <?php echo of.' '.$rate_counter.' '.ratings; ?></span></td>
			</tr>
			<?php endif; ?>
		</table>
  </div>
 </div>
 <div class="panel box"> 		
	<header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#publishing">
			<h5><?php echo Publishing; ?></h5>
		</a>
	</header>
  <div id="publishing" class="panel-collapse collapse">
		<table class="data2">
			<tr>
				<td class="row-title" style="width: 35%" title="<?php echo Author_tip; ?>"><?php echo Author; ?></td>
				<td><input name="author" style="min-width: 83.5%" disabled size="15" type="text"value="<?php echo userInfo('name',$qr['author_id']); ?>"/></td>
			</tr>
			<tr>
				<td class="row-title" style="width: 35%" title=""><?php echo Author_Alias; ?></td>
				<td><input name="author" style="min-width: 83.5%" size="15" type="text"value="<?php echo $qr['author']; ?>"/></td>
			</tr>	
			<tr>
				<td class="row-title" style="width: 35%" title="<?php echo Date_tip; ?>"><?php echo Date; ?></td>
				<td>		
				 <div id="datetimepicker" class="input-append date input-group" style="  width: 160px;">
					<input data-format="yyyy-MM-dd hh:mm:ss" type="text" name="date" id="datepicker" size="16" type="date" value="<?php if($qr['date']) echo $qr['date']; else echo date("Y-m-d H:i:t"); ?>"/>
					<span class="add-on input-group-addon">
					 <i class="icon-calendar">
					 </i>
					</span>
				 </div>
				</td>
			</tr>
			<tr>
				<td class="row-title" style="width: 35%" title="<?php echo Last_Updated_tip; ?>"><?php echo Updated; ?></td>
				<td>							
				 <div class="input-append date input-group" style="  width: 160px;">
					<input type="text" disabled value="<?php if($qr['updated']) echo $qr['updated']; ?>" size="16">
					<span class="add-on input-group-addon">
					 <i class="icon-calendar">
					 </i>
					</span>
				 </div>
				</td>
			</tr>
			<tr>
				<td class="row-title" style="width: 35%" title="<?php echo Editor_tip; ?>"><?php echo Editor; ?></td>
				<td><input type="text" disabled value="<?php if(!empty($qr['editor'])) echo oneQuery("user","id",$qr['editor'],"name"); ?>" style="min-width: 83.5%" size="18"></td>
			</tr>
			<tr>
				<td class="row-title" title="<?php echo Editor_level_tip; ?>" style="width:30%"><?php echo Editor_Level; ?></td>
				<td><select name="param12" placeholder="">
				<option value=""></option>
					<?php
						$db = new FQuery(); 
						$db->connect(); 
						$sql = $db->select(FDBPrefix.'user_group','*','level >= '.USER_LEVEL);
						while($qrs=mysql_fetch_array($sql)){
							if($qrs['level']==3 AND !$editor_level) {
								echo "<option value='$qrs[level]' selected>$qrs[group_name]</option>";}
							else if($qrs['level'] == $editor_level){
								echo "<option value='$qrs[level]' selected>$qrs[group_name]</option>";}
							else {
								echo "<option value='$qrs[level]'>$qrs[group_name]</option>";
							}
						}
					?>
					</select>
				</td>
			</tr>		
		</table>
  </div>
 </div>
 <div class="panel box parameter"> 		
  <header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
			<h5>Parameter</h5>
		</a>
	</header>
  <div id="collapse2" class="panel-collapse collapse">   
			<input type="hidden" name="totalparam" value="13"/>
			<input type="hidden" name="nameParam1" value="show_comment" />
			<input type="hidden" name="nameParam2" value="show_author" />
			<input type="hidden" name="nameParam3" value="show_date" />
			<input type="hidden" name="nameParam4" value="show_category" />
			<input type="hidden" name="nameParam5" value="show_tags" />
			<input type="hidden" name="nameParam6" value="show_hits" />
			<input type="hidden" name="nameParam7" value="show_rate" />
			<input type="hidden" name="nameParam8" value="rate_value" />
			<input type="hidden" name="nameParam9" value="rate_counter" />
			<input type="hidden" name="nameParam10" value="panel_top" />
			<input type="hidden" name="nameParam11" value="panel_bottom" />
			<input type="hidden" name="nameParam12" value="editor_level" />
			<input type="hidden" name="nameParam13" value="show_title" />
			
		<table class="data2">				
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Panel.' '.Top; ?></td>
				<td>
					<select name="param10" class="chosen-gsh <?php echo "s-$panel_top"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($panel_top == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($panel_top == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($panel_top == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>				
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Panel.' '.Bottom; ?></td>
				<td>
					<select name="param11" class="chosen-gsh <?php echo "s-$panel_bottom"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($panel_bottom == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($panel_bottom == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($panel_bottom == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>				
			<tr>
				<td class="row-title" style="width: 40%"><div><?php echo Comment; ?></div></td>
				<td>
					<select name="param1" class="chosen-gsh <?php echo "s-$show_comment"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_comment == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_comment == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_comment == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>					
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Title; ?></td>
				<td>
					<select name="param13" class="chosen-gsh <?php echo "s-$show_title"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_title == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_title == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_title == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>					
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Author; ?></td>
				<td>
					<select name="param2" class="chosen-gsh <?php echo "s-$show_author"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_author == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_author == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_author == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>											
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Date; ?></td>
				<td>	
					<select name="param3" class="chosen-gsh <?php echo "s-$show_date"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_date == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_date == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_date == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Category; ?></td>
				<td>	
					<select name="param4" class="chosen-gsh <?php echo "s-$show_category"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_category == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_category == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_category == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="row-title" style="width: 40%"><?php echo Tags; ?></td>
				<td>	
					<select name="param5" class="chosen-gsh <?php echo "s-$show_tags"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_tags == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_tags == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_tags == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>	
			<tr>
				<td class="row-title" style="width: 40%" id="article_sum"><?php echo Rates; ?></td>
				<td>	
					<select name="param7" class="chosen-gsh <?php echo "s-$show_rate"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_rate == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_rate == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_rate == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
					<input type="hidden" name="param8" value="<?php echo @$rate_value; ?>">
					<input type="hidden" name="param9" value="<?php echo @$rate_counter; ?>">
				</td>
			</tr>					
			<tr>
				<td class="row-title" style="width: 40%" id="article_sum"><?php echo Hits; ?></td>
				<td>	
					<select name="param6" class="chosen-gsh <?php echo "s-$show_hits"; ?>" style="min-width:150px; width:100%;">
						<option value="2" <?php if($show_hits == 2) echo'selected'; ?>>Global</option>
						<option value="1" <?php if($show_hits == 1) echo'selected'; ?>><?php echo Show;?></option>
						<option value="0" <?php if($show_hits == 0) echo'selected'; ?>><?php echo Hide;?></option>
					</select>
				</td>
			</tr>	
		</table>
  </div>
 </div>
 <div class="panel box"> 		
  <header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
			<h5>Meta Data</h5>
		</a>
	</header>
  <div id="collapse3" class="panel-collapse collapse">
		<table class="data2">
			<!--tr>
				<td class="row-title"  style="width: 30%" title="<?php echo Keywords_tip; ?>">SEF URLs</td>
				<td><textarea rows="2" cols="19" type="text" name="keyword" style="min-width:100%; max-width: 100%; resize: vertical;"><?php formRefill('keyword',$qr['keyword'],'textarea'); ?></textarea></td>
			</tr-->			
			<tr>
				<td class="row-title " title="<?php echo Keywords_tip; ?>"><?php echo Keyword; ?></td>
				<td><textarea rows="3" cols="19" type="text" name="keyword"style="min-width:100%; max-width: 100%; resize: vertical;"><?php formRefill('keyword',$qr['keyword'],'textarea'); ?></textarea></td>
			</tr>							
			<tr>
				<td class="row-title " title="<?php echo Meta_Desc_tip; ?>"><?php echo Description; ?></td>
				<td><textarea rows="5" cols="19" type="text" name="desc"style="min-width:100%; max-width: 100%; resize: vertical;"><?php formRefill('description',$qr['description'],'textarea'); ?></textarea></td>
			</tr>
		</table>
  </div>
 </div>
</div>
</div>