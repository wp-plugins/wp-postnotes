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
	var $marker = array();
	var $wmarker = array();
	var $callback = array();
	var $option_callback=array();
	var $dims=array();
	var $Desc=array();
	var $priority=array();

	function getName($name)
	{
		return strtolower(str_replace(' ','_',$name));
	}
	function addMarker($marker,$callback,$option_callback = null,$dims = null,$Desc = null,$priority=1) {
		$name=$this->getName($marker);
		$this->marker[$name] = $name;
		$this->wmarker[$name]=$marker;
		$this->option_callback[$name]=$option_callback;
		$this->dims[$name]=$dims;
		$this->Desc[$name]=$Desc;
		$this->callback[$name] = $callback;
		add_filter('the_content', array($this,'_matchMarker'),$priority);
		add_action($this->marker[$name],array($this,'_action'),1,1);
		if(!is_null($option_callback))
		{
			$this->loadClass('wp_widget',array($this,'widget_register'));
		}
	}
	function widget_register()
	{
		foreach((array)$this->marker as $marker)
		{
			$w = $this->loadClass('wp_widget');
			$w->config($this->wmarker[$marker],$this->callback[$marker],$this->option_callback[$marker],$this->dims[$marker],$this->Desc[$marker]);
		}
	}
	function _matchMarker($content)
	{
		$t = $this->loadClass('html_tag');
		foreach((array)$this->marker as $marker)
		{
			$matches = $t->get($marker,$content,true);
			foreach($matches as $match) {
				if ($match['attributes']['demo']=="true")
				{
					unset($match['attributes']['demo']);
					$newmatch=$t->render($match);
					$content=str_replace($match['match'],$newmatch,$content);
				}
				else
					$content=call_user_func($this->callback[$marker],$content,$match);
			}
		}
		return $content;
	}

	function _action($attributes)
	{
		$action=current_filter();
		if(!is_array($attributes))
		{
			$t=$this->loadClass('html_tag');
			$attributes=$t->attributes($attributes);
		}
		$match=array();
		$match['match']='notdone';
		$match['tag']=$action;
		$match['attributes']=(array)$attributes;
		$match['attributes']['template']=1;
		$content=call_user_func($this->callback[$action],'notdone',$match);
		echo $content;
	}

}

?>