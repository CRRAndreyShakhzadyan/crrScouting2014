<?php
function fmsDecode($tweet)//remember to change the regex pattern match to amend what fms standard changes
{
	$names_buffer = array();
	$outputarray = array();
	$increasemar = 1;
	$iii = 1;
	$jjj = 1;
	
	preg_match('/^#FRC([A-Za-z0-9]*) TY ([PQE]) MC ([0-9]{1,3}) RF ([0-9]{1,3}) BF ([0-9]{1,3}) RA ([0-9]{1,4}) ([0-9]{1,4}) ([0-9]{1,4}) BA ([0-9]{1,4}) ([0-9]{1,4}) ([0-9]{1,4}) RC ([0-9]{1,2}) BC ([0-9]{1,2}) RFP ([0-9]{1,2}) BFP ([0-9]{1,2}) RAS ([0-9]{1,2}) BAS ([0-9]{1,2}) RTS ([0-9]{1,3}) BTS ([0-9]{1,3})/', $tweet, $result,NULL);
	preg_match('/#FRC[A-Za-z0-9]* (TY) [PQE] (MC) [0-9]{1,3} (RF) [0-9]{1,3} (BF) [0-9]{1,3} (RA) [0-9]{1,4} [0-9]{1,4} [0-9]{1,4} (BA) [0-9]{1,4} [0-9]{1,4} [0-9]{1,4} (RC) [0-9]{1,2} (BC) [0-9]{1,2} (RFP) [0-9]{1,2} (BFP) [0-9]{1,2} (RAS) [0-9]{1,2} (BAS) [0-9]{1,2} (RTS) [0-9]{1,3} (BTS) [0-9]{1,3}/',$tweet, $names_buffer, NULL);
	unset($result[0]);
	unset($names_buffer[0]);

	// if(is_array($result))
	// {
		for($iii;$iii < (count($result)-2);$iii++)
		{
			
			if($iii == 1)
			{
				$outputarray["competition"] = $result[1];
			}
			if(strcmp($names_buffer[$jjj], "RA") == 0)
			{
				$names_buffer["RA1"] = $result[$iii];
				$names_buffer["RA2"] = $result[$iii+1];
				$names_buffer["RA3"] = $result[$iii+2];
				$iii += 3;
	
			}
			if(strcmp($names_buffer[$jjj], "BA" )== 0)
			{
				$names_buffer["BA1"] = $result[$iii];
				$names_buffer["BA2"] = $result[$iii+1];
				$names_buffer["BA3"] = $result[$iii+2];
				$iii+=3;

			}
			if($jjj =! 1)
			{
				$outputarray[ $names_buffer[$jjj] ] = $result[$iii];
				$jjj++;
			}
		}
	// }
	return $outputarray;
}

print_r(fmsDecode("#FRCArchimedes TY Q MC 200 RF 320 BF 410 RA 1234 5678 8900 BA 1234 5678 8900 RC 10 BC 10 RFP 0 BFP 0 RAS 0 BAS 0 RTS 0 BTS 0"));
?>