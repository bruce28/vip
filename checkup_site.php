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

$site_id;
if(isset($_SESSION['meter']))
unset($_SESSION['meter']);


?>

<HTML>
<HEAD>
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">

<!--

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css" />
-->


<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
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

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php 
$serwer='127.0.0.1';
$user='root';
$password='krasnal';
$dbs='dbs3';

mysql_connect($serwer,$user,$password); 

mysql_select_db($dbs);
echo "<form action=checkup.php method='POST'>";
echo "<select name='id_check'><option value='1'>Everything</option><option value='2'>Failed test</option><option value='3'>Weights Tested</option><option value='4'>Users</option><option value='5'>Sold</option></select>";
echo "<input type='submit' name='check' value='Check'></form>";


if(isset($_POST['check']))
{
 echo '<table border=1>';   

if($_POST['id_check']==1)
{
    echo "1";
$sql="SELECT * FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
WHERE Test.Ready=1 AND Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%UNQ/%'
";
$i=0;
$result=mysql_query($sql) or die(mysql_error());

while($rek=mysql_fetch_array($result))
{
    $i++;
    echo '<tr>';
   //echo $rek[0]; 
   
    foreach ($rek as $value) {    
         echo "<td> ";
    echo $value;
    echo '</td>';
  
}
  echo '</tr>';
}
}

if($_POST['id_check']==2)
{
    echo "2";
$sql="SELECT * FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
WHERE Test.Ready=0 AND  (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%UNQ/%')
";
$i=0;
$result=mysql_query($sql) or die(mysql_error());

while($rek=mysql_fetch_array($result))
{
    $i++;
    echo '<tr>';
   //echo $rek[0]; 
   
    foreach ($rek as $value) {    
         echo "<td> ";
    echo $value;
    echo '</td>';
  
}
  echo '</tr>';
}
}

if($_POST['id_check']==3)
{
    echo "3";
$sql="
SELECT SUM(weight)as weight, item.name FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON item_has_cat.id_item_cat=item.Item_has_Cat_id_item_cat 
WHERE Test.Ready=1 AND Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%UNQ/%' GROUP BY weight";
$i=0;
$result=mysql_query($sql) or die(mysql_error());

while($rek=mysql_fetch_array($result))
{
    $i++;
    echo '<tr>';
   //echo $rek[0]; 
   
    foreach ($rek as $value) {    
         echo "<td> ";
    echo $value;
    echo '</td>';
  
}
  echo '</tr>';
}
}

if($_POST['id_check']==4)
{
    echo "4";
$sql="
SELECT COUNT(*) as ile, user_2.name FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON item_has_cat.id_item_cat=item.Item_has_Cat_id_item_cat 
WHERE Test.Ready=1 AND Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%UNQ/%' GROUP BY weight";
$i=0;
$result=mysql_query($sql) or die(mysql_error());

while($rek=mysql_fetch_array($result))
{
    $i++;
    echo '<tr>';
   //echo $rek[0]; 
   
    foreach ($rek as $value) {    
         echo "<td> ";
    echo $value;
    echo '</td>';
  
}
  echo '</tr>';
}
}

if($_POST['id_check']==5)
{
    echo "5";
$sql="
SELECT count(*)as sold FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON item_has_cat.id_item_cat=item.Item_has_Cat_id_item_cat 
LEFT JOIN barcode_has_buyer ON Barcode.id_barcode=Barcode_has_buyer.Barcode_id_Barcode
WHERE Test.Ready=1 AND finished=2 AND (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%UNQ/%') ";
$i=0;
$result=mysql_query($sql) or die(mysql_error());

while($rek=mysql_fetch_array($result))
{
    $i++;
    echo '<tr>';
   //echo $rek[0]; 
   
    foreach ($rek as $value) {    
         echo "<td> ";
    echo $value;
    echo '</td>';
  
}
  echo '</tr>';
}
}




echo '</table>';






}






?>

</td>
</table>




</BODY>
</HTML>