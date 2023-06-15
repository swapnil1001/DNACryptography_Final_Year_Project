<?php
error_reporting(E_ALL ^ E_NOTICE);
//$folder_name = "cryptography/";
$upload_file = basename($_FILES["fileToUpload"]["name"]);
$upload_file2 = basename($_FILES["fileToUpload2"]["name"]); 
$uploadOk = 1;
if(isset($_POST["btn-submit"])){
	$uploadfile_type = strtolower(pathinfo($upload_file,PATHINFO_EXTENSION));
	$uploadfile_type2 = strtolower(pathinfo($upload_file2,PATHINFO_EXTENSION));
	//echo "$uploadfile_type<br>";
	//echo "$uploadfile_type2<br>";
	if($uploadfile_type != "txt" || $uploadfile_type2 != "txt") {
    echo "Sorry, txt files are allowed.";
    $uploadOk = 0;
   }
   else{
     //echo "Text files are chosen<br>";
     $uploadOk = 1;
   }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000 || $_FILES["fileToUpload2"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
      } 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $upload_file) && move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $upload_file2)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        echo "The file ". basename( $_FILES["fileToUpload2"]["name"]). " has been uploaded.";
     } 
    else {
       //echo "Sorry, there was an error uploading your file.";
    }
 }
?>
