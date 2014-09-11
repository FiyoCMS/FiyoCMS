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
$contact -> item($id,Page_ID);
$contact -> send(@$_POST['name'],@$_POST['email'],@$_POST['text'],@$_POST['send'],@$_POST['to']);

addJs(FUrl.'plugins/plg_jquery_ui/ui.validate.js');
if(isset($contact->name)) : ?>
	<div>
		<?php if(!empty($contact->photo) AND $contact->photo !='') : ?>	
		<div class="contact-photo">
			<?php echo $contact->photo; ?>
		</div>
		<?php endif; ?>	
			
		<div class="contact-detail">		
			<div>
				<label><?php echo _contact_Name; ?></label><div class="contact-name"><?php echo $contact->name; ?></div>
			</div>
			<?php if($contact-> address) : ?>
				<label><?php echo _contact_Address; ?></label>
				<div>
					<?php echo $contact->address; ?>
					
					<?php if($contact-> state or $contact-> city or $contact-> country) { ?>
						<br>
							<?php if($contact-> city) echo "$contact->city,"; ?>
							<?php if($contact-> state) echo "$contact->state,"; ?>
							<?php if($contact-> country)  echo $contact->country; ?>
						
					<?php } ?>			
					<?php if($contact-> zip) : ?>
						<br>
						<?php echo $contact->zip; ?>
						
					<?php endif; ?>
					
				</div>
			<?php endif; ?>
			
			<?php if($contact-> email) : ?>
				<div>
					<label><?php echo _contact_Email; ?></label>
					<div><?php echo $contact->email; ?>
					</div>
				</div>
			<?php endif; ?>
			
			
			<?php if($contact-> phone) : ?>				
				<div>
					<label><?php echo _contact_Phone; ?></label>
					<div><?php echo $contact->phone; ?></div>
				</div>
			<?php endif; ?>
			
			<?php if($contact->ym or $contact->facebook or $contact->twitter or $contact->web): ?>
				<div class="links">
					<label>Links</label>
					<div>
					<?php if(!empty($contact->ym)) echo $contact->ym; ?> <?php if(!empty($contact->twitter)) echo $contact->twitter; ?> <?php if(!empty($contact->facebook)) echo $contact->facebook; ?> <?php if(!empty($contact->web)) echo $contact->web; ?></div>
				</div>
			<?php endif; ?>
			
			<?php if($contact-> about) : ?>				
				<div class='about-me'>
					<label><?php echo _contact_About; ?></label>
					<div><?php echo $contact->about; ?></div>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	<script>
		$(function () {		
			var c = $("#contact");
			if(c.width() < 800 ) {
				$(".about-me").addClass('max-about-me').appendTo("#contact");			
			}
		})
	</script>
<?php endif; ?>