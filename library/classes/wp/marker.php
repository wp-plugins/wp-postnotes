<?php
class dc_wp_marker_1_0_0 extends dc_base_1_0_2 {
	var $marker = '';
	var $callback = null;
	function config($marker,$callback) {
		$this->marker = $marker;
		$this->callback = $callback;
		add_filter('the_content', array($this,'match_marker'),1);	
	}
	function match_marker($content)
	{
		$t = $this->loadClass('tag');
		$matches = $t->get($this->marker,$content,true);
		foreach($matches as $match) {
			$content=call_user_func($this->callback,$content,$match);			
		}
		return $content;
	}
}

?>