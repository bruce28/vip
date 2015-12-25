<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header_mysql.php';
include 'functions.php';
include 'header.php';
$DEBUG;
//$generate_new_number=0;

include 'header_valid.php';
include 'functions/waste_sell_fn.php';


//Activate or deactivate quantity selling module

$ACTIVE_QUANTITY_SELL=0;

//let's go for default date
//$batch_date= date("Y-m-d");
//echo $batch_date;

//function for blockin form

//local functions for weee sale _2

//new way of showing list of items

//function that reads weee extension_cat

function weee_ext_categories($id_ext)
{
    $sql_weee_ext="SELECT * FROM weee_extension WHERE idweee_extension='$id_ext'";
    $result=mysql_query($sql_weee_ext) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['idweee_extension']; 
}

function weee_ext_name($id_ext)
{
    $sql_weee_ext="SELECT * FROM weee_extension WHERE idweee_extension='$id_ext'";
    $result=mysql_query($sql_weee_ext) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['name_ext']; 
}


function show_qtty_waste($ref_sell,$ext_weee)
{
    $sum_counter=0;
    $sql_qtty="SELECT * FROM waste_barcode INNER JOIN transaction_waste ON transaction_waste.waste_barcode_idwaste_barcode=waste_barcode.idwaste_barcode WHERE ref_sell_number='$ref_sell' AND type_item_cnv='$ext_weee'";
    $result=mysql_query($sql_qtty) or die(mysql_error());
    while($rek=mysql_fetch_array($result))
    {
     if(!empty($rek['idwaste_barcode']))
         $sum_counter+=1;
    }
    return $sum_counter;
}

function show_barcode_waste($ref_sell,$ext_weee)
{
    $sum_counter=0;
    //$sql_qtty="SELECT * FROM waste_quantity, transaction_waste WHERE transaction_waste.ref_sell_number=waste_quantity.idtransaction_waste AND ref_sell_number='$ref_sell' AND name_cat_cnv='$ext_weee'";
    $sql_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat_cnv='$ext_weee'";
    $result=mysql_query($sql_qtty) or die(mysql_error());
    while($rek=mysql_fetch_array($result))
    {
     if(!empty($rek['qtty']))
         $sum_counter+=$rek['qtty'];
    }
    return $sum_counter;
}




//end of new showing functions



function get_extension($id_ext)
{
     $sql_item_type="SELECT * FROM weee_extension WHERE idweee_extension='$id_ext' ";
    $result=mysql_query($sql_item_type) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['weee_extension']; 
}

//end of local function for weee sale_2


function check_init_gen($ref_sell)
{
   // echo "<td>sasda". $ref_sell."</td>";
   $select="SELECT * From transaction_waste WHERE ref_sell_number='$ref_sell'";
   $result=mysql_query($select) or die(mysql_error());
  // echo "<td> result ".$result."</td>";
   $rek=mysql_fetch_array($result);
   if(!empty($rek[0])>0)
       return 1;
   else
       return 0;
    
    
}


function get_sub_cat_name($name_cat)
{
   $select="SELECT * FROM sub_cat WHERE id_c='$name_cat'";
   $result=mysql_query($select) or die(mysql_error());
   $rek=mysql_fetch_array($result);
   
   return $rek['conotation'];
}
/*
function get_item_name($item_type)
{
    $sql_item_type="SELECT * FROM item,item_has_cat WHERE item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat AND id_item_cat='$item_type' ";
    $result=mysql_query($sql_item_type) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['name'];
    
}
 * 
 */


function check_cat($id)
{
    $db = connect_dbi();
    $sql ="SELECT * FROM item_has_cat INNER JOIN item ON item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat WHERE active=1 GROUP BY assign_nr ORDER By id_item_cat";
    $result = query_selecti($db,$sql);
   // echo $id;
    while($rek = mysqli_fetch_array($result))
    {
      $sub_cat=$rek['sub_cat'];  
      if($id==$rek['id_item_cat'])
              echo "<option value='".$rek['id_item_cat']."' selected >".$rek['name']." - <b>".get_sub_cat_name($sub_cat)."</b></option>";
      else
      echo "<option value='".$rek['id_item_cat']."'>".$rek['name']." - <b>".get_sub_cat_name($rek['sub_cat'])."</b></option>";               
    }
  //  return $rek['town_name'];
    
}
function check_cat_ext($id)
{
    $db = connect_dbi();
    $sql ="SELECT * FROM weee_extension";
    $result = query_selecti($db,$sql);
   // echo $id;
    while($rek = mysqli_fetch_array($result))
    {
      //$sub_cat=$rek['sub_cat'];  
      if($id==$rek['idweee_extension'])
              echo "<option value='".$rek['idweee_extension']."' selected >".$rek['name_ext']." - <b>".$rek['weee_extension']."</b></option>";
      else
      echo "<option value='".$rek['idweee_extension']."'>".$rek['name_ext']." - <b>".$rek['weee_extension']."</b></option>";               
    }
  //  return $rek['town_name'];
    
}




// ID Buyera
$_SESSION['site_id_s_s'];

function message()
{
if($_GET['MESSG']>0)
{
$message=$_GET['MESSG'];

if($message==1)
$message="Item not in stock. Had been already sold";
if($message==2)
$message="Item Add to Transaction system.";
if($message==3)
$message="Waste Item Added";
//$message="Item";
if($message==4)
$message="We have never had this item in stock";

if($message==5)
$message="Item in stock, but have not yet been tested. Not availible for sales";

if($message==11)
$message="Item sold on Six Bit";

if($_GET['qc'] > 0)
{
    $qtty_bulk=$_GET['qc'];
    if($qtty_bulk==1)
     $message="Added ".$qtty_bulk." random item of ".get_item_name(get_extension ($_GET['item_type']))." category";         
    else
$message="Added ".$qtty_bulk." random items of ".get_item_name(get_extension ($_GET['item_type']))." category";    
}
echo "<div id='message' style='position: relative; width: 80%;marign: auto;border:4px black;'> ";    
echo "<h4> MESSAGE: </h4>".$message;   
echo "</div></BR></BR></BR>";    
}
}

include 'menu_header.php';

//everything perfect until now but user dont work so i add a input user to the function
function show_site($id_user)
{
    $ref_show=$_SESSION['ref_sell_number'];
 connect_db();

// Show SOLD ITEMS by USER in the session
 $sql_select="SELECT * FROM waste_barcode INNER JOIN transaction_waste ON waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode WHERE ref_sell_number='$ref_show' ";

//show transaction started as zero means a fresh transaction that dad
//if($ref_show==0)
//  $sql_select="SELECT * FROM Barcode INNER JOIN Item ON Item.id_item=Barcode.Item_id_item INNER JOIN Barcode_has_Buyer ON Barcode.id_Barcode=Barcode_has_Buyer.Barcode_id_Barcode Where stock_out=1 AND Barcode_has_Buyer.user_2='$id_user' AND ref_sell_number='$ref_show'  ORDER BY date_sold DESC";

$result=query_select($sql_select) or die(mysql_error());
while($rek=mysql_fetch_array($result))
{  
  echo "<tr><td>";
 echo $rek["Barcode_waste"];
  echo "</td><td>";
echo $rek["stock_in"];
echo "</td><td>";  
echo $rek["weight"];
  //echo "sdfsdf";
echo "</td><td>";   
echo $rek["category"];
 echo "</td><td>";
 echo $rek["date_sold"];
 echo "</td><td>";
 echo $rek["type_item"];
 echo "</td><td>";
 echo $rek["brand"];
 echo "</td><td>";
 echo $rek["pn"]; 
 echo "</td><td>";
 echo $rek["ref_sell_number"];
 echo "</td><td>";
 echo "</td><td>";
 echo $id_weee_ext=$rek["type_item_cnv"];
 
 //we pick up also a weee extension name for waste barcode
 $check_weee_extension="SELECT * FROM weee_extension WHERE idweee_extension=$id_weee_ext";
 $result_weee=mysql_query($check_weee_extension);
 $rek_weee=mysql_fetch_array($result_weee);
 
 echo "</td><td>";
 echo "</td><td>";
 echo $rek_weee["name_ext"];
 echo "</td><td>";
 echo "Sold";
    echo "</td></tr>";

  
 } 
  
  
   
}






//IF change site sended by get. Redirect than
/**
 * if($_GET['ref_sell_new']>0 AND isset($_GET['ref_sell_new']))
 * {
 *     $_SESSION['generate_new_number']=0;
 *     $_SESSION['ref_sell_number']=$_GET['ref_sell_new'];
 *     $_SESSION['site_id_s']=$_GET['site_location'];
 *     $show_site=1;
 *     
 * }
 */
if($_GET["change_site"]==1)
{
    //ID BUYER is site_id_s. WHEN change site than id_buyer does not exist
  if(isset($_SESSION['site_id_s_s']))
  unset($_SESSION['site_id_s_s']);  
  $site_location=0;
  $batch_date=0;
  $site_location=0; 
  $show_site=0;
  $site_id=0;  
  unset($_SESSION['ref_sell_number']);
  $_SESSION['generate_new_number']=1;
}
  
//$error_msg;
$show_site=0;

$site_specified=0;
$site_change_req=0;
$site_id;

connect_db();
$query="SELECT * From Buyer WHERE ttl_nr IS NOT NULL ";
//this can be twofold, both distinct inner join or every site place distinctivel from origin tabel
//INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id

$result=query_select($query);

$users=array();
$names=array();
$batch_date=array();

/**
 * if(!isset($_SESSION['ref_sell_number'])AND $_SESSION['ref_sell_number']==0)
 *     {
 *          
 *     }   
 */
if($_GET['site_specified']==1 OR isset($_SESSION['site_id_s_s']))
{
    
    
  ///  echo "site specified";
    $show_site=1;
 ///   echo "Pzrypadek SESJA  ustalona lub zmienna przekazana";
    if($_GET['site_specified']==1 AND !isset($_SESSION['site_id_s_s']))
    {
       // $show_site=1;
       $site_id=$_GET["site_id"];
       $_SESSION['site_id_s_s']=$site_id; 
 ///      echo "Przypadek Zmienna ste przekazana i sesja nie ustalona";
    }
    if($_GET['site_specified']!=1 AND isset($_SESSION['site_id_s_s']))
    {
       //$show_site=1; 
       $site_id=$_SESSION['site_id_s_s'];
  ///     echo "Przypadek Zmienna nie przekazana ale sesja ustalona"; 
    }
    else
    $site_id=$_GET["site_id"];
 ///   echo $_GET["site_id"];
    
    //here is a bug fixed. STEP2 rm
    $site_id=$_SESSION['site_id_s_s'];
    
  ///  echo $_SESSION['site_id_s_s'];
}
else
{
$i=0;
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $users[$i]=$rek["id_Buyer"];    
     $names[$i]=$rek["postcode"];
     $origin[$i]=$rek["id_Buyer"];
     //$batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }
 ///  echo "Nie ustalono site place ani zmienna ani przekazanie";
}


//variables post checking, after checked if eg. barcode exist added locally
global $bar_ex_id;
global $item_ex_id;
global $brand_ex_id;
global $serial_ex_id;

$def=array();

if(isset($_GET['processing'])) {
  echo 'Form successfully submitted.';}
  
  
if($_GET['bar_ex']==1) {
//  echo 'bar exist';
//  echo $_GET['V_BARCODE'];
  $bar_ex_id=$_GET['bar_ex'];
  $BAR_EX=$_GET['V_BARCODE'];
///  echo $BAR_EX;
  
  }
  else
  $BAR_EX=$_GET['V_BARCODE']; // if not exist do not move local id exist and get an empty one
  
  //if not empty item field
if($_GET['s_item']==1)
{
  $item_ex_id=$_GET['s_item'];
  $ITEM_EX=$_GET['V_ITEM'];  
    
}  
  
if($_GET['s_brand']==1)
{
  $brand_ex_id=$_GET['s_brand'];
  $BRAND_EX=$_GET['V_BRAND'];  
    
}    
  
if($_GET['s_serial']==1)
{
  $serial_ex_id=$_GET['s_serial'];
  $SERIAL_EX=$_GET['V_SERIAL'];  
    
}    

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
<?php if($_GET[MESSG] == 2): ?>
   <embed height="50" width="100" src="beep/beep1.mp3" hidden="true">   
        <?php endif ?>    
   <?php if($_GET['qc'] > 0): ?>
   <embed height="50" width="100" src="beep/beep4.mp3" hidden="true">   
        <?php endif ?>  
    
<?php if($_GET[MESSG] == 2): ?>
   <embed height="50" width="100" src="beep/beep1.mp3" hidden="true">   
        <?php endif ?>
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
//echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";
} ?>


<!--

<div id="banner">


<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div></BR></BR>
-->



<div id="all">




<div id="form_stock"> 


<div margin="10px">





<form action="sell_item_pro_waste1.php" method="POST">







<?php

if($show_site==1)
{

    $DEBUG.= "showsite";
   $batch_date=$_GET["batch_date"];
   $site_location=$_GET["site_specified"]; 
  
   
  if(!empty($batch_date)AND !empty($site_location) OR isset($_SESSION["site_id_s_s"]))
{
    $DEBUG.="Nie zalapalo numeru";
     if($_SESSION['generate_new_number']==1)
    {
    ///    echo "generacja numeru";
      $_SESSION['ref_sell_number']=$site_location.$batch_date.rand();
      $_SESSION['generate_new_number']=0;
    ///  echo $_SESSION['ref_sell_number'];
    
    }
     
    $DEBUG.='asassdfsfdsfdsdfsdfsdfsdfsdfsdfsdfsfd';
  connect_db();
  //$query="SELECT * From Origin INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id WHERE batch_date='$batch_date' AND Origin_origin_id='$site_location'";
    $query="SELECT * From Buyer INNER JOIN transaction_waste ON Buyer.id_Buyer=transaction_waste.Buyer_id WHERE id_Buyer ='$site_id'";

   // echo $batch_date.$site_location;
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
  */echo "121";
  if($rek = mysql_fetch_array($result,1))
  {
  $site_specified=1;  
  
  $batch_date=$rek["date_sold"];
  $site_location=$rek["id_Buyer"];
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
  echo "<p style='font-family: Arial Narrow, Arial, sans-serif; font-size:16;'><b>Transaction details:</b></p></BR></BR>";
  
  echo "<table><tr>";
  echo "</BR><td>Transaction Reference Number: </td><td>".$site_ref_number;
  echo "</BR></td></tr><tr><td>Company Name: </td><td>".$comp_name;
  echo "</BR></td></tr><tr><td>Name: </td><td>".$name;
  echo "</BR></td></tr><tr><td>Surname: </td><td>".$surname;
  echo "</BR></td></tr><tr><td>Postal Code: </td><td>".$post_code;
  echo "</BR></td></tr><tr><td>House Number: </td><td>".$house_num;
  echo "</BR></td></tr><tr><td>Street: </td><td>".$street;
  echo "</BR></td></tr><tr><td>town: </td><td>".$town;
   echo "</BR></td></tr><tr><td>T11 premises code</td><td><b>".$rek["ttl_nr"]."</b>";
  echo "</BR></BR></td></tr><tr><td>Transaction in progress: </td><td>"; if($closed==0)echo "YES";
  echo "</td></tr></table>";
  echo "</BR> </BR> <a style='text-decoration: none;
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 10%;
    height:5px;
    color:black;
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse;  '  </BR>";
  //href='sell_item_waste1.php?change_site=1'> Change Transaction </a>
  }
  else
  {
  //$_SESSION['site_id_s']=0;
  if(isset($_SESSION['site_id_s_s']))
  ;
  //unset($_SESSION['site_id_s']);
  }
}  
    
}

else
{
echo "</BR></BR><span style='margin: 10px;'>Customer Adress</span>";

echo '<select name="site_location" size="1">';

for($z=0;$z<=$i;$z++)
{
  echo '<option value="'.$origin[$z].'">'.$names[$z].'</option>';

}
echo '</select>';


echo<<<DATE_F
<span style="margin:10px">Date of transaction</span>

<input type="text "id="" name="batch_date" placeholder="YYYY-MM-DD" value="
DATE_F;

echo date("Y-m-d");    
$batch_date;

echo<<<DATE_F1

"/>


<input type="hidden" name="submitted" value="1" />


<input type='submit' name='Submit' value='Specify' align='right'>

</form>




DATE_F1;
}
?>

















</BR></BR></BR></BR>


<?php $r=1; if(isset($_SESSION['site_id_s_s']) == 1): 
//echo $DEBUG;
message();
if($state_ind==1)
        $select_list.=" WHERE ind='1'";
    
?>

<?php

$ref_sell=$_SESSION['ref_sell_number'];

$customer1="SELECT Item.name, count(*) as quantity From Barcode_has_Buyer
INNER JOIN Buyer ON Barcode_has_Buyer.Buyer_id_Buyer=Buyer.id_Buyer
INNER JOIN Barcode ON Barcode.id_Barcode=Barcode_has_Buyer.Barcode_id_Barcode
INNER JOIN Item ON Item.id_item=Barcode.Item_id_item
WHERE ref_sell_number='$ref_sell' 
GROUP BY Item.name ORDER BY Item.name
";

$customer1="SELECT type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
        . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' GROUP BY type_item ORDER By type_item";

$cust=  mysql_query($customer1);


//secodn prepared query to include waste qtty

$waste_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat=";

/*
echo '<table style="width: 200px;">';

//this code generates item qtty list it must be implemented to include waste quantity
while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
   
   $sum_waste_qtty=0;
   
   echo '<tr>';
   
   
	 echo '<td>'.  get_item_name($rek['type_item']).'</td>';
         $item_type_qtty=$rek['type_item'];
         //a space for fetching items waste qtty and add it to waste barcode
         $waste_qtty_query=$waste_qtty.$item_type_qtty;
         //$waste_qtty.="'";
         $result_waste=mysql_query($waste_qtty_query) or die(mysql_error());
         while($rek_waste=mysql_fetch_array($result_waste))
         {
           $sum_waste_qtty+=$rek_waste['qtty'];
             
         }
         $waste_qtty;
         $waste_bar_qtty=$rek['quantity'];
          $waste_bar_qtty+=$sum_waste_qtty;
         echo '<td>'.$waste_bar_qtty.'</td>';
	 //echo '<td>'.$rek["name"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</tr>';
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
$waste_qtty_sep="SELECT SUM(qtty) as qtty,name_cat FROM waste_quantity,waste_barcode,transaction_waste WHERE waste_barcode.type_item=waste_quantity.name_cat AND transaction_waste.waste_barcode_idwaste_barcode=waste_barcode.Barcode_waste AND waste_quantity.idtransaction_waste='$ref_sell' AND ref_sell_number='$ref_sell'";
$result_sep=mysql_query($waste_qtty_sep) or die(mysql_error());
*/

//turning of old module 1 assignment needed of barcode waste to previous waste quantity may show up
/*
while($rek_sep=mysql_fetch_array($result_sep))
{
    echo '<tr>';
    echo '<td>';
    echo get_item_name($rek_sep['name_cat']);
    echo '</td><td>';
    echo $rek_sep['qtty'];
   echo '</td>';
    echo '</tr>';
    
}

echo '<tr></tr>'; 
echo '</table>';
*/

////Modul function show waste from waste quantity and waste barcode

echo '<table style="width: 200px;">';
//new way of listing items

 for($i=0;$i<30;$i++)
    {
     $sum=0;
     
     $id_ext=weee_ext_categories($i);
   
 // echo "<BR/>";
      $sum=show_qtty_waste($ref_sell, $id_ext); //echo " : "; 
      $sum +=  show_barcode_waste($ref_sell, $id_ext);
    if($sum>0)
    {
        echo '<tr><td>';
        echo weee_ext_name($id_ext);
        echo "</td><td> ";
        echo $sum;
        echo " Unit </td></tr>";
    }
    }

//old way od listing items
//show_concat_waste_swaped($ref_sell);
echo '</table>';

?>
<BR/><BR/>

<table border="1">
<tr><td>Barcode</td><td>Item Type</td><td></td><td></td></tr>
<tr>




<form onsubmit="return ini()" action="sell_item_pro_waste1.php" method="POST">

<td>
    <input type="text "id="code_read_box" name="barcode" value="<?php echo $BAR_EX; ?>" autofocus="" placeholder="Waste barcode"/><?php if(!empty($bar_ex_id)) echo "*"; ?>
</td>

<td>
    <select name="item_type" ><?php check_cat_ext($_GET['item_type']); ?> </select>
</td>


<input type="hidden" name="submitted" value="1" />


<td>

<input type='submit' name='Submit' value='Sell' align='right'></td><td colspan="2"> <input type="checkbox" name="print_out" value="yes" <?php if(isset($_GET['print_out'])) {echo 'checked=""'; $state_ind=1;} ?>  > Remove item </br>  </br>

</td>

</tr>
<tr>
    <td></td><td><input type="text" name="quantity" value="" placeholder="Quantity" <?php if($ACTIVE_QUANTITY_SELL==0) echo 'disabled=""' ?> ><td>
    <td><input type='submit' name='Finish' value='Finish Transaction' align='right' <?php if(check_init_gen($ref_sell)==0) echo 'disabled'; ?> ></td>
<td><input type='submit' name='Cancel' value='Cancel Transaction' align='right'></td>    
</tr>
</form>

</table>

<?php endif ?>

</div>

<!--
<div id="buttons">
<h4> <a href="index.php">Return</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</h4>
</div>
-->


</div>

</div>
 </br></br>
 
 
 <table width='50%' style="padding:9px;  
    border: solid 1px #E5E5E5;  
    outline: 0;  
    font: normal 13px/100% Verdana, Tahoma, sans-serif;  
    width: 50%;  
    background: #FFFFFF url('bg_form.png') left top repeat-x;  
    background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;  
    -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;   
    
    border-collapse:collapse; ">
 
 <?php
echo "<div id='box_right'> <table>";
 show_site($id_user);
echo "</table></div>";
 echo $error_msg;   
 ?>  














































</td>
</tr>
</table>




</BODY>
</HTML>