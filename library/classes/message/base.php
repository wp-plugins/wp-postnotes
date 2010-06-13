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
	function warning($text,$title="")
	{
		$page=$this->loadHTML('message');
		$page=str_replace('@@color@@','#EFC2C2',$page);
		if($title=="")
		{
			$page=str_replace('<legend>@@title@@</legend>','',$page);
		}
		else
		{
			$page=str_replace('@@title@@',$title,$page);
		}
		$page=str_replace('@@message@@',$text,$page);
		return $page;
	}
}
?>