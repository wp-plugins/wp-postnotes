<?php
class dc_wp_header_1_2_0 extends dc_base_2_1_0 {
	function init() {
		$this->config();
	}
	function config($blog=true,$login=false,$admin=false)
	{
		if (!is_null($this->callback))
		{
			if ($blog)
			{
				add_action('wp_head', $this->callback);		
			}
			if ($login)
			{
				add_action('login_head', $this->callback);		
			}
			if ($admin)
			{
				add_action('admin_head', $this->callback);		
			}
		}
	}
	var $style=null;
	function addStyle($load)
	{
		$load=str_replace('_','/',$load);
		$file=dirname(__FILE__).DIRECTORY_SEPARATOR.$load.".css";
		if (!file_exists($file))
		{
			$f=$this->loadClass('file');
			$f->folders[]='styles';
			$file = $f->findFile($load.".css");
			if (is_null($file)) {
				$file = $f->findFile($load.DIRECTORY_SEPARATOR."style.css");
			}
		}
		if (!is_null($file)) {
			$this->style=$file;
			add_action('wp_head', array($this,'styleHeader'));		
		}
		$file=dirname(__FILE__).DIRECTORY_SEPARATOR.$load.".php";
		if (!file_exists($file))
		{
			$f=$this->loadClass('file');
			$f->folders[]='styles';
			$file = $f->findFile($load.".php");
			if (is_null($file)) {
				$file = $f->findFile($load.DIRECTORY_SEPARATOR."style.php");
			}
		}
		if (!is_null($file)) {
			$this->style=$file;
			add_action('wp_head', array($this,'styleHeader'));		
		}
		return null;
	}
	function styleHeader($args)
	{
		if(!is_null($this->style))		
		{
			$f=$this->loadClass('wp_file');
		?>
		<link rel="stylesheet" href="<?php echo $f->baseURL($this->style); ?>" type="text/css" media="screen" />
		<?php
		}
	}
	var $script=null;
	function addScript($load)
	{
		$load=str_replace('_','/',$load);
		$file=dirname(__FILE__).DIRECTORY_SEPARATOR.$load.".js";
		if (!file_exists($file))
		{
			$f=$this->loadClass('file');
			$f->folders[]='scripts';
			$file = $f->findFile($load.".js");
			if (is_null($file)) {
				$file = $f->findFile($load.DIRECTORY_SEPARATOR."script.js");
			}
		}
		if (!is_null($file)) {
			$this->script=$file;
			add_action('wp_head', array($this,'scriptHeader'));		
		}
		return null;
	}
	function scriptHeader($args)
	{
		if(!is_null($this->script))		
		{
			$f=$this->loadClass('wp_file');
		?>
		<script src="<?php echo $f->baseURL($this->script); ?>"></script>
		<?php
		}
	}
}
?>