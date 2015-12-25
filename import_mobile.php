<?php
session_start();

include 'header_valid.php';
include 'import_mobile_config.php';


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
    
$connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);

return $connect;
    
}

function connect_dbs3()
{
    
$connect=mysql_connect($host_in,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_in);
    
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

function roll_back_insert_manifest_details_root($id_mani)
{
    global $host_in;
    global $dbs3_in;
    
    echo "<BR />Cleaning main root system from specifics and details. Rolling back to previous state.";
                            $connect=mysql_connect($host_in,'root','krasnal') or die(mysql_error());
                             mysql_select_db($dbs3_in);
                             $update_closed="DELETE FROM manifest_reg WHERE idmanifest_reg='$id_mani'";
                             $rek_details=mysql_query($update_closed);
                             if(!$rek_details)
                             {
                             echo "Error:#1 ".mysql_error($connect);
                             //$import_details=$id_manif;
                             }
                             echo "<BR />Cleaning Specifics";
                            
                             $update_closed="DELETE FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$id_mani'";
                             
                            $rek_specifics=mysql_query($update_closed);
                            if(!$rek_specifics)
                            {
                                echo "Error:#2 ".mysql_error($connect);
                            }
                              
                             mysql_close();
                             if($rek_details AND $rek_specifics)
                             return "<BR />Manifest cleaned ".$id_mani;
}





function roll_back_insert_site_cat($id_site)
{
    global $host_in;
    global $dbs3_in;
    
    echo "<BR />Cleaning main root system from specifics and details. Rolling back to previous state.";
                            $connect=mysql_connect($host_in,'root','krasnal') or die(mysql_error());
                             mysql_select_db($dbs3_in);
                             $update_closed="DELETE FROM site_has_cat WHERE Site_site_id='$id_site'";
                             $rek_details=mysql_query($update_closed);
                             if(!$rek_details)
                             {
                             echo "Error:#1 ".mysql_error($connect);
                             //$import_details=$id_manif;
                             }
                             echo "<BR />Cleaning site categories";
                            
                             $update_closed="DELETE FROM site WHERE site_id='$id_site'";
                             
                            $rek_specifics=mysql_query($update_closed);
                            if(!$rek_specifics)
                            {
                                echo "Error:#2 ".mysql_error($connect);
                            }
                              
                             mysql_close();
                             if($rek_details AND $rek_specifics)
                             return "<BR />Site and site_cat cleaned successfuly ".$id_mani;
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
    <center><p style=""><h3>Mobile Device Module</h3></p></center>
    </br>
    
  
    
    
    
    
    
<table id="tabel_out" border="1"  >

<?php
echo "<a href=import_mobile.php> Re-connect </a><BR />";

$stime = microtime();  
    $stime = explode(" ",$stime);  
    $stime = $stime[1] + $stime[0];  



$connect=mysql_connect($host_out,'root','krasnal')
  or die(mysql_error());

mysql_select_db($dbs3_out);


//if($connect1=connect_dbs3())
//{
   // echo "<BR/>The Root System is Ready for transfer";
//}

if(isset($_POST['Submit']))
{
    
    //echo "Imported";
    
    $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
    $update_closed="UPDATE manifest_reg SET closed=1 WHERE idmanifest_reg='$id_manif'";
    $rek=mysql_query($update_closed) or die(mysql_error());
   echo "Import ". $import_details=$id_manif;
    
}




if($connect)
{
    echo "Mobile Device Connection Established<BR />";
    echo "Device: ".$host_out." in range.<BR />";
    echo "Detected following Site Places";
   
}

$sql='SELECT DISTINCT idmanifest_reg, manifest_unq_num,driver_num,date_manifest,siteid,start_dbs,end_dbs FROM manifest_reg INNER JOIN manifest_counter ON idmanifest_reg=manifest_reg_idmanifest_reg WHERE manifest_counter.finished=1 AND closed=0';

$result=add_db($sql);


$tab = array();
for($z=0;$z<=1000;$z++)
   $tab[$z]=0;
echo '<table>';
while($rek = mysql_fetch_array($result,MYSQL_BOTH)) { //changed from 1 
   $i++;  
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
            echo '<td> <form action="import_mobile.php" method="POST">';
            $idmanifest_counter=$rek['idmanifest_reg'];
            $select_mani_count="SELECT SUM(manifest_counter) as ile FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$idmanifest_counter'";
            $result_count=mysql_query($select_mani_count);
            echo mysql_error();
            $rek_count=mysql_fetch_array($result_count);
            echo "<td>".$rek_count['ile']."</td>";
            echo $rek['driver_num'];
            $name_sub_cat=$rek['id'];   
            echo '</td><td><input type="checkbox" name="att_ck" value="';
            if(isset($_POST['att_ck'])) echo 'checked';
            echo '">'.$rek[type_2].'<br>';
  

//echo '</td><td><input style="padding:10px;margin:10px" type="text"  name="batch_date" value="'.htmlentities($weight).'">';

echo '<input style="padding:10px;margin:10px" type="hidden" placeholder="Item type" name="name_sub_cat" value="'.htmlentities($name_sub_cat).'">';


echo '<input type="hidden" name="submitted" value="1" >';

echo '<input type="hidden" name="id_manif_id" value="'.$id_manif_id.'" >';

echo "<input style='padding:10px;margin:10px' type='submit' name='Submit' value='Import' align='right'>";

	echo '</tr>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 
     //}
  
        echo "</form></td>"; 
	  //$tab[$rek["id_test"]]+=1;
}
  
echo '</tr></table><BR />';
?>
      
 



</table>
    </BR>
    
    
    

    
    <table>
        <?php 
        $sstime = microtime();  
    $sstime = explode(" ",$sstime);  
    $sstime = $sstime[1] + $sstime[0]; 
         $totaltime = ($sstime - $stime);
    echo $totaltime;
      
    
    
    
    
    
        // We come to the point where we import manifest data both details and specifics
        echo $import_details;
        if($import_details>0)
        {
            $import_specifics=0;
            echo "<h3>Import Details:</h3><BR />";
            echo "Manifest Import Number: ".$import_details."<BR/>";
            mysql_close();
            $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
            
            mysql_select_db($dbs3_out);
            
            $select_dbs_tab="SELECT * FROM manifest_reg Where idmanifest_reg='$import_details'";
            
            
            $result_dbs_tab=mysql_query($select_dbs_tab) or die(mysql_error());
            while($rek_dbs_tab= mysql_fetch_array($result_dbs_tab))
            {
                echo $id_mani=$rek_dbs_tab['idmanifest_reg'];
                echo $mani_unq_num=$rek_dbs_tab['manifest_unq_num'];
                echo $date_mani=$rek_dbs_tab['date_manifest'];
                echo $driver_num=$rek_dbs_tab['driver_num'];
                echo $closed=$rek_dbs_tab['closed'];
                echo $siteid=$rek_dbs_tab['siteid'];
                echo $start_dbs=$rek_dbs_tab['start_dbs'];
                echo $end_dbs=$rek_dbs_tab['end_dbs'];
                
                
               $connect1=mysql_connect($host_in,'root','krasnal');
               mysql_select_db($dbs3_in);
               
               //here we check if particular idmanifest counter really already exist in our dbs
               
               $SELECT="Select * FROM manifest_reg WHERE manifest_unq_num='$mani_unq_num'";
                       $result_ch=mysql_query($SELECT);
                       $rek_ch=mysql_fetch_array($result_ch);
                       if($rek_ch['manifest_unq_num']==$mani_unq_num)
                       {   
                           echo "Given manifest already exists in root system<BR />";
                           $existing_mani_id=1;
                       }
                       
                       //we get confirmation or not if manifest al exist
                        else {
                $insert_dbs3="INSERT INTO manifest_reg(idmanifest_reg,manifest_unq_num,date_manifest,driver_num,hash_serial,group1,closed,siteid,start_dbs,end_dbs) VALUES('$id_mani','$mani_unq_num','$date_mani','$driver_num','0','0','$closed','$siteid','$start_dbs','$end_dbs')";
                       $result_dbs3=mysql_query($insert_dbs3); 
                               echo "BASIC: ".mysql_error($connect1) ;
                                echo $last_inserted_mani=mysql_insert_id();
                       // $import_specifics=mysql_insert_id();
                       echo "<BR />".$result_dbs3;
                        
                //checinh in if in root system there exists: mani unq num
                       
                       
               if(!$result_dbs3){
                   
               
               
               //we remove idmanifest reg acuse root system has auto in this gives us uniqe siteplaces
               $insert_dbs3="INSERT INTO manifest_reg(manifest_unq_num,date_manifest,driver_num,hash_serial,group1,closed,siteid,start_dbs,end_dbs) VALUES('$mani_unq_num','$date_mani','$driver_num','0','0','$closed','$siteid','$start_dbs','$end_dbs')";
                       $result_dbs3=mysql_query($insert_dbs3); 
                               echo "Parallel: ".mysql_error($connect1) ;
                               $last_inserted_mani=mysql_insert_id();
                       // $import_specifics=mysql_insert_id();
                       echo "<BR />".$result_dbs3;
                       
               }
                        }
                       if($result_dbs3)
                       {
                           echo "Successfuly Imported Manifest Details";
                           //changing idmani formani unique_num or for last insert id
                           $import_specifics=$id_mani;  $last_inserted_mani;     ///$mani_unq_num;    //$id_mani;
                           $site_place=$siteid;
                           //$import_specifics=mysql_insert_id();
                           echo $import_specifics;
                           mysql_close();
                       }
                       
                       
        }}           //end of ifmani exist
            
                        
 else { 
     
     $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
     mysql_select_db($dbs3_out);
    // $id_manif=$_POST['id_manif_id'];
    //echo $id_manif;
    $update_closed="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$id_mani'";
    $rek=mysql_query($update_closed) or die(mysql_error());
    $import_details=$id_manif;}
    mysql_close();
            
    //STATUS CHECk    
    
    
            
            if($import_specifics>0)
            {
                echo "<BR />Prepering to import specifics";
            
                $connect=mysql_connect($host_out,'root','krasnal')
            or die(mysql_error());
            
            mysql_select_db($dbs3_out);
            
            $select_dbs_tab="SELECT * FROM manifest_counter Where manifest_reg_idmanifest_reg='$import_specifics'";
            
            
            $result_dbs_tab=mysql_query($select_dbs_tab) or die(mysql_error());
            while($rek_dbs_tab= mysql_fetch_array($result_dbs_tab))
            {
                $id_mani_counter=$rek_dbs_tab['id_manifest_counter'];
                $mani_counter=$rek_dbs_tab['manifest_counter'];
                $sub_cat=$rek_dbs_tab['sub_cat'];
                $mani_reg=$rek_dbs_tab['manifest_reg_idmanifest_reg'];
                $finished=$rek_dbs_tab['finished'];
               
                $i_counter++;
                
               $connect1=mysql_connect($host_in,'root','krasnal');
               mysql_select_db($dbs3_in);
               
               
               //M->M
               $mani_reg=$last_inserted_mani;
               //$mani_reg=$import_details;
               //here we also switch idmanifest counter to be removed ve need more flexible import
               //$insert_dbs3="INSERT INTO manifest_counter(id_manifest_counter,manifest_counter,sub_cat,manifest_reg_idmanifest_reg,finished) VALUES('$id_mani_counter','$mani_counter','$sub_cat','$mani_reg','$finished')";
               $insert_dbs3="INSERT INTO manifest_counter(manifest_counter,sub_cat,manifest_reg_idmanifest_reg,finished) VALUES('$mani_counter','$sub_cat','$mani_reg','$finished')";        
               $result_dbs3=mysql_query($insert_dbs3);
               echo "<BR/>Manifest specifics failed error: ".mysql_error();
               
               if(mysql_error($connect1)!=0)
              echo "Import Error: ".mysql_error($connect1);
                       if($result_dbs3)
                       {
                           
                           if($i_counter==1)
                           {
                               //sleep(2);
                               echo "<BR />Successfuly Imported Manifest Specifics";
                           }
                               $imported=1;
                          // $import_specifics=mysql_insert_id();
                           mysql_close();
                       }
                       else{
                            echo "<BR />Mannifest specifics failed to be import";
                            $connect=mysql_connect($host_out,'root','krasnal') or die(mysql_error());
                             mysql_select_db($dbs3_out);
                             $update_closed="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$id_mani'";
                             $rek=mysql_query($update_closed);
                             if($rek)
                             echo "Error:#1 ".mysql_error($connect);
                             $import_details=$id_manif;
                             mysql_close();
                             echo "<BR />Cleaning";
                            $connect=mysql_connect($host_in,'root','krasnal') or die(mysql_error());
                             
                             $update_closed="DELETE FROM manifest_reg WHERE idmanifest_reg='$id_mani'";
                            /* 
                            $rek=mysql_query($update_closed);
                            if($rek)
                            echo "Error:#2 ".mysql_error($connect);
                             $import_details=$id_manif;
                             mysql_close();
                             */
                       }
           
             
                       }
                
                
                
                
                
                
                
                
                
            }
            
            
            
            if($import_specifics>0)
    {
        mysql_connect($host_out,$username,$password);
        mysql_select_db($dbs3_out);
       $status="SELECT * FROM manifest_reg WHERE idmanifest_reg='$import_details'";
       $result=mysql_query($status) ;
       echo "<BR/>ERROR#status 1 check : ".mysql_error();
       
       
       echo "<BR/>Manifest details for SCM: <BR/>";
       while($rek=mysql_fetch_array($result))
       {
            
                echo "<BR/>Manifest ID: ".$idmanif_stat=$rek['idmanifest_reg'];
                echo "<BR/>Manifest UNIQUE NUMBER: ".$mani_unq_num_stat=$rek['manifest_unq_num'];
                echo "<BR/>Date Manifest: ".$date_mani_stat=$rek['date_manifest'];
                echo "<BR/>Driver ID: ".$driver_num_stat=$rek['driver_num'];
                echo "<BR/>Manifest Closed: ".$closed_stat=$rek['closed'];
                echo "<BR/>Site ID: ".$siteid_stat=$rek['siteid'];
                echo "<BR/>START DBS: ".$start_dbs_stat=$rek['start_dbs'];
                echo "<BR/>END_DBS: ".$end_dbs_stat=$rek['end_dbs'];
           
                
                echo "<BR/><BR/>STATUS: <BR/>";
                
                echo "<BR/>First Label: ";
                if(!empty($start_dbs_stat))
                {
                    echo "Set";
                }
                else
                echo "Not set"; 
                
                echo "<BR/>Last Label: ";
                if(!empty($end_dbs_stat))
                {
                    echo "Set";
                }
                else
                echo "Not set"; 
               
                $barcode=$start_dbs_stat;
                 echo "<BR/>Labels coherency: ";
                if((get_barcodes_from_db($barcode))==0)
                {
                    echo "Coherent";
                }
                else
                echo "Not Cohernet";
                
                
                
                
                
                
           
           
       }
        
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    //END of STATUS CHECK
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        
        
        //prepering to import att delivery site and categories
        if($imported==1)
        {
            
            //first we take every detail 
            //sleep(2);
            echo "<BR/>Loading Site details into transfering module ".$siteid." ";
            $mtime = microtime();  
    $mtime = explode(" ",$mtime);  
    $mtime = $mtime[1] + $mtime[0]; 
    
     $totaltime = ($mtime - $stime);
    echo $totaltime;
    mysql_close();
    
    $connect=connect_tablet();
    //conversion of site ido into site local system must be auto incremented as a new one
    $connect=mysql_connect($host_out,'root','krasnal') or die(mysql_error());
    mysql_select_db($dbs3_out); //without this no db selected? 
    echo "  :".$site_place;
    $site_sql="Select * from site Where site_id='$site_place'";
    $result_site=mysql_query($site_sql) ;
    echo " ".mysql_error();
    echo '<BR/>Prepering to Load site details  ';
    while($rek_site=mysql_fetch_array($result_site))
    {
        echo "IN";
     echo  $rek_site['site_id']."<BR/>";
      echo $rek_site['Origin_origin_id']."<BR/>";
     echo  $rek_site['site_ref_number']."<BR/>";
     echo  $rek_site['Rep_Auth']."<BR/>";
      echo  $rek_site['Dest_Location']."<BR/>";
       echo  $rek_site['batch_date']."<BR/>";
         echo $rek_site['batch_id']."<BR/>";
         echo  $rek_site['closed']."<BR/>";
       
       echo "<BR/>Site Details Loaded into Buffer ";
       echo "<BR/>checkin Compability mode ".$id_manif;
       
       connect_dbs3();
       
       mysql_select_db($dbs3_in);
       $check_compability=$site_sql;
       $result_compability= mysql_query($check_compability) or die(mysql_error());
       if($result_compability)
           echo "<BR/> Compability checked successfuly ";
       else
           echo "<BR/> Compability checked failed. prepering to turn on Conversion modul.. <BR/><BR/>";

       
       //echo "Conversion Modul Set Up;";
       
       if(!$result_compability)
       {
           echo "Conversion Modul Set Up<BR/><BR />";
           echo "Echoing a current dump. Recieved from root system";
           
           /*while($rek_echo=mysql_fetch_array($result_compability))
           {
               
           }*/
           $dump=array();
        echo $dump=mysql_fetch_alias_array($result_compability);
           
           
           //here we go conversion module
           
       }
 else {
       echo "<BR />Systems coherent: Prepering to write: ";
       echo  $site_id_w=$rek_site['site_id']; echo "<BR/>";
        echo $origin_origin_id_w=$rek_site['Origin_origin_id']; echo "<BR/>";
       echo  $site_ref_num_w=$rek_site['site_ref_number']; echo "<BR/>";
       echo  $rep_auth_w=$rek_site['Rep_Auth']; echo "<BR />";
        echo  $dest_location_w=$rek_site['Dest_Location']; echo "<BR/>";
       echo  $batch_date_w=$rek_site['batch_date']; echo "<BR/>";
         echo $batch_id_w=$rek_site['batch_id']; echo "<BR/>";
         echo  $closed_w=$rek_site['closed']; echo "<BR/>";
       
         $wsstime = microtime();  
    $wsstime = explode(" ",$wsstime);  
    $wsstime = $wsstime[1] + $wsstime[0]; 
         $totaltime_w = ($wsstime - $stime);
   
         
         echo "<BR />Preparing statement";
         echo "<BR/>Resources used until now ".$totaltime_w;
         echo "<BR />-Resources used for Device communication";
         
         echo "<BR/>Puting site into conversion modul conversion module: INPUT: ".$site_id_w;
         echo "  OUTPUT: ".$site_id_root_converted=conv_max_site_id()+1;
         
         $sql_write="INSERT INTO site(site_id,Origin_origin_id,site_ref_number,Rep_Auth,Dest_Location,batch_date,batch_id,closed) "
                 . "VALUES('$site_id_root_converted','$origin_origin_id_w','$site_ref_num_w','$rep_auth_w','$dest_location_w','$batch_date_w','$batch_id_w','$closed_w')";
         $result_write=mysql_query($sql_write);
         if($result_write)
         echo "<BR /> Root system writing error: ".mysql_error();
         echo "Buffer Loaded into Main System memory";
         if($result_write)
         {
            echo "<BR/>Site in Root System"; 
            
            echo "<BR />Prepering Subcategories to be transfered";
            
            echo "<BR/> Prepering mobile site identification ".$site_id_w;
            echo "<BR />Calling Transfering System for Subcategories translation:. Error: System does not exist. Encapsulation cannot be done. ";
            $connect=mysql_connect($host_out,$username,$password);
            mysql_select_db($dbs3_out);
            
            
            
          //  $select_mobile_subcat="SELECT * FROM site_has_cat INNER JOIN sub_cat ON site_has_cat.Sub_cat_id_c=sub_cat.id_c
//INNER JOIN weight ON weight.id=sub_cat.Weight_id INNER JOIN category ON category.id=sub_cat.id_c WHERE site_has_cat.Site_site_id='$site_id_w'";
            
            $select_mobile_subcat="SELECT * FROM site_has_cat INNER JOIN sub_cat ON site_has_cat.Sub_cat_id_c=sub_cat.id_c
 WHERE site_has_cat.Site_site_id='$site_id_w'";
            // AND sub_cat.Category_id=weight.id AND sub_cat.Weight_id=weight.id ,weight,category
            
            $result_mobile_subcat=mysql_query($select_mobile_subcat) or die(mysql_error());
            echo "<BR />Setting transactional mode.";
            echo "<BR /> Printing manifest instances: ";
            echo "<table>";
            while($rek_mobile_subcat=  mysql_fetch_assoc($result_mobile_subcat))
            {
                echo "<tr>";
              //  echo $rek_mobile_subcat['Name_sub'];   
                foreach ($rek_mobile_subcat as $key => $value) { // Loops 4 times because there are 4 columns
                  echo "<td>".$value."</td>";
                   //echo "<td>".$rek_mobile_subcat[$key]."</td>"; // Same output as previous line
             }
             echo "</tr>";
    //echo ['product_id']; 
            } 
            echo "</table>";
            
            
            echo "<BR />Calling Conversion Module";
            
            echo "<BR />Identifying weights and categories";
            $result_mobile_subcat=mysql_query($select_mobile_subcat);
            $manifest_size=mysql_num_rows($result_mobile_subcat);
            echo "<BR /> Manifest size: ".$manifest_size;
            /*
            $insert_count=0;
            do {
              $insert_count++;  
              
              
            }while($insert_count<=$manifest_size);
            */
            
            while($rek_mobile_subcat=mysql_fetch_array($result_mobile_subcat))
            {
               echo $rek_mobile_subcat['id'];
               $sub_cat_id_c=$rek_mobile_subcat['Sub_cat_id_c'];
               $site_site_id_c=$rek_mobile_subcat['Site_site_id'];
               $quantity=$rek_mobile_subcat['Quantity'];
               $sum_weight=$rek_mobile_subcat['sum_weight'];
               
               $rek_mobile_subcat['id_c'];
               
               echo $categoryid=$rek_mobile_subcat['Category_id'];
               echo $weightid=$rek_mobile_subcat['Weight_id'];
               $name_sub=$rek_mobile_subcat['Name_sub'];
               $kind=$rek_mobile_subcat['kind'];
               
               $weight=array();
               $weight=get_weight($weightid);
               if(!empty($weight))
               {
                   echo "<BR/>Weights taken from Mobile System";
                  
                   
               }
               //echo $weight['id'];
               //echo $weight['weight'];
               $category=array();
               $category=get_category($categoryid);
               if(!empty($category))
               {
                   echo "<BR/>Category taken from Mobile System";
                   
                   
               } 
               
               if(!empty($category) AND !empty($weight))
               {
                   mysql_connect($host_in,'root','krasnal');
                   mysql_select_db($dbs3_in);
                   
                   echo "<BR />Category transfer. Sub_cat";
                  
                   echo "Problem with conversion module. Assigned to sub cat";
                   $insert_subcat="INSERT INTO sub_cat(id_c,Category_id,Weight_id,Name_sub, kind) Values('$sub_cat_id_c','$weightid','$categoryid','$name_sub','$kind')";
                   //$result_subcat=mysql_query($insert_subcat);
                   echo "<BR />Error Inserting Site Cat ".mysql_error();
                   if($result_subcat)
                   {
                           $last_id_sub=mysql_insert_id();
                            echo "Standard translatione done ".$rek_mobile_subcat['id_c']." to ".$last_id_sub;  
                            
               
                   }
                   else
                       $roll_back_sub_cat=1;
                   
                   
                   
                   
                   
                   echo "<BR />Site id root converted ".$site_id_root_converted;
                   
                   echo "<BR/> Transfering manifest sitecategory. ".$rek_mobile_subcat['id'];
                   $insert_manifest="INSERT INTO site_has_cat(Sub_cat_id_c,Site_site_id,Quantity,sum_weight) Values('$sub_cat_id_c','$site_id_root_converted','$quantity','$sum_weight')";
                   $result_sub_cat=mysql_query($insert_manifest);
                   echo "<BR />Error Inserting Site Cat ".mysql_error();
                   if($result_sub_cat)
                   {
                           $last_id_sub=mysql_insert_id();
                            echo "Standard translatione done ".$rek_mobile_subcat['id']." to ".$last_id_sub;   
               
                   }
                   else
                       $roll_back_site_has_cat=1;
                   
                    $in_wsstime = microtime();  
    $in_wsstime = explode(" ",$in_wsstime);  
    $in_wsstime = $in_wsstime[1] + $in_wsstime[0]; 
         $totaltime_inw = ($in_wsstime - $wsstime);
   
                   echo "<BR />Resources used to this operation: ".$totaltime_inw;
                   
               }
                           
             
    
            }
            if($roll_back_site_has_cat==1)
            {
                echo "<BR/>Prepering to roll back site categories ";
                $res_roll=roll_back_insert_site_cat($site_id_root_converted);  
                echo $res_roll;
                
            }
            
            echo "<BR />Root system: ";
            
           
            
            $select_mobile_subcat="SELECT * FROM site_has_cat INNER JOIN sub_cat ON site_has_cat.Sub_cat_id_c=sub_cat.id_c
 WHERE site_has_cat.Site_site_id='$site_id_root_converted'";
            // AND sub_cat.Category_id=weight.id AND sub_cat.Weight_id=weight.id ,weight,category
            
            $result_mobile_subcat=mysql_query($select_mobile_subcat) or die(mysql_error());
         
            echo "<BR /> Printing root system instances: ";
            echo "<table>";
            while($rek_mobile_subcat=  mysql_fetch_assoc($result_mobile_subcat))
            {
                echo "<tr>";
              //  echo $rek_mobile_subcat['Name_sub'];   
                foreach ($rek_mobile_subcat as $key => $value) { // Loops 4 times because there are 4 columns
                  echo "<td>".$value."</td>";
                   //echo "<td>".$rek_mobile_subcat[$key]."</td>"; // Same output as previous line
             }
             echo "</tr>";
    //echo ['product_id']; 
            } 
            echo "</table>";
            
            
            /*
            $view=array();
            $view=mysql_fetch_table($result_mobile_subcat);
            for($i=0;$i<sizeof($view);$i++)
            {
                echo $view[$i];
                
            }
             * 
             */
            
            echo "<BR/><Automatic comparison: turn off>..";
            echo "<BR/><BR/><Preparing to import att's>..";
            mysql_close();
            mysql_connect($host_out,$username,$password);
            mysql_select_db($dbs3_out);
            
            $select_att="SELECT * FROM delivery WHERE Site_site_id='$site_id_w'";
            $result_att=mysql_query($select_att); 
            echo "<table>";
            while($rek_mobile_subcat=  mysql_fetch_assoc($result_att))
            {
                echo "<tr>";
              //  echo $rek_mobile_subcat['Name_sub'];   
                foreach ($rek_mobile_subcat as $key => $value) { // Loops 4 times because there are 4 columns
                  echo "<td>".$value."</td>";
                   //echo "<td>".$rek_mobile_subcat[$key]."</td>"; // Same output as previous line
                 
             }
             echo "</tr>";
    //echo ['product_id']; 
            } 
            echo "</table>";
            echo "<BR /> Prepering to conversion..".$site_id_root_converted;
            
            $result_att=mysql_query($select_att);
            while($rek_att=mysql_fetch_array($result_att))
            {
                $i++;
                $trans=$rek_att['Trans_Category_Category_id'];
                $site_id_tmp_att=$rek_att['Site_site_id'];
                $date=$rek_att['date'];
                $qtty=$rek_att['QtyPickedUp'];
                $picker1=$rek_att['picker1'];
                $trans_ref_num=$rek_att['trans_ref_num'];
                $closed=$rek_att['closed'];
                $qnum=$rek_att['QNum'];
                $att_num=$rek_att['att_num'];
                
                
                mysql_connect($host_in,$username,$password);
                mysql_select_db($dbs_in);
                $sql_insert="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,QtyPickedUp,picker1,trans_ref_num,closed,QNum,att_num) "
                        . "VALUES('$trans','$site_id_root_converted','$date','$qtty','$picker1','$trans_ref_num','$closed','$qnum','$att_num')";
                $result_att_in=mysql_query($sql_insert);
                if($result_att_in)
                {
                    echo "<BR/>Import #".$i." Done successfuly";
                    $convert_site="UPDATE manifest_reg SET siteid='$site_id_root_converted' WHERE idmanifest_reg='$last_inserted_mani'";
                    mysql_query($convert_site) or die(mysql_error());
                    echo "<BR/>LAsT INSERTED MANI".$last_inserted_mani."Import details ".$import_details;
                    
                    
                     $convert_site="UPDATE manifest_counter SET manifest_reg_idmanifest_reg='$last_inserted_mani' WHERE manifest_reg_idmanifest_reg='$mani_reg='";
                    //mysql_query($convert_site) or die(mysql_error());
                
                     //than do the callculations for site id
                     //echo $start_dbs-$end_dbs;
                     if(isset($start_dbs)AND isset($end_dbs))
                     {
                     $space=split_barcode($start_dbs,$end_dbs);
                     $update_site_space="UPDATE site SET closed='$space' WHERE site_id='$site_id_root_converted'";
                     $result_space=mysql_query($update_site_space);
                     //$rek_space=mysql_fetch_array($result_space);
                     }
                     else 
                        echo "Ending barcode not set. Not calculated"; 
                }
                else
                    echo mysql_error();
            }
            
            
            
            
            
         }
         else 
         {
             echo "<BR />Rolling_back :".$manifest_id=$import_details;
             echo "<BR />Rolled backed. ".roll_back_manifest($manifest_id);
             roll_back_insert_manifest_details_root($last_inserted_mani);
             
             //rolling back site,sitecat and delivery
             
             
             
         }
         
       
       }
      
        
        
    }
    
    
    
    
    
    
            
            
            //later we import them into root system
            
            
            
            
            
            
            
            
        }
        
        
        ?>
        
        
        
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
?>
<BR><BR>
<?php
//<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>
</BODY>
</HTML>