<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die; 
$db->connect();

//set request id 
if(isset($_REQUEST['id']))
	$id=$_REQUEST['id'];
else
	$id = null;
if(!isset($id)) {
	$_REQUEST['id']=0;	
	$row = null;
}

$act = $_REQUEST['view'];
$menuLink = null;

switch($act)
{
	case 'add':
		$name = $_POST['apps'];		
		$row = null;
		$mod_class = null;
		$mod_style = null;
		$show_title = null;
		if($name == 'sperator')
		$menuLink = '#';
		$edit = 0;
	break;
	
	case 'edit':
		$sql = $db->select(FDBPrefix.'menu','*','id='.$id); 
		$row = $sql[0];	
		$edit = 1;
		$name = $row['app'];
		$param = $row['parameter'];
		$mod_class = $row['class'];
		$mod_style = $row['style'];
		$show_title = $row['show_title'];
		$menuLink = $row['link'];
	break;
}
$menuParam = $row['parameter'];
$params ="apps/$name/app_params.php";	
?>
 
<script type="text/javascript">
$(function() {
	$(".categorymenu").change(function(){
		var cat = $('.categorymenu').val();	
		var id = $('.menuid').val();	
		var pid = $('.parentid').val();	
		$.ajax({
			type: "POST",
			url: "apps/app_menu/controller/parent.php",
			data: "id="+id+"&cat="+cat+"&parent="+pid,
			success: function(data){
				$(".parent").html(data);
				$(".parent").trigger("chosen:updated");
			}
		});
		
	});
	$(".parent").chosen({disable_search_threshold: 10, 
	allow_single_deselect: true});
});
</script>
<div class="col-lg-6 box-left">
	<div class="box">								
		<header class="dark">
			<h5>Menu Details</h5>
		</header>								
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Menu_Type_tip; ?>"><?php echo Menu_Type; ?></span></td>
					<td><b><i><?php echo $name; if(isset($row)) echo " (id = $row[id])";?></i></b>
					<input type="hidden" name="apps" value="<?php echo $name;?>"> 
					<input type="hidden" name="id" class="menuid" value="<?php echo $row['id'];?>"></td>
					<input type="hidden" name="parent_id" class="parentid" value="<?php echo $row['id'];?>"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Menu_Name_tip; ?>"><?php echo Name; ?></span></td>
					<td><input <?php formRefill('desc',$row['name']); ?> style="min-width: 60%" type="text" name="name" required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Menu_link_tip; ?>">Link</span></td>
					<td><input <?php formRefill('desc',$menuLink); ?> style="width: 90%" type="text" name="link" id="link"<?php if($name!='link') echo 'readonly'; ?> required ></td>
				</tr>				
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Menu_Status_tip; ?>"><?php echo Active_Status; ?></span></td>
					<td>
						<?php 
							if($row['status'] or $act == 'add'){$f1="selected checked"; $f0 = "";}
							else {$f0="selected checked"; $f1= "";}
						?>
						<p class="switch">
							<input id="radio17" value="1" name="status" type="radio" <?php echo $f1;?> class="invisible">
							<input id="radio18" value="0" name="status" type="radio" <?php echo $f0;?> class="invisible">
							<label for="radio17" class="cb-enable <?php echo $f1;?>"><span>On</span></label>
							<label for="radio18" class="cb-disable <?php echo $f0;?>"><span>Off</span></label>
						</p></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Menu_Category_tip; ?>"><?php echo Menu_Category; ?></span></td>
					<td><select name="cat" class="categorymenu chosen no-search">
					<?php
					$sql2 = $db->select(FDBPrefix.'menu_category');
					foreach($sql2 as $row2){
						if($row2['category'] == 'adminpanel' AND USER_LEVEL > 1) continue;
						if($row2['category']==$row['category']){ 
							echo "<option value='$row2[category]' selected>$row2[title]</option>";
						}
						else {
							echo "<option value='$row2[category]'>$row2[title]</option>";
						}						
					}
					?>
					</select></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Menu_Order_tip; ?>"><?php echo Menu_Order; ?></span></td>
					<td><input value="<?php echo $row['short'];?>" type="number" name="short" size="2" id="order" class="numeric spinner min-0" min="0" style="width: 50px"><span id="pesan"></span></td>
				</tr>				
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Parent_Menu_tip; ?>"><?php echo Parent_Menu; ?></span></td>
					<td>
					<select name="parent_id" class="parent chosen" data-placeholder="Choose...">
					<option value=''></option>
					<?php	
						if($edit) $eid = "AND id!=$row[id]";
						if($_GET['view'] == 'add') {
							$sql3 = $db->select(FDBPrefix.'menu','*',"parent_id = 0 ",'short ASC'); 
						}
						else {
							$sql3 = $db->select(FDBPrefix.'menu','*',"parent_id = 0 $eid AND category = '$row[category]'",'short ASC'); 
						}
						foreach($sql3 as $row3){	
							if($row3['id']==$row['parent_id']){ 
								echo "<option value='$row3[id]' selected>$row3[name]</option>";option_sub_menu($row3['id'],$row['parent_id'],'');
							}
							else {
								echo "<option value='$row3[id]'>$row3[name]</option>";option_sub_menu($row3['id'],$row['parent_id'],'');
							}
						}
						
					?>
					
					</select></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Access_Menu_tip; ?>"><?php echo Access_Level ?></span></td>
					<td><select name="level" class="chosen no-search">
					<?php
						$sql4 = $db->select(FDBPrefix.'user_group');
						foreach($sql4 as $row4){
							if($row4['level']==$row['level']){
								echo "<option value='$row4[level]' selected>$row4[group_name]</option>";}
								else {
									echo "<option value='$row4[level]'>$row4[group_name]</option>";}
						}
						if($row['level']==99 or !$edit) $s="selected";else $s="";
						echo "<option value='99' $s>"._Public."</option>"
					?>
					</select></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="col-lg-6 box-right">
	<?php 
		$menuId = $asset = $id ;
		define('menuParam',$menuId);
		if(file_exists($params)) require($params);
		$hidden = '';
		if($name == 'link' or $name == 'sperator') $hidden = 'hidden';
	?>
	<div class="box <?php echo $hidden;?>">								
		<header>
			<a class="accordion-toggle <?php if(file_exists($params)) echo "collapsed"; ?>" data-toggle="collapse" href="#page-configuration">
				<h5>Page Configuration</h5>
			</a>
		</header>								
		<div id="page-configuration" class="<?php if(file_exists($params)) echo "collapse"; else echo "in"; ?>">
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Page_Title_tip; ?>"><?php echo Page_Title; ?></span></td>
					<td><input value="<?php echo $row['title'] ; ?>" type="text" name="title" style="width: 70%;"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Show_title_tip; ?>" ><?php echo Show_title; ?></span></td>
					<td>
						<?php 
							if($show_title or $_GET['view'] =='add'){$s1="selected checked"; $s0 = "";}
							else {$s0="selected checked"; $s1= "";}
						?>
						<p class="switch">
							<input id="radio3" value="1" name="show_title" type="radio" <?php echo $s1;?> class="invisible">
							<input id="radio4" value="0" name="show_title" type="radio" <?php echo $s0;?> class="invisible">
							<label for="radio3" class="cb-enable <?php echo $s1;?>"><span>Yes</span></label>
							<label for="radio4" class="cb-disable <?php echo $s0;?>"><span>No</span></label>
						</p>
					</td>
				</tr>							
			</table>
		</div>
	</div>
	
	<div class="box">								
		<header>
			<a class="accordion-toggle <?php if(file_exists($params)) echo "collapsed"; ?>" data-toggle="collapse" href="#menu-style">
				<h5>Menu Styling</h5>
			</a>
		</header>	
		<div id="menu-style" class="<?php if(file_exists($params)) echo "collapse"; else echo "in"; ?>">
			<table>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Subtitle_tip; ?>"><?php echo Subtitle_Menu; ?></span></td>
					<td><input value="<?php echo $row['sub_name'] ; ?>" type="text" name="sub_name" style="width: 60%;"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Add_css_class_tip; ?>">CSS Class</span></td>
					<td><input value="<?php echo $mod_class ; ?>" type="text" name="class" style="width: 60%;"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Add_css_style_tip; ?>">CSS Style</span></td>
					<td><textarea type="text" name="style" rows="5" style="width: 90%; resize: vertical;"><?php echo $mod_style ; ?></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>