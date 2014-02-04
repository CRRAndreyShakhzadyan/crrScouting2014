<?php
// define variables and set to default values
$match = $team = $barToss = $barCatch = $passes = $recive = $goalHigh = $goalLow = $defense = $killed= 0;
$tags = $notes = "";
$high = $low = $hot = $drove = False;

//This entire thing just assigns the form data to these variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["match"] != "" && $_POST["team"] != ""){ 
	$match = $_POST["match"];
	$team = $_POST["team"];
	$high = (strcmp($_POST["shot_auton"],"high")==0);
	$low = (strcmp($_POST["shot_auton"],"low")==0);
	$hot = (strcmp($_POST["hot"],"hot")==0);
	$drove = (strcmp($_POST["drove_auton"],"drove")==0);
	$barToss = $_POST["bar_toss"];
	$barCatch = $_POST["bar_catch"];
	$passes = $_POST["passes"];
	$recive = $_POST["recieved"];
	$goalHigh = $_POST["goal_high"];
	$goalLow = $_POST["goal_low"];
	$defense = $_POST["defense"];
	$killed = $_POST["killed"];
	$notes = $_POST["notes"];
	$tags = $_POST["tags"];

$con=mysqli_connect("localhost","root","","scouting_database");

//Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$query= 'INSERT INTO `match_data`(`match_number`, `team`, `high_auton`, `low_auton`, `hot_auton`, `drove_auton`,`bar_toss`, `bar_catch`, `passes`, `received`,`goal_high`, `goal_low`,`defense`, `killed`, `notes`, `tags`) VALUES ("'.$match.'","'.$team.'","'.$high.'","'.$low.'","'.$hot.'","'.$drove.'","'.$barToss.'","'.$barCatch.'","'.$passes.'","'.$recive.'","'.$goalHigh.'","'.$goalLow.'","'.$killed.'","'.$defense.'","'.$notes.'","'.$tags.'")';//The good stuff, pass off to mysql


if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }

//Tidy up
mysqli_close($con);

echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='match_entry.html'>here.</a>");
}

else
{
	echo "Form was not submitted successfully.  Returning you to the previous page";
?>

<html>


<meta HTTP-EQUIV="REFRESH" content="2; url=match_entry.html">

</html>

<?php
}
?>