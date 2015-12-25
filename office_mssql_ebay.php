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
include 'config_six.php';

$site_id;
if(isset($_SESSION['meter']))
unset($_SESSION['meter']);

connect_db();


$filename="scripts/input.txt";
 $fh_read=fopen($filename, "r");
 
 $filename2="scripts/titles.txt";
 $fh_write_title=fopen($filename2,"wb");
 
 $filename3="scripts/sku.txt";
 $fh_write_sku=fopen($filename3,"wb");
 
  $filename4="scripts/notes.txt";
 $fh_write_notes=fopen($filename4,"wb");

global $conn;

if($SIX_WORK==1)
{
 //$serverName="GRRSERVER\TEMPSERVER";
 //change dne on 02 June
//$serverName="MRLCPWORK\MRLCPSQLSERVER";

$serverName="MRLCPWORK\SQLTRIALSERVER";

$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBitserver");
}
else {
    $serverName="TEST-PC\SIXBITDBSERVER";
$connectionInfo = array( "Database"=>"SixBit_BT_001");
}
/* Connect using Windows Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}

function read_ebayid($ebayid,$flag)
{
    global $conn;
    if ($ebayid==-1)
        echo "Error -1";
    echo "Reading ".$ebayid."\n";
    $ebayid=rtrim($ebayid);
    echo "Reading cutted".$ebayid."\n";
   /* 
    $qq="select distinct Sales.eCommerceID,Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country, Sales.TransactionID, Orders.ExternalOrderID, Sales.SalePrice
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Sales.eCommerceID='$ebayid'";
    //echo "\n\n".$qq;
    */
    /*
    "select distinct Sales.eCommerceID, Items.Title, Inventory.SKU
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Sales.eCommerceID='$ebayid'"*/
    
    
   $result = sqlsrv_query($conn,"select distinct Sales.eCommerceID, Items.Title, Inventory.SKU, Sales.Notes
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Sales.eCommerceID='$ebayid'");
//Sales.SaleDate > '2013-11-29' AND Shipments.TrackingNumber='' AND
if (!$result) {
    //die('Query failed.REF ebayidfun', print_r( sqlsrv_errors(),true));
      die( print_r( sqlsrv_errors(), true));
    
}
$i=0;


while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
{ 
    
   /* foreach ($row as $value) {
        echo $value;
    }
    */
    //title
    $title=$row['Title'];
    $sku=$row['SKU'];
    $notes=$row['Notes'];
    
    
    
}
echo "title:".$title;
if($flag==0)
return $title;
if($flag==1)
return $sku;
if($flag==2)
    return $notes;

}


function read_data($fh_read)
{
 
 
     
 $line=fgets($fh_read);    
 echo $line;
 //if(!feof($fh_read))
 return $line;
//else {
 // return -1; 
//}
}


function save_title($fh_write_title,$title)
{
    fwrite($fh_write_title, $title);
    fwrite($fh_write_title, "\r\n");
    
}

function save_sku($fh_write_sku,$sku)
{
    fwrite($fh_write_sku, $sku);
    fwrite($fh_write_sku, "\r\n");
    
}

function save_notes($fh_write_notes,$notes)
{
    fwrite($fh_write_notes, $notes);
    fwrite($fh_write_notes, "\r\n");
    
}

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
<script>
function printpage()
  {
  window.print()
  }
</script>

</HEAD>
<BODY >

     <style id="ni">
        table a:link {
	color: #666;
	font-weight: bold;
	text-decoration:none;
}
table a:visited {
	color: #999999;
	font-weight:bold;
	text-decoration:none;
}
table a:active,
table a:hover {
	color: #bd5a35;
	text-decoration:underline;
}
table {
	font-family:Arial, Helvetica, sans-serif;
	color:#666;
	font-size:12px;
	text-shadow: 1px 1px 0px #fff;
	background:#eaebec;
	margin:20px;
	border:#ccc 1px solid;

	-moz-border-radius:3px;
	-webkit-border-radius:3px;
	border-radius:3px;

	-moz-box-shadow: 0 1px 2px #d1d1d1;
	-webkit-box-shadow: 0 1px 2px #d1d1d1;
	box-shadow: 0 1px 2px #d1d1d1;
}
table th {
	padding:21px 25px 22px 25px;
	border-top:1px solid #fafafa;
	border-bottom:1px solid #e0e0e0;

	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
	background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
}
table th:first-child {
	text-align: left;
	padding-left:20px;
}
table tr:first-child th:first-child {
	-moz-border-radius-topleft:3px;
	-webkit-border-top-left-radius:3px;
	border-top-left-radius:3px;
}
table tr:first-child th:last-child {
	-moz-border-radius-topright:3px;
	-webkit-border-top-right-radius:3px;
	border-top-right-radius:3px;
}
table tr {
	text-align: center;
	padding-left:20px;
}
table td:first-child {
	text-align: left;
	padding-left:20px;
	border-left: 0;
}
table td {
	padding:18px;
	border-top: 1px solid #ffffff;
	border-bottom:1px solid #e0e0e0;
	border-left: 1px solid #e0e0e0;

	background: #fafafa;
	background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
	background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
}
table tr.even td {
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
	background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
}
table tr:last-child td {
	border-bottom:0;
}
table tr:last-child td:first-child {
	-moz-border-radius-bottomleft:3px;
	-webkit-border-bottom-left-radius:3px;
	border-bottom-left-radius:3px;
}
table tr:last-child td:last-child {
	-moz-border-radius-bottomright:3px;
	-webkit-border-bottom-right-radius:3px;
	border-bottom-right-radius:3px;
}
table tr:hover td {
	background: #f2f2f2;
	background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
	background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
}
        
    
    </style>
    
    
    
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
echo "<h4>Office Reports Generator - OfficeMSSQL Module </h4>";
    

?>
    <form method="POST" action="office_mssql.php">
<textarea name="sql" cols="218" rows="20" >
<?php echo $_POST['sql']; ?>

</textarea><br>
<input type="submit" name="query" value="Query" />
</form>
</BR>


    
<?php

if($SIX_WORK==1)
{
 //$serverName="GRRSERVER\TEMPSERVER";
 //change dne on 02 June
//$serverName="MRLCPWORK\MRLCPSQLSERVER";

$serverName="MRLCPWORK\SQLTRIALSERVER";

$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBitserver");
}
else {
    $serverName="TEST-PC\SIXBITDBSERVER";
$connectionInfo = array( "Database"=>"SixBit_BT_001");
}
/* Connect using Windows Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}


/*

 if(isset($_POST['query']))
 {
     //echo "1dsfsdsdfsdf";
    // echo $_POST['sql'];
//echo "council";
echo "<table>";
 $query=$_POST['sql'];
 
 echo $query;
 //$result=sqlsrv_query($conn,$query);
 
 
 $result=mysql_query($query) or die(mysql_error());
 
 // $num_columns=mysql_num_fields($result);
 
 if (!$result) {
   die('Query failed.1');
}
 else {

    //$rek_svr=sqlsrv_fetch_array($result);
   // echo "Result ";
    
    //$num_columns=mssql_num_fields($result);
    $num_columns=20;
  
    for($i=0;$i<$num_columns;$i++)
    {
    echo "<th>";   
    //echo mysql_field_name($result,$i);   
    
    echo "</th>";
     
     }  
 

     
 while($rek=sqlsrv_fetch_array($result))
 {
   echo "<tr>";
   //for($i=0;$i<$num_columns;$i++)
  // {
     //  echo "<td>";
    //echo $rek[$i];
 //  foreach($rek as $value) {
      //  echo '<td>' . $value . '</td>';
  //  }
    //   echo "</td>";
  
   for($i=0;$i<20;$i++)
    echo '<td>' . $rek[$i] . '</td>';
    
    
//   }
 //  echo "</BR>";     
  echo "</tr>";   
 }
  
 echo "</table>";
 
 } 
echo '<input type="button" value="Print Output" onclick="printpage()">';
 
 }
 
 */


while(!feof($fh_read))
{
save_title($fh_write_title,read_ebayid($data=read_data($fh_read),0));
save_sku($fh_write_sku,read_ebayid($data,1));
//save_notes($fh_write_notes,  read_ebayid($data, 2));
}
//save_title($fh_write_title,read_ebayid(read_data($fh_read)));
echo "***END END END***"


   ?>    
</td>
</table>




</BODY>
</HTML>