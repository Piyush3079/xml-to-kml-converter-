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
		copy('xml_upload_files/test.xml', 'xml_upload_files/'.$name.'/temp/test.xml');
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

		// assuming file.zip is in the same directory as the executing script.
		/*$file = 'samples.zip';

		// get the absolute path to $file
		$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

		$zip = new ZipArchive;
		$res = $zip->open($file);
		if ($res === TRUE) {
		  // extract it to the path we determined above
		  $zip->extractTo($path);
		  $zip->close();
		  echo "WOOT! $file extracted to $path";
		} else {
		  echo "Doh! I couldn't open $file";
		}*/


		/*$zip = zip_open("test.zip");

		if ($zip)
		  {
		  while ($zip_entry = zip_read($zip))
		    {
		    echo "<p>";
		    echo "Name: " . zip_entry_name($zip_entry) . "<br />";

		    if (zip_entry_open($zip, $zip_entry))
		      {
		      echo "File Contents:<br/>";
		      $contents = zip_entry_read($zip_entry);
		      echo "$contents<br />";
		      zip_entry_close($zip_entry);
		      }
		    echo "</p>";
		  }

		zip_close($zip);
		}*/






		//XML merging function
		$filenames = glob("./xml_upload_files/".$name."/*.xml");
		//print_r($filenames);
		foreach($filenames as $file){
		$doc1 = new DOMDocument();
		$doc1->load('xml_upload_files/'.$name.'/temp/test.xml');
		$doc2 =new DOMDocument();
		$doc2 ->load($file);

		// get 'res' element of document 1
		$res1 = $doc1->getElementsByTagName('paramcollected')->item(0); //edited res - items

		// iterate over 'item' elements of document 2
		$items2 = $doc2->getElementsByTagName('observations');
			for ($i = 0; $i < 1; $i++) {
			    $item2 = $items2->item($i);
			    
			    // import/copy item from document 2 to document 1
			    $item1 = $doc1->importNode($item2, true);

			    // append imported item to document 1 'res' element
			    $res1->appendChild($item1);
			    unlink($file);
			}
			$doc1->save('xml_upload_files/'.$name.'/temp/test.xml'); //edited -added saving into xml file
		}
		$doc2->load('xml_upload_files/'.$name.'/temp/test.xml');
		$doc1->save('xml_upload_files/'.$name.'/temp/test.txt');
		$txt = 'xml_upload_files/'.$name.'/temp/test.txt'; 
		header('Location:index2.php?text=$txt');
	}
	else{
		header('Location: index.html');
	}
?>