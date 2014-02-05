<?php

echo '<!DOCTYPE html>
<html lang="en"><head><link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css"><link rel= "stylesheet" href="css/default.css" type="text/css"></head>';
$team = 0;
$heads=array("autonomous","tosses over bar","catches from bar","passes","received","high goals","low goals","defense estimate","fouls","technical fouls","problems","won/lost","notes","tags");//stores the column header names

$team = "*";
$auton = $barToss = $barCatch = $passes = $recieve = $goalHigh =$goalLow = $defense = $fouls = $tech_fouls = $tech_problems = $won = $notes = $tags = True;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// define variables and set to default values
	///$barToss = $barCatch = $passes = $recieve = $goalHigh = $goalLow = $defense = $killed = $notes = $tags =  False;
	
	//This entire thing just assigns the form data to these variables
	$auton = isset($_POST["shot_auton"]);
	$barToss = isset($_POST["bar_toss"]);
	$barCatch = isset($_POST["bar_catch"]);
	$passes = isset($_POST["passes"]);
	$recieve = isset($_POST["recieved"]);
	$goalHigh = isset($_POST["goal_high"]);
	$goalLow = isset($_POST["goal_low"]);
	$defense = isset($_POST["defense"]);
	$fouls = isset($_POST["fouls"]);
	$tech_fouls = isset($_POST["tech_fouls"]);
	$tech_problems = isset($_POST["tech_problems"]);
	$won = isset($_POST["won"]);
	$notes = isset($_POST["notes"]);
	$tags = isset($_POST["tags"]);
	
	//stores the boolean values from the form responses
	$cols=array($auton,$barToss,$barCatch,$passes,$recieve,$goalHigh,$goalLow,$defense,$fouls,$tech_fouls,$tech_problems,$won,$notes,$tags);
}


$con=mysqli_connect("localhost","root","","scouting_database");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Gather the actual data FROM ROBOTS                                  
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM robot_data");

//Here we get ready to print out a table
$print="<table><tr> <td>team</td> <td>drive train</td> <td>passing/scoring mechanism</td> <td>catching mechanism</td> <td>defensive capabilities</td></tr>";

//Gos through every row and places information in the table
while($row = mysqli_fetch_array($result)){
	$print=$print."<tr><td>".$row['team'].
	"</td><td>type:".$row['drive_type']." speed:".$row['drive_speed']." pushiness:".$row['drive_push'].
	"</td><td>pass method:".$row['pass_method']." compatability:".$row['pass_comp'].
	"</td><td> catcher:".$row['catcher']." truss catcher".$row['truss_catch'].
	"</td><td> block ability:".$rows['block_ability']." block type:".$rows['block_mech']."</td></tr>";//TODO:check over everything here and make sure columns correspond
}
$print=$print."</table>";
echo $print;

//Gather the actual data FOR MATCHES                         <-------------------------Matches
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM match_data");

//Here we get ready to print out a table
$print="<table class='table'><tr> <td>match</td> <td>team</td>";

for($i=1;$i<sizeof($heads) && $i<sizeof($cols);$i++){
	if($cols[$i]){
		$print=$print."<td>".$heads[$i]."</td>";
	}
}
//PRINT!!!
echo $print."</tr>";

//Gos through every row and places information in the table
while($row = mysqli_fetch_array($result)){
	$auton="NA"; //creates a variable to define the goal made in autonomous
	if($row['high_auton']==1)
		$auton="high";
	else if($row['low_auton']==1)
		$auton="low";
	//if($row['hot']==1)//TODO: Validate, make sure this isn't true without high or low
		//$auton=$auton." hot";
	if($row['drove_auton']==1)
		$auton=$auton." drove";
	
	//This masssive section of ifs adds on all of the columns that we are actually tracking
	$print="<tr> <td>".$row['match_number']."</td> <td>".$row['team']."</td>";
	if($cols[0]){
		$print=$print."<td>".$auton."</td>";
	}if($cols[1]){
		$print=$print."<td>".$row['bar_toss']."</td>";
	}if($cols[2]){
		$print=$print."<td>".$row['bar_catch']."</td>";
	}if($cols[3]){
		$print=$print."<td>".$row['passes']."</td>";
	}if($cols[4]){
		$print=$print."<td>".$row['recieved']."</td>";
	}if($cols[5]){
		$print=$print."<td>".$row['goal_high']."</td>";
	}if($cols[6]){
		$print=$print."<td>".$row['goal_low']."</td>";
	}if($cols[7]){
		$print=$print."<td>".$row['defense']."</td>";
	}if($cols[8]){
		$print=$print."<td>".$row['fouls']."</td>";
	}if($cols[9]){
		$print=$print."<td>".$row['tech_fouls']."</td>";
	}if($cols[10]){
		$print=$print."<td>".$row['tech_problems']."</td>";
	}if($cols[11]){
		$print=$print."<td>".$row['win/lose']."</td>";
	}if($cols[12]){
		$print=$print."<td>".$row['notes']."</td>";
	}if($cols[13]){
		$print=$print."<td>".$row['tags']."</td>";
	}
	$print=$print."</tr>";
}
$print=$print."</table></html>";
echo $print;

//Gather the actual data FROM Team statistics                                  
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM team_data");//TODO: make sure the name of the database is right

//Here we get ready to print out a table
$print="<table><tr> <td>team</td> <td>work well</td> <td>mentors</td></tr>";

//Gos through every row and places information in the table
while($row = mysqli_fetch_array($result)){
	$print=$print."<tr><td>".$row['team'].
	"</td><td>worked well together:".$row['work_well']." mentors:".$row['mentors']."</td></tr>";//TODO:check over everything here and make sure columns correspond
}
$print=$print."</table>";
echo $print;

mysqli_close($con);
?>
