<?php
$_dc_class_name = 'dc_wp_marker_1_0_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_marker_1_0_0 extends dc_base_1_0_1 {
		var $marker = '';
		var $callback = null;
		function config($marker,$callback) {
			$this->marker = $marker;
			$this->callback = $callback;
			add_filter('the_content', array($this,'match_marker'),1);	
		}
		function match_marker($content)
		{
			$retval=array();
			$pattern='|<!--\s*'.$this->marker.'\s*.*-->([\w\W\s\S]*)<!--\s*\/'.$this->marker.'\s*-->|Ui';
			preg_match_all($pattern,$content,$matches,PREG_SET_ORDER);
			$cnt=0;
			foreach((array)$matches as $match)
			{
				$retval[$cnt]['content']=trim($match[1]);
				$cnt++;
			}
			$pattern='|<!--\s*'.$this->marker.'\s*(.*)\s*-->|Ui';
			$spattern='|\s*(.*)\s*=\s*"(.*)"\s*|Ui';
			preg_match_all($pattern,$content,$matches,PREG_SET_ORDER);
			$cnt=0;
			foreach((array)$matches as $match)
			{
				$retval[$cnt]['match']=trim($match[0]);
				$retval[$cnt]['attribute']=array();
				preg_match_all($spattern,$match[1],$smatches,PREG_SET_ORDER);
				$attrib="";
				foreach ((array)$smatches as $smatch)
				{
					$retval[$cnt]['attribute'][strtolower(trim($smatch[1]))] = trim($smatch[2]);
				}
				$cnt++;
			}
			foreach($retval as $match) {
				$content=call_user_func($this->callback,$content,$match);			
			}
			return $content;;
		}

	}
}
?>