<?php

$team = 0;
$heads=array("<td>autonomous</td>","<td>tosses over bar</td>","<td>catches from bar</td>","<td>passes</td>","<td>recieved</td>","<td>high goals</td>","<td>low goals</td>","<td>defense estimate</td>","<td>fouls</td>","<td>technical fouls</td>","<td>problems</td>","<td>won/lost</td>","<td>notes</td>","<td>tags</td>");//stores the column header names

$team = "*";
$auton = $barToss = $barCatch = $passes = $recieve = $goalHigh =$goalLow = $defense = $fouls = $tech_fouls = $tech_problems = $won = $notes = $tags = True;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// define variables and set to default values
	///$barToss = $barCatch = $passes = $recieve = $goalHigh = $goalLow = $defense = $killed = $notes = $tags =  False;
	
	//This entire thing just assigns the form data to these variables
	$auton = (strcmp($_POST["auton"],"shot_auton")==0);
	$barToss = (strcmp($_POST["bar_toss"],"bar_toss")==0);
	$barCatch = (strcmp($_POST["bar_catch"],"bar_catch")==0);
	$passes = (strcmp($_POST["passes"],"passes")==0);
	$recieve = (strcmp($_POST["recieved"],"recieved")==0);
	$goalHigh = (strcmp($_POST["goal_high"],"goal_high")==0);
	$goalLow = (strcmp($_POST["goal_low"],"goal_low")==0);
	$defense = (strcmp($_POST["defense"],"dfense")==0);
	$fouls = (strcmp($_POST["fouls"],"fouls")==0);
	$tech_fouls = (strcmp($_POST["tech_fouls"],"tech_fouls")==0);
	$tech_problems = (strcmp($_POST["tech_problems"],"tech_problems")==0);
	$won = (strcmp($_POST["won"],"won")==0);
	$notes = (strcmp($_POST["notes"],"notes")==0);
	$tags = (strcmp($_POST["tags"],"tags")==0);
	
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
$print="<table><tr> <td>team</td> <td>info</td></tr>";
echo $print;

//Gos through every row and places information in the table
while($row = mysqli_fetch_array($result)){
	//TODO:Find out what columns should go here
}


//Gather the actual data FOR MATCHES                         <-------------------------Matches
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM match_data");

//Here we get ready to print out a table
$print="<table>
<tr> <td>match</td> <td>team</td>";

for($i=1;$i<sizeof($heads) && $i<sizeof($cols);$i++){
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
	
	//This masssive section of ifs adds on all of the columns that we are actually tracking
	$print="<tr> <td>".$row['match']."</td> <td>".$row['team']."</td>";
	if(cols[0]){
		$print=$print."<td>".$auton."</td>"
	}if(cols[1]){
		$print=$print."<td>".$row['bar_toss']."</td>"
	}if(cols[2]){
		$print=$print."<td>".$row['bar_catch']."</td>"
	}if(cols[3]){
		$print=$print."<td>".$row['passes']."</td>"
	}if(cols[4]){
		$print=$print."<td>".$row['recieved']."</td>"
	}if(cols[5]){
		$print=$print."<td>".$row['goal_high']."</td>"
	}if(cols[6]){
		$print=$print."<td>".$row['goal_low']."</td>"
	}if(cols[7]){
		$print=$print."<td>".$row['defense']."</td>"
	}if(cols[8]){
		$print=$print."<td>".$row['fouls']."</td>"
	}if(cols[9]){
		$print=$print."<td>".$row['tech_fouls']."</td>"
	}if(cols[10]){
		$print=$print."<td>".$row['tech_problems']."</td>"
	}if(cols[11]){
		$print=$print."<td>".$row['win/lose']."</td>"
	}if(cols[12]){
		$print=$print."<td>".$row['notes']."</td>"
	}if(cols[13]){
		$print=$print."<td>".$row['tags']."</td>"
	}
	$print=$print."</tr>"
		
	echo $print;
}
echo "</table>"

mysqli_close($con);
?>
