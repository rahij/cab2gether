<html>
<body>

<?php

include("db_login_info.php");
	
	$origin = $_POST['stpt'];
	$destination = $_POST['dest'];	
	$date=$_POST['date'];
	$time = $_POST['time'];
	$dt=$date." ".$time;
	$name="Rahij";
	$hpno="12345678";	
	

	/*
	echo "Your Username is: " . $input_username . "<br />";
	echo "Your Password is: " . $input_password . "<br />";
	*/
	
	$con = mysql_connect('http://46.137.218.102','ec2-user','rahij');
	if(!$con)
	{
		echo "Unable to connect to mysql";
		die();
	}
	
	$open_db = mysql_select_db("$database_name");
	echo "db selected!";	
	if (!$open_db)
	{
		echo "Unable to open database";
		die();
	}

	$success = mysql_query("INSERT INTO $table_name VALUES ('$origin','$destination','$dt','$name',$hpno')");
	if($success)
		echo 'Success!';
	else
		echo 'Failed!'


?>
</body>
</html>
