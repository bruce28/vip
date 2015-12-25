<?php
session_start();

include 'header_valid.php';

//fixing bug if form set once. Seems to solve problem. Item only doesnt apper on the bottom

if(isset($_POST['Submit']))
{
    redirect("revision.php",0);
    
}



function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
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
 else
  $result="No";
	
	return $result ;
}

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}

$barcode=$_POST['barcode'];
$item=$_POST['item'];
$brand=$_POST['brand'];
$serial=$_POST['serial'];
$pat=$_POST['pat'];
$fun=$_POST['fun'];
$cln=$_POST['cln'];
$vis=$_POST['vis'];
$defect=$_POST['defect'];
$rdy=$_POST['rdy'];

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

//$sql='SELECT * FROM Sub_cat'
         //. ' INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id'
  //       . ' INNER JOIN Weight ON Weight.id=Sub_cat.Weight_id'
    //     . ' INNER JOIN Category ON Category.id=Sub_cat.Category_id';
        

$sql='SELECT * FROM Category';

$result=add_db($sql);


    
    
$sql_cat_read="SELECT * FROM Category";
//$sql_cat="INSERT INTO Weight(weight) Values('$weight')";

$result_sub=add_db($sql_cat_read);    
$count_cat=0;		
while($rek1 = mysql_fetch_array($result_sub,1))  
   {
     $i++; 
     $count_cat++;
    // $users[$i]=$rek["post_code"];    
     $names[$i]=$rek1["Name_cat"];
     $origin[$i]=$rek1["id"];
     //$batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }
  /// echo "Nie ustalono site place ani zmienna ani przekazanie";		
		

$weight=$_POST["batch_date"];
$name_sub_cat=$_POST['name_sub_cat'];
$name_cat=$_POST['site_location'];


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
</BR></BR>

<div id="tabel_wrap_out"></BR>
    </br>
    <center><p style=""><h3>Categories Revision</h3></p></center>
    </br>
    
    
<table id="tabel_out" border="1"  >


<tr><td>Category Description</td><td>Category</td><td>Cat. Name New</td></tr>
<?php

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;

while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
   //echo '<tr><td>'.$rek["Name_sub"].'</td>'; 
	// echo '<td>'.$rek["kind"].'</td>';
	 //echo '<td>'.$rek["weight"].'</td>';
	 echo '<td>'.$rek["name_cat"].'</td>';
	   echo '<td>'.$rek["id"].'.</td>';
           $name_sub_cat=$rek['id'];
           echo '<td> <form action="revision.php" method="POST"><input style="padding:10px;margin:10px" type="text" placeholder="New Category description.." name="batch_date" value="'.htmlentities($weight).'">';
echo '<input style="padding:10px;margin:10px" type="hidden" placeholder="Item type" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


echo '<input type="hidden" name="submitted" value="1" >';


echo "<input style='padding:10px;margin:10px' type='submit' name='Submit' value='Revise' align='right'>";

 echo "</form></td>";  	
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</tr>';
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}



$add_new=1;
if($add_new==1)
{
    
    
    
    
    //echo "w funkcji";
$sql='INSERT INTO Sub_cat'
         //. ' INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id'
         . ' INNER JOIN Weight ON Weight.id=Sub_cat.Weight_id'
         . ' INNER JOIN Category ON Category.id=Sub_cat.Category_id';

//$weight=$batch_date;
$name_cat;
$name_sub_cat;


$sql_transaction="BEGIN
INSERT INTO Weight(weight) 
  VALUES('$weight');
  set v_weight_id = last_insert_id();
INSERT INTO Category (name_cat) 
  VALUES('$name_cat');

INSERT INTO Sub_cat (Category_id, Weight_id) 
  VALUES(LAST_INSERT_ID(),v_weight_id,'$name_sub_cat');

COMMIT";





$weight=$_POST['batch_date'];
//Category
$name_sub_cat=$_POST['name_sub_cat'];
$name_cat=$_POST['site_location'];

$category=$_POST['category'];
//echo $weight;
//echo $category;
if(!empty($category))
{  
    echo $category;
$sql_weight="INSERT INTO category(type_2,name_cat) Values('0','$category')";
$result=add_db($sql_weight);

//$we=mysql_insert_id();
//echo $we;
//$sql_cat_read="SELECT * FROM Category";

//$sql_cat="INSERT INTO Sub_cat(Category_id,Weight_id,Name_sub) Values('$name_cat','$we','$name_sub_cat')";

//$result=add_db($sql_cat);
}



}    


//AND !empty($_POST['name_sub_cat'])
if(!empty($_POST['batch_date']))
{
    
    echo $name_sub_cat;
$sql_weight="Update category SET name_cat='$weight' WHERE id='$name_sub_cat'";
$result=add_db($sql_weight) or die(mysql_error());

$we=mysql_insert_id();
//echo $we;
$sql_cat_read="SELECT * FROM Category";

//$sql_cat="INSERT INTO Sub_cat(Category_id,Weight_id,Name_sub) Values('$name_cat','$we','$name_sub_cat')";

//$result=add_db($sql_cat);
}

/**
 * $result=add_db($sql_cat_read);
 *      while($rek=mysql_fetch_array($result))
 *      {
 *           
 *      }
 */


$weight=0;
$name_sub_cat=0;
unset($weight);
unset($name_sub_cat);

///A place for code of categories
























//$result=add_db($sql_subcat);
//if($result)
// echo "Dodano tranzakcje";


?>


</table>
    </BR>
    
    
    
 <?php
echo "<center><form action='revision.php' method='POST'>";



echo "New Category";

echo '<input style="padding:10px;margin:10px" type="text" placeholder="category name..." name="category" value="">';

/* for($z=0;$z<=$count_cat;$z++)
{
  echo '<option value="'.$origin[$z].'">'.$names[$z].'</option>';

}
echo '</select>';
*/
 

//switched
//echo '<input style="padding:10px;margin:10px" type="text" placeholder="Weight" name="batch_date" value="'.htmlentities($weight).'">';
//echo '<input style="padding:10px;margin:10px" type="text" placeholder="Item type" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


//echo '<input type="hidden" name="submitted" value="1" >';


echo "<input style='padding:10px;margin:10px' type='submit' name='Submit' value='Create Category' align='right'>";

 echo "</form>";
 echo "</table></center>"; 

 //fixing bug - no infinit loop
 //redirect("categories.php",0);
 
?>   
        
    
    
    
    
    
    
    
    
    
    
    
    
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
?>
<br><BR>
<?php
//<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>
</BODY>
</HTML>