<?php
class Alliance{
	const MISS_PENALTY=10;//how much time is deducted from a missed shot
	
	private $robotA;
	private $robotB;
	private $robotC;
	
	private $ballOwner;
	private $ballHeat=0;
	private $score=0;
	private $passedOver=false;
	
	private $robotTeam = array();
	
	private $winLoss = 0;//TODO: make this an actual ratio?
	
	//Adds a new match outcome to the win loss ratio
	//$won is a boolean value representing whether the robot won or not
	public function placeMatch($won){
		if($won)
			$winLoss+=1;
		else if(!$won)
			$winLoss-=1;
	}
	
	public function __construct(Robot $a, Robot $b, Robot $c){
		$a->reset();
		$b->reset();
		$c->reset();
		$robotA=$a;
		$robotB=$b;
		$robotC=$c;
		$robotTeam[0]=$a;
		$robotTeam[1]=$b;
		$robotTeam[2]=$c;
		$ballOwner=$robotA;
	}
	
	//passes the ball to a random robot params: 
	//$not: what robot just passed the ball and therefore can't recieve
	/*-IMPORTANT- This method doesn't do anything to remove the ball from
	one robot, make sure that a robot has already passed a pass check BEFORE
	calling this method
	*/
	public function pass($not){//TODO:add some protection for bad calls
		if($not==$robotA)
			$ballOwner=(rand(0,1)<0.5 ? $robotB:$robotC);
		else if($not==$robotB)
			$ballOwner=(rand(0,1)<0.5 ? $robotA:$robotC);
		else if($not==$robotC)
			$ballOwner=(rand(0,1)<0.5 ? $robotA:$robotB);
	}
	
	//If it hasn't already been done and the robots are capable pass the ball over the truss 
	//$robot1 should be the passing robot and $robot2 the recieving
	public function passOverBar($robot1,$robot2){
		if(!$passedOver && $robot1->getPassOver() && $robot2->getCatchOver()){
			$passedOver=True;
			$ballHeat+=10;
			if(rand(0,1)<$robot2->getCatchProb())
				$ballHeat+=10;
		} else {
			pass($robot1);
		}
	}
	
	public function playAutonomous(){
		if($a->getAutonDrive())
			$score+=5;
		if($b->getAutonDrive())
			$score+=5;
		if($c->getAutonDrive())
			$score+=5;
			
		if($a->score())
			$score+=$a->$getAutonShoot();
		if($b->score())
			$score+=$b->$getAutonShoot();
		if($c->score())
			$score+=$c->$getAutonShoot();
	}
	
	public function getTickDefense(){
		if(strcmp($robotA->getTask(),"defend")==0){
			return $robotA->getDefended();
		}
		if(strcmp($robotB->getTask(),"defend")==0){
			return $robotB->getDefended();
		}
		if(strcmp($robotC->getTask(),"defend")==0){
			return $robotC->getDefended();
		}
	}
	
	//calls robot->tick() methods and does the other things in this decade
	//defended should be a reference
	public function tick($defended){
		if($robotA->tick($defended)!=0){
			$task=$robotA->getTask();
			if(strcmp($task,"pass")==0){
				passOverBar($robotA,$robotB);//TODO?:make this randomized
			}else if(strcmp($task,"shoot")==0){
				$score+=($robotA->getShoot()>=2 ? 10:1)+$ballHeat;
			}
		}
		if($robotB->tick($defended)!=0){
			$task=$robotB->getTask();
			if(strcmp($task,"pass")==0){
				passOverBar($robotB,$robotC);//TODO?:make this randomized
			}else if(strcmp($task,"shoot")==0){
				$score+=($robotB->getShoot()>=2 ? 10:1)+$ballHeat;
			}
		}
		if($robotC->tick($defended)!=0){
			$task=$robotC->getTask();
			if(strcmp($task,"pass")==0){
				passOverBar($robotC,$robotA);//TODO?:make this randomized
			}else if(strcmp($task,"shoot")==0){
				$score+=($robotC->getShoot()>=2 ? 10:1)+$ballHeat;
			}
		}
	}
	
	//Getter methods
	public function getRobots()
	{
		return $robotTeam;
	}
	
	public function getBallHeat(){//returns how many points a ball will yield if scored
		return $ballHeat;
	}
	
	public function getPassedOver(){//return whether the ball has been passed over the bar
		return $passedOver;
	}
	
	public function getScore(){
		return $score;
	}
	
	public function getWinLoss(){
		return $winLoss;
	}
}
?>
