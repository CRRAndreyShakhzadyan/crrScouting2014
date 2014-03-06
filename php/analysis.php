<?php
$con=mysqli_connect("localhost","root","","scouting_database");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Gather the actual data FOR MATCHES
$result=mysqli_query($con,"SELECT * FROM match_data");

//these variables are used by each of the teams
$toss=false; $catch=false; $drive=false; $score=0; $autonScore=0;
$teams=array();

while($row = mysqli_fetch_array($result)){
	$found=false;
	for($i=0;$i<sizeof($teams);$i++){
		if($row['team']==$teams[$i][0]){
			$found=true;
			break;
		}
	}
	
	if($found){
		if($row['bar_toss']>0)
			$toss=true;
		if($row['bar_catch']>0)
			$catch=true;
		if($row['drove_auton']==1)
			$drive=true;
		if($row['goal_low']>0)
			$score+=1;
		if($row['goal_high']>0)
			$score+=2;
		if($row['low_auton']>0)
			$autonScore+=6;
		if($row['high_auton']>0)
			$autonScore+=15;
		if(($teams[$i][6]==11 || $teams[$i][6]==16) && $row['hot_auton']!=0)
			$autonScore-=5;
		
		$teams[$i][1]+=$row['defense'];
		$teams[$i][2]+=$row['goal_high']+$row['goal_low'];
		$teams[$i][3]+=$row['missed'];
		$teams[$i][4]+=1;
		$teams[$i][5]=max($teams[$i][5],$score);
		$teams[$i][6]=max($teams[$i][6],$autonScore);
		$teams[$i][7]=($teams[$i][7] || $toss);
		$teams[$i][8]=($teams[$i][8] || $catch);
		$teams[$i][9]=($teams[$i][9] || $drive);
		
		$toss=false; $catch=false; $drive=false; $score=0; $autonScore=0;
	} else {
		if($row['bar_toss']>0)
			$toss=true;
		if($row['bar_catch']>0)
			$catch=true;
		if($row['drove_auton']==1)
			$drive=true;
		if($row['goal_low']>0)
			$score+=1;
		if($row['goal_high']>0)
			$score+=2;
		if($row['low_auton']>0)
			$autonScore+=6;
		if($row['high_auton']>0)
			$autonScore+=15;
		if($row['hot_auton']>0)
			$autonScore+=5;
		
		array_push( $teams,array($row['team'],$row['defense'],$row['goal_high']+$row['goal_low'],$row['missed'],1,$score,$autonScore,$toss,$catch,$drive) );
		
		$toss=false; $catch=false; $drive=false; $score=0; $autonScore=0;
	}
}
	
for($i=0;$i<sizeof($teams);$i++){
	$teams[$i][2]/=$teams[$i][5];
	$teams[$i][3]/=$teams[$i][4];
}

//Gather the actual data FOR ROBOTS
$result=mysqli_query($con,"SELECT * FROM robot_data");
while($row = mysqli_fetch_array($result)){
	for($i=0;$i<sizeof($teams);$i++){
		if($row['team']==$teams[$i][0]){
			array_push($teams[$i],$row['shoot_time']);
		}
	}
}

$print="";
for($i=0;$i<sizeof($teams);$i++){
	$print=$print.$teams[$i][0].":".$teams[$i][1].",".$teams[$i][2].",".$teams[$i][5].",".$teams[$i][6].",".$teams[$i][7].",".$teams[$i][8].",".$teams[$i][9].",".$teams[$i][10].";";
}
echo $print;
?>