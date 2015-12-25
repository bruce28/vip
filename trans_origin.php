<?php
session_start();
include 'header_valid.php';
include 'dbs3_config.php';

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
if($rek=='1')
  $result="Yes";
 else
  $result="No";
	
	return $result ;
}

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql);
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

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

$sql="SELECT * FROM Barcode
          INNER JOIN Item ON Barcode.Item_id_item=Item.id_item
          INNER JOIN Buyer ON Buyer.id_Buyer=Barcode_has_Buyer.Buyer_id_Buyer 
          INNER JOIN Barcode_has_Buyer ON Barcode_has_Buyer.Barcode_id_Barcode=Barcode.id_Barcode
          INNER JOIN Site ON Site.site_id=Barcode.Site_site_id
          INNER JOIN Origin ON Origin.origin_id=Site.Origin_origin_id WHERE finished=2
          ";
        

$sql="SELECT id_Barcode, Site_site_id,Item_id_item, Barcode,Barcode.date as bar_date,pn,brand,Item.name as item,
    site_id,site_ref_number,batch_date, Source_source_id, 
    Origin.company_name as company_name_s, Origin.name as name_s, Origin.surname as surname_s,
    Origin.post_code as post_code_s, Origin.town as town_s, Invoice_inv_id, ref_sell_number, Buyer.id_Buyer, Buyer.postcode,
    date_sold,finished
FROM Barcode
INNER JOIN Item ON Barcode.Item_id_item = Item.id_item
INNER JOIN Site ON Site.site_id = Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id = Site.Origin_origin_id
INNER JOIN Barcode_has_Buyer ON Barcode_has_Buyer.Barcode_id_Barcode = Barcode.id_Barcode
INNER JOIN Buyer ON Buyer.id_Buyer = Barcode_has_Buyer.Buyer_id_Buyer where finished=2";

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

<link rel="stylesheet" href="layout.css " type="text/css">
</HEAD>
<BODY>

<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>





<div id="tabel_wrap_out"></BR></BR></BR>	
<table id="tabel_out" border="1" style="table-layout: auto; width: 100%;" >


<tr><td>Transaction Name</td><td>Barcode</td><td>Item</td><td>Brand</td> <td>Model</td> <td>Buyer ID</td><td>Post Code of a Buyer</td><td>Date Sold</td>
<td>ST</td><td>Origin</td><td>ORI_SUR</td><td>ORI_POST</td><td>ORI_TOWN</td><td>Site Visit Num</td><td>Date Collected</td></tr>
<?php

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;

while($rek = mysql_fetch_array($result,1)) { 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
   echo '<tr><td>'.$rek["ref_sell_number"].'</td><td>'.$rek["Barcode"].'</td>'; 
	 echo '<td>'.$rek["Item_id_item"].'</td>';
	 echo '<td>'.$rek["brand"].'</td>';
     echo '<td>'.$rek["pn"].'</td>';
     
     //Buyer id
      echo '<td>'.$rek["id_Buyer"].'</td>';
	 echo '<td>'.$rek["postcode"].'</td>';
echo '<td>'.$rek["date_sold"].'</td>';
echo '<td>'.$rek["finished"].'</td>';



	//site origin
     echo '<td>'.$rek["name_s"].'</td>';
echo '<td>'.$rek["surname_s"].'</td>';
echo '<td>'.$rek["post_code_s"].'</td>';
echo '<td>'.$rek["town_s"].'</td>';
echo '<td>'.$rek["site_id"].'</td>';
echo '<td>'.$rek["batch_date"].'</td>';
	
	echo '<td>'.$rek["bar_date"].'</td>';
	 echo '</tr>';
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}

?>

</table>
</div> 

  
<div id="buttons_out"> 
  <h4>
  
  
 <p class="submit">  
       <a href="index.php"> <button class="submit">Return</button> </a>
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->
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