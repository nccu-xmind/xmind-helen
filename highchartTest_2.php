<?php
include_once 'MobileSNS_config_db.php';
$category = $_POST["category"];
$user = $_POST["user_id"];
$time_int = $_POST["time_int"];
$last_time = "2009-01";

$sql = "SELECT FROM_UNIXTIME(`Time_Stamp`,'" . $time_int . "') AS 'MyTime',CAST(FROM_UNIXTIME(`Time_Stamp`,'%Y') AS CHAR) AS 'MyYear',CAST(FROM_UNIXTIME(`Time_Stamp`,'%m') AS CHAR) AS 'MyMonth',CAST(FROM_UNIXTIME(`Time_Stamp`,'%d') AS CHAR) AS 'MyDay',COUNT(*) AS 'Counts',`appname` AS 'App_Name', `color_scheme`
FROM `activitylogs` JOIN `info_pkg` ON `Name_App` = `pkgName`
WHERE   `category` LIKE \"$category\" AND activitylogs.`ID_User`= \"$user\"
GROUP BY `MyTime`, `Name_App`
HAVING `MyTime`>\"$last_time\"";

//$sql = "SELECT FROM_UNIXTIME(`Time_Stamp`,'" . $time_int . "') AS 'MyTime',CAST(FROM_UNIXTIME(`Time_Stamp`,'%Y') AS CHAR) AS 'MyYear',CAST(FROM_UNIXTIME(`Time_Stamp`,'%m') AS CHAR) AS 'MyMonth',CAST(FROM_UNIXTIME(`Time_Stamp`,'%d') AS CHAR) AS 'MyDay',COUNT(*) AS 'Counts',`title` AS 'App_Name'
//FROM activitylogs JOIN info_pkg JOIN info_user ON CAST(`Name_App` AS CHAR) = `pkgName` AND CAST(`gaccount` AS CHAR)= CAST(`ID_User` AS CHAR)
//WHERE   `category` LIKE \"$category\" AND info_user.`id`= $user 
//GROUP BY `MyTime`, `Name_App`
//HAVING `MyTime`>\"$last_time\"";
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

//$result2 =mysql_query($sql2) or trigger_error(mysql_error()."<br>SQL error>");
$testint = 0;
while ($row = mysql_fetch_array($result)) {

    //       	$people[] = $row["ID_Machine"];
    $date[] = $row["MyTime"];
    $counts[] = $row["Counts"];
    $app_name[] = $row["App_Name"];
    $year[] = $row["MyYear"];
    $month[] = $row["MyMonth"] - 1;
    $day[] = $row["MyDay"];
    $color[] = $row["color_scheme"];
}
$length = count($date);

// while ($row2 = mysql_fetch_array ($result2)) {
//   $app_counts[] = $row2["Counts"];
//    $app_cat[] = $row2["App_Category"];
//  }

$uni_app = array_unique($app_name);
$app_num = count($uni_app);


mysql_free_result($result);
//mysql_free_result ($result2);
?>
<html lang="zh-Hant-TW">
    <head>

        <title>Highcharts for X-Mind (Demo)</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
                Highcharts.dateFormat('" . $highchart_time . "', this.x) +': '+ this.y ;
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function () {
                            getAppdata(this.category, this.series.name, this.y);
                        }
                    }
                }
            }
        },
        series: [";
        $cur = 0;
        for ($t = 0; $t < $app_num; $t++) {
            if ($t != 0) {
                echo ",";
            }
            while ($uni_app[$cur] == "") {
                $cur = $cur + 1;
            }
            echo "{
                    name: '" . $uni_app[$cur] . "',
                    color: '" . $color[$cur] . "',
                    data: [";
            $flag = 1;
            for ($i = 0; $i < $length; $i++) {

                if ($app_name[$i] == $uni_app[$cur]) {
                    if ($flag == 0) {
                        echo ",";
                    }
                    $flag = 0;
                    if ($time_int == "%Y-%m") {
                        echo "[Date.UTC(" . $year[$i] . "," . $month[$i] . ", 1)," . $counts[$i] . "]";
                    } else {
                        echo "[Date.UTC(" . $year[$i] . "," . $month[$i] . "," . $day[$i] . ")," . $counts[$i] . "]";
                    }
                    //echo "'a'";
                }
            }
            $flag = 1;
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <script src="http://code.highcharts.com/highcharts.js"></script>
                    <script src="http://code.highcharts.com/modules/exporting.js"></script>
                    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
                            <?php
                            if ($length == 0) {
                                echo "<p>Sorry, this user does not use \"" . $category . "\" type of applications.</p>";
                                echo "<p>Please <a href=\"http://mobilesns.cs.nccu.edu.tw/helen/index_graph.php\">go back</a> and try another category</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">User: <strong><?php echo $user; ?></strong> Application Logs (Click Graph Point to show)</div>
                        <div class="panel-body">
                            <table id="userapp" class="table">
                                <thead>
                                    <tr>
                                        <th>USER_ID</th>
                                        <th>Time</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var user = "<?php echo $user; ?>";
            var oTable;
            function getAppdata(datetime, appname, appcount) {
                $.ajaxSetup({
                    cache: false
                });

                var jqxhr = $.getJSON('ajax_appdata.php', {
                    usr: user,
                    dt: datetime / 1000,
                    an: appname,
                    ac: appcount
                });

                jqxhr.done(function (data) {
                    if (oTable){
                        oTable.fnDestroy();
                    }
                    oTable = $('#userapp').dataTable({
                        "data": data,
                        "columns": [
                            {"data": "userid"},
                            {"data": "usetime"},
                            {"data": "activity"}
                        ]
                    });
                });
            }
            ;
        </script>
    </body>

</html>



