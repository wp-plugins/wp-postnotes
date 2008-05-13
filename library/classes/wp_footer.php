<?php
$_dc_class_name = 'dc_wp_footer_1_0_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_footer_1_0_0 extends dc_base_1_0_1 {
		function init() {
			add_action('wp_footer', $this->callback);
		}
	}
}
?>