<?php
$_dc_class_name = 'dc_wp_options_1_0_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_options_1_0_0 extends dc_base_1_0_1 {

		var $values = array();
		var $_name = null;

		function init() {
			$this->load();
		}
		function save()
		{
			update_option(get_class($this->project_class), $this->values);
		}
		function load($name = null)
		{
			if (is_null($name)) {
				$name = get_class($this->project_class);
			}
			$this->values=get_option($name);
		}
		function field_prefix()
		{
			return get_class($this->project_class).'_';
		}
		function merge($array)
		{
			if(count($array)>0)
			{
				foreach(array_keys($_POST) as $key)
				{
					if(strpos($key,$this->field_prefix())===0)
					{
						$newkey = substr($key,strlen($this->field_prefix()));
						$this->values[$newkey] = $array[$key];
					}
				}
				foreach(array_keys($this->values) as $key)
				{
					if($this->values[$key] == 'checked=checked')
					{
						if (!array_key_exists($this->field_prefix().$key,$array))
						{					
							$this->values[$key] = '';
						}
					}
				}
				$this->save();
			}
		}
		function prepare($content)
		{
			$content = str_replace('@@field_prefix@@',$this->field_prefix(),$content);
			foreach(array_keys($this->values) as $key)
			{
				$content = str_replace("@@$key@@",$this->values[$key],$content);
			}
			return $content;
		}
	}
}
?>