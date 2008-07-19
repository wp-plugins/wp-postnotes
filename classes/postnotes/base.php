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
	function init()
	{
		$m = $this->loadClass('wp_widget_marker');
		$m->addMarker('postnote',array($this,'postnote'));
	}
	function postnote($content,$match)
	{
		global $userdata;
		$title = $match['attributes']['title'];
		$demo = $match['attributes']['demo'];
		$silent = $match['attributes']['silent'];
		unset($match['attributes']['title']);
		unset($match['attributes']['demo']);
		unset($match['attributes']['silent']);
		$match['attributes'][] = get_the_author();
		if (in_array($userdata->user_login,$match['attributes']))
		{
			if ($demo=="true")
			{
				$page = eregi_replace(' demo\s*=\s*\"true\"','',$match['match']);
			}
			else
			{
				$page= $match['innerhtml'];
				if(!$silent)
				{
					$page = $this->loadHTML('postnotes');
					if ($title!="")
					{
						$page= str_replace('@@title@@'," : ".$title,$page);
					}
					else
					{
						$page= str_replace('@@title@@',"".$title,$page);
					}
					$page= str_replace('@@content@@',$match['innerhtml'],$page);
				}

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
