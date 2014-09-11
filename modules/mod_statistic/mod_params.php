<?php
/**
* @name			Module Statistic
* @version		1.5.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$param1 = mod_param('today',modParam);
$param2 = mod_param('yesterday',modParam);
$param3 = mod_param('thisweek',modParam);
$param4 = mod_param('lastweek',modParam);
$param5 = mod_param('thismonth',modParam);
$param6 = mod_param('lastmonth',modParam);
$param7 = mod_param('all',modParam);
$param8 = mod_param('info',modParam);

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
<input type="hidden" value="8" name="totalParam" />
<input type="hidden" value="today" name="nameParam1" />
<input type="hidden" value="yesterday" name="nameParam2" />
<input type="hidden" value="thisweek" name="nameParam3" />
<input type="hidden" value="lastweek" name="nameParam4" />
<input type="hidden" value="thismonth" name="nameParam5" />
<input type="hidden" value="lastmonth" name="nameParam6" />
<input type="hidden" value="all" name="nameParam7" />
<input type="hidden" value="info" name="nameParam8" />
<div class="panel box">								
	<header>
		<a class="accordion-toggle" data-toggle="collapse" href="#article_list" data-parent="#accordion">
				<h5>Statistics Configuration</h5>
		</a>
	</header>
	<div id="article_list" class="in">
			<table class="data2">				
			<tr>
				<td class="row-title"><span title="Show author comment">Show Today</td>
				<td>	
					<?php 
					if($param1 or $_GET['act'] == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="par1" value="1" name="param1" type="radio" <?php echo $f1;?> class="invisible">
						<input id="par2" value="0" name="param1" type="radio" <?php echo $f0;?> class="invisible">
						<label for="par1" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="par2" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>				
			<tr>
				<td class="row-title"><span title="Show gravatar image">Show Yesterday</td>
				<td>	
					<?php 
					if($param2 or $_GET['act'] == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="par3" value="1" name="param2" type="radio" <?php echo $f1;?> class="invisible">
						<input id="par4" value="0" name="param2" type="radio" <?php echo $f0;?> class="invisible">
						<label for="par3" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="par4" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>			
			
			<tr>
				<td class="row-title"><span title='Show article title'>Show This Week</td>
				<td>	
					<?php 
					if($param3 or $_GET['act'] == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="par5" value="1" name="param3" type="radio" <?php echo $f1;?> class="invisible">
						<input id="par6" value="0" name="param4" type="radio" <?php echo $f0;?> class="invisible">
						<label for="par5" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="par6" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>			
			<tr>
				<td class="row-title"><span title='Show text comments' >Show Last Week</td>
				<td>	
					<?php 
					if($param4 or $_GET['act'] == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="par7" value="1" name="param4" type="radio" <?php echo $f1;?> class="invisible">
						<input id="par8" value="0" name="param4" type="radio" <?php echo $f0;?> class="invisible">
						<label for="par7" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="par8" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>						
			<tr>
				<td class="row-title"><span title='Show comments date' >Show This Month</td>
				<td>	
					<?php 
					if($param5 or $_GET['act'] == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="par9" value="1" name="param5" type="radio" <?php echo $f1;?> class="invisible">
						<input id="par10" value="0" name="param5" type="radio" <?php echo $f0;?> class="invisible">
						<label for="par9" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="par10" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			<tr>
				<td class="row-title"><span title='Show comments date' >Show Last Month</td>
				<td>	
					<?php 
					if($param6){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="par11" value="1" name="param6" type="radio" <?php echo $f1;?> class="invisible">
						<input id="par12" value="0" name="param6" type="radio" <?php echo $f0;?> class="invisible">
						<label for="par11" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="par12" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			<tr>
				<td class="row-title"><span title='Show comments date' >Show Total</td>
				<td>	
					<?php 
					if($param7 or $_GET['act'] == 'add'){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="para7" value="1" name="param7" type="radio" <?php echo $f1;?> class="invisible">
						<input id="parb7" value="0" name="param7" type="radio" <?php echo $f0;?> class="invisible">
						<label for="para7" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="parb7" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr><tr>
				<td class="row-title"><span title='Show comments date' >Guest Information</td>
				<td>	
					<?php 
					if($param8){$f1="selected checked"; $f0 = "";}
					else {$f0="selected checked"; $f1= "";}
					?>
					<p class="switch">
						<input id="para8" value="1" name="param8" type="radio" <?php echo $f1;?> class="invisible">
						<input id="parb8" value="0" name="param8" type="radio" <?php echo $f0;?> class="invisible">
						<label for="para8" class="cb-enable <?php echo $f1;?>"><span>Show</span></label>
						<label for="parb8" class="cb-disable <?php echo $f0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>		
		</table>					
		</div>	
	</div>	
</li>