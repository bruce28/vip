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
include 'functions.php';
include 'header_mysql.php';
$site_id;

connect_db();

$time=0; //time for redirect

//here there are two functions to fetch invoice data

$FLAG_LAST_INV_SIZE=10;


function space(){
   echo '<BR />'; 
    
}


//this two functions plays a role to show up last invoices limited by a flag size
function get_last_invoice($invoice_nr)
{
  $sql_invoice="SELECT * FROM `invoice` WHERE main_pri!=0 ORDER BY inv_id DESC LIMIT ";
  $sql_invoice.=$invoice_nr;
  $result=mysql_query($sql_invoice);
  while($rek=mysql_fetch_array($result))
  {
     echo $rek[0];
     echo '<BR />';
  }
          
    
    
}

function get_last_wee_invoice($invoice_nr)
{
    
    $sql_invoice="SELECT * FROM `invoice_waste` Where main_pri!=0 ORDER BY idinvoice_waste DESC LIMIT ";
    $sql_invoice.=$invoice_nr ;
  $result=mysql_query($sql_invoice);
  while($rek=mysql_fetch_array($result))
  {
     echo $rek[0];
     echo '<BR />';
  }
         
}

//here this functions are doubled. They ll be listing last invoices by a particular buyer

function get_last_invoice_buyer($invoice_nr,$buyer_id)
{
  $sql_invoice="SELECT * FROM `invoice` INNER JOIN barcode_has_buyer ON barcode_has_buyer.Invoice_inv_id=invoice.inv_id
WHERE main_pri!=0 AND Buyer_id_Buyer=".$buyer_id." GROUP BY Invoice_inv_id, Buyer_id_Buyer ORDER BY inv_id DESC LIMIT ";
  $sql_invoice.=$invoice_nr;
  $result=mysql_query($sql_invoice);
  while($rek=mysql_fetch_array($result))
  {
     echo $rek[0];
     echo '<BR />';
  }
          
    
    
}

function get_last_wee_invoice_buyer($invoice_nr,$buyer_id)
{
    
    $sql_invoice="SELECT idinvoice_waste,buyer_id FROM `invoice_waste`INNER JOIN transaction_waste ON transaction_waste.invoice_waste_idinvoice_waste=invoice_waste.idinvoice_waste
 Where main_pri!=0 AND buyer_id=".$buyer_id." GROUP BY idinvoice_waste ORDER BY idinvoice_waste DESC LIMIT ";
    $sql_invoice.=$invoice_nr ;
  $result=mysql_query($sql_invoice);
  while($rek=mysql_fetch_array($result))
  {
     echo $rek[0];
     echo '<BR />';
  }
         
}

//this function will search up for a customer details by postpode or surname

//returns buyer id and 
function search_buyer($description)
{
    $sql_buyer="SELECT id_Buyer From buyer WHERE surname='".$description."'";
    $result=mysql_query($sql_buyer);
    $rek=mysql_fetch_array($result);
    if(!empty($rek[0]))
    return $rek[0];
    else
    {
        $sql_buyer="SELECT id_Buyer From buyer WHERE postcode='".$description."'";
    $result=mysql_query($sql_buyer);
    $rek=mysql_fetch_array($result); 
        return $rek[0];
        
    }    
        
    
}



?>

<HTML>
<HEAD>
<link rel="stylesheet" href="layout.css " type="text/css" />
<link rel="stylesheet" href="form1.css " type="text/css" />

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">

<!--

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css" />
-->


<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
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

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php 
////if(isset($_GET['test'])) 
//{
//echo "Item with Barcode <B>".isset($_GET['test'])."</B> added to the System ";} ?>

</BR>
</BR>

<form action="print_invoice_s_buyer.php" method="post">
<input type="text" name="buyer_id" value="<?php echo $_POST['buyer_id']; ?>" placeholder="Postcode or surname..">
<input type="submit" name="Submit_customer" value="Find customer">
</form>

<form action="print_invoice_s_buyer.php" method="post">
    <input type="text" name="inv_id" value="" placeholder="invoice number..."/>

<input type="submit" autofocus="" name="Submit" value="Search Invoice" />



</form>


<?php
//Here we put a code to show 3 recent transaction both invoice and invoice waste
$invoice_nr=$FLAG_LAST_INV_SIZE;
space();
echo "<b>Last Weee Invoices</b>";
space();
space();
if(isset($_POST['Submit_customer']))
{
    $description=$_POST['buyer_id'];
    $id_buyer=search_buyer($description);
    get_last_invoice_buyer($invoice_nr,$id_buyer);

}
else
get_last_invoice($invoice_nr);
space();
space();
echo "<b>Last Wee Waste Invoices</b>";
space();
space();
if(isset($_POST['Submit_customer']))
{
    $description=$_POST['buyer_id'];
    $id_buyer=search_buyer($description);
    get_last_wee_invoice_buyer($invoice_nr,$id_buyer);

    
    
}
    else
get_last_wee_invoice($invoice_nr);
space();

?>

<?php

if(isset($_POST['inv_id']))
{
    
  if($_POST['inv_id']>0)
  {  //$inv=9;
    $inv=$_POST['inv_id'];                         //here by seting a static constraint we block two invoice domains that vere faulty
  $query="SELECT * FROM Barcode_has_Buyer WHERE Invoice_inv_id='$inv' AND Invoice_inv_id!='1506' AND Invoice_inv_id!='1507'";
  $res=mysql_query($query) or die(mysql_error());
  if($res)
  {
  $rek=mysql_fetch_array($res);
  $ref_sell=$rek["ref_sell_number"];
  echo $ref_sell;
   if($rek["ref_sell_number"]>0 AND !empty($rek["ref_sell_number"]))
       redirect("invoice_print.php?ref_sell=$ref_sell&show=2",$time);
   else //here we try if not found invoice to search for invoice waste
   {
       //we will add a code to check over 19 invoice waste1
       if($inv>19)
       {
            $query="SELECT * FROM transaction_waste,invoice_waste WHERE invoice_waste_idinvoice_waste='$inv' AND invoice_waste.idinvoice_waste=transaction_waste.invoice_waste_idinvoice_waste AND main_pri>0";
       $res=mysql_query($query) or die(mysql_error());
       if($res)
       {
          $rek=mysql_fetch_array($res);
          $ref_sell=$rek['ref_sell_number'];
         if($rek['ref_sell_number']>0 AND !empty($rek["ref_sell_number"]))  
         redirect("invoice_print_waste1.php?ref_sell=$ref_sell&show=2",$time);
       }
       }    
       else
       {
       $query="SELECT * FROM transaction_waste,invoice_waste WHERE invoice_waste_idinvoice_waste='$inv' AND invoice_waste.idinvoice_waste=transaction_waste.invoice_waste_idinvoice_waste AND main_pri>0";
       $res=mysql_query($query) or die(mysql_error());
       if($res)
       {
          $rek=mysql_fetch_array($res);
          $ref_sell=$rek['ref_sell_number'];
         if($rek['ref_sell_number']>0 AND !empty($rek["ref_sell_number"]))  
         redirect("invoice_print_waste.php?ref_sell=$ref_sell&show=2",$time);
       }
       }
   }
  
  }
  else 
   ;  
}
}
?>

</td>

</tr>
</table>




</BODY>
</HTML>