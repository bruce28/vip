<?php
session_start();
include 'header_valid.php';
include 'dbs3_config.php';

//Lets set variable for one site id

$PREVIOUS_SITE=0;
$FLAG_RESET=0;




//here we set a function that takes a row and czecks this id site with previous if the same keep the flag counter if different reset the counter

function check_previous_site($current_site)
{
  global $PREVIOUS_SITE;
  global $FLAG_RESET;
  if($current_site==$PREVIOUS_SITE)
  { //in that case if comparison done
    ;  
      
  }  
 else {
    $FLAG_RESET=1;  
    $PREVIOUS_SITE=$current_site;
  }
  
    
}

function cat_convert_tv($input)
{
    
    return $output;
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
	 
	 
   $result=mysql_query($sql)or die(mysql_error());
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

$sql='SELECT * FROM `Delivery`'
         . ' INNER JOIN Site ON Site.site_id=Delivery.Site_site_id'
         . ' INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id'
         . ' INNER JOIN Trans_Category ON Delivery.Trans_Category_Category_id=Trans_Category.Category_id ' // modify so hide the incorrect atts
         . ' INNER JOIN Source ON Origin.Source_source_id=Source.source_id WHERE QtyPickedUP>0 AND delivery.closed!=1 AND delivery.closed!=2 ORDER BY date, delivery_id ';
       //  . ' INNER JOIN Site_has_Cat ON Site_has_Cat.Site_site_id= Site.site_id'
         //. ' INNER JOIN Sub_cat ON Site_has_Cat.Sub_cat_id_c= Sub_cat.id_c' 
        // . ' WHERE Delivery.date BETWEEN "2013-10-08" AND "2013-10-08" AND Delivery.att_num="1"';
        // . ' INNER JOIN Defect ON Test.id_test=Defect.Test_id_test'
        // . WHERE Test.Ready=0 Order by Test.date';
        

$result=add_db($sql);


//we get att weee-reused weight sum


$weee_reuse="SELECT SUM(QtyPickedUP) as weee_reuse,Trans_Category_Category_id,site_id FROM Delivery
INNER JOIN Site ON Site.site_id=Delivery.Site_site_id
INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id
INNER JOIN Trans_Category ON Delivery.Trans_Category_Category_id=Trans_Category.Category_id 
INNER JOIN Source ON Origin.Source_source_id=Source.source_id WHERE (Trans_Category_Category_id='66' OR Trans_Category_Category_id='93') GROUP BY Site_site_id  ORDER BY date, delivery_id ";


//$result_wee=mysql_query($weee_reuse);



//EBD of wee reuse
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

<link rel="stylesheet" href="layout.css " type="text/css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
<link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">

</HEAD>
<BODY>

<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</BR></BR></BR>
</div>






<div id="tabel_wrap_out"></BR></BR></BR>	
<table id="tabel_out" border="1"  >


<tr><td>BatchID</td><td>BatchDateDAT</td><td>ReportingAuth</td><td>TransactionCat</td></td><td>Stream</td><td>TransactionDate</td><td>TransactionRef</td><td>QtyNUM</td><td>QtyUOMT</td>
<td>SourceLocationID</td><td>SiteID</td><td>Destination Location</td><td>Notes</td></tr>
<?php
$notes=0;
$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
$flag_counter=0;
while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //here we initialise the first site id
   
   if($i==0)
   {
     $PREVIOUS_SITE=$rek['Site_site_id'];  
     $FLAG_RESET=1;
     
   }
 else {
     $current_site=$rek['Site_site_id'];
       check_previous_site($current_site);
   }
   
   //if($tab[$rek["id_test"]]<'1')
   //{
   // echo "<tr>";
 /*
   if(($i%2)==0)  //reseting a counter every two rows, this must be reseted with every new site
      $flag_counter=0;
   */
   
   if($FLAG_RESET==1)
   {
          $flag_counter=0; 
          $FLAG_RESET=0;
   }
  if($rek["Trans_Category_Category_id"]=='66' OR $rek["Trans_Category_Category_id"]=='93')
  {
      if($rek["Trans_Category_Category_id"]=='66')
          $flag_counter++;
      if($rek["Trans_Category_Category_id"]=='93')
          $flag_counter++;
      if($flag_counter==1)
      {
          //$flag_counter=2;
      $weee_reuse="SELECT SUM(QtyPickedUP) as weee_reuse,Trans_Category_Category_id,Site_site_id,batch_id,Rep_Auth,name_1,date,att_num,Source_source_id,town_name,Dest_Location FROM Delivery
INNER JOIN Site ON Site.site_id=Delivery.Site_site_id
INNER JOIN Origin ON Origin.origin_id= Site.Origin_origin_id
INNER JOIN Trans_Category ON Delivery.Trans_Category_Category_id=Trans_Category.Category_id 
INNER JOIN Source ON Origin.Source_source_id=Source.source_id WHERE (Trans_Category_Category_id='66' OR Trans_Category_Category_id='93') AND Site_site_id='";
      $weee_reuse.=$rek['Site_site_id'];
      $weee_reuse.="' GROUP BY Site_site_id  ORDER BY date, delivery_id"; 
      $result_weee=mysql_query($weee_reuse)or die(mysql_error());
      $rek_weee=mysql_fetch_array($result_weee);
      //echo $rek_weee['Site_site_id'];
      //echo $rek_weee['weee_reuse'];
      
      //here we double the original code
      $batch_date_id='2014-01-31';
   
   if($rek_weee['batch_id']==62)
       $batch_date_id='2014-02-28';
   
   if($rek_weee['batch_id']==63)
       $batch_date_id='2014-03-31';
   if($rek_weee['batch_id']==64)
       $batch_date_id='2014-04-30';
   if($rek_weee['batch_id']==65)
       $batch_date_id='2014-05-31';
    if($rek_weee['batch_id']==66)
       $batch_date_id='2014-06-30';
   if($rek_weee['batch_id']==67)
       $batch_date_id='2014-07-31';
     if($rek_weee['batch_id']==68)
       $batch_date_id='2014-08-31';
    if($rek_weee['batch_id']==69)
       $batch_date_id='2014-09-30';
    if($rek_weee['batch_id']==70)
       $batch_date_id='2014-10-31';
    
   //$rek["batch_date"];
   //if(strlen($rek_weee["att_num"])!=6)
       echo "<tr bgcolor='red'>";
  // echo "<tr>";
       //echo "wwl";
   echo '<td>'.$rek_weee["batch_id"].'</td><td>'.$batch_date_id.'</td>'; 
	 echo '<td>'.$rek_weee["Rep_Auth"].'</td>';
          
         if($rek['Trans_Category_Category_id']=="TV")
         {
            // $trans_c=$rek["Trans_Category_Category_id"];
              $trans_c="93";
           //  $stream=$rek["name_1"];
             $stream="SDA";
         echo '<td>'.$trans_c.'</td>'; 
         }
         else
             echo '<td>'.$rek_weee["Trans_Category_Category_id"].'</td>';
         
         if($rek['name_1']=="TV")
         {
            // $trans_c=$rek["Trans_Category_Category_id"];
            
           //  $stream=$rek["name_1"];
             $stream="SDA";
           echo '<td>'.$stream.'</td>';
         $notes=1;
         }
         else
             echo '<td>'."REUSE".'</td>'; // $rek_weee["name_1"]
         
	//here we connect sda with lda
         
       // if($rek['Trans_Category_Category_id']=="93")
      
         
         echo '<td>'.$rek_weee["date"].'</td>';
       echo '<td>'.$rek_weee["att_num"].'</td>';
        //$ar=around($rek_weee["weee_reuse"],2);
	 echo '<td>'.round($rek_weee["weee_reuse"],2).'</td>';
      echo '<td> KGS </td>';
       echo '<td>'.$rek_weee["Source_source_id"].'</td>';
        echo '<td>'.$rek_weee["town_name"].'</td>';
         echo '<td>'.$rek_weee["Dest_Location"].'</td>';
         echo '</tr>'; //not there
      
      }
  }
      else  //if else just print telies TAG
      {
   
   $batch_date_id='2014-01-31';
   
   if($rek['batch_id']==62)
       $batch_date_id='2014-02-28';
   
   if($rek['batch_id']==63)
       $batch_date_id='2014-03-31';
   if($rek['batch_id']==64)
       $batch_date_id='2014-04-30';
   if($rek_weee['batch_id']==65)
       $batch_date_id='2014-05-31';
   if($rek_weee['batch_id']==66)
       $batch_date_id='2014-06-30';
    if($rek_weee['batch_id']==67)
       $batch_date_id='2014-07-31';
      if($rek_weee['batch_id']==68)
       $batch_date_id='2014-08-31';
      if($rek_weee['batch_id']==69)
       $batch_date_id='2014-09-30';
         if($rek_weee['batch_id']==70)
       $batch_date_id='2014-10-31';
   //$rek["batch_date"];
    // echo "<tr bgcolor='red'>";
   echo '<tr><td>'.$rek["batch_id"].'</td><td>'.$batch_date_id.'</td>'; 
	 echo '<td>'.$rek["Rep_Auth"].'</td>';
          
         if($rek['Trans_Category_Category_id']=="TV")
         {
            // $trans_c=$rek["Trans_Category_Category_id"];
              $trans_c="93";
           //  $stream=$rek["name_1"];
             $stream="SDA";
         echo '<td>'.$trans_c.'</td>'; 
         }
         else
             echo '<td>'.$rek["Trans_Category_Category_id"].'</td>';
         
         if($rek['name_1']=="TV")
         {
            // $trans_c=$rek["Trans_Category_Category_id"];
            
           //  $stream=$rek["name_1"];
             $stream="SDA";
           echo '<td>'.$stream.'</td>';
         $notes=1;
         }
         else
             echo '<td>'.$rek["name_1"].'</td>';
         
	//here we connect sda with lda
         
       // if($rek['Trans_Category_Category_id']=="93")
      
         
         echo '<td>'.$rek["date"].'</td>';
       echo '<td>'.$rek["att_num"].'</td>';
	 echo '<td>'.$rek["QtyPickedUp"].'</td>';
      echo '<td> KGS </td>';
       echo '<td>'.$rek["Source_source_id"].'</td>';
        echo '<td>'.$rek["town_name"].'</td>';
         echo '<td>'.$rek["Dest_Location"].'</td>';

         if($notes==1)
             echo '<td>DSE</td></tr>';
         $notes=0;    
 }         
}	


?>

</table>
    </BR></BR>
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