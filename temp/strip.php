<?php

	$files=glob("./xml_upload_files/xxx/temp/*.kml");
	$tot = count($files);
	$x_value = array();
	for($m=0;$m<$tot;$m++){
		$dash1 = strpos($files[$m], '_') + 1;
		$dot = strpos($files[$m], '.')+2;
		$file1 = substr($files[$m], $dash1, ($dot - $dash1));
		$dash2 = strpos($file1, '_') + 1;
		$file2 = substr($file1, $dash2);
		$dash3 = strpos($file2, '_') + 1;
		$x_number = substr($file2, $dash3);
		if(strlen($x_number) < 6){
		$x_value[] =  $x_number;}
	}
$x_max = max($x_value);

?>