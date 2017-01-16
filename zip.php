<?php
	//form submission
	if(isset($_POST['submit']) && isset($_POST["name"]) && !empty($_POST["name"])){
		$name = $_POST["name"];
		if(is_dir('xml_upload_files/'.$name.'/temp')){
		$files=glob("./xml_upload_files/".$name."/temp/*.kml");
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
				$x_value[] =  $x_number;
			}
			}
			$x_max = max($x_value);
			$x = $x_max;
			//echo "Vijay";
		}
		else{
			$x = 0;
			$y = 0;
			//echo "Piyush";
		}
		$dir = 'xml_upload_files/'.$name;
		if (!is_dir($dir)){
		mkdir('xml_upload_files/'.$name ,0777 ,true);
		}	
		$total = $_FILES['upload']['name'];
		$tmpFilePath = $_FILES['upload']['tmp_name'];
		$ext = explode(".", $total);
		//var_dump($ext);
		$newFilePath = "./xml_upload_files/" . $name."/" .$name.".".$ext[1];
		//echo $newFilePath;
	    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
	      //echo "Form submitted succesfully";
	    }
		//directory creating
		$dir = 'xml_upload_files/'.$name.'/temp';
		if (!is_dir($dir)){
		mkdir('xml_upload_files/'.$name.'/temp', 0777, true);
		//copy test.xml
		copy('xml_upload_files/test1.xml', 'xml_upload_files/'.$name.'/temp/test1.xml');
		}
		// assuming file.zip is in the same directory as the executing script.
		$file = $newFilePath;
		// get the absolute path to $file
		$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
		$zip = new ZipArchive;
		$res = $zip->open($file);
		if ($res === TRUE) {
		  // extract it to the path we determined above
		  $zip->extractTo($path);
		  $zip->close();
		  unlink($newFilePath);
		} else {
		  echo "Doh! I couldn't open $file";
		}
$note=<<<XML
<kml xmlns= "http://www.opengis.net/kml/2.2">
<Document>
</Document>
</kml>
XML;
$filenames = glob("./xml_upload_files/".$name."/*.xml");
foreach($filenames as $file){
	$xml1=new SimpleXMLElement($note);
	$xml = simplexml_load_file($file);
	$value3 = (string) $xml->observations[0]->observation[0]->featuretype;
	$value0 = (string) $xml->projectdetails[0]->profilename;
	//echo $value0;
	$value1 = (string) $xml->observations[0]->observation[0]->gpsdetails[0]->featurecoords;
	$coord = split(" ", $value1);
	$longitude = $coord[0]."<br>";
	$latitude = $coord[1];
	$accuracy = (string) $xml->observations[0]->observation[0]->gpsdetails[0]->accuracy;
	$altitude = (string) $xml->observations[0]->observation[0]->gpsdetails[0]->altitude;
	$param_general = '<![CDATA[<html xmlns:fo="http://www.w3.org/1999/XSL/Format" xmlns:msxsl="urn:schemas-microsoft-com:xslt">
						<head><META http-equiv="Content-Type" content="text/html"><meta http-equiv="content-type" content="text/html; charset=UTF-8"></head>
						<body style="margin:0px 0px 0px 0px;overflow:auto;background:#FFFFFF;"><table style="font-family:Arial,Verdana,Times;font-size:12px;text-align:left;width:100%;border-collapse:collapse;padding:3px 3px 3px 3px">
					<thead>
						<trstyle="text-align:center;font-weight:bold;background:#9CBCE2"><td>'.$value0.'</td></tr>
					</thead>
					<tbody>
						<tr>
							<td>Latitude</td>
							<td>'.$latitude.'</td>
						</tr>
						<tr>
							<td>Longitede</td>
							<td>'.$longitude.'</td>
						</tr>
						<tr>
							<td>Accuracy</td>
							<td>'.$accuracy.'</td>
						</tr>
						<tr>
							<td>Altitude</td>
							<td>'.$altitude.'</td>
						</tr>';
	foreach($xml->observations[0]->observation[0]->params[0]->param as $temp){
		$attribute = $temp[0]->paramname;
		$attr_value = $temp[0]->paramvalue;

			$param_general .= '<tr>
				<td>'.$attribute.'</td>
				<td>'.$attr_value.'</td>
			</tr>
		';
	}
	$param_td = '</tbody></table></body></html>]]>';
	$description_table = $param_general.$param_td;
	//echo $value1;
	if($value3 == "Point"){
		//echo "Piyush";
	}
	if($value3 == "Poly"){
		//echo "PiyushVijay";
	}
	if($value3 == "Line"){
		//echo "Why";
	}
	if($value3 == "Point"){
		$value2 = str_replace(' ', ',', $value1);
		//if(!file_exists('xml_upload_files/'.$name.'/temp/Point.kml'))
		$folder = $xml1->Document->addChild('Folder');
		$folder->addChild('name', $value0);		
		$valuew = $folder;	
		$valuex = $valuew->addChild('Placemark');
		$valuex->addChild('name', $value0);
		$valuex->addChild('description', $description_table);
		$valuey = $valuex->addChild('Point');
		$valuey->addChild('altitudeMode', 'clampToGround');
		$valuey->addChild('coordinates', $value2.','.$altitude);
		$file2 = $xml1->asXML('xml_upload_files/'.$name.'/temp/Points.xml');
			$doc1 = new DOMDocument();
			$doc1->load('xml_upload_files/'.$name.'/temp/test1.xml');
			$doc2 =new DOMDocument();
			$doc2 ->load('xml_upload_files/'.$name.'/temp/Points.xml');
			// get 'res' element of document 1
			$res1 = $doc1->getElementsByTagName("Document")->item(0); //edited res - items
			// iterate over 'item' elements of document 2
			$items2 = $doc2->getElementsByTagName("Folder");
				for ($i = 0; $i < 1; $i++) {
				    $item2 = $items2->item($i);
				    // import/copy item from document 2 to document 1
				    $item1 = $doc1->importNode($item2, true);
				    // append imported item to document 1 'res' element
				    $res1->appendChild($item1);
				$doc1->save('xml_upload_files/'.$name.'/temp/test1.xml'); //edited -added saving into xml file
			}
			unlink('xml_upload_files/'.$name.'/temp/Points.xml');
		}
	if($value3 == "Poly" || $value3 == "Line"){
		$value = $value1;
		$array = split(",", $value);
		$array_data = array();
		//print_r($array);
		$total = count($array);
		for($i=0;$i<$total;$i++){
			$latlong = str_replace(" ",",",$array[$i]);
			$array_data[] = $latlong;
		}
			$total1 = count($array_data);
			$latlong123 = "";
			for($k=0;$k<$total1;$k++){
				$latlong123 .= $array_data[$k].",0 ";
			}
			$latlon = $latlong123;
				$valuew = $xml1->Document;
				$valuew->addChild('name', $value0);
				//foreach($array_data as $latlon){
					//$latlon = $array_data[$j];
					$valuex = $valuew->addChild('Placemark');
					$valuex->addChild('name', $value0);
					$valuex->addChild('description', $description_table);
					if($value3 == "Poly"){
					$valuey = $valuex->addChild('Polygon');
					$valuea = $valuey->addChild('outerBoundaryIs');
					$valueb = $valuea->addChild('LinearRing');
					$valueb->addChild('coordinates', $latlon);
					$string = "Polygon_";
					}
					else{
						$valuea = $valuex->addChild('LineString');
						$valueb = $valuea->addChild('coordinates', $latlon);
						$string = "Line_";
					}
				$x++;
				$xml1->asXML('xml_upload_files/'.$name.'/temp/'.$string.$x.'.kml');
		//print_r($array_data);
		}
		unlink($file);
	}
		$doc2->load('xml_upload_files/'.$name.'/temp/test1.xml');
		$doc1->save('xml_upload_files/'.$name.'/temp/Points.kml');
		header('Location:index.html');
	}
	else{
		header('Location: index.html');
	}
?>