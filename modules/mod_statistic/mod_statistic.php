<?php
/**
* @name			Module Statistic
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');

$td = mod_param('today',$modParam);
$yd = mod_param('yesterday',$modParam);
$tw = mod_param('thisweek',$modParam);
$lw = mod_param('lastweek',$modParam);
$tm = mod_param('thismonth',$modParam);
$lm = mod_param('lastmonth',$modParam);
$tg = mod_param('all',$modParam);
$info = mod_param('info',$modParam);

require_once("mod_system.php");

?>

<table style="margin-bottom: 0; width: 100%" class="statistic-table">
	<tbody>
		<?php if($td) { ?>
		<tr>
			<td style="width: 70%">
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_green.png" alt="flag" width="16" height="16"> Hari Ini</td>
			<td style="text-align:right"><?php echo $today; ?><!-- visitor --></td>
		</tr>		
		<?php } ?>
		<?php if($yd) { ?>
		<tr>
			<td>
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_green2.png" alt="flag" width="16" height="16"> Kemarin</td>
			<td style="text-align:right"><?php echo $yesterday; ?><!-- visitor --></td>
		</tr>
		<?php } ?>
		
		<?php if($tw) { ?>
		<tr>
			<td>
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_yellow.png" alt="flag" width="16" height="16"> Minggu Ini</td>
			<td style="text-align:right"><?php echo $thisweek; ?><!-- visitor --></td>
		</tr>
		<?php } ?>
		
		<?php if($lw) { ?>
		<tr>
			<td>
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_red.png" alt="flag" width="16" height="16"> Minggu Lalu</td>
			<td style="text-align:right"><?php echo $lastweek; ?><!-- visitor --></td>
		</tr>
		<?php } ?>
		
		<?php if($tm) { ?>
		<tr>
			<td>
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_blue.png" alt="flag" width="16" height="16"> Bulan Ini</td>
			<td style="text-align:right"><?php echo $thismonth; ?><!-- visitor --></td>
		</tr>
		<?php } ?>
		
		<?php if($lm) { ?>
		<tr>
			<td>
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_purple.png" alt="flag" width="16" height="16"> Bulan Lalu</td>
			<td style="text-align:right"><?php echo $lastmonth; ?><!-- visitor --></td>
		</tr>
		<?php } ?>
		
		<?php if($tg) { ?>
		<tr>
			<td>
				<img src="<?php echo FUrl; ?>modules/mod_statistic/images/flag_2.png" alt="flag" width="16" height="16"> Total</td>
			<td style="text-align:right"><?php echo $total; ?><!-- visitor --></td>
		</tr>
		<?php } ?>
		
		<?php if($info) { ?>		
		<tr>
			<td colspan='2' style="text-align:center">
			<div style="border-top: 1px solid #ccc; border-bottom: 1px solid #fff;"></div>
			<?php echo $html ?></td>
		</tr>
		<?php } ?>
		
	</tbody>
</table>
