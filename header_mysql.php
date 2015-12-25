<?php
//Header File
$header_space="</BR>";

$serwer = "127.0.0.1";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  



function connect_db()
{
    
    global $serwer;
    global $login;
    global $haslo;
    global $baza;
    
    $connect=mysql_connect($serwer,$login,$haslo)
    or die(mysql_error());
    
    mysql_select_db("dbs3");
    
    return $connect;
    
}

function query_select($sql)
{
     $result= mysql_query($sql) or die(mysql_error()) ;
     return $result; 
}

function read_row($result)
{
    
  if($rek = mysql_fetch_array($result,1))  
   {
     if($rek["Barcode"]==$in)
      {
       
      }
}     
	 
}    
    
function read_rows($result)
{
    
  if($rek = mysql_fetch_array($result,MYSQL_BOTH))  
   {
     //echo $rek["post_code"];
     return $rek;
     
   }
   else
   {
     return 0;     
   }	 
}         
//section for function mysqli()


function connect_dbi()
{
   //$db = new mysqli($serwer,$login,$haslo,$baza);
   //or 
   global $serwer;
   global $login;
   global $haslo;
   global $baza;
    
   $db = mysqli_connect('127.0.0.1','root','krasnal','dbs3');
    if(mysqli_connect_errno())
    {
        echo 'Could connect the main database';
        exit;
        
    }
    mysqli_select_db($db,"dbs3");
    
    
    
  return $db;    
}
    

function query_selecti($db,$sql)
{
    
    
    $result= mysqli_query($db,$sql) or trigger_error(mysqli_error($db)) ;
     return $result; 
    
 /*
     $code = mysqli_real_escape_string ($dbc, $_GET['invite']);

$q = "SELECT invite_id FROM signups_invited WHERE (code = '$code') LIMIT 1";
$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

if (mysqli_num_rows($r) == 1) {
    echo 'Verified';
} else {
    echo 'That is not valid. Sorry.';
}
   */  
     
     
     
}

//var_dump(function_exists('mysqli_connect'));


//section for functions PDO

function read_rowsi($result)
{
    
  if($rek = mysqli_fetch_array($result,MYSQL_BOTH))  
   {
     //echo $rek["post_code"];
     return $rek;
     
   }
   else
   {
     return 0;     
   }	 
}
 



?>