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


//What kind of items can be stripped. Those in serialisation set, and not in stock

$MESG=" SCAN ITEM";


//here flags for module

//This flag know how to focus on correct object

//side functions. Doing some minor work

function check_statuses($barcode)
{
//This function check_statuses checks if the item is already stripped    
    
   echo  $sql="SELECT * FROM barcode_statuses 
INNER JOIN dismantled ON dismantled.id_cat_dis=barcode_statuses.dismantled_id_cat_dis 
INNER JOIN statuses ON barcode_statuses.statuses_id_status=statuses.id_status WHERE barcode_name='$barcode' AND status_name='Dismantled' ";
    $result=query_select($sql);
    
    $num=mysql_num_rows($result);
    //echo "</br>Rows : ".$num;
    if($rek=mysql_fetch_array($result,MYSQL_BOTH))
    {
        if($num==1){
          //return $rek['id_cat_dis'];
	     return 1;
	  }
        else if($num>1)
            return 2;
    }
    else return 0;
    
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
        //echo $letter;
         if($letter==" ")
            $word_str[$key]="\n";
        $word_str[$key]=$letter;
       
    }
    
    
            
   // echo "</BR>Debug: F[Word] - ".(string)$word_str;
   
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
    //echo "</BR>DEBUG: [TYPE_STRIP,F[check_dismantle]] - ".$type_strip;
    //here we connect and check which kind of dismantling is used LAPTOP STRIP TV STRIP
    connect_db();
    $sql="SELECT * FROM dismantled WHERE type_dismantle='$type_strip'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
      //echo "</BR>DEBUG: [DISMANTLE_ID] - ".$rek[0];
    if($rek)
        return $rek[0];
    else 
        return 0;
    //
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
//here we add validation of size, len of barcode
$barcode= barcode_checks($_POST['barcode']);  //barcode checks is for checking barcode input lewnght 12,10..ons..unq,dbs


   
$signature=$_POST['signature'];
echo "</BR>";
echo "<div style='text-align:center;'><h3>Dismantle Item</h3></div>";
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
 
 
 $site_ex = get_barcode($barcode);  //gets site
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
           $_SESSION['FOCUS']=1;
          $foc_scan="";
           $foc_sign="autofocus=''";
             //echo "ONS</br>";
     }
          if(substr($barcode,0,3)=='UNQ')
          {
              $_SESSION['FOCUS']=1;
          $foc_scan="";
           $foc_sign="autofocus=''";
            //  echo "unq</br>";
              
          }
     
     else
     unset($barcode);
     
 }
 
 if($_SESSION['FOCUS']==1)
 {
     $foc_sign="autofocus=''";
 }
 //echo "DEBUG: [Signature] - ".$signature;
$ready_to_dismantle = check_dismantle($signature);

 if($ready_to_dismantle!=0) //function check dismantle must return 1,2,3 not zeor that refers to what kind of item stripped if returned other wise it will reste signarure field
 {
    // echo "</BR>DEBUG: [Prepering dismantle]:  - Ready To DISMANTLE";
     
     
     
     //here we must check:
     // 1. If already item in barcode statuses. We dont want doubled strips of the same barcode
     
     // 2. Item cant be added to be striped since is tested in main system
    // echo "VV: ";
     echo $status_strip=validate_barcode_strip($barcode);
     //prepering for inserts
    // echo "VV";
     echo "</BR> STATUS STRIP: ".$status_strip;
     
     if($status_strip==-1)
     {
         $MESG1="Item prepared for reuse cant be dismantled.";
         //here we check if weee waste
     }   
     else if($status_strip==0 AND !empty($site_ex)) // if barcode doesnt exist and is in serialisation set
     {    
     //echo "BEFORE status check: ".$barcode."DF ".$DISMANTLE_FACTOR;
         
         
         //here we check if already in internal structure of barcode statuses
     $num_strip=check_statuses($barcode);
     echo "</BR>Check strip .".$num_strip;
     //this gets results statuse. -1 is while already more than one the same barcode. 1 is while already exists 0 while none
     if($num_strip==1) //change status for tv, laptop
     {
       //  echo "MODIFFYING BARCODE STRIP";
         $dismantle_type=check_dismantle($signature);
         $sql="UPDATE barcode_statuses SET dismantled_id_cat_dis='$dismantle_type' WHERE barcode_name='$barcode'";
         $result1=query_select($sql);
         if($result1)
         {
         $type_signa=explode(" ", $signature)[0];
         $MESG1=strtoupper($type_signa)." Dismantled.";
         //problem remoe -1 mistake
         
         }
     }
     else if($num_strip==2)
         $MESG1="Internal error. ";
     else if ($num_strip==0)
         $MESG1="Blocking.";
     
    
    // echo "</BR>NUM: ".$num_strip;
     
    echo"</BR>WASTE ".$waste_status=check_barcode_in_waste($barcode).";";
         if($waste_status==1)
			$MESG1.=" Barcode already sold.";
     
      
     
     echo "<BR>check statuse: ".$barcode;
     
     
     
     if(!empty($barcode) AND $num_strip==0 AND $barcode!=-1 AND $waste_status==0 )
     {
     $sql="INSERT INTO barcode_statuses(barcode_name,statuses_id_status,dismantled_id_cat_dis,user_dismantle) VALUES('$barcode','1','$ready_to_dismantle','$id_user')";
     //echo $sql;
     
     $result=query_select($sql);
     
     if($result)
     {
        echo "</BR>DEBUG: [Added to DB] ";
        echo '<embed height="50" width="100" src="beep/beep1.mp3" hidden="true">';  
        $MESG1=$barcode." dismantled";
         
     }
     else
     {   //this case is when insert into statuses failed
         echo "</BR>ERROR: NOT ADDED TO DB";
         $MESG1="Item not dismantled";
     }
     }
      } //end check of how many barcodes the same are alredy in barcode statuses
     
     
     //ending thismantling at the end
     unset($_SESSION['FOCUS']);
     unset($barcode);
     //$_SESSION['FOCUS']=0;
     $foc_scan="autofocus";
     
     
 } //end of check is signature correct
 else
 { //if signature not correct than reset signature
     
    if(!empty($signature))
    {
    unset($signature); 
    $MESG=" Signature incorrect. Please scan item type one more time."; 
    }
    else
        $MESG=" Please scan signature";
    
 }
 
 if(empty($barcode))
 {
     if(!empty($MESG1))
     {
     
        $MESG=$MESG1;
     }
     else
       $MESG=" Scan barcode";  
 }

 //form space
 
 //start of form
 echo '<form action="mark_strip.php" method="POST">';
 echo '<input type="text" name="barcode" value="'.$barcode.'" placeholder="Scan item.."'.$foc_scan.'>';
 
 if($_SESSION['FOCUS']==1)
     echo '<input type="text" name="signature" value="'.$signature.'" placeholder="Type signature.."'.$foc_sign.'>'; 
 echo '<input type="submit" name="Submit" value="Dismantle">';
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
