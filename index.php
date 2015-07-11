<?php
require './inc/setup.inc.php';

require_once _APP_PATH . 'classes/myPDOConn.Class.php';
require_once _APP_PATH . 'classes/XMindAnalysis.Class.php';

$pdoConn = \ninthday\niceToolbar\myPDOConn::getInstance('myPDOConnConfig.inc.php');

try {
    $obj_xmind = new ninthday\xmind\XMindAnalysis($pdoConn);
    $ary_catelist = $obj_xmind->getAppCateList();
    $ary_userlist = $obj_xmind->getEncodeUserList();
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>X-Mind Graphing Tool Demo</title>
        <link href="index_graph.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <h1>X-Mind Graphing Tools Demo</h1>
        <p>Welcome to the X-Mind Graphing Tools Demo. </p>
        <p>Please select the content of the graph you would like to see.</p>
        <p>You can select an application type and a user</p>
        <form action="highchartTest_2.php" method="post">
            <fieldset>
                <legend>Try a Graph!</legend>
                <label>Application Category: </label>
                <select name="category">
                    <option value="" selected ="selected">Please Select</option>
                    <?php
                    foreach ($ary_catelist as $list) {
                        echo '<option value="' . $list . '">' . $list . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <label>User: </label><select name="user_id">
                    <option value="" selected ="selected">Please Select</option>
                    <?php
                    foreach ($ary_userlist as $user) {
                        echo '<option value="' . $user . '">' . $user . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <select name="time_int">
                    <option value="%Y-%m">By Month</option>
                    <option value="%Y-%m-%d">By Day</option>
                </select>
                <br/>
                <input type="submit" />
            </fieldset>
        </form>
        <br/>
        <p><strong>New Functionality!</strong> Now you can check the Facebook activity usage of all users. This is a test function and any feedback is welcome.</p>
        <br/>
        <form action="facebookTest.php" method="post">
            <fieldset>
                <legend>Facebook Activity Test</legend>
                <label>Choose Activity to Monitor: </label><select name="activity">
                    <option value=".UploadPhotoActivity">Upload Photos</option>
                    <option value=".ComposerActivity">Post on Wall</option>
                    <option value=".FeedComposerActivity">Reply</option>
                    <option value=".activity.media.ViewPhotoActivity">View Photos</option>
                    <option value=".ShareLinkActivity">Sharing</option>
                    <option value=".activity.messages.MessageComposeActivity">Sending Message</option>
                </select>
                <br/>
                <select name="time_int">
                    <option value="%Y-%m">By Month</option>
                    <option value="%Y-%m-%d">By Day</option>
                </select>
                <br/>
                <input type="submit" />
            </fieldset>
        </form>
        <p>Revisions:
            <ul>
                <li>2015-07-11: Graph Tools back to HighChart (@JeffyShih)</li>
                <li>2015-07-01: Category & User List, Get from Database (@JeffyShih)</li>
                <li>2013-07-07: New Users Added, User ID Update</li>
                <li>2013-07-07: Graph Tools is now using NVD3</li>
                <li>2013-01-14: Added Facebook Monitor and More Users</li>
                <li>2012-07-08: Added Time Range Selection</li>
                <li>2012-06-12: First Version</li>
            </ul>
        </p>
    </body>
</html>