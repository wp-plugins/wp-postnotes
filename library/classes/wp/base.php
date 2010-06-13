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
	function init($args)
	{
		require_once(ABSPATH.'/wp-admin/includes/admin.php');
		require_once(ABSPATH.'/wp-admin/includes/upgrade.php');
		add_action('init',array($this,'wp_init'));
		add_action('plugins_loaded',array($this,'plugins_loaded'));
	}

	function plugins_loaded()
	{
		foreach((array)$this->init_args as $arg)
		{
			$this->loadClass($arg);
		}
	}
	function wp_init()
	{
		load_plugin_textdomain($this->domain,PLUGINDIR.DIRECTORY_SEPARATOR.basename($this->projectFile).DIRECTORY_SEPARATOR.'languages');
	}
}

?>