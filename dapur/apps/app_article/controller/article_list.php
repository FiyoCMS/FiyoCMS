<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(@$_SESSION['USER_LEVEL'] > 5 or !isset($_GET['iSortCol_0'])) die ('Access Denied!');
define('_FINDEX_','BACK');
require('../../../system/jscore.php');
header('Content-Type: application/json');
    $db = new DB;


	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'id', 'title', 'status', 'category', 'author_id', 'level', 'date', 'hits', 'featured', 'parameter' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "date";
	
	/* DB table to use */
	$sTable = FDBPrefix."article";
	
	/* 
	 * Paging
	 */
	$sLimit = "LIMIT 10";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "ORDER BY date desc";
	if (isset($_GET['iSortCol_0']) AND !empty($_GET['iSortCol_0']))
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	if(!empty($_GET['cat'])) $cat = " category = '$_GET[cat]'  AND "; 
	else $cat = '';
	if(!empty($_GET['user'])) $user = " author_id = '$_GET[user]'  AND "; 
	else $user = '';
	if(!empty($_GET['level'])) $level = " level = '$_GET[level]'  AND "; 
	else $level = '';
	
	$sWhere = "WHERE  $cat $user $level level >= $_SESSION[USER_LEVEL] ";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere .= " AND(";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".addslashes( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "AND " )
			{
				$sWhere .= " ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".addslashes($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM  $sTable
		$sWhere 
		$sOrder
		$sLimit
		";
	$rResult = $db->query( $sQuery);
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = $db->query( $sQuery)->fetchColumn();
	$iFilteredTotal = $rResultFilterTotal;
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	
	$rResultTotal = $db->query($sQuery)->fetchColumn();
	$iTotal = $rResultTotal;
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval(@$_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	foreach ( $rResult as $aRow )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{	
			/* logika status aktif atau tidak */
				/* logika status aktif atau tidak */
			if($aRow['status']==1)
			{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
			else
			{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
				
			/* logika frontpages */
				/* logika status aktif atau tidak */
			if($aRow['featured']==1)
			{ $fp1 ="selected"; $fp2 =""; $featured = 'featured star';}							
				else
			{ $fp2 ="selected";$fp1 ="";  $featured = 'not';}
								
			$title = $aRow['title'];
			$editor_level 	= mod_param('editor_level',$aRow['parameter']);
			if($_SESSION['USER_LEVEL'] == 1 OR $_SESSION['USER_ID'] == $aRow['author_id'] AND $aRow['author_id'] != 0 OR ($_SESSION['USER_LEVEL'] <= $editor_level OR (empty($editor_level) AND $_SESSION['USER_LEVEL'] <=3))) {
				$checkbox ="<label><input type='checkbox' data-name='rad-$aRow[id]' name='check[]' value='$aRow[id]' rel='ck' ><span class='input-check'></span></label>";
				
				$name ="<a class='tips' title='".Edit."' href='?app=article&act=edit&id=$aRow[id]' target='_self' data-placement='right'>$title</a>";	
					
				$status ="<span class='invisible'>$enable</span>
				<div class='switch s-icon activator editor'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-check-circle'></i></span></label>
					<input type='hidden' value='$aRow[id]' class='number invisible'>
					<input type='hidden' value='$aRow[status]'  class='type invisible'>
				</div>";
				
				$featured ="
				<div class='switch s-icon featured editor'><span class='invisible'>$featured</span>
					<label class='cb-enable $fp1 tips' data-placement='left' title='".Unfeatured."'><span>
					<i class='icon-star'></i>
					</span></label>
					<label class='cb-disable $fp2 tips' data-placement='left' title='".Featured."'><span>
					<i class='icon-star'></i></span></label>
					<input type='hidden' value='$aRow[id]'  class='number invisible'>
					<input type='hidden' value='$aRow[featured]' class='type invisible'>
				</div>";				
			}
			else {	
				$name =  $title;
				$checkbox = "<span class='icon lock'></lock>";
					
				$status ="<span class='invisible'>$enable</span>
				<div class='switch s-icon activator help'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-check-circle'></i></span></label>
					<input type='hidden' value='$aRow[id]' class='number invisible'>
					<input type='hidden' value='$aRow[status]'  class='type invisible'>
				</div>";
				
				$featured ="
				<div class='switch s-icon featured help'><span class='invisible'>$featured</span>
					<label class='cb-enable $fp1 tips' data-placement='left' title='".Unfeatured."'><span>
					<i class='icon-star'></i>
					</span></label>
					<label class='cb-disable $fp2 tips' data-placement='left' title='".Featured."'><span>
					<i class='icon-star'></i></span></label>
					<input type='hidden' value='$aRow[id]'  class='number invisible'>
					<input type='hidden' value='$aRow[featured]' class='type invisible'>
				</div>";
									
			}					
			if ( $i == 0 )
			{			
				if(!isset($_GET['param']))
				$row[] = $checkbox; 
			}				
			else if ( $i == 1 )
			{	
				if(!isset($_GET['param']))
					$row[] = $name;
				else
					$row[] ="<a class='tips select' rel='$aRow[id]' title='".Choose."' href='#' target='_self' redata-placement='right'>$title</a>";	
				
			}			
			else if ( $i == 2 )
			{			
				if(!isset($_GET['param']))
				$row[] = "<div class='switch-group'>$featured$status</div>";
			}	
			else if ( $i == 3 )
			{			
				$sql2 = $db->select(FDBPrefix."article_category","name","id=$aRow[category]"); 
				$category = $sql2[0];
				$category = $category['name'];
				$row[] = "<div class='center'>$category</div>";
			}
			else if ( $i == 4 )
			{			
				
				$aut = userInfo('name',$aRow['author_id']); 
				$author = $aut;
				if(!empty($aRow['author']))
					$author = $aRow['author'];					
				else if(empty($author))
					$author="<span title='Original by Anonymous' class='tips'>Anonymous</span>";
				else
					$author="<span title='Original by $aut' class='tips'>$author</span>";
				$row[] = "<div class='center'>$author</div>";
			}
			else if ( $i == 5 )
			{		
				//creat user group values			
				if($aRow['level']==99) {$level = _Public;
				} 
				else {
					$lvl = $db->select(FDBPrefix.'user_group','*',"level='$aRow[level]'"); 
					$level = $lvl[0];	
					$level = $level['group_name'];	
				} 	
				
				$row[] = "<div class='center'>$level</div>";
			}
			else if ( $i == 6 )
			{		
				$row[] = "<div class='center'>$aRow[date]</div>";
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>