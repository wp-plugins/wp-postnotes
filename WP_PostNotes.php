<?php
/*
Plugin Name: WP_PostNotes
Plugin URI: http://www.dcoda.co.uk/index.php/downloads/wordpress/wp_postnotes/
Description: WP-PostnNotes allows you to add notes to a post that will only be viewable when editing.
Author: DCoda Ltd
Author URI: http://www.dcoda.co.uk
Version: 2.0
*/

require_once('DCodaBase.php');

class DCodaPostNotes extends DCodaBaseV1_1
{
	function filter($content)
	{
		$pattern="|<!--\s*postnote\s*-->([\w\W\s\S]*)<!--\s*\/postnote\s*-->|Ui";
 		$do=preg_match_all($pattern,$content,$matches,PREG_SET_ORDER);
 		foreach($matches as $match)
 		{
			$content=str_replace($match[0],'',$content);
 		}
 		return $content;
	}
}
new DCodaPostNotes();
?>
