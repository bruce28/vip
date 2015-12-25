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

$site_id;
if(isset($_SESSION['meter']))
unset($_SESSION['meter']);

connect_db();
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
<?php if(isset($_GET['test'])) {
  
   
}
echo "<center><h4>Office Reports Generator </h4></center>";
    

?>
<form action="office.php" method="POST">
<input type="submit" name="Council" value="Council">
</BR>
<input type="submit" name="ATT" value="att">
</BR>
<input type="submit" name="area1" value="area1">

</BR>
<input type="submit" name="ebay" value="ebay">
</BR>
<input type="submit" name="wholesales" value="wholesales">
</form>
    
<?php
 if(isset($_POST['Council']))
 {
echo "council";
echo "<table>";
 $query="SELECT * FROM Site
INNER JOIN Origin ON Site.Origin_origin_id=origin.origin_id
INNER JOIN Delivery ON delivery.Site_site_id=site.site_id
INNER JOIN trans_category ON trans_category.Category_id=delivery.Trans_Category_category_id";
 
 $result=mysql_query($query) or die(mysql_error());
 
 $num_columns=mysql_num_fields($result);
 
   for($i=0;$i<$num_columns;$i++)
   {
    echo "<th>";   
     echo mysql_field_name($result,$i);   
     echo "</th>";
     
   }  
 
 while($rek=mysql_fetch_array($result))
 {
   echo "<tr>";
   for($i=0;$i<$num_columns;$i++)
   {
       echo "<td>";
       echo $rek[$i];
       echo "</td>";
       
   }
 //  echo "</BR>";     
  echo "</tr>";   
 }
  
 echo "</table>";

 
   }
if(isset($_POST['ATT']))
{
    echo "ATT";   
    echo "<table>";
    
$query="SELECT * FROM Site
INNER JOIN Origin ON Site.Origin_origin_id=origin.origin_id
INNER JOIN Delivery ON delivery.Site_site_id=site.site_id
INNER JOIN trans_category ON trans_category.Category_id=delivery.Trans_Category_category_id
INNER JOIN site_has_cat ON Site.site_id=site_has_cat.Site_site_id";
$result=mysql_query($query) or die(mysql_error());
 
 $num_columns=mysql_num_fields($result);
 
   for($i=0;$i<$num_columns;$i++)
   {
    echo "<th>";   
     echo mysql_field_name($result,$i);   
     echo "</th>";
     
   }  
 
 while($rek=mysql_fetch_array($result))
 {
   echo "<tr>";
   for($i=0;$i<$num_columns;$i++)
   {
       echo "<td>";
       echo $rek[$i];
       echo "</td>";
       
   }
    //echo "</BR>";     
      echo "</tr>";
 }
 
 echo "</table>";

 
 
    
    
} 

if(isset($_POST['area1']))
{
    echo "ATT";   
    echo "<table>";
    
$query="SELECT * FROM Site
INNER JOIN Origin ON Site.Origin_origin_id=origin.origin_id
INNER JOIN Delivery ON delivery.Site_site_id=site.site_id
INNER JOIN trans_category ON trans_category.Category_id=delivery.Trans_Category_category_id
INNER JOIN site_has_cat ON Site.site_id=site_has_cat.Site_site_id
INNER JOIN sub_cat ON site_has_cat.Sub_cat_id_c=sub_cat.id_c
INNER JOIN weight ON weight.id=sub_cat.Weight_id
INNER JOIN category ON category.id=sub_cat.Category_id
";
$result=mysql_query($query) or die(mysql_error());
 
 $num_columns=mysql_num_fields($result);
 
   for($i=0;$i<$num_columns;$i++)
   {
    echo "<th>";   
     echo mysql_field_name($result,$i);   
     echo "</th>";
     
   }  
 
 while($rek=mysql_fetch_array($result))
 {
   echo "<tr>";
   for($i=0;$i<$num_columns;$i++)
   {
       echo "<td>";
       echo $rek[$i];
       echo "</td>";
       
   }
   // echo "</BR>";     
      echo "</tr>";
 }
 
 echo "</table>";

 
 
    
    
} 

if(isset($_POST['ebay']))
{
    echo "ATT";   
    echo "<table>";
    
$query="SELECT * FROM six_barcode";
$result=mysql_query($query) or die(mysql_error());
 
 $num_columns=mysql_num_fields($result);
 
   for($i=0;$i<$num_columns;$i++)
   {
    echo "<th>";   
     echo mysql_field_name($result,$i);   
     echo "</th>";
     
   }  
 
 while($rek=mysql_fetch_array($result))
 {
   echo "<tr>";
   for($i=0;$i<$num_columns;$i++)
   {
       echo "<td>";
       echo $rek[$i];
       echo "</td>";
       
   }
    //echo "</BR>";     
      echo "</tr>";
 }
 
 echo "</table>";

 
 
    
    
}


if(isset($_POST['wholesales']))
{
    echo "ATT";   
    echo "<table>";
    
$query="SELECT * FROM Barcode
INNER JOIN item ON barcode.item_id_item=item.id_item
INNER JOIN item_has_cat ON item_has_cat.id_item_cat=item.Item_has_Cat_id_item_cat
INNER JOIN barcode_has_buyer ON barcode.id_Barcode=barcode_has_buyer.Barcode_id_Barcode
";
$result=mysql_query($query) or die(mysql_error());
 
 $num_columns=mysql_num_fields($result);
 
   for($i=0;$i<$num_columns;$i++)
   {
    echo "<th>";   
     echo mysql_field_name($result,$i);   
     echo "</th>";
     
   }  
 
 while($rek=mysql_fetch_array($result))
 {
   echo "<tr>";
   for($i=0;$i<$num_columns;$i++)
   {
       echo "<td>";
       echo $rek[$i];
       echo "</td>";
       
   }
    //echo "</BR>";     
      echo "</tr>";
 }
 
 echo "</table>";

 
 
    
    
}




   ?>    
</td>
</table>




</BODY>
</HTML>