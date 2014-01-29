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
