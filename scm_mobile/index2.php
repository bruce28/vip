<?php
session_start();
include '../header_valid.php';
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include '../header.php';
include 'manifest_config.php';
include 'db_config.php';

$PLAY_SOUND_FLAG=0;

$site_id=$_POST['site_id'];

$_SESSION['manifest_number'];
 echo $id_manif_count=$_SESSION['manifest_idd']; 

$_SESSION['last_insert_row'];
$_SESSION['last_qtty']; 
 //START


if(isset($_GET['restore']))
{
    $origin=$_SESSION['restore_site_id'];
    
}


 function show_site()
{
global $serwer;
global $login;
global $haslo;
global $baza;
     
mysql_connect($serwer, $login, $haslo);
mysql_select_db($baza);

$last_item=$_SESSION['last_insert_row'];
$sql_select="SELECT * FROM sub_cat WHERE id_c='$last_item'";
    

$result=mysql_query($sql_select);
if(!$result)
echo mysql_error();

while($rek=mysql_fetch_array($result))
{
//echo "<table>";    
echo "<tr><td>DONE: ";
 //echo $rek["id_c"];
  //echo "</td><td>";
//echo $rek["Category_id"];
//echo "</td><td>";  
//echo $rek["Weight_id"];
  //echo "sdfsdf";
echo "</td><td><b>";   
echo $rek["Name_sub"];
 echo "</b></td><td>";
 //echo $rek["kind"];
  
  
 echo "</td><td><b>QTTY: ";
 //echo $rek["town"];
  echo $_SESSION['last_qtty'];
  echo "</b></td><td>";
 
  //$postal_code = strtoupper (str_replace(' ', '', $postal_code));
  //echo $rek["Source_source_id"];
 // echo $last_item;
  echo "</td><td>";
//echo $rek["town_name"];
//echo "</td><td>";
// echo $email=$rek['email'];
 //echo "</td><td>";
 
 // echo $phone=$rek['phone']; 
    echo "</td></tr>";
  
  
  
 } 
 
 mysql_free_result($result);
 mysql_close($db);
  
  
    
    
}
 
 
 //END show user
 
function select_sub_cat($id,$id_manif_count)
{
    
  // echo $id_manif_count;
 //echo $id_manif_count;   
 // AND id_manifest_counter='$id_manif_count'
  $select="SELECT * FROM manifest_counter Where sub_cat='$id' AND manifest_reg_idmanifest_reg='$id_manif_count'";
  $result=mysql_query($select)or die(mysql_error());
  while($rek=mysql_fetch_array($result))
  {
     //if($rek['manifest_counter']!=0) 
    $result_quant=$rek['manifest_counter'];   
    // echo $rek['manifest_counter'];
  }
    return $result_quant;
}

mysql_connect($serwer, $login, $haslo);
mysql_select_db($baza);


function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


function get_start_dbs($id)
{
    $SELECT="SELECT * FROM manifest_reg WHERE idmanifest_reg='$id'";
    $result=mysql_query($SELECT);
    $rek=mysql_fetch_array($result);
    return $rek['start_dbs'];
}
    



function get_site_unq_id($siteid)
{
   $select="SELECT * FROM site WHERE site_id='$siteid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
 
    return $rek['site_ref_number'];
}



/*
function play_sound_beep()
{
    $file='beep1.mp3';
    echo "<embed src =\"$file\" hidden=\"true\" autostart=\"true\"></embed>";
    
}
*/













//here will be a code for addin plus/minus











for($i=0;$i<$_POST['in'];$i++)
{
    $add_name="add".$i;
    $name_sub_cat="id".$i; 
if(isset($_POST[$add_name]))
{
    echo "added one pice";
   // echo $quantity;
    $name_quantity="quantity".$i;
    $quantity=$_POST[$name_quantity];
    $quant=select_sub_cat($i,$id_manif_count);
    $quantity+=$quant;
    //echo $quantity=$quantity;
    $insert="UPDATE manifest_counter SET manifest_counter='$quantity' WHERE sub_cat='$i'";
    mysql_query($insert) or die(mysql_error());
}

$add_plus="plus".$i;
if(isset($_POST[$add_plus]))
{
    //We are trying get unique sub cat not a counter i
    $val_sub_cat=$_POST[$name_sub_cat];
   
    //echo '<embed height="50" width="100" src="../beep/beep1.mp3" hidden="true">'; 
    //echo '<video src="../beep/beep1.mp3" onclick="this.play();"></video>';
    echo "increased";
   // echo $quantity;
    $id_manif_count=$_SESSION['manifest_idd'];
    echo $id_manif_count;
    $quantity=$_POST[$add_plus];
    $quantity=select_sub_cat($i, $id_manif_count);
    echo $quantity;
    $quantity+=1;
    /*if($quantity=='quantity1' AND $add_plus!=1)
        $quantity-=1;*/
    
   // if($_POST['plus1'])
    
    //Now standard update modify exactly the umber of sub cat. Let's change it with actuall value number of sub category
    $val_sub_cat=$_POST[$name_sub_cat];
     // echo "<BR/>Manifest sub_cat: ".$manifest_sub_cat=$_POST['name_sub_cat'];
    //apparently the was no condition of particular manif ref id before
    $insert="UPDATE manifest_counter SET manifest_counter='$quantity' WHERE sub_cat='$i' AND manifest_reg_idmanifest_reg='$id_manif_count'";
    //$insert_sub_cat="UPDATE manifest_counter SET manifest_sub_cat='$manifest_sub_cat' WHERE sub_cat='$i' AND manifest_reg_idmanifest_reg='$id_manif_count'";
    $result=mysql_query($insert) or die(mysql_error());
    //$result=mysql_query($insert_sub_cat) or die(mysql_error());
    echo $name_quantity="quantity".$i;
    if($result)
    { 
      $sub_ccat=$_POST[$name_sub_cat];  
      $_SESSION['last_insert_row']=$sub_ccat;  
      $_SESSION['last_qtty']=1;
     
      //lets play sound
      
     $PLAY_SOUND_FLAG=1;
   
      
    } 
    else
    {
       $_SESSION['last_insert_row']=0;
       $_SESSION['last_qtty']=0;
    }
    if(isset($_POST[$name_quantity])AND !empty($_POST[$name_quantity]) )
    {
       echo "dodano ".$_POST[$name_quantity]; 
       
       //$name_quantity="quantity".$i;
    $quantity=$_POST[$name_quantity];
    $quant=select_sub_cat($i,$id_manif_count);
    $quantity+=$quant;
    $quantity-=1;
    //echo $quantity=$quantity;
    $insert="UPDATE manifest_counter SET manifest_counter='$quantity' WHERE sub_cat='$i' AND manifest_reg_idmanifest_reg='$id_manif_count'";
    $result=mysql_query($insert) or die(mysql_error());
    if($result)
    { 
      $sub_ccat=$_POST[$name_sub_cat];  
      $_SESSION['last_insert_row']=$sub_ccat;  
      $_SESSION['last_qtty']=$quantity;
    } 
    else
    {
       $_SESSION['last_insert_row']=0;
       $_SESSION['last_qtty']=0;
    }
       
    }
    
    
}


$add_minus="minus".$i;
if(isset($_POST[$add_minus]))
{
    echo "decreased";
   // echo $quantity;
    $id_manif_count=$_SESSION['manifest_idd'];
    echo $id_manif_count;
    $quantity=$_POST[$add_minus];
    $quantity=select_sub_cat($i, $id_manif_count);
    echo $quantity;
    if($quantity==0)
    {
        
    }
    else {
    $quantity-=1;
    $insert="UPDATE manifest_counter SET manifest_counter='$quantity' WHERE sub_cat='$i'";
    $result=mysql_query($insert) or die(mysql_error());
    if($result)
    {
        $_SESSION['last_insert_row']=0;
       $_SESSION['last_qtty']=0;
    }
    }
}

}



//play_sound_beep();



?>
<HTML>
<HEAD>
    <script src="js/jquery-1.10.2.min.js"></script>
<script src="js/ion.sound.js"></script>

<!--
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
-->
    <title>GRR COLLECTION SYSTEM</title>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

   <script>
    function closeWindow() {
        window.open('','_parent','');
        window.close();
    }
</script>  

<script type="text/javascript">
function sound_tab()
{
    $(document).ready(function(){

        $.ionSound({
            sounds: [
                "beer_can_opening",
                "bell_ring",
                "branch_break",
                "water_droplet"
            ],
            path: "sounds/",
            multiPlay: true,
            volume: "1.0"
        });

      
            $.ionSound.play("beer_can_opening");
       
       //window.alert("QTTY LOADED");
            //$.ionSound.play("bell_ring");
     window.jAlert('This is a custom alert box', 'Alert Dialog');

    });
}
</script>;  
    
    



<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->    
<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">
<link rel="stylesheet" href="form.css" type="text/css">

<!--<link rel="stylesheet" href="../layout.css " type="text/css">-->
<!--<link rel="stylesheet" href="../form_cat.css " type="text/css">-->


<link rel="stylesheet" href="newcss.css " type="text/css">

<!--<link rel="stylesheet" type="text/css" href="../csshorizontalmenu.css" />

<script type="text/javascript" src="../csshorizontalmenu.js">



</script>-->
<script>
 function scrollIntoView(eleID) {
   var e = document.getElementById(eleID);
   if (!!e && e.scrollIntoView) {
       e.scrollIntoView();
   }
}
</script>



 

</HEAD>
<BODY >







 <table border="2" style="table-layout:fixed;width:100%;marign:0px;padding: 0px;"><tr>
<td>
<h2> GRR Database System 2: </h2>
</td>
</tr>
<tr><td>
<H4>Visit Site Code: </H4> 


<?php


if($_GET['finished']==1)
{
    unset($_SESSION['restore_site_id']);
    //get the number of items collected
    
    $number="SELECT SUM(manifest_counter) as num FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$id_manif_count'";
    $result=mysql_query($number);
    $rek_num=mysql_fetch_array($result);
    $num=$rek_num['num'];
    
    
    echo "Your Manifest has been rised successfuly. There are detailed informations:";
      
    //we take details from 3 tables
    $SELECT="SELECT * FROM manifest_reg WHERE idmanifest_reg='$id_manif_count'";
    echo $id_manif_count;
    $result=mysql_query($SELECT);
   
      
    
    while($rek=mysql_fetch_array($result))
    {
        echo '<BR />Manifest ID: '.$rek['idmanifest_reg'];
        echo '<BR />Manifest Unique Number: '.$rek['manifest_unq_num'];
        echo '<BR />Manifest rised on: '.$rek['date_manifest'];
        echo '<BR />Yours Picker ID is: '.$rek['driver_num'];
        echo '<BR />Site ID: '.$rek['siteid'];
        echo '<BR /> A new updated site ID is: '.$rek['siteid'];
        echo '<BR /> Site Unique reference Number is: '.get_site_unq_id($rek['siteid']);
        echo '<BR/><BR />Vehicle Registration details are: ';
        
        echo '<BR/><BR/>You have started yours stickers at: '.$rek['start_dbs'];
        echo '<BR/>Collecting '.$num.' items';
        echo '<BR/>You shall use following stickers :<BR /><BR />';
         $pre_increment =  substr($rek['start_dbs'],0,10);
        $post_inc=substr($rek['start_dbs'],10,12);
        for($i=0;$i<$num;$i++)
        {
            echo '<BR />';
            //$pre_increment=array();
            
             
            echo $pre_increment++; 
            echo $post_inc;
            /*$prefix=$rek['start_dbs'];
            $pre_prefix=array();
            for($i=0;$i<9;$i++)
            {
                $pre_prefix[$i]=$prefix[$i];
              
            }
            echo $pre_prefix++;*/
            
            //echo $pre_increment++;
            //$pre_increment++;
            //$pre_increment+=substr($rek['start_dbs'],10);
            //echo $pre_increment;
          //echo $rek['start_dbs']++; 
            
        }
        echo '<BR /><BR /> Make sure that your last sticker is as following: ';
        echo 'Or specify new ending range<BR />';
        
        if(isset($rek['end_dbs'])) 
        { 
            echo '<BR /> New last sticker defined <BR />';
            echo $rek['end_dbs'];
        }
            
        }
    
    
    
    echo "<BR /><form action='index2.php?finished=1' method='POST'>";
    echo "<input type='text' name='end_sticker'>";
    echo "<input type='submit' name='sticker' value='SET'>";
    echo "</form>";
    
    
    
    if(isset($_POST['end_sticker']))
    {
        $end_sticker=$_POST['end_sticker'];
        $update="UPDATE manifest_reg SET end_dbs='$end_sticker' WHERE idmanifest_reg='$id_manif_count'";
        mysql_query($update)or die(mysql_error());
        
    }
    
    echo $rek['end_dbs'];
    
    
    echo '<a href="javascript:closeWindow();">Shut down</a>';
    
    echo "<BR /><form action='index2.php?finished=1' method='POST'>";
   
    echo "<input type='submit' name='finish' value='Finish'>";
    echo "</form>";
    
    if(isset($_POST['finish']))
    {
        session_unset();
        redirect('index.php',0);
        exit(0);    
        
    }
    echo "</table>";
}
 else {



//F8F8F8  F0F0F0 #E0E0E0


?>



<?php



        
if(!empty($_POST['location']))
$loca=trim($_POST['location']);
echo $loca;

   
   if(!empty($loca)){ 
    $flag_s=0;
    $wynik1 = mysql_query("SELECT * FROM origin WHERE post_code='$loca'");
         
         while($rek1=mysql_fetch_array($wynik1)){
            $origin=$rek1["origin_id"];
            $comp_name=$rek1['company_name'];
            $post=$rek1['post_code'];
            $name=$rek1['name'];
            $surname=$rek1['surname'];
            $town=$rek1['town'];
            
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
          
         $flag_s=1;
   	  echo "<a href='site.php'> (Change Location) </a>";
            
            }
            
            if($flag_s!=1)
            {
                echo "Not Specified"; 
	         	echo "<a href='site.php'> (SPECIFY) </a>";
             }  
           
    
  /**
 *  $wynik = mysql_query("INSERT INTO Site(Origin_origin_id,site_ref_number,Rep_Auth,Dest_Location,batch_date,batch_id) VALUES($origin,'','14','7932',now(),'')")
 *    or die("Blad w zapytaniu!"); 
 */
   }
   else {
    echo "Not Specified"; 
		echo "<a href='site.php'> (SPECIFY) </a>";
   
	 }
    
         if(!empty($origin))
         {
             
         
         $site_id=$origin;
         echo $site_id;
         }
         

  //else echo "Nie moge polaczyc sie z baza danych!"; 


?>

</td></tr><tr><td>
<?php if($_POST['confirmation_manifest']!=1) : ?>
<?php 


//we take manifest fields from sub_categories set up   
    $wynik = mysql_query("SELECT * FROM sub_cat INNER JOIN category ON category.id = sub_cat.category_id INNER JOIN weight ON weight.id = sub_cat.Weight_id WHERE sub_cat.kind=2 ORDER BY name_sub ASC ") 
        or die(mysql_error()); 
         
     
    
    
    
    if(isset($_POST['date_op']) AND !empty($_POST['date_op']))
    {
        $date1=$_POST['date_op'];
    }
    else
    {
       //$date1 = date('m/d/Y h:i:s a', time());
       $date1= date('y/m/d');
        
    }
    echo $date1;
   
    
        
    if(!isset($_POST['submitted'])OR !isset($_POST['Confirm']))
    {
        
        //if manifest number in session is set than do this
       if(isset($_SESSION['manifest_number']))
       {}
       else
       {
           $token=rand(1000,10000);
           //generate the unique manifest number
           $manifest_new_number=$_POST['location']."5".rand(100,10000).$token;
           echo $manifest_new_number;
           $id_user=$_SESSION['id_user'];
          
           
         $insert="INSERT INTO manifest_reg(manifest_unq_num,date_manifest,driver_num,hash_serial,group1,closed,siteid) VALUES('$manifest_new_number','$date1','$id_user','0','95','0','0')"; //changed $site_id for NULL not yet generated  
         $rek_manifest=mysql_query($insert) or die(mysql_error());
         $last_insert_id=  mysql_insert_id();
         $_SESSION['manifest_number']=$manifest_new_number;
         echo '<BR/><BR /><h3>You are in manifest environment now. Before you confirm manifest, be sure everything is correct.</h3><BR/>';
         
         //transfering data to new table
         
         $take_out="Select * From sub_cat"; //WHEREsub_cat.kind=2
         $res_out=mysql_query($take_out) or die(mysql_error());
         $manifest_id=$last_insert_id;
            $_SESSION['manifest_idd']=$manifest_id;
         while($rek_out=mysql_fetch_array($res_out))
         {
            $sub_cat=$rek_out['id_c'];
            
            $take_in="INSERT INTO manifest_counter(manifest_counter,sub_cat,manifest_reg_idmanifest_reg,finished) VALUES('0','$sub_cat','$manifest_id','0')";
            mysql_query($take_in) or die(mysql_error());
            
         }
         
         
         
         }
         
         
         
         //here comes dbs startin range
         
         $start_dbs_check=get_start_dbs($id_manif_count);
         echo $_SESSION['start_dbs_barcode'];
         if(isset($_SESSION['start_dbs_barcode']))
         {    
             
       /*       if(!empty($_POST['sticker_start']))
     {
         echo "<BR />Stickers range successfuly set.<BR />";
         echo $sticker=;
         echo "<BR />";
         $update_sticker="UPDATE manifest_reg SET start_dbs='$sticker' WHERE idmanifest_reg='$id_manif_count'";
         $result=mysql_query($update_sticker) or die(mysql_error());
         
         
     }*/
     if(isset($_SESSION['start_dbs_barcode']))
     {
         echo "<BR />Stickers range successfuly set.<BR />";
         echo $sticker=$_SESSION['start_dbs_barcode'];
         echo "<BR />";
         $update_sticker="UPDATE manifest_reg SET start_dbs='$sticker' WHERE idmanifest_reg='$id_manif_count'";
         $result=mysql_query($update_sticker) or die(mysql_error());
         if($result)
         {
             echo "added barcode stickers";
         }
         
     }
     else
     {
             
             
         echo "<h3>Please specify Manifest Identification stickers starting range</h3>
     <BR />
      
  
     <BR />";

     echo "<table style='WIDTH:300px'><tr><td width='20%'><form action='index2.php' method='POST'>";
     echo "<input  type='text' name='sticker_start' placeholder='DBS/...'></td>";
     //echo '<input type="hidden" name="confirmation_manifest" value="1">';
    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
    echo "<input type='hidden' name='location' value='".$loca."' > ";
     echo "<td width='20%'><input type='submit' name='Submit' value='SET' align='right'> </td>";
  for($i=0;$i<$_POST['in'];$i++)
    {
        $in=$_POST['in'];
    echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
    $quant="quantity".$i;
   // echo $quant;
    $quant=$_POST[$quant];
    //echo $i;
    //echo $quant;
    $quant=select_sub_cat($i, $id_manif_count);
   // echo $quant;
    echo "<input type='hidden' name='quantity".$i."' value='".$quant."'>";
    }
   echo "</form></tr></table>";

     }
         } 
         else {"<BR/>Starting sticker set on ".$start_dbs_check;
         }
         
         
         
         
         
         
         
   /*      
         
  echo     ' <div style="position: relative; padding: 100px;">';

  echo '<button onclick="function()" id="plus">Play "beer_can_opening"</button>';
   echo '<button id="b02">Play "bell_ring"</button>';

echo '</div>';
     */    
         
     
        
        
        
      echo "<table border='1' style='width:100%;display:block;marign:0;padding:0;'>";
       // echo "<tr><th>Subcategory</th><th>Q.Rec.</th></tr>"; //<th colspan='4'></th><th>Subcat.</th><th>Q.Rec</th><th></th>

   
    echo "<form action='index2.php#Mani28' method='post' onsubmit='document. id='search'><tr>";




    $in=0;
    $i=0;
    
    //config sensitivity
    if($size_zoom==0)
    {
        $buttony=35;
        
    }
    else
    {
        $buttony=$size_zoom;
    }
    echo "Sens ".$size_zoom;
    /*echo "  <style>
    input[type=submit] {
    width: ".$size_zoom."em;  height:3em;</style>
    ";*/
    //style='font-family:Orator Std;font-size: 35px;' style='
    //width: ".$size_zoom."em;  height:3em;' onclick='scrollIntoView('".$amni."')' >
    while($rek = mysql_fetch_array($wynik,1)) { 
        $in++;
        $i++;
        
        $quntty=select_sub_cat($in,$id_manif_count);
       echo '<a name="Mani'.$i.'"></a>';
        $amni="Mani".$i;
        echo "<td style='width:10px;'><h3>".$rek["Name_sub"]." (".$rek['weight']." kg)".$in."</h3></td>";
        
        
        echo "<div><td style='width:7px;'><h3><BR />".$quntty."</h3></td>";
        
        
                echo "<div><td colspan='8' style='text-align:left'>";
           
                echo "<input type='Submit' size='35' name='plus".$in."' value='+' id='plus' class='sbutton'/>"; 
                
                echo "<input type='Submit' name='minus".$in."' value='-' class='sbutton'/>";
                
                echo "<input type='text' class='sfield' name='quantity".$in."' placeholder='QTTY' />";
                 
                   //echo "<input type='Submit' name='add".$in."' value='add' class='sbutton'/>";
                         echo  "</td></div>"; 
        //echo $rek['id_c'];
        echo '<input type="hidden" name="id'.$in.'" value="'.htmlentities($rek["id_c"]).'">'; //number of sub category unique
        echo '<input type="hidden" name="weight'.$in.'" value="'.htmlentities($rek["weight"]).'">';  //weight of subcategory
	echo '<input type="hidden" name="cat_id'.$in.'" value="'.htmlentities($rek["Category_id"]).'">'; //category
        echo '<input type="hidden" name="date1" value="'.htmlentities($date1).'">';  //date manifest rised
        echo "</div>"; 
        if($i%$num_columns==0)
          echo "</tr><tr style='width: 100%; max-height: 40px; overflow:hidden;'>"; 
    } 
     echo '<input type="hidden" name="location" value="'.$_POST['location'].'">';
     echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
     echo '<input type="hidden" name="submitted" value="1">';
 if(isset($site_id))    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
   if(isset($site_id)) echo "<tr><td></td><td colspan='2'><input type='Submit' name='Submitt' value='Confirm' align='right' > </td>";
  
   echo "</form>";
    echo "</table>";

    //mysql_close();   
    }
    if(isset($_POST['Submitt']))
    {
        echo '<a name="Rise"></a>';
     echo "<BR /><h3>Manifest has been rised. Are the quantities correct?</h3>";
    echo '<form action="index2.php" method="POST">';
    echo '<input type="hidden" name="confirmation_manifest" value="1">';
    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
    echo '<input type="submit" name="manifest_submit" value="Yes" ';
    echo '<input type="submit" name="manifest_submit1" value="No" ';
    for($i=0;$i<$_POST['in'];$i++)
    {
        $in=$_POST['in'];
    echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
    $quant="quantity".$i;
   // echo $quant;
    $quant=$_POST[$quant];
    //echo $i;
    echo $quant;
    $quant=select_sub_cat($i, $id_manif_count);
   // echo $quant;
    echo "<input type='hidden' name='quantity".$i."' value='".$quant."'>";
    }
    echo '</form><BR /><BR />';
    //echo "<table border='1'><tr><th>Subcategory</th><th>Quantity Recv.</th></tr>";

   
    echo "<form action='report.php' method='post'><tr>";




    $in=0;
    $i=0;
    while($rek = mysql_fetch_array($wynik,1)) { 
        $in++;
        $i++;
        echo "<td>".$rek["Name_sub"]." (".$rek['weight']." kg)</td><td><input type='text' name='quantity".$in."'></td>";  //quantity id, how many picked up
        
        echo '<input type="hidden" name="id'.$in.'" value="'.htmlentities($rek["id_c"]).'">'; //number of sub category unique
        echo '<input type="hidden" name="weight'.$in.'" value="'.htmlentities($rek["weight"]).'">';  //weight of subcategory
	echo '<input type="hidden" name="cat_id'.$in.'" value="'.htmlentities($rek["Category_id"]).'">'; //category
        echo '<input type="hidden" name="date1" value="'.htmlentities($date1).'">';  //date manifest rised
         if($i%$num_columns==0)
          echo "</tr><tr>"; 
    } 
     
     echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
     echo '<input type="hidden" name="submitted" value="1">';
 //if(isset($site_id))    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
   //if(isset($site_id)) echo "<tr><td></td><td></td><td><input type='submit' name='Submit' value='Confirm' align='right'> </td>";
  
   echo "</form>";
    echo "</table>";

    //mysql_close(); 
    }
    
?> 
     <?php endif ?>
        
     <?php if($_POST['confirmation_manifest']==1) : ?>
     <h4>Manifest Range is: <?php echo $_POST['in']; ?></h4>
     <h4>Picked up items in total: <?php 
     $name_qant=array();
     $id_manif_count=$_SESSION['manifest_idd']; 
     for($i=0;$i<$_POST['in'];$i++)
     {
     $name_quant[$i]="quantity";
     $name_quant[$i].=$i;
     $quant=$name_quant[$i];
   // echo $quant;
     $sum+=$_POST[$quant];
   //  echo $_POST[$quant];
     }
     echo " ";    
     echo $sum; ?></h4><BR /><BR />
  <?php /*echo "<h3>Please specify Manifest Identification stickers starting range</h3>
     <BR />
      
  
     <BR /><BR />";
     
     
     echo "<table><tr><td><form action='index2.php' method='POST'>";
     echo "<input type='text' name='sticker_start'></td>";
     echo '<input type="hidden" name="confirmation_manifest" value="1">';
    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
     echo "<td><input type='submit' name='Submit' value='SET' align='right'> </td>";
  for($i=0;$i<$_POST['in'];$i++)
    {
        $in=$_POST['in'];
    echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
    $quant="quantity".$i;
   // echo $quant;
    $quant=$_POST[$quant];
    //echo $i;
    //echo $quant;
    $quant=select_sub_cat($i, $id_manif_count);
   // echo $quant;
    echo "<input type='hidden' name='quantity".$i."' value='".$quant."'>";
    }
   echo "</form></tr></table>";

     if(!empty($_POST['sticker_start']))
     {
         echo "Stickers range successfuly set.<BR />";
         echo $sticker=$_POST['sticker_start'];
         echo "<BR />";
         $update_sticker="UPDATE manifest_reg SET start_dbs='$sticker' WHERE idmanifest_reg='$id_manif_count'";
         $result=mysql_query($update_sticker) or die(mysql_error());
         
         
     }
   
   */
     //we take manifest fields from sub_categories set up   
    $wynik = mysql_query("SELECT * FROM sub_cat INNER JOIN category ON category.id = sub_cat.category_id INNER JOIN weight ON weight.id = sub_cat.weight_id WHERE sub_cat.kind=2 ORDER BY name_sub ASC ") 
        or die(mysql_error()); 
         
     
    
    
    
    if(isset($_POST['date_op']) AND !empty($_POST['date_op']))
    {
        $date1=$_POST['date_op'];
    }
    else
    {
       //$date1 = date('m/d/Y h:i:s a', time());
       $date1= date('y/m/d');
        
    }
    echo $date1;
   
   // echo "<table border='1'><tr><th>Subcategory</th><th>Quantity Recv.</th></tr>";

   
    echo "<form action='report.php' method='POST'><tr>";

    
$_SESSION['restore_site_id']=$site_id;

    $in=0;
    $i=0;
    while($rek = mysql_fetch_array($wynik,1)) { 
        $in++;
        $i++;
        $name_quant[$i]="quantity";
     $name_quant[$i].=$i;
          $quant=$name_quant[$i];
         // echo $_POST[$quant];
        echo "<td>".$rek["Name_sub"]." (".$rek['weight']." kg)</td><td>  <input type='hidden' name='quantity".$in."' value='".$_POST[$quant]."'>".$_POST[$quant]."</td>";  //quantity id, how many picked up
        
        echo '<input type="hidden" name="id'.$in.'" value="'.htmlentities($rek["id_c"]).'">'; //number of sub category unique
        echo '<input type="hidden" name="weight'.$in.'" value="'.htmlentities($rek["weight"]).'">';  //weight of subcategory
	echo '<input type="hidden" name="cat_id'.$in.'" value="'.htmlentities($rek["Category_id"]).'">'; //category
        echo '<input type="hidden" name="date1" value="'.htmlentities($date1).'">';  //date manifest rised
         
        if($i%$num_columns_2==0)
          echo "</tr><tr>"; 
    } 
     
     echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
     echo '<input type="hidden" name="submitted" value="1">';
    
 if(isset($site_id))    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
   if(isset($site_id)) echo "<tr><td></td><td></td><td><td><td><input type='submit' name='Submit' value='Confirm' align='right'> </td>";
  echo $site_id;
   echo "</form>";
    echo "</table>";

     
     
     
     /*
      echo "<form action='report.php' method='POST'>";
     for($i=0;$i<$_POST['in'];$i++)
     {
         
         $name_quant[$i]="quantity";
     $name_quant[$i].=$i;
          $quant=$name_quant[$i];
         echo $quant;
         echo $_POST[$quant];
         echo $_POST['in'];
         echo $site_id;
     echo "<input type='hidden' name='quantity".$in." value='".$_POST[$quant]."'>";
         echo '<input type="hidden" name="in" value="'.htmlentities($_POST['in']).'">';
      echo '<input type="hidden" name="submitted" value="1">';
     }
      echo '<input type="hidden" name="site_id" value="'.$site_id.'">';
     echo "<input type='submit' name='Submit' value='Confirm'>";
     echo "</form>";
     ?>
     */
   
    ?>
     <?php endif ?>
      <?php if($_POST['confirmation_manifest']==2) : ?>
     
          <?php endif ?>
        
  
   <?php  } // end of get finished   ?>     
<!--<a href="../index.php"><button> Return</button></a>-->
</td></tr>

</td>
</tr>
</table>



</td>
<div id="box_right"><table border="2" ><?php show_site();?> </table></div>
</table>

<?php
if($PLAY_SOUND_FLAG==1)
echo '<script type="text/javascript">
    sound_tab();
</script>';
?>


</BODY>
</HTML>