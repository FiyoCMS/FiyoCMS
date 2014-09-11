<?php
/**
* @version		v 1.2.1
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see license.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$db = @new FQuery() or die;  
$db->connect();

//set request id 
if(!empty($_REQUEST['id'])){
	$id=$_REQUEST['id'];	
	$sql = $db->select(FDBPrefix.'contact','*','id='.$id); 
	$qr	 = mysql_fetch_array($sql);
}
else {
	$id = null;
	$qr = null;
}

?>
<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".delete").click(function(){
		$("#img").hide();
		$(this).hide();
		$(".imgdiv").html("<a>Choose Image</a>");
		$("#img1").val('');
		$(".image-group").addClass('noimg');	
	});	
	
	$(".image-group .imgdiv").hover(function() {
		$(this).toggleClass('selected');		
	});
});
function openKCFinder(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = 1;
            div.innerHTML = '<div style="margin:5px">Loading...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                div.innerHTML = '<img id="img" src="' + url + '" class="img" title="click to change image" height=" 150px;"  /><input type="hidden" value="' + url + '" class="imgval" name="photo">';
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    img.style.width = f_w + "px";
                    img.style.height = f_h + "px";
                } else {
                    f_w = o_w;
                    f_h = o_h;
                }
                img.style.visibility = "visible";
				$(".image-group").removeClass('noimg');
				$(".delete").show();
            }
        }
    };
    window.open('../plugins/plg_kcfinder/browse.php',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=700, height=400'
    );
}
</script>
<div class="col-lg-6 box-left">
	<div class="panel box"> 		
		<header>
			<h5>Umum</h5>
		</header>
		<div>
			<table class="data2">
				<input value="<?php echo @$qr['id'];?>" type="hidden" name="id">
				<tr>
					<td><?php echo Name; ?></td>
					<td><input value="<?php echo $qr['name'];?>" type="text" name="name" size="20" required tabindex="1"></td>
				</tr>
				<tr>
					<td><?php echo Gender; ?></td>
					<td><select name="gender" tabindex="2">
					<option value="1" selected><?php echo Man; ?></option>
					<option value="2" <?php if($qr['gender']==2) echo 'selected'; ?>><?php echo Woman; ?></option>
					</select></td>
				</tr>	
				<tr>
					<td title="Contact Group">Contact Group</td>
					<td><select name="group" tabindex="3">
					<?php
					$sql2 = $db->select(FDBPrefix.'contact_group');
					while($qr2=mysql_fetch_array($sql2)){
						if($qr2['id']==$qr['group_id']){ 
							echo "<option value='$qr2[id]' selected>$qr2[name]</option>";
						}
						else {
							echo "<option value='$qr2[id]'>$qr2[name]</option>";
						}						
					}
					?>
					</select></td>
				</tr>			
				<tr>
					<td><?php echo Address; ?></td>
					<td><textarea tabindex="4" rows="3" cols="45"style="margin-right:-30px;" name="address" required><?php echo $qr['address'];?></textarea></td>
				</tr>
				
				<tr>
					<td><?php echo City; ?></td>
					<td><input tabindex="5" required value="<?php echo $qr['city'];?>" type="text" name="city" size="20"></td>
				</tr>	
				<tr>
					<td><?php echo State; ?></td>
					<td><input tabindex="6" required value="<?php echo $qr['state'];?>" type="text" name="state" size="20"></td>
				</tr>	
				<tr>
					<td><?php echo Country; ?></td>
					<td><input tabindex="7" required value="<?php echo $qr['country'];?>" type="text" name="country" size="20"></td>
				</tr>	
				<tr>
					<td><?php echo Zip; ?></td>
					<td><input tabindex="8" required value="<?php echo $qr['zip'];?>" type="text" name="zip" size="20"></td>
				</tr>	
				
				<tr>
					<td><?php echo Job; ?></td>
					<td><input tabindex="9" value="<?php echo $qr['job'];?>" type="text" name="job" size="20"></td>
				</tr>
				
				<tr>
					<td><?php echo Description; ?></td>
					<td><textarea tabindex="10" rows="4" cols="40"style="margin-right:-30px;" name="desc"><?php echo $qr['description'];?></textarea></td>
				</tr>
				
			</table>
		</div>
	</div>
</div>
<div class="box-right">
	<div class="box">									
		<header class="dark">
			<h5>Module Details</h5>
		</header>				
		<div class="isi">
			<table class="data2">				
				<tr>
					<td>Email</td>
					<td><input tabindex="11" value="<?php echo $qr['email'];?>" class='email' type="text" name="email" size="28"></td>
				</tr>	
				<tr>
					<td><?php echo Phone; ?></td>
					<td><input tabindex="12" value="<?php echo $qr['phone'];?>" type="text" name="phone" size="20"></td>
				</tr>
				<tr>
					<td>Fax</td>
					<td><input tabindex="13" value="<?php echo $qr['fax'];?>" type="text" name="fax" size="20"></td>
				</tr>							
				<tr>
					<td title="Website or Blog">Website</td>
					<td>
					
					<div class="input-group">
						<span class="input-group-addon">http://</span>
					<input tabindex="14" value="<?php echo $qr['web'];?>" class='web' type="text" name="web" size="20"></td>
                    </div></td>
				</tr>
				
				<tr>
					<td title="Yahoo Massagger ID">Yahoo! Massagger</td>
					<td><input tabindex="15" value="<?php echo $qr['ym'];?>" type="text" name="ym" size="20" id="order"></td>
				</tr>	
				<tr>
					<td title="Facebook Page">Facebook</td>
					<td>
					<div class="input-group">
						<span class="input-group-addon"><i class="icon-facebook"></i></span>
						<input tabindex="16" value="<?php echo $qr['fb'];?>" type="text" name="fb" size="20"></td>
                    </div>
					
					
					</td>
				</tr>	
				<tr>
					<td title="Twitter Page">Twitter</td>
					<td>
					<div class="input-group">
						<span class="input-group-addon"> @ </span>
						<input tabindex="17" value="<?php echo $qr['tw'];?>" type="text" name="tw" size="20"></td>
                    </div>
				</tr>	
				<tr>
					<td>Photo</td>
					<td><input type="hidden" id="img1" name="photo" value="<?php echo $qr['photo'];?>">
					<div class="image-group <?php if(empty($qr['photo'])) echo "noimg"; ?>">
						<div id="image1" class="imgdiv btn" onclick="openKCFinder(this)"><?php if(!empty($qr['photo'])) echo "<img id='img' src='$qr[photo]' class='img tips' height='150' title='click to change image'>";?><a <?php if(!empty($qr['photo'])) echo " style=' display: none';"; ?>>Choose Image</a></div>
						<label <?php if(empty($qr['photo'])) echo " style=' display: none';"; ?> class=" red tips delete btn" data-placement="top" title="" data-original-title="<?php echo Delete; ?>"><span><b class="icon-remove-sign"></b></span></label>
						<span class="infade">aasdasdsdsd</span>
					</div>
					
					
					</td>
				</tr>		
			</table>
		</div>
	</div>
</div>