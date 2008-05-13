<?php
$_dc_class_name = 'dc_wp_dashboard_1_2_0';
if (!class_exists($_dc_class_name)) {
	require_once(dirname(dirname(__FILE__)).'/base.php');
	class dc_wp_dashboard_1_2_0 extends dc_base_1_0_1 {
// -- DashBoard stuff ----------------------------------------------------------------------------------------------------------------
		function init() {
			add_action('admin_menu', Array(&$this,'init_dashboard'));
		}
		
		function add_page($page_title,$menu_title,$callback) {
			global $menu;
			$Page = "";
			foreach((array)$menu as $menu_item)
			{
				if ($menu_item[0] == $page_title)
				{
					$Page = $menu_item[2];
					break;
				}
				
			}		
			if ($Page == "")
			{
				$Page = $menu_title;
				add_menu_page($menu_title, $page_title, 8,$Page,$callback);
			}
			add_submenu_page($Page,$page_title,$menu_title,8,$menu_title, $callback);
		}
		function init_dashboard() {
			call_user_func_array($this->callback,array());
		}
		function test()
		{
			return $this->debug->test($this);
		}
		function template($title="",$content="",$options=null,$submit = 'Submit Options')
		{
			$html = $this->load_class('phtml');

			$return = $html->load('dashboard_template');
			$return = str_replace('@@title@@',$title,$return);
			$return = str_replace('@@content@@',$content,$return);
			$return = str_replace('@@prefix@@',$this->field_prefix(),$return);
			$return = str_replace('@@submit_options@@',$submit,$return);

			foreach(array_keys((array)$options) as $key)
			{
				$return = str_replace('@@'.$key.'@@',$options[$key],$return);
			}

			echo $return;
		}
		function field_prefix()
		{
			return get_class($this->project_class).'_';
		}
	}	
}
?>