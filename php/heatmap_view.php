<?php
if(isset($_GET['team']))
	$team=$_GET['team'];


$con=mysqli_connect("localhost","root","","scouting_database");

$query="SELECT * FROM `location_data` WHERE `team`=".$team;

if($team=='*'){
	$query="SELECT * FROM `location_data`";
}

$result=mysqli_query($con,$query);
if(!$result){
	die();
}

$startPos=array();
$coor=array();
$dCoor=array();
$pCoor=array();

while($row=mysqli_fetch_array($result)){
	$startPos=explode(',',$row['start_position']);
	
	$coorN=explode(',',$row['goals']);
	for($i=0;$i<sizeOf($coorN);$i++){
		array_push($coor,substr($coorN[$i],0,4));
	}
	
	$dCoorN=explode(',',$row['defense']);
	for($i=0;$i<sizeOf($dCoorN);$i++){
		array_push($dCoor,substr($dCoorN[$i],0,4));
	}
	
	$pCoorN=explode(',',$row['passes']);
	for($i=0;$i<sizeOf($pCoorN);$i++){
		array_push($pCoor,substr($pCoorN[$i],0,4));
	}
}

echo '{"x":"'.$startPos[1].'","y":"'.$startPos[2].'"}';

for($i=1;$i<sizeof($coor)-1;$i++){
	echo $coor[$i].',';
}
if(sizeof($coor)>0){
	echo $coor[sizeof($coor)-1].';';
}else{
	echo ';';
}

for($i=1;$i<sizeof($dCoor)-1;$i++){
	echo $dCoor[$i].',';
}
if(sizeof($dCoor)>0){
	echo $dCoor[sizeof($dCoor)-1].';';
}else{
	echo ';';
}

for($i=1;$i<sizeof($pCoor)-1;$i++){
	echo $pCoor[$i].',';
}
if(sizeof($pCoor)>0){
	echo $pCoor[sizeof($pCoor)-1].';';
}else{
	echo ';';
}
?>