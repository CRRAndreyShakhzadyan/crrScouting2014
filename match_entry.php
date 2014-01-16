<?php
// define variables and set to default values
$match = $team = $barToss = $barCatch = $passes = $recieve = $goalHigh = $goalLow = $defense = $killed= 0;
$tags = $notes = "";
$high = $low = $hot = $drove = False;

//This entire thing just assigns the form data to these variables
if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$match = $_POST["match"];
	$team = $_POST["team"];
	$high = (strcmp($_POST["shot_auton"],"high")==0);
	$low = (strcmp($_POST["shot_auton"],"low")==0);
	$hot = (strcmp($_POST["hot"],"hot")==0);
	$drove = (strcmp($_POST["drove_auton"],"drove")==0);
	$barToss = $_POST["bar_toss"];
	$barCatch = $_POST["bar_catch"];
	$passes = $_POST["passes"];
	$recieve = $_POST["recieved"];
	$goalHigh = $_POST["goal_high"];
	$goalLow = $_POST["goal_low"];
	$defense = $_POST["defense"];
	$killed = $_POST["killed"];
	$notes = $_POST["notes"];
	$tags = $_POST["tags"];
}

$con=mysqli_connect("localhost","root","","scouting_database");

//Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con,"INSERT INTO `match_data`(`match`, `team`, `high_auton`, `low_auton`, `hot_auton`, `drove_auton`,`bar_toss`, `bar_catch`, `passes`, `recieved`,`goal_high`, `goal_low`,`defense`, `killed`, `notes`, `tags`,) VALUES (".$match.",".$team.",".$high.",".$low.",".$hot.",".$drove.",".$barToss.",".$barCatch.",".$passes.",".$recive.",".$defense.",`".$notes."`,`".$tags."`)");//The good stuff, pass off to mysql

//Tidy up
mysqli_close($con);

echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='http://localhost/match_entry.html'>here.</a>");
?>