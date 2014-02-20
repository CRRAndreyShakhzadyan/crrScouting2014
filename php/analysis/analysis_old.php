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

$m=new Main();
?>