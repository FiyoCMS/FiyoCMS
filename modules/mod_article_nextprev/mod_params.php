<?php
/**
* @version		1.0.0
* @package		Article NextPrev
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$cat 	= mod_param('cat',modParam);
$showImg = mod_param('showImg',modParam);

if($showImg){ $swimg1="selected checked"; $swimg2 = "";}
else {$swimg2 ="selected checked"; $swimg1 = "";}

?>

<script type="text/javascript">
$(document).ready( function(){ 
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
	});
});
</script>
<input type="hidden" value="2" name="totalParam"/>
<input type="hidden" value="cat" name="nameParam1"/>
<input type="hidden" value="filter" name="nameParam2"/>
<div class="panel box">								
	<header>
		<a data-parent="#accordion" class="accordion-toggle" data-toggle="collapse" href="#article_list">
				<h5>Article NextPrev Configuration</h5>
		</a>
	</header>
	<div id="article_list" class="in">
		<table class="data2">
		<tr>
				<td class="row-title">Category</td>
				<td>	
					<select name="param1[]" multiple style="height:160px; width:200px; ">
					<?php	
						$_GET['id']=0;
						$db = new FQuery();  
						$sql = $db->select(FDBPrefix.'article_category','*','parent_id=0'); 
						while($qrs=mysql_fetch_array($sql)){
							$s = multipleSelected($cat,$qrs['id']);
							echo "<option value='$qrs[id]' $s>$qrs[name]</option>";
							option_sub_cat($qrs['id'],$cat,'');
						}

						function option_sub_cat($parent_id,$cat,$pre) {
							$db = new FQuery();  
							$sql=$db->select(FDBPrefix."article_category","*","parent_id=$parent_id AND id!=$_REQUEST[id]"); 
							while($qr=mysql_fetch_array($sql)){	
								$s = multipleSelected($cat,$qr['id']);
								echo "<option value='$qr[id]' $s>$pre |_ $qr[name]</option>";
								option_sub_cat($qr['id'],$cat,$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
							}			
						}						
					?>
					</select>
				</td>
			</tr>	
			<!--
			<tr>
				<td class="row-title tooltip" title="Show gravatar image">Show Images</td>
				<td>	
					<p class="switch">
						<input id="radio21"  value="1" name="param2" type="radio" <?php echo $swimg1;?> class="invisible">
						<input id="radio22"  value="0" name="param2" type="radio" <?php echo $swimg2;?> class="invisible">
						<label for="radio21" class="cb-enable <?php echo $swimg1;?>"><span>Show</span></label>
						<label for="radio22" class="cb-disable <?php echo $swimg2;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>	
			-->
		</table>
	</div>
</div>