<?php
echo '<html>
<head>
<title>Match Scouting Results</title>
</head>

<link href="../css/default.css" type="text/css" rel = "stylesheet">
<div class = "formb1">
<body>
<a href="../index.html"><img src="../assets/Scouting4.png" alt="Scouting4.png" width="639" height="200"></a>
<h1>Match Results Per Robot</h1>';//TODO:update copied code

$con=mysqli_connect("localhost","root","","scouting_database");

// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//Gather the actual data FROM ROBOTS                                  
//TODO: ? restrict to only the needed values
$result=mysqli_query($con,"SELECT * FROM robot_attributes");

//Here we get ready to print out a table
$print="<table class='display'><tr> <th>team</th> <th>drive train</th> <th>passing/scoring mechanism</th> <th>catching mechanism</th> <th>defensive capabilities</th></tr>";

//Gos through every row and places information in the table
while($row = mysqli_fetch_array($result)){
	$print=$print."<tr><td>".$row['team'].
	"</td><td>type:".$row['drive_type']." speed:".$row['drive_speed']." pushiness:".$row['drive_push'].
	"</td><td>pass method:".$row['pass_method']." compatability:".$row['pass_comp'].
	"</td><td> catcher:".$row['catcher']." truss catcher".$row['truss_catch'].
	"</td><td> block ability:".$rows['block_ability']." block type:".$rows['block_mech']."</td></tr>";//TODO:check over everything here and make sure columns correspond
}
$print=$print."</table>";
echo $print;
?>
