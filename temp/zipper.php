<?php
if(isset($_POST['submit']) && isset($_POST["name"]) && !empty($_POST["name"])){
    $name = $_POST["name"];
    $download_name = $name.'.zip';
// Get real path for our folder
$rootPath = realpath('xml_upload_files/'.$name);

// Initialize archive object
$zip = new ZipArchive();
$zip->open('xml_upload_files/'.$name.'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
//rmdir("xml_upload_files/".$name);
header("Location:xml_upload_files/download.php?name=$download_name");
}
else{
    header('Location:index.html');
}
?>