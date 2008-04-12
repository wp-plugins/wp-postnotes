<?php
class dc_form_1_0_0 {
	function checked($value)
	{
		if (isset($value))	
		{
			return " checked = checked ";
		}
		return "";
	}
}
?>