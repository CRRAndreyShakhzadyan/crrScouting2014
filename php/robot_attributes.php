<?php
// define variables, set them to default values
$shoottime = $successrate = 0;
$drivetype = $drivespeed = $pushiness = $passmethod = $passcomp = $blockmech = $blockability = "";
$pickup = $catcher = $trusscatch = $blockcap = False;

//this assigns form data to the variables
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$shoottime = $_POST["shoot"];
	$successrate = $_POST["goal_rate"];
	$pickup = isset($_POST['pickup']);
	$catcher = isset($_POST['catcher']);
	$trusscatch = isset($_POST['truss_catch']);
	$blockcap = isset($_POST['block_cap']);
	$drivetype = $_POST["drive_type"];
	$drivespeed = $_POST["drive_speed"];
	$pushiness = $_POST["drive_push"];
	$passmethod = $_POST["pass_method"];
	$passcomp = $_POST["pass_comp"];
	$blockmech = $_POST["block_mech"];
	$blockability = $_POST["block_ability"];
	
}

$con=mysqli_connect("localhost","root","","scouting_database");

//Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$query = "INSERT INTO `robot_attributes`(`shoot_time`, `goal_rate`, `pickup`, `catcher`, `truss_catch`, `block_cap`, `drive_type`, `drive_speed`, `drive_push`, `pass_method`, `pass_comp`, `block_mech`, `block_ability`) VALUES ('$shoottime','$successrate','$pickup','$catcher','$trusscatch','$blockcap','$drivetype','$drivespeed','$pushiness','$passmethod','$passcomp','$blockmech','$blockability')";
 
echo $query;

if(!mysqli_query($con,$query))
{
	die('Error: ' . mysqli_error($con)); 
}
//Tidy up
mysqli_close($con);

echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='http://localhost/robot_attributes.html'>here.</a>");
?>
