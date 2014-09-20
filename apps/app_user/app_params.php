<?php
/**
* @name			User
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$view = menu_param('view',menuParam);
if($view == 'login') $view1='selected';
if($view == 'register') $view2='selected';
if($view == 'profile') $view3='selected';


?>
<script type="text/javascript">
$(document).ready(function(){
	var loading = $("#loading");
	loading.fadeOut();	
	var link = $("#link").val()
	if(link=="#") $("#link").val("?app=user&view=login");
	$("#type").change(function(){
		var tm = $("#type").val();	
		if(tm=='login')
			$("#link").val("?app=user&view=login");
		else if(tm=='register')
			$("#link").val("?app=user&view=register");				
		else if(tm=='profile')
			$("#link").val("?app=user&view=profile");	
		
	});
});
</script>

<input type="hidden" name="totalParam" value="1"/>
<input type="hidden" name="nameParam1" value="view" />
<li>
	<h3>User Menu</h3>
		<div class="isi">
			<div class="acmain open">
			<table class="data2">				
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td class="djudul">Page Type</td>
				<td>
					<select id="type"  name='param1'/>
						<option value='login' <?php echo @$view1;?>>Login Page</option>
						<option value='register' <?php echo @$view2;?>>Register Page</option>
						<option value='profile' <?php echo @$view3;?>>Profile Page</option>
					</select>
				</td>
			</tr>			
		</table>
		</div>
	</div>
</li>
