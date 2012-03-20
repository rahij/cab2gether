<?php
	include("db_info.php");
	$username = $_POST["username"];
	$hpno = $_POST["hpno"];
	$orig = $_POST["orig"];
	$dest = $_POST["dest"];
	$timeval = $_POST["timeval"];
	
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
	
	$maxid=mysql_query("SELECT max(rowid) FROM rides");
	$maxid2=mysql_fetch_row($maxid);
	$nextid=$maxid2[0] + 1;
	
	
	echo "<!DOCTYPE html>
<head>
	<title>New Journey</title>
	<link rel='stylesheet' type='text/css' href='./details_with_join.css' />
</head>
<body>
<table width='320' border='0'>
<tr>
<td style='background-color:#FFA500;text-align:center;'>";
	
	$success=mysql_query("INSERT INTO rides VALUES ('$orig', '$dest', '$timeval', '$username', '$hpno', $nextid, NULL, NULL, NULL, NULL, NULL, NULL, 0)");

	if($success){
		echo "<p id='main_text'>Journey created!</p>";
	}
	else{
		echo "<p id='main_text'>Error!</p>";
	}
	
	echo "</td>
</tr>
</table>
</body>
</html>";
	
?>
