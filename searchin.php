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


$METER_READING_FL=1;
?>


<?php

//we write a function draw_dash
function draw($meter)
{
    if(empty($meter))
    {
        return "-";
    }
    else
    {
       return $meter;  
    }
}


/* Specify the server and connection string attributes. */
//$serverName = "(local)";

function test_string($rek)
{
if($rek=='2')
{
   $result="N/A";
   return $result;    
}
if($rek=='1')
  $result="Yes";
 else
  $result="No";
	
	return $result ;
}

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
   <!-- <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
-->
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
  <!--  <script src="dist/js/bootstrap.min.js"></script>
-->

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

    <center><h4>Inventory Search </h4></center>
    
    </BR>
    </BR>
    </BR>
   
    <div style="margin: 10px;">
    <form action="searchin.php" method="POST" >
      <p><select name="site" size="1">
 <?php
    for($z=0;$z<1;$z++)
    {
          echo '<option value="0"> Unique Barcode </option>';
        echo '<option value="1"> Buyer </option>';
        
    }
        echo '</select></span>';
        
      ?>                
        <label for="site" > </label>              
                      <input type="text" name="search" value="" placeholder="Search..." style="margin:15px;">
                      <!-- <input type="text" name="date" value="" placeholder="YYYY-MM-DD" style="margin:15px;"><label for="date">Recent period sold</date>
                      -->
                      </p>
                      <input type="submit" name="Generate" value="Search" style="
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                     <!-- <input type="checkbox" name="print_out" value="yes" <?php if(isset($_POST['print_out'])) {echo 'checked=""'; $state_ind=1;} ?>  >Individual customer<br>
    
                     -->
                     </form>
        <style>
          label{
          margin-left: 10px;   
          color: #999999;
          font: normal 13px/100% Verdana, Tahoma, sans-serif;
            }
           </style>
    </div>
    
    
    
    
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
    
    
    <?php
    if(isset($_POST['Generate']))
    {
        
        echo '<p style="margin-left: 10px;">';
        //echo "Six Bit Sales";
        // Searching ond output results module
        
        if(empty($_POST['date'])AND empty($_POST['site']))
        {    
        $select_list="SELECT * FROM Item'
       //  . ' INNER JOIN Barcode ON Barcode.Item_id_item=Item.id_item'
     //   . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
      //  . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
      //  . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
      //  . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
      //   . ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
          .' ORDER BY Barcode.date';";
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


//$select_list="SELECT * FROM six_barcode";

$select_list='SELECT Barcode FROM Item'
        . ' INNER JOIN Barcode ON Barcode.Item_id_item=Item.id_item ';
        

$select_list='SELECT * FROM Item'
         . ' INNER JOIN Barcode ON Barcode.Item_id_item=Item.id_item'
        . ' INNER JOIN Site ON Site.site_id = Barcode.Site_site_id'
        . ' INNER JOIN Origin On Origin.origin_id= Site.Origin_origin_id';
        //. ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
        // . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
        // . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
        // . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
       //  .' ORDER BY Barcode.date';



/*
$select_list="SELECT id_Barcode, Site_site_id,Item_id_item, Barcode,Barcode.date as bar_date,pn,brand,Item.name as item,
    site_id,site_ref_number,batch_date, Source_source_id, 
    Origin.company_name as company_name_s, Origin.name as name_s, Origin.surname as surname_s,
    Origin.post_code as post_code_s, Origin.town as town_s, Invoice_inv_id, ref_sell_number, Buyer.id_Buyer, Buyer.postcode,
    date_sold,finished
FROM Barcode
INNER JOIN Item ON Barcode.Item_id_item = Item.id_item
INNER JOIN Site ON Site.site_id = Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id = Site.Origin_origin_id";
// INNER JOIN Barcode_has_Buyer ON Barcode_has_Buyer.Barcode_id_Barcode = Barcode.id_Barcode
// INNER JOIN Buyer ON Buyer.id_Buyer = Barcode_has_Buyer.Buyer_id_Buyer where finished=2";

*/




     //   . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
      //  . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
      //  . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
      //  . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
      //   . ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
      //    .' ORDER BY Barcode.date';"

if(isset($_POST['search'])AND isset($_POST['site']))
{
    $search=$_POST['search'];
    $date_ship=$_POST['date'];
    $filter=$_POST['site'];
    
    
    
   // $select_list="SELECT * FROM six_barcode";
    
    if($state_ind==1)
    //    $select_list.=" WHERE ind='1'";
    
    if($filter==1)
  //      $select_list.=" WHERE u_barcode='".$search."'";
   
    if($filter==2)
    //    $select_list.=" WHERE postalcode='".$search."'";
    
;
    if(isset($search)AND !empty($search)AND $filter==0)
        $select_list.=" WHERE Barcode='".$search."'";
    //echo $search.$select_list;
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
        echo "</BR></BR></BR><table style='padding: 150px;'>";
        
        
        if($METER_READING_FL==1)
            echo "<thead><tr><td>NR</td><td>Barcode</td><td>Brand</td><td>Item</td><td>Model Number</td><td>St.</td><td>St.ID</td><td>Date St.</td><td>Date Cl.</td><td>Status</td><td>Tests Rs.</td><td>REI</td><td>FRM</td><td>PAT</td><td>CLN</td><td>FUN</td><td>VIS</td><td>Meter</td><td>Meter 2</td><td>Meter 3</td><td>Tested by:</td><td colspan='5'>Origins</td></tr><tr><td></td></tr></thead>";
        else
        echo "<thead><tr><td>NR</td><td>Barcode</td><td>Brand</td><td>Item</td><td>Model Number</td><td>St.</td><td>St.ID</td><td>Date St.</td><td>Date Cl.</td><td>Status</td><td>Tests Rs.</td><td>REI</td><td>FRM</td><td>PAT</td><td>CLN</td><td>FUN</td><td>VIS</td><td>Tested by:</td><td colspan='5'>Origins</td></tr><tr><td></td></tr></thead>";
  //+++      
        
        ini_set('output_buffering', 'off');
// Turn off PHP output compression
ini_set('zlib.output_compression', false);
         
//Flush (send) the output buffer and turn off output buffering
//ob_end_flush();
while (@ob_end_flush());
         
// Implicitly flush the buffer(s)
ini_set('implicit_flush', true);
ob_implicit_flush(true);
 
//prevent apache from buffering it for deflate/gzip
header("Content-type: text/plain");
header('Cache-Control: no-cache'); // recommended to prevent caching of event
//+++
        
        
     while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { 
   $i++;  
  // if($tab[$rek["id_test"]]<'1')
   //{
   
   //
   
   if($filter==1)
   {
       $sql="SELECT * FROM six_barcode WHERE postalcode='".$search."'";
                        // $res_sql=mysql_query($sql);
			// $rek_sql=mysql_fetch_array($res_sql);
                         
                         if($rek_sql)
                         {
                          // echo "1" ; 
                         }
       
        $sql="SELECT Barcode_id_Barcode, Invoice_inv_id FROM barcode_has_buyer "
                . "INNER JOIN buyer ON barcode_has_buyer.Buyer_id_Buyer=Buyer.id_Buyer WHERE postcode='".$search."'";
                         $res_sql1=mysql_query($sql);
			 while($rek_sql1=mysql_fetch_array($res_sql1)){                  
   
                        if($rek_sql1)
                         {
                            if($rek_sql1[0]==$rek["id_Barcode"])
                            {
                             //echo "2";
                            
                             echo '<tr><td>'.$rek["id_Barcode"].'</td><td>'.$rek["Barcode"].'</td>'; 
	 //echo '<td>'.$rek["Item_id_item"].'</td>';
	 echo '<td>'.$rek["brand"].'</td>';
	 echo '<td>'.$rek[4].'</td>';
	  echo '<td>'.$rek["pn"].'</td>';
	 // echo '<td>'.$rek["serial"].'</td>';
		 echo '<td>'.$rek["stock_in"].'</td>';
		  echo '<td>'.$rek["user_2"].'</td>';
			 echo '<td>'.$rek["date"].'</td><td>';
                         echo $rek["batch_date"].'</td><td>';
                         $sql="SELECT * FROM six_barcode WHERE u_barcode='".$rek['Barcode']."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         if($rek_sql[0]!=NULL) echo "E-bay: ".$rek_sql[20]."</BR> Shipped to ".$rek_sql[9]." ".$rek_sql[10]."</BR>".$rek_sql[16];
                         else
                         {
                             $sql="SELECT * FROM barcode_has_buyer WHERE Barcode_id_Barcode='".$rek['id_Barcode']."' AND finished=2";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         if($rek_sql[0]!=NULL) {
                             echo "Wholesales: Invoice number ".$rek_sql[1];
                           $sql="SELECT * FROM buyer WHERE id_Buyer='".$rek_sql[3]."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         echo " Sold to: ".$rek_sql[2]." ".$rek_sql[3]."</BR>".$rek_sql[7];
                         }
                          else 
                         echo "Not yet sold";
                         }
                         echo "</td><td>";
                         $sql="SELECT * FROM test WHERE Barcode_id_Barcode='".$rek['id_Barcode']."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                          if($rek_sql[9]==1)
                              echo "PASSED test";
                          else if($rek_sql[0]!=0 AND $rek_sql[9]==0)
                           echo "Failed test";
                          else echo "Not tested";
                          echo "</td><td>";
                          echo test_string($rek_sql[1]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[2]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[5]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[6]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[7]);                          
                          echo "</td><td>";
                           echo test_string($rek_sql[8]);                          
                          echo "</td>";
                          if($METER_READING_FL==1)
                          {
                             echo "<td>";
                             echo $rek_sql[13];
                             echo "</td>";
                             echo "<td>";
                             echo $rek_sql[15];
                             echo "</td>";
                             echo "<td>";
                             echo $rek_sql[16];
                             echo "</td>";
                          }
                          echo "<td>";
                           $sql="SELECT * FROM user_2 WHERE id_user='".$rek_sql[3]."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         echo $rek_sql[3]; 
                         echo "</td><td>";
                          echo $rek["company_name"];
                          echo "</td><td>";
                          echo $rek["name"];
                          echo "</td><td>";
                          echo $rek["surname"];
                          echo "</td><td>";
                          echo $rek["post_code"];
                          echo "</td><td>";
                          echo $rek["town"];
                          echo "</td><td>";
                          echo $rek_sql1[1];
	 echo '</td></tr>';
                            } 
                         }
                         }                      
   }
   else {
   //only sold
   echo '<tr><td>'.$rek["id_Barcode"].'</td><td>'.$rek["Barcode"].'</td>'; 
	 //echo '<td>'.$rek["Item_id_item"].'</td>';
	 echo '<td>'.$rek["brand"].'</td>';
	 echo '<td>'.$rek[4].'</td>';
	  echo '<td>'.$rek["pn"].'</td>';
	 // echo '<td>'.$rek["serial"].'</td>';
		 echo '<td>'.$rek["stock_in"].'</td>';
		  echo '<td>'.$rek["user_2"].'</td>';
			 echo '<td>'.$rek["date"].'</td><td>';
                         echo $rek["batch_date"].'</td><td>';
                         $sql="SELECT * FROM six_barcode WHERE u_barcode='".$rek['Barcode']."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         if($rek_sql[0]!=NULL) echo "E-bay: ".$rek_sql[20]."</BR> Shipped to ".$rek_sql[9]." ".$rek_sql[10]."</BR>".$rek_sql[16];
                         else
                         {
                             $sql="SELECT * FROM barcode_has_buyer WHERE Barcode_id_Barcode='".$rek['id_Barcode']."' AND finished=2";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         if($rek_sql[0]!=NULL) {
                             echo "Wholesales: Invoice number ".$rek_sql[1];
                           $sql="SELECT * FROM buyer WHERE id_Buyer='".$rek_sql[3]."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         echo " Sold to: ".$rek_sql[2]." ".$rek_sql[3]."</BR>".$rek_sql[7];
                         }
                          else 
                         echo "Not yet sold";
                         }
                         echo "</td><td>";
                         $sql="SELECT * FROM test WHERE Barcode_id_Barcode='".$rek['id_Barcode']."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                          if($rek_sql[9]==1)
                              echo "PASSED test";
                          else if($rek_sql[0]!=0 AND $rek_sql[9]==0)
                           echo "Failed test";
                          else echo "Not tested";
                          echo "</td><td>";
                          echo test_string($rek_sql[1]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[2]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[5]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[6]);                          
                          echo "</td><td>";
                          echo test_string($rek_sql[7]);                          
                          echo "</td><td>";
                           echo test_string($rek_sql[8]);                          
                          echo "</td>";
                          
                          if($METER_READING_FL==1)
                          {
                             echo "<td>";
                             echo draw($rek_sql[13]);
                             echo "</td>";
                             echo "<td>";
                             echo draw($rek_sql[15]);
                             echo "</td>";
                             echo "<td>";
                             echo draw($rek_sql[16]);
                             echo "</td>";
                          }
                          
                          echo "<td>";
                           $sql="SELECT * FROM user_2 WHERE id_user='".$rek_sql[3]."'";
                         $res_sql=mysql_query($sql);
			 $rek_sql=mysql_fetch_array($res_sql);
                         echo $rek_sql[3]; 
                         echo "</td><td>";
                          echo $rek["company_name"];
                          echo "</td><td>";
                          echo $rek["name"];
                          echo "</td><td>";
                          echo $rek["surname"];
                          echo "</td><td>";
                          echo $rek["post_code"];
                          echo "</td><td>";
                          echo $rek["town"];
	 echo '</td></tr>';
     //}
         ob_flush();
flush();
   }
	//  $tab[$rek["id_test"]]+=1;
   ob_flush();
flush();
}   


ob_flush();
flush();
echo "</table>";
        /*
        
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
         
         */
    }
   
 
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td>
</table>


    
    

</BODY>
</HTML>