<?php

	$name = $_POST["name"];
	mkdir('xml_upload_files/'.$name ,0777 ,true);
	$total = $_FILES['upload']['name'];
	$tmpFilePath = $_FILES['upload']['tmp_name'];
	$ext = explode(".", $total);
	var_dump($ext);
	$newFilePath = "./xml_upload_files/" . $name."/" .$name.".".$ext[1];
	echo $newFilePath;
	
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
      echo "Form submitted succesfully";
    }
	

$zip = zip_open($newFilePath);
if ($zip) {
  while ($zip_entry = zip_read($zip)) {
    $fp = fopen("zip/".zip_entry_name($zip_entry), "w");
    if (zip_entry_open($zip, $zip_entry, "r")) {
      $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
      fwrite($fp,"$buf");
      zip_entry_close($zip_entry);
      fclose($fp);
    }
  }
  zip_close($zip);
}


/*
 * PHP Zip - Extract the contents of a zip archive
 */

//create a ZipArchive instance
/*$zip = new ZipArchive;
//open the archive
if ($zip->open('xml_upload_files/Party4/Party4.zip') === TRUE) {
    //extract contents to /data/ folder
    $zip->extractTo('xml_upload_files/Party4/');
    //close the archive
    $zip->close();
    echo 'Archive extracted to data/ folder!';
} else {
    echo 'Failed to open the archive!';
}*/

	


		
/*$filexml1='xml/sample_fdc_SISDP-Asset_AssetMapping_CA050201_Point_943f72c033bdee45_10_6_7_25_11_2016.xml';
$filexml2='xml/sample_fdc_SISDP-Asset_AssetMapping_CA050201_Point_943f72c033bdee45_10_6_15_28_11_2016.xml';

    //File 1
    if (file_exists($filexml1)) {
        $xml = simplexml_load_file($filexml1); 
        $f = fopen('csv/test.csv', 'w');

    $headers = array('LatLong', 'accuracy', 'altitude', 'speed', 'timestamp');
    $converted_array = array_map("strtoupper", $headers);


    fputcsv($f, $converted_array, ',', '"');


    
    	$gpsdetail = $xml->gpsdetails;
        //$phone->title = trim($phone->title, " ");
        // Array of just the components you need...
        $values = array(
           "LatLong" => (string)$gpsdetails->featurecoords, 
           "accuracy" => (string)$gpsdetails->accuracy,
           "altitude" => (string)$gpsdetails->altitude,
           "speed" => (string)$gpsdetails->speed,
           "timestamp" => (string)$gpsdetails->timestamp
        );
        print_r($values);
        fputcsv($f, $values,',','"');

    
    fclose($f); 

    echo "<p>File 1 coverted to .csv sucessfully</p>";
} else {
    exit('Failed to open test.xml.');
}*/

 /*   //File 2
    if (file_exists($filexml2)) {
        $xml = simplexml_load_file($filexml2); 
        $f = fopen('test.csv', 'a');


    //the same code for second file like for the first file

    echo "<p>File 2 coverted to .csv sucessfully</p>";
} else {
    exit('Failed to open test1.xml.');
}*/


	/*$file1 = 'xml/sample_fdc_SISDP-Asset_AssetMapping_CA050201_Point_943f72c033bdee45_10_6_7_25_11_2016.xml';
	//$file2 = 'xml/sample_fdc_SISDP-Asset_AssetMapping_CA050201_Point_943f72c033bdee45_10_6_15_28_11_2016.xml';
	$fileout = 'xml/fileout.xml';	$xml1 = simplexml_load_file( $file1 );
	//$xml2 = simplexml_load_file( $file2 );	// loop through the FOO and add them and their attributes to xml1
	foreach( $xml2->FOO as $foo ) {
		$new = $xml1->addChild( 'FOO' , $foo );
		foreach( $foo->attributes() as $key => $value ) {
			$new->addAttribute( $key, $value );
		}
	}	$fh = fopen( $fileout, 'w') or die ( "can't open file $fileout" );
	fwrite( $fh, $xml1->asXML() );
	fclose( $fh );*/

?>