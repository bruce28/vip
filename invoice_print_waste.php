<?php
session_start();
include 'header_valid.php';

function get_cat($name_cat)
{
     $select_weight="SELECT * FROM item_has_cat WHERE id_item_cat='$name_cat'";
   $result_weight=mysql_query($select_weight) or die(mysql_error());
   $rek_wei=mysql_fetch_array($result_weight);
    return $weight=$rek_wei['cat'];
    
    
}

function get_weight_qtty($ref_sell,$name_cat)
{
   
   $waste_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat=";
   //$result_waste=mysql_query($waste_qtty);
   
   
   $select_weight="SELECT * FROM item_has_cat WHERE id_item_cat='$name_cat'";
   $result_weight=mysql_query($select_weight) or die(mysql_error());
   $rek_wei=mysql_fetch_array($result_weight);
   $weight=$rek_wei['weight'];
   $sum_waste_qtty=0;
 
   $item_type_qtty=$name_cat;
         
   $waste_qtty_query=$waste_qtty.$item_type_qtty;
         
   $result_waste=mysql_query($waste_qtty_query) or die(mysql_error());
   while($rek_waste=mysql_fetch_array($result_waste))
         {
           $sum_waste_qtty+=$rek_waste['qtty'];
             
         }
         $waste_qtty;
         $waste_bar_qtty=$rek['quantity'];
          return $waste_bar_qtty+=$sum_waste_qtty*$weight;
    
    
    

}


function get_waste_qtty($ref_sell,$name_cat)
{
   
   $waste_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat=";
   //$result_waste=mysql_query($waste_qtty);
   
   $sum_waste_qtty=0;
 
   $item_type_qtty=$name_cat;
         
   $waste_qtty_query=$waste_qtty.$item_type_qtty;
         
   $result_waste=mysql_query($waste_qtty_query) or die(mysql_error());
   while($rek_waste=mysql_fetch_array($result_waste))
         {
           $sum_waste_qtty+=$rek_waste['qtty'];
             
         }
         $waste_qtty;
         $waste_bar_qtty=$rek['quantity'];
          return $waste_bar_qtty+=$sum_waste_qtty;
    
    
    

}

function get_item_name($item_type)
{
    $sql_item_type="SELECT * FROM item,item_has_cat WHERE item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat AND id_item_cat='$item_type' ";
    $result=mysql_query($sql_item_type) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['name'];
    
}




function dup_row($count)
{
 if($count="0")
   return 0;    
 else
 {
     
 }   
}
function test_string($rek)
{
if($rek=='1')
  $result="Yes";
 else if($rek=='2')
  $result="N/A";
 else 
     $result="No";
	
	return $result ;
}

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}

$barcode=$_POST['price'];



$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');


if($_GET['ref_sell']>0)
{
   
$ref_sell=$_GET['ref_sell'];
 //echo "get". $ref_sell;
$sql="SELECT * FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell'";
         
        

$result2=add_db($sql);

$customer="SELECT * From transaction_waste, Buyer WHERE
transaction_waste.buyer_id=Buyer.id_Buyer AND ref_sell_number='$ref_sell '
";

$cust=add_db($customer);


}





?>
<HTML>
<HEAD>
<script>
function printpage()
  {
  window.print()
  }
</script>

<link rel="stylesheet" href="layout_invoice.css " type="text/css">


<link rel="stylesheet" href="form_cat.css " type="text/css">

</HEAD>
<BODY>

<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>

<?php 

$take_inv_from_ref1="SELECT * FROM transaction_waste WHERE ref_sell_number='$ref_sell'";
$res_bar1=mysql_query($take_inv_from_ref1);
$res_bar1=mysql_fetch_array($res_bar1);
$inv_id=$res_bar1['invoice_waste_idinvoice_waste'];
$inv_date=$res_bar1['date_sold'];
?>




<center><h1>INVOICE</h1></center>

<div id="tabel_wrap_out"  style="table-layout: fixed;"></BR></BR></BR>	
<h3><table id="ii" style="width: auto; margin-right:10px;"><tr><td>Registered Office:</td></tr><tr><td>273-275 Sheepcot Lane</td></tr><tr><td>Garston</td>                       </tr>
<tr><td>Watford</td> </tr><tr><td>WD25 7DL</td>  </tr><tr><td>Registered in England no. 6238804</td></tr><tr><td>VAT number 852 374420</td>                       </tr>

</table></h3>

<h1> WEEE WASTE INVOICE # <?php echo $inv_id; ?></h1>
<h2>Date - <?php //echo date("j, n, Y"); 

$inv_date = date("d-m-Y", strtotime($inv_date));
echo $inv_date;   ?></h2>
<h2>Customer Details:</h2>
<table width="55%" style="width: 33%;">

<?php

$rek_c=mysql_fetch_array($cust);
 echo "<tr><td>Transaction Reference</td><td><b>".$rek_c["ref_sell_number"].$rek_c["Buyer_id_Buyer"]."</b></td></tr>";
  echo "<tr><td>Company</td><td>".$rek_c["company_name"]." </td></tr>";
   echo "<tr><td>Name</td><td>".$rek_c["name"]." </td></tr>";
    echo "<tr><td>Surname</td><td>".$rek_c["surname"]." </td></tr>";
     echo "<tr><td>Address</td><td>".$rek_c["address"]."</BR>".$rek_c["town"]."</BR>".$rek_c["postcode"]."</td></tr>";
     echo "<tr><td>T11 premises code</td><td><b>".$rek_c["ttl_nr"]."</b></td></tr></BR>";
?>
</table>
</BR></BR>


<h3>SUMMARY:</h3>
<!--<table style="width: 110px;"><tr><td>Item type</td><td>Quantity sold</td></tr>-->
<?php 


$customer1="SELECT Item.name, count(*) as quantity From Barcode_has_Buyer
INNER JOIN Buyer ON Barcode_has_Buyer.Buyer_id_Buyer=Buyer.id_Buyer
INNER JOIN Barcode ON Barcode.id_Barcode=Barcode_has_Buyer.Barcode_id_Barcode
INNER JOIN Item ON Item.id_item=Barcode.Item_id_item
WHERE ref_sell_number='$ref_sell' 
GROUP BY Item.name ORDER BY Item.name
";

$customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
        . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' GROUP BY type_item ORDER By type_item";




$reuse=array();

$cust=add_db($customer1);
$waste_barcode=array();
$waste_barcode_weight=array();
while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
  $index=$rek['type_item'];
 // echo " <BR /> ";
   $waste_barcode[$index]+=$rek['quantity'];
   $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
   //echo '<tr>';
	// echo '<td>'.get_item_name($rek['type_item']).'</td>';
	// echo '<td>'.$rek["quantity"].'</td>';
	// echo '<td>'.$rek["category"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	// echo '</tr>';
         
         $cat=$rek['category'];
        $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
$waste_barcode[3];
$waste_barcode_weight[3];
 ?>
<!--</table>
</BR></BR>-->

<!--
<h3>Items Bought:</h3>
</BR></BR>
<table id="tabel_out2" border="1" >


<tr><td>NO.</td><td>Item Barcode</td><td>WEEE Category</td><td>Standard Weight</td><td>Item Type</td><td></td><td>Quantity</td></tr>
-->
    <?php

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
$i=0;
while($rek = mysql_fetch_array($result2,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
   $id_bar=$rek['id_Barcode'];
    $sql_test="SELECT * FROM test WHERE Barcode_id_Barcode=$id_bar";
    $result=mysql_query($sql_test);
    
  // echo '<b><tr><td>'.$i.'</td><td>'.$rek["Barcode_waste"].'</td>'; 
	// echo '<td>'.$rek["category"].'</td>';
	// echo '<td>'.$rek["weight"].'</td>';
	// echo '<td>'.get_item_name($rek["type_item"]).'</td>';
	//   echo '<td>'.$rek["pn"].'.</td>';
         //     	echo '<td>1</td></b>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	// echo '</tr>';
     //}
         
         while($rek_test=mysql_fetch_array($result,MYSQL_BOTH))
         {
 //  echo '<tr><i><td colspan="2">Test NR:'.$rek_test['id_test'].'</td><td>Reinstallation:'.test_string($rek_test["Reinstallation_id_reinst"]).'</td>'; 
//	 echo '<td>Formatted:'.test_string($rek_test["Formatted_id_form"]).'</td>';
   //      echo '<td>PAT:'.test_string($rek_test["Pat_id_pat"]).'</td>';
//	 echo '<td>Cleaning:'.test_string($rek_test["Cleaning_id_clean"]).'</td>';
//	 echo '<td>Functionality:'.test_string($rek_test["Functional_id_fun"]).'</td>';
	//   echo '<td>Fuse Fitted:'.test_string($rek_test["Fuse_id_fuse"]).'.</td>';
      //        	echo '<td>RDY:'.$rek_test['Ready'].'</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
//	 echo '</i></tr>';      
         }
        
         /*
          while($rek_test=mysql_fetch_array($result,MYSQL_BOTH))
         {
   echo '<tr><i><td colspan=2>Test NR:'.$rek_test['id_test'].'</td><td  colspan=5> REI: '.test_string($rek_test["Reinstallation_id_reinst"]).' '; 
	 echo '    FRM: '.test_string($rek_test["Formatted_id_form"]).'';
         echo '    PAT: '.test_string($rek_test["Pat_id_pat"]).'';
	 echo '    CLN: '.test_string($rek_test["Cleaning_id_clean"]).'';
	 echo '    FUN: '.test_string($rek_test["Functional_id_fun"]).'';
	   echo '  FUSE: '.test_string($rek_test["Fuse_id_fuse"]).'';
              	echo '   RDY: '.$rek_test['Ready'].'</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</i></tr>';      
         }
         */
         echo "<tr></tr>";
	  //$tab[$rek["id_test"]]+=1;
           
          
}














?>


<!--</table>
<BR/><BR/>-->
<h3>Item breakdown</h3>


<table>

    <?php
    $weee_reused_waste_qtty=array();    
    for($name_cat=0;$name_cat<62;$name_cat++)
    {
        if(($qtty=get_waste_qtty($ref_sell, $name_cat))>0)
        {
        echo "<tr>";
        echo "<td>";
   echo $qtty+$waste_barcode[$name_cat]; 
        echo " UNIT </td>";
        echo "<td>";
        echo get_item_name($name_cat);
        echo "</td>";
        echo '<td>';
        echo get_weight_qtty($ref_sell, $name_cat)+$waste_barcode_weight[$name_cat];
        echo "</td>";
        echo "<td>".$name_cat."</td>";
        echo  "</tr>"; 
        $sum_qtty=  get_weight_qtty($ref_sell, $name_cat);+$waste_barcode[$name_cat];
          $cat=get_cat($name_cat);
         $weee_reused_waste_qtty[$cat]+=get_weight_qtty($ref_sell, $name_cat);
         
        
        }
        else {
            $customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
             . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' AND type_item='$name_cat' GROUP BY type_item ORDER By type_item";
            
            $cust=add_db($customer1);
            while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { 
             $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
           
             if($rek['quantity']>0)
             {    
             $index=$rek['type_item'];
              $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
 // echo " <BR /> ";
           //$waste_barcode[$index]+=$rek['quantity'];
          // $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
           echo '<tr>';
              echo '<td>'.$rek["quantity"].' Unit</td>';
	    echo '<td>'.get_item_name($rek['type_item']).'</td>';
	    echo '<td>'.$waste_barcode_weight[$index]
            .'</td>';
	   echo '<td>'.$rek["category"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</tr>';
         
       //  $cat=$rek['category'];
      //  $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
     }
  
	  //$tab[$rek["id_test"]]+=1;
}
            
            
        }
    }       
            
     for($i=0;$i<62;$i++)
    //echo $weee_reused_waste_qtty[$i];
            ?>
    
    
</table>

<BR/><BR/>

<h3>Weight by category</h3>

<table>
    
    
    <?php
    $i=0;
    $select="SELECT * FROM Category WHERE id<12";
    $result=mysql_query($select);
    
    
    
    while($rek=mysql_fetch_array($result))
    {
    //for($i=0;$i<11;$i++)
    $i++;
    $sum_weight_category+=$reuse[$i]+$weee_reused_waste_qtty[$i];
    if($reuse[$i]==0 AND $weee_reused_waste_qtty[$i]==0)
          echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> Nil </td>";
      else
        echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> ".($weee_reused_waste_qtty[$i]+$reuse[$i])." </td>";
       
     
 
       
       echo "</tr>";
    
    } 
    echo "<tr></tr>";
    echo "<tr><td></td><td><b>Total weight: ".$sum_weight_category." kgs</b></td></tr>";
    ?>
    
</table>


<?php

$price=$_POST['price'];
//$vat=($price *20)/100;
//$a_vat=(double)1.2;
$net=((double)$price/(double)(1.2));
$vat=$price-$net;

$net=round($net,2);
$vat=round($vat,2);

$take_inv_from_ref="SELECT * FROM transaction_waste WHERE ref_sell_number='$ref_sell'";
$res_bar=mysql_query($take_inv_from_ref);
$res_bar=mysql_fetch_array($res_bar);
$inv_id=$res_bar['invoice_waste_idinvoice_waste'];

//$inv_id
if(isset($_POST['price'])AND ($_POST['price'])>0)
{
$update="UPDATE invoice_waste SET main_pri='$price', vat_pri='$vat', net_pri=$net WHERE idinvoice_waste='$inv_id'";
mysql_query($update)or die(mysql_error());
}

$sql_inv="SELECT * FROM Invoice_waste WHERE idinvoice_waste='$inv_id'";
$res_inv=mysql_query($sql_inv)or die(mysql_error());
$inv_res=mysql_fetch_array($res_inv);
$main=$inv_res['main_pri'];
$vat=$inv_res['vat_pri'];
$net=$inv_res['net_pri'];

?>

<p>
<h3>Total Price</h3> <?php echo $_POST['main']; ?> 
</br>
Subtotal: <?php echo $net; ?>

</br>
VAT: <?php echo $vat; ?>
</br>
Total: <?php echo $main; ?>


</p>
</div> 

<!--<center><h2>ALL EEE(Electrical and Electronic Equipment) Items listed in </br>this invoice have passed a PAT (Portable Appliances Test) and a basic functionality check.</BR></BR>
All items are sold with 30 day warranty starting from the invoice date which is stated above.
</h2>
</center>-->

<?php echo "Invoice ID: ".$inv_res["idinvoice_waste"]?>
  
  
<div id="buttons_out" style="border: aqua;"> 
  <h4>
  

<?php if($_GET['show']!=2): ?>  
 <p class="submit">  
      <a href="sell_item_invoice_waste.php?invoice=1&ref_sell=<?php echo $ref_sell; ?>"> <button class="submit">Return</button> </a> 
      <input type="button" value="Print Invoice" onclick="printpage()">
      
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->
    </p>  
<?php endif ?>

<?php if($_GET['show']==2): ?>  
 <p class="submit">  
      <a href="print_invoice_s_buyer.php?invoice=1&ref_sell=<?php echo $ref_sell; ?>"> <button class="submit">Return</button> </a> 
      <input type="button" value="Print Invoice" onclick="printpage()">
      
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->
    </p>  
<?php endif ?>

</h4>       
</div>

<br><BR>
<?php
//<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>
</BODY>
</HTML>