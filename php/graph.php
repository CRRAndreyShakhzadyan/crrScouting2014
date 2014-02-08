<?php
require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_radar.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$team=$_POST["team"];
}

$con=mysqli_connect("localhost","root","","scouting_database");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Gather the actual data FOR MATCHES
//TODO: ? restrict to only the needed values
//$result=mysqli_query($con,"SELECT * FROM match_data WHERE team=`".$team."`");
$result=mysqli_query($con,"SELECT * FROM match_data WHERE team=639");

if(!$result){
	echo "oops";
	die();
}

$avgR=array(0,0,0,0,0,0,0,0);
$iterations=1;
//Gos through every row and calculates average
while($row = mysqli_fetch_array($result)){
	if($row['team']==639){
	$avgR[0]+=$row['bar_toss'];
	$avgR[1]+=$row['bar_catch'];
	$avgR[2]+=$row['passes'];
	$avgR[3]+=$row['received'];
	$avgR[4]+=$row['goal_high'];
	$avgR[5]+=$row['goal_low'];
	$avgR[6]+=$row['missed'];
	$avgR[7]+=$row['defense'];
	
	$iterations++;
	}
}

//divide every value to find average
for($i=0;$i<sizeof($avgR);$i++){
	$avgR[$i]/=$iterations;
}

//Gather the actual data FOR MATCHES
$result=mysqli_query($con,"SELECT * FROM match_data");


$avg=array(0,0,0,0,0,0,0,0);
$iterations=1;
//Gos through every row and calculates average
while($row = mysqli_fetch_array($result)){
	$avg[0]+=$row['bar_toss'];
	$avg[1]+=$row['bar_catch'];
	$avg[2]+=$row['passes'];
	$avg[3]+=$row['received'];
	$avg[4]+=$row['goal_high'];
	$avg[5]+=$row['goal_low'];
	$avg[6]+=$row['missed'];
	$avg[7]+=$row['defense'];
	
	$iterations++;
}

//divide every value to find average
for($i=0;$i<sizeof($avg);$i++){
	$avg[$i]/=$iterations;
}

$graph=new RadarGraph(400,400);
$graph->SetScale("lin");
$graph->title->Set("Individual Performance vs Avg");
$graph->SetTitles(array("truss toss","truss catch","passes","receive","high goals","low goals","missed","defense"));

$plotR=new RadarPlot($avgR);
$plotR->SetLegend("robot");
$plotR->SetColor('red');

$plotA=new RadarPlot($avg);
$plotA->SetLegend("avg");
$plotA->SetColor('blue');

// Add the plots to the graph
$graph->Add($plotR);
$graph->Add($plotA);
 
// and display the graph
$graph->Stroke();
?>
