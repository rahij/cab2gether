<!DOCTYPE html>

<body>

<link rel="stylesheet" type="text/css" href="./home_screen.css" />


<table width="320" border="0">

<tr>
<td colspan="2" style="background-color:#FFA500;text-align:center;">
<button id="journeynew" onClick="window.location='new_journey.html'">
New Ride
</button>
</td>
</tr>

<?php
	include("db_info.php");
	$username = $_POST["username"];
	$hpno = $_POST["hpno"];
	
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

	$matching_records = mysql_query("SELECT * FROM rides WHERE name='$username' OR passenger1='$username' OR passenger2='$username' OR passenger3='$username' ORDER BY dt");
	
	if (mysql_num_rows($matching_records) == 0)
		{
		echo "No rides!";
		}

	else{
		while ($current_item = mysql_fetch_object($matching_records)){
		$currentdest = $current_item->destination;
		$currentorig = $current_item->origin;
		$currenttime = $current_item->dt;
		$currentkey = $current_item->rowid;
		echo "<tr>
<td style='background-color:#FFA500;text-align:center;'>
<form action='http://46.137.218.102/cab2gether/details.php' method='post'>
<input type='hidden' name='key' value='" . $currentkey . "' />
<input type='submit' class='ride_button' value='";
		echo $currentorig . " to " . $currentdest . " at " . $currenttime;
		echo "' />
		</td>
		</tr>";
}	}
?>


</table>

</body>
</html>
