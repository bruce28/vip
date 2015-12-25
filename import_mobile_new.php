<?php
session_start();
ini_set('max_execution_time', 0);

include 'header_valid.php';
include 'import_mobile_config.php';
include 'header_mysql.php';
include 'email.php';

$GME;

$host_out=0;
//here we initialise session detected device we store unless detect button is set

$_SESSION['host_out'];


function set_device_in_session($host_out)
{
   $_SESSION['host_out']=$host_out;
   
}

function get_device_from_session()
{
   return $_SESSION['host_out']; 
}

if(!defined('IMPORT_EXIT_DETAILS_EXIST'))    
    define("IMPORT_EXIT_DETAILS_EXIST", 2);


$FLAG_IMPORT=0; //this flag is set one while Submit particular import button

//include 'second_lvl_api.php'; //get max i origin
function get_max_customer()
{
    $sql="SELECT MAX(origin_id) AS origin_max FROM origin";
    $result=query_select($sql);
    
    //gets the higest value in column not how manyt ropws
    
    $rek=mysql_fetch_array($result);
    return $rek[0];
    
    
}
$FLAG_MESSG="MESSAGE: ";

function serializing($fix)
{
    
    
}

function split_barcode($barcode,$barcode_end)
{
  // echo "Result of fun split_barcode: "; 
  // echo "<BR />".
           $prefix=substr($barcode,0,3);
   //echo "<BR />".
           $pre_increment =  substr($barcode,4,-2);
   //echo "<BR />".
           $post_inc=substr($barcode,10,12);
   
           
           
           $prefix1=substr($barcode_end,0,3);
   //echo "<BR />".
           $pre_increment1 =  substr($barcode_end,4,-2);
   //echo "<BR />".
           $post_inc1=substr($barcode_end,10,12);
   //$pre_increment = str_pad($pre_increment + 1, 5, 0, STR_PAD_LEFT);
   
   //$inc=$prefix."/".$pre_increment;
   //$inc++;
   //echo $inc;
   //$serialised=$inc.$post_inc;
    //$serialised=array();
   //echo $serialised=$prefix.$pre_increment.$post_inc;
   
   //$words = preg_split('/\s/', $barcode); 
   //echo $words[0];   
//$chars = preg_split('/', $barcode, -1, PREG_SPLIT_OFFSET_CAPTURE);
   //print_r($chars);
   echo $pre_increment;
   echo $pre_increment1;
         $size=$pre_increment-$pre_increment1 ; 
           echo "De deferentiation".$size;
           
           
           
           
   return (-($size)+1); 
    
}




function mysql_fetch_alias_array($result)
{
    if (!($row = mysql_fetch_array($result)))
    {
        return null;
    }

    $assoc = Array();
    $rowCount = mysql_num_fields($result);
   
    for ($idx = 0; $idx < $rowCount; $idx++)
    {
        $table = mysql_field_table($result, $idx);
        $field = mysql_field_name($result, $idx);
        echo $assoc["$table.$field"] = $row[$idx]."<BR />";
    }
   
    return $assoc;
}


function mysql_fetch_table($result)
{
    if (!($row = mysql_fetch_array($result)))
    {
        return null;
    }

    $assoc = Array();
    $rowCount = mysql_num_fields($result);
   
    for ($idx = 0; $idx < $rowCount; $idx++)
    {
        $table = mysql_field_table($result, $idx);
        $field = mysql_field_name($result, $idx);
        echo $assoc["$table.$field"] = $row[$idx]."<BR />";
    }
   
    return $assoc;
}

function show($show)
{
    echo "<BR />".$show;
}
function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}
 $origin_id;

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}

function get_site_id($siteid)
{
   $select="SELECT * FROM site WHERE site_id='$siteid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
   global $origin_id;
   $origin_id=$rek['Origin_origin_id'];
    return $rek['site_ref_number'];
}

function get_origin_id($originid)
{
   $select="SELECT * FROM origin WHERE origin_id='$originid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
    return $rek['town'];
}

function get_user_id($userid)
{
   $select="SELECT * FROM user_2 WHERE id_user='$userid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
    return $rek['name'];
}


function connect_tablet()
{
    global $FLAG_MESSG;
    
    global $host_out;
    global $dbs3_out;
    
$connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);
$FLAG_MESSG.= "</BR> Connect tablet function - Done con tab </br>";
return $connect;
    
}

function connect_dbs3()
{
    global $FLAG_MESSG;
  global $host_in; 
    global $dbs3_in;
 

$connect=mysql_connect($host_in,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_in);

$FLAG_MESSG.= "</BR> Connect root dbs3 - Done con dbs3</br>";
//echo "conn dbs3";
   return $connect; 
}

function roll_back_manifest($id_mani)
{
    global $host_out;
    global $dbs3_out;
 $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
     mysql_select_db($dbs3_out);
    // $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
    $update_closed="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$id_mani'";
    $rek=mysql_query($update_closed) or die(mysql_error());
    $import_details=$id_mani;
    mysql_close();
    if($rek)
    return $import_details;
}















//end of rooling back definition

function check_competence($connect)
{
    //it takes from tablet all those manifest not yet closed
    
}

function conv_max_site_id()
{
    global $host_in;
    global $dbs3_in;
    $connect=mysql_connect($host_out,'root','krasnal');
    mysql_select_db($dbs3_in);
    $last_id="SELECT MAX(site_id) as smax FROM site ORDER BY site_id DESC LIMIT 1;";
    $result_id=mysql_query($last_id,$connect);
    $rek=mysql_fetch_array($result_id);
    if($result_id)
      return $rek['smax'];  
    else return -1;
}


function get_weight($weightid)
{
   global $host_out;
   global $dbs_out;
   
   $connect=mysql_connect($host_out,'root','krasnal');
   mysql_select_db($dbs3_out);
    
   $select="SELECT * FROM weight WHERE id='$weightid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
   mysql_close();
    return $rek;
}
               

function get_category($categoryid)
{
    global $host_out;
   global $dbs_out;
   
   $connect=mysql_connect($host_out,'root','krasnal');
   mysql_select_db($dbs3_out);
   
   $select="SELECT * FROM category WHERE id='$categoryid'";
   $result=mysql_query($select)or die(mysql_error());
   $rek=mysql_fetch_array($result);
   mysql_close();
   return $rek;
}
   

function get_barcodes_from_db($barcode)
{
    echo "Przekazany bar".$barcode;
    
    //get barcode, search whole database, serialize and compare if ok return site place
    echo "<BR/><BR/><BR/>inside get_barcodes;";
    
    
    global $host_in;
    global $username;
    global $password;
            
    global $dbs3_in;
    mysql_connect($host_in,$username,$password);
    mysql_select_db($dbs3_in);
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
            $return_flag=1;
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
    
    echo "<BR/>Local Serialization done for: ".$local_size;
    for($i=0;$i<$local_size;$i++)
    {
     echo $barcode=$local_serialisation_table[$i];   
    $query="SELECT Barcode FROM barcode WHERE Barcode='$barcode'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
           echo "Barcode Range exists in root system system in Barcode: ".$rek['Barcode'];
         if(!empty($rek['Barcode']))
         {
           $local_flag_bar=1;  
         }
         
     }
    }
    
    
    
    
    //END 
    
    if(($return_flag==1) AND ($local_flag_bar==1))
    {    
    echo "SESSION SET ";
    return 1;
    }
    else
    {
      echo "<BR/>Braekin Bad";   
      return 0;  
         
      
    }
      
    }





































$import_details=0;
$imported=0;
$site_place=0;
$existing_mani_id=0;
?>




<HTML>
<HEAD>

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">


<link rel="stylesheet" href="jquery-ui2/jquery-ui-1.11.2.custom/jquery-ui.css" type="text/css">
      <script src="jquery-ui2/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
      <script src="jquery-ui2/jquery-ui-1.11.2.custom/jquery-ui.js"></script>


</HEAD>
<BODY>
   <script>$(function() {
    $("#accordion").accordion({heightStyle: "content",
    active: 1});
  });
  $(function (){
    $("a").button();
    });
    
   $(function ()
           
   {
       $("button").button();
       $("input[type=Submit]").button();
       
   });
    
</script>
<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>
    
    
    <div class="ui-widget-content" id="wrapper_content">
</BR></BR>

<?php
 echo '<div id="accordion">';
 
 
            
            $host_out_id=get_device_from_session();
            if(!empty($host_out_id))
            $header_ac=" - Presently detected:".$host_out_id;
 
                echo '<h3>Devices '.$header_ac.'</h3>';
              echo '<div>';
              
              
            detect_button();
            
              if($_POST['button_detect'])
              {
                  unset($_SESSION['host_out']);
                  echo "detected";
                  
                  
              }
                  
              process_device_detect();
              detect_devices();
             //echo "ff";
              $host_out=get_device_from_session();
              
                            
              //echo "Device";
             echo '</div>';
            // echo '</div>';
            
             echo '<h3>Import Manifest</h3>';
             echo '<div>';
               echo "<p class='ui-widget-content'>You're working on:".$host_out=get_device_from_session();
            echo "</p>";
             
?>
<div id="tabel_wrap_out2"></BR>
    </br>
    <center><p style=""><h3>Mobile Device Module</h3></p></center>
    </br>
    
  
    
    
    
    
    
<table id="tabel_out" border="1"  >

<?php


function detect_button()
{
   
    echo '<form action="import_mobile_new.php" method="POST">';
    echo '<input type="Submit" name="button_detect" value="Detect">';
    echo '</form>';
    
}

function process_device_detect()
{
    global $host_out;
    for($i=0;$i<255;$i++)
    {
        $name="count".$i;
        $name_value="counter".$i;
        if(isset($_POST[$name]))
        {
           // echo "detected: ".$_POST[$name];
          //  echo "VAL".$_POST[$name_value];
            
            //set host out
           echo $host_out=$_POST[$name];
           if(!empty($host_out))
            echo set_device_in_session($host_out);  //set device in session use it 
                    
        }
    }
    
}


 function detect_devices()
 {             
$from = 1;
$to = 40;

$port=3306;
//TCP ports
$host = '192.168.0.';
 $detected_devices=array();
 $counter=0;
for($from; $from <= $to ; $from++)
{
   $host_name=$host.$from; 
  // socket_set_timeout($stream, $seconds, $microseconds)
/*   $fp = fsockopen($host_name , $port, $timeout=1);
 */ 
   /*
   if(fsockopen($host, $sport, $errorno, $errorstr, 0.1))

$connection = @fsockopen($host, $sport);
if (is_resource($connection)){
  // OK
}
   */
   
   echo '<form action="import_mobile_new.php" method="POST">';
   if($from==24)
       ;
   else
   {    
        if(fsockopen($host_name, $port, $errorno, $errorstr, 0.1))
        { 
                 $counter++;
                echo  '<input type="hidden" name="counter'.$counter.'" value="'.$from.'">';
                echo "</BR>Detected device: <input type='Submit' name='count".$counter."' value='".$host_name."'>";
                $detected_devices[$counter]=$host_name;
        }
   } 
   echo '</form>';    
   /*
  if ($fp)
 
  {
    echo "Detected devices:".$host_name."\n";
   // fclose($fp);
  }
  else
      echo $host_name."not detected";
  */ 
}
 }

function get_manifest_to_be_import_details()
{
    global $FLAG_MESSG;
    //i think the problem is that was linked to dbs3 root sytem
    connect_tablet();
    
   $sql='SELECT DISTINCT idmanifest_reg, manifest_unq_num,driver_num,date_manifest,siteid,start_dbs,end_dbs FROM manifest_reg INNER JOIN manifest_counter ON idmanifest_reg=manifest_reg_idmanifest_reg WHERE manifest_counter.finished=1 AND closed=0';

$result=add_db($sql);

global $origin_id;

$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
echo '<table>';
while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   $origin_none_detect=0;
   $id_manif_id=$rek['idmanifest_reg'];
   //if($tab[$rek["id_test"]]<'1')
   //{
   //echo '<tr><td>'.$rek["Name_sub"].'</td>'; 
	// echo '<td>'.$rek["kind"].'</td>';
	 //echo '<td>'.$rek["weight"].'</td>';
	 echo '<tr><td>'.$rek["idmanifest_reg"].'</td>';
	   echo '<td>'.$rek["manifest_unq_num"].'</td>';
           echo '<td>'.$rek["date_manifest"].'</td>';
          
           echo '<td>'.$rek["closed"].'</td>';
              echo '<td>'.get_site_id($rek["siteid"]).'</td>';
              echo '<td>'.get_origin_id($origin_id).'</td>';
              echo '<td>'.$rek['driver_num'].'</td>';
              echo '<td>collected by '.get_user_id($rek['driver_num']).'</td>';
              
               echo '<td>'.$rek['start_dbs'].'</td>';
                echo '<td>'.$rek['end_dbs'].'</td>';
            echo '<td> <form action="import_mobile_new.php" method="POST">';
            $idmanifest_counter=$rek['idmanifest_reg'];
            $select_mani_count="SELECT SUM(manifest_counter) as ile FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_counter'";
            $result_count=mysql_query($select_mani_count);
            //echo mysql_error();
            $rek_count=mysql_fetch_array($result_count);
            echo "<td>".$rek_count['ile']."</td>";
            echo "<td>";
            
            if(($or_id=root_system_origin(tablet_detect_origins($origin_id)))!=0)
            {    echo "DTCT: ".$or_id." PO ".$post_code=search_post_code_on_root(get_post_code(tablet_detect_origins($origin_id)));
            
                    if(empty($post_code))
                        $origin_none_detect=1;
            }
            else 
            {   //tablet can detect and pass to get postcode
                echo "Got post codeL".$post_code=get_post_code(tablet_detect_origins($origin_id));
                if(tablet_system_origin_post_code($post_code)==root_system_origin_post_code($post_code))
                {
                    echo "in root system that post code".  tablet_system_origin_post_code($post_code);
                    $origin_none_detect=0;
                }
                else {
                $origin_none_detect=1;
                }    
//echo "none in the root";
                   //   draw_origin_form();
            }   
            connect_tablet();
           // echo get_origin_id($originid);
            echo "</td>";
            echo "<td>";
            echo $rek['driver_num'];
            $name_sub_cat=$rek['id'];   
            echo '</td><td><input type="checkbox" name="att_ck" value="';
            if(isset($_POST['att_ck'])) echo 'checked';
            echo '">'.$rek[type_2].'<br>';
  

//echo '</td><td><input style="padding:10px;margin:10px" type="text"  name="batch_date" value="'.htmlentities($weight).'">';

echo '<input style="padding:10px;margin:10px" type="hidden" placeholder="Item type" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


echo '<input type="hidden" name="submitted" value="1" >';

echo '<input type="hidden" name="id_manif_id" value="'.$id_manif_id.'" >';
if($origin_none_detect!=1)
{
    echo "<input style='padding:10px;margin:10px' type='submit' name='Submit' value='Import' align='right'>";
}
else
{
    //perform operation
    $FLAG_MESSG.= "Detected in root: ".$origin_id_from_root=tablet_detect_origins($origin_id);
    echo $origin_id_from_root;
    //if the case is none specified origin in the root system
    
     draw_origin_form($origin_id_from_root);
}
     echo '</tr>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 
     //}
  
        echo "</form></td>"; 
	  //$tab[$rek["id_test"]]+=1;
}
  
echo '</tr></table><BR />'; 
    
}


function search_post_code_on_root($post_code)
{
    connect_dbs3();
   $sql="SELECT post_code FROM origin WHERE post_code='$post_code'";
    
    
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    echo $rek[0];
    return $rek[0];
    
}

function process_origin_add()
{
    
    for($i=0;$i<=get_max_customer();$i++)  //until reached max origin id, so many times
    {
        //form a name for form handling
                // echo "mixer".$i;
        $name="origin_non_detect".$i;
         //$name_val=
         if(isset($_POST[$name]))
         {
                 echo "Processing non_origin";
                    //echo $_POST[$name];
                    $origin_val="origin_val".$i;
                     $origin_id=$_POST[$origin_val];
                    
                    //here we import origins as transaction while done it's shown as import ready.
                    import_origin($origin_id);
                    
         }
      
    }
}

function import_origin($origin_id) //id of origins imported
{
    echo $origin_id;
    
    //IT@s always CID. We only import origin table with conversion
    
    connect_tablet();
    
    $SELECT_TAB="SELECT * FROM origin WHERE origin_id='$origin_id'";
    $result=query_select($SELECT_TAB)or die (mysql_error());
    
    $rek=mysql_fetch_array($result,MYSQL_BOTH);
    
    //$origin_to_be_insert=$rek['origin_id'];
    $source_id="CID";
    $company_name=$rek['company_name'];
    $name=$rek['name'];
    $surname=$rek['surname'];
    $post_code=$rek['post_code'];
    $house_number=$rek['house_number'];
    $street=$rek['street'];
    $town=$rek['town'];
    $email=$rek['email'];
    $phone=$rek['phone'];
    
    connect_dbs3();
    
    echo $INSERT_DBS3="INSERT INTO origin(Source_source_id,company_name,name,surname,post_code,house_number,street,town,email,phone) VALUES('$source_id'"
            . ",'$company_name','$name','$surname','$post_code','$house_number','$street','$town','$email','$phone')";
    $result=query_select($INSERT_DBS3);
    
    if($result)
    {
        echo "Site imported";
    }
    else
    {
        echo "Origin not imported";
    }
    
    
    
}



function draw_origin_form($origin_id_from_root)
{
    echo '<form action="import_mobile_new.php" method="POST">';
   echo '<input type="hidden" name="origin_val'.$origin_id_from_root.'" value="'.$origin_id_from_root.'">'; 
    echo '<input type="submit" name="origin_non_detect'.$origin_id_from_root.'" value="Not detected">';
    echo '</form>';
}


function tablet_detect_origins($origin_id)
{
    
    connect_tablet();
   $sql="SELECT origin_id FROM origin WHERE origin_id='$origin_id'";
    
    
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    echo $rek[0];
    return $rek[0];    
}

function root_system_origin($origin_id)
{
    //echo "in root";
    connect_dbs3();
   // echo $origin_id;
   $sql="SELECT origin_id FROM origin WHERE origin_id='$origin_id'";
    
    
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
     $rek[0];
    if(!empty($rek))
    {
        echo $rek[0];
         return $rek[0];
    }
    else 0;
}

//detect wrapper check post codes both in root and main system

function root_system_origin_post_code($post_code)
{
    //echo "in root";
    connect_dbs3();
   // echo $origin_id;
   $sql="SELECT post_code FROM origin WHERE post_code='$post_code'";
    
    
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
     $rek[0];
    if(!empty($rek))
    {
        echo $rek[0];
         return $rek[0];
    }
    else 0;
}


function root_system_origin_from_post($post_code)
{
    //echo "in root";
    connect_dbs3();
   // echo $origin_id;
   $sql="SELECT origin_id FROM origin WHERE post_code='$post_code'";
    
    
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
     $rek[0];
    if(!empty($rek))
    {
        echo $rek[0];
         return $rek[0];
    }
    else 0;
}

function get_post_code($origin_id)
{
    connect_tablet();
    //conect tablet cause it has origin and post code w e look
    $SELECT_SQL="SELECT post_code FROM origin WHERE origin_id='$origin_id'";
    $result=mysql_query($SELECT_SQL)or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek[0];
}

function tablet_system_origin_post_code($post_code)
{
    //echo "in root";
    connect_tablet();
   // echo $origin_id;
   $sql="SELECT post_code FROM origin WHERE post_code='$post_code'";
    
    
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
     $rek[0];
    if(!empty($rek))
    {
        echo $rek[0];
         return $rek[0];
    }
    else 0;
}

/**  functions utilizes basic comparison on origins on tablet device and root system
 *   @return 1_true Description
 */

function compare_origins() 
{
    $size_origin_tablet=0;
    $size_origin_root=0;
    
    
    global $host_in;
    global $host_out;
    global $dbs3_in;
    global $dbs3_out;
    
     echo $sql="SELECT * FROM origin";
    
    //$connect=connect_tablet();
 
     $connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);
    
   $result=add_db($sql);
   $size_origin_tablet= mysql_num_rows($rek);
    
 // mysql_connect()
    //connect_dbs3();
   
   
      
   //END
   
    $connect=mysql_connect($host_in,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_in);
     
   
    $result=add_db($sql);
   $size_origin_root=mysql_num_rows($result);
    
   echo "SIZE TAB ".$size_origin_tablet;
   echo "SIZE dbs ".$size_origin_root;
   //compare the scope of tablet and root if is different communicate for show manifest
   //and start digging out which one is missing. I fount with collection communicate to get it befor manifest import. Manifest import done in transactional mode

   if($size_origin_root==$size_origin_tablet)
   {
      return 0;
   }
   else 
       return 1;
   
}




//END FUNCTIONS NEW MODULE

















echo "<a href=import_mobile_new.php> Re-connect </a><BR />";

$stime = microtime();  
    $stime = explode(" ",$stime);  
    $stime = $stime[1] + $stime[0];  

$host_out= get_device_from_session();
//echo "Cinnect before connect:".$host_out;
$connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);


//if($connect1=connect_dbs3())
//{
   // echo "<BR/>The Root System is Ready for transfer";
//}

process_origin_add();


//ITS Clicked Import

if(isset($_POST['Submit']))  //processing import
{
    
    //echo "Imported";
    
    $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
  //  $update_closed="UPDATE manifest_reg SET closed=1 WHERE idmanifest_reg='$id_manif'";
   // $rek=mysql_query($update_closed) or die(mysql_error());
   echo "Import ". $import_details=$id_manif;
  // $host_out;
   $FLAG_IMPORT=1;
    
}


if(!empty($host_out))
{    

if($connect) //connection details. empty connection
{
    echo "</BR></BR></BR></BR>";
    echo "Mobile Device Connection Established<BR />";
    echo "Device: ".$host_out." in range.<BR />";
    echo "Detected following Site Places</BR></BR>";
   
}


/*
if($result_if_origin_diff=compare_origins())
{
    echo "The root device has different origin table.".$result_if_origin_diff;
    
    
}*/

get_manifest_to_be_import_details();
}
//echo compare_origins();
?>
      
 



</table>
    </BR>
    
    
    

    
    <table>
        <?php 
        
        
        
        
        
        
        $sstime = microtime();  
    $sstime = explode(" ",$sstime);  
    $sstime = $sstime[1] + $sstime[0]; 
         $totaltime = ($sstime - $stime);
    echo "Load: ".$totaltime;
    echo " m/s";
      
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    try{
    mysql_query("START TRANSACTION");

$a1 = mysql_query(" INTO INTO maniets VALUES('1')");
$a2 = mysql_query("INSERT INTO reg VALUES('2')");

if ($a1 and $a2) {
    mysql_query("COMMIT");
} else {        
    mysql_query("ROLLBACK");
}
    }
    catch (Exception $e)
    {
        echo "EXCEPTION TR";
    }
    
    //END OF FLOW OF SHEET
    
    
    
    
    /**  Description of the stage: IMPORT DATA FROM TABLET TO ROOT SYSTEM. RELATION: MANY TO ONE
     *   
     * 
     *   Using/Case Scenario:
     *   
     *   1.  Get manifest register     
     *   2.  Get manifest specifics  
     *   3.  Check manifest register and specifics
     *   4.  Write manifest register
     *   5.  Write manifest specifics
     *   6.  Get Site, Site_has_cat, delivert
     *   7.  Import them 
     * 
     * 
     * 
     */
 
    
  
    
    function read_manifest_details($import_details)
    {
        //we connect to tablet system
        
         $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
            
            mysql_select_db($dbs3_out);
        
        //  we read current manifest details if is set manifest id
            
           
        if($import_details>0)
        {
            $import_specifics=0;
            echo "<h3>Import Details:</h3><BR />";
            echo "Manifest Import Number: ".$import_details."<BR/>";
            mysql_close();
            connect_tablet();
            /*
            $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
            
            mysql_select_db($dbs3_out);
            */
            //GET manifest_reg that is gona be imported
            
            $select_dbs_tab="SELECT * FROM manifest_reg Where idmanifest_reg='$import_details'";
            
            
            $result_dbs_tab=mysql_query($select_dbs_tab) or die(mysql_error());
            
            while($rek_dbs_tab= mysql_fetch_array($result_dbs_tab)) //fetch one row actually with id manifest reg on tablet
            {
                echo $id_mani=$rek_dbs_tab['idmanifest_reg'];       //fetch all details
                echo $mani_unq_num=$rek_dbs_tab['manifest_unq_num'];
                echo $date_mani=$rek_dbs_tab['date_manifest'];
                echo $driver_num=$rek_dbs_tab['driver_num'];
                echo $closed=$rek_dbs_tab['closed'];
                echo $siteid=$rek_dbs_tab['siteid'];
                echo $start_dbs=$rek_dbs_tab['start_dbs'];
                echo $end_dbs=$rek_dbs_tab['end_dbs'];
                
                
               $connect1=mysql_connect($host_in,'root','krasnal');   //connecting to internal system
               mysql_select_db($dbs3_in);
               
               //here we check if particular idmanifest counter really already exist in our dbs
               
               $SELECT="Select * FROM manifest_reg WHERE manifest_unq_num='$mani_unq_num'";  //check if not exist in root
                       $result_ch=mysql_query($SELECT);
                       $rek_ch=mysql_fetch_array($result_ch);
                       if($rek_ch['manifest_unq_num']==$mani_unq_num)
                       {   
                           echo "Given manifest already exists in root system<BR />";
                           $existing_mani_id=1;
                           
                           return IMPORT_EXIT_DETAILS_EXIST;  //returned to deal_with_errors function
                       }
                       
                       //we get confirmation or not if manifest al exist
                        else {   //if manifest not in root than go
                            
                            
                            echo "Manifest not in root system. Ready to go. Building details array";
                            //Craeting array that is passed
                            
                            $manifest_details_set=array();
                            
                            $manifest_details_set[0]=$id_mani=$rek_dbs_tab['idmanifest_reg'];       //fetch all details
                            $manifest_details_set[1]=$mani_unq_num=$rek_dbs_tab['manifest_unq_num'];
                            $manifest_details_set[2]=$date_mani=$rek_dbs_tab['date_manifest'];
                            $manifest_details_set[3]=$driver_num=$rek_dbs_tab['driver_num'];
                            $manifest_details_set[4]=$closed=$rek_dbs_tab['closed'];
                            $manifest_details_set[5]=$siteid=$rek_dbs_tab['siteid'];
                            $manifest_details_set[6]=$start_dbs=$rek_dbs_tab['start_dbs'];
                            $manifest_details_set[7]=$end_dbs=$rek_dbs_tab['end_dbs'];
                            
                            return $manifest_details_set;
                            
                            
                            
                        }
                       
              
           }
                     
                       
                       
        } //END OF WHILE FETCH
        
        
         
        
        
     }           //end of ifmani exist
            
            /*
            $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
     mysql_select_db($dbs3_out);
    // $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
    $update_closed="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$id_mani'";
    $rek=mysql_query($update_closed) or die(mysql_error());
    $import_details=$id_manif;}
    mysql_close();
            */
            
            
        
    
    
    
    function read_manifesr_specifics()
    {
        
        
    }
   
    function extract_ar($result)
    {
        $size_of_result=sizeof($result);
        for($i=0;$i<$size_of_result;$i++)
        {
            $result[$i];
            
        }
    }
    
    
    //Common problem is that we dispose static key data from manifest we dont acctualy want that, we shall follow the last_insert id to mine the unique keys like:
    // basicly no dynamic conversion module. Risk of spoiling main data in root system.
    function import_manifest($manifest_reg,$manifest_counter_result,$site_result,$site_has_cat_result,$delivery_result)
    {
        global $GME;
        echo "In import manifest";
        connect_tablet(); //here we for the last time ask tavblet before connectin to root
        //check manifest unq number
        
        
        
        
        $GME.=new_line(" In import manifest ");
        
        //
        //extract manifest reg 
        $id_manifest=$manifest_reg[0];
        $manifest_unq_num=$manifest_reg[1];
        $manifest_date=$manifest_reg[2];
        $manifest_driver=$manifest_reg[3];
        $manifest_closed=$manifest_reg[4]; //write a standard origin conversion function that
        //$manifest_siteid=$manifest_reg[5]; //converst tablet origin into dbs3 origin using post code as constanse
        $manifest_start_dbs=$manifest_reg[6];  //do it each time
        $manifest_end_dbs=$manifest_reg[7];
        
        //site for site conversion
        
         //asssuming only one site
           $GME.=new_line(" Manifest array ".$manifest_reg[0]." - ".$manifest_reg[1]." - ".$manifest_reg[2]." - ".$manifest_reg[3]." - ".$manifest_reg[4]." - ".$manifest_reg[5]);     
               
        $site=mysql_fetch_array($site_result);      
        $site_id=$site[0];
        $site_origin_origin_id=$site[1];  //here a problem cince it may be with root system origin converted. Means that origins must be converted from tablet to root
        $site_ref_number=$site[2];
        $site_rep_auth=$site[3];
        $site_dest_location=$site[4];
        $site_batch_date=$site[5];
        $site_batch_id=$site[6];
        $site_closed=$site[7];
        
        ###
         
     //get post code from tablet
        $tablet_tmp_post_code=get_post_code($site_origin_origin_id); //get origin from tablet
                            //checktabletpostcode
                        echo "NEW CONV Ori:".$new_converted_origin= root_system_origin_from_post($tablet_tmp_post_code);                
          $GME.=new_line("NEW Conv ori:".$new_converted_origin);
        $tablet_tmp_post_code=$new_converted_origin;
        /*
        $site_origin_tab=mysql_fetch_array($site_result);
     //get post code from tablet
        $tablet_tmp_post_code=get_post_code($site_origin_tab[1]); //get origin from tablet
                            //checktabletpostcode
                        echo "NEW CONV Ori:".$new_converted_origin= root_system_origin_post_code($tablet_tmp_post_code);                
        */
        
        
          //root_system_origin($origin_id);                    //check pos code root return origin id
        
        //Manifest reg id is taken from manifest, than is inserted into root system with conversion
        //we gona insert this to root system as AI. But we chcack manifest unq number 
        
        
        //extract site -stage 2
        /*
        
        $site_id=$site[0];
        $site_origin_origin_id=$site[1];
        $site_ref_number=$site[2];
        $site_rep_auth=$site[3];
        $site_dest_location=$site[4];
        $site_batch_date=$site[5];
        $site_batch_id=$site[6];
        $site_closed=$site[7];
        */
        
        //variables for module conversion
        
        $stack_trace_manifest_reg_id;
        $stack_trace_manifest_reg_unq_number;
        $stack_trace_fresh_site_id;
        
        connect_dbs3(); //here we connect to main root system
       
        //check root system
        $sql="SELECT * FROM manifest_reg WHERE manifest_unq_num='$manifest_unq_num'";
        $result=query_select($sql);
        
        if($num=mysql_num_rows($result)>0)
            return "manifest already exist in the system";
        
        /*
        //Checking if origins id is adjusted to coonversion module
        $conversion_post_code=get_post_code($site_origin_origin_id=$site[1]); //take tablet origin_id and compare to local
        
         echo $sql="SELECT origin_id FROM origin WHERE post_code='$conversion_post_code'";
         $result=query_select($sql) or die(mysql_error());
         $rek=mysql_fetch_array($result);
         $origin_in_root=$rek[0];
         echo "NEW conversion id".$origin_in_root;
          */       
        
        
        
         connect_dbs3();      
        mysql_query("START TRANSACTION");
        $flag = true;
        
            //here we insert as it goes manifest reg, but we need to keeptrace of it to update     
        
                    $manifest_siteid=0; //we use blank one 
        
            echo $query_manifest = "INSERT INTO manifest_reg(manifest_unq_num,date_manifest,driver_num,hash_serial,group1,closed,siteid,start_dbs,end_dbs) "
                    . "VALUES ('$manifest_unq_num','$manifest_date','$manifest_driver','0','0','$manifest_closed','$manifest_siteid','$manifest_start_dbs','$manifest_end_dbs')";

            
             $result = mysql_query($query_manifest) or trigger_error(mysql_error(), E_USER_ERROR);
                    if (!$result) {
                        $flag = false;
                    }
                    else {
                        echo "Result manifest register done";
                        $GME.=new_line("Result manifest register done");
                        //if inserted correctly we take last insert id
                        $stack_trace_manifest_reg_id=mysql_insert_id();
                        $stack_trace_manifest_reg_unq_number=$manifest_unq_num;
                    }
            
            //manifest counter extract
           while($manifest_counter=mysql_fetch_array($manifest_counter_result))  //SECOND QUERY
            {
               echo "executing mysql counter";
               //here we will be unsing manifest stack trace for manifest_reg
               
                 echo $manifest_counter_id = $manifest_counter[0];
                 echo $manifest_counter_manifest_counter = $manifest_counter[1];
                 $manifest_counter_sub_cat = $manifest_counter[2];
                 $manifest_counter_manifest_sub_cat = $manifest_counter[3];
                echo "reg:". $manifest_counter_manifest_reg_idmanifest_reg = $stack_trace_manifest_reg_id;    //$manifest_counter[4]; deprecated
                 $manifest_counter_finished = $manifest_counter[5];

              echo   $query_manifest_counter = "INSERT INTO manifest_counter(manifest_counter,sub_cat,manifest_sub_cat,manifest_reg_idmanifest_reg,finished) "
                         . "VALUES ('$manifest_counter_manifest_counter','$manifest_counter_sub_cat','$manifest_counter_manifest_sub_cat','$manifest_counter_manifest_reg_idmanifest_reg','$manifest_counter_finished')";


                 $result = mysql_query($query_manifest_counter) or trigger_error(mysql_error(), E_USER_ERROR);
                    if (!$result) {
                        $flag = false;
                    }
                    else{
                       echo "Result insert counter done"; 
                       
                       //here we need a fresh site id not the old one from system. Its generated on level of adding site id
                    }
             }

       

               echo "Done manifest counters successfult";  
          //IF FIRST STAGE DONE GO THROUGH SECOND ONE      
                
                
                //SITE
                
                
        //asssuming only one site
                
      /*         
        $site=mysql_fetch_array($site_result);      
        $site_id=$site[0];
        $site_origin_origin_id=$site[1];  //here a problem cince it may be with root system origin converted. Means that origins must be converted from tablet to root
        $site_ref_number=$site[2];
        $site_rep_auth=$site[3];
        $site_dest_location=$site[4];
        $site_batch_date=$site[5];
        $site_batch_id=$site[6];
        $site_closed=$site[7];
                
         */
       $site_origin_origin_id=$tablet_tmp_post_code;
                //add one site 
        
                echo $query_site = "INSERT INTO site(Origin_origin_id,site_ref_number,Rep_Auth,Dest_location,batch_date,batch_id,closed) "
                         . "VALUES ('$site_origin_origin_id','$site_ref_number','$site_rep_auth','$site_dest_location','$site_batch_date','$site_batch_id','$site_closed')";


                 $result = mysql_query($query_site) or trigger_error(mysql_error(), E_USER_ERROR);
                    if (!$result) {
                        $flag = false;
                    }
                    else
                    {
                        echo "Done site";
                       echo $stack_trace_fresh_site_id=mysql_insert_id();
                    }
                
                
                //SITE HAS CATEGORY INSERT
       

          while($site_has_cat=mysql_fetch_array($site_has_cat_result))       //IF site_has cat impoerted correctly
          {
              $i++;
                    $site_has_cat_id=$site_has_cat[0];
                    //$site_has_cat_site_site_id=$site_has_cat[1];
                    $site_has_cat_sub_cat_id=$site_has_cat[1];
                    $site_has_cat_quantity=$site_has_cat[3];
                    $site_has_cat_sum_weight=$site_has_cat[4];  

                    $site_has_cat_site_site_id=$stack_trace_fresh_site_id;
                    
                     //$site_has_cat_sum_weight=0;   
                     //only adds few
                    echo "</BR>".$i;
                     echo $query_site_has_cat = "INSERT INTO site_has_cat(Sub_cat_id_c,Site_site_id,Quantity,sum_weight) "
                                 . "VALUES ('$site_has_cat_sub_cat_id','$site_has_cat_site_site_id','$site_has_cat_quantity','$site_has_cat_sum_weight')";
                                 
                    $result = mysql_query($query_site_has_cat) or trigger_error(mysql_error(), E_USER_ERROR);
                    if (!$result) {
                        $flag = false;
                    }
                    else
                        echo "result site_has_cat Done";
       
          }
       
          
          
          //deliveries
          
        
          
          
          
                while($delivery=mysql_fetch_array($delivery_result))       //IF site_has cat impoerted correctly
                {
                        $delivery_delivery_id=$delivery[0];
                        $delivery_trans_category=$delivery[1];
                        //$delivery_site_site_id=$delivery[2];
                        $delivery_date=$delivery[3];
                        $delivery_qtty_picked_up=$delivery[4];
                        $delivery_picker1=$delivery[5];
                        $delivery_trans_ref_number=$delivery[6];
                        $delivery_closed=$delivery[7];
                        $delivery_qnum=$delivery[8];
                        $delivery_att_num=$delivery[9];
                            
                        $delivery_site_site_id=$stack_trace_fresh_site_id;
                        
                    echo $query_delivery = "INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,picker1,trans_ref_num,closed,QNum,att_num)"
                    . "VALUES ('$delivery_trans_category','$delivery_site_site_id','$delivery_date','$delivery_qtty_picked_up','$delivery_picker1','$delivery_trans_ref_number',"
                             . "'$delivery_closed','$delivery_qnum','$delivery_att_num')";
                                 
                    $result = mysql_query($query_delivery) or trigger_error(mysql_error(), E_USER_ERROR);
                    if (!$result) {
                        $flag = false;
                    }
                    else
                        echo "result succesfully done deliveries";
                    
       
                }
                
        
                //here we update site id in both manifest_reg and manifest_counter
                
                $update_manifest_reg="UPDATE manifest_reg SET siteid='$stack_trace_fresh_site_id' WHERE idmanifest_reg='$stack_trace_manifest_reg_id'";
                $result=query_select($update_manifest_reg);
                if (!$result) {
                        $flag = false;
                    }
                    else
                        echo "result succesfully updated manifest reg siteid";
                    
                  
             
        if ($flag) {
            echo "Cimmited";
            mysql_query("COMMIT");
        } else {        
            echo "Rolled backed";
            mysql_query("ROLLBACK");
        }
        //update manifest on table for cloas 1
        
        
        if($flag)
        {
            connect_tablet();
              
                    //the last one is to reove from tablet. make it unvisible
            $update_closed="UPDATE manifest_reg SET closed=1 WHERE idmanifest_reg='$id_manifest'";
            $rek=mysql_query($update_closed) or die(mysql_error());
        }
        
    }
    $import_details;
    $import_specifics;
    
    $import_site_details;
    
    
    
    
    //END OF IMPOERT FUNCTION IMPLEMENTATION
    
            
    
            
            
            
      
        // END OF IMPOERT FUNCTION IMPLEMENTATION
        
        
      //  echo "s";
        $current_manifest_register=read_manifest_details($import_details); // function calls a check for manifest import
        
        //if manifest done correctly than take one manifest counter and input
        //than take site site has cat
        
        
       //TRANSACTION
        //we connect to manifest counter and take results
               
        connect_tablet();
        
        $syntax_sql_manifest_counter="Select * from manifest_counter WHERE manifest_reg_idmanifest_reg='$import_details'";
        
     //  echo "cuurent mani details";
      //print_r($current_manifest_register);
       
        $tablet_result_manifest_counter=mysql_query($syntax_sql_manifest_counter)or die(mysql_error());
        
        //By current site id we detect and gather each detail in arrays.
       //was empty bug
        $site_id=$current_manifest_register[5]; //associative call
         $syntax_sql_site_id="select * from site WHERE site_id='$site_id'";
        $tablet_result_site=mysql_query($syntax_sql_site_id) or die(mysql_error()); 
        
        
        $syntax_sql_site_has_cat="SELECT * FROM site_has_cat WHERE Site_site_id='$site_id'";
        $tablet_result_site_has_cat=mysql_query($syntax_sql_site_has_cat) or die(mysql_error());
        
        $syntax_sql_delivery="SELECT * FROM delivery WHERE Site_site_id='$site_id'";
        $tablet_result_delivery=  mysql_query($syntax_sql_delivery)or die(mysql_error());
        
        //echo "passing";
        
      //  print_r($tablet_result_manifest_counter);
        
        
        
        //we call only if not yet detected in root particular manifest unq number
        if($FLAG_IMPORT==1)
        {
           $messages=import_manifest($current_manifest_register,$tablet_result_manifest_counter,$tablet_result_site,$tablet_result_site_has_cat,$tablet_result_delivery);
           send_email($GME."MESSAGE".$messages);  
        } 
            
            
            
            
         if(!empty($messages))  
           echo $messages;
       // echo $FLAG_MESSG;
      
      
    
       
       
       
       
        ?>
        
     
        
    </table>   
    <?php
   echo '</div>'; //END OF IMPORT MANIFEST ACORDION DIV;
       echo '</div>'; //END OF ACCORDION DIV
         
    ?>
    <h3>Import Details</h3>
<div>Details</div>
    
    
    </div>
    
    
    
</div> 


    
    
    
    
    
    
    
    
<div id="buttons_out"> 
  <h4>
  
  
 <p>  
      <a href="index.php">Return</a> 
       <!--
 <button class="submit"><a href="add.php">Another Test</a> </button> 
-->
    </p>  


</h4>       
</div>
<?php

?>
<BR><BR>
<?php



  
//<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>



</div>

</BODY>


</HTML>
