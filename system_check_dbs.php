<?php
session_start();
ini_set('max_execution_time', 0); 
$host='127.0.0.1';
$dbs='dbs3';
$username='root';
$password='krasnal';

$FLAG_BARCODE='dbs/021500/2';
$FLAG_HOW_MANY=400;

//A BLOCK OF BOR FUNCTIONS FROM STOCK IN

//Lets measuer execution time

 
$FLAG_GO=0;


 

if(isset($_POST['barcode_set']))
{
    echo $_POST['dbs_start'];
    echo $FLAG_BARCODE=$_POST['dbs_start'];
    echo $FLAG_HOW_MANY=$_POST['many'];
    $FLAG_GO=1;
}

//LETS SET A FLAGS

$COUNTER_BREAK=0;

$OLD_MODE=0;
$SITE_OLD_MODE=0;

$NEW_CALCULATION=1;

$EXTENDED_MODULE=0;
$SITE_CONTAINER_EXT=0;

$error_factor=0;
$TEST_T=0;
$MESSG=0;
$MESSG_EX=-1; //to do not priv menu when item not filled

$WR=0;

$CONFIG_MODE=1;
$IS_SET_WEIGHT=0;
$WEIGHT_PASS=0;

$DOCUMENT_ROOT;
$ro_active=0;
$omit=0;

$host='127.0.0.1';
 $dbs3='dbs3';
  $username='root';
$password='krasnal';


function check_unq($barcode)
{
    global $EXTENDED_MODULE;
     echo "<BR/>PREFIX ".$prefix=substr($barcode,0,3);
   //echo "<BR />".
     echo    "<BR/>POSTFIX ".$pre_increment =  substr($barcode,4,8);
     
    if(strcmp($prefix,"UNQ")==0)
    {
      echo "UNQ Compared";
      echo $pre_increment;
      echo strlen($pre_increment);
      echo "EXTENDED MODULE ".$EXTENDED_MODULE=1; 
      //if(strlen($pre_increment)==6)
      return $barcode;  
      //else
        //  return 0;
    
    }
    else 
        return $barcode;
    
}




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
    //echo "Przekazany bar".$barcode;
    //echo split_barcode($barcode);
    //get barcode, search whole database, serialize and compare if ok return site place
    //echo "<BR/><BR/><BR/>inside get_barcodes;";
    //$siteid=$_SESSION['site_id_s'];
   // echo "s";
    global $COUNTER_BREAK;
    global $host;
    global $username;
    global $password;
    global $NEW_CALCULATION;        
    global $dbs3;
    $con=mysql_connect($host,$username,$password);
    mysql_select_db($dbs3);
   // print "con".$con;
    //echo "get_bar ".$siteid;
    $query="SELECT * FROM manifest_reg ORDER BY idmanifest_reg DESC";  //changing order for bigggest/ most recent first gives amazing efficency rise from 0,46 ms to 0,046. ten times better
    $result=mysql_query($query)or die(mysql_error());
   // echo "qud".$result;
    //echo "<BR/>Interpreter: ".mysql_error();
    $check_buffor_register=array();
    $z_counter=0;
    $return_flag=0;
    while($rek=mysql_fetch_array($result))
    {
    
      // echo "<BR/>Starting Barcode From manifest Register ";
       $start_dbs=$rek['start_dbs'];
       $end_dbs=$rek['end_dbs'];
       $idmanifest_reg=$rek['idmanifest_reg'];
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
      {  //do for each of manifest registy take a siteid and process individualy
          //take from site table
         $query="SELECT siteid FROM manifest_reg WHERE idmanifest_reg='$idmanifest_reg'";
     $result_count=mysql_query($query) or die(mysql_error());  
     while($rek_count=mysql_fetch_array($result_count))
     {
		// echo "ssi";
           $site_id_tmp=$rek_count['siteid'];
            $query="SELECT * FROM site WHERE site_id='$site_id_tmp'";
     $result_count=mysql_query($query) or die(mysql_error());
     if(mysql_num_rows($result_count)>1)
         die(mysql_error ());
     while($rek_site=mysql_fetch_array($result_count)){
               $size_calculation_site=$rek_site['closed'];  //get a set of range
              }
       
        //get sites ends here
     } 
          
         //end else 
      }
    //standard code
     $barcode=strtolower($barcode);
     $dbs_set=array();
     global $error_factor;
     $suma=0;
     $dbs_prob_set=$suma+$error_factor;
     //echo $barcode;
     //echo $barcode;
     if($NEW_CALCULATION==1)
     {
         
          // "Second serialisation cicrut active";
          $dbs_prob_set=$size_calculation_site;    //initialise given manifest id by its reall range
     }
     else
     {
       
     }
     //echo "1";
     $next_dbs=$start_dbs;
     
     //this shall solve unset value
     $initializer=0;
     for($i=0;$i<$dbs_prob_set;$i++) //to as site size says, that many times
     {
        /**
         * Optimisation method using so called initialiser initializing it with 1 while detected one site id, than carrying on untill 100 more barcodes than quits with
         * successs. Or if met the overlapped set, that means if another flag returned during this 100 hunders than gives value -5 error message
         */
         $initializer++;
         if($initializer==100 AND $return_flag==1)
             return $siteid;
         
        $dbs_set[$i]=  strtolower($next_dbs);  //first is start dbs
       $next_dbs=split_barcode($next_dbs);
        //echo $dbs_set[$i]."<BR />";
        //echo "First : ".$dbs_set[$i]."Second : ".$barcode;
        $result_cmp=strcmp($dbs_set[$i],$barcode);
         if($result_cmp==0)
         {
			// echo "cmp";
           // echo "<BR/><BR/>Detected Comparison: ".$dbs_set[$i]." AND ".$barcode;
           //   echo " Sum: ".$suma;
        //   echo " Result ".$barcode;
        //   echo " Range ".$dbs_set[0]." ".$dbs_set[$dbs_prob_set];
        //    echo " ~Result ".$barcode;
             $siteid=$rek['siteid'];
       //     echo $start_dbs;
            $return_flag+=1;
            
            
            //optimisation way
            if($return_flag==1) //if already 1 site. impossible to find another in lets say 1 hundred steps. locality rule than return
            {  $initializer=1;
               
            }
            if($return_flag>1)
            {
                return -5;
            }
            
            
            
      //      echo "<BR/><BR/>";
             while($rek_count['ile']>40)
         {
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
             //break;
             return -2;
         }
         
          //return $siteid;
         // echo "el";
         }
        
     }
  //   echo "<BR /><BR/>";
    }
  //  echo "<BR/><BR/> ";
    //echo "Return flag: ".$return_flag;
   /* if($z_counter>1)
    {
       echo "Z Buffor size abnormal ".$z_counter; 
       return -2;
    }*/
   // echo "end";
    mysql_close($con);
    
    if($return_flag>1) //if is more than one fetch than sayd it's overlaping data set. critical error. But we must turn off our optimisation algorithm
    {
        return -5;
    }
    
    if($return_flag==1)
    {    
    $_SESSION['site_id_s']=$siteid;
    return strtoupper($siteid);
    
    }
    else
    {
		 $COUNTER_BREAK+=1;
         $_SESSION['site_id_s']=0; 
      //echo "<BR/>";  
      echo "<BR/>Braekin Bad";   
      return 0;  
       
      
    }
      
    }


//function for validation stocking names and input data

function add_db_format($input)
{
  $output=addslashes($input);  
  return $output;  
}



//FUNCTION TO IMPROVE SPEED



//END OF BLOCK


?>

<HTML>
<HEAD>

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">



<link rel="stylesheet" href="jquery-ui/jquery-ui-1.11.2.custom/jquery-ui.css" type="text/css">
      <script src="jquery-ui/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
      <script src="jquery-ui/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
</HEAD>
<BODY>
    <SCRIPT>
        $(function (){
            $("input").button();
        });
    </SCRIPT>
<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>
</BR></BR>

<div id="tabel_wrap_out"></BR>
    </br>
    <center><p style=""><h3>System Checkup and Recovery </h3></p></center>
    </br>
    
    <?php
echo '<form action="system_check_dbs.php" METHOD="POST">';

echo '<input type="text" name="dbs_start" value="" placeholder="dbs/000111/1">';
echo '<input type="text" name="many" value="" placeholder="how many..">';
echo '<input type="Submit" name="barcode_set" value="Check">';
echo "</form>";    


     $LIMIT_SITES=50;
    ?>
    </BR></BR></BR></BR>
    <h4>Recent sites availible <?php echo $LIMIT_SITES; ?></h4>
    
    <?php
      mysql_connect($host,$username,$password);
    mysql_select_db($dbs);
   
    
     
     
    
    //user
    
    echo '<table>';
    $sql="SELECT * FROM manifest_reg ORDER BY idmanifest_reg DESC LIMIT $LIMIT_SITES";
    $result=mysql_query($sql)or die(mysql_error());
    while($rek=mysql_fetch_array($result,MYSQL_BOTH))
    {
      echo '<tr>';  
      echo '<td>';
    echo $rek["siteid"];
    echo '</td>';
    //echo " ";
    echo '<td>';
    echo $rek['start_dbs'];
    echo '</td>';
    //echo " - ";
    echo '<td>';
    echo $rek['end_dbs'];
    echo '</td>';
    echo '<td>';
    echo "+ Site Size: ";
    
    //site
    
    $site_id=$rek["siteid"];
    $sql_site="SELECT * FROM site WHERE site_id='$site_id'";
    $result_site=  mysql_query($sql_site)or die(mysql_error());
    $rek_site=mysql_fetch_array($result_site,MYSQL_BOTH);
   
    echo $rek_site["closed"];
echo '</td>';    
//site
    echo '<td>';
    $size=$rek_site["closed"];
    echo '<form action="system_check_dbs.php" method="POST">';
    echo '<input type="text" lenght="4" name="" value="" placeholder="Items '.$size.'">';
    echo '<input type="submit" name="edit" value="edit">';
    echo '</form>';
    
    //echo "</BR>";
    echo '</td>';
    echo '<td>';
    echo 'Picker: ';
    $rek['driver_num'];
    $log_name="";
    //user
     $sql_user="SELECT id_user,login FROM user_2";
     $result_users=mysql_query($sql_user);
   while($rek_user=mysql_fetch_array($result_users))
   {
       if($rek_user['id_user']==$rek['driver_num'])
         $log_name=$rek_user["login"];  
   }
   echo $log_name;
    echo '</td>';
    }
    echo '</tr>';
    echo '</table>';
            ?>
    
    
  <h4> Manifest Register AND Manifest Counter:</h4>
    <?php
  
    
    $border_mani=70;
    $check_up="SELECT COUNT(idmanifest_reg) as ile, idmanifest_reg FROM manifest_counter INNER JOIN manifest_reg ON manifest_reg.idmanifest_reg=manifest_counter.manifest_reg_idmanifest_reg GROUP BY manifest_reg_idmanifest_reg,idmanifest_reg
";
            $result_check=mysql_query($check_up);
            while($rek_check=mysql_fetch_array($result_check))
            {
              if($rek_check['ile']>$border_mani)
              {
                  echo "<BR />SYSTEM Manifest idmanifest_reg_idmanifest_reg NOT COHERENT: ".$rek_check['idmanifest_reg'];
                  echo "<BR/>";
                  $incoherent=$rek_check['idmanifest_reg'];
                  $select="SELECT siteid from manifest_reg WHERE idmanifest_reg='$incoherent' ";
                  $res_select=mysql_query($select);
                  while($rek=mysql_fetch_array($res_select))
                  {
                      echo "Site id: ";
                      echo $rek['siteid'];
                      
                      //echo "<BR/>Manifest counter: ".$rek['id_manifest_counter'];
                     
                  }
                  
              }
                
            }
            
            
            
            echo "<BR/><BR/> Sites";
            
            $sites_sql="SELECT * FROM manifest_reg
Right JOIN site ON manifest_reg.siteid=site.site_id
WHERE manifest_reg.siteid is NULL";
            $result=mysql_query($sites_sql) or die(mysql_error());
            while($rek=mysql_fetch_array($result))
            {
              echo $rek['site_id'];
              echo "<BR/>";
            }
    
    
    
    ?>
    
    
    
    
<table id="tabel_out" border="1"  >

    
    
<?php

$barcode=$FLAG_BARCODE;
$i=0;
$total_sum_time=0;
$last_barcode;

// Turn off output buffering
ini_set('output_buffering', 'off');
// Turn off PHP output compression
ini_set('zlib.output_compression', false);
         
//Flush (send) the output buffer and turn off output buffering
//ob_end_flush();
while (@ob_end_flush());
         
// Implicitly flush the buffer(s)
ini_set('implicit_flush', true);
ob_implicit_flush(true);
 
//prevent apache from buffering it for deflate/gzip
header("Content-type: text/plain");
header('Cache-Control: no-cache'); // recommended to prevent caching of event


$filename="diagnosis/overlapped". str_replace($FLAG_BARCODE,'/','').".txt";
echo $filename;
$fw=fopen($filename,"a");

$filename="diagnosis/empty".  str_replace($FLAG_BARCODE,'/','').".txt";
$fwe=fopen($filename,"a");

$all_overlapped=array();
$overlapped=0;

if($FLAG_GO==1)
{ 

do{
$barcode=split_barcode($barcode);
// A loop for query. We will observe the complexity and efficiency of site acgureing function



$stime = microtime();  
    $stime = explode(" ",$stime);  
    $stime = $stime[1] + $stime[0];  

$conf_barcode=get_barcodes_from_db($barcode);

$sstime = microtime();  
    $sstime = explode(" ",$sstime);  
    $sstime = $sstime[1] + $sstime[0]; 
         $totaltime = ($sstime - $stime);
    

if($conf_barcode==-5)
{
    echo "<font color='red'>";
    echo $barcode." -  Overlapped";
    echo '</font>';
    $overlapped++;
    $all_overlapped[$overlapped]=$barcode;
    fwrite($fw,$overlapped);
    fwrite($fw, PHP_EOL);
}
else if($conf_barcode>0)
{
  $state=0;  
echo $barcode." - ".$conf_barcode." - Executed in: ".round($totaltime,3)." ms </BR>";
}
else if($conf_barcode==0)
{// report to file
    if($state==1)
    {
         fwrite($fwe, PHP_EOL);
      fwrite($fwe, $barcode);   
    }
   
    echo $barcode;
    if($state==0)
    {
    fwrite($fwe, PHP_EOL);
     fwrite($fwe, PHP_EOL);
    }
    $state=1;
} 
    
$i++;
$total_sum_time+=$totaltime;
//if($i==1400)
  //usleep(10000);



}while($i<$FLAG_HOW_MANY);
$last_barcode=$barcode;
echo "popopop";

ob_flush();
flush();
 
/// Now start the program output
 
echo "Program Output";
 
ob_flush();
flush();




echo "</ BR></BR>Total sum vector time: ".round($total_sum_time,3)." sec<\br>";
echo "Breaking Bad: ".$COUNTER_BREAK;
echo "</BR>Sets overlapped: ".$overlapped;


echo "</BR>ALL overlapped array: ";
foreach ($all_overlapped as $over)
    echo "</BR> Barcode: ".$over;
        flush();
      
}



?>



</table>
    </BR>
    
    
    

    
   
<BR><BR>

</BODY>
</HTML>
