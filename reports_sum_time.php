<?php
session_start();
//include 'header.php';
include 'header_mysql.php';
include 'menu_header.php';


$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header.php';
$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 

$site_id;
$sda=0;
connect_db();

$date_in;
$date_out;

//processing form
if(isset($_POST['show']))
{
    //echo "Date set as:".$_POST['date_in'];
    
    $date_in=$_POST['date_in'];
    $date_out=$_POST['date_out'];
    
    
    
    
    
    
}

//Discrepancy report module
function dis_fun()
{
    global $date_in;
    global $date_out;
    global $sda;
     echo "<h3></BR></BR></BR>Totals Collected:<h3></BR></BR>"; 
 $sql_select_site_dis="SELECT SUM(sum_weight) as wei,category.id as cat_idd,sum_weight,category.name_cat as cat_name, SUM(Quantity) as quan FROM site_has_cat INNER JOIN Sub_cat ON sub_cat.id_c=site_has_cat.Sub_cat_id_c INNER JOIN category ON category.id=sub_cat.Category_id"
        . " INNER JOIN site ON site.site_id=site_has_cat.Site_site_id WHERE site.batch_date BETWEEN '$date_in' AND '$date_out' GROUP by cat_idd";
$result_site_dis=query_select($sql_select_site_dis);
echo '<table border="1"><tr><td></td><td>Totals for category [kgs]</td><td>Category</td><td></td><td>Numbers</td></tr>';
while($rek_site_dis= mysql_fetch_array($result_site_dis))
{
   echo '<tr><td>';
   // echo $rek_site_dis['sum_weight'];
   //echo $rek_site_dis['Name_sub'];
   echo '</td><td>';
    echo round($rek_site_dis['wei'],1);
   $total_sum+=$rek_site_dis['wei'];
   //echo $rek_site_dis['Site_site_id'];
   echo '</td><td>';
  echo $rek_site_dis['cat_idd'];
   echo '</td><td>';
  echo $rek_site_dis['cat_name'];
   echo '</td><td>';
    echo $rek_site_dis['quan'];
   echo '</td></tr>'; 
}

$sda=$total_sum;
echo '<tr><td colspan="4"></td><td><b>TOTAL WEIGHT COLLECTED:</b> '.$total_sum.'<td></tr>';
//echo '<tr><td colspan="4"></td><td><b>By this month:</b> '.$total_sum.'<td></tr>';
//echo '<tr><td colspan="4"></td><td><b>By this year:</b> '.$total_sum.'<td></tr>';
echo '</table>';
}

//sold fun

function sold_fun()
{
 echo "<h3></BR></BR></BR>Wholesales:<h3></BR></BR>";   
$sql_select_site_dis="SELECT SUM(sum_weight) as wei,category.id as cat_idd,sum_weight,category.name_cat as cat_name, SUM(Quantity) as quan FROM site_has_cat INNER JOIN Sub_cat ON sub_cat.id_c=site_has_cat.Sub_cat_id_c INNER JOIN category ON category.id=sub_cat.Category_id GROUP by cat_idd";

$sql_select_site_dis="
SELECT *, SUM(weight) as wei,cat AS cat_idd, (SELECT name_cat FROM category WHERE id=cat)as name_cat FROM item
Inner JOIN item_has_cat On item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
LEFT JOIN Barcode On barcode.Item_id_item=item.id_item
RIGHT JOIN test ON test.Barcode_id_Barcode=barcode.id_barcode 
INNER JOIN barcode_has_buyer ON barcode.id_Barcode=barcode_has_buyer.Barcode_id_Barcode
WHERE ready=1
Group by cat";
$result_site_dis=query_select($sql_select_site_dis);
echo '<table border="1"><tr><td></td><td>Totals for category [kgs]</td><td>Category</td><td></td><td></td></tr>';
while($rek_site_dis= mysql_fetch_array($result_site_dis))
{
   echo '<tr><td>';
   // echo $rek_site_dis['sum_weight'];
   //echo $rek_site_dis['Name_sub'];
   echo '</td><td>';
    echo $rek_site_dis['wei'];
   $total_sum+=$rek_site_dis['wei'];
   //echo $rek_site_dis['Site_site_id'];
   echo '</td><td>';
  echo $rek_site_dis['cat_idd'];
   echo '</td><td>';
  echo $rek_site_dis['name_cat'];
   echo '</td><td>';
    echo $rek_site_dis['quan'];
   echo '</td></tr>'; 
}
echo '<tr><td colspan="4"></td><td><b>TOTAL WEIGHT SOLD:</b> '.$total_sum.'<td></tr>';
echo '<tr><td colspan="4"></td><td><b>By this month:</b> '.$total_sum.'<td></tr>';
echo '<tr><td colspan="4"></td><td><b>By this year:</b> '.$total_sum.'<td></tr>';
echo '</table>';
}




function sold_ebay_fun()
{
 echo "<h3></BR></BR></BR>Ebay Sales:<h3></BR></BR>";   
$sql_select_site_dis="SELECT SUM(sum_weight) as wei,category.id as cat_idd,sum_weight,category.name_cat as cat_name, SUM(Quantity) as quan FROM site_has_cat INNER JOIN Sub_cat ON sub_cat.id_c=site_has_cat.Sub_cat_id_c INNER JOIN category ON category.id=sub_cat.Category_id GROUP by cat_idd";

$sql_select_site_dis="
SELECT *, SUM(weight) as wei,cat AS cat_idd, (SELECT name_cat FROM category WHERE id=cat)as name_cat FROM item
Inner JOIN item_has_cat On item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
LEFT JOIN Barcode On barcode.Item_id_item=item.id_item
RIGHT JOIN test ON test.Barcode_id_Barcode=barcode.id_barcode
INNER JOIN six_barcode ON barcode.id_Barcode=six_barcode.barcode_id_Barcode WHERE ready=1
Group by cat";
$result_site_dis=query_select($sql_select_site_dis);
echo '<table border="1"><tr><td></td><td>Totals for category [kgs]</td><td>Category</td><td></td><td></td></tr>';
while($rek_site_dis= mysql_fetch_array($result_site_dis))
{
   echo '<tr><td>';
   // echo $rek_site_dis['sum_weight'];
   //echo $rek_site_dis['Name_sub'];
   echo '</td><td>';
    echo $rek_site_dis['wei'];
   $total_sum+=$rek_site_dis['wei'];
   //echo $rek_site_dis['Site_site_id'];
   echo '</td><td>';
  echo $rek_site_dis['cat_idd'];
   echo '</td><td>';
  echo $rek_site_dis['name_cat'];
   echo '</td><td>';
    echo $rek_site_dis['quan'];
   echo '</td></tr>'; 
}
echo '<tr><td colspan="4"></td><td><b>TOTAL WEIGHT SOLD:</b> '.$total_sum.'<td></tr>';
echo '<tr><td colspan="4"></td><td><b>By this month:</b> '.$total_sum.'<td></tr>';
echo '<tr><td colspan="4"></td><td><b>By this year:</b> '.$total_sum.'<td></tr>';
echo '</table>';
}


function sold_cnt_ebay_fun()
{
 echo "<h3></BR></BR></BR>Country Outlook:<h3></BR></BR>";   
$sql_select_site_dis="SELECT SUM(sum_weight) as wei,category.id as cat_idd,sum_weight,category.name_cat as cat_name, SUM(Quantity) as quan FROM site_has_cat INNER JOIN Sub_cat ON sub_cat.id_c=site_has_cat.Sub_cat_id_c INNER JOIN category ON category.id=sub_cat.Category_id GROUP by cat_idd";

$sql_select_site_dis="
SELECT *, SUM(weight) as wei,cat AS cat_idd, (SELECT name_cat FROM category WHERE id=cat)as name_cat FROM item
Inner JOIN item_has_cat On item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
LEFT JOIN Barcode On barcode.Item_id_item=item.id_item
RIGHT JOIN test ON test.Barcode_id_Barcode=barcode.id_barcode
INNER JOIN six_barcode ON barcode.id_Barcode=six_barcode.barcode_id_Barcode WHERE ready=1
Group by cat";

$sql_select_site_dis="SELECT count(*), SUM(weight) as wei, country,price, SUM(price) as pri,COUNT(country) AS total, CASE WHEN country IN ('Great Britain', 'Ireland') THEN 'UK'
         WHEN Country IN ('Italy','France'
'Albania',
'Andorra',
'Austria',
'Belarus',
'Belgium',
'Bosnia and Herzegovina',
'Bulgaria',
'Croatia',
'Czech Republic',
'Denmark',
'Estonia',
'European Union',
'Faroe Islands',
'Finland',
'France',
'Germany',
'Gibraltar',
'Greece',
'Guernsey',
'Holy See (Vatican City)',
'Hungary',
'Iceland',
'Isle of Man',
'Italy',
'Jan Mayen',
'Jersey',
'Kosovo',
'Latvia',
'Liechtenstein',
'Lithuania',
'Luxembourg',
'Macedonia',
'Malta',
'Moldova',
'Monaco',
'Montenegro',
'Netherlands',
'Norway',
'Poland',
'Portugal',
'Romania',
'San Marino',
'Serbia',
'Slovakia',
'Slovenia',
'Spain',
'Svalbard',
'Sweden',
'Switzerland',
'Ukraine'
) THEN 'Europe'
         ELSE 'World' END AS Region
             FROM six_barcode
INNER JOIN barcode ON barcode.id_Barcode=six_barcode.barcode_id_Barcode 
INNER JOIN item ON barcode.Item_id_item=item.id_item
INNER JOIN item_has_cat ON item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat
GROUP BY country";


$result_site_dis=query_select($sql_select_site_dis);
echo '<table border="1"><tr><td></td><td>Totals for category [kgs]</td><td>Country</td><td></td><td>Total</td><td>Region</td></tr>';
while($rek_site_dis= mysql_fetch_array($result_site_dis))
{
   echo '<tr><td>';
   // echo $rek_site_dis['sum_weight'];
   //echo $rek_site_dis['Name_sub'];
   echo '</td><td>';
    echo $rek_site_dis['wei'];
   $total_sum+=$rek_site_dis['wei'];
   //echo $rek_site_dis['Site_site_id'];
   echo '</td><td>';
  echo $rek_site_dis['country'];
   echo '</td><td>';
  echo $rek_site_dis['pri'];
   echo '</td><td>';
    echo $rek_site_dis['total'];
     echo '</td><td>';
    echo $rek_site_dis['Region'];
   echo '</td></tr>'; 
}
echo '<tr><td colspan="4"></td><td><b>TOTAL WEIGHT SOLD:</b> '.$total_sum.'<td></tr>';
echo '<tr><td colspan="4"></td><td><b>By this month:</b> '.$total_sum.'<td></tr>';
echo '<tr><td colspan="4"></td><td><b>By this year:</b> '.$total_sum.'<td></tr>';
echo '</table>';
}










//$num1_bar=mysql_num_rows($result1);

//end of disrepancy report module


//START OF STOCK report waste calculation and dispalay


function stock_fun()
{
  global $date_in;
  global $date_out;
$sql_select_site_dis="SELECT SUM(weight) as wei,item_has_cat.cat as cat_idd, SUM(cat) as quan FROM item_has_cat INNER JOIN Item ON Item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat"
        . " INNER JOIN barcode ON barcode.Item_id_item=item.id_item WHERE barcode.date BETWEEN '$date_in' AND '$date_out' GROUP by cat_idd";
$result_site_dis=query_select($sql_select_site_dis);

//TESTED
 $sql_select_site_dis_test="SELECT SUM(weight) as wei,item_has_cat.cat as cat_idd, SUM(cat) as quan FROM item_has_cat "
        . "INNER JOIN Item ON Item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat INNER JOIN Barcode ON barcode.Item_id_item=item.id_item INNER JOIN Test ON Test.Barcode_id_Barcode=barcode.id_Barcode WHERE barcode.date BETWEEN '$date_in' AND '$date_out' GROUP by cat_idd";
$result_site_dis_test=query_select($sql_select_site_dis_test);
//shows tested all
echo "<p><b>Tested</b></p>";
echo "<table><tr><td>Total</td><td></td></tr>";
while($rek_site_dis_test= mysql_fetch_array($result_site_dis_test))
{
   echo '<tr><td>';
   // echo $rek_site_dis['sum_weight'];
   //echo $rek_site_dis['Name_sub'];
   echo '</td><td>';
    echo round($rek_site_dis_test['wei'],1);
   $total_sum_test+=$rek_site_dis_test['wei'];
   //echo $rek_site_dis['Site_site_id'];
   echo '</td><td>';
  echo $rek_site_dis_test['cat_idd'];
   echo '</td><td>';
  //echo $rek_site_dis['cat_name'];
   echo '</td><td>';
    //echo $rek_site_dis['quan'];
   echo '</td><td>';
   echo '</td><td>';
   echo '</td><td>';
   echo '</td><td>';
   echo '</td></tr>'; 
}
echo "<table>";

//disposed

$sql_select_site_dis_test="SELECT SUM(weight) as wei,item_has_cat.cat as cat_idd, SUM(cat) as quan FROM item_has_cat "
        . "INNER JOIN Item ON Item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat INNER JOIN Barcode ON barcode.Item_id_item=item.id_item INNER JOIN Test ON Test.Barcode_id_Barcode=barcode.id_Barcode Where Ready=0 AND barcode.date BETWEEN '$date_in' AND '$date_out' GROUP by cat_idd";
$result_site_dis_test=query_select($sql_select_site_dis_test);
//shows tested all
echo "<p><b>Disposed - Not passing test</b></p>";
echo "<table width='200px'><tr><td>Total</td><td></td></tr>";
while($rek_site_dis_test= mysql_fetch_array($result_site_dis_test))
{
   echo '<tr><td>';
   
   echo '</td><td>';
    echo round($rek_site_dis_test['wei'],1);
   $total_sum_test_disp+=$rek_site_dis_test['wei'];
   
   echo '</td><td>';
  echo $rek_site_dis_test['cat_idd'];
   echo '</td><td>';
  
   echo '</td><td>';
   
   echo '</td><td>';
   echo '</td><td>';
   echo '</td><td>';
   echo '</td><td>';
   echo '</td></tr>'; 
}
echo "<table>";





//disposed


echo '<tr><td colspan="1"></td><td><b>TOTAL WEIGHT Tested:</b> '.round($total_sum_test,1).'<td><td colspan="5">'.$total.'</td></tr></br></table>';

//TESTED

echo '</BR></BR><table border="1"><tr><td></td><td>Totals for category [kgs]</td><td>Category</td></tr>';
while($rek_site_dis= mysql_fetch_array($result_site_dis))
{
   echo '<tr><td>';
   // echo $rek_site_dis['sum_weight'];
   //echo $rek_site_dis['Name_sub'];
   echo '</td><td>';
    echo round($rek_site_dis['wei'],1);
   $total_sum+=$rek_site_dis['wei'];
   //echo $rek_site_dis['Site_site_id'];
   echo '</td><td>';
  echo $rek_site_dis['cat_idd'];
   echo '</td><td>';
  echo $rek_site_dis['cat_name'];
   //echo '</td><td>';
    //echo $rek_site_dis['quan'];
  
   echo '</td></tr>'; 
}
global $sda;
echo '<tr><td colspan="1"></td><td><b>TOTAL WEIGHT STOCKED:</b> '.round($total_sum,1).'<td><td colspan="5">'.$total.'</td></tr>';
echo '<tr><td colspan="1"></td><td><b>SDA WASTE:</b> '.$sda=$sda-$total_sum.'<td></tr>';
//echo '<tr><td colspan="1"></td><td><b>By this year:</b> '.$total_sum.'<td></tr>';
echo '</table>';
}




//END of stock report waste calculation



$status_sql1="SELECT Barcode FROM Barcode";

$status_sql2="SELECT DISTINCT Barcode FROM Barcode";

$result1=query_select($status_sql1);
$num1_bar=mysql_num_rows($result1);
$result2=query_select($status_sql2);
$num2_bar_d=mysql_num_rows($result2);

//echo $num1_bar;
//echo $num2_bar_d;



$status_sql11="SELECT Barcode FROM Barcode "
        . " INNER JOIN Item ON Barcode.Item_id_item=Item.id_item"
        ." INNER JOIN Item_has_cat ON Item.Item_has_Cat_id_item_cat=Item_has_cat.id_item_cat";
$status_sql21="SELECT Barcode FROM Barcode "
        . " INNER JOIN Item ON Barcode.Item_id_item=Item.id_item"
        ." INNER JOIN Item_has_cat ON Item.Item_has_Cat_id_item_cat=Item_has_cat.id_item_cat";

$result1=query_select($status_sql11);
$num1_bar_ar=mysql_num_rows($result1);
$result2=query_select($status_sql21);
$num2_bar_d_ar=mysql_num_rows($result2);

//echo $num1_bar_ar;
//echo $num2_bar_d_ar;


$status_sql1="SELECT name FROM ITEM";

$status_sql2="SELECT DISTINCT name FROM ITEM";

$result1=query_select($status_sql1);
$num1_item=mysql_num_rows($result1);
$result2=query_select($status_sql2);
$num2_item_d=mysql_num_rows($result2);









$query="SELECT * From Barcode WHERE date=CURDATE()";
$result=query_select($query);

$barcode=array();
$serial=array();
$barcode_id=array();
  $num_stock_tod=mysql_num_rows($result);
$i=0;
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $barcode[$i]=$rek["Barcode"];    
     $barcode_id[$i]=$rek["id_Barcode"];
     $serial[$i]=$rek["serial"];  
     //echo $barcode_id[$i]."</br>";
   }


///
$z=0;
$g=0;
$zi=0;
$test_id=array();

for($c=1;$c<=$i;$c++)
{
    
$query="SELECT * From Test WHERE Barcode_id_Barcode=".$barcode_id[$c]." AND Ready='0'";
$result=query_select($query);



if($rek = mysql_fetch_array($result,1));  
   {
    if(!empty($rek['id_test']))
     $z++; 
     //$test_id[$c]=$rek["id_test"];    
     //$serial[$i]=$rek["serial"];  
     //echo $barcode[$i].$serial[$i];
    // if(!isset($test_id[$c]) AND empty($test_id[$c]))
      //  $zi++;
   }
   
$query1="SELECT * From Test WHERE Barcode_id_Barcode=".$barcode_id[$c]." AND Ready='1'";
$result1=query_select($query1);

if($rek = mysql_fetch_array($result1,1));  
   {
    if(!empty($rek['id_test']))
     $g++; 
     //$test_id[$c]=$rek["id_test"];    
     //$serial[$i]=$rek["serial"];  
     //echo $barcode[$i].$serial[$i];
    // if(!isset($test_id[$c]) AND empty($test_id[$c]))
      //  $zi++;
   }



}
?>



<HTML>
<HEAD>
<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">

<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />

<script type="text/javascript" src="csshorizontalmenu.js">



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

    
    </BR></BR></BR><div style="alignment-adjust: central"><h1>Category Overview</h1></div></BR></BR><table style="width:auto">
<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php /* if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} 
 echo "</BR>Today, ".date('l jS \of F ');
echo ",</BR></br> Added on Stock: <b>".$i." Items</b></BR>";
echo  "Tested <b>".($g+$z)." Items</b>, while<b> ".$z." Items</b> failed tests.";
echo "</BR><table border='2' ><tr><td>Test Description</td><td>Status</td></tr>";
echo "</BR> <td> Every Item has UNIQUE Barcode </td><td>YES</td></tr><tr>";
echo "<td colspan='2' border='2'></tr><tr><td>CONTROL STATUS</td></tr><tr>";
echo "<td>UNIQUE BARCODE</td><td>STATUS CRQ</td><td>BARTQ:".$num1_bar." BARDQ:".$num2_bar_d."</td></tr><tr>";
echo "<td></td><td>AREA 1</td><td>BARTQ:".$num1_bar_ar." BARDQ:".$num2_bar_d_ar."</td></tr><tr>";
echo "<td>UNIQUE BARCODE</td><td>STATUS CRQ</td><td>ITTQ:".$num1_item." ITDQ:".$num2_item_d."</td></tr><tr>";

echo "</table>";
//echo $num_stock_tod;
//echo "</br>Stock IN</BR>";
//echo "</BR>PER HOUR / PER USER  ".$num_stock_tod/10;
//echo "<br>Tests</BR>";

//echo "Tottal weight of manifest collection from site places:$sum    Total sum of weight assignment for items comeing from one site place      WEIGHt DISCREPANCY BY TOTALS  show by cattegories";

//echo "total";
//echo '</BR>';
*/

echo "<form action='reports_sum_time.php' method='POST'>";
echo "<input type='text' name='date_in' placeholder='YYYY-MM-DD' value='".$_POST['date_in']."'>";
echo "<input type='text' name='date_out' placeholder='YYYY-MM-DD' value='".$_POST['date_out']."'>";
echo "<input type='submit' name='show' value='Show'>";
echo "</form>";

?>




</td>
</table>


<?php dis_fun(); ?>
<?php // echo "</br></BR><table><tr><td><b>Stocked in total weight</b></td><td><b>Disposed total weight</b></td><td><b>SDA WASTE totals</b></td></tr> </table>";
stock_fun();
//sold_fun();
//sold_ebay_fun();
//sold_cnt_ebay_fun();
//echo $sda;
?>
</BODY>
</HTML>