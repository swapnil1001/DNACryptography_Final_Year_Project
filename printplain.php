<?php
$x=file_exists("de_decryptionplain.txt");
if($x){
$file = "de_decryptionplain.txt";
echo file_get_contents($file); 
}
else{
	echo "";
}
?>