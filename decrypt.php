<?php
error_reporting(E_ALL ^ E_NOTICE);
//--------------------------------GLOBAL VARIABLES-----------------------------------//
$splitted_finalciphertext = array();
$remain_finalcipher=array();
$dinterweave=array(array());
$dnasequence=array();
$dbinary=array();
$din=0;
$dasciikeyword=array();
$dkeyminus=array();
$dsubmatrix=array(array());
$dp=0;
$dplaintext=array();
$dasciivalue=array();
//-------------------Reading FinalcipherText From File cipher.txt----------------//
function decryption_finalcipher(){ 
    global $splitted_finalciphertext;
    $fp = fopen("en_finalcipher.txt", "r")// does the work of file as in C language "*fp"//
    or die("UNABLE TO OPEN THE FILE");
    $final_ciphertext=fread($fp, filesize("en_finalcipher.txt")); 
    fclose($fp);//closes the file//
    //echo "CIPHER TEXT = $final_ciphertext<br>";//prints $keyword variable which stores the content of the file//
    $splitted_finalciphertext = str_split($final_ciphertext);
    $len_finalcipher=count($splitted_finalciphertext);
    //echo "Array length of ciphertext = ".count($splitted_finalciphertext)."<br>";
    //echo "<br>";
    //print_r($splitted_finalciphertext);
    return $len_finalcipher;
}
//---------------Constructing Interweaving Matrix--------------------//
function decryption_interweavematrix($inmatrix_order,$len_finalcipher)
 {
    global $splitted_finalciphertext;
    global $remain_finalcipher;
    global $dinterweave;
     $k=0;
    //echo "<br>"."INTERWEAVE SQUARE MATRIX AFTER ROTATION OF ORDER $inmatrix_order :"."<br>";
     
      for($i=0;$i<$inmatrix_order;$i++)
      {
        for($j=0;$j<$inmatrix_order;$j++) 
        {
          $dinterweave[$j][$i]=$splitted_finalciphertext[$k];
          $k++;
        }
      }
    //------------Printing dinterweave matrix-----------// 
     for($i=0;$i<$inmatrix_order;$i++)
     {
        for($j=0;$j<$inmatrix_order;$j++) 
        {
      //    printf("  ".$dinterweave[$i][$j]."  ");
        }
      //echo"<br>"; 
     } 
     //------------Remaining Sequence-------------------//
    $remlen_cipher=$len_finalcipher-$k;
    for($i=0;$i<$remlen_cipher;$i++)
    {
       $remain_finalcipher[$i]=$splitted_finalciphertext[--$len_finalcipher];
        }
    //echo"Remaing Sequence in reverse order: "; 
    //print_r($remain_finalcipher); 
}
//------------------INVERSE INTERWEAVING METHOD----------------//
function decryption_inverseinterweaving($inmatrix_order)
{
  global $dinterweave;
  for($i=$inmatrix_order-1;$i>=0;$i--){
    $k=$dinterweave[$i][$inmatrix_order-1];
   for($j=$inmatrix_order-1;$j>=1;$j--){
      $dinterweave[$i][$j]=$dinterweave[$i][$j-1];
       }  
   $dinterweave[$i][0]=$k;
     $k=$dinterweave[$inmatrix_order-1][$i];
      for($j=$inmatrix_order-1;$j>=1;$j--){
        $dinterweave[$j][$i]=$dinterweave[$j-1][$i];
    }
    $dinterweave[0][$i]=$k;  
  }
  //------------Printing original dinterweave matrix-----------//
    //echo "<br>";
    //echo "Original Interweave Matrix :<br>";
     for($i=0;$i<$inmatrix_order;$i++){
        for($j=0;$j<$inmatrix_order;$j++) {
      //printf(" ".$dinterweave[$i][$j]." ");
       }
      //echo "<br>";
     } 
}
//-------------Constructing Original Dna Sequence-------------//
function decryption_dnasequence($len_finalcipher,$inmatrix_order)
{
  global $remain_finalcipher;
  global $dinterweave;
  global $dnasequence;
  //echo "<br>Original DNA sequence:<br>";
  for($i=0;$i<count($remain_finalcipher);$i++){
    $dnasequence[$i]=$remain_finalcipher[$i];
  }
     $k=count($remain_finalcipher);
    for($i=$inmatrix_order-1;$i>=0;$i--){
        for($j=$inmatrix_order-1;$j>=0;$j--) {
      $dnasequence[$k]=$dinterweave[$j][$i];
      $k++;
       }
      }
  //for($i=0;$i<$len_finalcipher;$i++)
   //echo $dnasequence[$i];
}
//------------------------------DNA TO BINARY--------------------------------------//
function decryption_dnatobinary($ch1)
{  
  global $dbinary; 
  global $din;
  $a=0;
  $c=1;
  $g=10;
  $t=11;
  $fp=fopen("de_dnatobinary.txt","a+");  
  if($ch1=='A')
  {
      $dbinary[$din]=0;
      $dbinary[$din+1]=0;     
      $din=$din+2;
     // echo "$a$a";
      fprintf($fp,"%u%u",$a,$a);
    }
  else if($ch1=='C')
  {
      $dbinary[$din]=0;
      $dbinary[$din+1]=1; 
      $din=$din+2;
     // echo "$a$c";
      fprintf($fp,"%u%u",$a,$c);
    }
  else if($ch1=='G')
  {
      $dbinary[$din]=1;
      $dbinary[$din+1]=0;
      $din=$din+2;
      //echo"$g";
      fprintf($fp,"%u",$g);
    }
  else
  {
      $dbinary[$din]=1;
      $dbinary[$din+1]=1;
      $din=$din+2;
      //echo"$t";
      fprintf($fp,"%u",$t);
    }
  fclose($fp);
}
function decryption_sendingdna()
{
    global $dnasequence;
    //echo"<br> Binary value of the dna sequence:";  
    for ($i = 0; $i<count($dnasequence); $i++) {    
    decryption_dnatobinary($dnasequence[$i]);     
    }    
  }
//-------------------------Binary to ascii----------------------------//
function decryption_binarytoascii($len_finalcipher)
{
	global $dbinary;
	global $dasciivalue;
	//echo"<br> ASCII VALUE OF THE BINARY DATA:";
  $len_dascii=0;
	$i=0;
	$k=0;
	$j=0;
	$sum=0;
	$l=0;
	for($i=0;$i<($len_finalcipher/4);$i++)
	{
	   	$sum=0;
		  for($j=7;$j>=0;$j--)
		  {
			 if($dbinary[$k]==1)
			   {
			     $sum=$sum+pow(2,$j);
			     } 
			 else
			   {
			     $sum=$sum+0;
		        }
  			$k++;    
	       }
		  $dasciivalue[$l]=$sum; 
		  $l++;
	   }
	  for($i=0;$i<($len_finalcipher/4);$i++)
	  // echo" $dasciivalue[$i]";
	  $len_dascii=$i;
    //echo"<br>";
	  return $len_dascii;
}
//-----------------------INTERMEDIATE CIPHER TEXT TO PLAIN TEXT------------------------//
function decryption_inciphertoplain( $len_dascii)
{
   global $dasciivalue;	
   $i=0;
   $len_keyword=0;  
   $len_keyword=decryption_keyword();  
   $len_keyword=decryption_eliminateduplicate($len_keyword);
   decryption_exceptkeyword($len_keyword);
   decryption_substitutionmatrix($len_keyword);
   for ($i = 0; $i < $len_dascii; $i=$i+2) 
     {       
       decryption_playfair($dasciivalue[$i], $dasciivalue[$i + 1]);    
       }  
 }
//----------------READING DECRYPTION KEYWORD FROM FILE---------------------------//
function decryption_keyword()
{
  $i=0;
  $x=0;
  global $dasciikeyword;
  $k=0;
  $fp=fopen("keyword.txt","r")
  or die("UNABLE TO OPEN THE FILE");
  $keyword = fread($fp, filesize("keyword.txt"));
  fclose($fp);
   $splitted_keyword = str_split($keyword);
  // echo"<br> KEYWORD: ";
   //print_r($splitted_keyword);
   //echo"<br>";
 for($x=0; $x<count($splitted_keyword); $x++)
   {  
     $dasciikeyword[$x]=ord($splitted_keyword[$x]);
     //echo $dasciikeyword[$x];
     //echo" ";
     }
  $k=count($dasciikeyword);
   return $k;
}
//---------------------ELIMINATING DUPLICATE KEYWORD--------------------------//
function decryption_eliminateduplicate($len_keyword)
{
     global $dasciikeyword;
     $i=0;
     $j=0;
     $k=0;
     $x=0;
    for ($i=0; $i<$len_keyword; $i++)
     {
        for ($j = $i + 1; $j < $len_keyword;)
        {
         if ($dasciikeyword[$j] == $dasciikeyword[$i]) 
          {
           for ($k = $j; $k < $len_keyword; $k++) 
            {
              $dasciikeyword[$k]=$dasciikeyword[$k + 1];
               }
           $len_keyword--;
            } 
          else
            $j++;
          }
        }
    for($x=0;$x<$len_keyword;$x++)
     {  
       //echo $dasciikeyword[$x];
       //echo" ";
       }
    //echo"$dasciikeyword"; 
    //echo"<br>";
   // echo"$len_keyword";
    return $len_keyword;
  }
//------------------------STORING ALL CHARACTERS EXCEPT KEYWORD IN DKEYMINUS ARRAY-----------------------//
function decryption_exceptkeyword($len_keyword)
   { 
     global $dasciikeyword; 
     global $dkeyminus;
     $i=0;
     $k=0;
     $j=0;
   //space=32,plus_minus=241,divide=246,copyright=184,pound=156,registered=169,equivalent=240,yen=190,micro=230,alpha=242,squareroot=251,undefined=236;
   //Latin diphthong ae in lowercase=145;
     $dalphabet=array(  
     65,66,67,68,69,70,71,72,73,74,
     75,76,77,78,79,80,81,82,83,84,
     85,86,87,88,89,90,97,98,99,100,
     101,102,103,104,105,106,107,108,109,110,
     111,112,113,114,115,116,117,118,119,120,
     121,122,48,49,50,51,52,53,54,55,
     56,57,33,64,35,36,37,94,38,42,
     43,61,40,123,91,41,125,93,58,59,
     46,44,63,95,45,34,47,60,62,126,
     32,246,145,241,124,248,240,251,243,242);
    //------------------------------------------// 
    for ($i = 0; $i<100; $i++) 
    {  
      for ($k = 0; $k < $len_keyword; $k++) 
      {  
         if ($dasciikeyword[$k] == $dalphabet[$i])
           break;    
      }  
        if ($k == $len_keyword) 
        {  
            $dkeyminus[$j] = $dalphabet[$i];  
            $j++;  
        }  
      } 
} 
//---------------------CONSTRUCTION OF 10X10 SUBSTITUTION MATRIX------------------------//
function decryption_substitutionmatrix($len_keyword)
{
    global $dasciikeyword; 
    global $dsubmatrix;
    global $dkeyminus;
    $i=0;
    $j=0;
    $k=0;
    $m=0;
    $n=0;  
    //n=strlen(keyword); //-------------------//
    //echo"<br> 10x10 SUBSTITUTION MATRIX ";
    //echo"<br>";  
    for($i = 0; $i < 10; $i++) 
    {  
      for ($j = 0; $j < 10; $j++) 
        {  
         if ($k < $len_keyword) 
          {  
            $dsubmatrix[$i][$j] = $dasciikeyword[$k];  
            $k++;  
            } 
         else 
            {  
             $dsubmatrix[$i][$j] = $dkeyminus[$m];  
             $m++;  
              }  
      //      echo" ".chr($dsubmatrix[$i][$j])." "; 
         }  
        // printf("<br>");  
      } 
}
//---------------------PLAYFAIR FUNCTION---------------------------------//
function decryption_playfair($ch1, $ch2) 
{  
	global $dsubmatrix;
	global $dp;
	global $dplaintext;
    $i=0;
    $j=0;
    $column_ch1=0;
    $row_ch1=0;
    $column_ch2=0;
    $row_ch2=0;
    $len_dascii=2;

    for ($i = 0; $i < 10; $i++) 
    {  
        for ($j = 0; $j < 10; $j++) 
        {  
            if ($ch1 == $dsubmatrix[$i][$j]) 
            {  
                $row_ch1 = $i;
				$column_ch1 = $j;    
            } 

            else if ($ch2 == $dsubmatrix[$i][$j]) 
            {  
                $row_ch2 = $i;
				$column_ch2 = $j;    
            }  
        }  
    }

    if($row_ch1 == $row_ch2) 
    {  
        $column_ch1 = ($column_ch1 - 1) % 10;  
        $column_ch2 = ($column_ch2 - 1) % 10;  
        if($column_ch1<0)
        {
        	$column_ch1=10+$column_ch1;
		}
        if($column_ch2<0)
        {
        	$column_ch2=10+$column_ch2;
		}
		$dplaintext[$dp]=$dsubmatrix[$row_ch1][$column_ch1];
	    $dplaintext[$dp+1]=$dsubmatrix[$row_ch2][$column_ch2]; 		
     	$dp=$dp+2; 
    }

    else if ($column_ch1 == $column_ch2) 
    {  
        $row_ch1 = ($row_ch1 - 1) % 10;   
        $row_ch2 = ($row_ch2 - 1) % 10;  
        if($row_ch1<0)
        {
        	$row_ch1=10+$row_ch1;
		}
        if($row_ch2<0)
        {
        	$row_ch2=10+$row_ch2;
		}
		$dplaintext[$dp]=$dsubmatrix[$row_ch1][$column_ch1];
	    $dplaintext[$dp+1]=$dsubmatrix[$row_ch2][$column_ch2]; 		
     	$dp=$dp+2;
    }

	else 
	{  
	    $dplaintext[$dp]=$dsubmatrix[$row_ch1][$column_ch2];
	    $dplaintext[$dp+1]=$dsubmatrix[$row_ch2][$column_ch1]; 		
     	$dp=$dp+2;
    }
}
//----------------------------PRINTING PLAINTEXT-----------------------------//
function decryption_printplaintext( $len_dascii)
{
  global $dplaintext;
	 $z=0;
	 $i=0;
	 $k=0;
	 $Z=0;
	$fp = fopen("de_decryptionplain.txt", "a+")
    or die("UNABLE TO THE FILE");
	for ($i = 0; $i < $len_dascii;)
	{
	 if ($dplaintext[$i] == 145) 
	   {
			for ($k = $i; $k < $len_dascii; $k++) 
		   	{
					$dplaintext[$k] = $dplaintext[$k+1];
			      }
      $len_dascii--;
          } 
    else
      $i++;
    }
	//echo"<br> PLAIN TEXT: ";
	for($z=0;$z<$len_dascii;$z++) 
	  {
  //     echo chr($dplaintext[$z]); 
        fwrite ($fp,chr($dplaintext[$z]));
    	}	
}
//------------------Function calling----------------------//
if(isset($_POST["btn-decrt"])){
fclose(fopen("de_dnatobinary.txt","w"));
fclose(fopen("de_decryptionplain.txt","w"));
$len_finalcipher = decryption_finalcipher();
$inmatrix_order=(int)sqrt($len_finalcipher);
decryption_interweavematrix($inmatrix_order,$len_finalcipher);
decryption_inverseinterweaving($inmatrix_order);
decryption_dnasequence($len_finalcipher,$inmatrix_order);
decryption_sendingdna();
$len_dascii=decryption_binarytoascii($len_finalcipher);
decryption_inciphertoplain($len_dascii);
decryption_printplaintext($len_dascii);
}
if(isset($_POST["btn-decrypt"])){
$ciphertextarea = $_POST['ciphertextarea'];
$keywordtextarea = $_POST['keywordtextarea'];
$fc = fopen("en_finalcipher.txt", "w");
$fk = fopen("keyword.txt", "w");
fwrite($fc, $ciphertextarea);
fwrite($fk, $keywordtextarea);
fclose($fc);  
fclose($fk);
fclose(fopen("de_dnatobinary.txt","w"));
fclose(fopen("de_decryptionplain.txt","w"));
$len_finalcipher = decryption_finalcipher();
$inmatrix_order=(int)sqrt($len_finalcipher);
decryption_interweavematrix($inmatrix_order,$len_finalcipher);
decryption_inverseinterweaving($inmatrix_order);
decryption_dnasequence($len_finalcipher,$inmatrix_order);
decryption_sendingdna();
$len_dascii=decryption_binarytoascii($len_finalcipher);
decryption_inciphertoplain($len_dascii);
decryption_printplaintext($len_dascii);
}
?>