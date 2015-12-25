<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include "../header_mysql.php";

include '../header_valid.php';

$user_st=$id_user;

$_SESSION['meter'];

$_SESSION['class_2'];
unset($_SESSION['PAT_GO']);

function message()
{
if(isset($_GET['MESSG'])>0)
{
$message=$_GET['MESSG'];

if($message==1)
$message="Item have been tested.";
if($message==2)
$message="This Item does not exist in Stock. Check a barcode";
if($message==3)
$message="Item Already Tested";
if($message==4)
$message="Item in stock not yet tested";
//$message="Item";
//if($message==4)
//$message="We have never had this item in stock";

     


if($message==10)
$message="Test Cancelled";
echo "<div id='message' style='position: relative; width: 80%;marign: auto;border:4px black;'> ";    
echo "<h4> MESSAGE: </h4>".$message;   
echo "</div></BR>";    
}

if($_SESSION['meter']==2)
{
    $message=$_SESSION['meter'];
    
if($message==2)
  $message="Please give PAT Test resul parameters";   
echo "<div id='message' style='position: relative; width: 80%;marign: auto;border:4px black;'> ";    
echo "<h4> </h4>".$message;   
echo "</div></BR>";    
}

}


function show_site($user_st)
{
    
 connect_db();
//slight change this is originally for barcode stocked in by whome
//$sql_select="SELECT * FROM Barcode INNER JOIN Item ON Item.id_item=Barcode.Item_id_item INNER JOIN Test ON Barcode.id_Barcode=Test.Barcode_id_Barcode WHERE stock_in=1 AND user_2='$user_st' ORDER BY Barcode.date DESC";

//this a new one with test
$sql_select="SELECT * FROM Barcode INNER JOIN Item ON Item.id_item=Barcode.Item_id_item INNER JOIN Test ON Barcode.id_Barcode=Test.Barcode_id_Barcode WHERE stock_in=1 AND User_2_id_user='$user_st' ORDER BY Barcode.date DESC";

$result=query_select($sql_select);
while($rek=mysql_fetch_array($result))
{
//echo "<table>";    
/**
 * echo "<tr><td>";
 *  echo $rek["post_code"];
 *   echo "</td><td>";
 * echo $rek["company_name"];
 * echo "</td><td>";  
 * echo $rek["name"];
 *   //echo "sdfsdf";
 * echo "</td><td>";   
 * echo $rek["surname"];
 *  echo "</td><td>";
 *  echo $rek["street"];
 *   
 *   
 *  echo "</td><td>";
 *  echo $rek["town"];
 *   
 *   echo "</td><td>";
 *  
 *   //$postal_code = strtoupper (str_replace(' ', '', $postal_code));
 *  

 *  echo $email=$rek['email'];
 *  echo "</td><td>";
 *  
 *   echo $phone=$rek['phone']; 
 *     echo "</td></tr>";
 */
  
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
 echo $rek["User_2_id_user"];echo "#";
 echo "</td><td>";    
 echo $rek["Site_site_id"];
 echo "</td><td>";     
 echo "Tested";
    echo "</td></tr>";

  

 } 
 }



function swap_hash($in)
{
  for($i=0;$i<=45;$i++)
  {
    if($in[$i]=='#')
    {
      $in[$i]='\\';
    }
  };  
    
   return $in; 
}

function swap_back($in)
{
  for($i=0;$i<=45;$i++)
  {
    if($in[$i]=='\\')
    {
      $in[$i]='#';
    }
  };  
    
   return $in; 
}



//$error_msg;

$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 

$site_id;

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
  //echo $BAR_EX;
  
  }
  else
  $BAR_EX=$_GET['V_BARCODE'];
  
  
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
  
  
  
  
  
  
  
  
  
  
  
// ISSET
  
if(isset($_GET['v_pat'])AND $_GET['v_pat']==0) {
  //echo 'PAT UNSET';
  
  }

if(isset($_GET['v_cln'])AND $_GET['v_cln']==0) {
 // echo 'CLN UNSET';
  
  }

if(isset($_GET['v_fun'])AND $_GET['v_fun']==0) {
 // echo 'FUN UNSET';
  
}
  
if(isset($_GET['v_vis'])AND $_GET['v_vis']==0) {
 // echo 'VIS UNSET';
  
  }

if(isset($_GET['v_fuse'])AND $_GET['v_fuse']==0) {
 // echo 'VIS UNSET';
  
  }

//CHECK

if($_GET['v_pat']==1) {
 // echo 'PAT SET';
  $PAT_CHK1='NULL';
  $PAT_CHK2='checked';
  $PAT_CHK3='NULL';
  }
if($_GET['v_pat']==2) {
 // echo 'PAT SET';
  
  $PAT_CHK1='checked';
  $PAT_CHK2='NULL';
  $PAT_CHK3='NULL';
  }  
if($_GET['v_pat']==3) {
 // echo 'PAT SET';
  
  $PAT_CHK1='NULL';
  $PAT_CHK2='NULL';
  $PAT_CHK3='checked';
  }  
  
  
if($_GET['v_cln']==1) {
//  echo 'CLN SET';
  $CLN_CHK1='NULL';
  $CLN_CHK2='checked';
  }
if($_GET['v_cln']==2) {
//  echo 'CLN SET';
  
  $CLN_CHK1='checked';
  $CLN_CHK2='NULL';
  }  
  
  
  if($_GET['v_fun']==1) {
 // echo 'FUN SET';
  $FUN_CHK1='NULL';
  $FUN_CHK2='checked';
  }
if($_GET['v_fun']==2) {
 // echo 'FUN SET';
  
  $FUN_CHK1='checked';
  $FUN_CHK2='NULL';
  }  
  
  
  if($_GET['v_vis']==1) {
 // echo 'VIS SET';
  $VIS_CHK1='NULL';
  $VIS_CHK2='checked';
  }
if($_GET['v_vis']==2) {
// echo 'VIS SET';
  
  $VIS_CHK1='checked';
  $VIS_CHK2='NULL';
  }    

if($_GET['v_frm']==1) {
 // echo 'PAT SET';
  $FRM_CHK1='NULL';
  $FRM_CHK2='checked';
  $FRM_CHK3='NULL';
  }
if($_GET['v_frm']==2) {
 // echo 'PAT SET';
  
  $FRM_CHK1='checked';
  $FRM_CHK2='NULL';
  $FRM_CHK3='NULL';
  }  
if($_GET['v_frm']==3) {
 // echo 'PAT SET';
  
  $FRM_CHK1='NULL';
  $FRM_CHK2='NULL';
  $FRM_CHK3='checked';
  }  
  
if($_GET['v_rin']==1) {
 // echo 'PAT SET';
  $RIN_CHK1='NULL';
  $RIN_CHK2='checked';
  $RIN_CHK3='NULL';
  }
if($_GET['v_rin']==2) {
 // echo 'PAT SET';
  
  $RIN_CHK1='checked';
  $RIN_CHK2='NULL';
  $RIN_CHK3='NULL';
  }  
if($_GET['v_rin']==3) {
 // echo 'PAT SET';
  
  $RIN_CHK1='NULL';
  $RIN_CHK2='NULL';
  $RIN_CHK3='checked';
  }    

if($_GET['v_fuse']==1) {
 // echo 'PAT SET';
  
  $FUSE_CHK1='NULL';
  $FUSE_CHK2='checked';
  $FUSE_CHK3='NULL';
  }  
  
if($_GET['v_fuse']==2) {
 // echo 'PAT SET';
  
  $FUSE_CHK1='checked';
  $FUSE_CHK2='NULL';
  $FUSE_CHK3='NULL';
  }    
  
if($_GET['v_fuse']==3) {
 // echo 'PAT SET';
  
  $FUSE_CHK1='NULL';
  $FUSE_CHK2='NULL';
  $FUSE_CHK3='checked';
  }  

for($i=1;$i<6;$i++)
{
    $def_name="defect".$i;
   //echo $def_name;
  
    if($_GET[$def_name]=='1')
    {
        //echo $_GET[$def_name];
        //echo "122121";
        $def[$i]=0;
      $def[$i]=$_GET[$def_name];
      //echo $def[$i];       
    }  
}

?>



<script language="javascript" type="text/javascript">

function ini()
{

// Retrieve the code
var code =document.getElementById (�code_read_box�).value;


printf("FALSESS");
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

  <title> Testing </title>

  <!--
<link rel="stylesheet" href="loyout.css " type="text/css">
-->
  <!--
<link rel="stylesheet" href="form_cat.css " type="text/css">
-->
  
</head>
<body>
   
</BR></BR></BR></BR></BR></BR></BR></BR></BR>
<table border="1" style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; ">
<tr><td>Barcode</td><td>Item</td><td>Brand</td><td>Serial</td><td>PAT </td><td>Visual</td><td>Functionality</td><td>Cleaning</td><td>Formatted</td><td>Reinstallation</td><td>Correct Fuse Fitted</td><td>Repairs carried out</td></tr>
<tr>


<?php if(!empty($item_ex_id)AND !empty($item_ex_id)) $COL=1; else $COL=0?>

<form onsubmit="return ini()" id="dateForm" action="add_process_bar.php" method="POST">

<td>
<input type="text "id="code_read_box" name="barcode" placeholder="Waiting for barcode scan..."  value="<?php if(isset($BAR_EX))echo $BAR_EX; ?>" autofocus="" autocomplete="off" /><?php if(!empty($bar_ex_id)) echo "*"; ?>
</td>

<td>
<input type="text "id="" name="item" value="<?php if(isset($ITEM_EX))echo $ITEM_EX; ?>" disabled /><?php if(empty($item_ex_id)) //echo "</BR>+"; ?> 
</td>
<td>
<input type="text "id="" name="brand" value="<?php if(isset($BRAND_EX))echo $BRAND_EX; ?>" disabled /><?php if(empty($brand_ex_id)) //echo "</BR>+"; ?>
</td>
<td>
<input type="text "id="" name="serial" value="
<?php if(isset($SERIAL_EX))echo $SERIAL_EX; ?>" disabled /><?php if(empty($serial_ex_id)) //echo "</BR>+"; ?>
</td>
<td>
</br>
<input type="radio" name="pat" value="1" <?php if(isset($PAT_CHK1)) echo $PAT_CHK1; if(!isset($_GET['block_test'])) echo "disabled";?> /> Pass </BR>
<input type="radio" name="pat" value="0" <?php if(isset($PAT_CHK2))echo $PAT_CHK2; if(!isset($_GET['block_test'])) echo "disabled";?> /> Fail </BR>
<input type="radio" name="pat" value="2" <?php if(isset($PAT_CHK3))echo $PAT_CHK3; if(!isset($_GET['block_test'])) echo "disabled"; ?> /> Not Applicable
</td>
<td <?php if($COL=1) echo 'style="background-color: whitesmoke"';?>> 
<input type="radio" name="vis" value="1" <?php if(isset($VIS_CHK1)) echo $VIS_CHK1;if(!isset($_GET['block_test'])) echo "disabled";?> /> YES</br>
<input type="radio" name="vis" value="0" <?php if(isset($VIS_CHK1)) echo $VIS_CHK2;if(!isset($_GET['block_test'])) echo "disabled";?> /> NO
</td>


<td>
<input type="radio" name="fun" value="1" <?php if(isset($FUN_CHK1))echo $FUN_CHK1;if(!isset($_GET['block_test'])) echo "disabled";?>  /> YES</br>
<input type="radio" name="fun" value="0" <?php if(isset($FUN_CHK2))echo $FUN_CHK2;if(!isset($_GET['block_test'])) echo "disabled";?>  /> NO
</td>

<td>
<input type="radio" name="cln" value="1"  <?php if(isset($CLN_CHK1)) echo $CLN_CHK1;if(!isset($_GET['block_test'])) echo "disabled";?>  /> YES</br>
<input type="radio" name="cln" value="0" <?php if(isset($CLN_CHK2)) echo $CLN_CHK2;if(!isset($_GET['block_test'])) echo "disabled";?>  /> NO
</td>

<td>
</br>
<input type="radio" name="frm" value="1"  <?php if(isset($FRM_CHK1)) echo $FRM_CHK1;if(!isset($_GET['block_test'])) echo "disabled";?>  /> YES</br>
<input type="radio" name="frm" value="0" <?php if(isset($FRM_CHK2)) echo $FRM_CHK2;if(!isset($_GET['block_test'])) echo "disabled";?>  /> NO</br>
<input type="radio" name="frm" value="2" <?php if(isset($FRM_CHK3)) echo $FRM_CHK3;if(!isset($_GET['block_test'])) echo "disabled";?> /> Not Applicable
</td>

<td>
</br>
<input type="radio" name="rin" value="1"  <?php if(isset($RIN_CHK1))echo $RIN_CHK1;if(!isset($_GET['block_test'])) echo "disabled";?>  /> YES</br>
<input type="radio" name="rin" value="0" <?php if(isset($RIN_CHK2))echo $RIN_CHK2;if(!isset($_GET['block_test'])) echo "disabled";?>  /> NO </br>
<input type="radio" name="rin" value="2" <?php if(isset($RIN_CHK3))echo $RIN_CHK3;if(!isset($_GET['block_test'])) echo "disabled";?> /> Not Applicable
</td>

<td>
</br>
<input type="radio" name="fuse" value="1"  <?php if(isset($FUSE_CHK1))echo $FUSE_CHK1;if(!isset($_GET['block_test'])) echo "disabled";?>  /> YES</br>
<input type="radio" name="fuse" value="0" <?php if(isset($FUSE_CHK2))echo $FUSE_CHK2;if(!isset($_GET['block_test'])) echo "disabled";?>  /> NO </br>
<input type="radio" name="fuse" value="2" <?php if(isset($FUSE_CHK3))echo $FUSE_CHK3;if(!isset($_GET['block_test'])) echo "disabled";?> /> Not Applicable
</td>

<td>
<input type="checkbox" name="defect1" value="1" <?php if(isset($def[1])==1){echo "checked"; } if(!isset($_GET['block_test'])) echo "disabled";?> > New cable or plug fitted<br>
<input type="checkbox" name="defect2" value="1" <?php if(isset($def[2])==1){echo "checked"; } if(!isset($_GET['block_test'])) echo "disabled";?> >Potentiometer changed or cleaned<br>
<input type="checkbox" name="defect3" value="1" <?php if(isset($def[3])==1){echo "checked"; } if(!isset($_GET['block_test'])) echo "disabled";?> >Lens changed or cleaned<br>
<input type="checkbox" name="defect4" value="1" <?php if(isset($def[4])==1){echo "checked"; } if(!isset($_GET['block_test'])) echo "disabled";?> >Internal capacitor or resistor changed<br>
<input type="checkbox" name="defect5" value="1" <?php if(isset($def[5])==1){echo "checked"; } if(!isset($_GET['block_test'])) echo "disabled"; ?> >Other internal components changed/repaired<br> 
</td>
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

<input style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; "


 type='submit' name='Submit' value='Test' align='right'></br>
<input 
style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; "

type='submit' name='Cancel' value='Cancel' align='right'>

</td>

</tr>
<?php if($_SESSION['meter']==2 OR $_GET['meter_out']>0 AND $_SESSION['patt_var']!=2):?>
<tr>
    <td colspan="3">Riso</td><td  style="background-color: whitesmoke" ></td><td><input  type="text" placeholder="Meter Output" value="<?php if(isset($_GET['meter_out'])) echo $_GET['meter_out']; ?>" name="meter" style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; "></td><td colspan="7"></td> 
    
    
    
    
</tr>
<tr>
 <td colspan="3">Ileak</td><td  style="background-color: whitesmoke" ></td><td><input  type="text" placeholder="Meter Output" value="<?php if(isset($_GET['meter_out']) and $_SESSION['class_2']==1) echo $_GET['meter_out']; else if($_SESSION['class_2']!=1 AND $_SESSION['patt_var']==1 AND $_SESSION['patt_var']!=2); else echo 0.1;  ?>" name="meter2" style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; "></td><td colspan="7"></td> 
</tr>

<?php if($_SESSION['class_2']!=1 AND $_SESSION['patt_var']==1 AND $_SESSION['patt_var']!=2) : ?>
<tr>
 <td colspan="3">Rpe</td><td  style="background-color: whitesmoke" ></td><td><input  type="text" placeholder="Meter Output" value="<?php if(isset($_GET['meter_out'])) //echo $_GET['meter_out']; ?>" name="meter3" style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; "></td><td colspan="7"></td> 
</tr>
<?php endif ?>
<?php endif ?>
</form>

</table>

<span id="buttons_out"> 
  <h4>
  
  
 <p class="submit">  
      <a href="add_stock.php"> <button style="padding:9px;   
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 10%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; " class="submit">Return</button> </a> 
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->

 <?php
  echo "<center><div id='form_stock' style='font: normal 13px/100% Verdana, Tahoma, sans-serif; marign: auto;'>";
 message();
 echo "</div></center>"; ?>
    </p>  
 </h4>

 </span>    
 </br></br>
 
 <table width='50%' style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 100%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; ">
 
 <?php

 show_site($user_st);
 echo "</table>";
 //echo $error_msg;   
    
 ?>   
     
 <?php
    if (isset($_GET['test_stock']))
{?>

<script type="text/javascript">
//    var hidden = document.createElement("input");
//hidden.type = "hidden";
//hidden.name = "patt";
//hidden.value = current_score;

var urlParts=document.URL.split("?");
var paramParts=urlParts[1].split("&");
document.writeln("HH");
for(i=0;i<paramParts.length;i++)
{
   var pair=paramParts[i].split("="); 
   document.writeln(pair[0]);
   if(pair[0]="patt")
   {
        document.writeln(pair[1]);
        var patt_var=pair[1];
    }
}
     //document.getElementById('hiddenField').value = patt_var;
   
                //var url = "add_process_bar.php?id=" + document.getElementById('id').value;
                //document.getElementById("myForm").setAttribute('action', url);
    
    document.getElementById('dateForm').submit(); // SUBMIT FORM
</script>    
 <?php
}
 ?>
</body>
</html>
