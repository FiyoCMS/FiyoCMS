<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>

<script> 
$(document).ready(function(){	
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
		
	// username checker
	$("#username").change(function(){ 
    $('#pesan').html("<span class='formloading'>checking...</span>");	
    var username  = $("#username").val(); 
		$.ajax({
		 type:"POST",
		 url:"apps/app_user/controller/check_user.php",    
		 data: "act=user&username=" + username,
		 success: function(data){                 
			if(data==0){
				$("#pesan").html("<span class='form_ok'>Username availible</span>");	
			} 
			else if(data==2){
				$("#pesan").html("<span class='form_error'>Username not valid</span>"); 
			} 
			else {
				$("#pesan").html("<span class='form_error'>Username not availible</span>");   
		   }
		}
		}); 		
		setTimeout(function(){
			$(".form_ok").fadeOut(1000, function() {
			});				
		}, 3000);		
	});
	
	
	
	// email checker	
	$("#email").change(function(){ 		
		$('#pesan_email').html("<span class='formloading'>checking...</span>");	
		var email  = $("#email").val(); 		
		$.ajax({
		 type:"POST",
		 url:"apps/app_user/controller/check_user.php",    
		 data: "act=email&email=" + email,
		 success: function(data){                 
			if(data==0){
				$("#email").parent().append("<span class='form_ok'>Email availible</span>");	
			} 
			else if(data==2){
				$("#email").parent().append("<span class='form_error'>Email not valid</span>"); 
			} 
			else {
				$("#email").parent().append("<span class='form_error'>Email not availible</span>");   
		   }
		}
		}); 		
		setTimeout(function(){
			$(".form_ok").fadeOut(1000, function() {
			});				
		}, 3000);
	});
	
	// re-password checker	
	$("#repassword").change(function(){
	
		var password  = $("#pass").val(); 	
		var repassword  = $("#repassword"); 
			if(password==repassword.val()){
				repassword.parent().append("<span class='form_ok'>Passed</span>");	
			} 
			else {
				repassword.parent().append("<span class='form_error'>Re-password not valid</span>");   
		   }
		
		setTimeout(function(){
			$(".form_ok").fadeOut(1000, function() {
			});				
		}, 3000);	
			
	});
	
	$.getScript(
		'apps/app_user/controller/pass.min.js',
		function() {
			$('form').passroids({
				main : "#pass"
			});
		}
	);
	
	
});
</script>
<div class=" box-left">
	<div class="box">								
		<header class="dark">
			<h5>Login Data</h5>
		</header>								
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Username_tip; ?>" width="40%">Username</td>
					<td><input type="hidden" name="id" value="<?php echo $qr['id']; ?>"><input type="hidden" name="z" id="user" value="<?php echo $qr['user']; ?>">
					<input type="text" id="username" required  name="user" size="20" <?php echo formRefill('user',"$qr[user]"); ?> class='alphanumeric'/>
					<input type="text" name="z" size="1" style="display:none" value="<?php echo $qr['user']; ?>"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Password_tip; ?>">Password</td>
					<td><input type="password" name="x" style="display:none">
					<input type="password" name="password" size="20" <?php if($_GET['act'] == 'add') echo 'required'; ?> id="pass"  placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo RePassword_tip; ?>">Re-Password</td>
					<td><input type="password" name="kpassword" size="20" <?php if($_GET['act'] == 'add') echo 'required'; ?> id="repassword"  placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Email_tip; ?>">Email</td>
					<td><input type="email" id="email" name="email" size="30" required class='email' <?php echo formRefill('email',"$qr[email]"); ?> /></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_Group_tip; ?>">User Group</td>
					<td>
						<select name="level" id="select">
						<?php
							$sql2=$db->select(FDBPrefix.'user_group'); 
							while($qrs=mysql_fetch_array($sql2)){
							 if($qrs['level'] >= userInfo('level')) {
								if($qrs['level'] > 3 AND $_GET['act'] == 'add'){
									echo "<option value='$qrs[level]' selected>$qrs[group_name]</option>";
								}
								else if($qrs['level']==$qr['level']){
									echo "<option value='$qrs[level]' selected>$qrs[group_name]</option>";
								}
								else {
									echo "<option value='$qrs[level]'>$qrs[group_name]</option>";
								}
							  }
							}
						?>
						</select>
					</td>
				</tr>	
			</table>			
		</div>  
	</div>
</div>
<div class="col-lg-6 box-right">
	<div class="box">								
		<header class="dark">
			<h5>Personal Data</h5>
		</header>								
		<div>
			<table>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Full_Name_tip; ?>"><?php echo Full_Name; ?></td>
					<td><input type="text" required name="name" size="30"  <?php echo formRefill('name',"$qr[name]"); ?> ></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo Active_Status_tip; ?>"><?php echo Active_Status; ?></td>
					<td style="padding: 5px 10px;">
					
						<p class="switch">
					<?php 
						if($qr['status'] or $_GET['act'] =='add'){$s1="selected checked"; $s0 = "";}
						else {$s0="selected checked"; $s1= "";}
						if($_SESSION['USER_ID'] != $qr['id'] or $_GET['act'] == 'add') :
					?>
								<input id="radio1" value="1" name="status" type="radio" <?php echo $s1;?> class="invisible">
								<input id="radio2" value="0" name="status" type="radio" <?php echo $s0;?> class="invisible">
								<label for="radio1" class="cb-enable <?php echo $s1;?>"><span><?php echo Enable;?> </span></label>
								<label for="radio2" class="cb-disable <?php echo $s0;?>"><span><?php echo Disable;?> </span></label>
						
					<?php
					 else : ?>
						<label class='cb-enable selected  no-change'><span><?php echo Enable;?></span></label>
						<label class='cs-disable  no-change'><span><?php echo Disable;?></span></label>
					<?php
					 endif; ?></p>
					</td>
				</tr>
				
				<tr>
					<td class="row-title"><span class="tips" title="<?php echo User_bio_tip; ?>">Bio</td>
					<td><textarea name="bio" rows="6" style="width:100%; padding: 5px;resize: vertical;"><?php echo formRefill('bio',"$qr[about]",'textarea'); ?></textarea></td>
				</tr>
			</table>	
		</div>  
	</div> 
</div>  
