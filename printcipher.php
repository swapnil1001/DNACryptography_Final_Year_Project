<?php
$x=file_exists("en_finalcipher.txt");
if($x){
$file = "en_finalcipher.txt";
echo file_get_contents($file); 
}
else{
	echo "";
}
?>