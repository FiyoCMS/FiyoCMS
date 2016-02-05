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

/****************************************/
/*	    Enable and Disbale Article		*/
/****************************************/
echo "<option value=''></option>";	
$sql = $db->select(FDBPrefix.'menu','*',"parent_id=0 AND category = '$_POST[cat]' AND id !='$_POST[id]'",'short ASC'); 
foreach($sql as $row){	
	if($row['id']==$_POST['parent']){ 
		echo "<option value='$row[id]' selected>$row[name]</option>";
		option_sub_menu($row['id'],$_POST['parent_id'],'');
	}
	else {
		echo "<option value='$row[id]'>$row[name]</option>";option_sub_menu($row['id'],$_POST['parent'],'');
	}
}				

function option_sub_menu($parent_id,$sub = NULL,$pre) {
	$db = new FQuery();  
	$db->connect(); 
	if($_POST['id']) $eid = "AND id!=$_POST[id]"; else $eid = '';
	$sql = $db->select(FDBPrefix."menu","*","parent_id=$parent_id $eid");  
	foreach($sql as $row){	
		if($sub==$row['id']) $s="selected"; else $s="";
		echo "<option value='$row[id]' $s>$pre|_ $row[name]</option>";
		option_sub_menu($row['id'],$sub,$pre."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");	
	}	
}