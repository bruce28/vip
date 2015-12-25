<?php
session_start();
include 'header_valid.php';
$_SESSION['quantity']=$_POST['quantity'];
$id_user=$_SESSION['id_user'];

$date=$_POST['date1'];

$compare=1;

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

    
    
   
    
    if(isset($_POST['tv_cat']))
    {
        $cat_set_up=1;
       // echo "in tv sheet";
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
   //here we come back to main system since agin insert cannot be done I think
   // redirect("index.php",0);
    

if(!isset($_POST['site_id']))
{
 
}



//here if collected after 1 october
if($_POST['site_id']>=514)
{
    $SET_OCT=1;
    
    $WEIGHT_FOR_LAPTOP_COLLECTED=2.4;
    
    
}
else
    $WEIGHT_FOR_LAPTOP_COLLECTED=2.6;


 $origin=$_POST['site_id'];
//$site_ref_num=$origin+rand();
//DEBUG VARIABLE TURN OFF SITE
 //echo $origin;

   $wynik = mysql_query("SELECT * FROM Site where site_id='$origin'") 
        or die(mysql_error()); 
    while($rek = mysql_fetch_array($wynik,1)){ 
    //    echo $rek["site_id"];
      //  echo '</BR>';
       // echo $rek['site_ref_number'];
       // echo '</BR>';
      //  echo $name;
      //  echo '</BR>';
      //  echo $surname;
      //  echo '</BR>';
      //  echo $post;
       // echo '</BR>';
       // echo $town;
       // echo '</BR>';
        
         $site_id=$rek["site_id"];
}

//here we must pic up items

//site id 514




$num_ro=mysql_num_rows($sql_item_has);
$in=30;

$tab = array();
for($z=0;$z<=100;$z++)
   $tab[$z]=0;
$sql_item_has_cat="SELECT * FROM site_has_cat where Site_site_id='$origin'";
$result_item_has_cat=mysql_query($sql_item_has_cat);
$i=0;
while($rek_item_has_cat=mysql_fetch_array($result_item_has_cat))
{ 
  //$tab[$i]=0;   
	  //echo "</ BR></BR>";
    //item category associated with weight and categorie
    $i++;
    
    $id_c=$rek_item_has_cat['Sub_cat_id_c'];
    
    $sql_item_has="SELECT Category.id as idc, weight.id as idw, weight,name_cat,id_c FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id "
            
            . " WHERE Sub_cat.id_c='$id_c'";
$result_item=mysql_query($sql_item_has)or die(mysql_error());
    $rek_result=mysql_fetch_array($result_item);
    //output is weight and category
    
  //$idd="id".$i;
    //echo $_POST[$idd];
    //echo " "; 
  //$name="quantity".$i; 
		//echo $_POST[$name];
    //echo " "; 
  //$weight="weight".$i; 
    //echo $_POST[$weight];
    //echo " "; 
    
    
    if($rek_result['id_c']==30)
    {
       $cat_id=12;  
    }
    else
  $cat_id=$rek_result['idc']; 
    //echo $_POST[$cat_id];
  
    
    

    //echo " "; 
  if($rek_result['id_c']==43 OR $rek_result['id_c']==44 OR $rek_result['id_c']==45 AND $SET_OCT==1)
      $weight=$rek_item_has_cat['Quantity']*$WEIGHT_FOR_LAPTOP_COLLECTED;
  else
 
   $weight=$rek_item_has_cat['Quantity']* $rek_result['weight'];     
  //$sum_sub=$_POST[$name]*$_POST[$weight] ;
    //echo $sum_sub;
 // $tab[$_POST[$cat_id]]+=$sum_sub; 
  $sum_sub=$weight;
  //$site=$_POST['site_id']; 
  //$site=$site_id;

  
  //asign sum weight to caegories
  $tab[$cat_id]+=$sum_sub;
  
	//echo $site;
   $insert1 = "INSERT INTO Site_has_cat(Site_site_id, Sub_cat_id_c,quantity,sum_weight) VALUES ('$site','$_POST[$idd]','$_POST[$name]','$sum_sub')";
   
    
 // echo mysql_query($insert1);
   
   
   //echo $_POST[$idd];
  
  
  
  

        

}

?>
<HTML>
<HEAD>
    <link rel="stylesheet" href="layout_pr.css " type="text/css">
<link rel="stylesheet" href="form_cat_pr.css " type="text/css">

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

    
<p><h2>WEEE COLLECTION DOCKET.  Categorised as specified under the EU directive.</h2></p><p><h3> EWC CODE 20 01 36</h3></p>
<p><h3>WEEE COLLECTED FROM HWRC SITE...<b><?php echo $_POST['source'];?></b>... ON DATE: <?php echo $_POST['date_r'];?>     
</h3></p>

<?php

$sql = "SELECT * FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id";
$sql1= "SELECT name_cat,type_2,id from Category";

$serwer="localhost";
$login="root";
$haslo="krasnal";
$baza="dbs3";
 


    if (mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza)) { 
         
        $wynik = mysql_query($sql1) 
        or die("Blad w zapytaniu!"); 
         
        mysql_close(); 
    } 
    else echo "Cannot Connect"; 

if($compare==1)
{
    mysql_connect($serwer, $login, $haslo);
    mysql_select_db($baza);
    $sql_compare="SELECT SUM(weight) as suma, site_id, Barcode.date,login,Ready,town,cat FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
INNER JOIN site ON site.site_id=barcode.Site_site_id
INNER JOIN Origin On Origin.Origin_id=site.Origin_origin_id
WHERE (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%DBS/%/2' OR Barcode LIKE '%UNQ/%') AND Site.site_id='";
$sql_compare.=$_POST['site_id'];    
$sql_compare.="' GROUP BY site_ref_number,cat";
//echo $sql_compare;
$result_compare=mysql_query($sql_compare) or die(mysql_error());

}    

echo " <table border='1' > <tr><td>CATEGORY OF WEEE COLLECTED</td><td>WEIGHT (In Kg)</td></tr>";

$att_num=1;
$i=0;

 mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);

$lda=0;
$sda=0;
$lda_s=0;
$sda_s=0;
$znacznik_formy=0;
$total_compared=0;

$origin=$site_id;
while($rek = mysql_fetch_array($wynik,1)) {     
    
    $i++;
    //if($i==11)exit();
 
    if($compare==1)
    {
        $sql_compare="SELECT SUM(weight) as suma, site_id, Barcode.date,login,Ready,town,cat FROM barcode INNER JOIN test ON Barcode.id_Barcode=test.Barcode_id_Barcode
INNER JOIN user_2 ON user_2.id_user=test.user_2_id_user 
INNER JOIN Item on Barcode.Item_id_item=Item.id_item
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat
INNER JOIN site ON site.site_id=barcode.Site_site_id
INNER JOIN Origin On Origin.Origin_id=site.Origin_origin_id
WHERE (Barcode LIKE '%DBS/%/1' OR Barcode LIKE '%DBS/%/2' OR Barcode LIKE '%UNQ/%') AND Test.ready=1 AND Site.site_id='";
$sql_compare.=$_POST['site_id'];    
$sql_compare.="' AND cat='";
$sql_compare.=$rek['id'];
        $sql_compare.="' GROUP BY site_ref_number,cat";
        $result_compare=mysql_query($sql_compare) or die(mysql_error());
        $rek_compare=mysql_fetch_array($result_compare);
        $rek_compare['suma'];
    }
    
    
    
    
    
 //$i++;  
    $sum_total+=$tab[$i];
    //if($cat_set_up==1)
      //  $i=2;
   
    
  if($i<11 AND $cat_set_up==0) 
  {  
      if($tab[$i]==0)
          echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> Nil </td>";
      else
        echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> ".$tab[$i]." </td>";
   
 
       
       echo "</tr>";
  }
  else if($cat_set_up==1) 
  {
      if($rek['type_2']!=30)
      {
      if($tab[$i]==0)
          echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> Nil </td>";
      else
      { 
         
        echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> ".$tab[$i]." </td>";
      }
      }
  }
  
  //her
   if($compare==1)
    {
        if($rek_compare['suma']==0)
        {
            if($i==15) echo ''; else echo "<td>Nil</td>";
        }
      else
      {
        if(($tab[$i])<$rek_compare['suma'])
            echo "<td bgcolor='red'>Reused ".round($rek_compare['suma'],2)." </td>";
        else
        echo "<td>Reused ".round($rek_compare['suma'],2)." </td>";
        $total_compared+=$rek_compare['suma'];
      } 
      //echo '</tr>';
    }
  
}
echo "<tr><td><center>TOTAL WEIGHT OF COLLECTION</center></td><td>".$sum_total."</td>";
if($compare==1)
{
   echo "<td>".$total_compared."</td>"; 
}
      
        echo  "</tr>";

//while($rek = mysql_fetch_array($wynik,1)) { 
  //  echo "<tr><td>".$rek["name_cat"]."</td><td> ".$rek["Name"]." </td><td>   ".$rek["Street"]."  </td><td> ".$rek["House"]." </td><td> ".$rek["Date_Sold"]."</td><td>".$rek["Price"]." �</td></tr><br />"; 
//} 
     echo "</table> ";
//echo "<input type='submit' name='Submit' value='Add Ref Num' align='right'></form>";
//unset
     
     ?>


<IMG SRC="weee_out/image006.png" WIDTH=860 HEIGHT=127>
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
<h4> <a href="manifest_rep.php"><button class="submit" style=" width: auto;  
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