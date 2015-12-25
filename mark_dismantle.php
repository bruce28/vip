<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header.php';
$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat";
include 'menu_header.php'; 
include 'header_mysql.php';
include 'functions_site.php';
?>






<HTML>
<HEAD>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">


<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">


<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />

<script type="text/javascript" src="csshorizontalmenu.js" > 




</script>
<script type="text/javascript" src="jquery-1.10.2.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>


</HEAD>
<BODY >

<table border=1 width=100% height=800 bgcolor="F8F8F8" >
<tr>
<td colspan=2 width=100% height=5% align=right> 

<table border="0" cellpadding="1" cellspacing="3" bgcolor="#F8F8F8">

<?php
//F8F8F8  F0F0F0 #E0E0E0
if(empty($l_klient))
{
$log='<form action="log_pro.php" method="post">
<td>Login</td><td><input type="text" name="login"></td>
<td>Password</td><td><input type="password" name="pass"></td>
<tr>
<td></td><td></td><td></td><td><input type="submit" name="Submit" value="Log In" align="right"> </td>
</tr>
</form>';
echo $log;
}
else
echo "You are Logged In as ".$l_klient;

?>
</table>

</td></tr>

<tr bgcolor="#E0E0E0">
<td colspan=2 width=100% height=15% align=center valign=center> GRR Database System 2
</td>
</tr>
<tr>
<td colspan=2 width=100% height=25px align=right bgcolor="#E0E0E0"> 

<?php show_menu(); ?>


  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>

<?php 
//MODS to allow removing from ebay wholesale weee stock

$MOD_RM_EBAY=0;
$MOD_RM_WHL=0;
$MOD_RM_WEEE=0;

function check_wholesale($barcode)
{
   $sql="SELECT * FROM barcode_has_buyer INNER JOIN barcode ON barcode.id_Barcode=barcode_has_buyer.Barcode_id_Barcode WHERE Barcode='$barcode'";
   
   $result=query_select($sql);
    
   $rek=mysql_fetch_array($result,MYSQL_BOTH);
   if($result)
   return $rek['Barcode_id_Barcode'];
}



function check_ebay($barcode)
{
   $sql="SELECT barcode_id_Barcode from six_barcode WHERE u_barcode='$barcode'";
   
   $result=query_select($sql);
    
   $rek=mysql_fetch_array($result,MYSQL_BOTH);
   if($result)
   return $rek['barcode_id_Barcode'];
}


//checking first if item sold on ebay, wholsale or weee waste




//GEt id item

function get_id_item($barcode)
{
   $sql="SELECT Item_id_item FROM Barcode WHERE Barcode='$barcode'";
   
   $result=query_select($sql);
    
   $rek=mysql_fetch_array($result,MYSQL_BOTH);
   return $rek['Item_id_item'];
}


//here flags for module

//This flag know how to focus on correct object

//side functions. Doing some minor work

function check_statuses($barcode)
{
    $sql="SELECT * FROM barcode_statuses WHERE barcode_name='$barcode'";
    $result=query_select($sql);
    
    if($rek=mysql_fetch_array($result))
    {
       return 0; 
    }
    else return $barcode;
    
}

function get_word($sentence)
{
    $quit=0;
    $word=array();
    //$word=array();
    $word=str_split($sentence);
    $word_str=array();
    //we split every letter and below we assign as a string conversion letter -> array- string
    
    foreach ($word as $key => $letter) {
        echo $letter;
         if($letter==" ")
            $word_str[$key]="\n";
        $word_str[$key]=$letter;
       
    }
    
    
            
    echo "</BR>Debug: F[Word] - ".(string)$word_str;
   
         return $word_str;
}


//this checks what kind of dismantling are availible

function check_dismantle($type_strip)
{
    
    //here we divide the string for dismantle table norm that is only first input phrase
    //$type=array();
    //$type_strip=get_word($type_strip);
    
    //insted we use explode
    //incopatible verion of php notice
    $type_strip=explode(" ", $type_strip)[0];
    
    //$type_strip;
   // echo "</BR>DEBUG: [TYPE_STRIP,F[check_dismantle]] - ".$type_strip;
    //here we connect and check which kind of dismantling is used LAPTOP STRIP TV STRIP
    connect_db();
    $sql="SELECT * FROM dismantled WHERE type_dismantle='$type_strip'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    //  echo "</BR>DEBUG: [DISMANTLE_ID] - ".$rek[0];
    if($rek)
        return $rek[0];
    else 
        return 0;
    
}

function get_barcode($barcode)
{
    //this is wrapper for check site origins for barcode
    
    $site=0;
    $site=get_barcodes_from_db($barcode);
    return $site;
}

//$FOCUS=0;
$_SESSION['FOCUS'];
$barcode=  barcode_checks($_POST['barcode']);


echo "</BR></BR></BR>";

?> 

   
    <div style="margin: 10px;">
    
    
 <?php
 $search=$_POST['mark'];
 
 
 if($_SESSION['FOCUS']==0)
 {
     $foc_scan="autofocus=''";
 }
  else {
     $foc_scan="";
     
 }
 
 
 $site_ex = get_barcode($barcode);
 if($site_ex!=0)
 {
     $_SESSION['FOCUS']=1;
     $foc_scan="";
     $foc_sign="autofocus=''";
 }
 else
 {
     if(substr($barcode,0,3)=='ONS')
     {
             echo "ONS1".$barcode;
           
             
     }
     else if(substr($barcode,0,3)=='UNQ')
             echo "UNQ";
     else if(substr($barcode,0,3)=='DBS')
             echo "small dbs";
     else
     unset($barcode);
     
 }
 
 
 
 if($_SESSION['FOCUS']==1)
 {
     $foc_sign="autofocus=''";
 }
 //echo "DEBUG: [Signature] - ".$signature;
 //ready_to_dismantle = check_dismantle($signature);

 
     echo "</BR>DEBUG: [Prepering Remove ]:  - Ready To Remove";
     
     
     
     //here we must check:
     // 1. If already item in barcode statuses. We dont want doubled strips of the same barcode
     
     // 2. Item cant be added to be striped since is tested in main system
     echo "VV: ";
     echo $barcode;
     echo validate_barcode($barcode);
     //prepering for inserts
     
     echo "</BR>VALIDATED BARCODE ".$barcode;
     echo "VV";
     //$barcode=check_statuses($barcode);
     
     echo "ebay check";
         echo $ebay=check_ebay($barcode);
         
         if($ebay AND $MOD_RM_EBAY==0)
             $MESG="ITEM ON EBAY.Contact Supervisor";
         
                          
         $whl=check_wholesale($barcode);
         if($whl)
             echo "on wholesale"; 
     if(empty($ebay) OR $MOD_RM_EBAY==1)
     //here we go only if we
     {
         if(empty($whl))
         { 
     $MESSG="Item waste";    
     echo "n1ot in ebay";
     echo $DISMANTLE_FACTOR;
     if ($DISMANTLE_FACTOR==0 AND (get_barcode($barcode) OR substr($barcode,0,3)=="UNQ"))
     $MESG="Item Collected.SDA WASTE";
     if($DISMANTLE_FACTOR==12)
     {    
         echo "sd";
     if(!empty($barcode))
     {
         
         
     
         if(!empty($ebay))
         {
             echo "item on ebay";
             if($MOD_RM_EBAY==0)
                 $MESG="ITEM ON EBAY LOCK";
         }
     
              
             
         
        
        
         mysql_query("START TRANSACTION");
         
         $sql="DELETE barcode,test,barcode_has_buyer,item FROM barcode
JOIN test On Barcode.id_Barcode=Test.Barcode_id_Barcode
JOIN item on barcode.Item_id_item=Item.id_item
JOIN barcode_has_buyer On Barcode.id_Barcode=barcode_has_buyer.Barcode_id_Barcode
WHERE Barcode='$barcode'";
         
        // echo $sql;
         
         echo $sa1="DELETE barcode_has_buyer FROM barcode_has_buyer JOIN barcode ON Barcode.id_Barcode = barcode_has_buyer.Barcode_id_Barcode WHERE Barcode = '$barcode'";
         
        $a1=mysql_query($sa1);
         
         echo $sa2="DELETE test FROM test JOIN barcode ON Barcode.id_Barcode = test.Barcode_id_Barcode WHERE Barcode = '$barcode'";
         
         $a2=mysql_query($sa2);
         //
         
         if($ebay)
         {
         $sa5="DELETE FROM six_barcode WHERE u_barcode='$barcode'";
         $a5=mysql_query($sa5)or die();
         }
         
         
         //
         //echo $sa3="DELETE item,barcode FROM item JOIN barcode ON Barcode.Item_id_item = item.id_item WHERE Barcode = '$barcode'";
         //$a3=mysql_query($sa3);
         
         //here we change
         echo "IIII: " .$item_id= get_id_item($barcode);
         
         $sa3="DELETE barcode FROM barcode JOIN item ON Barcode.Item_id_item = item.id_item WHERE Barcode = '$barcode'";
         $a3=mysql_query($sa3) or die(mysql_error());
         
         
         $sa4="DELETE FROM item WHERE id_item='$item_id'";
         $a4=mysql_query($sa4);
         
         //$sa4="DELETE barcode FROM barcode JOIN item ON Barcode.Item_id_item = item.id_item WHERE Barcode = ''"
         
         
         if($a1 AND $a2 AND $a3 AND $a4)
         {
             mysql_query("COMMIT");
         }
 else {
             mysql_query("ROLLBACK");
 }
         
         
         //$result=query_select($sql);
         //$rek=  mysql_fetch_alias_array($result)
         
         //$barcode_id=get_barcode_id($barcode);
        
         //echo $sql="UPDATE test SET disposal='12' WHERE barcode_id_Barcode='$barcode_id'";
    
         

//echo $sql;
     
    // $result=query_select($sql);
     }
 else {
     $MESG="Item not removed. Barcode empty. Does not go throu validation";
     
     }
     if($a1 AND $a2 AND $a3 AND $a4)
     {
        echo "DEBUG: [Added to DB] "; 
         $MESG=" Item ".$barcode." Removed Completly from stock";
     }
     else
     {
         echo "ERROR: NOT ADDED TO DB";
         $MESG="Item not removed";
        echo "</BR>1. ".$a1;
        echo "</BR>2. ".$a2;
        echo "</BR>3. ".$a3;
        echo "</BR>4. ".$a4; 
     }
     }
     
     } //whl
     else {
         $MESG="Item on wholesale. Please contact supervisor";   
     }
     }
     else if(!$ebay)
     {
        $MESG="Item not in stock"; 
     }
     else if($whl)
     {
         $MESG="Item in wholesale";
     }    
     else 
        echo "Already waste";    
     //ending thismantling at the end
     unset($_SESSION['FOCUS']);
     unset($barcode);
     //$_SESSION['FOCUS']=0;
     $foc_scan="autofocus";
     
     
 

  
 //start of form
 echo '<form action="mark_dismantle.php" method="POST">';
 echo '<input type="text" name="barcode" value="'.$barcode.'" placeholder="Scan item.."'.$foc_scan.'>';
 
 
 echo '<input type="submit" name="Submit" value="Remove item">';
 echo "</form>";
 echo "</BR></BR>";
 

 show_message($MESG);
 //lets by default unset session focus and all variables by empty posts table. If we only rest session variable by checking if barcode was post that equals reste all form
 if(empty($_POST['barcode']));
 unset($_SESSION['FOCUS']);
 
              ?>
                  
        <style>
          label{
          margin-left: 10px;   
          color: #999999;
          font: normal 13px/100% Verdana, Tahoma, sans-serif;
            }
           </style>
    </div>
    
    
    
    
    
    <?php
    if(isset($_POST['Submit']))
    {
    }
    ?>
    
    
</td>
</table>


    
    

</BODY>
</HTML>
