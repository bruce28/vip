<?php

$DISMANTLE_FACTOR=0;
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

$DEBUG_MOD=1;

$host='127.0.0.1';
 $dbs3='dbs3';
  $username='root';
$password='krasnal';

//validation functions

//THIS FUNCTION Will do simple validation removes any input if bigger than $SIZE>12


//validation flags

$BARCODE_LENGHTS_DBS=12;
$BARCODE_LENGHTS_ONS=9;
$BARCODE_LENGHTS_UNQ=10;


$SIZE=12; //this is a size of biggest size of input barcodes

function reset_set($barcode)
{
    global $SIZE;
    if(strlen($barcode)<=$SIZE)
    {
        return $barcode;
        
    }
    else
        return NULL;
}


function get_len_checks($barcode)
{
    global $BARCODE_LENGHTS_DBS;
    global $BARCODE_LENGHTS_ONS;
    global $BARCODE_LENGHTS_UNQ;
    
    if(strlen($barcode)==$BARCODE_LENGHTS_DBS OR strlen($barcode)==$BARCODE_LENGHTS_ONS OR strlen($barcode)==$BARCODE_LENGHTS_UNQ)
    {
        echo $barcode;
        return strtoupper($barcode);
        
        
    }
    else return 0;
    
    
    
}

function barcode_checks($barcode)
{
    $barcode=get_len_checks($barcode);
    if($barcode)
        return $barcode;
    else
        return 0;
}

//end falidation functions

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
    $query="SELECT * FROM manifest_reg";
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
      {
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
               $size_calculation_site=$rek_site['closed'];
              }
       
        
     } 
          
          
      }
  
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
          $dbs_prob_set=$size_calculation_site; 
     }
     else
     {
       
     }
     //echo "1";
     $next_dbs=$start_dbs;
     for($i=0;$i<$dbs_prob_set;$i++)
     {
        
        $dbs_set[$i]=  strtolower($next_dbs);
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
            
      //      echo "<BR/><BR/>";
             while($rek_count['ile']>40)
         {
             echo "<BR/>Critical System Error: SYSTEM NOT COHERENT";
             //break;
             return -2;
         }
         
          return $siteid;
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
      //echo "<BR/>Braekin Bad";   
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


//FUCTIONS to VALIDATE BARCODE

function swap_hash($in)
{
  for($i=0;$i<=45;$i++)
  {
    if($in[$i]=='#')
    {
      $in[$i]='\\';
    }
  };  
    
   return $in; 
}

function swap_back($in)
{
  for($i=0;$i<=45;$i++)
  {
    if($in[$i]=='\\')
    {
      $in[$i]='#';
    }
  };  
    
   return $in; 
}


function validate_barcode($in)
{
    //function changes backslash to hash to allow to write/read to database in hash format 
   ECHO "swaPb ". $in=swap_back($in);
   
   
   global $DISMANTLE_FACTOR;
    //connect to database
    $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    //select database dbs3
    mysql_select_db('dbs3');
    echo '</br> barcode in validate'.$in;

echo $sql = "SELECT * FROM Barcode Where Barcode='$in'"; 
	 
    
    
     echo "INI".$in;
	echo "valid"; 
  $result= mysql_query($sql) or die("SELECT BAR Wrong");
  //variable written globaly/ modified $V_BAR_EX stores barcode read from database. It exists. $v_bar_exist defines the state of existance in db of bc
  
  
  //reads only once so a bug may be there if any double barcodes are already in database. Controled ower input validation
  if($rek = mysql_fetch_array($result,MYSQL_BOTH))  
   {
    //comparing with hash format
     if(strcmp($rek["Barcode"],$in))
      {
         echo 'taki barcode istnieje'; 
        
        $MESSG=2;
        //inform system that barcode already exists
        $v_bar_exist=1;
       echo "as:".$in;    
       //assignt existing barcode read from database to global variable $V_BAR_EX. Latar passed to the form add_stock.
        $rek["Barcode"];
        $DISMANTLE_FACTOR=12;
        return 0;
      }
      else
      {
        //barcode exist in db, but something is wrong. doesnt fit hash code
        echo 'nierowne';
        echo ' Porownaj Barcoe[]'.$rek['Barcode'].' in '.$in;
        
        // return barcode in hash form and set global $v_bar_exist as 0. That means that barcode does not exist in db. $$$shall be 1.
        $v_bar_exist=3;
        printf($rek['Barcode']);
        $V_BAR_EX=$rek['Barcode'];
        $DISMANTLE_FACTOR=12;
        return 0;
        
      }
   }
 else {
     return $in;    
   }
 
   
}    



//this functions checking if barcode is ready to be stripped
function validate_barcode_strip($in)
{
    //function changes backslash to hash to allow to write/read to database in hash format 
   $in=swap_back($in);
   
   
   global $DISMANTLE_FACTOR;
    //connect to database
    $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    //select database dbs3
    mysql_select_db('dbs3');
   // echo '</br> barcode in validate'.$in;

$sql = "SELECT * FROM Barcode Where Barcode='$in'"; 
	 
    
    
     //echo "INI".$in;
	//echo "valid"; 
  $result= mysql_query($sql) or die("SELECT BAR Wrong");
  //variable written globaly/ modified $V_BAR_EX stores barcode read from database. It exists. $v_bar_exist defines the state of existance in db of bc
  
  
  //reads only once so a bug may be there if any double barcodes are already in database. Controled ower input validation
  if($rek = mysql_fetch_array($result,MYSQL_BOTH))  
   {
    //comparing with hash format
     if(strcmp($rek["Barcode"],$in))
      {
       //  echo 'taki barcode istnieje'; 
        
        $MESSG=2;
        //inform system that barcode already exists
        $v_bar_exist=1;
   //    echo "as:".$in;    
       //assignt existing barcode read from database to global variable $V_BAR_EX. Latar passed to the form add_stock.
        $rek["Barcode"];
        $DISMANTLE_FACTOR=12;
        return -1;
      }
      else
      {
        //barcode exist in db, but something is wrong. doesnt fit hash code
     //   echo 'nierowne';
      //  echo ' Porownaj Barcoe[]'.$rek['Barcode'].' in '.$in;
        
        // return barcode in hash form and set global $v_bar_exist as 0. That means that barcode does not exist in db. $$$shall be 1.
        $v_bar_exist=3;
       // printf($rek['Barcode']);
        $V_BAR_EX=$rek['Barcode'];
        $DISMANTLE_FACTOR=12;
        return -1;
        
      }
   }
 else {
     $DISMANTLE_FACTOR=12;
     return 0;    
   }
 
   
}    








function get_barcode_id($barcode)
{
    connect_db();
    $sql="SELECT id_barcode FROM barcode where Barcode='$barcode'";
    $result=mysql_query($sql);
    $rek=mysql_fetch_array($result);        
     return $rek[0];
    
}

//wrapers

function wrap_table_in()
{
     echo "<table style='border-collapse:separate; 
border-spacing:2em;><tr>";  
     
}
function wrap_table_out()
{
    echo '</tr></table>';
    
}

function show_message($MESG)
{
    //wrap_table_in();
    echo "<table><tr>";
    echo "<td>";
    echo "<b>Communicate:".$MESG;
    echo "</b></td>";
    echo "</tr></table>";
    //wrap_table_out();
    
}

//debug

function debug_c($debug)
{
    global $DEBUG_MOD;
    if($BEBUG_MOD==1)
    echo $debug;
    
}

function check_barcode_in_waste($barcode)
{
	//here w may expend for inner join with transaction
	$sql="select Barcode_waste from waste_barcode WHERE Barcode_waste='$barcode'";
	$result=mysql_query($sql);
	$rek=mysql_fetch_array($result,MYSQL_BOTH);
	if($rek)
	return 1;
	else
	return 0;
}

