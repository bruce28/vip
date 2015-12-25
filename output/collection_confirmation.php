<?php
session_start();
include '../header_mysql.php';
include '../header_valid.php';
connect_db();

function get_weee_cat_name($id)
{
    $sql1= "SELECT name_cat,type_2,id from Category WHERE type_2=$id";
    $result=query_select($sql1);
    $rek=mysql_fetch_array($result);
    return $rek['name_cat'];       
}

function get_name_item($id_c)
{
    $sql1="SELECT * FROM sub_cat Where kind=2 AND id_c='$id_c'";
    $result=query_select($sql1);
    $rek=mysql_fetch_array($result);
    return $rek['Name_sub'];       
    
    
}

$items=array();
$items_qtty=array();



function serialize_barcodes($start_barcode)
{
	
 
 $prefix=substr($start_barcode,0,3);
   
 $pre_increment =  substr($start_barcode,4,-2);
   
 $post_inc=substr($start_barcode,10,12);
   
   
   $inc=$prefix."/".$pre_increment;
   $inc++;
   
   $serialised=$inc.$post_inc;
   return $serialised;
}

?>

<!DOCTYPE html>
<html>
<head>
<style>
	
	table {
	border: 1px solid #e3e3e3;
	background-color: #f2f2f2;
        width: 89%;
	border-radius: 6px;
	-webkit-border-radius: 6px;
	-moz-border-radius: 6px;
}
td,  th {
	padding: 5px;
	color: #333;
}
thead {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	padding: .2em 0 .2em .5em;
	text-align: left;
	color: #4B4B4B;
	background-color: #C8C8C8;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#e3e3e3), color-stop(.6,#B3B3B3));
	background-image: -moz-linear-gradient(top, #D6D6D6, #B0B0B0, #B3B3B3 90%);
	border-bottom: solid 1px #999;
}
th {
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 17px;
	line-height: 20px;
	font-style: normal;
	font-weight: normal;
	text-align: left;
	text-shadow: white 1px 1px 1px;
}
 td {
	line-height: 20px;
	font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-size: 14px;
	border-bottom: 1px solid #fff;
	border-top: 1px solid #fff;
}
td:hover {
	background-color: #fff;
}
	
	
	/*
	table {
	background-color: #f5f5f5;
	padding: 5px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid #ebebeb;
}
td, #table-5 th {
	padding: 1px 5px;
}
 thead {
	font: normal 15px Helvetica Neue,Helvetica,sans-serif;
	text-shadow: 0 1px 0 white;
	color: #999;
}
th {
	text-align: left;
	border-bottom: 1px solid #fff;
}
 td {
	font-size: 14px;
}
 td:hover {
	background-color: #fff;
}
	
	
	*/
	/*
	table {
	border: 1px solid #DFDFDF;
	background-color: #F9F9F9;
	width: 100%;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	font-family: Arial,"Bitstream Vera Sans",Helvetica,Verdana,sans-serif;
	color: #333;
}
 td, th {
	border-top-color: white;
	border-bottom: 1px solid #DFDFDF;
	color: #555;
}
 th {
	text-shadow: rgba(255, 255, 255, 0.796875) 0px 1px 0px;
	font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;
	font-weight: normal;
	padding: 7px 7px 8px;
	text-align: left;
	line-height: 1.3em;
	font-size: 14px;
}
td {
	font-size: 12px;
	padding: 4px 7px 2px;
	vertical-align: top;
}
	
	*/
	
	
	
img {
    position: absolute;
    left: 0px;
    top: 0px;
    z-index: -1;
}

img.pic {
    position: absolute;
    left: 0px;
    top: 3600px;
    z-index: -1;
}
img.pic2 {
    position: absolute;
    left: 0px;
    top: 4100px;
    z-index: -1;
}
img.pic3 {
    position: absolute;
    left: 0px;
    top: 4800px;
    z-index: -1;
}

p {
	position: relative;
	left: 40px;
	top:280px;
}


h1{
	position:absolute;
	left:220px;
	top:210px;
}

div.small {
	position: absolute;
	left: 40px;
	top:710px;
	
}

div.sub {
	position:relative;
	left:40px;
	top:750px
	
}
div.grr {
   	position: absolute;
	left: 560px;
	top:0px;
}

</style>
</head>
<body>

<h1>Collection Confirmation </h1>
<img src="image003.png" width="229" height="180">

<div class="grr">
<h3><table id="ii" style="width: auto; margin-right:10px;"><tr><td>Registered Office:</td></tr><tr><td>273-275 Sheepcot Lane</td></tr><tr><td>Garston</td>                       </tr>
<tr><td>Watford</td> </tr><tr><td>WD25 7DL</td>  </tr>

</table></h3>
</div>
<div>
<p>[*]This document was generated automatically by GRR Collection System
</BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR>
<h3>Customer Details:</h3>
<table width="55%" style="width: 33%;">

<?php

$rek_c=mysql_fetch_array($cust);
 echo "<tr><td>Site Reference Number</td><td><b>".$rek_c["ref_sell_number"].$rek_c["Buyer_id_Buyer"]."</b></td></tr>";
  echo "<tr><td>Site name</td><td>".$rek_c["company_name"]." </td></tr>";
   echo "<tr><td>Location</td><td>".$rek_c["name"]." </td></tr>";
    echo "<tr><td>Date of collection</td><td>".$rek_c["surname"]." </td></tr>";
     echo "<tr><td>Picker name</td><td>".$rek_c["address"]."</BR>".$rek_c["town"]."</BR>".$rek_c["postcode"]."</td></tr>";
     echo "<tr><td></td><td><b>".$rek_c["ttl_nr"]."</b></td></tr></BR>";
?>
</table>

</p>

</div>

<?php
$serialised="dbs/000121/2";
$size=60;
?>
<div class="small">
<table border="0">
<thead>
	<th colspan="8">Barcodes</th>
</thead>	
<tbody>
	<tr>
	  <?php 
	  echo "<tr>";
	  $i=0;
	    do{
			$i++;
			echo "<td>";
		echo $serialised=serialize_barcodes($serialised);
		$size--;
		    echo "</td>";
		    if($i%8==0)echo "</tr><tr>";
		    
		}while($size>0);	
	 ?>
	 </tr>
</tbody>	
</table>	
</div>

<div class="sub">
Overview:
<?php

$SITE_ID=502;
$i=0;
$sql1="SELECT * FROM sub_cat Where kind=2 ORDER BY id_c";
$result=query_select($sql1);
while($rek=mysql_fetch_array($result))
{
    $i++;
   $items[$i]=$rek['id_c']; 
}
$y=$i;


$item_collected_qtty="SELECT id_c, Name_sub, Weight_id, Category_id, Quantity
FROM sub_cat
INNER JOIN Site_has_cat ON Site_has_cat.Sub_cat_id_c = sub_cat.id_c
WHERE kind =2
AND Site_site_id =$SITE_ID ORDER by id_c";

$result_item_qtty=query_select($item_collected_qtty);
//Queries processing

$i=0;
while($rek=mysql_fetch_array($result_item_qtty))
{
     $cat=$rek['id_c'];
   $items_qtty[$cat]=$rek['Quantity'];
}

//END QUERIES
//


echo " <table border='0' id='tabel_out'  > <thead><tr><th>Items received</th><th>Qtty </th></tr><thead><tbody>";
$total_qtty_col=0;

for($i=1;$i<47;$i++)
{
    if(!empty($items_qtty[$items[$i]]))
    {
          echo "<tr bgcolor='whitesmoke'>";
    echo "<tr>";
  //  echo $items[$i];
    echo "<td>";
    echo get_name_item($items[$i]);
    echo "</td><td>";
   echo  $items_qtty[$items[$i]];
   echo "</td></tr>";
   $total_qtty_col+=$items_qtty[$items[$i]];
}else
;

}
   echo "<tr bgcolor='whitesmoke'><td>Totals:</td>";
    echo "<td>".$total_qtty_col."</td>";
    echo "</tr>";


echo "</tbody></table>";
//print_r($items);
//var_dump($items);
//echo $items["4"];


//weee


$i=0;$z=0;
$category=array();
$category_qtty=array();
$category_wei=array();

$y=$i;

$sql1= "SELECT name_cat,type_2,id from Category Where kind=1";
$result=query_select($sql1);
while($rek=mysql_fetch_array($result))
{
    $i++;
    $category[$i]=$rek['type_2']; 
}
$z=$i;

//Queries builder here

//category table queries

$prepared_query="SELECT id_c, Name_sub, Weight_id, Category_id, SUM(Quantity) as Qtty
FROM sub_cat INNER JOIN Site_has_cat ON Site_has_cat.Sub_cat_id_c=sub_cat.id_c where kind=2 AND Site_site_id='$SITE_ID' GROUP BY Category_id";

$result=query_select($prepared_query);
$i=0;
while($rek=  mysql_fetch_array($result))
{
     $cat=$rek['Category_id'];
   
    $category_qtty[$cat]=$rek['Qtty'];
}



$prepared_query_wei="SELECT id_c, Name_sub, Weight_id, Category_id, SUM( sum_weight ) as suma 
FROM sub_cat
INNER JOIN Site_has_cat ON Site_has_cat.Sub_cat_id_c = sub_cat.id_c
WHERE kind =2
AND Site_site_id =$SITE_ID
GROUP BY Category_id";


$result_wei=query_select($prepared_query_wei);
//Queries processing

$i=0;
while($rek= mysql_fetch_array($result_wei))
{
     $cat=$rek['Category_id'];
    $category_wei[$cat]=$rek['suma'];
}
echo "</BR></BR</BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR></BR>";
echo " <table border='1' id='tabel_out' style='float: left;' > ";
echo "<thead><th>Weee category</th><th>Quantity</th><th>Weight</th></thead><tbody>";
for($i=1;$i<$z+1;$i++)
{
echo "<tr><td>";
echo $category[$i].". ".get_weee_cat_name($category[$i]);
echo "</td>";

echo "<td>";
echo $category_qtty[$i];
echo "</td><td>";
echo round($category_wei[$i],2);
echo "</td>";


echo "</tr>";


}
echo "</tbody></table> ";

?>


</div>

<img class="pic" src="graph1.png">
<img class="pic2" src="graph2.png">
<img class="pic3" src="graph3.png">

</body>
</html>
