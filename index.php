<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {

if($imageFileType != "xml") {
    echo "Sorry only XML files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $myfile = fopen($target_file, "r") or die("Unable to open file!");
    $xml= fread($myfile,filesize($target_file));
    $doc = simplexml_load_string($xml);
    $oldValue = libxml_disable_entity_loader(true); // enable entity $
    $doc = simplexml_load_string($xml);
    libxml_disable_entity_loader($oldValue);

    $doc = simplexml_load_string($xml, null, LIBXML_NOENT);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}
?>

<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"></head><body>

<form action="" method="post" enctype="multipart/form-data" style="margin-left:30%;margin-top:10%;background-color:#e2e2e2;width:450px;padding:15px;border-radius: 20px;border: 2px solid black;">
   <p style="margin-left:30%;padding:10px;margin-top: 11px;">Select file to upload:</p>
    <input name="fileToUpload" id="fileToUpload" style="padding:1px;margin-left:30%;" type="file"><br><input value="Upload Contacts" name="submit" style="margin-top:20px;margin-left:125px;margin-bottom: 10px;" type="submit">
</form>

<div style="margin-left: 30%;background-color: black;width: 450px;padding: 15px;color: white;margin-top: 20px;border-radius: 20px;border: 2px solid #e2e2e2;">
<?php
for($x=0;$x<count($doc->name);$x++){
    echo $doc->name[$x]." : ".$doc->num[$x]."\n<br>";
}
?>
</div>

</body></html>
