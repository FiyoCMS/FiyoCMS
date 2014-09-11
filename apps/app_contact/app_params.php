<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

$name	= menu_param('show_name',menuParam);
$group	= menu_param('show_group',menuParam);
$email	= menu_param('show_email',menuParam);
$job	= menu_param('show_job',menuParam);
$gender	= menu_param('show_gender',menuParam);
$phone	= menu_param('show_phone',menuParam);
$address= menu_param('show_address',menuParam);
$links	= menu_param('show_links',menuParam);
$photo	= menu_param('show_photo',menuParam);
$job	= menu_param('show_job',menuParam);
$perpage= menu_param('per_page',menuParam);

$view = link_param('view',$menuLink);
$id   = link_param('id',$menuLink);


if($view=='person')$view='selected';

if(!$perpage) $perpage=10;


?>
<script type="text/javascript">
$(document).ready(function(){
	var loading = $("#loading");
	loading.fadeOut();
	
	var link = $("#link").val()
	$("#type").change(function(){	
		var vw = $("#view").val();
		var pg = $("#cat").val();
		var tm = $("#type").val();	
		if(tm==1){				
			$("#pg").addClass("invisible");	
			$(".per_page").removeClass("invisible");
			$(".pop_up2").addClass("invisible");
			$("#cat").removeClass("invisible");
			$(".catok").removeClass("invisible");
			$("#caton").html("Select Group");
			$("#link").val("");
			$("#pg").val("");
				
			var pg = $("#cat").val();	
				$("#link").val("?app=contact&view=group&id="+pg);
				
			$("#cat").change(function(){	
				var pg = $("#cat").val();
				$("#link").val("?app=contact&view=group&id="+pg);
			});
					
			$("#view").change(function(){
				if(vw==2) {
					$("#cat").addClass("invisible");
				}
				else if(vw==1){
					$("#cat").removeClass("invisible");
				}
				});	
			}
				
		else if(tm==2){
			$("#link").val("");
			$("#caton").html("contact Title");
			$(".per_page").addClass("invisible");
			$("#cat").addClass("invisible");	
			$("#cat2").addClass("invisible");		
			$("#pg").removeClass("invisible");	
			$(".pop_up2").removeClass("invisible");
			$(".catok").removeClass("invisible");	
		}
		
	});
	
	
	// jika menu (link) mengarah ke kategori
	var tm = $("#type").val();	
	if(tm==1){				
		$("#pg").addClass("invisible");	
		$(".pop_up2").addClass("invisible");
		$("#cat").removeClass("invisible");
		$(".catok").removeClass("invisible");
		$("#caton").html("Select Category");
		$("#link").val("");
		$("#pg").val("");
			
		var pg = $("#cat").val();	
			$("#link").val("?app=contact&view=group&id="+pg);
			
		$("#cat").change(function(){	
			var pg = $("#cat").val();
			$("#link").val("?app=contact&view=group&id="+pg);
		});				
	}
	
	// jika menu (link) mengarah ke artikel tunggal
	if(tm==2){
		var pg = $("#pgs").val();
		$("#caton").html("contact Title");
		$(".per_page").addClass("invisible");
		$("#cat").addClass("invisible");	
		$("#cat2").addClass("invisible");		
		$("#pg").removeClass("invisible");	
		$(".pop_up2").removeClass("invisible");
		$(".catok").removeClass("invisible");		
	}
  
  	$(".pop_up2").click(function() {
			$.ajax({
				url: "apps/app_contact/menu/contact_list.php",
				data: "img=1",
				success: function(data){
					$("#pages #page_id").html(data);
				}
			});
		});	
});
</script>
<input type="hidden" name="totalParam" value="10"/>
<input type="hidden" name="nameParam1" value="per_page" />
<input type="hidden" name="nameParam2" value="show_name" />
<input type="hidden" name="nameParam3" value="show_group" />
<input type="hidden" name="nameParam4" value="show_gender" />
<input type="hidden" name="nameParam5" value="show_address" />
<input type="hidden" name="nameParam6" value="show_phone" />
<input type="hidden" name="nameParam7" value="show_email" />
<input type="hidden" name="nameParam8" value="show_links" />
<input type="hidden" name="nameParam9" value="show_job" />
<input type="hidden" name="nameParam10" value="show_photo" />
				
<div class="box">								
	<header>
		<a class="accordion-toggle" data-toggle="collapse" href="#article-parameter">
			<h5>Contact Parameter</h5>
		</a>
	</header>								
	<div id="article-parameter" class="in">		
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td class="djudul">Page Type</td>
				<td>
					<select id="type" />
						<option value='1' selected>Group</option>
						<option value='2' <?php echo @$view;?>>Single Contact</option>
					</select>
				</td>
			</tr>
			<!-- Tipe tampilan menu -->
			<tr class="catok">
				<td class="djudul" id="caton">Select Group</td>
				<td>
					<select id="cat">
					<?php						
						$db = new FQuery();  
						$db->connect(); 						
						$sql2=$db->select(FDBPrefix.'contact_group'); 
						while($qr2 = mysql_fetch_array($sql2)) {
							if($id==$qr2['id']) $s='selected'; else $s='';
							echo "<option value='$qr2[id]' $s>$qr2[name]</option>";		
						}
					?>
					</select>
					
					<input type="hidden" value="?app=contact&view=item&id=<?php echo $id;?>" id="pgs" size="20" readonly /> 
					<input type="text" value="<?php echo oneQuery('contact','id',$id,'name'); ?>" id="pg" size="20" readonly /> 
					<a class="popup pop_up2 invisible" href="#pages" rel="width:940;height:400" style="margin-right:-20px;">Select contact</a>
				</td>
			</tr>	
			<!-- Tipe tampilan menu -->
			<tr class="per_page">
				<td class="djudul" id="contact_sum">Contact per page</td>
				<td>
					<input type="text" name="param1" value="<?php echo $perpage; ?>" id="per_page" size="5" />
					</td>
			</tr>			
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Name</td>
				<td>	
					<?php 
						if($name or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="c1" value="1" name="param2" type="radio" <?php echo $s1;?> class="invisible">
						<input id="c2" value="0" name="param2" type="radio" <?php echo $s0;?> class="invisible">
						<label for="c1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="c2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Group</td>
				<td>	
					<?php 
						if($group or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="a1" value="1" name="param3" type="radio" <?php echo $s1;?> class="invisible">
						<input id="a2" value="0" name="param3" type="radio" <?php echo $s0;?> class="invisible">
						<label for="a1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="a2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Gender</td>
				<td>	
					<?php 
						if($gender or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="b1" value="1" name="param4" type="radio" <?php echo $s1;?> class="invisible">
						<input id="b2" value="0" name="param4" type="radio" <?php echo $s0;?> class="invisible">
						<label for="b1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="b2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Address</td>
				<td>	
					<?php 
						if($address or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="d1" value="1" name="param5" type="radio" <?php echo $s1;?> class="invisible">
						<input id="d2" value="0" name="param5" type="radio" <?php echo $s0;?> class="invisible">
						<label for="d1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="d2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Phone</td>
				<td>	
					<?php 
						if($phone or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="e1" value="1" name="param6" type="radio" <?php echo $s1;?> class="invisible">
						<input id="e2" value="0" name="param6" type="radio" <?php echo $s0;?> class="invisible">
						<label for="e1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="e2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Email</td>
				<td>	
					<?php 
						if($email or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="f1" value="1" name="param7" type="radio" <?php echo $s1;?> class="invisible">
						<input id="f2" value="0" name="param7" type="radio" <?php echo $s0;?> class="invisible">
						<label for="f1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="f2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Links</td>
				<td>	
					<?php 
						if($links or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="g1" value="1" name="param8" type="radio" <?php echo $s1;?> class="invisible">
						<input id="g2" value="0" name="param8" type="radio" <?php echo $s0;?> class="invisible">
						<label for="g1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="g2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Job</td>
				<td>	
					<?php 
						if($job or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="i1" value="1" name="param9" type="radio" <?php echo $s1;?> class="invisible">
						<input id="i2" value="0" name="param9" type="radio" <?php echo $s0;?> class="invisible">
						<label for="i1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="i2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			<tr class="group_param">
				<td class="djudul" id="contact_sum">Show Photo</td>
				<td>	
					<?php 
						if($photo or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
					?>
					<p class="switch">
						<input id="h1" value="1" name="param10" type="radio" <?php echo $s1;?> class="invisible">
						<input id="h2" value="0" name="param10" type="radio" <?php echo $s0;?> class="invisible">
						<label for="h1" class="cb-enable <?php echo $s1;?>"><span>Show</span></label>
						<label for="h2" class="cb-disable <?php echo $s0;?>"><span>Hide</span></label>
					</p>
				</td>
			</tr>
			
		</table>
	</div>
</div>


<div class="popup_warp">
	<div id="pages" class="pop_up" style="padding:10px">
	<div id="page_id">
	
	
	</div>
	</div>	
</div>

