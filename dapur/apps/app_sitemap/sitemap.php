<?php
/* 
	This is phpSitemapNG, a php script that creates your personal google sitemap
	It can be downloaded from http://enarion.net/google/
	License: GPL
	
	Tobias Kluge, enarion.net
*/

require_once('inc/startup.php');

switch ($state) {
	case PSNG_ACTION_SETTINGS_RESET:
		viewSetup(TRUE);
		break;
			
	case PSNG_ACTION_SETTINGS_SETUP:
		resetRunon();
		viewSetup();
		break;

	case PSNG_ACTION_SETTINGS_GET: // & parse
		echo "<div class='sitemap-wrap sitemap-title'>";
		getSettings();
			echo "</div>";
		
	case PSNG_ACTION_SETTINGS_PARSE:
		echo "<div class='sitemap-wrap'>";
		$FILE = parseFilesystem();
		
		// check for timeout
		if ($SETTINGS[PSNG_TIMEOUT_ACTION] != '') break;
		// if no timeout, print result or write it
		if ($SETTINGS[PSNG_EDITRESULT] == PSNG_EDITRESULT_TRUE) {
			echo "</div>";
			displaySitemapEdit($FILE);
		} else {
		echo "<div class='sitemap-wrap'>";
			writeSitemap($FILE); echo "</div>";
		}
		break;
		
	case PSNG_ACTION_SETTINGS_WRITESITEMAP_USERINPUT:
		echo "<div class='sitemap-wrap'>";
		writeSitemapUserinput();echo "</div>";
		break;
	
	case PSNG_ACTION_SETTINGS_PINGGOOGLE:
		submitPageToGoogle();		
		break;

	case PSNG_ACTION_CHECK_UPDATESTATUS:
		checkUpdateStatus();
		break;
	
	default:
		viewSetup();
		break;
}

require_once(PSNG_FILE_INC_SHUTDOWN);

?>