<?php
/*
Plugin Name: WP_PostNotes
Plugin URI: http://www.dcoda.co.uk/index.php/downloads/wordpress/wp_postnotes/
Description: WP_PostnNotes allows you to add private note to a post that will only be viewable by the author or named users.
Author: DCoda Ltd
Author URI: http://www.dcoda.co.uk
Version: 2.5.1
*/
require_once(dirname(__FILE__).'/library/classes/base.php');
class DCodaPostNotes extends dc_base_2_1_0  {
	function init()
	{
		$this->setPath(__FILE__);
		$this->loadClass('postnotes');
	}
}
new DCodaPostNotes();
?>
