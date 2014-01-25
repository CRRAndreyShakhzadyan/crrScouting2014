<?php
class Alliance{
	const MISS_PENALTY=10;//how much time is deducted from a missed shot
	
	private $robotA=new Robot();
	private $robotB=new Robot();
	private $robotC=new Robot();
	
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
	

}
?>