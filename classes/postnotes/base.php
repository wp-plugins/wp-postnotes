<?php
class dc_postnotes_2_5_0 extends dc_base_2_1_0 {
	function init()
	{
		$this->loadClass('wp_plugin',array($this,'plugins_loaded'));
		$u=$this->loadClass('upgrade');
		$u->config("Postnotes","postnote");
	}
	function plugins_loaded()
	{
		$m = $this->loadClass('wp_marker');
		$m->config('postnote',array($this,'postnote'));
	}
	function postnote($content,$match)
	{
		global $userdata;
		$title = $match['attributes']['title'];
		$demo = $match['attributes']['demo'];
		unset($match['attributes']['title']);
		unset($match['attributes']['demo']);
		$match['attributes'][] = get_the_author();
		if (in_array($userdata->user_login,$match['attributes']))
		{
			if ($demo=="true")
			{
				$page = eregi_replace(' demo\s*=\s*\"true\"','',$match['match']);
			}
			else
			{
				$page = $this->loadHTML('postnotes');
				if ($title!="")
				{
					$page= str_replace('@@title@@'," : ".$title,$page);
				}
				$page= str_replace('@@content@@',$match['innerhtml'],$page);
			}
			$content=str_replace($match['match'],$page,$content);

		}
		else
		{
			$content=str_replace($match['match'],'',$content);
		}	
		return $content;
	}
}
