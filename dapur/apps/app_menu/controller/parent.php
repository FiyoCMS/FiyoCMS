<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(!isset($_SESSION['USER_LEVEL']) AND $_SESSION['USER_LEVEL'] <= 2 AND !isset($_POST['cat'])) die ();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 

/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/
echo "<option value=''></option>";	
$sql3 = $db->select(FDBPrefix.'menu','*',"parent_id=0 AND category = '$_POST[cat]' AND id !='$_POST[id]'",'short ASC'); 
while($qr=mysql_fetch_array($sql3)){	
	if($qr['id']==$_POST['parent']){ 
		echo "<option value='$qr[id]' selected>$qr[name]</option>";
		option_sub_menu($qr['id'],$_POST['parent_id'],'');
	}
	else {
		echo "<option value='$qr[id]'>$qr[name]</option>";option_sub_menu($qr['id'],$_POST['parent'],'');
	}
}				

function option_sub_menu($parent_id,$sub = NULL,$pre) {
	$db = new FQuery();  
	$db->connect(); 
	if($_POST['id']) $eid = "AND id!=$_POST[id]"; else $eid = '';
	$sql = $db->select(FDBPrefix."menu","*","parent_id=$parent_id $eid");  
	while($qr=mysql_fetch_array($sql)){	
		if($sub==$qr['id']) $s="selected"; else $s="";
		echo "<option value='$qr[id]' $s>$pre|_ $qr[name]</option>";
		option_sub_menu($qr['id'],$sub,$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");	
	}	
}