<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

session_start();
if(@$_SESSION['USER_LEVEL'] > 5 or !isset($_GET['iSortCol_0'])) die ('Access Denied!');
define('_FINDEX_',1);
require('../../../system/jscore.php');
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array( 'id', 'name', 'status', 'comment',  'link', 'date', 'email' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "date";
	
	/* DB table to use */
	$sTable = FDBPrefix."comment";
	
	/* Database connection information */
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
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
	$sOrder = "ORDER BY date DESC";
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
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
	$rResult = mysql_query( $sQuery) or die(mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval(@$_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
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
					
				$name = "$aRow[name]";
				$name = "<span class='tips' title='$aRow[email]' data-placement='right'>$name</span>";	
					
				$status ="<span class='invisible'>$enable</span>
				<div class='switch s-icon activator'>
					<label class='cb-enable $stat1 tips' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable $stat2 tips' data-placement='right' title='".Enable."'><span>
					<i class='icon-ok-sign'></i></span></label>
					<input type='hidden' value='$aRow[id]' class='number invisible'>
					<input type='hidden' value='$aRow[status]'  class='type invisible'>
				</div>";
							
							
			if ( $i == 0 )
			{			
				$row[] = "<label><input type='checkbox' data-name='rad-$aRow[id]' name='check_comment[]' value='$aRow[id]' rel='ck' ><span class='input-check'></span></label>"; 
			}				
			else if ( $i == 1 )
			{			
				$row[] = $name;
			}			
			else if ( $i == 2 )
			{			
				$row[] = "<div class='center'>$status</div>";
			}	
			else if ( $i == 3 )
			{			
				$comm = htmlentities(htmlToText($aRow['comment']));
				$comm = substr($comm,0,50);
				
				$comm ="<a class='tips' title='".Edit."' href='?app=article&view=comment&act=edit&id=$aRow[id]'>$comm ...</a>";
				$row[] = "$comm";
			}
			else if ( $i == 4 )
			{							
				$title = oneQuery('article','id',link_param('id',$aRow['link']),'title');
				$link = oneQuery('permalink','link',"'$aRow[link]'",'permalink');
				if(!empty($aRow['id'])) $clink = "#comment-$aRow[id]";
				else  $clink = "#comment";
				$title = "<span style='display:none'>$title</span><a href='../$link$clink ' target='_blank' class='outlink'>$title</a> ";
				$row[] = "$title";
			}
			else if ( $i == 5 )
			{			
				$row[] = "<div class='center'>$aRow[date]</div>";
			}
			else if ( $aColumns[$i] != ' ' )
			{
			
			}
		}
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>