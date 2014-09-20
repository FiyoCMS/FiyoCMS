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
?>
<form method="post" action="?app=config">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title"><?php echo Site_Configuration; ?></div>
			<div class="app_link">
				<button type="submit" class="save btn" title="<?php echo Save; ?>" value="<?php echo Save; ?>" name="config_save"><?php echo Save; ?></button>
				<?php printAlert(); ?>
			</div>		
		</div>
	</div>
	
<div class="box-left col-lg-6">
	<div class="box" id="general"> 		
		<header>
			<h5><?php echo General_Settings; ?></h5>
		</header>
		<div>
			<table>		
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Site_Name_tip; ?>" width="40%"> <?php echo Site_Name; ?></td>
					<td><input type="text" name="site_name" size="30" value="<?php echo siteConfig('site_name'); ?>" required></td>
				</tr> 
				
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Site_Title_tip; ?>"><?php echo Site_Title; ?></td>
					<td><input type="text" name="title" size="30" value="<?php echo siteConfig('site_title'); ?>" required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Site_URL_tip; ?>"><?php echo Site_URL; ?></td>
					<td>
					<div id="datetimepicker1" class="input-append date input-group" style="  width: 221px; max-width: 100%;">
					<span class="add-on input-group-addon">
					  <span>http://</span>
					</span>
					<input required type="text" name="url" size="40" value="<?php echo siteConfig('site_url'); ?>">
				 </div></td>
				</tr>	
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Site_Mail_tip; ?>"><?php echo Site_Mail; ?></td>
					<td><input type="email" name="mail" size="30" value="<?php echo siteConfig('site_mail'); ?>" required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Folder_AdminPanel_tip; ?>"><?php echo Folder_AdminPanel; ?></td>
					<td><input type="text" name="folder_new" size="15" value="<?php echo siteConfig('backend_folder'); ?>">
					<input type="hidden" name="folder_old" value="<?php echo siteConfig('backend_folder'); ?>" required></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Site_Status_tip; ?>"><?php echo Site_Status; ?></td>
					<td>
						<?php 
							if(siteConfig('site_status')){$s1="selected checked"; $s0 = "";}
							else {$s0="selected checked"; $s1= "";}
						?>
						<p class="switch">
							<input id="radio1"  value="1" name="status" type="radio" <?php echo $s1;?> class="invisible">
							<input id="radio2"  value="0" name="status" type="radio" <?php echo $s0;?> class="invisible">
							<label for="radio1" class="cb-enable <?php echo $s1;?>"><span>Online</span></label>
							<label for="radio2" class="cb-disable <?php echo $s0;?>"><span>Offline</span></label>
						</p>
					</td>
				</tr>
				
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Meta_Keywords_tip; ?>"><?php echo Meta_Keywords; ?></td>
					<td><textarea rows="4" cols="30" name="meta_keys" style="width:100%; resize: vertical;"><?php echo siteConfig('site_keys'); ?></textarea></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Meta_Description_tip; ?>"><?php echo Meta_Description; ?></td>
					<td>
					<textarea rows="6" cols="30" name="meta_desc" style="width:100%; resize: vertical;"><?php echo siteConfig('site_desc'); ?></textarea></td>
				</tr>
			</table>
		</div>
	</div>
</div>
	
	
<div class="panel-group col-lg-6 box-right" id="accordion">
	<div class="panel box"> 			
		<header>
		<a class="accordion-toggle" data-toggle="collapse" data-target="#sef" data-parent="#accordion">	
		<h5><?php echo SEF_Settings; ?></h5>
		</a>
		</header>
		<div id="sef" class="panel-collapse in">	
			<table>		
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo SEF_URLs_tip; ?>"><?php echo SEF_URLs; ?></td>
					<td>
						<?php 
							if(siteConfig('sef_url')){$u1="selected checked"; $u0 = "";}
							else {$u0="selected checked"; $u1= "";}
						?>
						<p class="switch">
							<input id="radio3"  value="1" name="sef" type="radio" <?php echo $u1;?> class="invisible">
							<input id="radio4"  value="0" name="sef" type="radio" <?php echo $u0;?> class="invisible">
							<label for="radio3" class="cb-enable <?php echo $u1;?>"><span>On</span></label>
							<label for="radio4" class="cb-disable <?php echo $u0;?>"><span>Off</span></label>
						</p>
					</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Redirect_WWW_tip; ?>"><?php echo Redirect_WWW; ?></td>
					<td>
						<?php 
							if(siteConfig('sef_www')){$u1="selected checked"; $u0 = "";}
							else {$u0="selected checked"; $u1= "";}
						?>
						<p class="switch">
							<input id="radio7"  value="1" name="www" type="radio" <?php echo $u1;?> class="invisible">
							<input id="radio8"  value="0" name="www" type="radio" <?php echo $u0;?> class="invisible">
							<label for="radio7" class="cb-enable <?php echo $u1;?>"><span>On</span></label>
							<label for="radio8" class="cb-disable <?php echo $u0;?>"><span>Off</span></label>
						</p>
						</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Link_Follow_tip ?>">Link Follow </td>
					<td><?php 
						if(siteConfig('follow_link')){$l1="selected checked"; $l0 = "";}
						else {$l0="selected checked"; $l1= "";}
						?>
						<p class="switch">
							<input id="radio5"  value="1" name="follow_link" type="radio" <?php echo $l1;?> class="invisible">
							<input id="radio6"  value="0" name="follow_link" type="radio" <?php echo $l0;?> class="invisible">
							<label for="radio5" class="cb-enable <?php echo $l1;?>"><span>On</span></label>
							<label for="radio6" class="cb-disable <?php echo $l0;?>"><span>Off</span></label>
						</p>
					</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Title_Type_tip; ?>"><?php echo Title_Type; ?></td>
					<td>
						<?php 
							$titile_type = siteConfig('title_type');
							$tt1 = $tt2 = $tt3 =$tt0 = 0;
							if($titile_type=='1') $tt1='selected'; 
							if($titile_type=='2') $tt2='selected';
							if($titile_type=='3') $tt3='selected'; 
							if($titile_type=='0') $tt0='selected';
						?>
						<select name="title_type"><option value="1" <?php echo $tt1; ?>>Page Title,  Sperator, Site Title</option><option value="2" <?php echo $tt2; ?>>Site Title,  Sperator, Page Title</option><option value="3" <?php echo $tt3; ?>>Page Title</option><option value="0" <?php echo $tt0; ?>>Site Title</option></select></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Title_Divider_tip; ?>"><?php echo Title_Divider; ?></td>
					<td><label>
						<input type="text" name="title_divider" size="5" value="<?php echo siteConfig('title_divider'); ?>"></label>							
					</td>
				</tr>	
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo SEF_Extention_tip ?>">SEF Extention</td>
					<td><label>
						<input type="text" class="alphadot" name="sef_ext" size="5" value="<?php echo siteConfig('sef_ext'); ?>"></label>							
					</td>
				</tr>							
			</table>
		</div>	
	</div>	
	
	<div class="panel box"> 
		<header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-target="#db" data-parent="#accordion">	
		<h5><?php echo Database_Settings; ?></h5>
		</a>
		</header>
		<div id="db" class="panel-collapse collapse">		
			<div class="alert-warning">			
			<?php echo Warning_to_Change_DB; ?></div>
			<table>		
					<tr>
						<td class="row-title"><span class="tips"  title="Database">Database</td>
						<td><input type="text" name="name" size="20" value="<?php echo FDBName; ?>" readonly></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips"  title="Hostname">Host</td>
						<td><input readonly type="text" value="<?php echo FDBHost; ?>" size="20" ></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips"  title="Username">Username</td>
						<td><input type="text" value="<?php echo FDBUser; ?>" size="20" readonly></td>
					</tr>
					<tr>
						<td class="row-title"><span class="tips"  title="Password">Password</td>
						<td><input type="password" value="<?php echo FDBPass; ?>" size="20" readonly></td>
					</tr>
			</table>
		</div>	
	</div>	
	
	<div class="panel box"> 
		<header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-target="#member" data-parent="#accordion">	
		<h5><?php echo Member_Settings; ?></h5>
		</a>
		</header>
		<div id="member" class="panel-collapse collapse">			
			<table>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Member_Register_tip; ?>"><?php echo Member_Register; ?></td>
					<td>
						<?php 
							if(siteConfig('member_registration')){$m1="selected checked"; $m0 = "";}
							else {$m0="selected checked"; $m1= "";}
						?>
						<p class="switch">
							<input id="radio11"  value="1" name="member_registration" type="radio" <?php echo $m1;?> class="invisible">
							<input id="radio12"  value="0" name="member_registration" type="radio" <?php echo $m0;?> class="invisible">
							<label for="radio11" class="cb-enable <?php echo $m1;?>"><span><?php echo Enable; ?></span></label>
							<label for="radio12" class="cb-disable <?php echo $m0;?>"><span><?php echo Disable; ?></span></label>
						</p>
					</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Member_Activation_tip; ?>"><?php echo Member_Activation; ?></td>
					<td>							
						<?php 
							$ac_1 = $ac_2 = $ac_3 = null;
							$ac  = siteConfig('member_activation'); 
							if($ac =='0') $ac_1 ='selected'; 
							if($ac =='1') $ac_2 ='selected';
							if($ac =='2') $ac_3 ='selected';
						?>
						<select name="member_activation" style="width: 150px">
							<option value="0" <?php echo $ac_1; ?>>Admin Confirmation</option>
							<option value="1" <?php echo $ac_2; ?>>Automatic</option>
							<option value="2" <?php echo $ac_3; ?>>Email Confirmation</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Default_Group_Member_tip; ?>"><?php echo Default_Group_Member; ?></td>
					<td>
					<select name="member_group" id="select">
					<?php
						$sql2=$db->select(FDBPrefix.'user_group'); 
						while($qrs=mysql_fetch_array($sql2)){
							if($qrs['level'] >= USER_LEVEL) {
								if($qrs['level'] < 3){
									echo "<option value='$qrs[level]' disabled>$qrs[group_name]</option>";
								}
								else {
									if($qrs['level'] == siteConfig('member_group'))
										$s = 'selected';
									else
										$s = '';
									echo "<option value='$qrs[level]' $s>$qrs[group_name]</option>";
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
	<div class="panel box"> 
		<header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-target="#media" data-parent="#accordion">	
		<h5><?php echo Media_Settings; ?></h5>
		</a>
		</header>
		<div id="media" class="panel-collapse collapse">			
			<table>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Allow_File_Extentions_tip; ?>"><?php echo Allow_File_Extentions; ?></td>
					<td><input type="text" name="file_allowed" size="30" style="width: 90%" value="<?php echo siteConfig('file_allowed'); ?>"></td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Disk_Space_tip; ?>"><?php echo Disk_Space; ?></td>
					<td><input type="text" name="disk_space" size="5" class="numeric spinner" value="<?php echo siteConfig('disk_space'); ?>" > MB</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Max_File_Size_tip; ?>"><?php echo Max_File_Size; ?></td>
					<td><input type="text" name="file_size" size="12" class="numeric spinner" value="<?php echo siteConfig('file_size'); ?>" > KB</td>
				</tr>				
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Media_Theme_tip; ?>"><?php echo Media_Theme; ?></td>
					<td>
						<?php 
						$dark = $default = null;
						$theme_m  = siteConfig('media_theme'); 
						if($theme_m =='oxygen') $default='selected'; 
						if($theme_m =='dark') $dark='selected';?>
						<select name="media_theme">
						<option value="oxygen" <?php echo $default; ?>>Default</option><option value="dark" <?php echo $dark; ?>>Dark</option></select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="panel box"> 
		<header>
		<a class="accordion-toggle collapsed" data-toggle="collapse" data-target="#time" data-parent="#accordion">	
		<h5><?php echo Language_and_Time; ?></h5>
		</a>
		</header>
		<div id="time" class="panel-collapse collapse">			
			<table>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Language_AdminPanel_tip; ?>"><?php echo Language; ?></td>
					<td>
						<select name="lang" class="lang-select" style="width: 500px">
						<?php
							include('controller/countrycode.php');
							$lang = siteConfig('lang');
							$dir=opendir("system/lang"); 
							$no=1;
							while($folder=readdir($dir)){ 
								if($folder=="." or $folder=="..")continue; 
								if(preg_match ( "/[\.]+php/i" , $folder))
								{	
									$folder = str_replace(".php","",$folder);
									if($folder == $lang) $selected_lang = 'selected';
									else $selected_lang = '';
									echo "<option value=\"$folder\" $selected_lang>$code[$folder]
									</option>";
								}
								$no++;
							} 
							closedir($dir);
						?> </select>
					</td>
				</tr>
				<tr>
					<td class="row-title"><span class="tips"  title="<?php echo Time_Zone_tip; ?>"><?php echo Time_Zone; ?></td>
					<td>
						<select class="timezone-select" id="timezone" name="timezone" style="width: 800px">
							<?php include('controller/timezone.php'); ?>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</form>	
