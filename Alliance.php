<?php
class Alliance{
	const MISS_PENALTY=10;//how much time is deducted from a missed shot
	
	private $a=new Robot();
	private $b=new Robot();
	private $c=new Robot();
	
	$ballOwner=NULL;
	
	private $timeLeft = 140;
	private $ballHeat = 0;//represents how many points a ball will yield if scored
	private $score = 0;
	private $passedOver = False;//represents whether the ball has already been passed over the bar
	
	public function __construct(Robot $a, Robot $b, Robot $c){
		this->$a=$a;
		this->$b=$b;
		this->$c=$c;
		$a->reset();
		$b->reset();
		$c->reset();
	}
	
	public function passOverBar(){//If it hasn't already been pass the ball over the bar (if it has pass it regularly)
		if(!$passedOver){
			$passedOver=True;
			$ballHeat+=20;
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
	
	public function playGame(Alliance $other){
		if($a->getAutonDrive())
			$score+=5;
		if($b->getAutonDrive())
			$score+=5;
		if($c->getAutonDrive())
			$score+=5
			
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
		
		$random=floor(rand(0,3));
	}
}
?>