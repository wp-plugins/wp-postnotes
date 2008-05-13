<?php
$_dc_class_name = 'dc_debug_1_0_0';
if (!class_exists($_dc_class_name)) {
	class dc_debug_1_0_0 {
		function test($var=null,$name='Call to test',$condition=true){
			$return = '';
			if ($condition) {
				ob_start();
				print_r($var);
				$output = ob_get_contents();
				ob_end_clean();
				$output = split("\n",$output);
				$return .= "\n\n";
				$return .= "\t<table style = 'margin:0;width:100%;background-color:white;border:4px solid darkblue;'>\n";
				$return .= "\t\t<thead style='margin:0;padding:5px;background-color:darkblue;color:white'>\n";
				$return .= "\t\t\t<tr>\n";
				$return .= "\t\t\t\t<th style='width:50px;text-align:left' scope = 'row'>Class</th>\n";
				$return .= "\t\t\t\t<td style='text-align:left'>".get_class($this)."</td>\n";
				$return .= "\t\t\t</tr>\n";
				$return .= "\t\t\t<tr>\n";
				$return .= "\t\t\t\t<th style='text-align:left' scope = 'row'>Time</th>\n";
				$return .= "\t\t\t\t<td style='text-align:left'>".date("Y-m-d H:i",time())."</td>\n";
				$return .= "\t\t\t</tr>\n";
				$return .= "\t\t\t<tr>\n";
				$return .= "\t\t\t\t<th style='text-align:left' scope = 'row'>Name</th>\n";
				$return .= "\t\t\t\t<td style='text-align:left'>".$name."</td>\n";
				$return .= "\t\t\t</tr>\n";
				$return .= "\t\t</thead>\n";
				$return .= "\t\t<tbody>\n";
				$cnt = 1;
				$alternate = "";
				foreach($output as $row)
				{
					$row = htmlentities($row);
					$row = str_replace(" ","<em style='color:red'>.</em>",$row);
					if (is_null($var))
					{
						$row = "<p style='color:red'>null</p>";
					};
					if (($cnt%2) == 0) {
						$alternate = " style='background-color:aliceblue' ";
					} else {
						$alternate = "";
					}
					$return .= "\t\t\t<tr$alternate>\n";
					$return .= "\t\t\t\t<th  style='text-align:right;padding-right:10px;' scope = 'row'>".$cnt++."</th>\n";
					$return .= "\t\t\t\t<td style='text-align:left'>".$row."</td>\n";
					$return .= "\t\t\t</tr>\n";
				}
				$return .= "\t\t</tbody>\n";
				$return .= "\t\t<tfoot>\n";
				$return .= "\t\t</tfoot>\n";
				$return .= "\t<table>\n";
				$return .= "\n\n";
			}
			return $return;
		}
	}
}
?>