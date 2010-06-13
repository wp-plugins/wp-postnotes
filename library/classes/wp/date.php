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
	function gmtToTimezone($date)
	{
		return $date+(get_option('gmt_offset')*60*60);
	}
}