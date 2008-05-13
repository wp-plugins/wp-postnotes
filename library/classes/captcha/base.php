<?php
class dc_captcha_1_0_0 extends dc_base_2_1_0 {
	function show()
	{
		if(!$this->check() || !$_POST)
		{
			$numbers = array(
			'first',
			'second',
			'third',
			'fourth',
			'fifth',
			'sixth',
			'seventh',
			'eighth',
			'ninth',
			);
	
			$colors = array(
			'black' => '000000',
			'blue' => '0000FF',
			'green' => '90EE90',
			'pink' => 'FFC0CB',
			'red' => 'FF0000',
			'yellow' => 'FFFF00',
			'white' => 'FFFFFF',
			'cyan' => '00FFFF',
			'gray' => 'D3D3D3',
			);
			$html = $this->loadHTML('captcha_colors');
			srand((float) microtime() * 10000000);
			$box = array_rand($numbers, 1);
			$color = null;
			$cnt = 1;
			foreach ($numbers as $number)
			{
				srand((float) microtime() * 10000000);
				$rand_key = array_rand($colors, 1);
				$colorbox.=$html;
				$colorbox=str_replace('@@bgcolor@@','#ffffff',$colorbox);
				$colorbox=str_replace('@@number@@',$cnt,$colorbox);
				$colorbox=str_replace('@@bcolor@@',"#ffffff",$colorbox);
				if($cnt==$box)
				{
					$color = $rand_key;
				}
				$cnt++;
			}
			$cnt = 0;
			$colorbox.="<div style='clear:both'></div>";
			$html=str_replace('@@number@@',"",$html);
			$html=str_replace('@@bcolor@@',"#000000",$html);
			foreach ($numbers as $number)
			{
				srand((float) microtime() * 10000000);
				$rand_key = array_rand($colors, 1);
				$colorbox.=$html;
				$colorbox=str_replace('@@bgcolor@@','#'.$colors[$rand_key],$colorbox);
				unset($colors[$rand_key]);
				if($cnt==$box)
				{
					$color = $rand_key;
				}
				$cnt++;
			}
			$colorbox.="<div style='clear:both'></div>";
			$content.=$this->loadHTML('captcha');
			$content=str_replace('@@box@@',$numbers[$box],$content);
			$content=str_replace('@@answer@@',$this->encode($color),$content);
			$content=str_replace('@@colorbox@@',$colorbox,$content);
	
			$fborder="border:none";
	
			if(!$this->check())
			{
					$fborder="border-color:#ff0000";
			}
			$content=str_replace('@@fborder@@',$fborder,$content);
		}
		return $content;
	}
	function check()
	{
		if($_POST)
		{
			if($this->encode($_POST['captcha']['response'])!=$_POST['captcha']['answer'])
			{
				return false;
			}
		}
		return true;
	}
	function encode($answer)
	{
		$answer = crypt(str_replace('grey','gray',(trim(strtolower($answer)))),__FILE__);
		return $answer;
	}
}
?>