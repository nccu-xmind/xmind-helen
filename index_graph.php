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
				<label>Application Category: </label><select name="category">
					<option value="Arcade" selected ="selected">Arcade & Action</option>
					<option value="Book">Books & Reference</option>
					<option value="Puzzle">Brain & Puzzle</option>
					<option value="Business">Business</option>
					<option value="Casual">Casual</option>
					<option value="Communication">Communication</option>
					<option value="Education">Education</option>
					<option value="Entertainment">Entertainment</option>
					<option value="Health">Health & Fitness</option>
					<option value="Lifestyle">Lifestyle</option>
					<option value="Media">Media & Video</option>
					<option value="Music">Music & Audio</option>
					<option value="News">News & Magazines</option>
					<option value="Photography">Photography</option>
					<option value="Productivity">Productivity</option>
					<option value="Racing">Racing</option>
					<option value="Shopping">Shopping</option>
					<option value="Social">Social</option>
					<option value="Tool">Tool</option>
					<option value="Transportation">Transportation</option>
					<option value="Weather">Weather</option>
				</select>
				<br/>
				<label>User: </label><select name="user_id">
					<option value="USER_008" selected ="selected">USER_008</option>
					<option value="USER_049">USER_049</option>
					<option value="USER_022">USER_022</option>
					<option value="USER_050">USER_050</option>
					<option value="USER_010">USER_010</option>
					<option value="USER_047">USER_047</option>
					<option value="USER_003">USER_003</option>
					<option value="USER_042">USER_042</option>
					<option value="USER_011">USER_011</option>
					<option value="USER_051">USER_051</option>
					<option value="USER_045">USER_045</option>
					<option value="USER_032">USER_032</option>
					<option value="USER_036">USER_036</option>
					<option value="USER_044">USER_044</option>
					<option value="USER_037">USER_037</option>
					<option value="USER_031">USER_031</option>
					<option value="USER_048">USER_048</option>
					<option value="USER_046">USER_046</option>
					<option value="USER_079">USER_079</option>
					<option value="USER_039">USER_039</option>
					<option value="USER_080">USER_080</option>
					<option value="USER_052">USER_052</option>
					<option value="USER_053">USER_053</option>
					<option value="USER_054">USER_054</option>
					<option value="USER_055">USER_055</option>
					<option value="USER_056">USER_056</option>
					<option value="USER_059">USER_059</option>
					<option value="USER_060">USER_060</option>
					<option value="USER_057">USER_057</option>
					<option value="USER_058">USER_058</option>
					<option value="USER_061">USER_061</option>
					<option value="USER_062">USER_062</option>
					<option value="USER_063">USER_063</option>
					<option value="USER_064">USER_064</option>
					<option value="USER_065">USER_065</option>
					<option value="USER_067">USER_067</option>
					<option value="USER_068">USER_068</option>
					<option value="USER_069">USER_069</option>
					<option value="USER_070">USER_070</option>
					<option value="USER_071">USER_071</option>
					<option value="USER_072">USER_072</option>
					<option value="USER_073">USER_073</option>
					<option value="USER_074">USER_074</option>
					<option value="USER_075">USER_075</option>
					<option value="USER_076">USER_076</option>
					<option value="USER_077">USER_077</option>
					<option value="USER_078">USER_078</option>
					<option value="USER_081">USER_081</option>
					<option value="USER_082">USER_082</option>
					<option value="USER_083">USER_083</option>
					<option value="USER_090">USER_090</option>
					<option value="USER_084">USER_084</option>
					<option value="USER_085">USER_085</option>
					<option value="USER_086">USER_086</option>
					<option value="USER_087">USER_087</option>
					<option value="USER_088">USER_088</option>
					<option value="USER_089">USER_089</option>
					<option value="USER_091">USER_091</option>
					<option value="USER_092">USER_092</option>
					<option value="USER_093">USER_093</option>
					<option value="USER_094">USER_094</option>
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
			</ul>
		</p>
	</body>
</html>

