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
        <title>X-Mind Graphing Tool Demo</title>
        <link href="index_graph.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <h1>X-Mind Graphing Tools Demo</h1>
        <p>Welcome to the X-Mind Graphing Tools Demo. </p>
        <p>Please select the content of the graph you would like to see.</p>
        <p>You can select an application type and a user</p>
        <form action="nvd3_test.php" method="post">
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
        <p><strong>New Look!</strong> The above graph tools now uses the NVD3 library, which provides many promises (and challenges) for future graph tools.</p>
        <p>Feel free to revert to the <a href="index_graph_20130707.php">previous highcharts version</a> for comparisons and feedback.</p>

        <p><strong>New Users!</strong> New User data is now available</p>
        <p><strong>User IDs now Match!</strong> The User IDs in the user list now match the ID in the database</p>
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
                <li>First Version: 2012-6-12</li>
                <li>Added Time Range Selection: 2012-7-8</li>
                <li>Added Facebook Monitor and More Users: 2013-1-14</li>
                <li>Graph Tools is now using NVD3: 2013-07-07</li>
                <li>New Users Added, User ID Update: 2013-07-07</li>
                <li>Category & User List, Get from Database (@JeffyShih): 2015-07-01</li>
            </ul>
        </p>
    </body>
</html>
<?php
unset($pdoConn);
?>