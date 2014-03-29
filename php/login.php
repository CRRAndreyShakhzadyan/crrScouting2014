<?php

if(isset($_POST["pass"])){
	$r=rand(0,1);
	
	if( ($r==0 && md5($_POST["pass"])=="7e843964cca0fe3c3adc1d3f8605554b") || ($r==1 && sha1($_POST["pass"])=="92f5d9410b62c8a35da15d64cacce9db13d15277") ){
		setcookie("enter_data","true",0,"/");
		echo "You are now logged in.";
	}else{
		setcookie("enter_data","true",0,"/");
		echo "Incorrect pass phrase";
	}
}else{
	echo "Please enter a valid pass phrase";
}

echo "<br>cookies:".$_COOKIE["enter_data"];
?>