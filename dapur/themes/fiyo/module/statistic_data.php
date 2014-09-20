<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 5) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');
$db = new FQuery();  
$db->connect(); 

if(checkMobile()) {
	$d13 = 6;
	$d14 = 7;
} else {
	$d13 = 13;
	$d14 = 14;
}
$uniqueVisitor = $allVisitor = $newVisitor = $dateList = '';
for($x = $d13; $x >= 0; $x--) {
	$dateList .= "'".date("d M y",strtotime("-$x days"))."'";
	if($x != 0) $dateList .= ",";
}

for($x = $d13; $x >= 0; $x--) {
	$dtf = date('Y-m-d 00:00:00',strtotime("-$x days"));
	$z = $x-1;
	$dts = date('Y-m-d 00:00:00',strtotime("-$z days"));	
	$v = FQuery('statistic',"time BETWEEN '$dtf' AND '$dts'","","","time ASC");
	$v = FQuery('statistic',"time BETWEEN '$dtf' AND '$dts'","","","time ASC");
	if(empty($v))  $allVisitor .= 0; else $allVisitor .= $v;
	if($x != 0) $allVisitor .= ",";
}
$z = 0;
for($x = $d14; $x >= 0; $x--) {
	$ytf = date('Y-m-d 00:00:00',strtotime("-$x days"));
	$t = $x-1;
	$dtf = date('Y-m-d 00:00:00',strtotime("-$t days"));

	$db = new FQuery();  
	$db -> connect();
	$sql = $db->select(FDBPrefix."statistic","*,COUNT(DISTINCT ip) AS q","time < '$dtf'","time ASC");
		
	$row = mysql_fetch_array($sql);
	$unique = $row['q'] - $z; 
	if($unique < 0 ) $unique = 0;
		$z = $row['q'];

	
	if(empty($unique))  
		$uniqueVisitor .= 0; 
	else if($x != $d14)
		$uniqueVisitor .= $unique;
	if($x != 0 AND $x != $d14) $uniqueVisitor .= ",";
}

for($x = $d13; $x >= 0; $x--) {
	$dtz = date('Y-m-d 00:00:00',strtotime("-$x days"));
	$t = $x-1;
	$dtf = date('Y-m-d 00:00:00',strtotime("-$t days"));
	
	$sql = $db->query("select COUNT( DISTINCT ip )  AS q FROM ".FDBPrefix."statistic WHERE time BETWEEN '$dtz' AND '$dtf'");
	$row = mysql_fetch_array($sql);
	if(empty($row['q']))  $newVisitor .= 0; else $newVisitor .= $row['q'];
	if($x != 0) $newVisitor .= ",";
}
$date = date("d-m-Y",strtotime("-$d13 days"));

$D = substr($date,0,2);
$M = substr($date,3,2)-1;
$Y = substr($date,6,4);

?>

<script>
$(function () {		
    var chart;
	var allVisitor = [<?php echo $allVisitor;?>];
	var uniqueVisitor = [<?php echo $uniqueVisitor;?>];
	var reVisitor = [<?php echo $newVisitor;?>];
    $(document).ready(function() {
		function chartStat() {
        chart = new Highcharts.Chart({
			colors: ['#009ae1', '#f85d11', '#15aa00'],
            chart: {
                renderTo: 'statistic',
                 type: 'area',
            },
            title: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
                labels: {
                overflow: 'justify'
                }
            },
            yAxis: {
                title: {
                    text: null
                },
            },
            tooltip: {
                valueSuffix: null,
                shared: true,
            },
            plotOptions: {
                area: {
                    lineWidth: 3,
                    states: {
                        hover: {
                            lineWidth: 3,
                        }
                    },
                    marker: {       
						fillColor: '#FFFFFF',
						lineWidth: 2,						
						radius: 4,
						symbol : 'circle',
						lineColor: null // inherit from series
                    },
                    pointInterval: 3600000*24, // one hour
                    pointStart: Date.UTC( <?php echo $Y;?>,  <?php echo $M;?>, <?php echo $D;?>, 0, 0, 0)
                }
				,series: {
					fillOpacity: 0.05,						
				},
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Hits',
                data: allVisitor
    
            },{
                name: 'Uniqeu Visitor',
                data: reVisitor
            },{
                name: 'New Visitor',
                data: uniqueVisitor
            }]
            ,
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
		}
		
		chartStat();
		
		function chartResize(width, height){		
			var w = $(window).width();
			w = parseInt(w);
			var r = $('rect').width();
			r = parseInt(r);
			if(w >= 980) var c = 220; 
			else if(w > 780) var c = 110; 
			else if(w <= 780) var c = 0; 
			var a = $(".statistic").width();
			var b = $("#statistic").height();
			a = parseInt(a);
			b = parseInt(b);
			chart.setSize(a-c-5,b);
			if($('.hide-sidebar').length && a > 200) {		
				chart.setSize(a+c-5,b);			
			}
			else if(width > 980)
			{
				chart.setSize(a-c-5,b);
			}
			else			
				chart.setSize(a-c-5,b);
		}
		$('.changeSidebarPos').on('click', function(e) {
			chartResize(null, null);
		});
			
		var prevHeight = $(window).height();
		var prevWidth = $(window).width();
		$(window).resize(function() {
			chartResize(prevWidth, prevHeight);
			prevWidth = $(window).width();
		});

    }); 
    
});
</script>