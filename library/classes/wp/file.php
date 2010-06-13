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
	function baseURL($file=null)
	{
		//return PLUGINDIR;
		if(is_null($file))
		{
			$path=$this->library_path[0];
		} else {
			$path=$file;
		}
		$path = str_replace('\\\\','\\',$path);
		$path = str_replace('\\','/',$path);
		$path = substr($path,strpos($path,PLUGINDIR));
		$path = get_option('home').'/'.substr($path,strpos($path,PLUGINDIR));
		return $path;
	}
}

?>