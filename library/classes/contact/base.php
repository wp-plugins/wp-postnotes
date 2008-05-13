<?php
class dc_contact_1_0_0 extends dc_base_2_1_0 {
	function show($content="",$show_captcha=true,$allow_cc=true,$user="",$email="",$site="http://")
	{
		$page = $this->loadHTML('contact');
		$user_fborder='border:none';
		$email_fborder='border:none';
		$checked = "";
		$valid=false;
		if($_POST)
		{
			$valid=true;
			$user=trim($_POST['usersettings']['user']);
			$email=trim($_POST['usersettings']['email']);
			$site=$_POST['usersettings']['site'];
			if($_POST['usersettings']['copy'])
				$checked = " checked=checked ";
			if($user=="")
			{
				$user_fborder="border-color:red";
				$valid=false;
			}
			if(strpos($email,'@')===false)
			{
				$email_fborder="border-color:red";
				$valid=false;
			}
		}
		$page = str_replace('@@user-fborder@@',$user_fborder,$page);
		$page = str_replace('@@email-fborder@@',$email_fborder,$page);
		$page = str_replace('@@user@@',$user,$page);
		$page = str_replace('@@email@@',$email,$page);
		$page = str_replace('@@site@@',$site,$page);
		$page = str_replace('@@content@@',$content,$page);
		$i=$this->loadClass('info');
		$page = str_replace('@@ip@@',$i->ip(),$page);
		$captcha="";
		if($show_captcha==true)
		{
			$c=$this->loadClass('captcha');
			$captcha=$c->show();
			if($captcha!="")
				$valid=false;
		}
		$page = str_replace('@@captcha@@',$captcha,$page);
		$cc = "display:none";
		if($allow_cc==true)
			$cc = "border:none";
		$page = str_replace('@@copy-fborder@@',$cc,$page);
		$page = str_replace('@@checked@@',$checked,$page);
		return array(
					'page'=>$page,
					'valid'=>$valid);
	}
}
?>