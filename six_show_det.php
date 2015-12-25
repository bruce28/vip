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

    <center><h4>Six Bit Transaction details </h4></center>
    
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
        echo '<option value="9">Confirmed </option>';
    }
        echo '</select></span>';
        
      ?>                
        <label for="site" > </label>              
                      <input type="text" name="search" value="" placeholder="Category Specifics...">
                    <!--  <input type="text" name="date" value="" placeholder="YYYY-MM-DD"><label for="date">Recent period sold</date>
                      --></p>
                      <input type="submit" name="Generate" value="Show sold" style="
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                   <!--   <input type="checkbox" name="print_out" value="yes" <?php //if(isset($_POST['print_out'])) {echo 'checked=""'; $state_ind=1;} ?>  >Individual customer<br> -->
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
    if(isset($_POST['tv_cat']))
    {
        $ebay_ref_num=$_POST['ebay_ref_number'];
        echo '<p style="margin-left: 10px;">';
        echo "</br>Ebay Transaction number: ".$ebay_ref_num.".</br> Ebay Tracking Number: ";
        // Searching ond output results module
        
        $select_tracking="SELECT tracking_num FROM six_barcode WHERE ebaysales='$ebay_ref_num'";
        $result_tracking=mysql_query($select_tracking);
        $rek_tracking=mysql_fetch_array($result_tracking);
       // echo $rek_tracking[0];
        
        
        
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

$u_barcode=$_POST['u_barcode'];
$ebay_ref_num=$_POST['ebay_ref_number'];

//echo $u_barcode;


 $select_list_ms="select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country, Orders.ExternalOrderID
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Orders.ExternalOrderID='$ebay_ref_num'";


$stmt = sqlsrv_query( $conn, $select_list_ms);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

/* Retrieve and display the results of the query. */
while($row = sqlsrv_fetch_array($stmt))
{ //if($row[16]==$ebay_ref_num)
echo $row[6]."</br></br>";
}

$select_list="SELECT * FROM six_barcode WHERE ebaysales='$ebay_ref_num'";






$result = mysql_query($select_list);
if (!$result) {
    die('Query failed.');
}
//else
   // echo $result;




//while($rek_list=sqlsrv_fetch_array($result,SQLSRV_FETCH_BOTH))
    //    echo $rek_list[0];
        
        
        
        
        
        
        
        //$result_list=mysql_query($select_list)or die(mysql_error());
       // $num_list_row= sqlsrv_num_rows($result);
       // echo $num_list_row;
        $i=-1;
       // for($i=0;$i<$num_list_row;$i++)
        
        
        
        $sql_origin="SELECT id_Barcode, Site_site_id,Item_id_item, Barcode,Barcode.date as bar_date,pn,brand,Item.name as item,
    site_id,site_ref_number,batch_date, Source_source_id, 
    Origin.company_name as company_name_s, Origin.name as name_s, Origin.surname as surname_s,
    Origin.post_code as post_code_s, Origin.town as town_s
FROM Barcode
INNER JOIN Item ON Barcode.Item_id_item = Item.id_item
INNER JOIN Site ON Site.site_id = Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id = Site.Origin_origin_id
where Barcode='$u_barcode'";
        
        
        while($rek_list=mysql_fetch_array($result, MYSQL_BOTH))
        {
          //echo "</br>";  
         //echo $i;
        $i++;
       // echo $rek_list[0];
        
        //echo "<form action='manifest_rep_print.php' method='POST'";   
        
    
    echo "<table><tr><td>Sales Number: ".($i+1).".</td><td> Unique barcode: <b>";
        echo $rek_list[0]." ".$rek_list[1];
        echo "</b></td><td>includes in set <b>";
        echo $rek_list[6];
        echo "</b></td><td> Ebay ID: <b>";
        echo $rek_list[2];
        echo "</td><td>";
        echo $rek_list[20];
        echo "</b></td><td>  <b> Shipped to: ";
        //print(intval($rek_list['sum']));
        echo $rek_list[9]." ".$rek_list[10];
        echo "</b><td> Shipment Address <b>".
                //$rek_list[11].
                //." ".$rek_list[12]." ".$rek_list[13]." ".$rek_list[14].
                " ".$rek_list[16];
        echo "</b></td></tr>";
        echo "<tr></tr><tr></tr><tr></BR><td colspan='8'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add.php' method='POST'>";
        
 //       $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
    //    $site_ref_num=$rek_list['site_ref_number'];
        $item_id=$rek_list[4];
        $buyer_id=$rek_list[5];
        $u_barcode=$rek_list[0];
//echo "ssd";
        echo "<input type='hidden' name='item_id' value='".$item_id."'>";
        echo "<input type='hidden' name='buyer_id' value='".$buyer_id."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        //echo "<input type='Submit' name='ten_cat' value='E-Bay Shipment'>";
        
        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='8'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add.php' method='POST'";
        
   //     $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
  //      $site_ref_num=$rek_list['site_ref_number'];
  //      $site_id=$rek_list['site_id'];        
//echo "ssd";
        echo "<input type='hidden' name='site_id' value='".$site_id."'>";
        echo "<input type='hidden' name='site_ref_number' value='".$site_ref_num."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        echo "<input type='Submit' name='tv_cat' value='Full Route' disabled>";
        //echo "<input type='Submit' name='tv_cat' value='Route'></span>";
        echo "</form></td></tr><tr><td> <b>Stock-in item:</b></BR></BR>";
        
              $sql_origin="SELECT id_Barcode, Site_site_id,Item_id_item, Barcode,Barcode.date as bar_date,pn,brand,Item.name as item,
    site_id,site_ref_number,batch_date, Source_source_id, 
    Origin.company_name as company_name_s, Origin.name as name_s, Origin.surname as surname_s,
    Origin.post_code as post_code_s, Origin.town as town_s
FROM Barcode
INNER JOIN Item ON Barcode.Item_id_item = Item.id_item
INNER JOIN Site ON Site.site_id = Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id = Site.Origin_origin_id
where Barcode='$u_barcode'";
        $res_ori=mysql_query($sql_origin);
        $rek_ori=mysql_fetch_array($res_ori);
        echo "Premises code: <b>";
        echo $rek_ori[12];
        echo "</b></BR>Stock-in Barcode: <b>";
        echo $rek_ori[3];
        echo "</b></BR>Item Model Number: <b>";
         echo $rek_ori[5];
         echo "</b></BR>Brand: <b>";
          echo $rek_ori[6];
          echo "</b></BR> Item type: <b>";
           echo $rek_ori[7];
           echo "</b></BR>Site ID: ";
           
             echo $rek_ori[8];
             echo "</BR>Site Reference: ";
          echo $rek_ori[9];
          echo "</BR> Collection Date: <b>";
           echo $rek_ori[10];
echo "</b></BR>Source Code: <b>";           
             echo $rek_ori[11];
echo "</b></BR>";
             echo $rek_ori[12];
           echo "</BR> Origin Name: ";
             echo $rek_ori[13];
        echo "</BR>Origin Surname: ";
         echo $rek_ori[14];
echo "</BR>Postal Code: ";
             echo $rek_ori[15];
           echo "</BR>Origin town: ";
             echo $rek_ori[16];
        echo "</BR>";
             echo "</td></tr></table>";
        
       
        
        }
        echo " </p>";
    }
   
   
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td>
</table>


    
    

</BODY>
</HTML>