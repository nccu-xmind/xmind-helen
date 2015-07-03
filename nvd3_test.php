<?php
include_once 'MobileSNS_config_db.php';
$category = $_POST["category"];
$user = $_POST["user_id"];
$time_int = $_POST["time_int"];
$last_time = "2009-01";

$check_count_sql = "SELECT `id` FROM `activitylogs` WHERE `ID_User` = '" . $user . "'";
$check_count_result = mysql_query($check_count_sql);
$check_count_num_rows = mysql_num_rows($check_count_result);

if ($check_count_num_rows < 1) {
    $modify_userid_sql = "SELECT `gaccount` FROM `info_user` WHERE `encode` = '" . $user . "'";
    $modify_userid_result = mysql_query($modify_userid_sql);
    $modify_userid_array = mysql_fetch_array($modify_userid_result);
    $user = $modify_userid_array['gaccount'];
}

$sql = "SELECT FROM_UNIXTIME(`Time_Stamp`,'" . $time_int . "') AS 'MyTime',CAST(FROM_UNIXTIME(`Time_Stamp`,'%Y') AS CHAR) AS 'MyYear',CAST(FROM_UNIXTIME(`Time_Stamp`,'%m') AS CHAR) AS 'MyMonth',CAST(FROM_UNIXTIME(`Time_Stamp`,'%d') AS CHAR) AS 'MyDay',COUNT(*) AS 'Counts',`appname` AS 'App_Name'
FROM `activitylogs` JOIN `info_pkg` ON `Name_App` = `pkgName`
WHERE   `category` LIKE \"$category\" AND activitylogs.`ID_User`= \"$user\"
GROUP BY `MyTime`, `Name_App`
HAVING `MyTime`>\"$last_time\"";

echo $sql;
//$sql2="SELECT  COUNT(*) AS 'Counts',`category` AS 'App_Category'
//FROM activitylogs JOIN info_pkg JOIN info_user ON CAST(`Name_App` AS CHAR) = `pkgName` AND CAST(`gaccount` AS CHAR)= CAST(`ID_User` AS CHAR)
//WHERE  info_user.`id`= $user
//GROUP BY `App_Category`"

if ($time_int == "%Y-%m") {
    $highchart_time = "%Y-%b";
} else {
    $highchart_time = "%Y-%b-%e";
}

$result = mysql_query($sql) or trigger_error(mysql_error() . "<br>SQL error>");

$testint = 0;
while ($row = mysql_fetch_array($result)) {

    //       	$people[] = $row["ID_Machine"];
    $date[] = $row["MyTime"];
    $counts[] = $row["Counts"];
    $app_name[] = $row["App_Name"];
    $year[] = $row["MyYear"];
    $month[] = $row["MyMonth"] - 1;
    $day[] = $row["MyDay"];
}
$length = count($date);


$uni_app = array_unique($app_name);
$app_num = count($uni_app);


mysql_free_result($result);
mysql_free_result($term);
//mysql_free_result ($result2);
?>

<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>NVD3.js ::  Line Plus Bar Chart</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="http://nvd3.org/assets/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <link href="http://nvd3.org/assets/css/common.css" rel="stylesheet">
        <link href="//cdnjs.cloudflare.com/ajax/libs/nvd3/1.1.15-beta/nv.d3.css" rel="stylesheet">
        <link href="http://nvd3.org/assets/css/syntax.css" rel="stylesheet">

        <script src="http://nvd3.org/assets/lib/d3.v2.js"></script>
        <script src="http://nvd3.org/assets/lib/fisheye.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/nvd3/1.1.15-beta/nv.d3.js"></script>
        <script src="http://nvd3.org/assets/js/data/stream_layers.js"></script>
    </head>

    <body>

        <div id="chart">
            <svg style="height:500px"></svg>
        </div>

        <script>
<?php
echo "nv.addGraph(function() {
              var testdata = log();
         var chart = nv.models.lineWithFocusChart()
                 .margin({top: 30, right: 60, bottom: 50, left: 70})
                 .x(function(d,i) { return i });

         chart.xAxis
             .tickFormat(function(d) {
             var dx = testdata[0].values[d] && testdata[0].values[d].x||0;
                 return d3.time.format('" . $highchart_time . "')(new Date(dx))
           });

               chart.x2Axis
             .tickFormat(function(d) {
             var dt = testdata[0].values[d] && testdata[0].values[d].x ||0;
                 return d3.time.format('" . $highchart_time . "')(new Date(dt))
           });

         chart.yAxis
             .tickFormat(d3.format(',.2f'));

         chart.y2Axis
             .tickFormat(d3.format(',.2f'));

         d3.select('#chart svg')
             .datum(log())
           .transition().duration(500)
             .call(chart);

         nv.utils.windowResize(chart.update);

         return chart;
       });


       function log() {

            return [ ";
$cur = 0;
for ($t = 0; $t < $app_num; $t++) {
    if ($t != 0) {
        echo ",";
    }
    while ($uni_app[$cur] == "") {
        $cur = $cur + 1;
    }
    echo "{
                                      key: '" . $uni_app[$cur] . "',
                                      values: [";
    $flag = 1;
    for ($i = 0; $i < $length; $i++) {

        if ($app_name[$i] == $uni_app[$cur]) {
            if ($flag == 0) {
                echo ",";
            }
            $flag = 0;
            if ($time_int == "%Y-%m") {
                echo "[(new Date(" . $year[$i] . "," . ($month[$i]) . ",1))," . $counts[$i] . "]";
            } else {
                echo "[(new Date(" . $year[$i] . "," . ($month[$i]) . "," . $day[$i] . "))," . $counts[$i] . "]";
            }
            //echo "'a'";
        }
    }
    $flag = 1;
    echo "]
                              }";
    $cur++;
}
echo" ].map(function(series) {
           series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
           return series;
         });
       }";
?>
        </script>
    </body></html>

