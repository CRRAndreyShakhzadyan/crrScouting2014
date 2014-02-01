<?php

class Match
{	
	const TICK_TIME=5;
	private $a = new Alliance();
	private $a = new Alliance();
	
	private $maxDefense;//TODO!:move this to whatever new managment class we make and have it find the max average defense or the max defense	
	private $timeLeft = 140;
	
	
	public function _construct(Alliance $a1, Alliance $b1)
	{
		this->$a=$a1;
		this->$b=$b1;
		
	}

	
	
	public function playGame(Alliance $other){
		$a->playAutonomous();
		$b->playAutonomous();
		
		while($timeLeft>0){
			$aDefend=$a->getDefense();
			$bDefend=$b->getDefense();
			$a->tick($bDefend);//swap them so that $a plays against the $b defense
			$b->tick($aDefend);
		}
		
		//This massive block of code is just the old alliance playGame() method
		/*if($a->getAutonDrive())
			$score+=5;
		if($b->getAutonDrive())
			$score+=5;
		if($c->getAutonDrive())
			$score+=5;
			
		if($a->score())
			$score+=$getAutonShoot();
		if($b->score())
			$score+=$getAutonShoot();
		if($c->score())
			$score+=$getAutonShoot();
		while($a->hasBall() || $b->hasBall() || $c->hasBall()){
			if($a->hasBall()){
				$a->score();
			}else if($b->hasBall()){
				$b->score();
			}else if($c->hasBall()){
				$c->score();
			}
			if($a->getPassSpeed()
		}
		
		$random=floor(rand(0,3));
		if($random==0){
			$a->giveBall();//TODO: Make the reset method correspond with giving the ball back or something
			$ballOwner=$a;
		}else if($random==1){
			$b->giveBall();
			$ballOwner=$b;
		}else{
			$c->giveBall();
			$ballOwner=$c;
		}
		public function giveBall(){ //gives the ball to the robots
		$hasBall = True;*/
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
	
	public function m_tick($tick_duration)
	{
		$timeleft -= $tick_duration;
		Robot->tick();
		Alliance-tick();
	}
	
		
	}
