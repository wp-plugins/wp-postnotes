<?php
/*
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
?>
<?php
class dcLoadableClass extends dcbase7 {
// -- DashBoard stuff ----------------------------------------------------------------------------------------------------------------
	var $callback=null;
	function init($args) {
		$this->callback=$args;
		add_action('admin_menu', Array(&$this,'init_dashboard'));
	}

	function add_page($page_title,$menu_title,$callback) {
		global $menu;
		global $wp_version;
		switch($page_title)
		{
			case 'Manage':
			case 'Content':
				add_management_page($page_title,$menu_title,8,$menu_title, $callback);
				break;
			case 'Templates':
			case 'Design':
			case 'Presentation':
				add_theme_page($page_title,$menu_title,8,$menu_title, $callback);
				break;
			case 'Settings':
			case 'Utilities':
			case 'Options':
				add_options_page($page_title,$menu_title,8,$menu_title, $callback);
				break;
			default:
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
	}
	function init_dashboard() {
		call_user_func_array($this->callback,array());
	}
	function template($title="",$content="",$options=null,$submit = null,$display=true,$saved=null,$submenu=null)
	{
		//class="wp-first-item current
		if(is_null($submit))
		{
			$submit=__('Save Settings',$this->domain);
		}
		if(is_null($saved))
		{
			$saved=__('Settings Saved',$this->domain);
		}
		$submenuhtml="";
		if(!is_null($submenu))
		{
			$submenuhtml=$this->loadHTML('wp_dashboard_submenu');
			$sub="";
			$newitem=$this->loadHTML('wp_dashboard_submenuitem');
			$class="wp-first-item";
			if(empty($_GET['subpage']))
			{
				$class.=" current";
			}
			foreach($submenu as $item)
			{
				$sub.=$newitem;
				if($_GET['subpage']==$item)
				{
					$class=trim($class." current");
				}
				$sub=str_replace("@@class@@",$class,$sub);
				$sub=str_replace("@@title@@",$item,$sub);
				$class="";
			}
			$submenuhtml=str_replace("@@submenu@@",$sub,$submenuhtml);
		}
		$return = $this->loadHTML('wp_dashboard_template');
		if ($display)
		{
			$return = str_replace('@@display@@',"",$return);
		}
		else
		{
			$return = str_replace('@@display@@'," style='display:none' ",$return);
			$return = str_replace("form method='post'","div",$return);
			$return = str_replace('form',"div",$return);
		}
		$return = str_replace('@@title@@',$title,$return);
		$return = str_replace('@@content@@',$content,$return);
		$return = str_replace('@@submenu@@',$submenuhtml,$return);
		if ($_POST)
		{
			$return = str_replace('@@display_saved@@',"",$return);
		}
		else
		{
			$return = str_replace('@@display_saved@@'," style='display:none' ",$return);
		}
		$return = str_replace('@@prefix@@',$this->field_prefix(),$return);
		$return = str_replace('@@submit_options@@',$submit,$return);
		$return = str_replace('@@saved@@',$saved,$return);
			foreach(array_keys((array)$options) as $key)
		{
			$return = str_replace('@@'.$key.'@@',$options[$key],$return);
		}
			echo $return;
	}
	function field_prefix()
	{
		return $this->projectClass.'_';
	}
}
?>