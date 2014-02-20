<?php
echo '<html>
<head>
<title>Match Scouting Results</title>
</head>

<link href="../css/default.css" type="text/css" rel = "stylesheet">
<div class = "formb1">
<body>
<a href="../index.html"><img src="../assets/Scouting4.png" alt="Scouting4.png" width="639" height="200"></a>
<h1>Results Per Robot</h1>';//TODO:update copied code

$con=mysqli_connect("localhost","root","","scouting_database");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Gather the actual data FROM ROBOTS                                  
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM robot_data");

//$print="<table class='display'><tr> <th>team</th> <th>drive train</th> <th>passing/scoring mechanism</th> <th>catching mechanism</th> <th>defensive capabilities</th></tr>";
$print="";
while($row = mysqli_fetch_array($result)){
	$print=$print."<h2>".$row['team']."</h2><object data='../graphs/team".$row['team'].".jpg'><object data='../graphs/team".$row['team'].".jpeg'><img src='../assets/default.png'></img></object></object>".
	"</br><h3>Drive Train:</h3>".$row['drive'].
	"<h3>Passing/Scoring:</h3>".$row['pass'].
	"<h3>Catcher:</h3>".($row['catcher']==1 ? ($row['truss_catch']==1 ? "can catch from truss" : "cannot catch from truss") : "cannot catch").
	"<h3>Defensive Capability:</h3>".$row['block']."</br><hr />";
}
echo $print;
?>