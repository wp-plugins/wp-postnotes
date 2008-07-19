<?php
/*
Plugin Name: WP_PostNotes
Plugin URI: http://www.dcoda.co.uk/index.php/tag/wp_postnotes/
Description: WP_PostnNotes allows you to add private note to a post that will only be viewable by the author or named users.
Author: DCoda Ltd
Author URI: http://www.dcoda.co.uk
Version: 2.6.0
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
require_once(dirname(__FILE__).'/library/classes/base.php');
class wp_postnotes extends dcbase7  {}
new wp_postnotes(__FILE__,'wp','postnotes');
?>
