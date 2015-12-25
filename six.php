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
?>


<?php
/* Specify the server and connection string attributes. */
//$serverName = "(local)";

//$serverName="TEST-PC\SIXBITDBSERVER";



if($SIX_WORK==1)
{
$serverName="GRRSERVER\SIXBITDBSERVER";
//$connectionInfo = array( "Database"=>"SixBit_BT_001");
$connectionInfo = array( "Database"=>"SixBit_BT_001");


$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBit_BT_001");
}
 else {


$serverName="TEST-PC\SIXBITDBSERVER";
     $connectionInfo = array( "Database"=>"SixBit_BT_001");
}

$dbcMssql = sqlsrv_connect($server, $connectionInfo);


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






$result = sqlsrv_query($conn,"select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country, Orders.ExternalOrderID, Sales.SalePrice, Items.Notes
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '2014-04-28'  AND Orders.StatusID='100000' AND Orders.ExternalOrderID>270000 ORDER by Sales.SaleDate");
//AND Shipments.TrackingNumber=''
if (!$result) {
    die('Query failed.');
}
$i=0;

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

echo "<table border='2'>";
while($row = sqlsrv_fetch_array($result))
{
 $i++;   
 $check_sql="SELECT * FROM six_barcode WHERE ebaysales='$row[16]'";
 $res_check=mysql_query($check_sql) or die(mysql_error());
 $rek_check=mysql_fetch_array($res_check);
 if($rek_check)
 {
     
     echo "<tr bgcolor='grey'>";
    // echo "<td>".$row[16].$rek_check[20]."</td>";
 }
     else
 echo "<tr>";
echo "<td>Six Bit: ".$i."</td><td> ".$row[0]."</td><td> ".$row[1]."</td> <td>".$row[2]."</td><td> ".$row[3]."</td><td> ".$row[4]->format('Y-m-d')."</td><td> ".$row[5]."</td><td> ".$row[16]."</td><td> ".$row[6]."</td><td> ".$row[7]."</BR>".$row[8]."</td><td> ".$row[9]."</BR>".$row[10]."</BR> ".$row[11]."</td><td> ".$row[12]."</td><td> ".$row[13]."</td><td> ".$row[17]."</td><td> ".$row[18]."</td><td> ".$row[14]."</BR> ".$row[15]." </br>";
//echo "date".$row[4];
echo "</tr>";

}
echo "</table>";



/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
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

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">


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

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>
//LETS ADD PROCESSING FUNCTION HERE

connect_db();
$query="SELECT * From Origin ";
//this can be twofold, both distinct inner join or every site place distinctivel from origin tabel
//INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id

$result=query_select($query);

$users=array();
$names=array();
$batch_date=array();

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


?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>

    <center><h4>Ebay Cross-reference Sells </h4></center>
    
    </BR>
    </BR>
    </BR>
   
    <div style="margin: 10px;">
    <form action="six.php" method="POST" >
      <p><select name="site" size="1">
 <?php
    for($z=0;$z<1;$z++)
    {
        echo '<option value="0">Default </option>';
        echo '<option value="1">No Tracking Number </option>';
        echo '<option value="2">Has Been Sold Not Parcelled </option>';

    }
        echo '</select></span>';
        
      ?>                
        <label for="site" >Sells type</label>              
                      
                      <input type="text" name="date" value="" placeholder="YYYY-MM-DD"><label for="date">Recent period sold</date></p>
                      <input type="submit" name="Generate" value="List" style="
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                      <input type="checkbox" name="print_out" value="yes" <?php if(isset($_POST['print_out'])) echo 'checked=""'; ?>  >Individual customer<br>
    </form>
        <style>
          label{
          margin-left: 10px;   
          color: #999999;
          font: normal 13px/100% Verdana, Tahoma, sans-serif;
            }
           </style>
    </div>
    
    
    
    
    <?php
    if(isset($_POST['Generate']))
    {
        $date = date("Y-m-d H:i:s ", strtotime("08/14/2012 1:05:18 PM"));
        echo '<p style="margin-left: 10px;">';
        echo "Six Bit Sales";
        // Searching ond output results module
        
        if(empty($_POST['date'])AND empty($_POST['site']))
        {    
            
        $select_list="select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '2013-01-15' AND Shipments.TrackingNumber='' AND Orders.StatusID='100000'";

        }
        else if(!empty($_POST['date'])) 
        {
            $dd_s=$_POST['date'];
            $dd.='00:00:00';
           $select_list="select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '$dd' AND Shipments.TrackingNumber='' AND Orders.StatusID='100000'";
                   
            
        }
        else if(!empty($_POST['site']))
        {
           $dd_t=$_POST['site']; 
          $select_list="SELECT DISTINCT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id WHERE origin_id='$dd_t'
           GROUP BY town;
         ";              
            
        }
        if(!empty($_POST['date'])AND !empty($_POST['site']))
        {
           $dd_t=$_POST['site']; 
            $dd_s=$_POST['date'];
        $select_list="select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '$dd_s' AND Shipments.TrackingNumber='' AND Orders.StatusID='100000'";
        }
        
        
        
        
//$serverName="TEST-PC\SIXBITDBSERVER";
//$serverName="GRRSERVER\GRRSQLSERVER";
//$connectionInfo = array( "Database"=>"SixBit_BT_001");
//$connectionInfo = array( "Database"=>"lcp");
/* Connect using Windows Authentication. */
        
if($SIX_WORK==1)
{
 $serverName="GRRSERVER\SIXBITDBSERVER";
//$connectionInfo = array( "Database"=>"SixBit_BT_001");
//$connectionInfo = array( "Database"=>"SixBit_BT_001");


//$serverName = 'GRRSERVER\GRRSQLSERVER';

$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBit_BT_001");
}
else {
   

$serverName="TEST-PC\SIXBITDBSERVER";
$connectionInfo = array( "Database"=>"SixBit_BT_001");

}
        
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}


/* Retrieve and display the results of the query. */


/*
$select_list="select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Sales.SaleDate > '2013-11-29' AND Shipments.TrackingNumber='' AND Orders.StatusID='100000'";
*/




$result = sqlsrv_query($conn,$select_list,array());
if (!$result) {
    die('Query failed.');
}




//while($rek_list=sqlsrv_fetch_array($result,SQLSRV_FETCH_BOTH))
    //    echo $rek_list[0];
        
        
        
        
        
        
        
        //$result_list=mysql_query($select_list)or die(mysql_error());
       // $num_list_row= sqlsrv_num_rows($result);
       // echo $num_list_row;
        $i=-1;
        $state=0;
       // for($i=0;$i<$num_list_row;$i++)
        while($rek_list=sqlsrv_fetch_array($result))
        {
          //echo "</br>";  
         //echo $i;
        $i++;
       // echo $rek_list[0];
        
        //echo "<form action='manifest_rep_print.php' method='POST'";   
        $stock_nr=swap_back($rek_list[2]);
        
        
        $check_sql="SELECT * FROM six_barcode WHERE stock_number='$stock_nr'";
        
        $result_my = mysql_query($check_sql);
         $rek_ch=mysql_fetch_array($result_my);
         
        if($rek_ch[6]==$stock_nr)
        {
             $state=12;
        }
      //  echo $rek_ch[6].$stock_nr;
    echo "<table><tr><td>".($i+1).".</td><td> for: <b>";
        echo $rek_list[7]." ".$rek_list[8];
        echo "</b></td><td>item: <b>";
        echo $rek_list[1];
        echo "</b>  ";
        if($state==1)
            echo "Sold on Ebay";
        echo " </td><td> specified by barcode : <b>";
        echo $rek_list[2];
        echo "</b></td><td>  <b>";
        //print(intval($rek_list['sum']));
        echo "</b></td></tr>";
        echo "<tr></tr><tr></tr><tr></BR><td colspan='4'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add.php' method='POST'>";
        
 //       $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
    //    $site_ref_num=$rek_list['site_ref_number'];
        $item_id=$rek_list[0];
        $buyer_id=$rek_list[3];
//echo "ssd";
        echo "<input type='hidden' name='item_id' value='".$item_id."'>";
        echo "<input type='hidden' name='buyer_id' value='".$buyer_id."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        echo "<input type='Submit' name='ten_cat' value='E-Bay Shipment'>";
        
        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='4'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add.php' method='POST'>";
        
   //     $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
  //      $site_ref_num=$rek_list['site_ref_number'];
  //      $site_id=$rek_list['site_id'];        
//echo "ssd"; 
//$item_id=$rek_list[0];
       //$item_id=$rek_list[0];
        //$buyer_id=$rek_list[3];
        echo "<input type='hidden' name='item_id' value='".$item_id."'>";
        echo "<input type='hidden' name='buyer_id' value='".$buyer_id."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        echo "<input type='Submit' name='tv_cat' value='Customer Collection'>";
        
        echo "</form></td></tr>";
        
        $state=0;
        echo "</table>";
        
        }
        echo " </p>";
    }
   
    
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td>
</table>


    
    

</BODY>
</HTML>