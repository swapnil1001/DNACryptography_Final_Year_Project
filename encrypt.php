<?php
error_reporting(E_ALL ^ E_NOTICE);
//-----------------------------GLOBAL VARIABLES-----------------------//
$plaintext=array();
$asciikeyword=array();
$keyminus=array();
$len_keyword=0;
$submatrix=array(array());
$ascii_plaintext=array();
$in=0;
//$incipher=array();
$splitted_plaintext=array();
$incipher=array();
$binary=array();
$k=0;
$interweave=array(array());
$dna=array();
$remain_dna=array();
//----------------------------ENCRYPTION FUNCTION--------------------------//
function encryption_playfair($ch1,$ch2) 
{
global $ascii_plaintext;	
global $submatrix;
global $in;
global $incipher;
//echo "d1";
$i=0;
$j=0;
$column_ch1=0;
$row_ch1=0;
    $column_ch2=0;
    $row_ch2=0;
    $fp = fopen("en_intermediatecipher.txt", "a+")
     or die("UNABLE TO OPEN THE FILE");  
    //$en_intermediatecipher = fopen("de_dnatobinary.txt","a+");  
    for ($i = 0; $i < 10; $i++) 
    {  
        for ($j = 0; $j < 10; $j++) 
        {  
            if ($ch1 == $submatrix[$i][$j]) 
            {  
                $row_ch1 = $i; 
               $column_ch1 = $j;   
            }
             else if ($ch2 ==$submatrix[$i][$j]) 
            {  
                $row_ch2 = $i; 
                $column_ch2 = $j;   
            }  
        }  
    }  
   
    if($row_ch1 == $row_ch2) 
    {  
        $column_ch1 = ($column_ch1 + 1) % 10;  
        $column_ch2 = ($column_ch2 + 1) % 10;  
        $incipher[$in]=$submatrix[$row_ch1][$column_ch1];
      $incipher[$in+1]=$submatrix[$row_ch2][$column_ch2];    
      $in=$in+2;
  //    echo "hello";
       // echo chr($submatrix[$row_ch1][$column_ch1]).chr($submatrix[$row_ch2][$column_ch2]);  
        fprintf($fp, "%c%c", $submatrix[$row_ch1][$column_ch1], $submatrix[$row_ch2][$column_ch2]); 
    }
    else if ($column_ch1 == $column_ch2) {  
        $row_ch1 = ($row_ch1 + 1) % 10;   
        $row_ch2 = ($row_ch2 + 1) % 10;  
        $incipher[$in]=$submatrix[$row_ch1][$column_ch1];
      $incipher[$in+1]=$submatrix[$row_ch2][$column_ch2];    
      $in=$in+2;
    //  echo "hello1";
        //echo chr($submatrix[$row_ch1][$column_ch1]).chr($submatrix[$row_ch2][$column_ch2]);  
        fprintf($fp, "%c%c", $submatrix[$row_ch1][$column_ch1], $submatrix[$row_ch2][$column_ch2]);  
    }
  else {  
       $incipher[$in]=$submatrix[$row_ch1][$column_ch2];
         $incipher[$in+1]=$submatrix[$row_ch2][$column_ch1];
         $in=$in+2;
      //   echo "hello2";
      //  echo chr($submatrix[$row_ch1][$column_ch2]).chr($submatrix[$row_ch2][$column_ch1]);  
        fprintf($fp, "%c%c", $submatrix[$row_ch1][$column_ch2], $submatrix[$row_ch2][$column_ch1]);  
    }  
    fclose($fp);  
}
//------------------------READING PLAINTEXT FROM FILE----------------------------------//
function encryption_plaintext(){
  global $plaintext;
  global $ascii_plaintext;
   $fp = fopen("plain.txt", "r")// does the work of file as in C language "*fp"//
    or die("UNABLE TO OPEN PLAIN.TXT FILE");   
    $plaintext = fread($fp, filesize("plain.txt"));//stores the content of a file in a variable//
    fclose($fp);//closes the file//
    //echo "PLAIN TEXT = $plaintext<br>";//prints $keyword variable which stores the content of the file//
    
    $splitted_plaintext = str_split($plaintext);//splits the content of the variable and stores it into an array//

    /*print_r($splitted_plaintext);//prints splitted content
    echo "<br>";
    echo "Array length of plaintext = ".count($splitted_plaintext)."<br>";
    echo "<br>";*/
    $arrlength=count($splitted_plaintext);
    for($x=0;$x<$arrlength;$x++)
    {  
      $ascii_plaintext[$x]=ord($splitted_plaintext[$x]);
      //echo $keyword[$x];
      //echo $ascii_plaintext[$x]."<br>";
    }  
    $ascii_plaintext[$x]=0;
}
//-----------------------READING KEYWORD FROM A FILE--------------------------//
function encryption_keyword(){
  global $asciikeyword;
    $fp = fopen("keyword.txt", "r")// does the work of file as in C language "*fp"//
    or die("UNABLE TO OPEN KEYWORD.TXT FILE");   
    $keyword = fread($fp, filesize("keyword.txt"));//stores the content of a file in a variable//
    fclose($fp);//closes the file//
    //echo "KEYWORD = $keyword<br>";//prints $keyword variable which stores the content of the file//
    
    $splitted_keyword = str_split($keyword);//splits the content of the variable and stores it into an array//

    //print_r($splitted_keyword);//prints splitted content
    //echo"<br>";
    //echo "Array length of keyword = ".count($splitted_keyword)."<br>";
    //echo "<br>";
    $arrlength=count($splitted_keyword);
    for($x=0;$x<$arrlength;$x++)
    {  
      $asciikeyword[$x]=ord($splitted_keyword[$x]);
      //echo $asciikeyword[$x]."<br>";
    }
    return $arrlength;
}

//--------------------------------ELIMINATING DUPLICATE CHARACTERS FROM KEYWORD-----------------------//
function encryption_eliminateduplicate($len_keyword)
{
     global $len_keyword;
     global $asciikeyword;
    for ($i = 0; $i < $len_keyword; $i++)
    {
    for ($j = $i + 1; $j < $len_keyword;)
    {
      if ($asciikeyword[$j] == $asciikeyword[$i]) {
        for ($k = $j; $k < $len_keyword; $k++) {
          $asciikeyword[$k] = $asciikeyword[$k+1];
        }
            $len_keyword--;
         } else
            $j++;
         }
       }
      /*for($x=0;$x<$len_keyword;$x++)
      {  
     
         echo $asciikeyword[$x];
         echo" ";
       }*/
      //   echo"<br>";
       //echo $len_keyword;
       //echo"<br>";
      return $len_keyword;
  }
//-----------------------STORING ALL CHARACTERS EXCEPT KEYWORD IN KEYMINUS ARRAY--------------------//
function encryption_exceptkeyword($len_keyword)
{ 
  global $asciikeyword;
  global $keyminus;
  $i=0;
  $j=0;
  $k=0;
  //space=32,plus_minus=241,divide=246,copyright=184,pound=156,registered=169,equivalent=240,yen=190,micro=230,alpha=242,squareroot=251,undefined=236;
  //Latin diphthong ae in lowercase=145;
    $alphabet=array(  
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
  //n=strlen(keyword);//-------//  
    for ($i = 0; $i<100; $i++)
    {  
        for ($k = 0; $k < $len_keyword; $k++) 
        {  
            if ($asciikeyword[$k] == $alphabet[$i])
               break;    
        }  
             if ($k == $len_keyword) 
             {  
                $keyminus[$j] = $alphabet[$i];  
                 $j++;  
             }  
      } 
   }
//-------------------------------CONSTRUCTING 10x10 SUBSTITUTION MATRIX--------------------------------//   
function encryption_substitutionmatrix($len_keyword)
{
  global $asciikeyword;
  global $submatrix;
  global $keyminus;
     
     $k=0;
     $m=0;  
    //n=strlen(keyword); //-------------------//
    //echo "<br><br>10x10 SUBSTITUTION MATRIX";
    //echo "<br>";  
    for ($i = 0; $i < 10; $i++) 
    {  
        for ($j = 0; $j < 10; $j++) 
        {  
            if ($k < $len_keyword)
             {  
                $submatrix[$i][$j] = $asciikeyword[$k];  
                $k++;  
            }
             else 
             {  
                $submatrix[$i][$j] = $keyminus[$m];  
                $m++;  
            }  
           
      //      echo chr($submatrix[$i][$j])."  ";  
        }  
    //    printf("<br>");  
    } 
}
//--------------------------------CONVERSION OF PLAINTEXT TO CIPHERTEXT-------------------------//
function encryption_plaintoincipher()
{
  global $plaintext;
  global $ascii_plaintext;
  //echo count($ascii_plaintext)."<br>";
  //echo print_r($ascii_plaintext);
  //echo "<br><br>Entered text: $plaintext <br><br>Cipher Text : ";  
    for ($i = 0; $i < count($ascii_plaintext)-1; $i++) 
    {
        if ($ascii_plaintext[$i + 1] == 0)
            encryption_playfair($ascii_plaintext[$i],145);  
        else 
        {    
            if ($ascii_plaintext[$i] == $ascii_plaintext[$i + 1]) 
               encryption_playfair($ascii_plaintext[$i],145); 
             else 
             { 	
                encryption_playfair($ascii_plaintext[$i], $ascii_plaintext[$i + 1]);  
                $i++; 
             }    
        }  
    }  
}
//-----------------PRINTING INTERMEDIATE CIPHER TEXT ASCII VALUE FROM INCIPHER[] ARRAY -------------//
  /*function encryption_readincipher()
  { 
  global $incipher;
  global $in;
  $i=0;
  $len_incipher=$in;
 // $len_incipher=count($incipher);
  //echo "<br><br>ASCII Values of Cipher Text:";
  for($i=0;$i<$in;$i++)
    echo "<br>".$incipher[$i];
  //echo"$len_incipher";
  return $len_incipher;
 }*/
 //--------------------ASCII TO BINARY CONVERSION FROM incipher[] ARRAY------------------//
  function encryption_asciitobinary($len_incipher)
  {
    global $incipher; 
    global $binary;
    $fp=fopen("en_binary.txt","a+")
   or die("UNABLE TO OPEN THE FILE");  
   $z=0;
   $w=0;
   $i=0;
   $j=0;
   $len_binary=0;
   $k=0;
   $t_binary=array();
  // $group_size = 8;
   $padding=0;
   //echo"$len_incipher";
  for($i=0;$i<$len_incipher;$i++) 
  {
    if($incipher[$i]==0)
    { 
      for($w=0;$w<8;$w++)
      {  
       $binary[$k++]=0;
      } 
    }
    else
    {
      $j=1;
      while($incipher[$i]!=0)
       {    
         $t_binary[$j++]=$incipher[$i]%2;    
         $incipher[$i]=floor($incipher[$i]/2);   
       } 

    $padding =8  - (($j-1) % 8);
    if($padding != 8) 
    {
       while($padding-- !=0) /* Add padding */
       {
          $t_binary[$j++] = 0;
       }
    }
      for($j=$j-1;$j>0;$j--) 
      {
        $binary[$k]=$t_binary[$j];  //----STORING BINARY NUMBERS IN AN ARRAY(BINARY)----//      
         $k++;   
       }
     }   
    } 
    $len_binary=$k; 
  // echo"$len_binary";
  //---------------------PRINTING BINARY NUMBERS STORED  IN  binary[] ---------------------------// 
  //echo"<br>";
  //echo"BINARY FORMS OF THE ASCII VALUES ARE:";
  for($z=0;$z<$len_binary;$z++)
  {  
     //echo"$binary[$z]"; 
    fprintf($fp,"%d",$binary[$z]);  
     
   }     
  fclose($fp);  
    return $len_binary;  
}
//------------------------BINARY TO DNA CONVERSION-------------------------------------------//
function encryption_dna($len_binary)
 {
  global $binary;
   $i=0;
    //echo"<br>DNA sequence:";  
    for ($i = 0; $i<$len_binary; $i=$i+2) 
    {    
       encryption_dnaprotien($binary[$i],$binary[$i+1]);     
    }

  }
//--------------------DNA PROTIEN FUNCTION----------------------------------------//
  function encryption_dnaprotien($ch1, $ch2)
{
  $a='A';
  $c='C';
  $g='G';
  $t='T';
  $fp=fopen("en_dna.txt","a+")
  or die("UNABLE TO OPEN THE FILE");  
  if($ch1==0 && $ch2==0)
  {
  //echo"$a";
  fwrite($fp,$a);
  }
    else if($ch1==0 && $ch2==1)
    {
     //echo"$c";
     fwrite($fp,$c);
    }

  else if($ch1==1 && $ch2==0)
  {
    //echo"$g";
    fwrite($fp,$g);
  }
  else
  {
   //echo"$t";
   fwrite($fp,$t);
  }
    fclose($fp);
}
//------------------Reading DNA SEQUENCE FROM FILE-------------------------//
function encryption_readdnasequence()
{
     global $dna;
     $i=0;
     $len_dna=0;
     $fp=fopen("en_dna.txt","r")
     or die("UNABLE TO OPEN THE FILE");  
     echo"<br>";
     $dna_seq=fread($fp, filesize("en_dna.txt")); 
     fclose($fp); 
     $dna=str_split($dna_seq);
   //print_r($dna);
   //for($i=0;$i<=24;$i++)
   //{  

    //echo $dna[$i];
   // }
    $len_dna=count($dna);
    //echo"$len_dna";
  return $len_dna;
}
//-------------------CONSTRUCTING INTERWEAVE SQUARE MATRIX--------------------//
  function encryption_interweavematrix($inmatrix_order,$len_dna)
 {
    global $interweave;
    global $dna;
    global $remain_dna;
   // echo "$len_dna";
   //echo"<br>INTERWEAVE SQUARE MATRIX OF ORDER $inmatrix_order";
   $k=$len_dna-1;
   $len_remaindna=0;
   $i=0;
   $j=0;

    for($i=0;$i<$inmatrix_order;$i++)
    {
      for($j=0;$j<$inmatrix_order;$j++) 
      {
        $interweave[$j][$i]=$dna[$k];
        $k--;
      }
    }
    //------------Printing interweave matrix-----------// 
     /*echo "<br>"; 
     for($i=0;$i<$inmatrix_order;$i++)
     {
        for($j=0;$j<$inmatrix_order;$j++) 
        {
           
           echo $interweave[$i][$j];
        }
      echo"<br>"; 
     }*/ 
     //------------Remaining Sequence-------------------//
  for($i=0;$i<=$k;$i++)
  {  
   $remain_dna[$i]=$dna[$i];
   } 
   //echo"<br>Remaing Sequence: "; 

  for($i=0;$i<=$k;$i++)
   {  

    //echo $remain_dna[$i];
    }
  $len_remaindna=$k;
  return $len_remaindna;
}
//------------------------INTERWEAVING PROCESS------------------//
function encryption_interweaving($inmatrix_order)
{
  global $interweave;
  $i=0;
  $j=0;
  $k;
  for($j=0;$j<$inmatrix_order;$j++)
  {
    $k=$interweave[0][$j];
   for($i=0;$i<($inmatrix_order-1);$i++)
   {
      $interweave[$i][$j]=$interweave[$i+1][$j];
   }  
   $interweave[$inmatrix_order-1][$j]=$k;
     $k=$interweave[$j][0];
      for($i=0;$i<($inmatrix_order-1);$i++)
    {
        $interweave[$j][$i]=$interweave[$j][$i+1];
    }
    $interweave[$j][$inmatrix_order-1]=$k;  
  }
  //------------Printing interweave matrix after rotation-----------// 
    //echo"<br>"; 
    //echo"Interweave Matrix After Rotation:<br>";
     for($i=0;$i<$inmatrix_order;$i++)
     {
        for($j=0;$j<$inmatrix_order;$j++) 
        {
      //      echo $interweave[$i][$j];
        }
     // echo "<br>"; 
     } 
}
//------------------FINAL CIPHER TEXT---------------------------//
function encryption_finalciphertext($len_remaindna,$inmatrix_order)
{
    global $interweave;
     global $remain_dna;
    $i=0;
    $j=0;
  
    $fp=fopen("en_finalcipher.txt","a+")
    or die("UNABLE TO OPEN THE FILE");
    //echo"Final Cipher Text:<br>";
     for($i=0;$i<$inmatrix_order;$i++)
     {
       for($j=0;$j<$inmatrix_order;$j++) 
       {
          fwrite($fp,$interweave[$j][$i]);  
     //     echo $interweave[$j][$i];
       }
     }
  for($i=$len_remaindna;$i>=0;$i--)
  {
    fwrite($fp,$remain_dna[$i]); 
   // echo $remain_dna[$i];
  }
}
//------------------------FUNCTION CALLING----------------------------//
if(isset($_POST["btn-encrt"])){
fclose(fopen("en_intermediatecipher.txt","w")); 
fclose(fopen("en_binary.txt","w")); 
fclose(fopen("en_dna.txt","w")); 
fclose(fopen("en_finalcipher.txt","w"));
encryption_plaintext();
$len_keyword=encryption_keyword();
$len_keyword=encryption_eliminateduplicate($len_keyword);
encryption_exceptkeyword($len_keyword);
encryption_substitutionmatrix($len_keyword);
encryption_plaintoincipher();
//$len_incipher=encryption_readincipher();
$len_incipher=$in;
$len_binary=encryption_asciitobinary($len_incipher);
encryption_dna($len_binary);
$len_dna=encryption_readdnasequence();
$inmatrix_order=(int)sqrt($len_dna);
$len_remaindna=encryption_interweavematrix($inmatrix_order,$len_dna);
encryption_interweaving($inmatrix_order);
encryption_finalciphertext($len_remaindna,$inmatrix_order);
}
if(isset($_POST["btn-encrypt"])){
$plaintextarea = $_POST['plaintextarea'];
$keywordtextarea = $_POST['keywordtextarea'];
$fp = fopen("plain.txt", "w");
$fk = fopen("keyword.txt", "w");
fwrite($fp, $plaintextarea);
fwrite($fk, $keywordtextarea);
fclose($fp);  
fclose($fk);
fclose(fopen("en_intermediatecipher.txt","w")); 
fclose(fopen("en_binary.txt","w")); 
fclose(fopen("en_dna.txt","w")); 
fclose(fopen("en_finalcipher.txt","w"));
encryption_plaintext();
$len_keyword=encryption_keyword();
$len_keyword=encryption_eliminateduplicate($len_keyword);
encryption_exceptkeyword($len_keyword);
encryption_substitutionmatrix($len_keyword);
encryption_plaintoincipher();
//$len_incipher=encryption_readincipher();
$len_incipher=$in;
$len_binary=encryption_asciitobinary($len_incipher);
encryption_dna($len_binary);
$len_dna=encryption_readdnasequence();
$inmatrix_order=(int)sqrt($len_dna);
$len_remaindna=encryption_interweavematrix($inmatrix_order,$len_dna);
encryption_interweaving($inmatrix_order);
encryption_finalciphertext($len_remaindna,$inmatrix_order);
}

?>











