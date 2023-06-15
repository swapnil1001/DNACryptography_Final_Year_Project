<HTML>
<HEAD>
<TITLE>DNA CRYPTOGRAPHY|DECRYPTION</TITLE>	
<script type="text/javascript" src="decryption.js"></script> 
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="decryption.css">
</HEAD>
<BODY>
<style>
#btn-decrt
{
  padding: 10px 20px;
  background: #4CAF50;;
  border: 0;
  color: #fff;
  display:inline-block;
  margin-top:20px;
  cursor: pointer;
  border-radius: 15px;
  box-shadow: 0 5px #666;
}
#btn-decrt:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
#btn-decrt:disabled{
  padding: 10px 20px;
  background: #CCC;
  border: 0;
  color: #FFF;
  display:inline-block;
  margin-top:20px;
  cursor: no-drop;
  box-shadow: 0 5px #666;
  border-radius: 15px;
}
</style>
<!--***********************HEADER DESIGN************************************-->
<?php
include "head.html";
?>
<br>
<br>
<h2 align="center">DECRYPTION USING 10x10 DNA PLAYFAIR</h1>
<h5 align="center"><font color="red">**Choose any one of the method for decryption(either by uploading files or by entering text).</font></h4>
<!--***************************FIRST FORM ENCRYPTION USING FILE**********************-->
<form action="" id="frm" method="post" enctype="multipart/form-data" style="padding-left:60px;float:left;width:50%;padding-top:20px;">
   <h4>Upload Files for Decryption</h4>
   <div class="input-group">Cipher Text <span class="fileToUpload-validation validation-error"></span></div>
   <div>
        <input type="file" name="fileToUpload" id="fileToUpload" class="input-control" onblur="validate()" />
   </div>
   <div class="input-group">Keyword  <span class="fileToUpload2-validation validation-error"></span></div>
   <div>
		<input type="file" name="fileToUpload2" id="fileToUpload2" class="input-control" onblur="validate()" />
   </div>
   <div>
        <button type="submit" name="btn-submit" id="btn-submit" disabled="disabled">Submit Files</button>
        <button type="submit" name="btn-decrt"  id="btn-decrt">Decrypt</button>
   </div> 
   <br>
   <b><font color="green"><?php include 'fileupload.php' ?></font></b>
</form>
<!--********************************SECOND FORM ENCRYPTION BY ENTERING TEXT*********************-->
<form action="" id="" method="post" enctype="multipart/form-data" style="padding-left:60px; padding-top:17px;">
   <h4>Enter text for Decryption</h4>
   <div class="input-group">Cipher Text <span class="ciphertextarea-validation validation-error"></span></div>
   <div>
      <textarea name="ciphertextarea" id="ciphertextarea" placeholder="Click here to enter the cipher text"class="input-control" onblur="validated()" rows="1"  cols="50"></textarea>
   </div>
   <div class="input-group">Keyword<span class="keywordtextarea-validation validation-error"></span></div>
   <div>
    <textarea name="keywordtextarea" id="keywordtextarea" placeholder="Click here to enter the keyword"class="input-control" onblur="validated()" rows="1" cols="50"></textarea>
   </div>
   <div>
        <button type="submit" name="btn-decrypt" id="btn-decrypt" disabled="disabled">Decrypt</button>
    </div>
    <?php include 'decrypt.php' ?> 
</form>
<br>
<br>
<br>
<br>
<font face="sans-serif"><h4 align="left" style="margin-left:60px;">Plain Text:</h4></font>
<table>
<tr>
<td><textarea readonly="readonly" placeholder="Decrypted plain text"align=left rows="3" cols="100" id="myInput" style="margin-left:60px;margin-bottom:20px;">
<?php include 'printplain.php' ?>
</textarea></td>
<td><button class="btn" onclick="document.getElementById('myInput').value = ''">CLEAR</button></td> 
</tr>
</table>
<!--******FOOTER DESIGN******-->
<?php include 'foot.html'?> 
</BODY>
</HTML>