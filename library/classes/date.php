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
	function stumble($date)
	{
		return strtotime($date);
	}
	/**
	 * convert internal datetime w3c standard format
	 *
	 * @param string $date, date to convert
	 * @param string $zone, offset for timezon '+hh:mm','-hh:mm' or 'Z' for gmt
	 * @return formatted date
	 */
	function toW3c($date,$zone="Z")
	{
		return date('Y-m-d',$date).'T'.date('H:i:s',$date).'.00'.$zone;
	}
	function digg($date)
	{
	}
}
?>