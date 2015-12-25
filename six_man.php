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
include 'functions_ebay.php';



//flag fro clear barcode
$CLEAR_SALES=1;

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


/* Free statement and connection resources. */

?>

<?php


if(isset($_POST['small_bar']))
{
    //here we need to provide an interface to detect barcode number in set so what is not empty is reall one processed
    $small_bar=$_POST['dbs0'];
    print("ADDING a cross reference to ");
    print $small_bar; 
    
    $barcode=$small_bar;
    
    $item_id=$_POST['item_id'];
    $buyer_id=$_POST['buyer_id'];
    
    echo $item_id;
    echo $buyer_id;
    
    
    
    $added=insert_six_barcode_sells($item_id, $buyer_id,$barcode, $conn);
    
    //here we pick up the error messages
    $id_barcode=get_barcode_id($barcode);   //This means if barcode is actually tested or not
    $TESTED=check_barcode_test($id_barcode);
    if($TESTED==1)
        echo "tested";
    else 
        echo "Not tested";
    
    if($added==1)
    {
        echo $added;
        $MESG="Item ".$barcode." Sold.";
    }
    else if($added==0)
        $MESG="Item failed to be sold.";
    
    
    if(empty($id_barcode))
    {
       // $MESG="This is not valid barcode format";
        $MESG=" This item needs further attention. Please contact supervisor.";
        //if not there than check if used valid barcode format
        if($val=validate_barcode($small_bar))
        $MESG=" This item is not valid barcode format ";
    }
    else     
     if($TESTED==1)
       ; 
    else 
        $MESG .= " This item needs further attention. Please contact supervisor.";
    
    if(check_barcode_ebay($barcode)==0 AND $added==0)
        $MESG.=" Item already sold on ebay";
}




sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);
















//if confirm posted than do this. Maybe here we fill put the query for adding to six barcode
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
    <?php
/*
echo '<script type="text/javascript">';
echo "document.getElementByClassName('au_sub')[0].click();";
 //echo   "document.getElementById('dateForm').submit();"; // SUBMIT FORM
echo "</script>";    
*/
 ?> 
 
    

    
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

$autofocus="autofocus=''";
$AUTO_FOCUS=1; //0 no 1 ebay reference 2 dbs
$AUTO_FOCUS=$_SESSION['AUTO_FOCUS'];

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
        <form name="dataForm" id="dataForm" <?php if(isset($_POST['small_bar'])) echo 'id="dateForm"';?> action="six_man.php" method="POST" >
     
           
           <table>
               
               
               <tr>
                      
                      
                      
                   
               
               
                     
                      
                      <td>
                      <input type="text" name="sales_number" value="<?php if(empty($_POST['sales_number'])) echo $_POST['sales_ref'];
                        //else echo $_POST['sales_number']; ?>" placeholder="Ebay ref. numb." <?php if($AUTO_FOCUS==0)echo $autofocus; ?>    style=" margin:15px;
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;"  ><label for="date">E-bay Reference Sales Number</date>
                    </td>
                      
              <!--        <td>
                 
                      
                      
     <input type="text" name="barcode" value="<?php echo $_POST['barcode']; ?>" placeholder="DBS Barcode." <?php if($AUTO_FOCUS==2)echo $autofocus; ?> ><label for="date">Uniqu item</date>
                    </td>-->
                      </tr><tr><td>
                             <!-- <input type="text" name="sales_number" value="<?php //echo $_POST['sales_number']; ?>"> -->
                              <input type="submit" name="Generate" value="Sell" style=" margin:15px;
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                
                              <script type="text/javascript">
                                  //document.dataForm.Generate.click();
                                  </script>
                              
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
      //  echo "</BR><b>Transaction inventory: </b></BR></BR>";
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
           if($AUTO_FOCUS==0)
               $_SESSION['AUTO_FOCUS']+=1;
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
        
        echo "<form action='six_man.php' method='POST'>";
        
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
         $sales_ref=$_POST['sales_number'];
        
        echo "<input type='hidden' name='sales_ref' value='".$sales_ref."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        //echo $rek_list[17];
        //echo $num_ro;
        //this statement block the selling button
        if($rek_list[17]==$num_ro)
        {
           echo "<input type='Submit' name='sold' value='Sold' disabled>";
           // echo "Debug".$rek_list[17];
        }
        else
        {
            $items=$rek_list[17];
            //echo "Debug".$rek_list[17];
           
            $sold=check_sold_transaction($barcode, $item_id);
            //IS A BUG SOME RECORD DOESNT SHOW
           for($i=0;$i<$items-$sold;$i++)
           {
            if($AUTO_FOCUS==1)
            {
              //here we check if one sold by un barcode and stock number if yes than decrement showing list by one and show list sold intead  
                
          echo "<input type='text' name='dbs".$i."' value='' placeholder='Item sold..".$rek_list[2]."' autofocus=''>";
          echo "<input type='Submit' name='small_bar' value='Sell'></BR>";     
          
            } 
          
            }        
         
         }        
//echo $track;
        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='4'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_man.php' method='POST'>";
        
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
         //if($rek_list[17]==$num_ro)
       
        echo "</form></td></tr>";
        
        $state=0;
        echo "</table>";
        
        }
        echo " </p>";
    }
   
    
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   <?php 
   if(!empty($MESG))
   show_message($MESG);
    
   ?>
    
    
    
    
    
    
    
    
    
</td>
</table>
   <?php
   
 /* 
  echo '<script type="text/javascript">';
 echo   "document.getElementById('dateForm').submit();"; // SUBMIT FORM
echo "</script>";    
*/
    ?> 
    
     

</BODY>
</HTML>