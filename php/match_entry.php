<?php
// define variables and set to default values
$match = $team = $barToss = $barCatch = $passes = $recive = $goalHigh = $goalLow = $defense = $killed= 0;
$tags = $notes = "";
$high = $low = $hot = $drove = False;

//This entire thing just assigns the form data to these variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["match"] != "" && $_POST["team"] != ""){
	$match = $_POST["match"];
	$team = $_POST["team"];
	$high = (isset($_POST["shot_auton"]) && $_POST["shot_auton"]=="high");
	$low = (isset($_POST["shot_auton"]) && $_POST["shot_auton"]=="low");
	$missed_auton = isset($_POST["missed_auton"]);
	$hot = isset($_POST["hot"]);
	$drove = isset($_POST["drove_auton"]);
	$barToss = $_POST["bar_toss"];
	$barCatch = $_POST["bar_catch"];
	$passes = $_POST["passes"];
	$recive = $_POST["recieved"];
	$goalHigh = $_POST["goal_high"];
	$goalLow = $_POST["goal_low"];
	$missed = $_POST["missed"];
	$defense = $_POST["defense"];
	$killed = $_POST["killed"];
	$won = (isset($_POST["won"]) && $_POST["won"]=="won");
	$notes = $_POST["notes"];
	$tags = $_POST["tags"];

	$con=mysqli_connect("localhost","root","","scouting_database");

	//Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$query= 'INSERT INTO `match_data`(`match_number`, `team`, `high_auton`, `low_auton`, `missed_auton`, `hot_auton`, `drove_auton`,`bar_toss`, `bar_catch`, `passes`, `received`,`goal_high`, `goal_low`, `missed`,`defense`, `won`, `killed`, `notes`, `tags`) VALUES ("'.$match.'","'.$team.'","'.$high.'","'.$low.'","'.$missed_auton.'","'.$hot.'","'.$drove.'","'.$barToss.'","'.$barCatch.'","'.$passes.'","'.$recive.'","'.$goalHigh.'","'.$goalLow.'","'.$missed.'","'.$defense.'","'.$killed.'","'.$won.'","'.$notes.'","'.$tags.'")';//The good stuff, pass off to mysql


	if (!mysqli_query($con,$query))
	{
	die('Error: ' . mysqli_error($con));
	}

	//Tidy up
	mysqli_close($con);

	if(strpos($_POST["tags"],"#econimal") !== false)//I changed it so it just needs to have #econimal anywhere in the string
	{
		echo '<iframe width="640" height="360" src="//www.youtube.com/embed/h7yfaSTSxBQ?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>';
	}
	
	echo("Form submitted successfully. If the back button infuriates you feel free to press <a href='match_entry.html'>here.</a>");
	
}else{
	echo "Form was not submitted successfully.  Returning you to the previous page";
}
?>