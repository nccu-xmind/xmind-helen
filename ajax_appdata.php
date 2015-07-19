<?php

/* 
 * 產生某位使用者在某個時間點，對於某個應用程式的使用記錄
 * 
 * @author ninthday <bee.me@ninthday.info>
 */

require './inc/setup.inc.php';

require_once _APP_PATH . 'classes/myPDOConn.Class.php';
require_once _APP_PATH . 'classes/XMindAnalysis.Class.php';

use ninthday\niceToolbar\myPDOConn;
use ninthday\xmind\XMindAnalysis;

$user_id = filter_input(INPUT_GET, 'usr', FILTER_SANITIZE_STRING);
$use_datetime = filter_input(INPUT_GET, 'dt', FILTER_SANITIZE_STRING);
$app_name = filter_input(INPUT_GET, 'an', FILTER_SANITIZE_STRING);
$app_count = filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING);

$pdoConn = myPDOConn::getInstance('myPDOConnConfig.inc.php');
$obj_xmind = new XMindAnalysis($pdoConn);

$use_time = date('Y-m', $use_datetime);

$log = $obj_xmind->getLogByUserTimeApp($user_id, $use_time, $app_name);
echo json_encode($log);