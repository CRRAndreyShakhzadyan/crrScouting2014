<?php


class Main
{
	private $robot = array(new Robot
	public function _construct()
	{
		$con=mysqli_connect("localhost","root","","scouting_database");
		mysql_select_db("scouting");
		$result_match=mysqli_query($con,"SELECT * FROM 'match_data'");
		
		while($i = mysql_fetch_array($result_match, MYSQL_ASSOC))
		{
			
			
	
	}
?>