<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$type = mod_param("type",modParam);
$category = mod_param("category",modParam);
$sub_menu = mod_param("sub_menu",modParam);
$sub_title = mod_param("sub_title",modParam);

if($type==1){$tipe1="selected";}
if($type==2){$tipe2="selected";}

if($sub_menu==1){$sub1="selected";}
if($sub_menu==0){$sub2="selected";} 

if($sub_title==1){$sut1="selected";}
if($sub_title==0){$sut2="selected";} 

?>
<input type="hidden" value="4" name="totalParam" />
<input type="hidden" value="category" name="nameParam1" />
<input type="hidden" value="type" name="nameParam2" />
<input type="hidden" value="sub_menu" name="nameParam3" />
<input type="hidden" value="sub_title" name="nameParam4" />
<div class="panel box">								
	<header>
		<a data-parent="#accordion" class="accordion-toggle" data-toggle="collapse" href="#article_list">
				<h5>Menu Configuration</h5>
		</a>
	</header>
	<div id="article_list" class="in">
		<table class="data2">
				
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td class="row-title">Menu Category</td>
				<td>	
					<select name='param1'>
					<?php 	
						$sql = $db->select(FDBPrefix.'menu_category','*',"category != 'adminpanel'"); 
						while($cat = mysql_fetch_array($sql)) {		
							if($category==$cat['category'])
								$s="selected";
							else
								$s='';
							echo "<option value='$cat[category]' $s>$cat[title]</option>";
						}
					?>
					</select>
				</td>
			</tr>
			
			<!-- Tipe tampilan menu -->
			<tr>
				<td class="row-title">Menu Type</td>
				<td>
					<select name='param2'>
					<option value="1"<?php echo @$tipe1;?>>Per-rows</option>
					<option value="2"<?php echo @$tipe2;?>>List (inline)</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="row-title" >Show Sub-menu</td>
				<td>
					<select name='param3'>
					<option value="1"<?php echo @$sub1;?> >Yes</option>
					<option value="0"<?php echo @$sub2;?> >No</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="row-title">Show Sub-tiltle</td>
				<td>
					<select name='param4'>
					<option value="1"<?php echo @$sut1;?> >Yes</option>
					<option value="0"<?php echo @$sut2;?> >No</option>
					</select>
				</td>
			</tr>			
		</table>
					
	</div>	
</div>	