<?php
// define variables, set them to default values
$shoottime = $successrate= $team = 0;
$drivetype = $drivespeed = $pushiness = $passmethod = $passcomp = $blockmech = $blockability = "";
$pickup = $catcher = $trusscatch = $blockcap = False;

//this assigns form data to the variables
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$team = $_POST["teamnum"];
	$shootTime = $_POST["shoot_time"];
	$pickup = isset($_POST['pickup']);
	$catcher = isset($_POST['catcher']);
	$trussCatch = isset($_POST['truss_catch']);
	$drive = $_POST["drive"];
	$pass = $_POST["passing"];
	$block = $_POST["block"];
	$blockSuccess = $_POST["block_success"];
}

$con=mysqli_connect("localhost","root","","scouting_database");

//Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$query = "INSERT INTO `robot_data`(`team`,`shoot_time`,`pickup`,`catcher`,`truss_catch`,`drive`,`pass`,`block`,`block_success`)
VALUES ('".$team."','".$shootTime."','".$pickup."','".$catcher."','".$trussCatch."','".$drive."','".$pass."','".$block."','".$blockSuccess."')";

if(!mysqli_query($con,$query))
{
	die('Error: ' . mysqli_error($con)); 
}
//Tidy up
mysqli_close($con);

echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='../robot_attributes.html'>here.</a>");
?>
