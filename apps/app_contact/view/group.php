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
$contact -> category($id);
	
if(isset($contact->name))
{	
?>	
<?php if(defined('Apps_Title')) echo "<h1>".PageTitle."</h1>"; ?>
<div id="contact">

	<?php 
	
	for($i=0; $i < $contact->perrows ;$i++)
	{
	?>			
	<div class="group-contact <?php if($a=$i%2==0) echo "ganjil"; else echo "genap"; ?>">
		
	<?php if($contact->sphoto==1) echo "<div class=\"group-photo\">".$contact->photo[$i]."</div>"; ?>
	
		<div class="group-detail-contact">
		<?php if($contact->sname==1) echo "<label>".$contact->name[$i]."</label>"; ?>
			<?php if($contact->sjob==1) echo "<span class='contact-job '>".$contact->job[$i]."</span>"; ?>
			
			<?php if($contact->saddress==1) echo "<div class='address'>".$contact->address[$i]."</div>"; ?>
			<?php if($contact->semail==1 AND !empty($contact->email[$i])) echo "<span class='email'>".$contact->email[$i]."</span>"; ?>
			<?php if($contact->sphone==1) echo "<span class='phone'>".$contact->phone[$i]."</span>"; ?>
			<?php if($contact->sphone==1) echo "<div class='links'>".$contact->links[$i]."</div>"; ?>
		</div>
	</div>
	<?php	
	}
	?>		
	<div class="contact-paging">
		<?php echo $contact->pagelink; ?>
	</div>
</div>

<script>
	$(function () {		
		var c = $("#contact");
		if(c.width() < 600 ) {
			$(".about-me").addClass('max-about-me').appendTo("#contact");			
		}
	})
</script>
<?php
}
?>