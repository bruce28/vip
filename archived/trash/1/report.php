<?php
session_start();
include '../header_valid.php';
include 'db_config.php';



$_SESSION['quantity']=$_POST['quantity'];  //we store quantity in a sesion
$id_user=$_SESSION['id_user'];
$origin=$_POST['site_id'];
$date=$_POST['date1'];
//echo $date;
//echo $date;

// db connection set-up. Must be extracted
$connect=mysql_connect($serwer,$login,$haslo)
  or die(mysql_error());

mysql_select_db($baza);
/*
if(isset($_POST['Confirm']))
{
    unset($_SESSION['att_flag']);
}

*/
//check if manifest not send empty

$set_flag_not_empty=1;


if($_GET['att']!=1)
{    
    
for($i=0;$i<$_POST['in'];$i++)
{
    $quant="quantity".$i;
    //echo $quant;
    if($_POST[$quant]>0)
       $set_flag_not_empty=1;
    
}

if($set_flag_not_empty==0)
{
    redirect("index2.php",5);
    exit();
}

if(!isset($_POST['submitted']))
{   
    //redirect ("index2.php", 0);
    //exit();
    
}

}

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}



//if send back a att flag. This must been rewriten to post
if($_GET['att']==1)
{
echo "changing attr numbers";    
    echo "IN att";
    //improved to categories number. Limited only 17 categories. Shall be set up or increased.
    for($i=0;$i<18;$i++)
    {
      //name different att  
      $name='att'.$i;
      $del_name='del'.$i;  
    
     //each time takes different
     $att11=$_POST[$name];
     $del11=$_POST[$del_name];
    
     // echo $att11;
    //  echo $del11;
    
    if($att11>0 AND $del11>0)
    {
    //if att not empty than update it    
    $update="UPDATE delivery SET att_num='$att11' WHERE delivery_id='$del11'"; 
    
    $result=mysql_query($update)or die(mysql_error());
 //   echo $att11;
  //  echo $del11;
     //printf ("Updated records: %d\n", mysql_affected_rows());
    $_SESSION['att_flag']=1;
    }
    }
    //End of Att changing section.
    
    //finiscshin manifest counter
    $manif_reg=$_SESSION['manifest_idd'];
    $insert="Update manifest_counter SET finished=1 WHERE manifest_reg_idmanifest_reg='$manif_reg'";
    
    mysql_query($insert) or die(mysql_error());
    
    
    
    //There is a need to edit given att . Att categories are counted some where else. Good to have module that assignes att grups/organises them. eg.
    //att number is this this and that from categories. And give priorities counting.
    //let say if this category is a att number assignation and give the same numbers for the categories counted
    
    echo $site_unq_id=$_POST['site_unq_id'];
       $update="UPDATE manifest_reg SET siteid='$site_unq_id' WHERE idmanifest_reg='$manif_reg'";
        mysql_query($update)or die(mysql_error()); 
    
    
   //here we come back to main system since agin insert cannot be done I think
    redirect("index2.php?finished=1",0);
   // printf ("Updated records: %d\n", mysql_affected_rows());

    exit();
}
else //if this is not att assignation than. Keep saving subcategories quantities set
if(!isset($_POST['site_id'])OR empty($_POST['site_id']) OR $_POST['site_id']==0)
{
  echo "Device reseted. Please wait and confirm manifest one more time. Every detailes and quantities will be the same...";
  echo $_POST['site_id'];
 /*echo $site=$_SESSION['manifest_idd']-1;
  $select_site="SELECT * FROM manifest_reg WHERE idmanifest_reg='$site'";
  $res=mysql_query($select_site) or die(mysql_error());
  $rek_site=mysql_fetch_array($res);
  echo "BUG. DeBug ;)";
  echo $origin=$rek_site['siteid'];  
  $select_origin="SELECT * FROM site WHERE site_id='$origin'";
  $res_ori=mysql_query($select_origin);
  $rek_ori=  mysql_fetch_array($res_ori);
  echo $origin=$rek_ori['Origin_origin_id'];
   */
  $origin=$_SESSION['restore_site_id'];
   redirect("index2.php?restore=".$origin,10);
   
  exit();  
  //echo $origin=$_SESSION['restore_site_id'];
}





/**
 * if($_POST['$site_id'])
 * {
 *   echo "Please specify a site place 0";
 *   exit();  
 * }
 */



// GENERATOR
//echo $date;
$date1=str_replace('/','',$date);
//echo $date1;
//$origin=$_POST['site_id'];
 $rand=rand(10,1000);
$site_ref_num=$origin.$date1.rand(1000,10000).$rand;

/**
 * $wynik1 = mysql_query("SELECT * FROM Origin WHERE origin_id='$origin'")
 *     or die("Blad w zapytaniu!");  
 *    $rek=mysql_fetch_array($wynik1);
 *       
 */

//batch id algoritm must be here. Takes a set up from con file

                                                ///we change now for $date
$wynik = mysql_query("INSERT INTO site(Origin_origin_id,site_ref_number,Rep_Auth,Dest_Location,batch_date,batch_id,closed) VALUES('$origin','$site_ref_num','14','7932','$date','67','')")
    or die(mysql_error());  
     
   $last_id = mysql_insert_id();
   $wynik = mysql_query("SELECT * FROM site where site_id='$last_id'") 
        or die(mysql_error()); 
    while($rek = mysql_fetch_array($wynik,1)){ 
        echo $rek["site_id"];
        echo '</BR>';
        echo $comp_name;
        echo '</BR>';
        echo $name;
        echo '</BR>';
        echo $surname;
        echo '</BR>';
        echo $post;
        echo '</BR>';
        echo $town;
        echo '</BR>';
        
         $site_id=$rek["site_id"];
}


$in=$_POST['in'];

$tab = array();
//this tab is used to store quontity *weight of every category. Its send as POST
//this initiationmay be not neccesser. limitation, ll see what ll hapen
//for($z=0;$z<=100;$z++)
//   $tab[$z]=0;

for($i=1;$i<=$in;$i++)
{ 
  //$tab[$i]=0;   
	  //echo "</ BR></BR>"; 
  $idd="id".$i;
    //echo $_POST[$idd];
    //echo " "; 
  $name="quantity".$i; 
		//echo $_POST[$name];
    //echo " "; 
  $weight="weight".$i; 
    //echo $_POST[$weight];
    //echo " "; 
  $cat_id="cat_id".$i; 
    //echo $_POST[$cat_id];
  
	echo " "; 
  $sum_sub=$_POST[$name]*$_POST[$weight] ;
    //echo $sum_sub;
  $tab[$_POST[$cat_id]]+=$sum_sub; 
  
  $site=$_POST['site_id']; 
  $site=$site_id;
  
 // echo "Name in";
  //echo $_POST[$name];

	//echo $site;
   $insert1 = "INSERT INTO site_has_cat(Site_site_id, Sub_cat_id_c,quantity,sum_weight) VALUES ('$site','$_POST[$idd]','$_POST[$name]','$sum_sub')";
   
    
  mysql_query($insert1);
   //we init the site has category
   
   //echo $_POST[$idd];
  
  
  
  

        

}

?>
<HTML>
<HEAD>
    <link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">

<link rel="stylesheet" href="../layout.css " type="text/css">
<link rel="stylesheet" href="../form_cat.css " type="text/css">

    
</HEAD>
<BODY>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>

<IMG SRC="weee/weee_cor.jpg" WIDTH=800 HEIGHT=120>

<?php

$sql = "SELECT * FROM sub_cat INNER JOIN category ON category.id = sub_cat.category_id INNER JOIN weight ON weight.id = sub_cat.weight_id ";
$sql1= "SELECT name_cat,type_2 from category WHERE category.kind=1 ";

//shall not be here
$serwer="localhost";
$login="root";
$haslo="krasnal";
$baza="dbs3";
 
     

    if (mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza)) { 
         
        $wynik = mysql_query($sql1) 
        or die(mysql_error()); 
         
        mysql_close(); 
    } 
    else echo "Cannot Connect"; 



echo " <table border='1' > <tr><td>CATEGORY OF WEEE COLLECTED</td><td>WEIGHT (In Kg)</td><td>ATT Ref Number</td></tr>";

$att_num=1;
$i=0;

 mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);

$lda=0;
$sda=0;
$lda_s=0;
$sda_s=0;
$znacznik_formy=0;


$origin=$site_id;
while($rek = mysql_fetch_array($wynik,1)) {
     //while we get name of category and type
    $ATT=0;
    $i++;
    $del_id=0;
     $del_id_s=0;
       $del_id_l=0;
  $att_l=0;
 $att_s=0;

   if($i==1 OR $i==10) //LDA 
   {
     if($tab[$i]>0)
     {
       $lda+=$tab[$i];
       if($lda_l==0)
          //$ATT=1;
       $lda_l=1;   
      
         
     }
    }
    
    if($i>=2 AND $i<=9 ) //SDA 
    {
     if($tab[$i]>0)
     {
       $sda+=$tab[$i];
       if($sda_s==0)
         // $ATT=1;
       $sda_s=1;   
     }
    
   } 
    
   if($i==10 AND $lda>0) // LDA
   {
   
                   
        
    $insert="SELECT * FROM trans_category WHERE category_id='66'"; //LDA
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
    $ATT=1;
     $wei=$lda;
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
        
        $del_id_l=mysql_insert_id();
        $att_l=1;
    
        
        
   }
   
   
   
   if($i==9 AND $sda>0) /// SDA
   {
   
                   
        
    $insert="SELECT * FROM trans_category WHERE category_id='93'"; //SDA reuse
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
    $ATT=1;
    
    //checking weight of mobile phones
     $MOBILE="SELECT SUM(sum_weight) as mobile FROM site_has_cat WHERE Sub_cat_id_c='30' AND Site_site_id='$site_id'";
   $result_mobile=mysql_query($MOBILE) or die(mysql_error());
   $rek_mobile=mysql_fetch_array($result_mobile);
   
   $MOBILE_WEIGHT=$rek_mobile['mobile'];
   
     //$MOBILE_WEIGHT;
    
     $wei=($sda-$MOBILE_WEIGHT);
     $sda-=$MOBILE_WEIGHT;
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
    
        $del_id_s=mysql_insert_id();
           $att_s=1;
        
   }
    
   if($i==11) //TV's
   {
    $insert="SELECT * FROM trans_category WHERE category_id='TV'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
    
    $wei=$tab[$i];
    if($wei>0)
    {
    $ATT=1;
    
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
          
      $result = mysql_query($insert) 
        or die(mysql_error()); 
        
        $del_id=mysql_insert_id();
    
     }  
    
   }
   
   if($i==12) //Mobile
   {
    $insert="SELECT * FROM trans_category WHERE category_id='A2'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
    $wei=$tab[$i];
    if($wei>0)
    {
    $ATT=1;
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
       $del_id=mysql_insert_id();
       }
    
   }
   
      if($i==13) //CDs DVDs
   {
    $insert="SELECT * FROM trans_category WHERE category_id='A1'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
    
    $wei=$tab[$i];
    if($wei>0)
    {
    $ATT=1;
    
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
      $del_id=mysql_insert_id();
       
    }
   }
   
      if($i==14) // Toner printer
   {
    $insert="SELECT * FROM trans_category WHERE category_id='99'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
    
    $wei=$tab[$i]+$tab[17];
    if($wei>0)
    {
    $ATT=1;
    
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
        $del_id=mysql_insert_id();
       }
    
   }
   
      if($i==15) //Brick-a-brack
   {
    $insert="SELECT * FROM trans_category WHERE category_id='94'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
  
  $wei=$tab[$i];
    if($wei>0)
    {
    $ATT=1;
  
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
          $del_id=mysql_insert_id();
       }
    
   }
   
   if($i==16) //DSE, just classify as SDA
   {
    $insert="SELECT * FROM trans_category WHERE category_id='93'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];      
  
  $wei=$tab[$i];
    if($wei>0)
    {
    $ATT=1;
  
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
          $del_id=mysql_insert_id();
       }
    
   }
   //toners show
   
   
   
   //let's assign mobile att
   
      if($i==3) //Brick-a-brack
   {
    $insert="SELECT * FROM trans_category WHERE category_id='A2'";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
     $rek1=mysql_fetch_array($result);
       $trans_cat=$rek1["Category_id"];    
       
       //one more time take a weight before of main takin in 9th step
        $MOBILE="SELECT SUM(sum_weight) as mobile FROM site_has_cat WHERE Sub_cat_id_c='30' AND Site_site_id='$site_id'";
   $result_mobile=mysql_query($MOBILE) or die(mysql_error());
   $rek_mobile=mysql_fetch_array($result_mobile);
   
   $MOBILE_WEIGHT=$rek_mobile['mobile'];
  
  $wei=$MOBILE_WEIGHT;
    if($wei>0)
    {
    $ATT=1;
  
    mysql_connect($serwer, $login, $haslo) and mysql_select_db($baza);
    $insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,QNum,att_num,picker1) VALUES('$trans_cat','$origin','$date','$wei','$wei','$att_num','$id_user')";
    
      $result = mysql_query($insert) 
        or die(mysql_error()); 
          $del_id=mysql_insert_id();
       }
    
   }
   
   
   
   
   //LETS ask the database about few things
   
   $CRT="SELECT SUM(sum_weight) as crt FROM site_has_cat WHERE Sub_cat_id_c BETWEEN 2 AND 3 AND Site_site_id='$site_id'";
   $result_crt=mysql_query($CRT) or die(mysql_error());
   $rek_crt=mysql_fetch_array($result_crt);
   
   $CRT_WEIGHT=$rek_crt['crt'];
   
   
   //OUTPUT
    
    if($i==11)
      echo "</tr><td><b>OTHER CAT: TV</b></td><tr>";
      
     if($i==12)
      echo "</tr><td><b>OTHER CAT: Additional streams</b></td><tr>";  
   //$i++;  
  
   echo "<tr><td>Category ".$rek["type_2"].". ".$rek["name_cat"]."</td><td> ".$tab[$i]." </td>"; 
   
     
     
     if($ATT==1 OR $del_id_l>0 AND $att_l==1){ 
    if($znacznik_formy==0)
    { 
      echo "<form action='report.php?att=1' method='POST'>";  
      $znacznik_formy=1;
      echo $del_id;
      echo $del_id_s;
      echo $del_id_l;
      
     }
     
     if($att_l==1)
     {
        if($del_id_l>0) //just what if chage was del_id_l
        
        echo "<td><input name='att1' value='".$del_id_l."'></td>";
     echo "<td><input type='hidden' name='del1' value='".$del_id_l."'>LDA ATT: ".$lda."</td>";
        
       /**
 * $del_id=$del_id_s;
 *        
 *        if($del_id_l>0)
 *        $del_id=$del_id_l;
 * 
 */
        
     }
     else
     if($att_s==1)
     {
        if($del_id_s>0) //with this
        
        echo "<td><input name='att2' value='".$del_id_s."'></td>";
     echo "<td><input type='hidden' name='del2' value='".$del_id_s."'>SDA ATT: ".$sda."</td>";
     // echo "<td>Weee Reused Totals: ".$sda+$lda."</td>";   
     }
     else
     {
     echo "<td><input name='att".$i."' value='".$del_id."'></td>";
     echo "<td><input type='hidden' name='del".$i."' value='".$del_id."'></td>";
      //echo $del_id;
      //echo $del_id_s;
      //echo $del_id_l;
     
     }
   }
   
   
   
       echo "<td>Weee Reused Totals: ".$sda+$lda."</td>";
   
   
    if($i==11)
     {
         $flat_panels=$tab[$i];
        echo "<tr><td align='left'><b>* CRT:  </b></td><td> ".$CRT_WEIGHT." </td></tr>"; 
        echo "<tr><td align='left'><b>* Other Flat Panels: </b></td><td> ".($flat_panels-$CRT_WEIGHT)." </td>";    
        
     }
     
     if($i==14)
     {
            $flat_panels=$tab[17];
            if($flat_panels>0)
        echo "<tr><td style='text-align:left; margin-right:-20px;'><b>* Toner Inks</b></td><td> ".$flat_panels." </td></tr>"; 
        
         
     }
     if($i==3 AND $MOBILE_WEIGHT>0)
     {
         //lets show use wight of mobiles att
         echo "<td>Mobile ATT: ".$MOBILE_WEIGHT."</td>";
     }
     
  
       
   echo "</tr>"; 
}


//while($rek = mysql_fetch_array($wynik,1)) { 
  //  echo "<tr><td>".$rek["name_cat"]."</td><td> ".$rek["Name"]." </td><td>   ".$rek["Street"]."  </td><td> ".$rek["House"]." </td><td> ".$rek["Date_Sold"]."</td><td>".$rek["Price"]." �</td></tr><br />"; 
//} 
     echo "</table> ";
     //if($_SESSION['att_flag']==1)
     //echo "<input type='submit' name='confirm' value='Confirm' align='right'>";
echo "<table><tr><td></td><td align='right'>"; 

echo "<input type='hidden' name='site_unq_id' value='".$site_id."'>";

echo "<input type='submit' name='Submit' value='Add Ref Num' align='right' style='align:right;'></form>";
echo "</td><tr></table>";
?>
<br><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
<!--<a href="../index2.php">Return</a>-->
</BODY>
</HTML>