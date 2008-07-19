<?php
/*
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
?>
<?php
class dcLoadableClass extends dc_base_1_0_1 {
	var $max_widgets = 20;
	function init()
	{
		add_action('widgets_init',$this->callback);
	}
	function remove_default_widget($name)
	{
		if(function_exists('unregister_sidebar_widget'))
		{
			switch (strtolower($name))
			{
				case 'archives':
					unregister_sidebar_widget('Archives');
					break;
				case 'calendar':
					unregister_sidebar_widget('Calendar');
					break;
				case 'categories':
					unregister_sidebar_widget('Categories 1');
					remove_action('sidebar_admin_setup','wp_widget_categories_setup');
					remove_action('sidebar_admin_page','wp_widget_categories_page');
					break;
				case 'links':
					unregister_sidebar_widget('Links');
					break;
				case 'meta':
					unregister_sidebar_widget('Meta');
					break;
				case 'pages':
					unregister_sidebar_widget('Pages');
					break;
				case 'recent_comments':
					unregister_sidebar_widget('Recent Comments');
					break;
				case 'recent_posts':
					unregister_sidebar_widget('Recent Posts');
					break;
				case 'search':
					unregister_sidebar_widget('Search');
				break;
					case 'rss':
					unregister_sidebar_widget('RSS 1');
					remove_action('sidebar_admin_setup','wp_widget_rss_setup');
					remove_action('sidebar_admin_page','wp_widget_rss_page');
					break;
				case 'tag_cloud':
					unregister_sidebar_widget('Tag_Cloud');
					break;
				case 'text':
					unregister_sidebar_widget('Text 1');
					remove_action('sidebar_admin_setup','wp_widget_text_setup');
					remove_action('sidebar_admin_page','wp_widget_text_page');
					break;
			}
		}
	}
	var $widgetDims=null;

	var $Name = '';
	var $widget_callback = null;
	var $options_callback = null;
	var $has_options = null;
	function config($name,$callback,$options_callback = null,$dims = null)
	{
		$this->Name = $name;
		if (is_null($dims)) {
			$this->widgetDims = array('width' => 460, 'height' => 65);
		} else {
			$this->widgetDims = array('width' => $dims[0], 'height' => $dims[1]);
		}
		$this->widget_callback = $callback;
		$this->options_callback = $options_callback;

		$this->register();

		add_action('sidebar_admin_setup', array(&$this,'setup'));
		add_action('sidebar_admin_page', array($this,'WidgetCount'));



	}
		function register()
	{
		$o = $this->load_class('wp_options');
		$number = $o->values[$this->Name]['info']['count'];
		if ($number=='') {
			$number = 1;
		}
		for ($cnt=1;$cnt<=$this->max_widgets;$cnt++)
		{
			$wName = $this->Name;
			if ($cnt>1)
			{
				$wName = "$this->Name $cnt";
			}
			wp_register_sidebar_widget($wName,$wName,$cnt<=$number?array($this,'widget'):null,'',$cnt-1);
			if (!is_null($this->options_callback))
			{
				wp_register_widget_control($wName,$wName,$cnt<=$number?array($this,'options'):null,$this->widgetDims,$cnt-1);
			}
		}

	}

	function setup()
	{
		$o = $this->load_class('wp_options');
		$r = $this->load_class('request');
		//$o->values[$this->Name] = null;
		if($r->is_request()) {
			$data = $r->get_data($this->field_prefix());
			$o->values[$this->Name] = array_merge($o->values[$this->Name],$data);
			//echo $this->debug->test($o->values);
		$o->save();
			}
	$this->register();
	}
	function widget($args,$number=1)
	{
		extract($args);
		$o = $this->load_class('wp_options');
		$title = $o->values[$this->Name]['widget'.$number]['title'];
		echo $before_widget;
		if ($title!="") {
			echo $before_title;
			echo "$title";
			echo $after_title;
		}
		echo call_user_func_array($this->widget_callback,$number);
		echo $after_widget;
	}
	function options($number)
	{
	$o = $this->load_class('wp_options');
			$title = $o->values[$this->Name]['widget'.$number]['title'];
		$h = $this->load_class('phtml');
		$page = $h->load('widget_options_template');
		$page = str_replace("@@content@@",call_user_func_array($this->options_callback,$number),$page);
		$page = str_replace("@@prefix@@",$this->field_prefix(),$page);
		$page = str_replace("@@number@@",$number,$page);
		$page = str_replace("@@name@@",$this->Name,$page);
		$page = str_replace("@@title@@",$title,$page);
		echo $page;
	}
		function widgetCount()
	{
		$o = $this->load_class('wp_options');
		$number = $o->values[$this->Name]['info']['count'];
		$h = $this->load_class('phtml');
		$page = $h->load('widgetcount_template');
		$content = "";
		for ( $i = 1; $i <= $this->max_widgets ;++$i )
		{
			$content .= $h->load('widgetcount_options_template');
			$content = str_replace('@@cnt@@',$i,$content);
			$selected = "";
			if ($number==$i)
			{
				$selected = " selected='selected'";
			}
			$content = str_replace('@@selected@@',$selected,$content);
		}
		$page = str_replace('@@name@@',$this->Name,$page);
		$page = str_replace('@@content@@',$content,$page);
		$page = str_replace('@@prefix@@',$this->field_prefix(),$page);


		echo $page;
	}
		function field_prefix()
	{
		return get_class($this->project_class).'_'.$this->Name."_";
	}
}

?>