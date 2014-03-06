<?php
$team=-1;
if(isset($_POST['team'])){
	$team=$_POST['team'];
}
$startPosition="";
if(isset($_POST['startPosition'])){
	$startPosition=$_POST['startPosition'];
}
$goals="";
if(isset($_POST['score'])){
	$goals=$_POST['score'];
}
$pass="";
if(isset($_POST['pass'])){
	$pass=$_POST['pass'];
}
$defended="";
if(isset($_POST['defend'])){
	$defended=$_POST['defend'];
}

$con=mysqli_connect("localhost","root","","scouting_database");

//Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$query= 'INSERT INTO `location_data`(`team`, `start_position`, `goals`, `defense`, `passes`) VALUES ("'.$team.'","'.$startPosition.'","'.$goals.'","'.$defended.'","'.$pass.'")';//The good stuff, pass off to mysql

if (!mysqli_query($con,$query))
{
	die('Error: '.mysqli_error($con));
}
echo "information submitted successfully"
?>