<?php
//include 'header_mysql.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$BARCODE_COMM=0;

$PREFIX_DBS="DBS";
$PREFIX_UNQ="UNQ";
$PREFIX_ONS="ONS";



function validate_barcode($barcode)
{
    global $PREFIX_DBS;
    global $PREFIX_ONS;
    global $PREFIX_UNQ;
    
    echo $prefix=strtoupper(substr($barcode,0,3)); //take prefix
    
    if(strcmp($PREFIX_DBS,$prefix) AND strcmp($PREFIX_UNQ,$prefix))
    {
        return 2;
    }  else {
       return 0;    
    }
     return $prefix;       
    
    
}

function check_ebay_sell()
{
    
    
}

function insert_six_barcode_sells($itemid,$buyerid,$barcode,$conn)
{
    
    
    connect_db();
    
   // $row = sqlsrv_fetch_array($stmt);
//echo "User login: ".$row[0]."</br>";





$result = sqlsrv_query($conn,"select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country, Sales.eCommerceID, Sales.TransactionID, Orders.ExternalOrderID, Sales.SalePrice
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Items.ItemID='$itemid' AND Orders.BuyerID='$buyerid'");
//Sales.SaleDate > '2013-11-29' AND Shipments.TrackingNumber='' AND
if (!$result) {
    die('Query failed.');
}
$i=0;
echo "<table border='2'>";




while($row = sqlsrv_fetch_array($result))
{
    
//echo "<td> ".$row[0]."</td><td> ".$row[1]."</td> <td>".$row[2]."</td><td> ".$row[3]."</td><td> ".$row[5]."</td><td> ".$row[6]."</td><td> ".$row[7]."</BR>".$row[8]."</td><td> ".$row[9]."</BR>".$row[10]."</BR> ".$row[11]."</td><td> ".$row[12]."</td><td> ".$row[13]."</td><td> ".$row[14]."</BR> ".$row[15]." </br>";
$u_barcode=swap_back($row[2]); //this a stoc number in reality
$ebaid=$row[16];
$ebairef=$row[17];
$tracking_number=$row[6];
$user=1;
$date=$row[4];
$item_id=$row[0];
$itemid;
$firstname=str_replace("'","a",$row[7]);
$lastname=  str_replace("'", "a", $row[8]);
//echo $itemid;
echo $lastname;
$unique=  swap_back($_POST['un_barcode']);
echo $unique;
echo $firstname;
$address1= str_replace("'","a",$row[9]);
$address2=  str_replace("'","a",$row[10]);
$address3=str_replace("'","a",$row[11]);
echo $address1;
echo $address2;
echo $address3;
$city=$row[12];
$state=$row[13];
$postalcode=$row[14];
$country=$row[15];
$ebaysales=$row[18];
$date_s=$row[4]->format('Y-m-d');
$price=$row[19];
//$date_s=$row[4];
echo $date_s;


$id_barcode=get_barcode_id($barcode);
echo $id_Barcode;

$FLAG_RDT_TO_GO=0;
global $BARCODE_COMM;

if(empty($id_barcode))
{
    //empty barcode id. Means barcode does not exists in barcode table, Though does not exist
    $BARCODE_COMM=" Empty Barcode";
    
}
 else {
  $FLAG_RDT_TO_GO=1;    
}

//checking ebay. Already sold



//check if tested and passed test

        $test_result=check_barcode_test($id_barcode);
if($test_result==1)
{
    $FLAG_RDT_TO_GO=1;
    echo "Tested it";
    
}
else
{
    $FLAG_RDT_TO_GO=0;
    
}


if($FLAG_RDT_TO_GO==1)
{
   $result_ebay=check_barcode_ebay($barcode);
   if($result_ebay==1)
   {
    $FLAG_RDT_TO_GO=1;
   }
    else {
   $FLAG_RDT_TO_GO=0;    
   }
}


//here we consider a case that needs current day to help tracking how many disposed that day

$date_disposed=date("Y-m-d");

  //echo "</BR>ass ".$address1=explode(',',preg_replace('/^\[(.*)\]$/','$1',$address1));
//here we take care of special characters conversion

echo "first: ".$firstname;
      echo "last:".  $lastname;
      echo $lastname=str_replace(")", "", $lastname);  //here is a problem (EMPA NW LTD)) No string compatibel
    echo $lastname=mysql_real_escape_string($lastname);
$address1=  mysql_real_escape_string($address1);
$address2=  mysql_real_escape_string($address2);
$address3=  mysql_real_escape_string($address3);

$city=  mysql_real_escape_string($city);
 $state-mysql_real_escape_string($state);

echo $insert="INSERT INTO six_barcode(u_barcode, barcode_id_Barcode,ebayid, ebayref, tracking_num, parceler"
        . ",stock_number,date_ship,item_id,name,surname,address1,address2,address3,city,state,postalcode, country, ebaysales,price,date_disposed) VALUES('$barcode','$id_barcode','$ebaid','$ebairef','$tracking_number','$id_user','$u_barcode','$date_s','$item_id','$firstname','$lastname','$address1','$address2','$address3','$city','$state','$postalcode','$country','$ebaysales','$price','$date_disposed')";
//echo $insert;




if($FLAG_RDT_TO_GO==1)
  $result=mysql_query($insert) or die(mysql_error());  
    
    
   echo $BARCODE_COMM; 
    if($result AND $FLAG_RDT_TO_GO==1)
         return 1;
    else
        return 0;
}
}

function check_barcode_ebay($barcode)
{
    //$barcode=validate_barcode($barcode);
echo $select="SELECT * FROM six_barcode WHERE u_barcode='$barcode'";
$result=mysql_query($select) or die(mysql_error());
    $rek=mysql_fetch_array($result,MYSQL_BOTH);
    $u_barcode=$rek['u_barcode'];
    
    if(empty($u_barcode))
   {
    return 1;    
    echo $barcode;    
   }
   else 
   {
       echo "This barcode needs further attention Please contact supervisor. 1)";
      return 0; 
   }

}
//by default we check id Barcode
function check_barcode_test($id_barcode)
{
$select="SELECT Ready From test Where Barcode_id_Barcode='$id_barcode'";
$result=mysql_query($select) or die(mysql_error());
$rek=mysql_fetch_array($result,MYSQL_BOTH);
if($rek['Ready']!=1)
{
    echo "Item not tested..";
    return 0;
}
else if($rek['Ready']==1)
{
    echo "Item passed test";
return 1;
    
}
//adding a new module
}

function check_barcode_sold_wholesale($id_barcode)
{
$select="SELECT * From barcode_has_buyer Where Barcode_id_Barcode='$id_barcode' AND finished=2";
$result=mysql_query($select) or die(mysql_error());
$rek=mysql_fetch_array($result);
if($rek[2]==$id_barcode)
{
    echo "Item sold on wholesale";
    exit();
}
}

function get_barcode_id($barcode)
{
    
$select="SELECT * From Barcode Where Barcode='$barcode'";
$result=mysql_query($select) or die(mysql_error());
$rek=mysql_fetch_array($result);
$id_barcode=$rek['id_Barcode'];
return $id_barcode;    
    
}

function check_sold_transaction($barcode,$itemid)
{
   // this one checks if listing id there not good cause the stock number the same not sold availible,possible
  //$sql="select * from six_barcode WHERE item_id='$itemid'";
  $sql="select * from six_barcode WHERE item_id='$barcode'";
  $result=mysql_query($sql);
  $i=0;
  while($rek=mysql_fetch_array($result,MYSQL_BOTH))
  {    
          //echo $rek['u_barcode'];
          $i++;       
  }
  return $i;
    
}

function show_message($MESG)
{
    //wrap_table_in();
    echo "<table><tr>";
    echo "<td>";
    echo "<b>Communicate:".$MESG;
    echo "</b></td>";
    echo "</tr></table>";
    //wrap_table_out();
    
}
