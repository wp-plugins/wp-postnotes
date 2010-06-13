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
	function implode($array)
	{
		$insert = '';
		$return = '';
		foreach (array_keys($array) as $key)
		{
			$return .= $insert;
			if(is_null($array[$key]))
			{
				$return .= $key;
			}
			else
			{
				$return .= $key."=".$array[$key];
			}
			$insert = "&";
		}
		return $return;
	}
}
?>