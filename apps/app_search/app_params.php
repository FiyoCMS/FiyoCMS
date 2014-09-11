<?php
/**
* @version		Beta 1.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2011 Fiyo CMS.
* @license		GNU/GPL, see liCENSE.php
* @description	Simple Module banner for Fiyo CMS
**/
$show_panel	= mod_param(show_panel,$qr[parameter]);
$read_more  = mod_param(read_more,$qr[parameter]);
$per_page	= mod_param(per_page,$qr[parameter]);

$view 	= link_param(view,$qr[link]);
$id 	= link_param(id,$qr[link]);

if($view=='category')$view2='selected';
if($view=='item')$view3='selected';

if($show_panel==1)$panel1="checked";
if($show_panel==0)$panel2="checked";

if(!$per_page) $per_page=5;




?>
<script type="text/javascript">
$(document).ready(function(){
	var loading = $("#loading");
	loading.fadeOut();	
	var link = $("#link").val()
	if(link=="#") $("#link").val("?app=article&view=featured");
	$("#type").change(function(){	
		var vw = $("#view").val();
		var pg = $("#cat").val();
		var tm = $("#type").val();	
		if(tm==1){
			$("#pg").addClass("invisible");	
			$(".per_page").removeClass("invisible");
			$(".pop_up2").addClass("invisible");
			$("#cat").addClass("invisible");
			$(".catok").addClass("invisible");
			$("#caton").html("Select Category");
			$("#link").val("?app=article&view=featured");
			$("#pg").val("");		
		}
				
		else if(tm==2){				
			$("#pg").addClass("invisible");	
			$(".per_page").removeClass("invisible");
			$(".pop_up2").addClass("invisible");
			$("#cat").removeClass("invisible");
			$(".catok").removeClass("invisible");
			$("#caton").html("Select Category");
			$("#link").val("");
			$("#pg").val("");
				
			var pg = $("#cat").val();	
				$("#link").val("?app=article&view=category&id="+pg);
				
			$("#cat").change(function(){	
				var pg = $("#cat").val();
				$("#link").val("?app=article&view=category&id="+pg);
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
				
		else if(tm==3){
			$("#link").val("");
			$("#caton").html("Article Title");
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
	if(tm==2){				
		$("#pg").addClass("invisible");	
		$(".pop_up2").addClass("invisible");
		$("#cat").removeClass("invisible");
		$(".catok").removeClass("invisible");
		$("#caton").html("Select Category");
		$("#link").val("");
		$("#pg").val("");
			
		var pg = $("#cat").val();	
			$("#link").val("?app=article&view=category&id="+pg);
			
		$("#cat").change(function(){	
			var pg = $("#cat").val();
			$("#link").val("?app=article&view=category&id="+pg);
		});				
	}
	
	// jika menu (link) mengarah ke artikel tunggal
	if(tm==3){
		var pg = $("#pgs").val();
		$("#link").val(pg);
			$("#caton").html("Article Title");
			$(".per_page").addClass("invisible");
			$("#cat").addClass("invisible");	
			$("#cat2").addClass("invisible");		
			$("#pg").removeClass("invisible");	
			$(".pop_up2").removeClass("invisible");
			$(".catok").removeClass("invisible");		
	}
  
  	$(".pop_up2").click(function() {
			$.ajax({
				url: "apps/app_article/menu/article_list.php",
				data: "img=1",
				success: function(data){
					$("#pages #page_id").html(data);
				}
			});
		});	
});
</script>
<input type="hidden" name="totalparam" value="3"/>
<input type="hidden" name="nameParam1" value="per_page" />
<input type="hidden" name="nameParam2" value="show_panel" />
<input type="hidden" name="nameParam3" value="read_more" />
				
<li>
	<h3>Fiyo Article</h3>
		<div class="isi">
			<div class="acmain open">
			<table class="data2">				
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td class="djudul">Page Type</td>
				<td>
					<select id="type" />
						<option value='1' selected>Front Page</option>
						<option value='2' <?php echo $view2;?>>Category</option>
						<option value='3' <?php echo $view3;?>>Single Article</option>
					</select>
				</td>
			</tr>
			<!-- Tipe tampilan menu -->
			<tr class="catok invisible">
				<td class="djudul" id="caton"></td>
				<td>
					<select id="cat" class="invisible">
					<?php						
						$db = new FQuery();  
						$db->connect(); 						
						$sql2=$db->select(FDBPrefix.'article_category'); 
						while($qr2 = mysql_fetch_array($sql2)) {
							if($id==$qr2[id]) $s='selected'; else $s='';
							echo "<option value='$qr2[id]' $s>$qr2[name]</option>";		
						}
						$sql3=$db->select(FDBPrefix.'article','*',"id=$id"); 
						$qr3 = mysql_fetch_array($sql3);
					?>
					</select>
					
					<input type="hidden" value="?app=article&view=item&id=<?php echo $id; ?>" id="pgs" size="20" readonly /> 
					<input type="text" class="invisible" value="<?php echo $qr3[name]; ?>" id="pg" size="20" readonly /> 
					<a class="popup pop_up2 invisible" href="#pages" rel="width:940;height:400">Select Article</a>
				</td>
			</tr>	
			<!-- Tipe tampilan menu -->
			<tr class="per_page">
				<td class="djudul" id="article_sum">Article per page</td>
				<td>
					<input type="text" name="param1" value="<?php echo $per_page; ?>" id="per_page" size="5" />
					</td>
			</tr>			
			
			<tr class="show_panel">
				<td class="djudul" id="article_sum">Show Panel</td>
				<td>	
					<label>
						<input type="radio" name="param2" value="1" <?php echo $panel1; ?>>
						<?php echo Yes; ?>
					</label>
					<label>
						<input type="radio" name="param2" value="0" <?php echo $panel2; ?>> <?php echo No; ?>
					</label>
				</td>
			</tr>
			
			<tr class="per_page">
				<td class="djudul" id="article_sum">Read More</td>
				<td>
					<input type="text" name="param3" value="<?php echo $read_more; ?>" size="15" />
				</td>
			</tr>	
		</table>
		</div>
	</div>
</li>


<div class="popup_warp">
	<div id="pages" class="pop_up" style="padding:10px">
	<div id="page_id"></div>
	</div>	
</div>

