<?php
/*
Plugin Name: WP_PostNotes
Plugin URI: http://www.dcoda.co.uk/index.php/downloads/wordpress/wp_postnotes/
Description: WP_PostnNotes allows you to add private note to a post that will only be viewable by the author or named users.
Author: DCoda Ltd
Author URI: http://www.dcoda.co.uk
Version: 2.5.0
*/
require_once(dirname(__FILE__).'/library/classes/base.php');
class DCodaPostNotes extends dc_base_1_0_2  {
	function init()
	{
		$this->loadClass('postnotes');
	}
}
new DCodaPostNotes();
?>
