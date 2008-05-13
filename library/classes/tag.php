<?php
class dc_tag_1_1_1 extends dc_base_2_1_0 {
	function get($tag,$content,$comment=false)
	{
		$comment_start = '';
		$comment_end = '';
		if ($comment)
		{
			$comment_start = '!--';
			$comment_end = '--';
		}
		$retval=array();
		$patterns = array();
		$patterns[] ='|<'.$comment_start.'\s*'.$tag.'\s*(.*)\s*'.$comment_end.'>([\w\W\s\S]*)<'.$comment_start.'\s*\/'.$tag.'\s*'.$comment_end.'>|Ui';
		$patterns[] ='|<'.$comment_start.'\s*'.$tag.'\s*(.*)\s*'.$comment_end.'\/?>|Ui';
		if($comment)
		{
			$patterns[]	='|\[\s*'.$tag.'\s*(.*)\s*\]([\w\W\s\S]*)\[\s*\/'.$tag.'\s*\]|Ui';
			$patterns[] ='|\[\s*'.$tag.'\s*(.*)\s*\/?\]|Ui';
		}
		$all_matches=null;
		foreach ($patterns as $pattern)
		{
			preg_match_all($pattern,$content,$matches,PREG_SET_ORDER);
			foreach ($matches as $match)
			{
				$content = str_replace($match[0],'',$content);
			}
			$all_matches = array_merge((array)$all_matches,(array)$matches);
		}
		$patterns = array();
		$patterns[]='|\s*(.*)\s*=\s*"(.*)"\s*|Ui';
		$patterns[]="|\s*(.*)\s*=\s*'(.*)'\s*|Ui";
		$patterns[]="|\s*(.*)\s*=\s*&#8217;(.*)&#8217;\s*|Ui";
		$patterns[]="|\s*(.*)\s*=\s*&#8221;(.*)&#8221;\s*|Ui";
		$complete_matches = array();
		foreach($all_matches as $all_match)
		{
			$complete_match = "";
			$complete_match['match'] = $all_match[0];
			$complete_match['tag'] = $tag;
			if ($comment)
				$complete_match['comment'] = true;
			$complete_match['open'] = $all_match[0][0];
			$complete_match['close'] = substr($all_match[0],-1);
			if (array_key_exists(2,$all_match))
				$complete_match['innerhtml'] = $all_match[2];
				foreach ($patterns as $pattern)
			{
				preg_match_all($pattern,$all_match[1],$matches,PREG_SET_ORDER);
				foreach($matches as $match)
				{
					$complete_match['attributes'][strtolower(trim($match[1]))] = trim($match[2]);
					$all_match[1] = str_replace($match[0],'',$all_match['1']);
				}
			}
			$complete_matches[]=$complete_match;
		}
		return $complete_matches;
	}
	function render($tag)
	{
		$default_tag = array('type' => 'text','open' => '<','close'=>'>');
		$tag = array_merge($default_attributes,$tag);
		$tag['attributes'] = array_merge($default_attributes,$tag['attributes']);
		//$this->test($tag);
		$comment_start = '';
		$comment_end = '';
		if ($tag['comment'])
		{
			$comment_start = '!--';
			$comment_end = '--';
		}
		$return  = "";
		$return .= $tag[open];
		$return .= $comment_start;
		$return .= $tag['tag'];
		foreach (array_keys((array)$tag['attributes']) as $key)
		{
			$return .= " ".$key." = '".$tag['attributes'][$key]."'";
		}
		if (!array_key_exists('innerhtml',$tag))
		{
			$return .= '/';
		}
		$return .= $tag['close'];
		$return .= $comment_end;		
		if (array_key_exists('innerhtml',$tag))
		{
			$return .= $tag['innerhtml'];
			$return .= $tag['open'];
			$return .= '/';
			$return .= $tag['comment_start'];
			$return .= $tag['tag'];
			$return .= $tag['comment_end'];
			$return .= $tag['close'];
		}
		return $return;
	}
	
	
}
?>