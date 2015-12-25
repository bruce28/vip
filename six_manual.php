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

$read=0;
$read=$_SESSION['read'];
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

//$connectionInfo = array( "Database"=>"SixBit_BT_001");
if($SIX_WORK==1)
{
 //$serverName="GRRSERVER\TEMPSERVER";
 //change dne on 02 June
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
Addresses.State,Addresses.PostalCode, Addresses.Country
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Orders.ExternalOrderID>270000");
//Sales.SaleDate > '2013-11-29' AND
//Shipments.TrackingNumber='' AND

if (!$result) {
    die('Query failed.');
}
$i=0;
echo "<table border='2'>";
/*
while($row = sqlsrv_fetch_array($result))
{
 $i++;   
 echo "<tr>";
echo "<td>Six Bit: ".$i."</td><td> ".$row[0]."</td><td> ".$row[1]."</td> <td>".$row[2]."</td><td> ".$row[3]."</td><td> ".$row[5]."</td><td> ".$row[6]."</td><td> ".$row[7]."</BR>".$row[8]."</td><td> ".$row[9]."</BR>".$row[10]."</BR> ".$row[11]."</td><td> ".$row[12]."</td><td> ".$row[13]."</td><td> ".$row[14]."</BR> ".$row[15]." </br>";
//echo "date".$row[4];
echo "</tr>";

}
echo "</table>";

*/

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
?>

<?php

if(isset($_POST['Confirm']))
{
     $connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

      
 $sales_num=$_POST['sales_number'];   
 if(isset($_GET['ebay']))
     $sales_num=$_GET['ebay'];
 
 echo $sales_number;
$select="UPDATE six_barcode SET conf='1' Where ebaysales='$sales_num'";
$result=mysql_query($select) or die(mysql_error());
//$rek=mysql_fetch_array($result); 
    
    echo "Sales Confirmed";
    
    
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

    <center><h4>E-bay Sells </h4></center>
    
    </BR>
    </BR>
    </BR>
   
    <div style="margin: 10px;">
    <form action="six_manual.php" method="POST" >
     
       <p>      
           <table><tr><td>
        <label for="site" ></label>              
                      
                      
                      <input type="text" name="sales_number" value="<?php echo $_POST['sales_number']; ?>" placeholder="Ebay ref. numb."><label for="date">Confirm Sale</date>
                    </td><td>  <input type="submit" name="Confirm" value="Confirm Sale" style="margin:15px;
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
            "  <?php if($read==0) echo "disabled"; ?> >
                      
                      
                      </p>
                    </td></tr><tr><td>
                             <!-- <input type="text" name="sales_number" value="<?php //echo $_POST['sales_number']; ?>"> -->
                      <input type="submit" name="Generate" value="List" style=" margin:15px;
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                      <!-- <input type="checkbox" name="print_out" value="yes" <?php //if(isset($_POST['print_out'])) echo 'checked=""'; ?>  >Individual customer<br> -->
    </form>
       </td></tr> </table>
        <style>
          label{
          margin-left: 10px;   
          color: #999999;
          font: normal 13px/100% Verdana, Tahoma, sans-serif;
            }
           </style>
    </div>
    
    
    
    
    <?php
    if(isset($_POST['Generate'])OR isset($_GET['ebay']))
    {
        
        echo '<p style="margin-left: 10px;">';
        echo "</BR><b>Transaction inventory: </b></BR></BR>";
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
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where  Orders.StatusID='100000' AND Orders.ExternalOrderID>270000";
        //Shipments.TrackingNumber='' AND
//Sales.SaleDate > '2013-11-29' AND
        }
        else if(!empty($_POST['date'])) 
        {
            $dd_s=$_POST['date'];
           $select_list="SELECT DISTINCT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id WHERE batch_date='$dd_s'
           GROUP BY town;
         ";            
            
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
         // 2 June
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

$sales=$_POST['sales_number'];


if(isset($_GET['ebay']))
    $sales=$_GET['ebay'];

$select_list="select distinct Items.ItemID, Items.Title, Inventory.SKU, Orders.BuyerID, 
Sales.SaleDate, Orders.StatusID, Shipments.TrackingNumber, Addresses.FirstName, Addresses.LastName,
Addresses.AddressLine1,Addresses.AddressLine2,Addresses.AddressLine3,Addresses.City,
Addresses.State,Addresses.PostalCode, Addresses.Country, Shipments.IsShipped, Sales.QtySold, Orders.ExternalOrderID
from Orders 
left join Shipments on Shipments.OrderID=Orders.OrderID 
left join Sales on Sales.ShipmentID = Shipments.ShipmentID 
INNER JOIN SalesPurchases ON SalesPurchases.SaleID=Sales.SaleID 
INNER JOIN Purchases ON Purchases.PurchaseID = SalesPurchases.PurchaseID  
Inner Join Inventory ON Inventory.InventoryID = Purchases.InventoryID
INNER Join Addresses ON Addresses.AddressID=Shipments.ShippingAddressID
INNER JOIN Items ON Items.ItemID = Inventory.ItemID where Orders.StatusID='100000' AND Orders.ExternalOrderID='$sales' AND Orders.ExternalOrderID>270000";

// Shipments.TrackingNumber='' AND
//Sales.SaleDate > '2013-11-29' AND


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
        
        //not stock number but u_barcode stock_nr
        //HERE we come to a problem while the main reason is stock number comparison, while shall be ebaysales
        
        //Beg
        $check_sql="SELECT * FROM six_barcode WHERE stock_number='$stock_nr'";
        
        //aleternative comparisobn
        
        //asign $rek_list[18] that is ebay ref number
        $ebay_ref=$rek_list[18];
        $check_sql="SELECT * FROM six_barcode WHere ebaysales='$ebay_ref'";
        
        //END 
        $result_my = mysql_query($check_sql);
         $rek_ch=mysql_fetch_array($result_my);
         $num_ro=mysql_num_rows($result_my);
         if($rek_list[17]==$num_ro)
         {
             $read=1;
             $_SESSION['read']=1;
             if($rek_ch[19]==1)
                 unset($_SESSION['read']);
         }
        
        if($rek_ch[6]==$stock_nr)
        {
             $state=12;
        }
      //  echo $rek_ch[6].$stock_nr;
    echo "<table><tr><td>".($i+1).".</td><td> Shipped to: <b>";
        echo $rek_list[7]." ".$rek_list[8];
        echo "</b></td><td>item: <b>";
        echo $rek_list[1];
        echo "</b>  ";
        if($state==1)
            echo "Sold on Ebay";
        echo " </td><td> specified by barcode : <b>";
        echo $rek_list[2];
        echo "</b></td><td>  <b>QTy: ";
        //print(intval($rek_list['sum']));
        echo $rek_list[17];
        echo "</td><td>";
        echo $track=$rek_list[6];
        echo "</td><td>";
        echo $rek_list[18];
        echo "</td><td>";
         echo $num_ro;
        echo "</td><td>";
        echo $rek_list[16];
        echo "</b></td><td> Date sold: <b>";
        echo $rek_list[4]->format('Y-m-d');
        
       // echo date('d-M-Y', strtotime($rek_list[4]));
        echo "</b></td></tr>";
        echo "<tr></tr><tr></tr><tr></BR><td colspan='4'></td><td style='font-size:11px'></BR>";
        //10 cat 1.
        echo "<form action='six_add_mn.php' method='POST'>";
        
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
        echo $rek_list[17];
        echo $num_ro;
        //this statement block the selling button
        if($rek_list[17]==$num_ro)
        {
            echo "<input type='Submit' name='ten_cat' value='E-Bay Shipment' disabled>";
            echo "Debug".$rek_list[17];
        }
        else
        {
            echo "Debug".$rek_list[17];
            echo "<input type='Submit' name='ten_cat' value='E-Bay Shipment'>";
        }        
//echo $track;
        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='4'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add_mn.php' method='POST'>";
        
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
         if($rek_list[17]==$num_ro)
        echo "<input type='Submit' name='tv_cat' value='Customer Collection' disabled>";
        else
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