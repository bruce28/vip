<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header_mysql.php';
include 'functions.php';
include 'header.php';

//$generate_new_number=0;


include 'menu_header.php';

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
<form action="invoice_print.php?ref_sell=<?php echo $ref_sell ?>  " method="POST">


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
    $query="SELECT * From Buyer INNER JOIN Barcode_has_Buyer ON Buyer.id_Buyer=Barcode_has_Buyer.Buyer_id_Buyer WHERE ref_sell_number ='$ref_sell'";

    echo $batch_date.$site_location;
   $result=query_select($query);

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
  echo "</BR></BR></td></tr><tr><td>Transaction in progress: </td><td>"; if($closed==0)echo "Finished";
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















<?php $r; if( $r == 1): ?>


<table border="1">
<tr><td>Total Value</td><td></td><td></td><td></td></tr>
<tr>




<form onsubmit="return ini()" action="invoice_print.php?ref_sell=<?php echo $ref_sell; ?>"  method="POST">

<td>
<input type="text" id="code_read_box" name="price" value="" />
</td>


<input type="hidden" name="submitted" value="1" />
<input type="hidden" name="id_Buyer" value="" />

<td align='right'>

<input type='submit' name='Submit' value='Print Invoice' align='right'></br>

</td>

</tr>
</form>

<form action="index.php" METHOD="POST">
    <input type='submit' name='Submit1' value='Finish' align='right'>
</form>

</table>

<?php endif ?>

</div>




</div>

</div>
 </br></br>
 
 
 <?php
echo "<div id='box_right'> <table>";

echo "</table></div>";
 echo $error_msg;   
 ?>  














































</td>
</tr>
</table>




</BODY>
</HTML>