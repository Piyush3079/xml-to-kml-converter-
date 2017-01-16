<?php
		//form submission
	if(isset($_POST["name"]) && !empty($_POST["name"])){
		$name = $_POST["name"];
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
		$filenames = glob("./xml_upload_files/".$name."/*.xml");
		//print_r($filenames);
		for ($j = 0; $j < 2; $j++) {
			if($j%2==0){
				$var='observations';
				$var1 = 'featurecoords';
			}
			else
			{
				$var='projectdetails';
				$var1 = 'profilename';
			}
		foreach($filenames as $file){
		$doc1 = new DOMDocument();
		$doc1->load('xml_upload_files/'.$name.'/temp/test1.xml');
		$doc2 =new DOMDocument();
		$doc2 ->load($file);

		// get 'res' element of document 1
		$res1 = $doc1->getElementsByTagName($var)->item(0); //edited res - items
		// iterate over 'item' elements of document 2
		$items2 = $doc2->getElementsByTagName($var1);
			for ($i = 0; $i < 1; $i++) {
			    $item2 = $items2->item($i);
			    
			    // import/copy item from document 2 to document 1
			    $item1 = $doc1->importNode($item2, true);

			    // append imported item to document 1 'res' element
			    $res1->appendChild($item1);
			    if($j%2==1){
			    unlink($file);}
			}
			$doc1->save('xml_upload_files/'.$name.'/temp/test1.xml'); //edited -added saving into xml file
		}}
		$doc2->load('xml_upload_files/'.$name.'/temp/test1.xml');
		$doc1->save('xml_upload_files/'.$name.'/temp/test1.txt');
		$txt = 'xml_upload_files/'.$name.'/temp/test1.txt'; 
		//header("Location:index2.php?text='$txt'");
	}
	else{
		//header('Location: index.html');
	}
?>