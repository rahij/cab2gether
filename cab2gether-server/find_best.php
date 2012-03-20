<?php
	include("db_info.php");
	
	echo "<!DOCTYPE html>
<head>
	<title>Best Matches</title>
	<link rel='stylesheet' type='text/css' href='http://46.137.218.102/cab2gether/find_best.css' />
</head>
<body>
<table width='320' border='0'>
<tr>
<td style='background-color:#FFA500;text-align:center;'>
<p id='heading'>These are the best matches:</p>
</td>
</tr>"; 
	
	$timeval = $_POST["date"] . " " . $_POST["time"];
	$dest=$_POST["dest"];
	$orig=$_POST["stpt"];
	$username=$_POST["username"];
	$hpno=$_POST["hpno"];

	$lefttosearch = 5;
	$lefttoreturn = 5;
	
	//echo "Passed0!";
	
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
	
	
	//echo "Passed2!";
	
	
	$bothmatch_values = mysql_query("SELECT * FROM $table_name WHERE destination = '$dest' AND origin = '$orig' AND dt >= '$timeval' ORDER BY dt LIMIT $lefttosearch");
	$lefttosearch -= mysql_num_rows($bothmatch_values);
	if($lefttosearch>0){
		$destmatches_values = mysql_query("SELECT * FROM $table_name WHERE destination = '$dest' AND origin <> '$orig' AND dt >= '$timeval' ORDER BY dt LIMIT $lefttosearch");
		$lefttosearch -= mysql_num_rows($destmatches_values);
		
	}
	if($lefttosearch>0){
		$origmatches_values = mysql_query("SELECT * FROM $table_name WHERE origin = '$orig' AND destination <> '$dest' AND dt >= '$timeval' ORDER BY dt LIMIT $lefttosearch");
	}
	
	//echo mysql_num_rows($bothmatch_values);	
	//echo "Passed3!";
	
	while ($current_item = mysql_fetch_object($bothmatch_values)){
		$currentname = $current_item->name;
		$currenthpno = $current_item->hpno;
		$currentdest = $current_item->destination;
		$currentorig = $current_item->origin;
		$currenttime = $current_item->dt;
		$currentkey = $current_item->rowid;
		echo "<tr>
<td style='background-color:#FFA500;text-align:center;'>
<form action='http://46.137.218.102/cab2gether/details_with_join.php' method='post'>
<input type='hidden' name='username' value='" . $username . "' />
<input type='hidden' name='hpno' value='" . $hpno . "' />
<input type='hidden' name='key' value='" . $currentkey . "' />
<input type='submit' class='ride_button' value='";
		echo $currentname . " is going from " . $currentorig . " to " . $currentdest . " at " . $currenttime;
		echo "' />
</form>
</td>
</tr>";
	} 
	
	
	//echo "Passed4!";
	
	
	$lefttoreturn -= mysql_num_rows($bothmatch_values);
	
	if($lefttoreturn > 0){
		while ($current_item = mysql_fetch_object($destmatches_values)){
			$currentname = $current_item->name;
			$currenthpno = $current_item->hpno;
			$currentdest = $current_item->destination;
			$currentorig = $current_item->origin;
			$currenttime = $current_item->dt;
			$currentkey = $current_item->rowid;
			echo "<tr>
<td style='background-color:#FFA500;text-align:center;'>
<form action='http://46.137.218.102/cab2gether/details_with_join.php' method='post'>
<input type='hidden' name='username' value='" . $username . "' />
<input type='hidden' name='hpno' value='" . $hpno . "' />
<input type='hidden' name='key' value='" . $currentkey . "' />
<input type='submit' class='ride_button' value='";
			echo $currentname . " is going from " . $currentorig . " to " . $currentdest . " at " . $currenttime;
			echo "' />
</form>
</td>
</tr>";
		}
		$lefttoreturn -= mysql_num_rows($destmatches_values);
	}
	
	if($lefttoreturn > 0){
		while ($current_item = mysql_fetch_object($origmatches_values)){
			$currentname = $current_item->name;
			$currenthpno = $current_item->hpno;
			$currentdest = $current_item->destination;
			$currentorig = $current_item->origin;
			$currenttime = $current_item->dt;
			$currentkey = $current_item->rowid;
			echo "<tr>
<td style='background-color:#FFA500;text-align:center;'>
<form action='http://46.137.218.102/cab2gether/details_with_join.php' method='post'>
<input type='hidden' name='username' value='" . $username . "' />
<input type='hidden' name='hpno' value='" . $hpno . "' />
<input type='hidden' name='key' value='" . $currentkey . "' />
<input type='submit' class='ride_button' value='";
			echo $currentname . " is going from " . $currentorig . " to " . $currentdest . " at " . $currenttime;
			echo "' />
</form>
</td>
</tr>";
		}
	}
	echo "<tr>
<td style='background-color:#FFA500;text-align:center;'>
<form action='http://46.137.218.102/cab2gether/create_new_journey.php' method='post'>
<input type='hidden' name='username' value='" . $username . "' />
<input type='hidden' name='hpno' value='" . $hpno . "' />
<input type='hidden' name='orig' value='" . $orig . "' />
<input type='hidden' name='dest' value='" . $dest . "' />
<input type='hidden' name='timeval' value='" . $timeval . "' />
<input type='submit' id='create_new_button' value='Or, create a new journey' />
</form>
</td>
</tr>
</table>
</body>
</html>";
?>
