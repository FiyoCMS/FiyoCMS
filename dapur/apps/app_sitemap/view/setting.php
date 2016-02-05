<?php
/**
* @name			Plugin SEF
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
*/

defined('_FINDEX_') or die('Access Denied');
$db = new FQuery();  	
$web 		= oneQuery("sitemap_setting","name","root_url","value");
$timeout 	= oneQuery("sitemap_setting","name","timeout","value");
$ex_dir 	= oneQuery("sitemap_setting","name","ex_dir","value");
$ex_file 	= oneQuery("sitemap_setting","name","ex_file","value");
$xml 		= oneQuery("sitemap_setting","name","xml","value");
$txt 		= oneQuery("sitemap_setting","name","txt","value");

?>

<form name="setupExpert" action="" method="post" novalidate="novalidate">
<input type="hidden" name="action" value="getSettings" class="form-control">	
<div class="panel box"> 	
	<div>
	<table>
	  <tbody>	  
	  <tr>
	  	<td valign="top"><label for="iwebsite" accesskey="W">Website</label></td>
		<td>
			<input class="required" required size="50" type="Text" name="web" value="<?php echo $web; ?>" placeholder="http://">
			<br><font size="-1">root url of your website use prefix http://</font>
		</td>
	  </tr>

	  <tr>
	  	<td valign="top"><label class="tips" title="stop the execution after an amount of time">Timeout</label></td>
		<td><input type="number" min="30" name="timeout" size="1" value="<?php echo $timeout; ?>" class="form-control"> <font size="-1">execution time in seconds</font>
		</td>
	  </tr>
	  
	  <tr>
	  	<td valign="top">Exclude directories<br>or other match string</td>
		<td>
			<font size="-1">directories containing these substrings will will not be scanned for files and will not be added to site index; use line break to separate entries</font><br>
			<textarea name="ex_dir" cols="40" rows="7"><?php echo $ex_dir;?></textarea>
		</td>
	  </tr>
	  <tr>
	  	<td valign="top"><label for="idisallow_file" accesskey="F">Exclude files</label></td>
		<td>
			<font size="-1">files containing these substrings will not be crawled for further links and not added to site index; use line break to separate entries</font><br>
			<textarea name="ex_file" cols="40" rows="7" tabindex="4"><?php echo $ex_file;?></textarea>
		</td>
	  </tr>
	  
	  <tr>
	  	<td valign="top"><label for="isitemap_url" accesskey="S">XML Sitemap file</label></td>
		<td>
			<input type="Text" name="xml" id="isitemap_url" align="LEFT" size="20" value="<?php echo $xml; ?>" required><br>
			<font size="-1">relative to your page root; the generated sitemap will be stored to this file</font>
		</td>
	  </tr>
	  <tr>
	  	<td valign="top">TXT Sitemap file</td>
		<td>
			<input type="Text" name="txt" id="itxtsitemap_url" align="LEFT" size="20" value="<?php echo $txt; ?>" required><br>
			relative to your page root; the generated txt sitemap will be stored to this file; Used by Yahoo, etc.
		</td>
	  </tr>
	  
	</tbody></table>
	</div>
	<div class="box-footer box"> 	
		<footer>
			<div></div>
			<div>	
				<button type="Submit" value="" name="config_save" class="btn btn-grad btn-primary">Save</button>
			</div>
		</footer>
	</div>	
</div>
</form>