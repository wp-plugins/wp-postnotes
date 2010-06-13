<?php
/*
$HeadURL$
$LastChangedDate$
$LastChangedRevision$
$LastChangedBy$
*/
?>
<?php
if (!class_exists('dcbase7')) {
/*
	note:
	major limitation with php 4.3.
	classes loaded into class variable in constructor
	are not retained accros a call back to function even
	within the same class. avoid using them unless you are
	sure you will be running on php 5
*/

	class dcbase7 {
		// the top most class in the class stucture
		var $projectClass = null;
		// the path to be searched when looking for files
		var $library_path = array();
		// sub folders to search in each of the above
		var $folders = array();
		// the callback function that may be called should you need it
		//var $callback = null;
		var $init_args=null;
		var $domain="";
		var $projectFile = null;
		//var $containerClass = null;
	function test()
	{
		echo realpath(__FILE__);
	}
		function dcbase7($projectFile=null,$initClass=null,$initClassArgs=null,$projectClass = null,$args=null,$caller=null,$librarypath=null,$domain=null){
			global $dcoda_direct;
			$this->init_args=$args;
			if(is_null($projectFile))
			{
				$this->projectFile=__FILE__;
			}
			else
			{
				$this->projectFile=$projectFile;
			}
			if(is_null($caller))
			{
				$caller=$this;
				$this->setPath($projectFile);
			}
			if(!is_null($librarypath))
			{
				$this->library_path = $librarypath;
			}
			if(!is_null($domain))
			{
				$this->domain = $domain;
			}
			//$this->containerClass=$caller;
			extract( (array)$args, EXTR_SKIP );

			//$this->callback = $callback;

			if (is_null($projectClass)) {
				$this->projectClass = get_class($this);
			} else {
				$this->projectClass = $projectClass;
			}

			$this->folders[] = "classes";
			// check for direct calls
			$file = str_replace('\\','/',__FILE__);
			$file = str_replace('//','/',$file);
			$script = str_replace('\\','/',$_SERVER['SCRIPT_FILENAME']);
			$script = dirname($script);
			$file = dirname(dirname(dirname($file)));
			if ( $script == $file && !$dcoda_direct)
			{
				$dcoda_direct = true;
				$this->direct();
			}
			else
			{
				$this->legacy($args);
				$this->init($args);
			}
			if(!is_null($initClass))
			{
				$this->loadClass($initClass,$initClassArgs);
			}
		}

		function setPath($file)
		{
			$this->library_path=array();
			$library_path = dirname($file);
			$this->domain=basename($file,".php");
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
		}

		function direct()
		{
			header("HTTP/1.1 301 Moved Permanently");
			header ("Location: http://www.dcoda.co.uk");
		}

		// change to do upgrade and other stuff before the code kicks off propper
		function legacy()
		{

		}
		// first proper code to execute after initialisation
		function init()
		{
		}

		function loadClass($load,$args=null)
		{
			$oload=$load;
			$load=str_replace('_',DIRECTORY_SEPARATOR,$load);
			$file = $this->findFile($load.".php");
			$this->searched=array();
			if (is_null($file)) {
				$file = $this->findFile($load.DIRECTORY_SEPARATOR."base.php");
			}
			if (!is_null($file)) {
				$cname = $this->_getClassname($file);
				if (!class_exists($cname))
				{
					$rf=$this->getFile($file);
					$rf=str_replace('dcLoadableClass',$cname,$rf);
					if(eval('?>'.$rf)===false)
					{
						return null;
					}
				}
				$return = new $cname($this->projectFile,null,$null,$this->projectClass,$args,$this,$this->library_path,$this->domain);
				return $return;
			}
			trigger_error("Cannot loadClass('".$oload."') as file ".$load."<br><b>Searching Path:</b><br>".implode($this->library_path,"<br>")."<br><b> and Sub folders:</b><br>".implode($this->folders,"<br>")."<br/><b>Searched for:</b><br>".implode($this->searched,"<br>")."<br>", E_USER_ERROR);
			return null;
		}
		function getFile($file)
		{
			$return = '';
			if (file_exists($file))
			{
				$return = implode('', file($file));
			}
			return $return;
		}

		function debug($var=null,$echo=true,$name='Call to test',$condition=true)
		{
			$t = $this->loadClass('debug');
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
			$pattern ='|\$HeadURL: (.*) \$|Ui';
			preg_match_all($pattern,$top,$matches,PREG_SET_ORDER);
			$file=str_replace(':','',str_replace('%7C','_',str_replace('/','_',str_replace('\\','_',str_replace('-','_',str_replace('.','_',str_replace('://','_',$matches[0][1])))))));
			$pattern ='|\$LastChangedRevision: (.*) \$|Ui';
			preg_match_all($pattern,$top,$matches,PREG_SET_ORDER);
			$file.="_rev".$matches[0][1];
			return $file;
		}
		var $searched=array();
		function findFile($load) {
			foreach($this->folders as $folder)
			{
				foreach($this->library_path as $library) {
					$file = $library.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$load;
					$this->searched[]=$file;
					if (file_exists($file)) {
						return($file);
					}
				}
			}
			return null;
		}

	}
}
?>