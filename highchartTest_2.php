<?php

	include_once 'MobileSNS_config_db.php';
	$category=$_POST["category"];
	$user=$_POST["user_id"];
	$time_int=$_POST["time_int"];
	$last_time="2009-01";
	
	
		$sql="SELECT FROM_UNIXTIME(`Time_Stamp`,'".$time_int."') AS 'MyTime',CAST(FROM_UNIXTIME(`Time_Stamp`,'%Y') AS CHAR) AS 'MyYear',CAST(FROM_UNIXTIME(`Time_Stamp`,'%m') AS CHAR) AS 'MyMonth',CAST(FROM_UNIXTIME(`Time_Stamp`,'%d') AS CHAR) AS 'MyDay',COUNT(*) AS 'Counts',`title` AS 'App_Name'
FROM activitylogs JOIN info_pkg JOIN info_user ON CAST(`Name_App` AS CHAR) = `pkgName` AND CAST(`gaccount` AS CHAR)= CAST(`ID_User` AS CHAR)
WHERE   `category` LIKE \"$category\" AND info_user.`id`= $user 
GROUP BY `MyTime`, `Name_App`
HAVING `MyTime`>\"$last_time\"";

//$sql2="SELECT  COUNT(*) AS 'Counts',`category` AS 'App_Category'
//FROM activitylogs JOIN info_pkg JOIN info_user ON CAST(`Name_App` AS CHAR) = `pkgName` AND CAST(`gaccount` AS CHAR)= CAST(`ID_User` AS CHAR)
//WHERE  info_user.`id`= $user 
//GROUP BY `App_Category`"

if($time_int=="%Y-%m"){
	$highchart_time="%Y-%b";
}
else{
	$highchart_time="%Y-%b-%e";
}

	
	
 $result =mysql_query($sql) or trigger_error(mysql_error()."<br>SQL error>");
 
 //$result2 =mysql_query($sql2) or trigger_error(mysql_error()."<br>SQL error>");
$testint=0;
	while ($row = mysql_fetch_array ($result)) {

     //       	$people[] = $row["ID_Machine"];
     $date[] = $row["MyTime"];
     $counts[] = $row["Counts"];
     $app_name[] = $row["App_Name"];
     $year[] = $row["MyYear"];
     $month[]=$row["MyMonth"]-1;
     $day[]=$row["MyDay"];
   }
   $length = count($date);
   
  // while ($row2 = mysql_fetch_array ($result2)) {

   
  //   $app_counts[] = $row2["Counts"];
 //    $app_cat[] = $row2["App_Category"];
 //  }
   
  $uni_app=array_unique($app_name);
  $app_num = count($uni_app);
  

   mysql_free_result ($result);
   //mysql_free_result ($result2);


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
var mchart;

$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'spline',
			zoomType: 'x'
		},
		title: {
			text: 'Comparison of Application Usage'
		},
		subtitle: {
			text: 'Click and drag a certain area along the X axis in order to zoom into a particular time period.'
		},
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: { // don't display the dummy year
				month: '%Y-%b',
				year: '%Y'
			}
		},
		yAxis: {
			title: {
				text: 'Userlog Numbers'
			},
			min: 0
		},
		tooltip: {
			formatter: function() {
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('".$highchart_time."', this.x) +': '+ this.y ;
			}
		},series: [";
		$cur = 0;
		for($t=0; $t<$app_num; $t++){
			if($t!=0){
				echo ",";
			}
			while($uni_app[$cur]==""){
				$cur=$cur+1;
			}
			echo "{
				name: '".$uni_app[$cur]."',
				data: [";
				$flag=1;
					for ($i=0;$i<$length; $i++){
						
						if($app_name[$i]==$uni_app[$cur]){
							if($flag==0){
								echo ",";
							}
							$flag=0;
							if($time_int=="%Y-%m"){
								echo "[Date.UTC(".$year[$i].",".$month[$i].", 1),".$counts[$i]."]";
							}
							else{
								echo "[Date.UTC(".$year[$i].",".$month[$i].",".$day[$i]."),".$counts[$i]."]";
							}
							//echo "'a'";
							
						}
					}
					$flag=1;
				echo "]
			}";
			$cur++;
		}
		
		echo "]
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



