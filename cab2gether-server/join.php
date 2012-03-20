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
	<title>Take the Ride!</title>
	<link rel='stylesheet' type='text/css' href='./details_with_join.css' />
</head>
<body>
<table width='320' border='0'>
<tr>
<td style='background-color:#FFA500;text-align:center;'>";
	
	$query_result=mysql_query("SELECT * FROM rides WHERE rowid='$key'");
	
	$current_item = mysql_fetch_object($query_result);
	
	$currentnopax = $current_item->nopax;
	
	if($currentnopax >= 3){
		echo "<p>That ride is fully occupied!</p>";
	}
	else{
		$thingy1 = "passengerx";
		$thingy2 = "passengerxhpno";
		$thingy1[9] = $currentnopax + 1;
		$thingy2[9] = $currentnopax + 1;
		$nextpax=$currentnopax+1;
		$success=mysql_query("UPDATE rides SET $thingy1='$username', $thingy2='$hpno', nopax=$nextpax WHERE rowid=$key");
		if($success)
			echo "<p>Journey Joined!</p>";
		else
			echo "<p>Error!</p>";
	}
