<?php
// define variables and set to default values
$match = $team = $barToss = $barCatch = $passes = $recieve = $goalHigh = 
$goalLow = $defense = $killed = $fouls = $tech_fouls = 0;
$tags = $notes = $tech_problems = "";
$high = $low = $noshot = $hot = $drove = $won = False;



//This entire thing just assigns the form data to these variables
if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
	$match = $_POST["match"];
	$team = $_POST["team"];
	$high = (strcmp($_POST["shot_auton"],"high")==0);
	$low = (strcmp($_POST["shot_auton"],"low")==0);
	$noshot = (strcmp($_POST["shot_auton"],"slept")==0);
	$hot = (strcmp($_POST["hot"],"hot")==0);
	$drove = (strcmp($_POST["drove_auton"],"drove")==0);
	$barToss = $_POST["bar_toss"];
	$barCatch = $_POST["bar_catch"];
	$passes = $_POST["passes"];
	$recieve = $_POST["recieved"];
	$goalHigh = $_POST["goal_high"];
	$goalLow = $_POST["goal_low"];
	$defense = $_POST["defense"];
	// $fouls = $_POST["fouls"];
	// $tech_fouls = $_POST["tech_fouls"];
	// $tech_problems = $_POST["tech_problems"];
	$won = isset($_POST['won']);
	$killed = $_POST["killed"];
	$notes = $_POST["notes"];
	$tags = $_POST["tags"];
}
//shh not important move along shh
if(strcmp($tags,"#econimal")== 0)
{
	echo '<iframe width="640" height="360" src="//www.youtube.com/embed/h7yfaSTSxBQ?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>';
}
$con=mysqli_connect("localhost","root","","scouting_database");

//Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_query($con,"INSERT INTO `match_data`(`match`, `team`, `high_auton`, `low_auton`, `no_auton`, `hot_auton`, `drove_auton`,`bar_toss`, `bar_catch`, `passes`, `recieved`,`goal_high`, `goal_low`,`defense`, `fouls`, `tech_fouls`, `tech_problems`, `win/lose`, `notes`, `tags`, `competition`) VALUES 
(".$match.",".$team.",".$high.",".$low.",".$noshot.",".$hot.",".$drove.",".$barToss.",".$barCatch.",".$passes.",".$recive.",".$defense.",`".$fouls.",`".$tech_fouls.",`".$tech_problems.",`".$won.",`".$notes."`,`".$tags."`)");//The good stuff, pass off to mysql

//Tidy up
mysqli_close($con);
echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='http://localhost/match_entry.html'>here.</a>");
?>
