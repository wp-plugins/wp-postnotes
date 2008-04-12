<?php
class dc_file_1_0_0 extends dc_base_1_0_2 {
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
		if (file_exists($file))
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
				if (file_exists($file)) {
					return($file);
				}
			}
		}
		return null;
	}		
}
?>