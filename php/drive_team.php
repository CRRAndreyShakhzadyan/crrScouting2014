<?php

$teamNumber = 0;
$workWell = $coach = $mentors = "";
	
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$teamNumber = $_POST["team_number"];
	$workWell = $_POST["work_well"];
	$mentors = $_POST["mentors"];
}
	
$con=mysqli_connect("localhost","root","","scouting_database");

if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con,"INSERT INTO `match_data`(`team_number`,`work_well`,`mentors`) VALUES 
(".$team_number.", ".$work_well.", ".$mentors$.")");//The good stuff, pass off to mysql

//Tidy up
mysqli_close($con);

echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='http://localhost/match_entry.html'>here.</a>");
?>





