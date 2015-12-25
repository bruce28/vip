<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];

include '../header_mysql.php';
include '../functions.php';

include '../header_valid.php';
$error_factor=0;
echo "SESJon site_id_s ".$_SESSION['site_id_s']." /";

echo "Last item added ".$_SESSION['last_item'];


$host='127.0.0.1';
 $dbs3='dbs3';
  $username='root';
$password='krasnal';


function serialize_set()
{
    
    
}

function divide_barcode()
{
    
    
}

function get_barcodes($barcode)
{
    
    //get barcode, search whole database, serialize and compare if ok return site place
   // echo "inside get_barcodes;";
    $siteid=$_SESSION['site_id_s'];
    
    global $host;
    global $username;
    global $password;
            
    global $dbs3;
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
    echo "get_bar ".$siteid;
    $query="SELECT * FROM manifest_reg WHERE siteid='$siteid'";
    $result=mysql_query($query);
    echo "Interpreter: ".mysql_error();
    $rek=mysql_fetch_array($result);
    
       $start_dbs=$rek['start_dbs'];
       $end_dbs=$rek['end_dbs'];
       $idmanifest_reg=$rek['idmanifest_reg'];
       echo "Start DBS is: ".$start_dbs;
       echo "End DBS is: ".$end_dbs;
       
     
         
       
     $query="SELECT COUNT(*) as ile, SUM(manifest_counter) as suma FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
         echo $ile=$rek_count['ile'];
         echo $suma=$rek_count['suma'];
         while($rek_count['ile']>40)
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
     }
     
     
     $dbs_set=array();
     global $error_factor;
     $dbs_prob_set=$ile+$error_factor;
     
     for($i=0;$i<$dbs_prob_set;$i++)
     {
         
        $dbs_set[$i]=$start_dbs++;
        echo $dbs_set[$i]."<BR />";
        
         
         
     }
    
    
}

function get_barcodes_from_db($barcode)
{
    echo "IN GET_BARCODES FROM DB";
    //get barcode, search whole database, serialize and compare if ok return site place
   // echo "inside get_barcodes;";
    $siteid=$_SESSION['site_id_s'];
    
    global $host;
    global $username;
    global $password;
            
    global $dbs3;
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
    echo "get_bar ".$siteid;
    $query="SELECT * FROM manifest_reg";
    $result=mysql_query($query);
    echo "Interpreter: ".mysql_error();
    while($rek=mysql_fetch_array($result))
    {
    
       $start_dbs=$rek['start_dbs'];
       $end_dbs=$rek['end_dbs'];
       $idmanifest_reg=$rek['idmanifest_reg'];
       $siteid=$rek['siteid'];
       //echo "Start DBS is: ".$start_dbs;
       //echo "End DBS is: ".$end_dbs;
       
       $pre_increment =  substr($rek['start_dbs'],0,10);
        $post_inc=substr($rek['start_dbs'],10,12);
        for($i=0;$i<$num;$i++)
        {
            echo '<BR />';
            
             
            echo $pre_increment++; 
            echo $post_inc;
            
        }
         
         
      
     $query="SELECT COUNT(*) as ile, SUM(manifest_counter) as suma FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
          $ile=$rek_count['ile'];
          $suma=$rek_count['suma'];
         /*while($rek_count['ile']>40)
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
     */
           }
          
     
     
     $dbs_set=array();
     global $error_factor;
     $dbs_prob_set=$ile+$error_factor;
     
     for($i=0;$i<$dbs_prob_set;$i++)
     {
        $dbs_set[$i]=$start_dbs++;
        //echo $dbs_set[$i]."<BR />";
        //echo "First : ".$dbs_set[$i]."Second : ".$barcode;
        $result_cmp=strcmp($dbs_set[$i],$barcode);
         if($result_cmp==0)
         {
            echo "Result ".$barcode; 
         }
     }
  //   echo "<BR /><BR/>";
    }
    echo "SESSION SET ".$_SESSION['site_id_s']=$siteid;
    return $siteid;
}



//Locking in a SYSTEM OPTION 1 or 0;
$CONFIG_MODE=1;
$IS_WEIGHT_SET=0; //different notation than in add_process_stock
$BLOCK_FORM=0;  //Option set to zero display barcode form if one than blocks barcode form



$user_st=$id_user;


mysql_select_db($dbs3);


//if the weight IS_SET_WEIGHT is set to onle than always set in form submodule to 2. Initialisation
if(isset($_GET['IS_SET_WEIGHT'])==1)
{
   $IS_WEIGHT_SET=2;
   
       
}    

//function displays choices of weight category
function check_cat($id)
{
    $db = connect_dbi();
    $sql ="SELECT * FROM category";
    $result = query_selecti($db,$sql);
    while($rek = mysqli_fetch_array($result))
    {
      echo "<option value='".$rek['id']."'>".$rek['name_cat']."</option>";               
    }
  //  return $rek['town_name'];
    
}
//function that deals with communicates
function message()
{
if(isset($_GET['MESSG'])>0)
{

    
$message=$_GET['MESSG'];
if($message==17)
$message="Abnormal Z Buffor";
if($message==16)
$message="Item with that Barcode is not in serialisation set";
if($message==14)
    $message="A Barcode connected with a new weight class. Everything is fine. Item added in stock. Activating Testing Module";

if($message==12)
    $message="CRITICAL SYSTEM ERROR. PLEASE CONTACT ADMIN.</BR> "
        . "The weight assasment modul gives back error: NO ACTIVE ITEM WEIGHT CATEGORY ASSIGNED";


if($message==1)
$message="Item added in Stock. Activating Testing Module";
if($message==2)
$message="Item with that Barcode already stocked in";
if($message==3)
{
    if(isset($_GET['MESSG_EX']))
      {
       // echo $_GET['V_ITEM'];
        global $BLOCK_FORM;
        $BLOCK_FORM=1; //LOCAL VARIABLE TO BLOCK form
        if(isset($_GET['V_ITEM']))
            $v_item=$_GET['V_ITEM'];
      $message="SYSTEM BLOCKED: A new type of item. Weight not assign. Call supervisor</br></br></br>"; 
      $message.='<form action="add_process_stock.php" method="POST"> <input placeholder="Password" type="password" name="password" autofocus="" style="margin:10px;padding:10px;">';
      $message.='<input type="hidden" name="name_p" value="'.$v_item.'">';
       $message.='<input type="hidden" name="barcode_p" value="'.$_GET['V_BARCODE'].'">';
        $message.='<input type="hidden" name="serial_p" value="'.$_GET['V_SERIAL'].'">';
         $message.='<input type="hidden" name="brand_p" value="'.$_GET['V_BRAND'].'">';
      $message.="<input type='Submit' name='log' value='Give priviliges' >";
      
      
      $message.="</form>";
      
      //give to local form 
     // $V_BAR_EX=$_GET['V_BARCODE'];
     // $V_ITEM_EX=$_GET['V_ITEM'];
    //  $V_BRAND_EX=$_GET['V_BRAND'];
   //   $V_SERIAL_EX=$_GET['V_SERIAL'];
            
      
      }
      else
$message="Please Fill in Necessary fields";
}
if($message==4)
//$message="Item in stock not yet tested";
//$message="Item";
//if($message==4)
//$message="We have never had this item in stock";

if($message==5)
$message="System blocked. No particular weight assigned. Call Supervisor</BR></div><div>";

if($message==6)
    $message="Added a new item type, with a new active weight category. Barcode stocked in. Activating Testing Module";

if($_GET['BUF_MESSG']>0)
    $message="IN Stock we have".$_GET['BUF_MESSG'];

if($message==10)
$message="Test Cancelled";

if($_GET['bar_ex']==3)
    $message="CRITICAL SYSTEM ERROR CONTACT ADMIN";

echo "<div id='message' style='position: relative; width: 80%;marign: auto;border:4px black;'> ";    
echo "<h4> MESSAGE: </h4>".$message;   
echo "</div></BR>";    




}
}


function show_site($user_st)
{
    
 connect_db();

$sql_select="SELECT * FROM Barcode INNER JOIN Item ON Item.id_item=Barcode.Item_id_item WHERE stock_in=1 AND user_2='$user_st' ORDER BY Barcode.date DESC";


//if(isset($_SESSION['site_id_s'])AND $SESSION['site_id_s']>0)
//{
$site_id_site=$_SESSION['site_id_s'];   
$sql_select="SELECT * FROM Barcode INNER JOIN Item ON Item.id_item=Barcode.Item_id_item WHERE stock_in=1 AND user_2='$user_st' AND Site_site_id='$site_id_site' ORDER BY Barcode.date DESC";
//}
$result=query_select($sql_select);
while($rek=mysql_fetch_array($result))
{

 $bar_id_test=$rek['id_Barcode'];   
  $sql_test="SELECT * FROM test WHERE Barcode_id_Barcode='$bar_id_test'";
  $result_test=mysql_query($sql_test);
  $rek_test=mysql_fetch_array($result_test);
  
    
  echo "<tr><td>";
 echo $rek["Barcode"];
  echo "</td><td>";
echo $rek["stock_in"];
echo "</td><td>";  
echo $rek["stock_out"];
  //echo "sdfsdf";
echo "</td><td>";   
echo $rek["Item_id_item"];
 echo "</td><td>";
 echo $rek["date"];
 echo "</td><td>";
 echo $rek["name"];
 echo "</td><td>";
 echo $rek["brand"];
 echo "</td><td>";
 echo $rek["pn"]; 
 echo "</td><td>";   
 echo $rek["user_2"];echo "#";
 echo "</td><td>";    
 echo $rek["Site_site_id"];
 echo "</td><td>";     
 echo "Stocked-in";
 if(mysql_num_rows($result_test)>0)
 {   echo "</td><td>";
    echo "Tested";
 }
 else {
     echo "</td><td>";
     $url="add_barcode.php?test_stock=1&V_BARCODE=";
 $url.=swap_hash($rek['Barcode']);
    echo "<a href=".$url."> Test it </a>" ;
 }
    echo "</td></tr>";

  

 } 
  
  
    
    
}





















/*
if(isset($_GET["change_site"])==1)
{
  if(isset($_SESSION['site_id_s']))
  unset($_SESSION['site_id_s']);  
  $site_location=0;
  $batch_date=0;
  $site_location=0; 
  $show_site=0;
  $site_id=0;  
}
  
//$error_msg;
$show_site=0;

$site_specified=0;
$site_change_req=0;
$site_id;

connect_db();
$query="SELECT * From Origin ";
//this can be twofold, both distinct inner join or every site place distinctivel from origin tabel
//INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id

$result=query_select($query);

$users=array();
$names=array();
$batch_date=array();


if($_GET['site_specified']==1 OR isset($_SESSION['site_id_s']))
{
    
 ///   echo "site specified";
    $show_site=1;
 ///   echo "Pzrypadek SESJA  ustalona lub zmienna przekazana";
    if($_GET['site_specified']==1 AND !isset($_SESSION['site_id_s']))
    {
       // $show_site=1;
       $site_id=$_GET["site_id"];
       $_SESSION['site_id_s']=$site_id; 
 ///      echo "Przypadek Zmienna ste przekazana i sesja nie ustalona";
    }
    if($_GET['site_specified']!=1 AND isset($_SESSION['site_id_s']))
    {
       //$show_site=1; 
       $site_id=$_SESSION['site_id_s'];
 ///      echo "Przypadek Zmienna nie przekazana ale sesja ustalona"; 
    }
    else
    $site_id=$_GET["site_id"];
 ///   echo $_GET["site_id"];
 ///   echo $_SESSION['site_id_s'];
}
else
{
$i=0;
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $users[$i]=$rek["post_code"];    
     $names[$i]=$rek["town"];
     $origin[$i]=$rek["origin_id"];
     //$batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }
 ///  echo "Nie ustalono site place ani zmienna ani przekazanie";
}
*/

//variables post checking, after checked if eg. barcode exist added locally
global $bar_ex_id;
global $item_ex_id;
global $brand_ex_id;
global $serial_ex_id;

$def=array();

if(isset($_GET['processing'])) {
  echo 'Form successfully submitted.';}
  
  
if($_GET['bar_ex']==1) {
//  echo 'bar exist';
//  echo $_GET['V_BARCODE'];
  $bar_ex_id=$_GET['bar_ex'];
  $BAR_EX=$_GET['V_BARCODE'];
  ///echo $BAR_EX;
  
  }
  else
  $BAR_EX=$_GET['V_BARCODE']; // if not exist do not move local id exist and get an empty one
  
  //if not empty item field
if($_GET['s_item']==1)
{
  $item_ex_id=$_GET['s_item'];
  $ITEM_EX=$_GET['V_ITEM'];  
    
}  
  
if($_GET['s_brand']==1)
{
  $brand_ex_id=$_GET['s_brand'];
  $BRAND_EX=$_GET['V_BRAND'];  
    
}    
  
if($_GET['s_serial']==1)
{
  $serial_ex_id=$_GET['s_serial'];
  $SERIAL_EX=$_GET['V_SERIAL'];  
    
}    
  
  
  
  
  
 
?>



<script language="javascript" type="text/javascript">

function ini()
{

// Retrieve the code
var code =document.getElementById (�code_read_box�).value;



// Return false to prevent the form to submit
//return false;

}
</script>











<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=iso-8859-2">
  <meta name="Description" content=" [wstaw tu opis strony] ">
  <meta name="Keywords" content=" [wstaw tu slowa kluczowe] ">
  <meta name="Author" content=" [dane autora] ">
  <meta name="Generator" content="kED2">

  <title> GRR 3 Stocking</title>

  <link rel="stylesheet" href="layout.css " type="text/css" />
   <link rel="stylesheet" href="form.css " type="text/css" />


<script type="text/javascript"> 
function validate()
{
if(document.getElementsByName('barcode') == "")
{
alert("Please Enter username");
return false;
}
...
}
</script>
<!--
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />

 <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js">
 <link rel="stylesheet" href="/resources/demos/style.css" />  

  <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="jquery-ui-1.9.2/development-bundle/themes/base/jquery-ui.css" />
  <script src="jquery-ui-1.9.2/js/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="jquery-ui-1.9.2/development-bundle/ui/jquery-ui.custom.js"></script>
 
 
    <script src="jquery-1.10.2.js"></script>
  
       
       
  <link rel="stylesheet" href="datepicker/css/datepicker.css" />
  <script src="datepicker/js/bootstrap-datepicker.js"></script>
  
   -->
  <script>
  //    $('#sandbox-container .input-append.date').datepicker({
//});
      
  //   $('#dp3').datepicker() 
  
 // $( "#datepicker" ).datepicker();
  //$(document).ready(function() {
   // $('#datepicker').datepicker();
//});
  
//$(function() {
      
   //   $('#sandbox-container #datepicker').datepicker({
   // format: "yyyy/mm/dd",
   // autoclose: true
//});

  //$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
    
    //var dateFormat = $( ".selector" ).datepicker( "option", "dateFormat" );
 
//$.datepicker.parseDate( "yy-mm-dd", "2007-01-26" );
    //
   // $( ".selector" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  // $( "#datepicker" ).datepicker({ autoSize: true });
  //$( "#datepicker" ).datepicker();
     //$.datepicker.formatDate( "yy-mm-dd", new Date( 2007, 1 - 1, 26 ) );
      //});
  </script>



</head>
<body>
<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div></BR></BR>



<div id="all">

<?php echo "<B>WELCOME: ".strtoupper($_SESSION['l_klient'])."</b>"; ?>


    <div id="form_stock" style="font: xx-large; font-variant: simplified; font-family: sans-serif; font-size:  inherit; "> <p>Stocking Manager Module - Collection </p>
</BR>
<div margin="10px">






<form action="add_process_stock.php" method="POST">







<?php

//$barcode="dbs/001400";
//$site= get_barcodes_from_db($barcode);

if($show_site==1)
{
    //echo "showsite";
   $batch_date=$_GET["batch_date"];
   $site_location=$_GET["site_specified"]; 
  if(!empty($batch_date)AND !empty($site_location) OR isset($_SESSION["site_id_s"]))
{
  
    //echo 'asassdfsfdsfdsdfsdfsdfsdfsdfsdfsdfsfd';
  connect_db();
  //$query="SELECT * From Origin INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id WHERE batch_date='$batch_date' AND Origin_origin_id='$site_location'";
    $query="SELECT * From Origin INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id WHERE site_id='$site_id'";


   $result=query_select($query);


$i=0;

  if($rek = mysql_fetch_array($result,1))
  {
  $site_specified=1;  
  
  $batch_date=$rek["batch_date"];
  $site_location=$rek["Origin_origin_id"];
  $comp_name=$rek["company_name"];
  $name=$rek["name"];
  $surname=$rek["surname"];
  $post_code=$rek["post_code"];
  $house_num=$rek["house_number"];
  $street=$rek["street"];
  $town=$rek["town"];
  $site_ref_number=$rek["site_ref_number"];
  $closed=$rek["closed"];
  $site_id_r=$_POST["site_id"];
  
 
 
 
 echo "<table id='stock_info'><tr>";
  echo "</BR><b><td>Site Reference Number: </td></b><td>".$site_ref_number;
  echo $site_id_r;
  echo "</td><td>";
  echo "</BR></td></tr><tr><td>Company Name: </td><td>".$comp_name;
  echo "</BR></td></tr><tr><td>Name: </td><td>".$name;
  echo "</BR></td></tr><tr><td>Surname: </td><td>".$surname;
  echo "</BR></td></tr><tr><td>Postal Code: </td><td>".$post_code;
  //echo "</BR></td></tr><tr><td>House Number: </td><td>".$house_num;
  echo "</BR></td></tr><tr><td>Street: </td><td>".$street;
  echo "</BR></td></tr><tr><td>Town: </td><td>".$town;
   echo "</BR></td></tr><tr><td>Date Manifest picked up: </td><td>".$batch_date;
  echo "</BR></BR></td></tr><tr><td>STATUS: </td><td>"; if($closed==0){ echo "Stocking Out"; }else echo "Stocking Closed";
  echo "</td></tr></table>";
  echo "</BR> </BR>"; if (!$IS_WEIGHT_SET!=2 AND $_GET['MESSG_EX']!=0 OR $_GET['MESSG']!=3 AND $_GET['IS_SET_WEIGHT']!=1) echo "<a style='
    
  text-decoration: none;
  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 10%;
    height:5px;
    color:black;
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse;  


' href='add_stock.php?change_site=1'> Change Site Place </a>";
 
 

  }
  else
  {
  //$_SESSION['site_id_s']=0;
  if(isset($_SESSION['site_id_s']))
  unset($_SESSION['site_id_s']);
  }
}  
    
}
/*
else
{
echo "<span>Site Place</span>";

echo '<span style="margin: 10px;"> <select  name="site_location" size="1">';

for($z=0;$z<=$i;$z++)
{
  echo '<option value="'.$origin[$z].'">'.$names[$z].'</option>';

}
echo '</select></span>';


echo<<<DATE_F
<span style="margin: 10px;">Date of Collection</span> 

<input type="text" name="batch_date" placeholder="YYYY-MM-DD" value="


DATE_F;

$batch_date;


echo<<<DATE_F1

"/>



<input type="hidden" name="submitted" value="1" />


<input type='submit' name='Submit' value='Specify' align='right'>

</form>
</table>


DATE_F1;
}*/
?>



<?php
if($_GET['ref']==1)
{
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
    echo "</BR>Please Pick up most recent site place</BR></BR>";
    $batch_date=$_GET["batch_date"];
   $site_location=$_GET["site_location"]; 
    $sql_reference="SELECT * FROM Site WHERE batch_date='$batch_date' AND Origin_origin_id='$site_location'";
    $result=mysql_query($sql_reference); 
            echo "error: ".mysql_error();
    
    echo "<form action='add_process_stock.php' method='POST'><select name='site_reference_number' style='marign:15px;'>";
    while($rek=mysql_fetch_array($result, MYSQL_BOTH))
    {
        $site_ref_number=$rek['site_ref_number'];
        echo "<option value='$site_ref_number'>";
        echo $rek['site_ref_number'];
        
        echo "</option>";
        echo "</BR>";
    }
    echo "</select><input type='hidden' name='batch_date' value='$batch_date'><input type='hidden' name='site_location' value='$site_location'><input type='Submit' name='site' value='Pick up'  style='marign:15px;'></form>";
    
    
}
?>
















    <div style="alignment-adjust: central"><?php message(); //implementing trim for %20?></div>
<?php if($IS_WEIGHT_SET==2) : //$BLOCK_FORM=1;//to block weight form?>  
   </BR></BR>
    <form action="add_process_stock.php" method="POST">
     <input style="marign: 10px;padding:10px;" type="text" name="weight" value="" placeholder="Weight in [kgs]"/>
     <select name="cat_id" > <?php check_cat($id); ?></select> </BR>
     <input type="hidden" name="barcode_in" value="<?php echo trim($_GET['barcode']); ?> " />
     <input type="hidden" name="item_in" value="<?php echo trim($_GET['item']); ?> " />
     <input type="hidden" name="brand_in" value="<?php echo trim($_GET['brand']); ?> " />
     <input type="hidden" name="serial_in" value="<?php echo trim($_GET['serial']); ?> " />
     <input style="marign: 10px;padding:10px;" type="submit" name="weight_add" value="Assess a new weight" />
    </form>   
    </BR></BR></BR>;
<?php endif ?>
    
<?php if($IS_WEIGHT_SET!=2 AND $show_site==0) ://onclick="return validate();" ?>    
<table border="1" id="stock_form1">
<tr><td>Barcode</td><td>Item</td><td>Brand</td><td>Model Number</td></tr>
<tr>




<form action="add_process_stock.php" method="POST">

<td>
    <input type="text "id="code_read_box" name="barcode" value="<?php if(!empty($BAR_EX)) echo $BAR_EX; ?>" autofocus="" placeholder="Barcode" <?php if($BLOCK_FORM==1) echo 'disabled'; ?> /><?php if(!empty($bar_ex_id)) echo "*"; ?>
</td>

<td>
<input type="text "id="" name="item" placeholder="e.g. DVD, PS2..." value="<?php if(!empty($ITEM_EX)) echo $ITEM_EX; ?>" <?php if($BLOCK_FORM==1) echo 'disabled'; ?> /><?php if(empty($item_ex_id)) echo "+"; ?> 
</td>
<td>
<input type="text "id="" name="brand" placeholder="e.g. JVC, Sanyo..." value="<?php if(!empty($BRAND_EX)) echo $BRAND_EX; ?>" <?php if($BLOCK_FORM==1) echo 'disabled'; ?>/><?php if(empty($brand_ex_id)) echo "+"; ?>
</td>
<td>
<input type="text "id="" name="serial" placeholder="e.g. TJR56" value="
<?php if(!empty($SERIAL_EX)) echo $SERIAL_EX; ?>" <?php if($BLOCK_FORM==1) echo 'disabled'; ?> /><?php if(empty($serial_ex_id)) echo "+"; ?>
</td>


</BR></BR></BR>
<?php

/*
<td> 
<input type="radio" name="rdy" value="1" /> YES</br>
<input type="radio" name="rdy" value="0" /> NO
</td>
*/
?>
<input type="hidden" name="submitted" value="1" />


<td>

<input type='submit' name='Submit' value='Add' align='right' <?php if($BLOCK_FORM==1) echo 'disabled'; ?>></br>
<input type='submit' name='Cancel' value='Cancel' align='right'>

</td>

</tr>
</form>

</table>
<?php endif ?>    
</div>

 <?php if(isset($_GET['MESSG_EX'])==0): ?>   
<div id="buttons">
<h4> <a href="../index.php"><button class="submit" style=" width: auto;  
    padding: 9px 15px;  
    background: #617798;  
    border: 0;  
    font-size: 14px;  
    color: #FFFFFF;  
    -moz-border-radius: 1px;  
    -webkit-border-radius: 1px;  ">Return</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</h4>
</div>
    <?php endif ?>
</div></div>
 </br></br>
 
 
 <?php
echo "<table width='50%'>";
 show_site($user_st);
 echo "</table>";
 echo $error_msg;   
 
 
 
 if($_GET['MESSG']==14 OR $_GET['MESSG']==1 OR $_GET['MESSG']==6)
 {
     echo "Going to do test";
 $V_BARCODE=$_GET['test'];
 $url="add_barcode.php?test_stock=1&V_BARCODE=";
 $url.=$V_BARCODE;
   redirect($url,0);
 }
   ?>   
 
 
</body>
</html>
