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
	function checked($value,$checked="on")
	{
		if (strtolower($value)==strtolower($checked))
		{
			return " checked = checked ";
		}
		return "";
	}
	function encode_array($array)
	{
		return base64_encode(htmlentities(serialize($array)));
	}
	function decode_array($string)
	{
		$array=base64_decode($string);
		$array=html_entity_decode($array);
		$array=stripcslashes($array);
		$array=unserialize($array);
		return $array;
	}
	function options($list,$select=null)
	{
		$return = "";
		foreach(array_keys((array)$list) as $key)
		{
			$selected = "";
			if ($key==$select)
			{
				$selected = " selected = selected ";
			}
			$return .= "<option ".$selected." value = '".$key."'>".$list[$key]."</option>";
		}
		return $return;
	}
}
?>