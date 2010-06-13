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
	var $searched="";
	function init()
	{
		$this->folders[]='pages';
	}
	function get($file)
	{
		$return = '';
		if (file_exists($file))
		{
			$return = implode('', file($file));
		}
		return $return;
	}
	function save($file,$data)
	{
		if (is_writable(dirname($file)))
		{
			$fp = fopen($file, "w");
			fwrite($fp,$data);
			fclose($fp);
		}
	}
	function findFile($load) {
		foreach($this->folders as $folder)
		{
			foreach($this->library_path as $library) {
				$file = $library.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$load;
				$this->searched.=$file."<br/> ";
				if (file_exists($file)) {
					return($file);
				}
			}
		}
		return null;
	}
}
?>