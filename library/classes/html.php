<?php
class dc_html_1_0_0 extends dc_base_2_2_0 {
	function init() {
		$this->folders[] = 'pages';
	}
	function load($load) {
		$f = $this->loadClass('file');
		$load=str_replace('_','/',$load);
		$php = true;
		$filename = $f->findFile($load.".html");
		if (is_null($filename)) {
			$filename = $f->findFile($load."/template.html");
		}
		if (!is_null($filename)) {
			$file = $this->loadClass('file');
			$return = $file->get($filename);
			return $return;
		}
		return null;
	}		
}
?>