<?php
class dc_upgrade_1_0_1 extends dc_base_2_1_0 {
	function config($title,$tag)
	{
		$this->title=$title;
		$this->tag=$tag;
		$this->loadClass('wp_dashboard',array($this,'dash'));
		
	}
	var $title = "";
	var $tag = "";
	function dash()
	{
		$d = $this->loadClass('wp_dashboard',array($this,'dash'));
		$d->add_page('Update',$this->title,array($this,'page'));	
	}
	function page()
	{
		$d = $this->loadClass('wp_dashboard');
		$p = $this->loadClass('wp_post');
		$display=true;
		$posts = $p->onPosts(array($this,'action'));
		if ($posts=="")
		{
			$display=false;
			$page = "No posts/pages need updating."	;	
		}
		else 
		{
			$page = $this->loadHTML('upgrade');
			$page = str_replace('@@posts@@',$posts,$page);		
			$page = str_replace('@@tag@@',$this->tag,$page);		
		}
		$d->template($this->title,$page,null,"Auto Update",$display);
	}
	function action($postID)
	{
		$update=$_POST['Submit'];
		$post = get_post_to_edit($postID);
		$t = $this->loadClass('tag');
		$matches = $t->get($this->tag,$post->post_content,true);
		$return = "";
		foreach($matches as $match) {
			if ($match['open']!="[")
			{
				if ($update)
				{
					$newmatch = str_replace("<!--","[",$match['match']);
					$newmatch = str_replace("-->","]",$newmatch);
					$post->post_content=str_replace($match['match'],$newmatch,$post->post_content);
					wp_update_post($post);
				}
				else
				{
					$return.= "<a href='post.php?action=edit&post=".$post->ID."'>".$post->post_title."</a> ";
				}
			}
		}
		return $return;
	}
}

