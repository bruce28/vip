<?php
session_start();
include 'header_valid.php';
$_SESSION['quantity']=$_POST['quantity'];
$id_user=$_SESSION['id_user'];

$date=$_POST['date1'];
include 'config_six.php';

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

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

    
    
   
 
if(isset($_POST['add'])AND !empty($_POST['add']))
{
    echo 'Barcode Added';
    $item_id=$_POST['item_id'];
    $buyer_id=$_POST['buyer_id'];
    
    //$serverName="TEST-PC\SIXBITDBSERVER";

//$connectionInfo = array( "Database"=>"SixBit_BT_001");

    if($SIX_WORK==1)
    {
    $serverName="GRRSERVER\SIXBITDBSERVER";


$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBit_BT_001");
    }
    else
    {
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

/* Query SQL Server for the login of the user accessing the
database. */
$tsql = "SELECT CONVERT(varchar(32), SUSER_SNAME())";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */
$row = sqlsrv_fetch_array($stmt);
echo "User login: ".$row[0]."</br>";

$itemid=$_POST['item_id'];
$buyerid=$_POST['buyer_id'];



$result = sqlsrv_query($conn,"select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country, Sales.eCommerceID, Sales.TransactionID
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '2013-11-29' AND Shipments.TrackingNumber='' AND Orders.StatusID='100000' AND Items.ItemID='$itemid' AND Orders.BuyerID='$buyerid'");

if (!$result) {
    die('Query failed.');
}
$i=0;
echo "<table border='2'>";




while($row = sqlsrv_fetch_array($result))
{
    
echo "<td> ".$row[0]."</td><td> ".$row[1]."</td> <td>".$row[2]."</td><td> ".$row[3]."</td><td> ".$row[5]."</td><td> ".$row[6]."</td><td> ".$row[7]."</BR>".$row[8]."</td><td> ".$row[9]."</BR>".$row[10]."</BR> ".$row[11]."</td><td> ".$row[12]."</td><td> ".$row[13]."</td><td> ".$row[14]."</BR> ".$row[15]." </br>";
$u_barcode=swap_back($row[2]);
$ebaid=$row[16];
$ebairef=$row[17];
$tracking_number=$row[6];
$user=1;
$date=$row[4];
$item_id=$row[0];
$itemid;
$firstname=$row[7];
$lastname=$row[8];
//echo $itemid;

$unique=  swap_back($_POST['un_barcode']);
echo $unique;

$address1=$row[9];
$address2=$row[10];
$address3=$row[11];

$city=$row[12];
$state=$row[13];
$postalcode=$row[14];
$country=$row[15];

//$date_s=$row[4];
echo $date_s;

$select="SELECT * From Barcode Where Barcode='$unique'";
$result=mysql_query($select) or die(mysql_error());
$rek=mysql_fetch_array($result);
$id_barcode=$rek['id_Barcode'];
echo $id_Barcode;
$insert="INSERT INTO six_barcode(u_barcode, barcode_id_Barcode,ebayid, ebayref, tracking_num, parceler"
        . ",stock_number,item_id,name,surname,address1,address2,address3,city,state,postalcode, country) VALUES('$unique','$id_barcode','$ebaid','$ebairef','$tracking_number','$id_user','$u_barcode','$item_id','$firstname','$lastname','$address1','$address2','$address3','$city','$state','$postalcode','$country')";

if($_POST['ind']==1)
{
    $insert="INSERT INTO six_barcode(u_barcode, barcode_id_Barcode,ebayid, ebayref, tracking_num, parceler"
        . ",stock_number,item_id,name,surname,address1,address2,address3,city,state,postalcode, country,ind) VALUES('$unique','$id_barcode','$ebaid','$ebairef','$tracking_number','$id_user','$u_barcode','$item_id','$firstname','$lastname','$address1','$address2','$address3','$city','$state','$postalcode','$country','1')";

    
}
mysql_query($insert) or die(mysql_error());

}
    
    
    
    
}

    
    
    
    
    
   
//$serverName="TEST-PC\SIXBITDBSERVER";

//$connectionInfo = array( "Database"=>"SixBit_BT_001");

if($SIX_WORK==1)
{
 $serverName="GRRSERVER\SIXBITDBSERVER";

$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBit_BT_001");
}
else
{
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

/* Query SQL Server for the login of the user accessing the
database. */
$tsql = "SELECT CONVERT(varchar(32), SUSER_SNAME())";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */
$row = sqlsrv_fetch_array($stmt);
echo "User login: ".$row[0]."</br>";

$itemid=$_POST['item_id'];
$buyerid=$_POST['buyer_id'];



$result = sqlsrv_query($conn,"select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '2013-11-29' AND Shipments.TrackingNumber='' AND Orders.StatusID='100000' AND Items.ItemID='$itemid' AND Orders.BuyerID='$buyerid'");

if (!$result) {
    die('Query failed.');
}
$i=0;
echo "<table border='2'>";
while($row = sqlsrv_fetch_array($result))
{
    
 $i++;   
 echo "<tr>";
echo "<td>Six Bit: ".$i."</td><td> ".$row[0]."</td><td> ".$row[1]."</td> <td>".$row[2]."</td><td> ".$row[3]."</td><td> ".$row[5]."</td><td> ".$row[6]."</td><td> ".$row[7]."</BR>".$row[8]."</td><td> ".$row[9]."</BR>".$row[10]."</BR> ".$row[11]."</td><td> ".$row[12]."</td><td> ".$row[13]."</td><td> ".$row[14]."</BR> ".$row[15]." </br>";
echo "</tr>";
echo '<tr>';
echo '<td>';

if(isset($_POST['tv_cat']))
   $ind=1; 

echo "<form action=six_add.php method=post> <input type='text' name='un_barcode'><input type='hidden' name='item_id' value='".$itemid."'> "
. "<input type='hidden' name='buyer_id' value='".$buyerid."'> ";
if($ind==1) echo "<input type='hidden' name='ind' value='1'>";
echo "<input type='Submit' name='add' value='Add cross-reference'>"
. "</form>";
echo '</td>';
echo '</tr>';
}
echo "</table>"; 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 



?>
<HTML>
<HEAD>
    <link rel="stylesheet" href="layout_pr.css " type="text/css">
<link rel="stylesheet" href="form_cat_pr.css " type="text/css">

<script>

</script>

</HEAD>
<BODY>
    <!--<IMG SRC="weee_out/image002.png" WIDTH=180 HEIGHT=151 align="left">
   -->
   <div id="all">

<div id="form_stock" style="font: xx-large; font-variant: simplified; font-family: sans-serif; font-size:  inherit; ">

    


<?php

$sql = "SELECT * FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id";
$sql1= "SELECT name_cat,type_2 from Category";

$serwer="localhost";
$login="root";
$haslo="krasnal";
$baza="dbs3";
 
     

    if (mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza)) { 
         
        $wynik = mysql_query($sql1) 
        or die("Blad w zapytaniu!"); 
         
        mysql_close(); 
    } 
    else echo "Cannot Connect"; 



//echo " <table border='1' > <tr><td></td></tr>";

$att_num=1;
$i=0;

 mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);

$lda=0;
$sda=0;
$lda_s=0;
$sda_s=0;
$znacznik_formy=0;



//} 
    // echo "</table> ";
//echo "<input type='submit' name='Submit' value='Add Ref Num' align='right'></form>";
//unset
     
     ?>



</div>
    </div>

   
<style type="text/css">
@media print {
    .submit {
        display :  none;
    }
}
</style>



   <div id="buttons">
<h4> <a href="six.php"><button class="submit" style=" width: auto;  
    margin: 15px;
    padding: 9px 15px;  
    background: #617798;  
    border: 0;  
    font-size: 14px;  
    color: #FFFFFF;  
    -moz-border-radius: 1px;  
    -webkit-border-radius: 1px;  ">Return</button></a>
</h4>

   
   
   </div>

</BODY>
</HTML>