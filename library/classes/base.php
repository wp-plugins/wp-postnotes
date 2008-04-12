<?php
if (!class_exists('dc_base_1_0_2')) {
/*
	note:
	major limitation with php 4.3. 	
	classes loaded into class variable in constructor
	are not retained accros a call back to function even
	within the same class. avoid using them unless you are
	sure you will be running on php 5
*/
	
	class dc_base_1_0_2 {
		// the top most class in the class stucture
		var $projectClass = null;
		// the path to be searched when looking for files
		var $library_path = array();
		// sub folders to search in each of the above
		var $folders = array();
		// the callback function that may be called should you need it
		var $callback = null;

		function dc_base_1_0_2($projectClass = null,$callback=null){
			$this->callback = $callback;
			
			if (is_null($projectClass)) {
				$this->projectClass = get_class($this);
			} else {
				$this->projectClass = $projectClass;			
			}
			$library_path = dirname(dirname(__FILE__));
			switch(basename($library_path)){
				case 'classes':
				case 'pages':
					$library_path = dirname($library_path);
			}
			switch(basename($library_path)){
				case 'library':
					$library_path = dirname($library_path);
			}
			$this->library_path[]=$library_path;
			$this->library_path[]=$library_path.DIRECTORY_SEPARATOR.'library';
			$this->folders[] = "classes";
			$script = strtolower(str_replace('\\','/',$_SERVER['SCRIPT_FILENAME']));
			$home = strtolower(dirname(dirname(str_replace('\\','/',__FILE__))));
			
			// check to see if this is a direct call
			if(strpos($script,$home)===0)
			{
				$this->direct();
			} else {
				$this->legacy();
				$this->init();
			} 
		}
		
		// overrideable function to deal with direct calls to the code
		function direct()
		{
			echo "No Direct Calls";
		}
		
		// change to do upgrade and other stuff before the code kicks off propper
		function legacy()
		{
			
		}
		// first proper code to execute after initialisation
		function init()
		{
		}
		
		function loadClass($load,$callback=null)
		{
			$load=str_replace('_','/',$load);
			$file=dirname(__FILE__).DIRECTORY_SEPARATOR.$load.".php";
			if (!file_exists($file))
			{
				$f=$this->loadClass('file');
				$file = $f->findFile($load.".php");
				if (is_null($file)) {
					$file = $f->findFile($load.DIRECTORY_SEPARATOR."base.php");
				}
			}
			if (!is_null($file)) {
				$cname = $this->_getClassname($file);
				if (!class_exists($cname))
				{
					require($file);
				}
				$return = new $cname($this->projectClass,$callback);
				return $return;
			}
			return null;
		}
		function debug($var=null,$echo=true,$name='Call to test',$condition=true)
		{
			$t = $this->loadClass('testing_debug');
			return $t->test($var,$echo,$name,$condition);
		}
		function loadHTML($load)
		{
			$h = $this->loadClass('html');
			return $h->load($load);
		}
		function _getClassname($file)
		{
			$handle = fopen($file, "rb");
			$top = fread($handle, 256);
			fclose($handle);
			$pattern ='|class\s*(.*[^\W])\W|Ui';
			preg_match_all($pattern,$top,$matches,PREG_SET_ORDER);
			return trim($matches[0][1]);
		}
	}
}
?>