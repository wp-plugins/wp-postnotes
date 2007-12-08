<?php
if (!class_exists("DCodaBaseV1_1")){
	class DCodaBaseV1_1
	{
// -- Initialise ----------------------------------------------------------------------------------------------------------------
		var $CName = '';
		var $Name = '';
		function DCodaBaseV1_1(){
			add_action('plugins_loaded', array($this,'doInit'));
		}
		function test()
		{
			echo "hello";
		}
		function doInit() {
			$this->preInit();
			$this->legacy();
			$this->init();
			$this->postInit();
		}
		function preInit() {
			$this->CName = get_class($this);
			$this->Name = $this->CName;
			$this->getOptions();
			if (!isset($this->Options['widgetCount']))
			{
				$this->Options['widgetCount'] = 1;
			}
		}
		
		function init() {
		}
		
		function postInit() {
			add_action('admin_menu', Array(&$this,'initDashboard'));
			$this->initWidget();		
			add_filter('the_content', array($this,'filter'));	
			add_action('wp_head', array($this,'doHeader'));
			add_action('admin_head', array($this,'doHeader'));
		}
		function legacy()
		{
			
		}
		// -- Style Stuff ----------------------------------------------------------------------------------------------------------------
		function styleTag($filename)
		{
			$return  = '';
			$return .= "\t\n<link rel='stylesheet' href='".$filename."' type='text/css' media='screen' />\n";
			return $return;
		}
		// -- header Stuff ----------------------------------------------------------------------------------------------------------------
		function doHeader()
		{
			$this->preHeader();
			$this->header();
			$this->postHeader();
		}
		function preHeader()
		{
			if ($this->getPluginFile('style.css')!='')
			{
				echo $this->styleTag($this->getPluginFile('style.css'));
			}
		}
		function header()
		{
			
		}
		function postHeader()
		{
			
		}
		// -- Widget Stuff ----------------------------------------------------------------------------------------------------------------
		var $widgetDims=array('width' => 460, 'height' => 65);
		function initWidget()
		{
		}
		var $maxWidgets = 1;
		function regWidget($Num = 1,$hasOptions = false)
		{
			$this->maxWidgets = $Num;
			for ($cnt=1;$cnt<=$Num;$cnt++)
			{
				$wName = $this->Name;
				if ($this->Options['widgetCount']>1)
				{
					$wName = "$this->Name $cnt";
				}
				wp_register_sidebar_widget($this->Name.$cnt,$wName,$cnt <= $this->Options['widgetCount'] ? Array($this,'Widget'):'',$cnt);
				if ($hasOptions)
				{
					wp_register_widget_control($this->Name.$cnt,$wName,$cnt <= $this->Options['widgetCount'] ? Array($this,'doWidgetOptions') : '',$this->widgetDims,$cnt);	
				}			
			}
			add_action('sidebar_admin_setup', array($this,'widgetSetup'));
			add_action('sidebar_admin_page', array($this,'WidgetCount'));
		}
		function widgetSetup()
		{
			if ( isset($_POST[$this->CName.'NumberSubmit']) )
			{
				$Number = (int) $_POST[$this->CName.'Number'];
				$this->Options['widgetCount'] = $Number;
				$this->saveOptions();
				$this->initWidget();			
			}
		}
		function widgetCount()
		{
			if ($this->maxWidgets==1)
				return;
			echo "<div class='wrap'><h2>$this->Name</h2>";
			echo "<form method='post'>";
			echo "<p style='line-height: 30px;'>How many ".$this->Name." widgets would you like? ";
			echo '<select Name="'.$this->CName."Number.'">'';
			for ( $i = 1; $i <= $this->maxWidgets; ++$i )
				echo "<option value='$i' ".($this->Options['widgetCount']==$i ? "selected='selected'" : '').">$i</option>";
			echo "</select> ";
			echo "<span class='submit'><input type='submit' name='".$this->CName."NumberSubmit' value='".attribute_escape(__('Save'))."' /></span></p>";
			echo "</form>";
			echo "</div>";			
		}
		function doWidgetOptions($Number = 1)
		{
			$this->preWidgetOptions($Number);
			$this->widgetOptions($Number);
			$this->postWidgetOptions($Number);
		}
		function preWidgetOptions($Number = 1)
		{
			$this->saveOptions($Number);
			echo "<table class='optiontable'>";		
		}
		function widgetOptions($Number = 1)
		{
		}
		function postWidgetOptions($Number = 1)
		{
			echo "</table>";		
		}
		function remove_default_widgets()
		{
			if(function_exists('unregister_sidebar_widget')){
				unregister_sidebar_widget('Archives');
				unregister_sidebar_widget('Calendar');
				unregister_sidebar_widget('Categories 1');
				remove_action('sidebar_admin_setup','wp_widget_categories_setup');
				remove_action('sidebar_admin_page','wp_widget_categories_page');
				unregister_sidebar_widget('Links');
				unregister_sidebar_widget('Meta');
				unregister_sidebar_widget('Pages');
				unregister_sidebar_widget('Recent Comments');
				unregister_sidebar_widget('Recent Posts');
				unregister_sidebar_widget('Search');
				unregister_sidebar_widget('RSS 1');
				remove_action('sidebar_admin_setup','wp_widget_rss_setup');
				remove_action('sidebar_admin_page','wp_widget_rss_page');
				unregister_sidebar_widget('Tag_Cloud');
				unregister_sidebar_widget('Text 1');
				remove_action('sidebar_admin_setup','wp_widget_text_setup');
				remove_action('sidebar_admin_page','wp_widget_text_page');
			}
		}
		function widgetOptionsLine($title = '',$content = '',$description = '') {
			echo "<tr><th scope='row'>$title</th><td>$content<br/><small>$description</small></td></tr>";
		}
		function Widget($args,$Number=1)
		{
		}

// -- DashBoard stuff ----------------------------------------------------------------------------------------------------------------

		function initDashBoard()
		{
		}
	
		function AddOptionsPage($PageTitle,$MenuTitle) {
				switch ($PageTitle)
				{
					case'Dashboard':
						$Page = 'index.php';
						break;
					case'Write':
						$Page = 'post-new.php';
						break;
					case'Manage':
						$Page = 'edit.php';
						break;
					case'Comments':
						$Page = 'edit-comments.php';
						break;
					case'Blogroll':
						$Page = 'link-manager.php';				
						break;
					case'Presentation':
						$Page = 'themes.php';
						break;
					case'Plugins':
						$Page = 'plugins.php';
						break;
					case'Users':
						$Page = 'users.php';
						break;
					case'Options':
						$Page = 'options-general.php';
						break;
					default:
						$Page = $MenuTitle;
						add_menu_page($MenuTitle, $PageTitle, 8,$Page,Array($this,'doOptionsPage'));
						break;
											
				}
				add_submenu_page($Page,$PageTitle,$MenuTitle,8,$MenuTitle, Array(&$this,'doOptionsPage'));
		}
		
	
		function doOptionsPage() {
			$this->preOptionsPage();
			$this->OptionsPage();
			$this->postOptionsPage();
		}
		function preOptionsPage(){
			if ($this->saveOptions('Option'))
			{
				echo '<div id="message" class="updated fade"><p>';
				echo _e($this->Name.' Options updated.');
				echo '</p></div>';
				
			}
			echo "<div class='wrap'><h2>$this->Name</h2>";
			echo "<form method='post'>";
			echo "<table class='optiontable'>";
		}
		function postOptionsPage() {
			echo "</table>";
			echo "</form>";
			echo "</div>";
			
		}
		function OptionsPage()
		{
		}
		function OptionsPageLine($title = '',$content = '',$description = '') {
			echo "<tr><th scope='row'>$title</th><td>$content<br/><small>$description</small></td></tr>";

		}
		function OptionsPageSubmit() {
			echo "<tr><td colspan=2><p class='submit'><input type='submit' name='".$this->CName."Submit' value='Submit Options' /></p></td></tr>";
		}


// -- Filter Stuff ----------------------------------------------------------------------------------------------------------------
	function filter($content)
	{
		return $content;
	}
// -- form Stuff ----------------------------------------------------------------------------------------------------------------
	function form($lines=array())
	{
		$return['error']=false;
		$return['code']='';
		$content='';
		$errors='';
		foreach((array)$lines as $line){
			if ($line['error']!='') {
				$errors.="\t\t<p class = 'error'>".$line['error']."</p>\n";
				$return['error']=true;
			}
			$content.=$line['code'];
		}
		$return['code']  = "\n";
		$return['code'] .= "<div class = '$this->CName'>\n";
		$return['code'] .= "\t<form method = 'post'>\n";
		$return['code'] .= $errors;
		$return['code'] .= $content;
		$return['code'] .= "\t\t<p class = 'submit'>\n";
		$return['code'] .= "\t\t\t<input name = '".$this->CName."_submit' type = 'submit' value = 'Submit' />\n";
		$return['code'] .= "\t\t</p>\n";
		$return['code'] .= "\t</form>\n";
		$return['code'] .= "</div>\n\n";
		return $return;
	}
	function isPosted() {
		return ($_POST[$this->CName.'_submit']!='');
	}
	function input($label,$fieldID,$type='text',$validation=array())
	{
		$trueFieldName=$this->CName.'_'.$fieldID;
		$return['error']='';
		$return['code']='';
		$class = '';
		if ($this->isPosted($formID) && count($validation)!=0)
		{
			$check=call_user_func($validation,$label,$_POST[$trueFieldName]);
			if($check!='')
			{
				$class = ' class = "error" ';
				$return['error']=$check;
			}
		}
		$value = $_POST[$trueFieldName];
		if ($type!='hidden') {
			$return['code'].="\t\t<p>\n";
		} else {
			$value = $label;
		}
		if ($type=='textarea') {
			$return['code'].="\t\t\t<label for = '".$trueFieldName."' >".$label."</label>\n";
			$return['code'].="\t\t\t<br/>\n";
			$return['code'].="\t\t\t<textarea ".$class." name='".$trueFieldName."' >".$value."</TEXTAREA>\n";
		} else {
			$return['code'].="\t\t\t<input type = '".$type."' ".$class." value='".$value."' name='".$trueFieldName."'>";
			if ($type!='hidden') {
				$return['code'].="<LABEL for='".$trueFieldName."'>".$label."</LABEL>\n";	
			}
		}
		if ($type!='hidden') {
			$return['code'].="\t\t</p>\n";
		}
		return $return;	
	}
	function captcha()
	{
		$return['error']='';
		$return['code']='';
		$class = '';
		if ($_POST[$this->CName.'_captcharesponse']!='')
		{
			if (crypt(trim($_POST[$this->CName.'_captcha']),"12345")!=$_POST[$this->CName.'_captcharesponse'])	
			{		
				$class=' class = "error" ';
				$return['error']="<p class='error'>The <font title='Human response test'>CAPTCHA</font> answer was incorrect.</p>";
			}
		}
		$no1 = rand(0,9);
		$no2 = rand(0,9);
		$ques = "$no1 + $no2";
		$ans=crypt($no1+$no2,"12345");
		$return['code']='<P class="captcha"><label>CAPTCHA</label><br/>What is '.$ques.': <input '.$class.' type="text" name="'.$this->CName.'_captcha" /><input type="hidden" name="'.$this->CName.'_captcharesponse" value="'.$ans.'" /></P>';
		return $return;
	}
	function checkMandatory($label,$field)
	{
		$return = '';
		if ($field=='')
		{
			$return = $label.' is mandatory';
		}
		return $return;
	}
	function checkKeywords($label,$field)
	{
		$return = '';
		$keywords=split(',',$this->Options['Option']['Keywords']);
		foreach($keywords as $keyword)
		{
			if ($keyword)
			{
				if(strpos($field,trim($keyword))!==false)
				{
					$return = $label.' has keyword violations';
				}
			}
		}
		return $return;
	}

// -- Options stuff ----------------------------------------------------------------------------------------------------------------
		var $Options = array();
		function saveOptions($Number = '')
		{
			$Updated = false;
			if ($_POST[$this->CName.'Submit']!='' and $Number!=''){
				$this->Options[$Number] = array();
				foreach(array_keys($_POST) as $key)
				{
					if(strpos($key,$this->inputPrefix($Number))===0)
					{
						$oKey=substr($key,strlen($this->inputPrefix($Number)));
						$this->Options[$Number][$oKey] = stripslashes($_POST[$key]);
						$Updated = true;
					}
				}
			}	
			update_option($this->CName, $this->Options);
			return $Updated;
		}
		function getOptions()
		{
			$this->Options=get_option($this->CName);
		}
// -- Common stuff ----------------------------------------------------------------------------------------------------------------

		function postExists($page_title) {
	 		global $wpdb;
 			$page_title = $wpdb->escape($page_title);
 			$page = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '$page_title' AND post_type='page'");
 			if ( $page )
 			{
	  			return get_page($page);
 			}
  			$page = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '$page_title' AND post_type='post'");
 			if ( $page )
 			{
	 			return get_post($page);
 			}
  			return NULL;
		} 
		function inputPrefix($Number='')
		{
			return $this->CName.'_'.$Number.'_';
		}
		function getPluginFile($file)
		{
			$rtext="";
			$filename=pathinfo(__FILE__,PATHINFO_DIRNAME).DIRECTORY_SEPARATOR.$file;
			$filename=str_replace('/',DIRECTORY_SEPARATOR,$filename);
			$plugindir=str_replace('/',DIRECTORY_SEPARATOR,PLUGINDIR);
			if (file_exists($filename))
			{
				$rtext.= '/'.str_replace('\\','/',substr($filename,strpos($filename,$plugindir)));
			}
			return $rtext;
		}

// -- Tag stuff ----------------------------------------------------------------------------------------------------------------
		function matchCommentTag($tag,$content)
		{
			$retval=array();
			$pattern='|<!--\s*'.$tag.'\s*.*-->([\w\W\s\S]*)<!--\s*\/'.$tag.'\s*-->|Ui';
			preg_match_all($pattern,$content,$matches,PREG_SET_ORDER);
			$cnt=0;
			foreach((array)$matches as $match)
			{
				$retval[$cnt]['content']=trim($match[1]);
				$cnt++;
			}
			$pattern='|<!--\s*'.$tag.'\s*(.*)\s*-->|Ui';
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
			return $retval;
		}

	}

}

?>