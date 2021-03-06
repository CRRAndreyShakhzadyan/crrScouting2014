<?php
class Robot{
	//declare variable types with default values of -1 and False
	private $team = -1;
	private $avgDefense = -1;
	private $shoot = -1;//0=can't shoot, 1=can shoot low, 2=can shoot high, 3=can shoot both
	private $autonShoot =-1;//0=can't shoot, 6=shoots low, 15=shoots high, 11=shoots hot low, 20=shoots hot high
	private $passSpeed = -1;//for now we are using the same variable for passing and shooting, partly to make scouting easier
	private $scoreProb = -1.0;
	private $chatchProb = -1.0;//deprecating
	private $passOver = False;
	private $catchOver = False;
	private $autonDrive = False;
	private $task="";
	private $taskTimeLeft=-1;//-1 is invalid, continue until another task is set
	private $hasBall = True;//this is declared true as per the rules
	
	public function __construct($p_team,$p_avgDefense,$p_shoot,$p_autonShoot,$p_passSpeed,$p_scoreProb,$p_passOver,$p_catchOver,$p_autonDrive){
		$team=$p_team;
		$avgDefense=$p_avgDefense;
		$shoot=$p_shoot;
		$autonShoot=$p_autonShoot;
		$passSpeed=$p_passSpeed;
		$scoreProb=$p_scoreProb;
		$passOver=$p_passOver;
		$catchOver=$p_catchOver;
		$autonDrive=$p_autonDrive;
	}

	public function pass($defense){//attempts to pass and returns whether the attempt was successful
		if(rand(0,1)<=$scoreProb-$defense/10){ //TODO?: use a better random number generator?
			if($hasBall){//TODO?:change above, keep better track?
				$hasBall = False;
				return True;
			}
		}
		return False;
	}
	
	//sets the new task for a robot to work on
	/*-ACCEPTS STRINGS- valid strings are "pass","shoot", "defend", 
	and an empty string for resting*/
	public function setTask($newTask){
		$task=$newTask;
		if(strcmp($newTask,"pass")==0 || strcmp($newTask,"shoot"))//for now I am using the same variable for passing and shooting
			$taskTimeLeft=$passSpeed;
		else if(strcmp($newTask,"defend")==0)
			$taskTimeLeft=-1;
	}
	
	public function tick($defended){
		if( ($taskTimeLeft-TICK_TIME)>0 ){//if the robot still has to "wind up"
			$taskTimeLeft-=TICK_TIME;
			return false;
		}else{
			if(strcmp($task,"pass")==0)
				return pass($defended);
			if(strcmp($task,"shoot")==0)
				return pass($defended);
			if(strcmp($task,"defend")==0)
				return true;//TODO?:add some random chance of returning true?
		}
		return false;
	}
	
	//getters
	public function getTeam(){
		return $team;
	}
	
	public function getDefense(){
		return $avgDefense;
	}
	
	public function getDefended(){
		return floor(rand(0,$avgDefense*TICK_TIME/140)*140/(TICK_TIME*$avgDefense));//TODO: make this something besides a load of crap
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
	
	public function getTask(){
		return $task;
	}
}
?>
