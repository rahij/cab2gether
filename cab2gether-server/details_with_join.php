<?php
	include("db_info.php");
	$username = $_POST["username"];
	$hpno = $_POST["hpno"];
	$key = $_POST["key"];
	
	$con = mysql_connect("$connect_host","$connect_user","$connect_password");
	
	//echo $username;
	//echo $hpno;
	
	//echo "Passed0.5!";
	
	if(!$con)
	{
		echo "Unable to connect to mysql";
		die();
	}
	//echo "Passed1!";
	
	$open_db = mysql_select_db("$database_name");
	if (!$open_db)
	{
		echo "Unable to open database";
		die();
	}
	
	echo "<!DOCTYPE html>
<head>
	<title>Journey Details</title>
	<link rel='stylesheet' type='text/css' href='./details_with_join.css' />
</head>
<body>
<table width='320' border='0'>
<tr>
<td style='background-color:#FFA500;text-align:center;'>";
	
	$query_result=mysql_query("SELECT * FROM rides WHERE rowid=$key");
	
	$current_item = mysql_fetch_object($query_result);
	
	$currentname = $current_item->name;
	$currenthpno = $current_item->hpno;
	$currentdest = $current_item->destination;
	$currentorig = $current_item->origin;
	$currenttime = $current_item->dt;
	$currentnopax = $current_item->nopax;
			
	echo "<p>Creator: " . $currentname . "</p>";
	echo "<p>Phone: " . $currenthpno . "</p>";
	echo "<p>Origin: " . $currentorig . "</p>";
	echo "<p>Destination: " . $currentdest . "</p>";
	echo "<p>Departure: " . $currenttime . "</p>";
	$thingy1 = "passengerx";
	$thingy2 = "passengerxhpno";
	for($i = 0; $i < $currentnopax; $i++){
		$thingy1[9] = $i+1;
		$thingy2[9] = $i+1;
		echo "<p>Passenger: " . $current_item->$thingy1 . "</p>";
		echo "<p>Phone: " . $current_item->$thingy2 . "</p>";
	}
	
	echo "<form action='http://46.137.218.102/cab2gether/join.php' method='post'>
	<input type='hidden' name='username' value='" . $username . "'/>
	<input type='hidden' name='hpno' value='" . $hpno . "'/>
	<input type='hidden' name='key' value='" . $key . "'/>
	<input type='submit' id='submit_button' value='Take this ride!' />
	</form>";
	
	
	echo "</td>
</tr>
</table>
</body>
</html>";
?>
