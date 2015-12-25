<?php
session_start();
//include 'header.php';
include 'header_mysql.php';
include 'menu_header.php';
include 'header_valid.php';
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header.php';
$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 

$site_id;

connect_db();


$status_sql1="SELECT Barcode FROM Barcode";

$status_sql2="SELECT DISTINCT Barcode FROM Barcode";

$result1=query_select($status_sql1);
$num1_bar=mysql_num_rows($result1);
$result2=query_select($status_sql2);
$num2_bar_d=mysql_num_rows($result2);

//echo $num1_bar;
//echo $num2_bar_d;



$status_sql11="SELECT Barcode FROM Barcode "
        . " INNER JOIN Item ON Barcode.Item_id_item=Item.id_item"
        ." INNER JOIN Item_has_cat ON Item.Item_has_Cat_id_item_cat=Item_has_cat.id_item_cat";
$status_sql21="SELECT Barcode FROM Barcode "
        . " INNER JOIN Item ON Barcode.Item_id_item=Item.id_item"
        ." INNER JOIN Item_has_cat ON Item.Item_has_Cat_id_item_cat=Item_has_cat.id_item_cat";

$result1=query_select($status_sql11);
$num1_bar_ar=mysql_num_rows($result1);
$result2=query_select($status_sql21);
$num2_bar_d_ar=mysql_num_rows($result2);

//echo $num1_bar_ar;
//echo $num2_bar_d_ar;


$status_sql1="SELECT name FROM ITEM";

$status_sql2="SELECT DISTINCT name FROM ITEM";

$result1=query_select($status_sql1);
$num1_item=mysql_num_rows($result1);
$result2=query_select($status_sql2);
$num2_item_d=mysql_num_rows($result2);









$query="SELECT * From Barcode WHERE date=CURDATE()";
$result=query_select($query);

$barcode=array();
$serial=array();
$barcode_id=array();
  $num_stock_tod=mysql_num_rows($result);
$i=0;
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $barcode[$i]=$rek["Barcode"];    
     $barcode_id[$i]=$rek["id_Barcode"];
     $serial[$i]=$rek["serial"];  
     //echo $barcode_id[$i]."</br>";
   }


///
$z=0;
$g=0;
$zi=0;
$test_id=array();

for($c=1;$c<=$i;$c++)
{
    
$query="SELECT * From Test WHERE Barcode_id_Barcode=".$barcode_id[$c]." AND Ready='0'";
$result=query_select($query);



if($rek = mysql_fetch_array($result,1));  
   {
    if(!empty($rek['id_test']))
     $z++; 
     //$test_id[$c]=$rek["id_test"];    
     //$serial[$i]=$rek["serial"];  
     //echo $barcode[$i].$serial[$i];
    // if(!isset($test_id[$c]) AND empty($test_id[$c]))
      //  $zi++;
   }
   
$query1="SELECT * From Test WHERE Barcode_id_Barcode=".$barcode_id[$c]." AND Ready='1'";
$result1=query_select($query1);

if($rek = mysql_fetch_array($result1,1));  
   {
    if(!empty($rek['id_test']))
     $g++; 
     //$test_id[$c]=$rek["id_test"];    
     //$serial[$i]=$rek["serial"];  
     //echo $barcode[$i].$serial[$i];
    // if(!isset($test_id[$c]) AND empty($test_id[$c]))
      //  $zi++;
   }



}
?>



<HTML>
<HEAD>
<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">

<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />

<script type="text/javascript" src="csshorizontalmenu.js">



</script>


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

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} 
 echo "</BR>Today, ".date('l jS \of F ');
echo ",</BR></br> Added on Stock: <b>".$i." Items</b></BR>";
echo  "Tested <b>".($g+$z)." Items</b>, while<b> ".$z." Items</b> failed tests.</BR>";
echo "</BR><table border='2' ><tr><td>Test Description</td><td>Status</td></tr>";
echo "</BR> <td> Every Item has UNIQUE Barcode </td><td>YES</td></tr><tr>";
echo "<td colspan='2' border='2'></tr><tr><td>CONTROL STATUS</td></tr><tr>";
echo "<td>UNIQUE BARCODE</td><td>STATUS CRQ</td><td>BARTQ:".$num1_bar." BARDQ:".$num2_bar_d."</td></tr><tr>";
echo "<td></td><td>AREA 1</td><td>BARTQ:".$num1_bar_ar." BARDQ:".$num2_bar_d_ar."</td></tr><tr>";
echo "<td>UNIQUE BARCODE</td><td>STATUS CRQ</td><td>ITTQ:".$num1_item." ITDQ:".$num2_item_d."</td></tr><tr>";

echo "</table>";
//echo $num_stock_tod;
//echo "</br>Stock IN</BR>";
//echo "</BR>PER HOUR / PER USER  ".$num_stock_tod/10;
//echo "<br>Tests</BR>";

//echo "Tottal weight of manifest collection from site places:$sum    Total sum of weight assignment for items comeing from one site place      WEIGHt DISCREPANCY BY TOTALS  show by cattegories";

//echo "total";
?>




</td>
</table>




</BODY>
</HTML>