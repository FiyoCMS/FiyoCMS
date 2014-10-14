<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$id = app_param('id');
$contact = new Contact() or die; 

//$contact -> send(@$_POST['name'],@$_POST['email'],@$_POST['text'],@$_POST['send'],@$_POST['to']);
	$param = menuInfo('parameter','?app=contact','',true);
	$email = parse_param('office_email',$param);
	$ph1	= parse_param('office_phone1',$param);
	$ph2 = parse_param('office_phone2',$param);
	$addr = parse_param('office_address',$param);
	$text = parse_param('office_text',$param);
	$fax = parse_param('office_fax',$param);
	$map = parse_param('office_map',$param);
	$x = explode(";",$param);
	$i = 0;
	

?>

<script>
function reloadCaptcha() {
	document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
}

$(function() {
	$('.send_contact').click(function() {	
		var name = $("#contact-name").val();
		var email = $("#contact-email").val();
		var text = $("#contact-text").val();
		var phone = $("#contact-phone").val();
		var subject = $("#contact-subject").val();
		var url = $("#contact-url").val();
		var captcha = $("#contact-captcha").val();
		var t = $(this);
		t.html("Loading...").attr('disabled','');
		$.ajax({
			type : "POST",
			data: "send=true&name="+name+"&email="+email+"&subject="+subject+"&text="+encodeURIComponent(text)+"&captcha="+captcha+"&phone="+phone+"&to=<?php echo $email;?>",
			url: "<?php echo FUrl; ?>apps/app_contact/controller/send_mail.php",
			timeout: 5000, 
			error:function(data){	
				alert("Send Message Error!");
				t.html("<?php echo Send_Message;?>").removeAttr('disabled');
			},
			success: function(data){
				var json = $.parseJSON(data);
				$(".alert, .notice").remove();
				$(".form-contact").before(json.alert);
				if(json.status == '1')	$("#contact-text").val("");
				t.html("<?php echo Send_Message;?>").removeAttr('disabled');
				reloadCaptcha();
			}
		});
	});	
});
	
</script>
<?php if(defined('Apps_Title')) echo "<h1>".PageTitle."</h1>"; ?>
	<div class="office-contact">	
		
		<?php if(!empty($map)) : ?> 
		<div class="office-address">
			<?php echo $map;?>
		</div>
		<?php endif; ?>
		
		<div class="office-address">
		<?php if(!empty($map)) : ?> 
		<h2>Contact Info</h2>
		<?php endif; ?>
		
		<?php if(!empty($text)) : ?> 
			<div class="office-text">
			<?php echo  $text;?>
			</div>			
		<?php endif; ?>
		
		<div class="office-a">
			<label><?php echo Address;?></label>
			<div><?php echo str_replace("\n","<br>",$addr);?></div>
		</div>
		
		<div class="office-c">
			<div>
				<label>Email</label>		
				<div><?php echo $email;?></div>
			</div>
			<div>
				<label>Phone</label>		
				<div><?php echo $ph1;?></div>
				<div><?php echo $ph2;?></div>
			</div>
			<div>
				<label>Fax</label>		
				<div><?php echo $fax;?></div>
			</div>
		</div>
		</div>
		
		<div class="office-form">
		<h2>Leave Message</h2>
		<form method="post" action="#contacts" class="form-contact">
			<div id="input-personal-data">
				<div>
				<label>
					<span>Nama *</span>
					<div>
						<input type="text" name="name" id="contact-name" class="input form-control" placeholder="Name" required="">
					</div>
				</label></div>
				<div>
					<label><span>Email *</span>
					<div>
						<input class="input required email form-control" id="contact-email" type="email" name="email" placeholder="name@email.com" required="">
					</div>
				</label></div>
				<div>
					<label><span>Phone </span>
					<div>
						<input type="text" class="input form-control" id="contact-phone" name="phone" value="" >
					</div>
				</label></div>	
			</div>
			
			<div id="input-text-contact">
				<label><span>Judul *</span>
				<div>
					<input type="text" class="input form-control" id="contact-subject" name="title" style="width:100%; max-width : 100%;">
				</div>
				</label>
				<label><span>Komentar *</span>
				<div>
					<textarea class="input required form-control" id="contact-text" name="com" style="width:100%; max-width : 100%;" rows="8" required="" data-placeholder="Tulis komentar disini..." placeholder="Tulis komentar disini..."></textarea>
				</div>
			</label></div>
				<div style="overflow: visible;">
				<button type="button" name="send-message" class="contact-button button btn send_contact" value="Send">Beri Komentar</button>
			</div>
		</form>
		</div>
		
	</div>