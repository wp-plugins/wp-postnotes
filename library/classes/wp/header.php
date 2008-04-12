<?php
class dc_wp_header_1_0_0 extends dc_base_1_0_2 {
	function init() {
	}
	function config($blog=true,$login=false,$admin=false)
	{
		if ($blog)
		{
			add_action('wp_head', $this->callback);		
		}
		if ($login)
		{
			add_action('login_head', $this->callback);		
		}
		if ($admin)
		{
			add_action('admin_head', $this->callback);		
		}
	}
}
?>