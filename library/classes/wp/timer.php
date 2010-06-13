<?php
/*
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
?>
<?php
class dcLoadableClass extends dcbase7 {
	var $startTime = 0;
	var $array="";
	function timeout($start=false,$array="")
	{
		$o=$this->loadClass('wp_options');
		if($start)
		{
			$this->startTime = microtime(true);
			$this->array=$array;
		}
		return ((microtime(true)-$this->startTime)>$o->values[$this->array]['#timeout']);
	}
	function checkTimer($timeout,$array,$callback=array())
	{
		$o=$this->loadClass('wp_options');
		if ($timeout == '0' || ($o->values[$array]['#timer']+$timeout)<time())
		{
			$o->values[$array]['#timer'] = time();
			$o->save();
			call_user_func($callback);
		}
	}
}
?>
