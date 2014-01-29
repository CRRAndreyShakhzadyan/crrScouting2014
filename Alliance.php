<?php
class Alliance{
	const MISS_PENALTY=10;//how much time is deducted from a missed shot
	
	private $robotA=new Robot();
	private $robotB=new Robot();
	private $robotC=new Robot();
	
	private $ballHeat=0;
	private $score=0;
	private $passedOver=false;
	
	private $robotTeam = array($robotA,$robotB,$robotC);
	
	public function __construct(Robot $a, Robot $b, Robot $c){
		this->$robotA=$a;
		this->$robotB=$b;
		this->$robotC=$c;
		$a->reset();
		$b->reset();
		$c->reset();
	}
	//Simulation Methods
	public function passOverBar(){//If it hasn't already been pass the ball over the bar (if it has pass it regularly)
	if(!$passedOver){
		$passedOver=True;
		$ballHeat+=10;
		
	} else {
		pass();
	}
	}
	
	public function pass(){//add the score to the ball heat for passing the ball over
		$ballHeat+=10;
	}
	
	public function goal($high){//scores the ball, whether the ball was scored high
		if($high){
			$score+=(10+$ballHeat);
		}else{
			$score+=(1+$ballHeat);
		}
	}
	
	public function getBallHeat(){//returns how many points a ball will yield if scored
		return $ballHeat;
	}
	
	public function getPassedOver(){//return whether the ball has been passed over the bar
		return $passedOver;
	}
	
	public function setTask($myTask){//valid tasks are "defend","shoot", and "pass"
		$task=$myTtask
	}
	
	public function recieve(){//receives a ball, returns 1=recieved,2=recieved over bar
		if(rand(0,1)<=$catchProb){
			$hasBall = True;
			if(rand(0,1)<=$catchProb){//smaller probability for passes over bar
				return 2;
			}else{
				return 1;
			}
		}
		return 0;
	}
		public function giveBall(){ //gives the ball to the robots
		$hasBall = True;
	}
	
	public function setTask($myTask){//valid tasks are "defend","shoot", and "pass"
		$task=$myTtask
	}
	//Getter methods
	public function getRobots()
	{
		return $robotTeam;
	}
	
	//passes the ball to a random robot params: 
	//$not: what robot just passed the ball and therefore can't recieve
	/*-IMPORTANT- This method doesn't do anything to remove the ball from
	one robot, make sure that a robot has already passed a pass check BEFORE
	calling this method
	*/
	public function pass($not){//TODO:add some protection for bad calls
		
	}
	
	//calls robot->tick() methods and does the other things in this decade
	public function tick(){
		if($robotA->tick()){
			$task=$robotA->getTask()
			if(strcmp($task,"pass")==0){
				pass();
			}else(strcmp($task,"shoot")==0){
				
			}
		}
	}
}
//we choose to go to the moon
?>
