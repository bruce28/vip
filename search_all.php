<?php
session_start();
include 'header_valid.php';
include 'dbs3_config.php';

function draw($meter)
{
    if(empty($meter))
    return "-";
    else
        return $meter;
}

function dup_row($count)
{
 if($count="0")
   return 0;    
 else
 {
     
 }   
}
function test_string($rek)
{
if($rek=='2')
{
   $result="N/A";
   return $result;    
}
if($rek=='1')
  $result="Yes";
 else
  $result="No";
	
	return $result ;
}

function add_db($sql)
{

	 
   $result=mysql_query($sql)or die(mysql_error());
	return $result;
}

$barcode=$_POST['barcode'];
$item=$_POST['item'];
$brand=$_POST['brand'];
$serial=$_POST['serial'];
$pat=$_POST['pat'];
$fun=$_POST['fun'];
$cln=$_POST['cln'];
$vis=$_POST['vis'];
$defect=$_POST['defect'];
$rdy=$_POST['rdy'];

if($_POST["Cancel"]=="Cancel")
echo "Cancel";

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

$sql='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         . ' INNER JOIN Formatted ON Formatted.id_form=Test.Formatted_id_form'
         . ' INNER JOIN Reinstallation ON Reinstallation.id_reinst=Test.Reinstallation_id_reinst '
         . ' INNER JOIN Fuse ON Fuse.id_fuse=Test.Fuse_id_fuse '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item ORDER BY id_test';
        

$result=add_db($sql);

/*

$tab = array();
for($z=0;$z<=100;$z++)
   $tab[$z]=0;

	 echo $barcode;
    //echo $_POST[$idd];
    //echo " "; 
  echo $pat ;
		//echo $_POST[$name];
    //echo " "; 
  
	 
	 $d=0;
for($i=1;$i<=10;$i++)
{ 

  $d++;
	
	$def_name="defect".$d;
  //$tab[$i]=0;   
	  echo "</ BR></BR>"; 
  
    //echo $_POST[$weight];
    //echo " "; 
  
    //echo $_POST[$cat_id];
  
	
	if(isset($_POST["$def_name"]))
	 if($_POST["$def_name"]=="1")
	 {
	  echo $d;
	   
	  
	  }
 
    //echo $sum_sub;
  //$tab[$_POST[$cat_id]]+=$sum_sub; 

 
	//echo $site;
	
	
}	
*/


/*

   $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`) VALUES ('0','$barcode','$pat', '$cln', '$fun', '$vis', '$rdy')"; 
	 
	 
	 
  echo mysql_query($insert1);
*/
    
		
		
		




?>
<HTML>
<HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"> -->

<link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">

<!--
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

 -->
<link rel="stylesheet" href="layout.css " type="text/css">

</HEAD>
<BODY>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</br>
</br>
</br>
</br>

<div id="tabel_wrap_out"></BR></BR></BR>
		
<table id="tabel_out" border="1">


<tr><td>Test</td><td>Barcode</td><td>Item</td><td>Brand</td><td>Item type</td><td>PAT</td><td>Meter reading</td><td>Functionality</td><td>Cleaning</td><td>Visual state</td><td>Reinstallation</td><td>Formatted</td><td>Correct fuse fitted</td><td>Ready</td><td>Date Tested</td></tr>
<?php

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;

while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { 
   $i++;  
  // if($tab[$rek["id_test"]]<'1')
   //{
   echo '<tr><td>'.$rek["id_test"].'</td><td>'.$rek["Barcode"].'</td>'; 
	 echo '<td>'.$rek["Item_id_item"].'</td>';
	 echo '<td>'.$rek["brand"].'</td>';
	 echo '<td>'.$rek["name"].'</td>';
	  echo '<td>'.test_string($rek["Pat_id_pat"]).'</td>';
          echo '<td>'.draw($rek["meter"]).'</td>';
          echo '<td>'.draw($rek["meter2"]).'</td>';
          echo '<td>'.draw($rek["meter3"]).'</td>';
	  echo '<td>'.test_string($rek["Functional_id_fun"]).'</td>';
		 echo '<td>'.test_string($rek["Cleaning_id_clean"]).'</td>';
		  echo '<td>'.test_string($rek["Visual_id_visual"]).'</td>';
          echo '<td>'.test_string($rek["Reinstallation_id_reinst"]).'</td>';
		  echo '<td>'.test_string($rek["Formatted_id_form"]).'</td>';
                  echo '<td>'.test_string($rek["Fuse_id_fuse"]).'</td>';
			 echo '<td>'.test_string($rek["Ready"]).'</td>';
			  echo '<td>'.$rek[12].'</td>';//date of test from name
	 echo '</tr>';
     //}
  
	//  $tab[$rek["id_test"]]+=1;
}

?>


</table>
</div>
<div id="buttons_out"> 
<h4> <p class="submit"> 
    <a href="index.php"> <button class="submit">Return</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 </p>
</h4>
</div>
<?php
/*
$sql = "SELECT *FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id";
$sql1= "SELECT name_cat,type_2 from Category";

$serwer="localhost";
$login="root";
$haslo="krasnal";
$baza="scm";
 
     

    if (mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza)) { 
         
        $wynik = mysql_query($sql1) 
        or die("Blad w zapytaniu!"); 
         
        mysql_close(); 
    } 
    else echo "Cannot Connect"; 



echo " <table border='1' > <tr><td>CATEGORY OF WEEE COLLECTED</td><td>WEIGHT (In Kg)</td></tr>";

$i=0;
while($rek = mysql_fetch_array($wynik,1)) { 
   $i++;  
   echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> ".$tab[$i]." </td></tr>"; 
}


//while($rek = mysql_fetch_array($wynik,1)) { 
  //  echo "<tr><td>".$rek["name_cat"]."</td><td> ".$rek["Name"]." </td><td>   ".$rek["Street"]."  </td><td> ".$rek["House"]." </td><td> ".$rek["Date_Sold"]."</td><td>".$rek["Price"]." �</td></tr><br />"; 
//} 
     echo "</table> "
*/
?>
<br><BR>
<?php
//<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>
</BODY>
</HTML>