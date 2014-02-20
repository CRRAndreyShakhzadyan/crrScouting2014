<?php
class Match
{	
	const TICK_TIME=5;
	private $a;
	private $b;
	
	private $maxDefense;//TODO!:move this to whatever new managment class we make and have it find the max average defense or the max defense	
	private $timeLeft = 140;
	
	
	public function _construct(Alliance $a1, Alliance $b1)
	{
		$a=$a1;
		$b=$b1;
	}

	
	
	public function playGame(){
		$a->playAutonomous();
		$b->playAutonomous();
		
		while($timeLeft>0){
			$aDefend=$a->getDefense();
			$bDefend=$b->getDefense();
			$a->tick($bDefend);//swap them so that $a plays against the $b defense
			$b->tick($aDefend);
		}
		
		if($a->getScore()>$b->getScore()){
			$a->placeMatch(true);
			$b->placeMatch(false);
		} else if($a->getScore()<$b->getScore()) {
			$a->placeMatch(false);
			$b->placeMatch(true);
		} else {//
			$a->placeMatch(-1);
			$b->placeMatch(-1);
		}
	}
	
	//receives a ball, returns 1=recieved,2=recieved over bar
	public function recieve(){
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
	
	//The tick method basically just decrements time and does this for everything else
	public function m_tick($tick_duration)
	{
		$timeleft -= $tick_duration;
		$a->tick();
		$b->tick();
	}
}
?>