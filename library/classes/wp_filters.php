<?php
$_dc_class_name = 'dc_wp_filters_1_0_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_filters_1_0_0 extends dc_base_1_0_1 {
		function prepare($content)
		{
			$content = str_replace("@@post_title@@",get_the_title(),$content);
			$content = str_replace("@@post_url@@",get_the_guid(),$content);
			return $content;
		}
	}
}
?>