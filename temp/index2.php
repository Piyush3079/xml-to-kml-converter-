<?php
$txt='/'.$_GET['text'];

echo $txt;

?>
<!DOCTYPE html>
<html>
<head>
<?php echo '<script type="text/javascript" src="https://cdn.rawgit.com/abdmob/x2js/master/xml2json.js"></script>
<script type="text/javascript" src="script.js"></script>'; ?>
</head>
<body>
    <h1>XML2CSV Demo</h1>
    <button id="convertToXmlBtn" onclick="xmlTocsv()">XML => CSV</button>
    <button id="convert" onclick="savecsv()">save csv</button>
  
    <div>        
        <h4>XML:</h4>
        <textarea id="xmlArea" cols="55" disabled rows="15"><?php include($txt); ?></textarea>
    </div>
    
    <div>
        <h4>CSV:</h4>
        <textarea id="csvArea" cols="55" rows="15"></textarea>
    </div>    
</body>
<script type="text/javascript">document.getElementById("convertToXmlBtn").click();</script>
</html>