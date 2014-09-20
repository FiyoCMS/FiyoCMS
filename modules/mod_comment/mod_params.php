<?php
/**
* @version		2.0
* @package		Fi Comments
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$param1 = mod_param('name',modParam);
$param2 = mod_param('gravatar',modParam);
$param3 = mod_param('title',modParam);
$param4 = mod_param('comment',modParam);
$param5 = mod_param('date',modParam);
$param6 = mod_param('text',modParam);
$param7 = mod_param('item',modParam);

if($param6== "" or empty($param6)) $param6 = 100;
if($param7== "" or empty($param7)) $param7 = 5;

if($param1){$enpar1="selected checked"; $dispar1 = "";}
else {$dispar1="selected checked"; $enpar1= "";}

if($param2){$enpar2="selected checked"; $dispar2 = "";}
else {$dispar2="selected checked"; $enpar2= "";}

if($param3){$enpar3="selected checked"; $dispar3 = "";}
else {$dispar3="selected checked"; $enpar3= "";}

if($param4){$enpar4="selected checked"; $dispar4 = "";}
else {$dispar4="selected checked"; $enpar4= "";}

if($param5){$enpar5="selected checked"; $dispar5 = "";}
else {$dispar5="selected checked"; $enpar5= "";}


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
<input type="hidden" value="7" name="totalParam" />
<input type="hidden" value="name" name="nameParam1" />
<input type="hidden" value="gravatar" name="nameParam2" />
<input type="hidden" value="title" name="nameParam3" />
<input type="hidden" value="comment" name="nameParam4" />
<input type="hidden" value="date" name="nameParam5" />
<input type="hidden" value="text" name="nameParam6" />
<input type="hidden" value="item" name="nameParam7" />
<div class="panel box">								
	<header>
		<a data-parent="#accordion" class="accordion-toggle" data-toggle="collapse" href="#article_list">
			<h5>Comments Configuration</h5>
		</a>
	</header>
	<div id="article_list" class="in">
		<table>				
			<tr>
				<td class="row-title"><span class="tips" title="Show author comment">Show Name</td>
				<td>	
					<p class="switch">
						<input id="radio11" value="1" name="param1" type="radio" <?php echo $enpar1;?> class="invisible">
						<input id="radio21" value="0" name="param1" type="radio" <?php echo $dispar1;?> class="invisible">
						<label for="radio11" class="cb-enable <?php echo $enpar1;?>"><span>Show</span></label>
						<label for="radio21" class="cb-disable <?php echo $dispar1;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>				
			<tr>
				<td class="row-title"><span class="tips" title="Show gravatar image">Show Gravatar</td>
				<td>	
					<p class="switch">
						<input id="radio31"  value="1" name="param2" type="radio" <?php echo $enpar2;?> class="invisible">
						<input id="radio41"  value="0" name="param2" type="radio" <?php echo $dispar2;?> class="invisible">
						<label for="radio31" class="cb-enable <?php echo $enpar2;?>"><span>Show</span></label>
						<label for="radio41" class="cb-disable <?php echo $dispar2;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>			
			
			<tr>
				<td class="row-title"><span class="tips" title='Show article title'>Show Article Title</td>
				<td>	
					<p class="switch">
						<input id="radio5" value="1"  name="param3" type="radio" <?php echo $enpar3;?> class="invisible">
						<input id="radio6"  value="0" name="param3" type="radio" <?php echo $dispar3;?> class="invisible">
						<label for="radio5" class="cb-enable <?php echo $enpar3;?>"><span>Show</span></label>
						<label for="radio6" class="cb-disable <?php echo $dispar3;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>			
			<tr>
				<td class="row-title"><span class="tips" title='Show text comments' >Show Comment</td>
				<td>	
					<p class="switch">
						<input id="radio7" value="1"  name="param4" type="radio" <?php echo $enpar4;?> class="invisible">
						<input id="radio8" value="0"  name="param4" type="radio" <?php echo $dispar4;?> class="invisible">
						<label for="radio7" class="cb-enable <?php echo $enpar4;?>"><span>Show</span></label>
						<label for="radio8" class="cb-disable <?php echo $dispar4;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>						
			<tr>
				<td class="row-title"><span class="tips" title='Show comments date' >Show Date</td>
				<td>	
					<p class="switch">
						<input id="radio9" value="1"  name="param5" type="radio" <?php echo $enpar5;?> class="invisible">
						<input id="radio10" value="0"  name="param5" type="radio" <?php echo $dispar5;?> class="invisible">
						<label for="radio9" class="cb-enable <?php echo $enpar5;?>"><span>Show</span></label>
						<label for="radio10" class="cb-disable <?php echo $dispar5;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			<tr>
				<td class="row-title"><span class="tips" title='Limit text comments' >Limit Words</span></td>
				<td>	
					<input type="text" value="<?php echo $param6; ?>" name="param6" size="1" class="spinner numeric"  />
				</td>
			</tr>	
			<tr>
				<td class="row-title"><span class="tips" title='Num of comments' >Limit Item</span></td>
				<td>	
					<input type="text" value="<?php echo $param7; ?>" name="param7" size="1" class="spinner numeric" />
				</td>
			</tr>		
		</table>					
	</div>	
</div>	