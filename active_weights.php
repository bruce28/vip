<?php
session_start();
include 'header_valid.php';

function check_active_weights($item_type)
{
    $active=0;
   $check_sql="SELECT * FROM item_has_cat INNER JOIN item ON item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat WHERE item.name='$item_type' " ;
   
   $result=mysql_query($check_sql);
   
   while($rek=mysql_fetch_array($result,MYSQL_BOTH))
   {
     if($rek['active']==1)
        $active=1; 
       
   }
   
   if($active==1)
   return 1;
   else
       return 0;
    
    
    
}




function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}

$s_l_array=array();
$w_n_array=array();
$count=0;
$name_array=array();

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
 else
  $result="No";
	
	return $result ;
}

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}







/*
if(isset($_POST['cat_as_yes']) )
{
    $def=0;
   /// echo "submited";
    
  
    
    
    
    
    
    
}




*/













$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

$sql='SELECT * FROM Sub_cat'
         //. ' INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id'
         . ' INNER JOIN Weight ON Weight.id=Sub_cat.Weight_id'
         . ' INNER JOIN Category ON Category.id=Sub_cat.Category_id';
        
        
$sql_item_not_as="SELECT item_has_cat.date,assign_nr, active,weight,site_ref_number,name, COUNT(*) as quantity FROM Barcode 

INNER JOIN Item ON Barcode.Item_id_item=Item.id_item INNER JOIN Site ON Barcode.Site_site_id=Site.site_id 
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat  
WHERE Item_has_Cat_id_item_cat>0
GROUP BY name  ORDER BY quantity DESC"; //site id        

$sql_item_not_as1="SELECT cat,item_has_cat.date,assign_nr, active,weight,site_ref_number,name,COUNT(*) as quantity  FROM Barcode 
INNER JOIN Item ON Barcode.Item_id_item=Item.id_item INNER JOIN Site ON Barcode.Site_site_id=Site.site_id 
INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat  
WHERE Item_has_Cat_id_item_cat>0 GROUP BY item_has_cat.id_item_cat,active, date, assign_nr ORDER BY name DESC"; //site id        
                                                 //here i just expaneded on item_has_cat.id_item_cat, when if we cat assign nr
$result=add_db($sql_item_not_as1);


    
$sql_cat_read="SELECT * FROM Category";


$result_sub=add_db($sql_cat_read);    
$count_cat=0;		
while($rek1 = mysql_fetch_array($result_sub,1))  
   {
     $i++; 
     $count_cat++;
     
    // $users[$i]=$rek["post_code"];    
     $names[$i]=$rek1["name_cat"];
     $origin[$i]=$rek1["id"];
     //$batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }
  /// echo "Nie ustalono site place ani zmienna ani przekazanie";		
		

//$weight=$_POST["batch_date"];
//$name_sub_cat=$_POST['name_sub_cat'];
//$name_cat=$_POST['site_location'];

///echo $weight;
///echo "Name_sub";
///echo $name_sub_cat;
?>
<HTML>
<HEAD>

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">
</HEAD>
<BODY>

<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>





<div id="tabel_wrap_out"></BR></BR></BR>	

<table id="tabel_out" border="1"  >


<tr><td>Quantity</td><td>Item Type Collected</td><td>STANDARD Weight Assesment</td><td>Active</td><td>ASSIGN NR</td><td>Date Weight ASSIGNMET MADE</td><td>Cat. Assignment</td></tr>
<?php
//if(isset($_SESSION['assign_number_dctv'])) //this modul is for creation of new active weight range
if(isset($_GET['CHG'])>0)
{   //each time we check if sesion var is set. This if no change once set shall be carry on inf.

    //lets give it by get once
    
    
    //We deactivate items by category / group of assignment number. If deactivate button is clicked 
    //than sesion is set untill it is unset by clicking create button
    //here w store seesion assign number of group of items that must be deset as tmp1. We take results from item and item cat
    // where asiign number is set
   
    //$old_as1=$_SESSION['assign_number_dctv'];
    
    $old_as1=$_GET['CHG'];
    
    $sql_item_not_as12="SELECT name,weight,active,assign_nr,cat FROM item_has_cat INNER JOIN Item ON Item.Item_has_Cat_id_item_cat=Item_has_cat.id_item_cat Where assign_nr='$old_as1' "; //site id      
    
    $result_sub12=add_db($sql_item_not_as12);  
    $rek_12=mysql_fetch_array($result_sub12);
    $old_as=rand();  //here we generate unique assignment number by taking old date  and some random set
  echo '<tr><td></td>'; 
  //thus we take only once since but many items on one assign?
	 echo '<td>'.$rek_12["name"].'</td>';
         echo '<td>'.$rek_12["weight"].'</td>';
       
	echo '<td>'.$rek_12["active"].'</td>';
          echo '<td>'.$rek_12["assign_nr"].'</td>';
//	echo '<td>'.$rek["assign_nr"].'</td>';
        echo '<td>'.$rek_12["date"].'</td>';
        echo '<td>'.$rek_12["cat"].'</td>';
	  // echo '<td>'.$rek["Sub_cat_id_c"].'</td>';
              	
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 
     echo '<form action="active_weights.php" method="POST">';
     echo '<td><input placeholder="Give new weight evaluation..." type="text" name="was" value="';
     
     
     $as_cat=$rek_12['name'];
     
     if($_POST[$w_n]!=0) echo $_POST[$w_n];
     
     echo ' " ></td>';
     echo '<td>';
     
     
     echo '<select name="site_location';
     echo '" size="1">';
     
     for($z=0;$z<=$count_cat;$z++)
     {
        echo '<option value="'.$origin[$z].'"';
        //if //($_POST[$s_l]==$origin[$z]) 
         if($origin[$z]==$rek_12['cat']) echo "selected";
        echo ' >'.$names[$z].'</option>';

     }
     echo '</select>';

     
     
     
     echo '</td>';
     //echo '<input type="hidden" name="item'.$i.'" value="'.$name.'>';
     echo '<td>';
     
   
      echo '<input type="hidden" name="ass_cat" value="'.$as_cat.'">';    
     echo '<input type="hidden" name="assign_num_ac" value="'.$old_as.'">';        
     echo '<input type="Submit" name="cat_as_yes1" value="Create">';    
    
     echo '</td>';
     // echo '<td>'.$rek["site_id"].'</td>';
     echo '</tr>';   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}




$weight=$_POST['w2'];



echo $weight;
echo $cat;

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
$i=0;
while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
    
   global $count;
   global $s_l_array;
   global $w_n_array;
   global $name_array;
    
   $s_l="site_location".$i;    
   $w_n='w'.$i; 
   $s_l_array[$i]=$_POST[$s_l];
   $w_n_array[$i]=$_POST[$w_n];
   $count=$i;
   $name_array[$i]=$rek['name'];
   
   //echo $rek['id_item_cat']; //show me item id cat, just to analyse
   echo '<tr><td>'.$rek["quantity"].'</td>'; 
	 echo '<td>'.$rek["name"].'</td>';
         echo '<td>'.$rek["weight"].'</td>';
       
	echo '<td>'.$rek["active"].'</td>';
          echo '<td>'.$rek["assign_nr"].'</td>';
//	echo '<td>'.$rek["assign_nr"].'</td>';
        echo '<td>'.$rek["date"].'</td>';
        echo '<td>'.$rek["cat"].'</td>';
	  // echo '<td>'.$rek["Sub_cat_id_c"].'</td>';
              	
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 
     echo '<form action="active_weights.php" method="POST">';
     echo '<td><input type="text" name="w'.$i.'" value="';
     
     if($_POST[$w_n]!=0) echo $_POST[$w_n];
     
     echo ' " disabled></td>';
     echo '<td>';
     
     
     echo '<select name="site_location'.$i;
     echo '" size="1" disabled>';
     
     for($z=0;$z<=$count_cat;$z++)
     {
        echo '<option value="'.$origin[$z].'"';
        //if //($_POST[$s_l]==$origin[$z]) 
         if($origin[$z]==$rek['cat']) echo "selected";
        echo ' >'.$names[$z].'</option>';

     }
     echo '</select>';

     
     
     
     echo '</td>';
     //echo '<input type="hidden" name="item'.$i.'" value="'.$name.'>';
     echo '<td>';
     if($rek['active']==1)
     {
     echo '<input type="hidden" name="assign_num_de'.$i.'" value="'.$rek['assign_nr'].'">';    
     echo '<input type="Submit" name="cat_as_yes2'.$i.'" value="Deactivate"';
     }
     if($rek['active']==0)
     {
     echo '<input type="hidden" name="assign_num_ac" value="'.$rek['assign_nr'].'">';        
     echo '<input type="Submit" name="cat_as_yes2" value="Activate" disabled>';    
     }
    /*
     $act_flag=check_active_weights($rek['name']);
     if($act_flag==0)
     {
     echo '<input type="hidden" name="assign_num_ac" value="'.$rek['assign_nr'].'">';        
     echo '<input type="Submit" name="cat_as_yes1" value="Create">';    
     }
     * 
     */
     echo '</td>';
     // echo '<td>'.$rek["site_id"].'</td>';
     echo '</tr>';
     
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
echo '<tr><td colspan=5></td><td>';


echo '</td>';

//$r=0;  if($r==1) echo '<td><input type="Submit" name="cat_as_confirm" value="Confirm"></td>';
echo '</tr>';

echo '</form>';







/**

 * $add_new=1;
 * if($add_new==1)
 * {
 *     
 *     
 *     
 *     
 *     //echo "w funkcji";
 * $sql='INSERT INTO Sub_cat'
 *          //. ' INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id'
 *          . ' INNER JOIN Weight ON Weight.id=Sub_cat.Weight_id'
 *          . ' INNER JOIN Category ON Category.id=Sub_cat.Category_id';

 * //$weight=$batch_date;
 * $name_cat;
 * $name_sub_cat;


 * $sql_transaction="BEGIN
 * INSERT INTO Weight(weight) 
 *   VALUES('$weight');
 *   set v_weight_id = last_insert_id();
 * INSERT INTO Category (name_cat) 
 *   VALUES('$name_cat');

 * INSERT INTO Sub_cat (Category_id, Weight_id) 
 *   VALUES(LAST_INSERT_ID(),v_weight_id,'$name_sub_cat');

 * COMMIT";





 * $weight=$_POST['batch_date'];
 * $name_sub_cat=$_POST['name_sub_cat'];
 * $name_cat=$_POST['site_location'];
 * //echo $weight;

 * if(!empty($_POST['batch_date'])AND !empty($_POST['name_sub_cat'])AND !empty($_POST['site_location']))
 * {
 * $sql_weight="INSERT INTO Weight(weight) Values('$weight')";
 * $result=add_db($sql_weight);

 * $we=mysql_insert_id();
 * //echo $we;
 * $sql_cat_read="SELECT * FROM Category";

 * $sql_cat="INSERT INTO Sub_cat(Category_id,Weight_id,Name_sub) Values('$name_cat','$we','$name_sub_cat')";

 * $result=add_db($sql_cat);
 * }
 */

/**
 * $result=add_db($sql_cat_read);
 *      while($rek=mysql_fetch_array($result))
 *      {
 *           
 *      }
 */




/*
$weight=0;
$name_sub_cat=0;
unset($weight);
unset($name_sub_cat);

echo "<form action='categories.php' method='POST'>";



echo "Category";

echo '<select name="site_location" size="1">';

for($z=0;$z<=$count_cat;$z++)
{
  echo '<option value="'.$origin[$z].'">'.$names[$z].'</option>';

}
echo '</select>';


 

//switched
echo '<input type="text" name="batch_date" value="'.htmlentities($weight).'">';
echo '<input type="text" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


echo '<input type="hidden" name="submitted" value="1" >';


echo "<input type='submit' name='Submit' value='Add an item to manifest' align='right'>";

 echo "</form>";
 echo "</table>";





*/


















//$result=add_db($sql_subcat);
//if($reult)
// echo "Dodano tranzakcje";


?>
<tr>


<td>

</td>

<td>

</td>
<td>

</td>
<td>

</td>

<td>

</td>
<td>

</td>

<td>

</td>

<td> 

</td>

<td>
 
</td>

<td> 

</td>

<td>

</td>

</tr>

</table>
</div> 

  
<div id="buttons_out"> 
  <h4>
  
  
 <p class="submit">  
      <a href="index.php"> <button class="submit">Return</button> </a> 
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->
    </p>  


</h4>       
</div>
<?php
/*
$sql = "SELECT *FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id";
$sql1= "SELECT name_cat,type_2 from Category";

$serwer="localhost";
$login="root";
$haslo="krasnal";
$baza="scm";
 
     

    if (mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza)) { 
         
        $wynik = mysql_query($sql1) 
        or die("Blad w zapytaniu!"); 
         
        mysql_close(); 
    } 
    else echo "Cannot Connect"; 



echo " <table border='1' > <tr><td>CATEGORY OF WEEE COLLECTED</td><td>WEIGHT (In Kg)</td></tr>";

$i=0;
while($rek = mysql_fetch_array($wynik,1)) { 
   $i++;  
   echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> ".$tab[$i]." </td></tr>"; 
}


//while($rek = mysql_fetch_array($wynik,1)) { 
  //  echo "<tr><td>".$rek["name_cat"]."</td><td> ".$rek["Name"]." </td><td>   ".$rek["Street"]."  </td><td> ".$rek["House"]." </td><td> ".$rek["Date_Sold"]."</td><td>".$rek["Price"]." �</td></tr><br />"; 
//} 
     echo "</table> "
*/

if(isset($_POST['cat_as_yes1']) )
{
    
  $weight=$_POST['was'];
  $cat=$_POST['site_location'];
  $assign_num=$_POST['assign_num_ac'];
  $name=$_POST['ass_cat'];
  $insert_sql="INSERT INTO item_has_cat(weight,cat,assign_nr,active,date,as_cat) VALUES('$weight','$cat','$assign_num','1',CURDATE(),'$name' )";
  mysql_query($insert_sql) or die(mysql_error());

if(isset($_SESSION['assign_number_dctv']))
{
    unset($_SESSION['assign_number_dctv']);
    echo "SESJION UNSET";
}
  
  redirect("active_weights.php",0);
 exit();
}





    
    
    for($i=0;$i<32;$i++)
    {
        $name="assign_num_de".$i;
        $name_sub="cat_as_yes2".$i;
    
    if(isset($_POST[$name_sub]) AND isset($_POST[$name]))
    {
        echo $_POST[$name];
        $assign_num=$_POST[$name];
    //assign number
    //$acv_item=$rek_active_w['Item_has_Cat_id_item_cat'];
    $sql_update_acv="UPDATE item_has_cat SET active='0' WHERE assign_nr='$assign_num' AND active=1";  //here only go thr 71 and second with 72 but spec this active
    $result_select_acv=mysql_query($sql_update_acv);
    //$rek_select_acv=mysql_fetch_array($result_select_acv);
    
    redirect("active_weights.php?CHG=".$assign_num,0);
 exit();
    
    }
   
    
    }
  /*  
    
    if(isset($_POST['assign_num_ac']))
    {
        $assign_num=$_POST['assign_num_ac'];
    //assign number
    //$acv_item=$rek_active_w['Item_has_Cat_id_item_cat'];
    $sql_update_acv="UPDATE item_has_cat SET active='1' WHERE assign_nr='$assign_num' AND active=0";  //here only go thr 71 and second with 72 but spec this active
    $result_select_acv=mysql_query($sql_update_acv);
    //$rek_select_acv=mysql_fetch_array($result_select_acv);
    }
*/
    
    
    
    
 //   $_SESSION['assign_number_dctv']=$assign_num;
    
    
       
    












































//redirect("active_weights.php",0);
//exit();

?>

</br></BR>
<?php
//<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>
</BODY>
</HTML>