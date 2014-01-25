<?php
$con=mysqli_connect("localhost","root","","scouting_database");
$result_match=mysqli_query($con,"SELECT * FROM 'match_data'");
$result_team=mysqli_query($con,"SELECT * FROM 'robot_data'")

while($row=mysql_fetch_array($result)){
//TODO: you know, MAKE THIS ACTUALLY WORK
}
mysqli_close($con);

class Robot{
	//declare variable types with default values of -1 and False
	private $team = -1;
	private $avgDefense = -1;
	private $shoot = -1;//0=can't shoot, 1=can shoot low, 2=can shoot high, 3=can shoot both
	private $passSpeed = -1;
	private $autonShoot =-1;//0=can't shoot, 6=shoots low, 15=shoots high, 11=shoots hot low, 20=shoots hot high
	private $scoreProb = -1.0
	private $chatchProb = -1.0;
	private $passOver = False;
	private $catchOver = False;
	private $autonDrive = False;
	
	private $task="";
	private $timeLEftTask=-1;
	private $hasBall = True;//this is declared true as per the rules
	
	public function __construct(){
		
	}
	

	
	public function pass(){//attempts to pass and returns whether the attempt was successful
		if(rand(0,1)<=$scoreProb){ //TODO?: use a better random number generator?
			if($hasBall){
				$hasBall = False;
				return True;
			}
		}
		return False;
	}
	
	
	
	{//getters
	public function getTeam(){
		return $team;
	}
	
	public function getDefense(){
		return $avgDefense;
	}
	
	public function getShoot(){
		return $shoot;
	}
	
	public function getPassSpeed(){
		return $passSpeed;
	}
	
	public function getAutonShoot(){
		return $autonShoot;
	}
	
	public function getScoreProb(){
		return $scoreProb;
	}
	
	public function getCatchProb(){
		return $catchProb;
	}
	
	public function getPassOver(){
		return $passOver;
	}
	
	public function getCatchOver(){
		return $catchOver;
	}
	
	public function hasBall(){
		return $hasBall;
	}
	
	public function getAutonDrive(){
		return $autonDrive;
	}
	
	public function getTaskAtTime($time){
		for($i=0;i<sizeof($taskAtTime);i++){
			
		}
	}
	}
}
?>