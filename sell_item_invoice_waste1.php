<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header_mysql.php';
include 'functions.php';
include 'header.php';

include 'header_valid.php';
//$generate_new_number=0;


$sum_rec=array(); //array to store values of recalculated sum weight 
$ind_rec=array(); //aray to keep separate price for each item
$qtty_rec=array();
$sum_price=0;
$price_invoice_set=0;

if(isset($_POST['Recalculate']))
{
    echo "Recalculated";
    //global $sum_rec;
    global $price_invoice_set;
    for($name_cat=0;$name_cat<62;$name_cat++)
    {
        global $sum_price;       
        $string_qtty_rec='qtty_rec'.$name_cat;
        $string_price_rec='price'.$name_cat;
        
        $qtty_rec[$name_cat]=$_POST[$string_qtty_rec];
        $ind_rec[$name_cat]=$_POST[$string_price_rec];
        $sum_rec[$name_cat]=$qtty_rec[$name_cat]*$ind_rec[$name_cat];
        $sum_price+=$sum_rec[$name_cat];
    }
    
    if(isset($_POST['sum_set'])) ;
     $price_invoice_set=$_POST['sum_set'];
    
}



include 'menu_header.php';

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

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}

function show_concat_waste($ref_sell,$price_call)
{
    
    mysql_connect('localhost','root','krasnal') or die(mysql_error());
    mysql_select_db('dbs3') or die(mysql_error());
  $customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
        . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' GROUP BY type_item ORDER By type_item";



//echo $ref_sell;
$reuse=array();

$cust=add_db($customer1);
$waste_barcode=array();
$waste_barcode_weight=array();
//echo "bf fetch";
while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //echo " in fetch ";
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
  $index=$rek['type_item'];
 // echo " <BR /> ";
   $waste_barcode[$index]+=$rek['quantity'];
   $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
   //echo '<tr>';
	//echo '<td>'.get_item_name($rek['type_item']).'</td>';
	// echo '<td>'.$rek["quantity"].'</td>';
	// echo '<td>'.$rek["category"].'</td>';
	//   echo '<td>'.$rek["pn"].'.</td>';
        //     	echo '<td>1</td>';
	//echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	//echo '</tr>';
         
         $cat=$rek['category'];
        $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
$waste_barcode[3];
$waste_barcode_weight[3];


echo '<form action="sell_item_invoice_waste1.php?invoice=1&ref_sell='.$ref_sell.'" method="POST">';
$weee_reused_waste_qtty=array();  
global $sum_rec;
global $qtty_rec;
global $ind_rec;
    for($name_cat=0;$name_cat<62;$name_cat++)
    {
        if(($qtty=get_waste_qtty($ref_sell, $name_cat))>0)
        {
        echo "<tr>";
        echo "<td>";
   echo $sum_qtty_recalculate=$qtty+$waste_barcode[$name_cat]; 
        echo " UNIT </td>";
        echo "<td>";
        echo get_item_name($name_cat);
        echo "</td>";
       // echo '<td>';
       // echo get_weight_qtty($ref_sell, $name_cat)+$waste_barcode_weight[$name_cat];
    //    echo "</td>";
    //    echo "<td>".$name_cat."</td>";
        echo "<td>".$sum_qtty_recalculate." x </td>";
       // echo $sum_rec[$name_cat];
        echo "<input type='hidden' name='qtty_rec".$name_cat."' value='".$sum_qtty_recalculate."'>";
        echo "<td><input type='text' name='price".$name_cat."' value='".$ind_rec[$name_cat]."' placeholder='Individual price'></td>";
        if($sum_rec[$name_cat]>0)
            echo "<td> <b>Price Set:</b> <BR/>".$sum_rec[$name_cat]." Pounds</td>";
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
                 $qtty_indiv=$rek["quantity"];
             $index=$rek['type_item'];
              $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
 // echo " <BR /> ";
           //$waste_barcode[$index]+=$rek['quantity'];
          // $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
           echo '<tr>';
              echo '<td>'.$rek["quantity"].' Unit</td>';
	    echo '<td>'.get_item_name($rek['type_item']).'</td>';
	 //   echo '<td>'.$waste_barcode_weight[$index]
         //   .'</td>';
	 //  echo '<td>'.$rek["category"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
             echo "<td>".$qtty_indiv." x </td>";
           echo "<input type='hidden' name='qtty_rec".$name_cat."' value='".$qtty_indiv."'>";
        echo "<td><input type='text' name='price".$name_cat."' value='".$ind_rec[$name_cat]."' placeholder='Individual price'></td>";
         if($sum_rec[$name_cat]>0)
            echo "<td> <b>Price Set:</b> <BR/>".$sum_rec[$name_cat]." Pounds</td>";
	 echo '</tr>';
         
       //  $cat=$rek['category'];
      //  $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
     }
  
	  //$tab[$rek["id_test"]]+=1;
}  
    
    
}
  

    }
    global $sum_price;
    global $price_invoice_set;   
    if($sum_price>0)
    {
     
    echo "<tr></tr>";
    echo "<tr><td colspan='4'></td><td> <b>Total value: ".$sum_price."</b></td></tr>";
    echo "<input type='hidden' name='sum_set' value='".$sum_price."'";
    $price_invoice_set=$sum_price;
    }
    echo '<tr><input type="Submit" name="Recalculate" value="Recalculate"></tr>';
    echo '<BR />';
    echo '</form>';
}







$ref_sell=$_GET['ref_sell'];

echo $ref_sell;


if($_POST['Submit1'])
{
    redirect($index,0);  
}



connect_db();
?>

<HTML>
<HEAD>
<link rel="stylesheet" href="layout.css " type="text/css" />
<link rel="stylesheet" href="form1.css " type="text/css" />

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />


<script type="text/javascript" src="csshorizontalmenu.js" > 



</script>


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
<tr><td>Login</td><td><input type="text" name="login"></td>
<td>Password</td><td><input type="password" name="pass"></td>
</tr><tr>
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
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>




<div id="all">




<div id="form_stock"> 


<div margin="10px">









<h3>Customer Details are:</h3>
<form action="invoice_print_waste1.php?ref_sell=<?php echo $ref_sell ?>  " method="POST">


<?php

if($_GET['invoice']==1)
{

    //echo "showsite";
   $batch_date=$_GET["batch_date"];
   $site_location=$_GET["site_specified"]; 
  
   
  if($_GET['ref_sell']>0 OR isset($_GET['ref_sell']))
{
    $r=1;
    //echo "Referance Transaction Number";
    $ref_sell=$_GET['ref_sell'];
    //echo 'asassdfsfdsfdsdfsdfsdfsdfsdfsdfsdfsfd';
   // echo $ref_sell;
  connect_db();
  //$query="SELECT * From Origin INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id WHERE batch_date='$batch_date' AND Origin_origin_id='$site_location'";
    $query="SELECT * From Buyer, transaction_waste Where Buyer.id_Buyer=transaction_waste.buyer_id AND transaction_waste.ref_sell_number ='$ref_sell'";

    echo $batch_date.$site_location;
   $result=query_select($query) or die(mysql_error());

//$users=array();
//$names=array();
//$batch_date=array();

$i=0;

/*
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $users[$i]=$rek["post_code"];    
     $names[$i]=$rek["town"];
     $batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }
  */
  if($rek = mysql_fetch_array($result,1))
  {
  $site_specified=1;  
  
  $batch_date=$rek["date_sold"];
  $id_buyer=$rek["id_Buyer"];
  $comp_name=$rek["company_name"];
  $name=$rek["name"];
  $surname=$rek["surname"];
  $post_code=$rek["postcode"];
  $house_num=$rek["house_number"];
  $street=$rek["address"];
  $town=$rek["town"];
  $site_ref_number=$_SESSION['ref_sell_number'];
  $closed=$rek["closed"];
  
  //$na=$rek["name"];
  //echo "A transaction Specified as:</BR></BR>";
  
  echo "<table><tr>";
  echo "</BR><td>Transaction Reference Number: </td><td>".$ref_sell;
  echo "</BR></td></tr><tr><td>Company Name: </td><td>".$comp_name;
  echo "</BR></td></tr><tr><td>Name: </td><td>".$name;
  echo "</BR></td></tr><tr><td>Surname: </td><td>".$surname;
  echo "</BR></td></tr><tr><td>Postal Code: </td><td>".$post_code;
  echo "</BR></td></tr><tr><td>House Number: </td><td>".$house_num;
  echo "</BR></td></tr><tr><td>Street: </td><td>".$street;
  echo "</BR></td></tr><tr><td>town: </td><td>".$town;
  echo "</BR></td></tr><tr><td>T11 premises code: </td><td><b>".$rek['ttl_nr'];
  echo "</b></BR></BR></td></tr><tr><td>Transaction in progress: </td><td>"; if($closed==0)echo "Finished";
  echo "</td></tr></table>";
  //echo "</BR> </BR> <a href='sell_item?change_site=1'> </a>";
  }
  else
  {
  //$_SESSION['site_id_s']=0;
  if(isset($_SESSION['site_id_s']))
  ;
  //unset($_SESSION['site_id_s']);
  }
}  
    
}

else
{
echo "Specify Customer Adress";

echo '<select name="site_location" size="1">';

for($z=0;$z<=$i;$z++)
{
  echo '<option value="'.$origin[$z].'">'.$names[$z].'</option>';

}
echo '</select>';


echo<<<DATE_F
Date of transaction

<input type="text "id="" name="batch_date" value="
DATE_F;

$batch_date;

echo<<<DATE_F1

"/>


<input type="hidden" name="submitted" value="1" />


<input type='submit' name='Submit' value='Specify' align='right'>

</form>




DATE_F1;
}
?>



<?php
//$ref_sell=$_SESSION['ref_sell_number'];

$customer1="SELECT Item.name, count(*) as quantity From Barcode_has_Buyer
INNER JOIN Buyer ON Barcode_has_Buyer.Buyer_id_Buyer=Buyer.id_Buyer
INNER JOIN Barcode ON Barcode.id_Barcode=Barcode_has_Buyer.Barcode_id_Barcode
INNER JOIN Item ON Item.id_item=Barcode.Item_id_item
WHERE ref_sell_number='$ref_sell' 
GROUP BY Item.name ORDER BY Item.name
";

$cust=  mysql_query($customer1);
echo '<BR><table>';

while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
    
   echo '<tr>';
	 echo '<td>'.$rek["name"].'</td>';
	 echo '<td>'.$rek["quantity"].' Unit</td>';
          echo '<td>Price per Unit</td>';
	 //echo '<td>'.$rek["name"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</tr>';
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
 
echo '</table><BR>';
?>


<?php

?>












<?php $r; if( $r == 1): ?>


<table border="1">
<tr><td>Total Value</td><td></td><td></td><td></td></tr>
<tr>




<form onsubmit="return ini()" action="invoice_print_waste1.php?ref_sell=<?php echo $ref_sell; ?>"  method="POST">

<td>
<input type="text" id="code_read_box" name="price" value="<?php if($price_invoice_set>0) echo $price_invoice_set?>" placeholder="Price"/>
</td>


<input type="hidden" name="submitted" value="1" />
<input type="hidden" name="id_Buyer" value="" />

<td align='right'>

<input type='submit' name='Submit' value='Print Invoice' align='right'></br>

</td>

</tr>
</form>

</table>
<BR/>   
<form action="index.php" METHOD="POST">
    <input type='submit' name='Submit1' value='Finish' align='right'>
</form>
    
<?php endif ?>

</div>




</div>

</div>
 </br></br>
 
 
 <?php
echo "<div id='box_right'> <table>";

echo "</table></div>";
 echo $error_msg;
 
 echo "<center>";
 echo '<h3>Sold<h3>';
 echo '<table style="width:40%;">';
show_concat_waste($ref_sell);

echo '</table>';
echo "</center>";
?>  














































</td>
</tr>
</table>




</BODY>
</HTML>