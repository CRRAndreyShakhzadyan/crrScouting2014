<?php
//represents titles for graphs and axis on radarchart
$titles=array("truss toss","truss catch","passes","receive","high goals","low goals","missed","defense");

require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_radar.php');
require_once ('../jpgraph/src/jpgraph_line.php');
//require_once ('/jpgraph/src/jpgraph_legend.php');

$team=639;
if(isset($_GET['team'])){
	$team=$_GET['team'];
}

$con=mysqli_connect("localhost","root","code red","scouting");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//Gather the actual data FOR MATCHES
//TODO: ? restrict to only the needed values
//$result=mysqli_query($con,"SELECT * FROM match_data WHERE team=`".$team."`");
$result=mysqli_query($con,"SELECT * FROM match_data WHERE team=".$team);

if(!$result){
	echo "oops";
	die();
}

$avgR=array(0,0,0,0,0,0,0,0);
$iterations=1;
//Gos through every row and calculates average
while($row = mysqli_fetch_array($result)){
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
$graph->SetTitles($titles);

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
$graph->legend->SetPos(.1,.9,'left','top');
$adress="../graphs/radar.png";
unlink($adress);
$graph->Stroke($adress);
echo "<img src='".$adress."'></img></br></br>";


//<---------------------------OTHER GRAPHS


$toss=array();$catch=array();$passes=array();$receive=array();$high=array();$low=array();$missed=array();$defense=array();
$stats=array($toss,$catch,$passes,$receive,$high,$low,$missed,$defense);
//echo "<img src='".$adress."'></img></body></div></html>";

//Gather the actual data FOR MATCHES
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM match_data WHERE team=".$team);

if(!$result){
	echo "oops";
	die();
}

//Gos through every row and calculates average
while($row = mysqli_fetch_array($result)){
	array_push($stats[0],$row['bar_toss']);
	array_push($stats[1],$row['bar_catch']);
	array_push($stats[2],$row['passes']);
	array_push($stats[3],$row['received']);
	array_push($stats[4],$row['goal_high']);
	array_push($stats[5],$row['goal_low']);
	array_push($stats[6],$row['missed']);
	array_push($stats[7],$row['defense']);
}

//printing the line graphs
for($i=0;$i<sizeof($stats);$i++){
	$graph=new Graph(400,400);
	$graph->SetScale("linlin");
	$graph->title->Set($titles[$i]);

	$plot=new LinePlot($stats[$i]);
	$plot->SetColor('red');

	// Add the plots to the graph
	$graph->Add($plot);
 
	// and display the graph
	$graph->legend->hide();
	$adress="../graphs/".$titles[$i].".png";
	unlink($adress);
	$graph->Stroke($adress);
	echo "<img src='".$adress."'></img></br></br>";
}
?>
