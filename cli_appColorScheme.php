<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './inc/setup.inc.php';

require_once _APP_PATH . 'resources/RandomColor.php';
require_once _APP_PATH . 'classes/myPDOConn.Class.php';
require_once _APP_PATH . 'classes/XMindAnalysis.Class.php';

use Colors\RandomColor;
use ninthday\niceToolbar\myPDOConn;
use ninthday\xmind\XMindAnalysis;

$pdoConn = myPDOConn::getInstance('myPDOConnConfig.inc.php');
$obj_xmind = new XMindAnalysis($pdoConn);

$ary_typecate = $obj_xmind->getAppTypeCate();
foreach ($ary_typecate as $row) {
    $package_ids = $obj_xmind->getPackageIDByTypeCate($row[0], $row[1]);
    $color_num = count($package_ids);
    $ary_colors = RandomColor::many($color_num);
    $obj_xmind->setAppColorScheme($package_ids, $ary_colors);
    unset($package_ids);
    unset($ary_colors);
    echo 'Type: ' . $row[0] . ', Category: ' . $row[1] . PHP_EOL;
}


//print_r($ary_colors);