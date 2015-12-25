<?php
session_start();
include 'header_valid.php';
include 'header_mysql.php';
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


function get_name_item_cat($id_c)
{
    $sql1="SELECT * FROM item Where Item_has_Cat_id_item_cat='$id_c'";
    $result=query_select($sql1);
    $rek=mysql_fetch_array($result);
    return $rek['name'];       
    
    
}

?>
<HTML>
<HEAD>
    <link rel="stylesheet" href="layout_pr_colre.css " type="text/css">
<link rel="stylesheet" href="form_cat_pr_colre.css " type="text/css">

<script>
function printpage()
  {
  window.print()
  }
</script>

</HEAD>
<BODY>
    <!--<IMG SRC="weee_out/image002.png" WIDTH=180 HEIGHT=151 align="left">
   -->
   <div id="all">
  <div id="banner">
<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=1 VSPACE=1>
<IMG SRC="weee_out/image001.png" WIDTH=600 HEIGHT=120>
  </div>
<div id="form_stock" style="font: xx-large; font-variant: simplified; font-family: sans-serif; font-size:  inherit; ">
<?php
//processing of post here
$site_id=0;


?>
    


<?php

     //echo "<h3> Site details: </h3>";
echo " Site ID: ".$_POST['site_id'];
      echo "<BR/> Site Reference Number: ".$_POST['site_ref_number'];
        echo " Collected On: " .$_POST['date_r'];   

echo "<BR/><BR/>";
$SITE_ID=$_POST['site_id'];

$i=0;$z=0;
$category=array();
$category_qtty=array();
$category_wei=array();
$category_reused_qtty=array();
$category_resued_wei=array();

//2ond sheet

$items=array();
$items_qtty=array();
$items_wei=array();
$items_qtty1=array();

$sql1= "SELECT name_cat,type_2,id from Category Where kind=1";
$result=query_select($sql1);
while($rek=mysql_fetch_array($result))
{
    $i++;
    $category[$i]=$rek['type_2']; 
}
$z=$i;
$i=0;

$sql1="SELECT * FROM sub_cat Where kind=2 ORDER BY id_c";
$result=query_select($sql1);
while($rek=mysql_fetch_array($result))
{
    $i++;
    $items[$i]=$rek['id_c']; 
}
$y=$i;




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



$prepered_reused_wei="SELECT SUM(weight) as suma, site_id, Barcode.date,login,Ready,town,cat FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
INNER JOIN site ON site.site_id=barcode.Site_site_id
INNER JOIN Origin On Origin.Origin_id=site.Origin_origin_id
WHERE (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%DBS/%/2' OR Barcode LIKE '%UNQ/%') AND Site.site_id=$SITE_ID GROUP BY cat";

$result_reused_wei=query_select($prepered_reused_wei);
//Queries processing

$i=0;
while($rek=mysql_fetch_array($result_reused_wei))
{
     $cat=$rek['cat'];
    $category_reused_wei[$cat]=$rek['suma'];
}

$prepared_qtty_wei="SELECT COUNT(*) as qtty, site_id, Barcode.date,login,Ready,town,cat FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
INNER JOIN site ON site.site_id=barcode.Site_site_id
INNER JOIN Origin On Origin.Origin_id=site.Origin_origin_id
WHERE (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%DBS/%/2' OR Barcode LIKE '%UNQ/%') AND Site.site_id=$SITE_ID GROUP BY cat";
$result_reused_qtty=query_select($prepared_qtty_wei);
//Queries processing

$i=0;
while($rek=mysql_fetch_array($result_reused_qtty))
{
     $cat=$rek['cat'];
    $category_reused_qtty[$cat]=$rek['qtty'];
}

//second table






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

$item_stocked="SELECT SUM(weight) as suma, id_item_cat,item.name, site_id, Barcode.date,login,Ready,town,cat FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
INNER JOIN site ON site.site_id=barcode.Site_site_id
INNER JOIN Origin On Origin.Origin_id=site.Origin_origin_id
WHERE (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%DBS/%/2' OR Barcode LIKE '%UNQ/%') AND Site.site_id=$SITE_ID and active=1 AND Test.Ready=1 GROUP BY id_item_cat";

$result_item_stocked=query_select($item_stocked);
//Queries processing

$i=0;
while($rek=mysql_fetch_array($result_item_stocked))
{
   
     $cat=$rek['id_item_cat'];
    $items_wei[$cat]=$rek['suma'];
}


//qtty reused
$item_stocked="SELECT COUNT(*) as qtty, id_item_cat,item.name, site_id, Barcode.date,login,Ready,town,cat FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
INNER JOIN site ON site.site_id=barcode.Site_site_id
INNER JOIN Origin On Origin.Origin_id=site.Origin_origin_id
WHERE (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%DBS/%/2' OR Barcode LIKE '%UNQ/%') AND Site.site_id=$SITE_ID and active=1 AND Test.Ready=1 GROUP BY id_item_cat";

$result_item_stocked=query_select($item_stocked);
//Queries processing

$i=0;
while($rek=mysql_fetch_array($result_item_stocked))
{
   
     $cat=$rek['id_item_cat'];
    $items_qtty1[$cat]=$rek['qtty'];
}

//table appears

//echo "<h3>Site ID :</h3>"; echo $SITE_ID;


echo " <table border='4' id='tabel_out' style='float: left;' > ";
echo "<th>Weee category</th><th>Quantity</th><th>Weight</th><th>Reused Qtty</th><th>Reused Weight</th>";
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
echo "<td>";
echo $category_reused_qtty[$i];

echo "</td>";
echo "<td>";
echo round($category_reused_wei[$i],2);
echo "</td>";

echo "</tr>";


}
echo "</table> ";

echo " <table border='4' id='tabel_out'  > <tr><td>Manifest ID</td><td>Manifest types</td><td>Qtty Received</td></tr>";
$total_qtty_col=0;
for($i=1;$i<47;$i++)
{
    if(!empty($items_qtty[$items[$i]]))
          echo "<tr bgcolor='whitesmoke'><td>";
    else
    echo "<tr><td>";
    echo $items[$i];
    echo "</td><td>";
    echo get_name_item($items[$i]);
    echo "</td><td>";
   echo  $items_qtty[$items[$i]];
   echo "</td></tr>";
   $total_qtty_col+=$items_qtty[$items[$i]];
}
   echo "<tr bgcolor='whitesmoke'><td>Totals:</td>";
    echo "<td>".$total_qtty_col."</td>";
    echo "</tr>";
echo "</table>";

echo "Summary reused";

$total_weight_re=0;
$total_qtty_re=0;
echo "<table border='4' id='tabel_out' ><td>Tested Item types</td><td>Reused Stock</td><td>Qtty Reused</td></tr>";
for($i=1;$i<47;$i++)
{
    //$items[$i];
    
   if(!empty($items_wei[$i]))
   {
       echo "<tr><td>";
   echo get_name_item_cat($i);
    echo "</td><td>";
     echo round($items_wei[$i],2);
      echo "</td><td>";
     echo $items_qtty1[$i];
   
    echo "</td></tr>";
   $total_qtty_re+=$items_qtty1[$i];
   $total_weight_re+=$items_wei[$i];
    
   }
   
   }
    echo "<tr bgcolor='whitesmoke'><td>Totals:</td>";
    echo "<td>".$total_weight_re."</td>";
    echo "<td>".$total_qtty_re."</td>";
    echo "</tr>";

echo "</table> ";
 


     ?>



</div>
 
    </div>

   
<style type="text/css">
@media print {
    .submit {
        display :  none;
    }
}
</style>

<p class="submit">   
      <input type="button" value="Print Report" onclick="printpage()">
     
     
    </p>  

   <div id="buttons">
<h4> <a href="manifest_rep_detail.php"><button class="submit" style=" width: auto;  
    margin: 15px;
    padding: 9px 15px;  
    background: #617798;  
    border: 0;  
    font-size: 14px;  
    color: #FFFFFF;  
    -moz-border-radius: 1px;  
    -webkit-border-radius: 1px;  ">Return</button></a>
</h4>

   
   
   </div>

</BODY>
</HTML>