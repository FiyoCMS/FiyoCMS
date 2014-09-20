<?php
/**
* @version		2.0
* @package		Fiyo CMS Installer
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>
<?php if(empty($_SESSION['host']) AND empty($_SESSION['success'])) { ?>
<?php printAlert();?>
<form method="post" action="">
	<div class="panel box"> 		
		<header>
			<h5>
				<a class='active'><span>1</span> Database</a>			
				<a><span>2</span> Administration</a>
				<a><span>3</span> Finihsing</a>
			</h5>
		</header>
		<div>
			<table class="data2">
				<tr>
					<td class="row-title">Host Name</td>
					<td>
						<div><div><input type="text" name="host" size="20" autocomplete="off" value="localhost" required></div>
						<p>Nama host atau IP server, cth: localhost atau 127.0.0.1.</p>
						<p>Host name or IP server, eg: localhost atau 127.0.0.1.</p>
					</td>
				</tr>
				<tr>
					<td class="row-title">Database User</td>
					<td><div><input type="text" name="user" size="20" autocomplete="off" required <?php formRefill('user');?>  ></div>
					<p>Nama pengguna yang berhak untuk mengakses database.</p>
					<p>Username who has the privilege to access the database.</p>
					
					</td>
				</tr>
				<tr>
					<td class="row-title">Database Password</td>
						<td><div><input type="password" name="pass" size="20"  autocomplete="off">
						</div><p>Katakunci pengguna untuk mengakses database.</p>
						<p>User's password to access the database.</p>
						</td>
				</tr>
				<tr>
					<td class="row-title">Database Name</td>
					<td><div><input type="text" name="dbase" <?php formRefill('dbase');?> id="database" size="30"  autocomplete="off" required><span id="db_alert"></span></div>
					
					<?php if($_SERVER['SERVER_ADDR'] == '127.0.0.1' or $_SERVER['SERVER_ADDR'] == '::1' ) : ?>
						<div>
							<label  style='margin: 5px 0; font-size: .9em; color: #888;'>
							<input type="checkbox" name="overwrite" value="1">Timpa database yang sudah ada? <em>Overwrite exists database?</em></label>
						</div>
						<p>Nama database yang akan digunakan dan terbentuk secara otomatis apabila nama tersedia.</p>
						<p>Database's name that will be used and created automatically when the name is available.</p>
					
					<?php else :  ?>
					
						<p>Nama database yang telah dibuat dan siap digunakan.</p>
						<p>Database's name that hat has been created and ready to use.</p>
						
					<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td class="row-title">Table Prefix</td>
					<td>
						<div><input type="text" name="prefix" autocomplete="off" value="fiyo<?php echo rand(10,99);?>_" required></div>
						<p>Nama depan tabel untuk meningkatkan keamanan database.</p>
						<p>Prefix name table for improve the security of the database.</p>
						
						</td>
				</tr>
					
			</table>			
		</div> 
		<div class="box-footer box"> 	
			<footer>
				<div></div>
				<div>	
					<button type="Submit" value=""  id="next1"  name="step_1" class="btn btn-grad btn-primary">Next</button>
				</div>
			</footer>
		</div>		
	</div> 	
</form>

<?php } else if(!empty($_SESSION['host'])  AND !empty($_SESSION['user'])) { ?>

<script>	
$(function() {
	$(".prev-1").click(function () {
		$.ajax({			
			url: "system/installer/controller/clear_sess.php",
			type: "POST",
			success: function(data){		
				location.reload();
			}
		});		
	
	});
	// re-password checker	
	$("#repassword").change(function(){	
		var password  = $("#password").val(); 	
		var repassword  = $("#repassword").val(); 
			if(password==repassword){
				$("#pesan_repassword").html("<span class='form_ok'>Passed</span>");	
			} 
			else {
				$("#pesan_repassword").html("<span class='form_error'>Re-password not valid</span>");   
		   }
		
		setTimeout(function(){
			$(".form_ok").fadeOut(1000, function() {
			});				
		}, 3000);	
	});
});
	
</script>
<?php printAlert();?>
<form method="post" action="">
	<div class="panel box"> 		
		<header>
			<h5>		
				<a><span>1</span> Database</a>			
				<a class='active'><span>2</span> Administration</a>
				<a><span>3</span> Finihsing</a>
			</h5>
		</header>
		<div>
			<table class="data2">
				<tr>
					<td class="row-title">Website Title</td>
					<td>
						<div><div><input type="text" name="site" <?php formRefill('site');?> size="53" autocomplete="off" required></div>
					</td>
				</tr>
				<tr>
					<td class="row-title">Website Description</td>
					<td><div><textarea rows="3" cols="55" name="desc" <?php formRefill('desc');?> size="30" autocomplete="off"></textarea></div>
					<p>Deskripsi website juga berpengaruh pada hasil pencarian di mesin pencari.</p>
					<p>Description of the website also affects the search results in search engines.</p>
					
					</td>
				</tr>
				<tr>
					<td class="row-title">Administrator Username</td>
					<td><div><input type="text" name="username" <?php formRefill('username');?> id="adminpass" size="20" autocomplete="off" required></div>
					<p>Nama pengguna yang akan digunakan untuk mengakses AdminPanel.</p>
					<p>Username that will be used to privilege access in AdminPanel.</p>
					
					</td>
				</tr>
				<tr>
					<td class="row-title">Administrator Password</td>
					<td><div><input type="password" name="userpass" id="password"  size="20"  autocomplete="off" required>
						</div><p>Katakunci administrator untuk mengakses AdminPanel.</p>
						<p>Administrator 's password to access AdminPanel.</p>
					</td>
				</tr>
				<tr>
					<td class="row-title">Password Confirmation</td>
					<td><div><input type="password" id="repassword" name="repass" size="20" autocomplete="off" required><span id="pesan_repassword"></span>
						</div><p>Masukan kembali katakunci sebagai verifikasi.</p>
						<p>Re-enter the password as verification.</p>
					</td>
				</tr>
				<tr>
					<td class="row-title">Administrator Email</td>
					<td>
						<div><input type="email" name="email" size="30" <?php formRefill('email');?> value="" required></div>
						<p>Isi dengan email aktif untuk fitur penting yang membutuhkan konfirmasi email.</p>
						<p>Fill with active email for important features that need email confirmation.</p>
						
						</td>
				</tr>
					
			</table>			
		</div> 
		<div class="box-footer box"> 	
			<footer>
				<div></div>
				<div>	
					
					<button type="button" value="" name="step_-1" class="btn btn-grad prev-1">Prev</button>
					<button type="submit" value="" name="step_2" class="btn btn-grad btn-primary">Next <i class="icon-arrow-right"></i></button>
				</div>
			</footer>
		</div>		
	</div> 	
</form>
<?php 	}	else if(!empty($_SESSION['success'])) 	{ 	?>
<form method="post" action="">
	<div class="panel box"> 		
		<header>
			<h5>	
				<a><span>1</span> Database</a>			
				<a><span>2</span> Administration</a>
				<a class='active'><span>3</span> Finihsing</a>
			</h5>
		</header>
		<div style="padding: 20px; text-align: center;">
			<h1>Yeeaaahhh!!!</h1>
			<p>Selamat, proses instalasi berhasil dan telah siap digunakan!<br>
			<em>Congratulations, the installation process successfully and is ready to use!</em></p>
				<p>Untuk mendapatkan tema, modul, plugin dan apps melalui AddOns Store (<a href='http://addons.fiyo.org' target='_blank'>http://addons.fiyo.org</a>).
				<br/>
				<em>You can get theme, modules, plugins and apps on AddOns Store (<a href='http://addons.fiyo.org' target='_blank'>http://addons.fiyo.org</a>).
				</em></p><br> 
				<p><span class="alert-warning"><i class="icon-info-sign"></i> Default AdminPanel folder : /dapur</span></p><br> 
				<p>
				<button type="Submit" value="" name="admin" class="btn btn-grad">Go to AdminPanel</button> &nbsp;<button type="Submit" value="" name="home" class="btn btn-grad btn-primary">Go to Front Site</button>
				</p>
		</div> 
		<div class="box-footer box"> 	
			<footer>
				<div></div>
				<div>	
				
				</div>
			</footer>
		</div>		
	</div> 	
</form>

<?php } ?>		
