<?php
class dc_date_1_0_0 extends dc_base_1_0_2 {
	function stumble($date)
	{
		return strtotime($date);
	}
	function delicious($date)
	{
		$timestr = str_replace("Z","",str_replace("T"," ",$date));
		return strtotime($timestr);
		
	}
	function digg($date)
	{
	}
}
?>