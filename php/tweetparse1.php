<?php
function fmsDecode($tweet)//remember to change the regex pattern match to amend what fms standard changes
{
	$result = array();
	$names_buffer = array();
	$outputarray = array();
	$iii = 0;
	$result = preg_match('/#FRC([A-Za-z0-9]*) TY ([PQE]) MC ([0-9]{1,3}) RF ([0-9]{1,3}) BF ([0-9]{1,3}) RA ([0-9]{1,4}) ([0-9]{1,4}) ([0-9]{1,4}) BA ([0-9]{1,4}) ([0-9]{1,4}) ([0-9]{1,4}) RC ([0-9]{1,2}) BC ([0-9]{1,2}) RFP ([0-9]{1,2}) BFP ([0-9]{1,2}) RAS ([0-9]{1,2}) BAS ([0-9]{1,2}) RTS ([0-9]{1,3}) BTS ([0-9]{1,3})/', $tweet, $result,NULL);

	print_r ($result);
	
	return $outputarray;
}

print_r (fmsDecode("#FRCArchimedes TY Q MC 200 RF 320 BF 410 RA 1234 5678 8900 BA 1234 5678 8900 RC 10 BC 10 RFP 0 BFP 0 RAS 0 BAS 0 RTS 0 BTS 0"));
?>
