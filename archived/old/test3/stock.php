<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];

include '../header_mysql.php';
include '../functions.php';

include '../header_valid.php';

$host='127.0.0.1';
 $dbs3='dbs3';
  $username='root';
$password='krasnal';


$CONFIG_MODE=1;
$IS_WEIGHT_SET=0; //different notation than in add_process_stock
$BLOCK_FORM=0;


//function from stock test2 module
function serializing($fix)
{
    
    
}

function split_barcode($barcode)
{
  // echo "Result of fun split_barcode: "; 
  // echo "<BR />".
           $prefix=substr($barcode,0,3);
   //echo "<BR />".
           $pre_increment =  substr($barcode,4,-2);
   //echo "<BR />".
           $post_inc=substr($barcode,10,12);
   
   //$pre_increment = str_pad($pre_increment + 1, 5, 0, STR_PAD_LEFT);
   
   $inc=$prefix."/".$pre_increment;
   $inc++;
   //echo $inc;
   $serialised=$inc.$post_inc;
    //$serialised=array();
   //echo $serialised=$prefix.$pre_increment.$post_inc;
   
   //$words = preg_split('/\s/', $barcode); 
   //echo $words[0];   
//$chars = preg_split('/', $barcode, -1, PREG_SPLIT_OFFSET_CAPTURE);
   //print_r($chars);
   
   return $serialised; 
    
}
function get_barcodes_from_db($barcode)
{
    echo "Przekazany bar".$barcode;
    //echo split_barcode($barcode);
    //get barcode, search whole database, serialize and compare if ok return site place
    echo "<BR/><BR/><BR/>inside get_barcodes;";
    //$siteid=$_SESSION['site_id_s'];
    
    global $host;
    global $username;
    global $password;
    global $NEW_CALCULATION;        
    global $dbs3;
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
    echo "get_bar ".$siteid;
    $query="SELECT * FROM manifest_reg";
    $result=mysql_query($query);
    echo "<BR/>Interpreter: ".mysql_error();
    $check_buffor_register=array();
    $z_counter=0;
    $return_flag=0;
    while($rek=mysql_fetch_array($result))
    {
    
      // echo "<BR/>Starting Barcode From manifest Register ";
       $start_dbs=$rek['start_dbs'];
       $end_dbs=$rek['end_dbs'];
      echo $idmanifest_reg=$rek['idmanifest_reg'];
      //echo " !!Siteid ";
            // $siteid=$rek['siteid'];
       //echo " Start DBS is: ";
               $start_dbs;
       //echo " End DBS is: ";
               $end_dbs;
       
         
         
      //here we go for taking a preset number of items collected from site place
      if($NEW_CALCULATION==0) 
      {
     $query="SELECT COUNT(manifest_counter) as ile, SUM(manifest_counter) as suma FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
           $ile=$rek_count['ile'];
           $suma=$rek_count['suma'];
        
     }
      }
      else
      {
          //take from site table
         $query="SELECT siteid FROM manifest_reg WHERE idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
           echo "Site id". $site_id_tmp=$rek_count['siteid'];
            $query="SELECT * FROM site WHERE site_id='$site_id_tmp'";
     $result_count=mysql_query($query) or die(mysql_error());
     if(mysql_num_rows($result_count)>1)
         die(mysql_error ());
     while($rek_site=mysql_fetch_array($result_count)){
                 echo "Size calc ". $size_calculation_site=$rek_site['closed'];
              }
       
        
     } 
          
          
      }
  
     $barcode=strtolower($barcode);
     $dbs_set=array();
     global $error_factor;
     echo " <BR/>PROB set".$dbs_prob_set=$suma+$error_factor;
     //echo $barcode;
     //echo $barcode;
     if($NEW_CALCULATION==1)
     {
         ;
          echo "Second serialisation cicrut active";
          $dbs_prob_set=$size_calculation_site; 
     }
     else
     {
       
     }
     $next_dbs=$start_dbs;
     for($i=0;$i<$dbs_prob_set;$i++)
     {
        
        $dbs_set[$i]=$next_dbs;
       $next_dbs=split_barcode($next_dbs);
        //echo $dbs_set[$i]."<BR />";
        //echo "First : ".$dbs_set[$i]."Second : ".$barcode;
        $result_cmp=strcmp($dbs_set[$i],$barcode);
         if($result_cmp==0)
         {
              echo "<BR/><BR/>Detected Comparison: ".$dbs_set[$i]." AND ".$barcode;
              echo " Sum: ".$suma;
            echo " Result ".$barcode;
            echo " Range ".$dbs_set[0]." ".$dbs_set[$dbs_prob_set];
            echo " ~Result ".$barcode;
            echo $siteid=$rek['siteid'];
            //echo $start_dbs;
            $return_flag+=1;
            
            echo "<BR/><BR/>";
             while($rek_count['ile']>40)
         {
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
             break;
         }
         }
     }
  //   echo "<BR /><BR/>";
    }
    echo "<BR/><BR/> ";
    echo "Return flag: ".$return_flag;
   /* if($z_counter>1)
    {
       echo "Z Buffor size abnormal ".$z_counter; 
       return -2;
    }*/
    if($return_flag==1)
    {    
    echo "SESSION SET ".$_SESSION['site_id_s']=$siteid;
    return strtoupper($barcode);
    
    }
    else
    {
         $_SESSION['site_id_s']=0; 
      echo "<BR/>";  
      echo "<BR/>Braekin Bad";   
      return 0;  
       
      
    }
      
    }




function message()
{
if(isset($_GET['MESSG'])>0)
{

    
$message=$_GET['MESSG'];

if($message==14)
    $message="A Barcode connected with a new weight class. Everything is fine. Item added in stock. Activating Testing Module";

if($message==12)
    $message="CRITICAL SYSTEM ERROR. PLEASE CONTACT ADMIN.</BR> "
        . "The weight assasment modul gives back error: NO ACTIVE ITEM WEIGHT CATEGORY ASSIGNED";


if($message==1)
$message="Item added in Stock. Activating Testing Module";
if($message==2)
$message="Item with that Barcode already stocked in";
if($message==3)
{
    if(isset($_GET['MESSG_EX']))
      {
       // echo $_GET['V_ITEM'];
        global $BLOCK_FORM;
        $BLOCK_FORM=1; //LOCAL VARIABLE TO BLOCK form
        if(isset($_GET['V_ITEM']))
            $v_item=$_GET['V_ITEM'];
      $message="SYSTEM BLOCKED: A new type of item. Weight not assign. Call supervisor</br></br></br>"; 
      $message.='<form action="add_process_stock.php" method="POST"> <input placeholder="Password" type="password" name="password" autofocus="" style="margin:10px;padding:10px;">';
      $message.='<input type="hidden" name="name_p" value="'.$v_item.'">';
       $message.='<input type="hidden" name="barcode_p" value="'.$_GET['V_BARCODE'].'">';
        $message.='<input type="hidden" name="serial_p" value="'.$_GET['V_SERIAL'].'">';
         $message.='<input type="hidden" name="brand_p" value="'.$_GET['V_BRAND'].'">';
      $message.="<input type='Submit' name='log' value='Give priviliges' >";
      
      
      $message.="</form>";
      
      //give to local form 
     // $V_BAR_EX=$_GET['V_BARCODE'];
     // $V_ITEM_EX=$_GET['V_ITEM'];
    //  $V_BRAND_EX=$_GET['V_BRAND'];
   //   $V_SERIAL_EX=$_GET['V_SERIAL'];
            
      
      }
      else
$message="Please Fill in Necessary fields";
}
if($message==4)
//$message="Item in stock not yet tested";
//$message="Item";
//if($message==4)
//$message="We have never had this item in stock";

if($message==5)
$message="System blocked. No particular weight assigned. Call Supervisor</BR></div><div>";

if($message==6)
    $message="Added a new item type, with a new active weight category. Barcode stocked in. Activating Testing Module";

if($_GET['BUF_MESSG']>0)
    $message="IN Stock we have".$_GET['BUF_MESSG'];

if($message==10)
$message="Test Cancelled";

if($_GET['bar_ex']==3)
    $message="CRITICAL SYSTEM ERROR CONTACT ADMIN";

echo "<div id='message' style='position: relative; width: 80%;marign: auto;border:4px black;'> ";    
echo "<h4> MESSAGE: </h4>".$message;   
echo "</div></BR>";    




}
}



function generate_item_list($idc)
{ 
   global $host;
   global $username;
   global $password;
   global $dbs3;
   //echo $idc;
   mysql_connect($host,$username,$password); 
   mysql_select_db($dbs3);
  $select= "SELECT * FROM sub_cat";
  $result=mysql_query($select) or die(mysql_error());
 // echo $idc;
   echo "<select name='sub_cat'>";
   
   while($rek=mysql_fetch_array($result))
   {
      // echo $idc." ".$rek['id_c']."<BR />";
   if($idc==$rek['id_c'])
   {
    //echo $idc;   
  echo '<option value="'.$rek['id_c'].'" selected >'.$rek['Name_sub'].'</option>';
   } 
  else
       echo '<option value="'.$rek['id_c'].'">'.$rek['Name_sub'].'</option>';
  
   }
          echo "</select>"; 
    
}


function get_barcodes_from_db_tab($barcode)
{
    echo "Przekazany bar".$barcode;
    
    //get barcode, search whole database, serialize and compare if ok return site place
    echo "<BR/><BR/><BR/>inside get_barcodes;";
    
    
    global $host;
    global $username;
    global $password;
            
    global $dbs3;
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
    echo "get_bar ".$barcode;
    $query="SELECT * FROM manifest_reg";
    $result=mysql_query($query);
    echo "<BR/>Interpreter: ".mysql_error();
    while($rek=mysql_fetch_array($result))
    {
    
       $start_dbs=$rek['start_dbs'];
       $end_dbs=$rek['end_dbs'];
       $idmanifest_reg=$rek['idmanifest_reg'];
       $siteid=$rek['siteid'];
       //echo "Start DBS is: ".$start_dbs;
       //echo "End DBS is: ".$end_dbs;
       
         
         
      echo "<BR/>Checking Root Manifest Register and Counter";
     $query="SELECT COUNT(manifest_counter) as ile, SUM(manifest_counter) as suma FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
           $ile=$rek_count['ile'];
           $suma=$rek_count['suma'];
        
           }
          
     $return_flag=0;
     $barcode=strtolower($barcode);
     $dbs_set=array();
     $local_serialisation_table=array();
     global $error_factor;
     "PROB set".$dbs_prob_set=$suma+$error_factor;
     //echo $barcode;
     //echo $barcode;
     for($i=0;$i<$dbs_prob_set;$i++)
     {
        
        $dbs_set[$i]=$start_dbs++;
        $local_serialisation_table[$i]=strtoupper($dbs_set[$i]);
        //echo $dbs_set[$i]."<BR />";
        //echo "First : ".$dbs_set[$i]."Second : ".$barcode;
        $result_cmp=strcmp($dbs_set[$i],$barcode);
         if($result_cmp==0)
         {
              echo "Sum: ".$suma;
            echo "Result ".$barcode;
            echo " Range ".$dbs_set[0]." ".$dbs_set[$dbs_prob_set];
            //echo $start_dbs;
            $return_flag+=1;
            $local_size=$suma;
            /* while($rek_count['ile']>40)
         {
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
             break;
         } */
         }
     }
  //   echo "<BR /><BR/>";
    }
    echo "<BR/><BR/>";
    
    
    
    
    echo "<BR/>Checking Root SYSTEM Main Barcode Storage";
    $local_flag_bar=0;
    
    $barcode=strtoupper($barcode);//searching only capital strings, standard dbs format
    $barcode1=strtoupper($barcode);
    echo "<BR/>Local Serialization done for: ".$local_size;
    for($i=0;$i<$local_size;$i++)
    {
     echo $barcode=$local_serialisation_table[$i];   
    $query="SELECT Barcode FROM barcode WHERE Barcode='$barcode'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
           echo "Barcode Range exists in root system system in Barcode: ".$rek['Barcode'];
        
           $local_flag_bar+=1;
           /*
           if(!empty($rek['Barcode']))
         {
           $local_flag_bar=1;  
         }
         */
     }
    }
    if($return_flag==1 AND $local_flag_bar==0)
    {
       echo "<BR/>System ready to go. Local return flag from serialisation ".$return_flag." and local barcode check is ".$local_flag_bar; 
       echo "<BR/>New Site ID is ".$siteid;
       return $barcode1;
    }
    
    
} 


/*

function get_barcodes_from_db($barcode)
{
    echo "Przekazany bar".$barcode;
    
    //get barcode, search whole database, serialize and compare if ok return site place
    echo "<BR/><BR/><BR/>inside get_barcodes;";
    $siteid=$_SESSION['site_id_s'];
    
    global $host;
    global $username;
    global $password;
            
    global $dbs3;
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
    echo "get_bar ".$siteid;
    $query="SELECT * FROM manifest_reg";
    $result=mysql_query($query);
    echo "<BR/>Interpreter: ".mysql_error();
    while($rek=mysql_fetch_array($result))
    {
    
       $start_dbs=$rek['start_dbs'];
       $end_dbs=$rek['end_dbs'];
       $idmanifest_reg=$rek['idmanifest_reg'];
       $siteid=$rek['siteid'];
       //echo "Start DBS is: ".$start_dbs;
       //echo "End DBS is: ".$end_dbs;
       
         
         
      
     $query="SELECT COUNT(manifest_counter) as ile, SUM(manifest_counter) as suma FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
           $ile=$rek_count['ile'];
           $suma=$rek_count['suma'];
        
           }
          
     $return_flag=0;
     $barcode=strtolower($barcode);
     $dbs_set=array();
     global $error_factor;
     "PROB set".$dbs_prob_set=$suma+$error_factor;
     //echo $barcode;
     //echo $barcode;
     for($i=0;$i<$dbs_prob_set;$i++)
     {
        
        $dbs_set[$i]=$start_dbs++;
        //echo $dbs_set[$i]."<BR />";
        //echo "First : ".$dbs_set[$i]."Second : ".$barcode;
        $result_cmp=strcmp($dbs_set[$i],$barcode);
         if($result_cmp==0)
         {
              echo $suma;
            echo "Result ".$barcode;
            //echo $start_dbs;
            $return_flag=1;
             while($rek_count['ile']>40)
         {
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
             break;
         }
         }
     }
  //   echo "<BR /><BR/>";
    }
    echo "<BR/><BR/>";
    
    if($return_flag==1)
    {    
    echo "SESSION SET ".$_SESSION['site_id_s']=$siteid;
    return strtoupper($barcode);
    
    }
    else
    {
      echo "<BR/>";  
      echo "<BR/>Braekin Bad";   
      return 0;  
       
      
    }
      
    }


*/


//end of functions



//validation starts

if(isset($_POST['Submit_stock']))
{
    echo "IN Submit stock";
   if(isset($_POST['barcode']))
   {
     echo "IN parcode post";  
    $BAR_EX=get_barcodes_from_db($_POST['barcode']);    
   //$BAR_EX=$_POST['barcode'];
   }
   if(isset($_POST['brand']))
   $BRAND_EX=$_POST['brand'];
   if(isset($_POST['serial']))
   $SERIAL_EX=$_POST['serial'];
   if(isset($_POST['item']))
      $ITEM_EX=$_POST['item']; 
       
  
    
    
}

if(isset($ITEM_EX) AND isset($BAR_EX) AND isset($BRAND_EX) AND isset($SERIAL_EX))
{
    echo "checkin weights";
    $SELECT_CAT="SELECT Category_id FROM sub_cat Where id_c=$ITEM_EX";
    $res_category=mysql_query($SELECT_CAT) or die(mysql_error());
    $rek_cat=mysql_fetch_array($res_category);
    echo "Sub category ".$category=$rek_cat['Category_id'];
   $SELECT_WEIGHT="SELECT * FROM item_has_cat INNER JOIN item ON item_has_cat.id_item_cat=item.Item_has_Cat_id_item_cat WHERE cat='$category' AND active=1 ";
   $res_weight=mysql_query($SELECT_WEIGHT) or die(mysql_error());
   while($rek_weight=mysql_fetch_array($res_weight))
   {
     echo "ID ITem cat  ".$rek_weight['id_item_cat'];  
       echo $rek_weight['name'];
   }
    echo "wieghts checked";
    
    
    
}






















?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=iso-8859-2">
  <meta name="Description" content=" GRR Secondary Sytem">
  <meta name="Keywords" content="  ">
  <meta name="Author" content="  ">
  

  <title> GRR 3 Stocking</title>

  <link rel="stylesheet" href="layout.css " type="text/css" />
   <link rel="stylesheet" href="form.css " type="text/css" />





</head>
<body>
<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div></BR></BR>



<div id="all">




    <div id="form_stock" style="font: xx-large; font-variant: simplified; font-family: sans-serif; font-size:  inherit; "> <p>Stocking Manager Module v 2.0</p>
</BR>
<div margin="10px">




<table border="1" id="stock_form1">
<tr><td>Barcode</td><td>Item</td><td>Brand</td><td>Model Number</td></tr>
<tr>

<form action="stock.php" method="POST">
<td>    
<input type="text" name="barcode" value="<?php if(!empty($BAR_EX)) echo $BAR_EX; ?>" autofocus="" placeholder="Barcode">
</td><td>
<?php
//echo $ITEM_EX;
//generate_item_list($ITEM_EX);

?>

<input type="text" name="item" value="<?php if(!empty($ITEM_EX)) echo $ITEM_EX; ?>" placeholder="e.g. DVD, PS2..."> 
</td><td>
<input type="text" name="brand" value="<?php if(!empty($BRAND_EX)) echo $BRAND_EX; ?>" placeholder="e.g. JVC, Sanyo...">
</td><td>
<input type="text" name="serial" value="<?php if(!empty($SERIAL_EX)) echo $SERIAL_EX; ?>" placeholder="e.g. TJR56">
</td><td>
<!--<input type='submit' name='Cancel' value='Cancel' align='right'></td>-->
</tr><tr>




<td>
<input type="submit" name="Submit_stock" value="Stock-in" >
</td>
</tr>


</form>
</table>   
</div>

























 <?php if(isset($_GET['MESSG_EX'])==0): ?>   
<div id="buttons">
<h4> <a href="../index.php"><button class="submit" style=" width: auto;  
    padding: 9px 15px;  
    background: #617798;  
    border: 0;  
    font-size: 14px;  
    color: #FFFFFF;  
    -moz-border-radius: 1px;  
    -webkit-border-radius: 1px;  ">Return</button></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</h4>
</div>
    <?php endif ?>
</div></div>
 </br></br>
 
 
 <?php
echo "<table width='50%'>";
 show_site($user_st);
 echo "</table>";
 echo $error_msg;   
 
 
 
 if($_GET['MESSG']==14 OR $_GET['MESSG']==1 OR $_GET['MESSG']==6)
 {
     echo "Going to do test";
 $V_BARCODE=$_GET['test'];
 $url="add_barcode.php?test_stock=1&V_BARCODE=";
 $url.=$V_BARCODE;
   redirect($url,2);
 }
   ?>   
 
 
</body>
</html>
