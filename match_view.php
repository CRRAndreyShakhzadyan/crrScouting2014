<?php

$team = 0;
$heads=array("<td>autonomous</td>","<td>tosses over bar</td>","<td>catches from bar</td>","<td>passes</td>","<td>recieved</td>","<td>high goals</td>","<td>low goals</td>","<td>defense estimate</td>","<td>balls killed</td>","<td>notes</td>","<td>tags</td>");//stores the column header names

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// define variables and set to default values
	$auton = $barToss = $barCatch = $passes = $recieve = $goalHigh = $goalLow = $defense = $killed = $notes = $tags =  False;
	
	//This entire thing just assigns the form data to these variables
	$team = $_POST["team"];
	$auton = (strcmp($_POST["shot_auton"],"high")==0);
	$barToss = (strcmp($_POST["bar_toss"],"high")==0);
	$barCatch = (strcmp($_POST["bar_catch"],"high")==0);
	$passes = (strcmp($_POST["passes"],"high")==0);
	$recieve = (strcmp($_POST["recieved"],"high")==0);
	$goalHigh = (strcmp($_POST["goal_high"],"high")==0);
	$goalLow = (strcmp($_POST["goal_low"],"high")==0);
	$defense = (strcmp($_POST["defense"],"high")==0);
	$killed = (strcmp($_POST["killed"],"high")==0);
	$notes = (strcmp($_POST["notes"],"high")==0);
	$tags = (strcmp($_POST["tags"],"high")==0);
}

//stores the boolean values from the form responses
$cols=array($auton,$barToss,$barCatch,$passes,$recieve,$goalHigh,$goalLow,$defense,$killed,$notes,$tags);

$con=mysqli_connect("localhost","root","","scouting_database");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Gather the actual data
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM match_data");

//Here we get ready to print out a table
$print="<table>
<tr> <td>match</td> <td>team</td>";

for($i=1;$i<sizeof($heads) && $i<sizeof($heads);$i++){
	if($cols[i])
		$print=$print.$heads[i];
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
	if($row['hot']==1)//TODO: Validate, make sure this isn't true without high or low
		$auton=$auton." hot";
	if($row['drove_auton']==1)
		$auton=$auton." drove";
	
	
	
	echo "<tr> <td>".$row['match']."</td> <td>".$row['team']."</td> <td>".$auton."</td> <td>".$row['bar_toss']."</td> <td>".$row['bar_catch']."</td> <td>".$row['passes']."</td> <td>".$row['recieved']."</td> <td>".$row['goal_high']."</td> <td>".$row['goal_low']."</td> <td>".$row['defense']."</td> <td>".$row['killed']."</td> <td>".$row['notes']."</td> <td>".$row['tags']."</td> </tr>";
}
echo "</table>"

mysqli_close($con);
?>