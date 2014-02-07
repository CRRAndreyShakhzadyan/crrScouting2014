<?php

echo '<html>
<head>
<title>Match Scouting Results</title>
</head>

<link href="../css/default.css" type="text/css" rel = "stylesheet">
<div class = "formb1">
<body>
<a href="../index.html"><img src="../assets/Scouting4.png" alt="Scouting4.png" width="639" height="200"></a>
<h1>Match Results Per Robot</h1>';
$team = 0;
$heads=array("autonomous","tosses over bar","catches from bar","passes","received","high goals","low goals","defense","fouls","tech fouls","problems","won/lost","notes","tags");//stores the column header names

$team = "*";
$auton = $barToss = $barCatch = $passes = $recieve = $goalHigh =$goalLow = $defense = $fouls = $tech_fouls = $tech_problems = $won = $notes = $tags = True;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	// define variables and set to default values
	///$barToss = $barCatch = $passes = $recieve = $goalHigh = $goalLow = $defense = $killed = $notes = $tags =  False;
	
	//This entire thing just assigns the form data to these variables
	$auton = isset($_POST["auton"]);
	$barToss = isset($_POST["truss_toss"]);
	$barCatch = isset($_POST["bar_catch"]);
	$passes = isset($_POST["passes"]);
	$recieve = isset($_POST["received"]);
	$goalHigh = isset($_POST["goal_high"]);
	$goalLow = isset($_POST["goal_low"]);
	$defense = isset($_POST["defense"]);
	$fouls = isset($_POST["fouls"]);
	$tech_fouls = isset($_POST["fouls"]);
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

//Gather the actual data FOR MATCHES                         <-------------------------Matches
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM match_data");

//Here we get ready to print out a table
$print="<table class='display'><tr> <th>match</th> <th>team</th>";

for($i=0;$i<sizeof($heads) && $i<sizeof($cols);$i++){
	if($cols[$i]){
		$print=$print."<th>".$heads[$i]."</th>";
	}
}
//PRINT!!!
echo $print."<th>won</th></tr>";

$print="";
//$print="<tr> <td>".$row['match_number']."</td> <td>".$row['team']."</td>";
$printf="";
$alt=false;
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
	
	if($alt){
		$print="<tr class='alt'> <td>".$row['match_number']."</td> <td>".$row['team']."</td>";
		$alt=false;
	}else{
		$print="<tr> <td>".$row['match_number']."</td> <td>".$row['team']."</td>";
		$alt=true;
	}
	
	//This masssive section of ifs adds on all of the columns that we are actually tracking
	if($cols[0]){
		$print=$print."<td>".$auton."</td>";
	}if($cols[1]){
		$print=$print."<td>".$row['bar_toss']."</td>";
	}if($cols[2]){
		$print=$print."<td>".$row['bar_catch']."</td>";
	}if($cols[3]){
		$print=$print."<td>".$row['passes']."</td>";
	}if($cols[4]){
		$print=$print."<td>".$row['received']."</td>";
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
	$print=$print."<td>".$row['won']."</td>";
	$printf=$printf.$print."</tr>";
}
$printf=$printf."</table></body></div></html>";
echo $printf;

/* I just commented out everything from team info, I find it of dubious necessity anyway
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
*/

mysqli_close($con);
?>
