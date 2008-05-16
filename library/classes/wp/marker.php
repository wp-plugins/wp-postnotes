<?php
class dc_wp_marker_1_1_0 extends dc_base_2_2_0 {
	var $marker = '';
	var $callback = null;
	function config($marker,$callback,$priority=1) {
		$this->marker = $marker;
		$this->callback = $callback;
		add_filter('the_content', array($this,'match_marker'),$priority);	
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