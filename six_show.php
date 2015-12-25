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
$state_ind=0;

?>


<?php
/* Specify the server and connection string attributes. */
//$serverName = "(local)";

function date_normalizer($d)
{ 
    if($d instanceof DateTime){ return $d->getTimestamp(); 
    
} else 
{ 
    return strtotime($d); 
    
} }
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

    <center><h4>SIX BIT Cross-reference Sales </h4></center>
    
    </BR>
    </BR>
    </BR>
   
    <div style="margin: 10px;">
    <form action="six_show.php" method="POST" >
      <p><select name="site" size="1">
 <?php
    for($z=0;$z<1;$z++)
    {
          echo '<option value="0"> Default </option>';
        echo '<option value="1">Unique Barcode </option>';
        echo '<option value="2">Postal Code </option>';
        echo '<option value="3">EbayID </option>';
        echo '<option value="4">Ebay Sales Record </option>';
        echo '<option value="5">Tracking Number </option>';
        echo '<option value="6">Parceler </option>';
        echo '<option value="7">Stock Number </option>';
        echo '<option value="8">Date Sold </option>';
        echo '<option value="9">Date Disposed </option>';
    }
        echo '</select></span>';
        
      ?>                
        <label for="site" > </label>              
                      <input type="text" name="search" value="" placeholder="Category Specifics..." style="margin:15px;">
                      <input type="text" name="date" value="" placeholder="YYYY-MM-DD" style="margin:15px;" disabled><label for="date">Recent period sold</date>
                      </p>
                      <input type="submit" name="Generate" value="Show sold" style="
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                      <input type="checkbox" name="print_out" value="yes" <?php if(isset($_POST['print_out'])) {echo 'checked=""'; $state_ind=1;} ?>  >Individual customer<br>
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Shipments.TrackingNumber='' AND Orders.StatusID='100000'";
// Sales.SaleDate > '2013-11-29' AND
        }
        else if(!empty($_POST['date'])) 
        {
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Shipments.TrackingNumber='' AND Orders.StatusID='100000' AND Sales.SaleDate='$dd_s'";
                    
            
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
        $select_list="SELECT DISTINCT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id WHERE origin_id='$dd_t' AND batch_date='$dd_s' 
           GROUP BY town;
         ";
        }
        
        
        
        
//$serverName="TEST-PC\SIXBITDBSERVER";

//$connectionInfo = array( "Database"=>"SixBit_BT_001");

        
        if($SIX_WORK==1)
        {
         //$serverName="GRRSERVER\TEMPSERVER";
//$serverName="MRLCPWORK\MRLCPSQLSERVER";
$serverName="MRLCPWORK\SQLTRIALSERVER";

$serverName="SQLSERVER\GRR";

$connectionInfo = array("UID" => "lukas", "PWD" => "lukas", "Database"=>"SixBitServer");
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


/* Retrieve and display the results of the query. */


$select_list="SELECT * FROM six_barcode";


if(isset($_POST['search'])AND isset($_POST['site']))
{
    $search=$_POST['search'];
    $date_ship=$_POST['date'];
    $filter=$_POST['site'];
    
    //date conversion to mysql
    
    //$timestamp = strtotime($date_ship);
    //$date_ship=date("Y-m-d H:i:s", $timestamp);
    
    //$date = DateTime::createFromFormat('Y-m-d H:i:s', $date_ship.' 00:00:00');
//$date_ship = $date->format('Y-m-d H:i:s');
    
    
    $select_list="SELECT * FROM six_barcode";
    
    if($state_ind==1)
        $select_list.=" WHERE ind='1'";
    
    if($filter==1)
        $select_list.=" WHERE u_barcode='".$search."'";
   
    if($filter==2)
        $select_list.=" WHERE postalcode='".$search."'";
    
     if($filter==3)
        $select_list.=" WHERE ebayid='".$search."'";
     
     if($filter==4)
        $select_list.=" WHERE ebaysales='".$search."'";
     
    if($filter==5)
        $select_list.=" WHERE tracking_num='".$search."'";
    
    if($filter==6)
        $select_list.=" WHERE parceler='".$search."'";
    
    if($filter==7)
        $select_list.=" WHERE stock_number='".$search."'";
   
     if($filter==8)
        $select_list.=" WHERE date_ship='".$date_ship."'";
   
    
    if($filter==9)
        $select_list.=" WHERE date_disposed='".$search."'";
    
    
}    



$result = mysql_query($select_list);
if (!$result) {
    die('Query failed.');
}




//while($rek_list=sqlsrv_fetch_array($result,SQLSRV_FETCH_BOTH))
    //    echo $rek_list[0];
        
        
        
        
        
        
        
        //$result_list=mysql_query($select_list)or die(mysql_error());
       // $num_list_row= sqlsrv_num_rows($result);
       // echo $num_list_row;
        $i=-1;
       // for($i=0;$i<$num_list_row;$i++)
        echo "</BR></BR></BR>";
        
        

        
        
        while($rek_list=mysql_fetch_array($result, MYSQL_BOTH))
        {
          //echo "</br>";  
         //echo $i;
        $i++;
       // echo $rek_list[0];
        
        //echo "<form action='manifest_rep_print.php' method='POST'";   
        
    
    echo "<table style='table-layout: fixed;'><tr><td>Sales Number: ".($i+1).".</td><td> Unique barcode: <b>";
        echo $rek_list[0]." ".$rek_list[1];
        echo "</b></td><td>includes in set <b>";
        echo $rek_list[6];
        echo "</b></td><td> Ebay ID: <b>";
        echo $rek_list[2];
        echo "</td><td style='width:240px;' > Ebay Sales Record: <b>";
        echo $rek_list[20];
        echo " </b> </td><td style='width:240px;'>  <b> Shipped to: ";
        //print(intval($rek_list['sum']));
        echo $rek_list[9]." ".$rek_list[10];
      
        echo "</b></td></tr>";
        echo "<tr></tr><tr></tr><tr></BR><td colspan='8'></td><td style='font-size:11px'>";
        //10 cat 1.
      //  echo "<form action='six_add.php' method='POST'>";
        
 //       $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
    //    $site_ref_num=$rek_list['site_ref_number'];
        $item_id=$rek_list[4];
        $buyer_id=$rek_list[5];
//echo "ssd";
        //echo "<input type='hidden' name='item_id' value='".$item_id."'>";
       // echo "<input type='hidden' name='buyer_id' value='".$buyer_id."'>";
       // echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        //echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        //echo "<input type='Submit' name='ten_cat' value='E-Bay Shipment'>";
        
//        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='8'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_show_det.php' method='POST'>";
        
   //     $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
  //      $site_ref_num=$rek_list['site_ref_number'];
  //      $site_id=$rek_list['site_id'];        
//echo "ssd";
        $u_barcode=$rek_list[0];
        $ebay_ref_num=$rek_list[20];
        //echo $u_barcode;
        //echo $ebay_ref_num;
        echo "<input type='hidden' name='u_barcode' value='".$u_barcode."'>";
        echo "<input type='hidden' name='ebay_ref_number' value='".$ebay_ref_num."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        echo "<input type='Submit' name='tv_cat' value='Check details'>";
        //echo "<input type='Submit' name='tv_cat' value='Route'></span>";
        echo "</form></td></tr>";
        
         
        echo "</table>";
        
        }
        echo " </p>";
    }
   
   
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td>
</table>


    
    

</BODY>
</HTML>