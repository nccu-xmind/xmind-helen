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
		<form action="highchartTest_2.php" method="post">
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
					<option value="5" selected ="selected">User 5</option>
					<option value="6">User 6</option>
					<option value="7">User 7</option>
					<option value="8">User 8</option>
					<option value="9">User 9</option>
					<option value="10">User 10</option>
					<option value="11">User 11</option>
					<option value="12">User 12</option>
					<option value="13">User 13</option>
					<option value="14">User 14</option>
					<option value="15">User 15</option>
					<option value="16">User 16</option>
					<option value="17">User 17</option>
					<option value="18">User 18</option>
					<option value="19">User 19</option>
					<option value="20">User 20</option>
					<option value="21">User 21</option>
					<option value="22">User 22</option>
					<option value="23">User 23</option>
					<option value="24">User 24</option>
					<option value="25">User 25</option>
					<option value="26">User 26</option>
					<option value="28">User 28</option>
					<option value="29">User 29</option>
					<option value="30">User 30</option>
					<option value="31">User 31</option>
					<option value="32">User 32</option>
					<option value="33">User 33</option>
					<option value="34">User 34</option>
					<option value="35">User 35</option>
					<option value="36">User 36</option>
					<option value="37">User 37</option>
					<option value="38">User 38</option>
					<option value="39">User 39</option>
					<option value="40">User 40</option>
					<option value="41">User 41</option>
					<option value="42">User 42</option>
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
	</body>
</html>