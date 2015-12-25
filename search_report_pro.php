<?php
session_start();
include 'header_fn.php';
include 'header_valid.php';
include 'dbs3_config.php';
if (empty($_POST['submitted'])) {
 ///  echo 'Test form not filled';
   $url="search_report.php";
   
		//	redirect($url,0); //1
        //    exit();
}

function dup_row($count)
{
 if($count="0")
   return 0;    
 else
 {
     
 }   
}
/**
 * function test_string($rek)
 * {
 * if($rek=='1')
 *   $result="Yes";
 *  else
 *   $result="No";
 * 	
 * 	return $result ;
 * }
 */
 
 function test_string($rek)
{
if($rek=='2')
{
   $result="N/A";
   return $result;    
}
if($rek=='1')
  $result="Yes";
 else
  $result="No";
	
	return $result ;
}

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql)or die(mysql_error()) ;
   
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

$date='2013-08-19';

/*
if($_GET["token"]==1)
{
  
$res_array=array();
$res_array_tested=array();
$res_wynik=array();
 
 $sql_date="SELECT * FROM Barcode
INNER JOIN Item ON Item.id_item= Barcode.Item_id_item
INNER JOIN Site ON Site.site_id=Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id
";  

$result=add_db($sql_date); 

while($rek=mysql_fetch_array($result,1))
{  $i++;
   $res_array[$i]=$rek["id_Barcode"];   
}


$sql_date="SELECT * FROM Test
INNER JOIN Barcode ON Test.Barcode_id_Barcode= Barcode.id_Barcode
INNER JOIN Item ON Item.id_item= Barcode.Item_id_item
INNER JOIN Site ON Site.site_id=Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id
";  


$result=add_db($sql_date); 

while($rek=mysql_fetch_array($result,1))
{  $i++;
   $res_array_tested[$i]=$rek["id_Barcode"];   
}

for($i=0;$i<200;$i++)
{
   for($j=0;$j<200;$j++) 
   {
     if($res_array[$i]==$res_array_tested[$j])
     {
       $res_array[$i]=0;  
     }   
   }
}


}
*/


$date_from=$_POST['date_from'];
$date_to=$_POST['date_to'];
$repairs=$_POST['repairs'];
$user=$_POST['user'];
$item=$_POST['item'];

$sql_date;
/*
if(isset($date_from) AND !isset($data_to))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Barcode.date="'.$date_from.'"';  
    
}
*/
//echo $repairs;
$sql_date="SELECT * FROM Test
INNER JOIN Barcode ON Test.Barcode_id_Barcode= Barcode.id_Barcode
INNER JOIN Item ON Item.id_item= Barcode.Item_id_item
INNER JOIN Site ON Site.site_id=Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id
";  

if(isset($date_from)AND isset($date_to) )
{
    
  $sql_date="SELECT * FROM Test
INNER JOIN Barcode ON Test.Barcode_id_Barcode= Barcode.id_Barcode
INNER JOIN Item ON Item.id_item= Barcode.Item_id_item
INNER JOIN Site ON Site.site_id=Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id
";  
    
 /* $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Test.state='.$repairs. ' AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.date';  */
         
   echo "1";
}

if(isset($date_from)AND isset($date_to) AND empty($user) AND empty($repairs))
{
  /*$sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Date';  
         */
    echo "0";
}

//category

if(isset($date_from)AND isset($date_to) AND empty($user) AND empty($repairs)AND !empty($item)AND isset($item))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Item.name="'.$item. '" AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.Date';  
  echo "4";
  echo $item;
}

//end category


if(isset($date_from)AND isset($date_to) AND isset($user)AND !empty($user))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Test.User_2_id_user='.$user. ' AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.Date';  
   echo "2";
}


if(isset($date_from)AND isset($date_to) AND isset($user)AND isset($repairs)AND !empty($user)AND !empty($repairs))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Test.User_2_id_user='.$user. ' AND Test.state='.$repairs. ' AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.Date';  
    echo "3";
}

if(isset($date_from)AND isset($date_to) AND isset($user)AND isset($repairs) AND !empty($user) AND !empty($repairs) AND isset($item) AND !empty($item))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Test.User_2_id_user='.$user. ' AND Test.state='.$repairs. ' AND Item.name="'.$item. '" AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.Date';  
    echo "6";
}

//works 


if(isset($date_from)AND isset($date_to) AND isset($user) AND empty($user) AND isset($repairs) AND !empty($repairs) AND isset($item) AND !empty($item))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Test.state='.$repairs. ' AND Item.name="'.$item. '" AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.Date';  
    echo "7";
}

if(isset($date_from)AND isset($date_to) AND isset($user) AND !empty($user) AND isset($repairs) AND empty($repairs) AND isset($item) AND !empty($item))
{
  $sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Test.User_2_id_user='.$user. ' AND Item.name="'.$item. '" AND Barcode.date BETWEEN' .'"'.$date_from.'" AND "'.$date_to.'" order by Test.Date';  
    echo "8";
}

/*
if(isset($date_to))
{
$sql_date='SELECT * FROM `Test`'
         . ' INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.Barcode'
         . ' INNER JOIN Pat ON Test.Pat_id_pat=Pat.id_pat '
         . ' INNER JOIN Visual ON Test.Visual_id_visual=Visual.id_visual'
         . ' INNER JOIN Functional ON Test.Functional_id_fun=Functional.id_fun'
         . ' INNER JOIN Cleaning ON Cleaning.id_clean=Test.Cleaning_id_clean '
         //. ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
         . ' INNER JOIN Item ON Barcode.Item_id_item=Item.id_item WHERE Barcode.date="'.$date_to.'"';
       // echo $sql;
}


*/


if($_GET["token"]==1)
{
  /*  $sql_date="SELECT * FROM Test
Right JOIN Barcode ON Test.Barcode_id_Barcode= Barcode.id_Barcode
WHERE Test.Barcode_id_Barcode is NULL";
    
 
for($i=0;$i<200;$i++)
  if($res_array!=0)
  {
     $sql_date.="id_Barcode='".$res_array[$i]." AND ";   
    
  }
*/


$sql_date="SELECT * FROM Test
Right JOIN Barcode ON Test.Barcode_id_Barcode= Barcode.id_Barcode
INNER JOIN Item ON Barcode.Item_id_item=Item.id_item
WHERE Test.Barcode_id_Barcode is NULL";
}  

/*
 $sql_date="SELECT * FROM Test
RIGHT INNER JOIN Barcode ON Test.Barcode_id_Barcode=Barcode.id_Barcode";   
*/

$result=add_db($sql_date);

/*

$tab = array();
for($z=0;$z<=100;$z++)
   $tab[$z]=0;

	 echo $barcode;
    //echo $_POST[$idd];
    //echo " "; 
  echo $pat ;
		//echo $_POST[$name];
    //echo " "; 
  
	 
	 $d=0;
for($i=1;$i<=10;$i++)
{ 

  $d++;
	
	$def_name="defect".$d;
  //$tab[$i]=0;   
	  echo "</ BR></BR>"; 
  
    //echo $_POST[$weight];
    //echo " "; 
  
    //echo $_POST[$cat_id];
  
	
	if(isset($_POST["$def_name"]))
	 if($_POST["$def_name"]=="1")
	 {
	  echo $d;
	   
	  
	  }
 
    //echo $sum_sub;
  //$tab[$_POST[$cat_id]]+=$sum_sub; 

 
	//echo $site;
	
	
}	
*/


/*

   $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`) VALUES ('0','$barcode','$pat', '$cln', '$fun', '$vis', '$rdy')"; 
	 
	 
	 
  echo mysql_query($insert1);
*/
    
		
		
		




?>
<HTML>
<HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
<link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script // src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
</HEAD>
<BODY>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>



		
<table border="1" style="width:100%">


<tr><td>Test</td><td>Barcode</td><td>Item</td><td>Item type</td><td>Brand</td><td>Part Number</td><td>Date Stocked</td><td>Visual state</td><td>PAT</td><td>Functionality</td>
<td>Cleaning</td><td>Formatted</td><td>Reinstallation</td><td>Cerrected Fuse</td><td>Ready</td><td>Date of Test</td><td>Site Reference Number</td>
<td>Company Name</td><td>Name</td><td>Surname</td><td>Street</td><td>Town</td><td>Post Code</td><td>Date of Collection</td></tr>
<?php

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
   


while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { 
   $i++;  
  // if($tab[$rek["id_test"]]<'1')
   //{
   echo '<tr><td>'.$rek[0].'</td><td>'.$rek["Barcode"].'</td>'; 
	 echo '<td>'.$rek["Item_id_item"].'</td>';
	 echo '<td>'.$rek["brand"].'</td>';
     echo '<td>'.$rek[28].'</td>';
     echo '<td>'.$rek["pn"].'</td>';
      echo '<td>'.$rek["date"].'</td>';
      echo '<td>'.test_string($rek["Visual_id_visual"]).'</td>';
	  echo '<td>'.test_string($rek["Pat_id_pat"]).'</td>';
	  echo '<td>'.test_string($rek["Functional_id_fun"]).'</td>';
		 echo '<td>'.test_string($rek["Cleaning_id_clean"]).'</td>';
		  echo '<td>'.test_string($rek["Formatted_id_form"]).'</td>';
          echo '<td>'.test_string($rek["Reinstallation_id_reinst"]).'</td>';
          echo '<td>'.test_string($rek["Fuse_id_fuse"]).'</td>';
			 echo '<td>'.test_string($rek["Ready"]).'</td>';
			   echo '<td>'.$rek[12].'</td>';
               echo '<td>'.$rek["site_ref_number"].'</td>';
               
echo '<td>'.$rek["company_name"].'</td>';
echo '<td>'.$rek["name"].'</td>';
echo '<td>'.$rek["surname"].'</td>';

//echo '<td>'.$rek["house_number"].'</td>';
echo '<td>'.$rek["street"].'</td>';
echo '<td>'.$rek["town"].'</td>';
echo '<td>'.$rek["post_code"].'</td>';

	 echo '<td>'.$rek["batch_date"].'</td>';
   
   
	 echo '</tr>';
     //}
  
	//  $tab[$rek["id_test"]]+=1;
}

?>


</table>
       <h4> <a href="index.php">Return</a> 
</h4>  

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