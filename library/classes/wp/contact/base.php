<?php
class dc_wp_contact_1_0_0 extends dc_base_2_2_0 {
	function show($content="",$show_captcha=true,$allow_cc=true)
	{
		global $userdata;
		$user="";
		$email="";
		$site="";
		if (isset($userdata))
		{
			$user = $userdata->display_name;
			$email = $userdata->user_email;
			$site = $userdata->user_url;
			$show_captcha=false;
		}
		$c=$this->loadClass('contact');
		return $c->show($content,$show_captcha,$allow_cc,$user,$email,$site);
	}
}
?>