<?php
/**
* @version		v.1.4.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/


defined('_FINDEX_') or die('Access Denied');

	$url = str_replace('?feed=rss','',getUrl());
	echo '<?xml version="1.0" encoding="UTF-8"?>	
	<?xml-stylesheet title="XSL_formatting" type="text/xsl" href="/shared/bsp/xsl/rss/nolsol.xsl"?>
	<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/"  xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
	 <![CDATA[<atom:link href="'.getUrl().'" rel="self" type="application/rss+xml" />]]>
		<title>'.$category[0].'</title>
		<description><![CDATA['.strip_tags($article-> catDesc).']]></description>
		<link><![CDATA['.$url.']]></link>
		<lastBuildDate>'.date('D, d M Y h:m:s',time()).'</lastBuildDate>
		<generator>Fiyo CMS Integrate Design Easily</generator>
		<language>en-gb</language>';
		for($i=0; $i <= $perrows ;$i++)
	{
	
	$img ='';
	$opentag = strpos($text[$i],"<img");
	if($opentag) {
		$closetag = substr($text[$i],$opentag);
		$closetag = strpos($closetag,">");
		$image = substr($text[$i],$opentag,$opentag+$closetag);
		$a = strpos($image,'src="');
		if(empty($a)) $a = strpos($image,"src='");
			$b = substr($image,$a+5);					
			$c = strpos($b,'"');
		if(empty($c))$c = strpos($b,"'");
			$img =  substr($image,$a+5,$c);					
	}
	$img = str_replace("/files","/files/.thumbs",$img);
	$desc[$i]	= cutWords($desc[$i],20);
				
echo '
	<item>
			<title>'.strip_tags($title[$i]).'</title>
			<link><![CDATA['.$link[$i].']]></link>
			<guid><![CDATA['.$link[$i].']]></guid>
			<description><![CDATA['.$desc[$i].']]></description>
			<category>'.$category[0].'</category>
			<pubDate>'.$time[$i].'</pubDate>
			<media:thumbnail width="66" height="49" url="'.FUrl.$img.'"/>  
			<media:thumbnail width="144" height="81" url="'.FUrl.$img.'"/>
	</item>';
	}
echo '</channel>
</rss>';