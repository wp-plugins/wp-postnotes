<?php
/*
Plugin Name: WP_PostNotes
Plugin URI: http://www.dcoda.co.uk
Description: WP_PostnNotes allows you to add notes to a post that will only be viewable when editing.
Author: DCoda Ltd
Author URI: http://www.dcoda.co.uk
Version: 1.0
*/

add_filter('the_content','DCoda_WP_PostNotes');

function DCoda_WP_PostNotes($post)
{
 $pattern="|<!--\s*postnote\s*-->([\w\W\s\S]*)<!--\s*\/postnote\s*-->|Ui";
 $do=preg_match_all($pattern,$post,$matches,PREG_SET_ORDER);
 foreach($matches as $match)
 {
	$post=str_replace($match[0],'',$post);
 }
 return $post;
}
?>
