<?php
session_start();
//header('Location: add_stock.php?processing=true&bar_ex='.$v_bar_exist.'');
//$state=0;

include '../header_mysql.php';
include '../header_valid.php';


//Lets measuer execution time
$stime = microtime();  
    $stime = explode(" ",$stime);  
    $stime = $stime[1] + $stime[0];  
    
 
//LETS SET A FLAGS

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

function get_barcodes_from_db_import($barcode)
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
     $next_dbs=$start_dbs;
     for($i=0;$i<$dbs_prob_set;$i++)
     {
        
        $dbs_set[$i]=$next_dbs;
        $next_dbs=split_barcode($next_dbs);
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
    if($local_flag_bar==1)
    {
        
       return "Exist"; 
    }
    
    if(($return_flag==1) )
    {    
    echo "SESSION SET ";
     echo "SESSION SET ".$_SESSION['site_id_s']=$siteid;
    return $barcode;
    }
    else
    {
      echo "<BR/>Braekin Bad";   
      return 0;  
         
      
    }
      
    }
    
    //END IMPORT SERIAL




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
        
        $dbs_set[$i]=  strtolower($next_dbs);
       echo $next_dbs=split_barcode($next_dbs);
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


//function for validation stocking names and input data

function add_db_format($input)
{
  $output=addslashes($input);  
  return $output;  
}



//FUNCTION TO IMPROVE SPEED




function redirect_fast($where)
{
    
    echo '<script type="text/javascript">';
   echo 'location.replace("'.$where.'")';

echo '</script>';
}


function send_sock($where)
{
$text1=$where;    
$fp = fsockopen("localhost", 80, $errno, $errstr, 3);
if (!$fp) echo "$errstr ($errno)\n";
else {
  fwrite($fp, "GET /dbs3/add_stock.php?text1=$text1 HTTP/1.0\r\nHost: localhost\r\n\r\n");
  fclose($fp);
}

}

function log_file($tofile)
{
    $fp=fopen("$DOCUMENT_ROOT/../user.txt",LOCK_EX);
    if(!$fp)
        echo "Could not open log file";
    
    fwrite($fp,$tofile,strlen($tofile));
   flock($fp,LOCK_UN);
   fclose($fp);
    
}

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}




//This function checks if log button was sumbited
if(isset($_POST['log']))
{
    //connect Database by mysqli interface
    $db=connect_dbi();
    
     //return a row when admin login in User_2 table
     $sql_select_admin = mysqli_query($db,'SELECT * FROM User_2 WHERE login = "admin"');
     $result_select_admin = mysqli_fetch_array($sql_select_admin) or die(mysql_error());
     if($sql_select_admin)
     {  
            if(isset($_POST['password']))
            if($_POST['password'] == $result_select_admin['pass']){
               $name_p=$_POST['name_p']; //initialize name_p variable
               $WEIGHT_PASS=1;
               }
              
       else {
        
      echo 'Wrong Data!';
     // $WR=1;  // These 4 variables send back to add stock if login is wrong
     $barcode = $bb=  $_POST['barcode_p'];
     $item= $ii=$_POST['name_p'];
     $brand= $ib=$_POST['brand_p'];
     $serial = $is=$_POST['serial_p'];
     
     //sending back: states barcode does not exist, and triple is set, not empty
      redirect("add_stock.php?bar_ex=0&s_item=1&s_brand=1&s_serial=1&V_BARCODE=".$bb."&V_ITEM=".$ii."&V_BRAND=".$ib."&V_SERIAL=".$is."&MESSG=3&MESSG_EX=0",0);
      
      
       exit();
       }
   } 
    
    mysqli_free_result($sql_select_admin);
    mysqli_close($dbi);    
    mysql_close();
     }
    echo "sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdf";
//exit();


$sesja=$_SESSION['site_id_s'];



/*
if (empty($_POST['submitted'])) {
   echo 'Test form not filled';
   $url="add_stock.php";
   
			redirect($url,0); //1
            exit();
}
*/
if(isset($_POST['Cancel'])) {
   echo 'Test form not filled';
   $url="add_stock.php";
   
   redirect($url,0);
   exit();
}
  
  
//VALIDATION veriables
//variables to assign and carry back details on BARCODE, TYPE,BRAND AND SERIAL
$V_BAR_EX=0;
$V_ITEM=0;
$V_BRAND=0;
$V_SERIAL=0;

$v_bar_exist=0;  

  
//Indicators for carrying back a state of emptiness
$s_item=0;
$s_brand=0;
$s_serial=0;

//not used
$state1=0;
$check=array();
$check[2]=2;
$defect=array();
  

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
   
   global $V_BAR_EX;
  global $v_bar_exist;
   
    //connect to database
    $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    //select database dbs3
    mysql_select_db('dbs3');
    echo '</br> barcode in validate'.$in;


      global $MESSG;
     
      if($in==-2)
      {
        $MESSG=17;
        $v_bar_exist=1;
        //$V_BAR_EX=1;
        return 0;
      }
      if(EMPTY($in))
      {
          echo 'bARCODE DOES NOT EXIST IN SERIALISATION SET'; 
        
        $MESSG=16;
        //inform system that barcode already exists
        $v_bar_exist=1;
        
        //$V_BAR_EX=1;
       echo "as:".$in;    
       //assignt existing barcode read from database to global variable $V_BAR_EX. Latar passed to the form add_stock.
        //$V_BAR_EX=$rek["Barcode"];
        
        return 0;
          
          
      }
      
	 $sql = "SELECT * FROM Barcode Where Barcode='$in'"; 
	 
    
    
     
	echo "valid"; 
  $result= mysql_query($sql) or die("SELECT BAR Wrong");
  
  echo '<BR>va'.$in;
  
  //variable written globaly/ modified $V_BAR_EX stores barcode read from database. It exists. $v_bar_exist defines the state of existance in db of bc
  
  
  //reads only once so a bug may be there if any double barcodes are already in database. Controled ower input validation
  if($rek = mysql_fetch_array($result,1))  
   {
    //comparing with hash format
     if($rek["Barcode"]==$in)
      {
         echo 'taki barcode istnieje'; 
        
        $MESSG=2;
        //inform system that barcode already exists
        $v_bar_exist=1;
       echo "as:".$in;    
       //assignt existing barcode read from database to global variable $V_BAR_EX. Latar passed to the form add_stock.
        $V_BAR_EX=$rek["Barcode"];
        
        return 0;
      }
      else
      {
        //barcode exist in db, but something is wrong. doesnt fit hash code
        echo 'nierowne';
        echo ' Porownaj Barcoe[]'.$rek[Barcode].' in '.$in;
        
        // return barcode in hash form and set global $v_bar_exist as 0. That means that barcode does not exist in db. $$$shall be 1.
        $v_bar_exist=3;
        printf($rek['Barcode']);
        $V_BAR_EX=$rek['Barcode'];
        return $in;
        
      }
   }
   else
   {   
      //No result given, that means no barcode given on input to that function in database. Return barcode in hash form. $$$$Input barcode assigned as V_BAR_EX. Return it
       $v_bar_exist=0;
       $V_BAR_EX=$in;
       echo 'nieistnieje';
       $MESSG=3;
       return $in;
    }
}    



//query database by default prepared statement 
function add_db($sql)
{
	 
  echo mysql_query($sql);

}


/*
MAIN APPLICATION STARTS HERE



>>>>>>>>>>>>>>>>>>>>>>>>>>
*/



//change again hash format into native backslash format. EVERY RECEIVED BARCODE is checked if no hash is there. Every interation is safe to eliminate wrong db format
//problem with % white space 3  
$barcode = trim(strtoupper(swap_hash($_POST["barcode"]))); //here also

//if(!get_magic_quotes_gpc())
//$barcode= stripslashes(trim($_POST['barcode'])); //take a barcode from stock in form

//$barcode=strtoupper($_POST['barcode']);
echo '</br> barcode receved from post'.$barcode;

//INITIALIZE VARIABLES for FORM 2 and 3 also here shall start FORM 1
if(isset($_POST['log']))
{
 if($WR==0)
 {   
 $item=strtoupper(swap_hash($_POST['name_p']));
 $serial=$_POST['serial_p'];
 $barcode=$_POST['barcode_p'];
 $brand=$_POST['brand_p'];   
 $MESSG_EX=1;
 }
 else
 ;
   
}




else   //means if FORM 1 not clicked than initialized standard varaiables from form 3 barcode all in capitals
{
$item=strtoupper($_POST['item']);   //Type of Item: DVD, TV //here we do bi case
$brand=strtoupper($_POST['brand']);  //Company name. JVC
$serial=strtoupper($_POST['serial']);  //PART NUMBER
}

///validation: checking if date of manifest and site location number is was set
if(isset($_POST['batch_date']))
{
$batch_date=$_POST['batch_date'];
}
if(isset($_POST['site_location']))
{
$site_location=$_POST['site_location'];
}


//if weigh added
if(isset($_POST['weight_add']))
{
    if(isset($_POST['barcode_in']))
    {   //to solve %20 trim here
        //initialize a new barcode. Thus from log and is not valid anymore
        if(isset($_POST['barcode_in']))
        $barcode=trim($_POST['barcode_in']);
        if(isset($_POST['item_in']))
        $item=trim($_POST['item_in']);
        if(isset($_POST['brand_in']))
        $brand=trim($_POST['brand_in']);
        if(isset($_POST['serial_in']))
        $serial=trim($_POST['serial_in']);
        
        $WEIGHT_PASS=1;   //ADJAST for for. Tell you are log in as admin to the input db form. Only if barcode does not exist in db and 3 fields are set
        echo "KLIKNIETOOOOOOOOOOOOOOOOOOOO";
        
        echo $barcode;
        echo $item;
        $MESSG_EX=1;  //i think to go in dirrectly to the function inserting
        $IS_SET_WEIGHT=2;  //we set is as added only while form was send once
    }
    
}  

/*
//ONLY once i think.
if(!empty($batch_date) AND !empty($site_location))
{
  connect_db();
  $query="SELECT * From Origin INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id WHERE batch_date='$batch_date' AND Origin_origin_id='$site_location'";

    echo $batch_date.$site_location;
   $result=query_select($query);


$i=0;
//this avoids to take more than one site place one day, jus comunicate

    $num_site=mysql_num_rows($result);
            if($num_site>1)
            {
                
                if(!isset($_SESSION['site_reference_number'])AND !isset($_POST['site_reference_number']))
                {
                    //SYSTEM LOGIC SECURITY LOCK: 
                    $url="add_stock.php?MESSG=MORE THAN ONE MANIFESTS ONE DAY FOR ONE SITE PLACE&ref=1&batch_date=";
                    $url.=$batch_date;
                    $url.="&site_location=";
                    $url.=$site_location;
                   redirect($url, 0);
                  // redirect("add_stock.php?MESSG=SYSTEM LOGIC SECURITY LOCK: MORE THAN ONE MANIFESTS ONE DAY FOR ONE SITE PLACE", 0);
                   exit();
                    
                }else
                $site_reference_number=$_SESSION['site_reference_number'];
                
                 $site_reference_number=$_POST['site_reference_number'];
               
                $query="SELECT * From Origin INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id WHERE batch_date='$batch_date' AND Origin_origin_id='$site_location' AND site_ref_number='$site_reference_number'";

    echo $batch_date.$site_location;
   $result=query_select($query);
            }   
//and of avoid site
            
  if($rek = mysql_fetch_array($result,1))
  $site_specified=1;  
  
  $batch_date=$rek["batch_date"];
  $site_location=$rek["Origin_origin_id"];
  $na=$rek["site_id"];
  $url='add_stock.php?'.'site_specified='.$site_specified.'&'
  .'batch_date='.$batch_date.'&'
  .'site_location='.$site_location.'&'
  .'site_id='.$na;  
  $_SESSION['site_id_s']=$na;
  redirect($url,0);
  exit();
}*/
else 
{ 
 
    
  echo "sama sesja";  
}
//main condition 1 condition. For every form. check is everything is not empty
if(empty($barcode) AND empty($item) AND empty($brand)AND empty($serial))
{
   ;    
}
else
{
    //
}
    
// NOw we check if barcode, item, brand and part number are not empty. Thus taken from form 1,2, or 3. Is there any case there can be not filled?
if(empty($barcode))
{
    redirect("add_stock.php",0); 
    //if barcode is empty redirect to form, but $$$form shall be checked by default values, also set not incomplete set of parametters can be send
  exit();         
}

if(!empty($item))
{
 //type of item is set as true if item field is not empty   
 $s_item=1; 
 $V_ITEM=$item; //Field V_ITEM that is sent back is set on that particulat item name that was send before  
 
 $connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');
 echo "item check";
  $sql_weight="SELECT * FROM Item INNER Join Item_has_Cat ON Item_has_Cat.id_item_cat=Item.Item_has_Cat_id_item_cat WHERE name='$item'";
    $res_weight=mysql_query($sql_weight) or die(mysql_error());
    $rek_weight=mysql_fetch_array($res_weight);
    $rows=mysql_num_rows($res_weight);
        if($rows==0)
        {  
            if($MESSG_EX==1)
              $MESSG_EX=1;
              else
           $MESSG_EX=$rows; //category not assigned 
        }
        else
          $MESSG_EX=$rows;    
       echo "Row Numbers".$rows;
     
}


if(!empty($brand))
{
 $s_brand=1; // if brand field is not empty than the same brand is past on. If is empty than is send empty   
 
 $V_BRAND=$brand; 
}


if(!empty($serial))
{
 $s_serial=1; //if part number is not empty   
 $V_SERIAL=$serial;
}



echo "BEFORE CROOS".$EXTENDED_MODULE;
// functions returns to a buffer that is not in use yet. Fun returns hash format. While barcode is still slash format. Thoough javna conversion is needed, before adding barcode 
$barcode3=check_unq($barcode);
if($EXTENDED_MODULE==1)
{
    $barcode2=validate_barcode(($barcode));
    if(isset($_POST['barcode2']))
    {
       echo "<BR />Container barcode set.";
       $barcode_cont=$_POST['barcode2'];
       $barcode_container=get_barcodes_from_db($barcode_cont);
    }
}
 else
$barcode2=validate_barcode(get_barcodes_from_db($barcode));

echo '</br>barcode after validateing: '. $barcode2;

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

//user is written as a session
$user=$_SESSION['id_user'];

 //$barcode=swap_hash($barcode);

//START Functionality


$FUN_STOCK=$_POST['fun'];
$PAT_STOCK=$_POST['pat'];



//END Functionality
  
 
	
   echo "KLINIETO BARCODE EXEXEXEXEXXEXXXEXEXE";   echo "VBAR EXRR:".$V_BAR_EX."s_itemRR:".$s_item.$s_brand.$s_serial."sesjaRR:".$sesja."MESSAGERR:".$MESSG_EX;
      

      // if barcode does not exist in database or barcode read from db exist but doesnt fit the barcode inputed and everything else is set than
      // if barcode does not exist in databse and everything is set and site place 
if($v_bar_exist==0 AND 
$s_item!=0 AND
$s_brand!=0 AND
$s_serial!=0 AND isset($sesja) AND $MESSG_EX!=0 
)
{   
    //HERE WE GIVE A MODUL FOR aggind slash format
    $item=add_db_format($item);
    $brand=  add_db_format($brand);
    $serial=  add_db_format($serial);


// STANDARD CHANGE FOR A NEW WEIGHT ASSASMENT MODULE
    echo "STANDARD ASSIGNMENT MODULE. STARTS VALIDATION</br></br>";
    $INSERT_LOG=0;
    $barcode= swap_back($barcode);  //we try to trim before insdert
   echo "kolo INNODB INSETThkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhkhk";
    $check_s="SELECT DISTINCT * FROM Item WHERE name='$item' AND Item_has_Cat_id_item_cat>=0"; //add where item cat is active than count numbers
    $resi=mysql_query($check_s) or die(mysql_error());  //taking all item with weight assign
    $ro=mysql_num_rows($resi);
    echo "Number of ro in SELECT * DISTINCT FROM ITEM where item, and each have cat defined</br></br>".$ro;
    ///SOLUTION FOR A NEW ACTIVE ACT
    $check_s_ac="SELECT DISTINCT Item_has_Cat_id_item_cat FROM Item INNER JOIN item_has_cat ON Item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat WHERE name='$item' AND Item_has_Cat_id_item_cat>=0 AND active='1'"; //add where item cat is active than count numbers
    $resi_ac=mysql_query($check_s_ac) or die(mysql_error());  //taking all item with weight assign
    $ro_active=mysql_num_rows($resi_ac);
     echo "Number of ro_active in SELECT Item_has_cat-id-item-cat DISTINCT FROM ITEM IJ item has cat where name cat >0 and active=1</br></br>".$ro_active;
    if($ro_active==0 AND $ro>$ro_active)  //if deactive than is weight
    {
       // $check_ss="SELECT id_item_cat FROM item_has_cat Right JOIN item ON item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat WHERE as_cat='$item' AND Active=1"; //add where item cat is active than count numbers
         echo "IN ro active==0".$ro_active."AND ro > roact</BR></BR>";
        $check_ss="SELECT id_item_cat FROM item Right JOIN item_has_cat ON item.Item_has_Cat_id_item_cat=item_has_cat.id_item_cat WHERE as_cat='$item' AND Active=1";
        $resis=mysql_query($check_ss) or die(mysql_error());  //taking all item with weight assign
    $ros=mysql_num_rows($resis);
    if($ros==1) //that shall be a case if only active has just been assigned as distinct
    {   //here insert
        echo "</BR>ROS1: CASE exist only in right table";
        $rek_is=mysql_fetch_array($resis);
        $id_cat_ite=$rek_is['id_item_cat'];
        $INSERT="INSERT INTO item(Item_has_Cat_id_item_cat,pn,brand,name) VALUES('$id_cat_ite','$serial','$brand','$item')";
        mysql_query($INSERT)or die(mysql_error());
        
         $last_id=  mysql_insert_id();
        $insert3="INSERT INTO `barcode` (`Item_id_item` ,`Barcode` ,`serial` ,`date`,stock_in,user_2,Site_site_id) VALUES ('$last_id','$barcode','0',NOW(),'1','$user','$sesja')";
        mysql_query($insert3) or die("INSERT Barcode Wrong");
       $MESSG=14; 
        redirect("add_stock.php?=ITEM ASSIGNED TO NEW CATEGORY&MESSG=".$MESSG,0);
       exit();
        
    }
    else
        ;
       
    }
    
    ///
    //this works just dont assign anything for non active
    if($ro>0) //AND $ro_active==1)     //if an item type is on stock with weight assasement take this one active and add to that category. This needs another module that changes weights assignment
    {    //this modul can only take one active. So if someone dont activate than adds to old weights
        $INSER_LOG.=$ro;
        //only once
        echo "</BR>IN RO >0 ".$ro;
        $rekii=mysql_fetch_array($resi);
                
         $rekii_aa=mysql_fetch_array($resi_ac);
         
       // $item_ca=$rekii["Item_has_Cat_id_item_cat"];
        $item_ca=$rekii_aa["Item_has_Cat_id_item_cat"];
        $i=0;
        echo "  sdsdds".$item_ca;
        // HERE WE CHECK if ALL ITEM the same. we take only active category
        
        // we take only uniqu/distinct name of weight category for that particulat item. Later we find active  26 DVD  28DVD
        $sql_select_active_w="SELECT DISTINCT Item_has_Cat_id_item_cat  FROM `item` WHERE name='$item'";
        $result_active_w=mysql_query($sql_select_active_w) or die(mysql_error());
        
        //res is 71 and 72 while few 72 with 0 active
        while($rek_active_w=mysql_fetch_array($result_active_w))
        {
            $i++;
            //While taken one cat 26 DVd read if this is active one
            $acv_item=$rek_active_w['Item_has_Cat_id_item_cat'];
            $sql_select_acv="SELECT * FROM item_has_cat WHERE item_has_cat.id_item_cat='$acv_item' AND active=1";  //here only go thr 71 and second with 72 but spec this active
            $result_select_acv=mysql_query($sql_select_acv);
            $rek_select_acv=mysql_fetch_array($result_select_acv);
            echo "iiiiiiiiiiiii".$i;
            echo $rek_active_w['Item_has_Cat_id_item_cat'];
            echo "</BR>Tem catspec".$rek_select_acv['item_has_cat'];
            //if(mysql_num_rows($result_select_acv)>1)
            $num_acv=mysql_num_rows($result_select_acv);
            if($num_acv>1) 
            {
            redirect("add_stock.php?MESSG=144&n=".$i,29);
            exit();
            
            }
            //active item assesed and ready to use
            if(!empty($rek_select_acv['id_item_cat']))
            $active_item_token=$rek_select_acv['id_item_cat'];
            else
            {
                //here comes a code to genereate new item assign creation
               
               //  redirect("add_stock.php?MESSG=NOT ACTIVE WEIGHT ASSIGNED. CONTACT SUPERVISOR&n=".$i,10);
             //    exit();
                ; 
                //somehow we must add a new item as privillage
                //$omit=1;       
                
            }
         echo "koniec while przydzialu czy id cat jest aktywna";   
        }
        
        
        
                
        //HERE WE CARRY ONE WITH ACTIVE ITEM. WE GIVE A NEW ITEM THE WEIGHT OF THE MOST ACTIVE WEIGHT
        
        
        $item_ca_ac=$active_item_token;  // here was in sql inserting item_ca but now we change inser statemet to item_ca_ac
        
        if($item_ca_ac!=0)    //Beware of this week valid, if go throu mistake by mysql. This if could not find anything active go to the end of code
        {
        if($omit!=1 OR !empty($item_ca_ac))  //define behaviour if the item of this type are in stock but not of them active
        {
        $INSERT_LOG.=$barcode.$item.$brand.$serial.$item_ca;
        
        
        $insert2="INSERT INTO `item`(`pn` ,`brand` ,`name`,Item_has_Cat_id_item_cat) VALUES ('$serial','$brand','$item','$item_ca_ac')";  
        $BUF_MESSG=$ro;
        mysql_query($insert2) or die(mysql_error());
        $last_id=  mysql_insert_id();
        $insert3="INSERT INTO `barcode` (`Item_id_item` ,`Barcode` ,`serial` ,`date`,stock_in,user_2,Site_site_id) VALUES ('$last_id','$barcode','0',NOW(),'1','$user','$sesja')";
        mysql_query($insert3) or die("INSERT Barcode Wrong");
        $INSERT_LOG.=$last_id.$sesja.$user;
        $INSERT_LOG.=date();
        log_file($INSERT_LOG);
        $MESSG=1;
        }

        }
        else   $MESSG=12;
    }
    else   //if unige item needs assesment
    {   //if not an bacode item yet in stock and type is not yet
        
//// this modul/part happens only while wher item name was not in database. This creates a fresh weight
        
     //item weight 
       echo "kolo inersta innasdddddddddddddddddduuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuwe";
        if($WEIGHT_PASS==1)
        {
            if($IS_SET_WEIGHT==2)
              ;
            else
            { 
              $IS_SET_WEIGHT=1;
             $url="add_stock.php?barcode=".swap_hash($barcode)."&item=".$item."&brand=".$brand."&serial=".$serial.'&IS_SET_WEIGHT=1';
   //concat($url,$check);
     redirect($url,0);
     exit();   
              
              
            }
        }  // else if: is weight pass is not set but the button of a form asses weight had been clicked than do
        if (isset($_POST['weight_add'])) {
            echo "hggggggggggggggggggggggasas";
        if(isset($_POST['weight']) AND isset($_POST['cat_id']))
        {
         $weight_pass_val = doubleval($_POST['weight']); //just take category in kg
         if($weight_pass_val==0)
             $weight_pass_val=1;
         $cat_pass=$_POST['cat_id'];    //and type of category classified
         $IS_SET_WEIGHT=2;
        }
        else 
        {
          $IS_SET_WEIGHT=1;  
        }    
    }
    if(isset($IS_SET_WEIGHT) AND $IS_SET_WEIGHT==2)
    {   
        //UNIQE ASSIGNMENT NUMBER GENERATION
        $ref=rand();
    $assign_num=$_SESSION['site_id_s'].$batch_date.$ref; 
    
    $sql_insert_item_cat="INSERT INTO Item_has_cat(weight ,cat ,date,assign_nr,active) VALUES ('$weight_pass_val','$cat_pass',now(),'$assign_num','1')";
    echo mysql_query($sql_insert_item_cat) or die(mysql_error());
    
  
    
  // last id stored of last item modified and saved as variable $id_item_l 
  $last_id = mysql_insert_id();
  $id_item_l= $last_id;
  
  
   $sql_insert_item="INSERT INTO Item(Item_has_Cat_id_item_cat ,pn ,brand,name) VALUES ('$last_id','$serial','$brand','$item')";
    echo mysql_query($sql_insert_item) or die(mysql_error());
  
  echo '<br>before insert'.$barcode;
  
  //changing to hash format for purpose of writing hash format into db.
  $barcode=swap_back($barcode);
   $last_id = mysql_insert_id();  
  //prepared statement. Add barcode, serial number not in form. delivery and stocked_problem. Delivery id must be set before the form is filled. Delivery is Site id cause
  // every particular item added to stock comes from particular siteplace
 $insert3="INSERT INTO `barcode` (`Item_id_item` ,`Barcode` ,`serial` ,`date`,stock_in,user_2,Site_site_id) VALUES ('$last_id','$barcode','0',NOW(),'1','$user','$sesja')";
  
  
  mysql_query($insert3) or die("INSERT Barcode Wrong");
   $bar_id=mysql_insert_id();
   
    
      // bar id is the last id of barcode that had been added
        
    echo "Barcode ID: ".$bar_id." Barcode ".$barcode." Barcode2".$barcode2."sddas ";
    
      // this if set cheked before on the condition coming into insert function. but checked twice just for sure 
      
      echo "<BR><BR>SATE </br>". $state1."</br> STATE</br><BR>";
	 $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`,`state`) VALUES ('$user','$bar_id','$pat', '$cln', '$fun', '$vis', '$ts','$state1')"; 
	 
	 
     //hash fromat to backslash format since we do not use barcode inertion anymore
	 
  //echo mysql_query($insert1) or die("INSERT test Wrong");
     //last test_id
     $last_id_t = mysql_insert_id();
     echo "last".$last_id_t;
	
      $barcode=swap_hash($barcode);
 
  
   


  $MESSG=1;

  
 // echo "MESSG_EX".$MESSG_EX;
  
    }
    ///CASE 3: IF WEIGHT NOT SET 2
    $_SESSION['last_item']=$item;
    $barcode=swap_hash($barcode);
  $url="add_stock.php?test=".$barcode.'&MESSG=6'.'&function=1';
   //concat($url,$check);
     redirect($url,0);
     exit();   
     
        
    
    }
    $barcode=swap_hash($barcode);
  $url="add_stock.php?test=".$barcode.'&MESSG='.$MESSG.'&function=1';
   //concat($url,$check);
     redirect($url,$TEST_T);
     exit();   
    
 }
?>
<HTML>
<HEAD>
</HEAD>
<BODY>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>

<IMG SRC="weee/weee_cor.jpg" WIDTH=800 HEIGHT=120>

<?php

$spec_weight=NULL;
if($IS_SET_WEIGHT==1)
{
   $spec_weight="&IS_SET_WEIGHT=".$IS_SET_WEIGHT; 
}    

//second token for exec time

$sstime = microtime();  
    $sstime = explode(" ",$sstime);  
    $sstime = $sstime[1] + $sstime[0]; 
         $totaltime = ($sstime - $stime);
    echo $totaltime;



echo "PRE". $V_BAR_EX;  //here added addstrip sin \ and has was changed on % or E
$V_BAR_EX=swap_hash($V_BAR_EX);
$url='add_stock.php?'.'bar_ex='.$v_bar_exist.'&'
/*.'v_pat='.$v_pat.'&'
.'v_fun='.$v_fun.'&'
.'v_cln='.$v_cln.'&'
.'v_vis='.$v_vis.'&'*/
.'s_item='.$s_item.'&'
.'s_brand='.$s_brand.'&'
.'s_serial='.$s_serial.'&'
.'V_BARCODE='.$V_BAR_EX.'&'
.'V_ITEM='.$V_ITEM.'&'
.'V_BRAND='.$V_BRAND.'&'
.'V_SERIAL='.$V_SERIAL.'&MESSG='.$MESSG.$spec_weight
.'&BUF_MESSG='.$BUF_MESSG
.'&v_fun='.$FUN_STOCK      
;

if($EXTENDED_MODULE==1)
{
   $url.="&unq=1";
   if(!empty($barcode_container))
   $url.="&barcode_container=".$barcode_container;
}
$url.="&exec=".$totaltime;

//Differend than defoult than send back
if($MESSG_EX!=-1 AND !empty($barcode)AND !empty($item) AND !empty($brand) AND !empty($serial))
    $url.='&MESSG_EX='.$MESSG_EX;


//send_sock($V_BAR_EX);
//

//redirect_fast($url);
		redirect($url,$TEST_T);
    
?>
<br><BR>



</BODY>
</HTML>