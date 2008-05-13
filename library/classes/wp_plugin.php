<?php
$_dc_class_name = 'dc_wp_plugin_1_0_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_plugin_1_0_0 extends dc_base_1_0_1 {
		
		function init() {
			add_action('plugins_loaded', $this->callback);	
		}

		// 		print_r (get_option('active_plugins'));

		function details($filename = null)
		{
			$file = $this->load_class('file');
			if(is_null($filename))
			{
				$filename = $this->project_file;
			}
			$pattern = "|(.*):(.*)|i";
			$content = $file->get($filename);
			preg_match_all($pattern,$content,$matches,PREG_SET_ORDER);
			$return = null;
			foreach((array)$matches as $match)
			{
				$key = trim($match[1]);
				$key = strtolower($key);
				$return[$key] = trim($match[2]);
			}
			$return['plugin path'] = $filename;
			return $return;
		}
		
		function folder()
		{
			return ABSPATH.PLUGINDIR.DIRECTORY_SEPARATOR;
		}
		function plugins()
		{
			foreach((array)get_option('active_plugins') as $plugin)
			{
				print_r($this->details($this->folder().$plugin));
			}
		}
	}
}

?>