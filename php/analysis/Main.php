<?php
class Main
{
	private $team=array();
	private $all=array();
	
	public function _construct()
	{
		$teams=addBots();
		
		for($i=0;$i<sizeof($teams);$i++){
			if($row['team']==$teams[$i][0]){
				array_push($team,new Robot($vals[0],$vals[1],$vals[5],$vals[6],$row['shoot_time'],$vals[2],$vals[7],$vals[8],$vals[9]));//TODO: CHECK I AM VIRTUALLY WILLING TO GUARANTEE AN ERROR HERE
			}
		}
		
		$all=addAls($teams);
		
		echo "simulating matches...</br>";
		flush();
		sleep(1);
		for($i=0;$i<sizeof($all);$i++){
			for($ii=0;$ii<sizeof($all);$i++){
				if($ii<$i){
					playGame($all[$i],$all[$ii]);
				}
			}
		}
		
		getBest();
	}
	
	//sorts the alliances from highest to lowest with quicksort
	public function sort($arr){
		echo "finding best robots...</br>";
		if(sizeof($arr>1)){
			$piv=floor(sizeof($arr)/2);
			$less=array();
			$more=array();
			for($i=0;$i<sizeof($arr);$i++){
				if($all[$i]<$arr[$piv])
					array_push($less,$arr[$i]);
				else
					array_push($more,$arr[$i]);
			}
			array_push($less,$all[$piv]);
			return concatenate($less,$more);
		} else {
			return $arr;
		}
	}
	
	public function concatenate($a,$b){
		for($i=0;$i<sizeof($b);$i++){
			array_push($a,$b[$i]);
		}
	}
	
	//returns an array containing the names of the best robots and their win loss ratio
	public function getBest(){
		$all=$sort($all);
		for($i=0;$i<20;$i++){//20 is the number of alliances to display
			$a=$all[$i]->getRobots()[0]->getTeam();
			$b=$all[$i]->getRobots()[1]->getTeam();
			$c=$all[$i]->getRobots()[2]->getTeam();
			echo ($i+1).$a.",".$b.",".$c."</br>";
		}
	}
	
	//Plays out a given match and returns the winning alliance
	//returns: true if a wins and false if b wins, -1 if something goes wrong
	public function playGame(Alliance $a, Alliance $b){
		$m=new Match($a,$b);
		$m->playGame($a,$b);
	}
	
	//Adds all of the possible alliances to an array and returns the result
	public function addAlls($teams){
		echo "adding alliances...</br>";
		flush();
		sleep(1);
		
		$alls=array();
		
		for($i=0;$i<sizeof($teams);$i++){
			for($ii=0;$ii<sizeof($teams);$ii++){
				for($iii=0;$iii<sizeof($teams);$iii++){//TODO:improve efficiency by changing the start value
					if($i<$ii && $ii<$iii && $i<$iii){//if we haven't done this one before
						array_push($alls,new Alliance($teams[$i],$teams[$ii],$teams[$iii]));
					}
				}
			}
		}
		
		return $alls;
	}
	
	//Adds all robots to an array by looking through the scouting database and returns the result
	public function addBots(){
		echo "adding robots...</br>";
		flush();
		sleep(1);
		$con=mysqli_connect("localhost","root","","scouting_database","scouting_database");
		$result=mysqli_query($con,"SELECT * FROM 'match_data'");
		
		//these variables are used by each of the teams
		$toss=false; $catch=false; $drive=false; $score=0; $autonScore=0;
		$teams=array();
		
		while($row = mysql_fetch_array($result)){
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
				if(($teams[6]==11 || $teams[6]==16) && $row['hot_auton']!=0)
					$autonScore-=5;
				
				$teams[$i][1]+=$row['defense'];
				$teams[$i][2]+=$row['goal_high']+$row['goal_low'];
				$teams[$i][3]+=$row['missed'];
				$teams[$i][4]+=1;
				$teams[$i][5]=max($teams[$i][5],$score);
				$teams[$i][6]=max($teams[$i][6],$autonScore);
				$teams[$i][7]=($teams[$i][7] || $toss);
				$teams[$i][8]=($teams[$i][8] || $catch);
				$teams[$i][9]=($teams[$i][9] || $drives);
				
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
					$score+=6;
				if($row['high_auton']>0)
					$score+=15;
				if($row['hot_auton']>0)
					$score+=5;
				
				array_push( $teams,array($row['team'],$row['defense'],$row['goal_high']+$row['goal_low'],$row['missed'],1,$score,$autonScore,$toss,$catch,$drives) );
				
				$toss=false; $catch=false; $drive=false; $score=0;
			}
		}
		
		for($i=0;$i<sizeof($teams);$i++){
			$teams[$i][1]/=$teams[$i][4];
			$teams[$i][2]/=$teams[$i][3];
		}
		
		return $teams;
	}
}
?>