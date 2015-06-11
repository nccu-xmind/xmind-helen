<?php

	include_once 'MobileSNS_config_db.php';
	$category=$_POST["category"];
	$user=$_POST["user_id"];
	$last_time="2009-01";
	
	//$sql="select ID_Machine from $db.android_category group by ID_Machine ";
	if($category!=""){
		$sql="SELECT FROM_UNIXTIME(`Time_Stamp`,'%Y-%m') AS 'MyTime',CAST(FROM_UNIXTIME(`Time_Stamp`,'%Y-%m') AS CHAR) AS 'MyDate',COUNT(*) AS 'Counts'
FROM activitylogs JOIN info_pkg JOIN info_user ON CAST(`Name_App` AS CHAR) = `pkgName` AND CAST(`gaccount` AS CHAR)= CAST(`ID_User` AS CHAR)
WHERE   `category` LIKE \"%$category%\" AND info_user.`id`= $user
GROUP BY `MyTime`
HAVING `MyTime`>\"$last_time\"";
	}
	else{
	$sql="SELECT FROM_UNIXTIME(`Time_Stamp`,'%Y-%m') AS 'MyTime',CAST(FROM_UNIXTIME(`Time_Stamp`,'%Y-%m') AS CHAR) AS 'MyDate',COUNT(*) AS 'Counts'
FROM activitylogs JOIN info_user ON CAST(`gaccount` AS CHAR)= CAST(`ID_User` AS CHAR)
WHERE  info_user.`id`= $user GROUP BY `MyTime` HAVING `MyTime`>\"$last_time\"";
	}
 $result =mysql_query($sql) or trigger_error(mysql_error()."<br>SQL error>");
 //$person = mysql_fetch_array ($result);
$testint=0;
	while ($row = mysql_fetch_array ($result)) {

     //       	$people[] = $row["ID_Machine"];
     $date[] = $row["MyDate"];
     $counts[] = $row["Counts"];
   }
   $length = count($date);
  
  

   mysql_free_result ($result);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">



<html debug="true">

<head>

<title>Highcharts for X-Mind (Demo)</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/favicon.ico"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<?php 
echo '<script type="text/javascript">';
echo "(function($){ // encapsulate jQuery



var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'line',
			marginRight: 130,
			marginBottom: 25
		},
		title: {
			text: 'User Graph Test',
			x: -20 //center
		},
		subtitle: {
			text: 'Source: MobileSNS',
			x: -20
		},
		xAxis: {
			categories: [";

for ($i=0;$i<$length; $i++){
	if($i==0){
		echo "'".$date[$i]."'";
	//echo "'a'";
	}
	else echo ",'".$date[$i]."'";
	//else echo ",'a'";
}
echo "]
		},
		yAxis: {
			title: {
				text: 'Usage (Amount)'
			},
			plotLines: [{
				value: 0,
				width: 1,
				color: '#808080'
			}]
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					this.x +': '+ this.y;
			}
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'top',
			x: -10,
			y: 100,
			borderWidth: 0
		},
		series: [{
			name: '".$category."',
			data: [";
for ($j=0;$j<$length; $j++){
	if($j==0){
	echo $counts[$j];
	//echo "1";
	}
	else echo ",".$counts[$j];
	//else echo ",1";
}
echo "]
		}]
	});
});


})(jQuery);";
    echo "</script>";
?>


</head>

<body>

	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/modules/exporting.js"></script>
	<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	<?php
	if($length==0){
		echo "<p>Sorry, this user does not use \"".$category."\" type of applications.</p>";
		echo "<p>Please <a href=\"http://mobilesns.cs.nccu.edu.tw/helen/index_graph.php\">go back</a> and try another category</p>";
	}
	?>
</body>

</html>



