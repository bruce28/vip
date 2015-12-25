<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header.php';
$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 


include 'header_valid.php';
include 'functions/waste_sell_fn.php';
include 'functions_group_barcode.php';

$MESSG=0;
//debbugin values for a test mode

$TEST_T=0;

$site_id;

//error_reporting(E_ALL ^ E_NOTICE);
$item_type=$_POST['item_type'];


 $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    //select database dbs3
    mysql_select_db('dbs3');

?>


<?php

//this seems to be a neccessery function to calculate site properly
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
    
     $host='127.0.0.1';
   $username='root';
    $password='krasnal';
     $NEW_CALCULATION=1;        
     $dbs3='dbs3';
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
             // return $site_id_tmp;
                 
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
    //echo "SESSION SET ".$_SESSION['site_id_s']=$siteid;
        echo "Siteid ".$siteid;
    return $siteid;
    
    }
    else
    {
         $_SESSION['site_id_s']=0; 
      echo "<BR/>";  
      echo "<BR/>Braekin Bad";   
      return 0;  
       
      
    }
     
    }





//header('Location: add_stock.php?processing=true&bar_ex='.$v_bar_exist.'');
//$state=0;

include 'header_mysql.php';

$sesja=$_SESSION['site_id_s_s'];



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
   $url="sell_item_waste1.php";
   $ref_sell_tmp=$_SESSION['ref_sell_number'];
   
   
  $update="UPDATE Barcode
INNER JOIN Barcode_has_Buyers ON Barcode.id_Barcode=Barcode_has_Buyer.Barcode_id_Barcode
SET stock_out='0' WHERE ref_sell_number='$ref_sell'";
   
   
   $select_sql="SELECT * FROM transaction_waste WHERE ref_sell_number='$ref_sell_tmp'"; 
   
   //$update="UPDATE Barcode SET stock_out='0' WHERE ref_sell_number='$ref_sell'";
   $re=mysql_query($select_sql) or die(mysql_error());
   
   while($res_t=mysql_fetch_array($re))
   {
    $bar_tmp=$res_t['waste_barcode_idwaste_barcode'];
    
    $inv_tmp=$res_t['invoice_waste_idinvoice_waste'];
    $insert1="UPDATE waste_barcode SET stock_out=0 WHERE idwaste_barcode='$bar_tmp'";
    mysql_query($insert1) or die(mysql_error());
    
    $insert2="UPDATE transaction_waste SET finished=3 WHERE ref_sell_number='$ref_sell_tmp'";
    
    mysql_query($insert2) or die(mysql_error());
    
    $invoice="UPDATE transaction_waste SET invoice_waste_idinvoice_waste='1' WHERE ref_sell_number='$ref_sell_tmp'";
     mysql_query($invoice) or die(mysql_error());
   }
   
   $delete="DELETE FROM invoice_waste WHERE idinvoice_waste='$inv_tmp'";
     mysql_query($delete) or die(mysql_error());
     
     if(empty($inv_tmp))
     {   
         $delete="DELETE FROM invoice_waste WHERE idinvoice_waste=''";
     mysql_query($delete) or die(mysql_error());
         
         
         //the problem was that it does not switch  to the last zeroed invoice id, that stems from probably canceling wihout initiation table. Solution is max id
         $max_value="SELECT MAX(idinvoice_waste) as maxinv FROM invoice_waste";
         $res_max=mysql_query($max_value) or die(mysql_errno());
         $rek_max=mysql_fetch_array($res_max);
         $max_id=$rek_max['maxinv'];
          $alter="ALTER TABLE invoice_waste AUTO_INCREMENT=$max_id";//$alter="ALTER TABLE invoice_waste AUTO_INCREMENT=$inv_tmp";
          
          //and just delete last highest id while cncel done without transaction init
          $delete="DELETE FROM invoice_waste WHERE idinvoice_waste=$max_id";
     mysql_query($delete) or die(mysql_error());
     }
         else
    $alter="ALTER TABLE invoice_waste AUTO_INCREMENT=$inv_tmp";
         
         //if(!empty($inv_tmp))
     mysql_query($alter) or die(mysql_error());
   //select every sel ref before and change to 0 finished and update barcode
   
   echo "sdsdsdsd";
   
   unset($_SESSION['site_id_s_s']);
   unset($_SESSION['ref_sell_number']);
			redirect($url,$TEST_T);
   exit();
}



if(isset($_POST['Finish'])) {
   echo 'Processing your sell request';
   $ref_sell=$_SESSION['ref_sell_number'];
   $url="sell_item_invoice_waste1.php?invoice=1&show=1&ref_sell=".$ref_sell;
   
   
   $update="UPDATE transaction_waste SET finished='2' WHERE ref_sell_number='$ref_sell'";
   mysql_query($update) or die(mysql_error());
   
    $inv_sql="Insert INTO invoice_waste(main_pri,net_pri,vat_pri) VALUES(0,0,0)";
  // mysql_query($inv_sql) or die(mysql_error());
   
   $inv_last_id=mysql_insert_id();
   
   $update_inv="UPDATE transaction_waste SET Invoice_inv_id='$inv_last_id' WHERE ref_sell_number='$ref_sell'";
   
  // mysql_query($update_inv) or die(mysql_error());
   
   
   
  
   unset($_SESSION['site_id_s_s']);
   unset($_SESSION['ref_sell_number']);
    unset($_SESSION);
   // select every ref and 
			redirect($url,$TEST_T);
   exit();
}  
  

//changin remove modul add

if(isset($_POST['print_out']))
{
    //take barcode to be removed 
    $bar_tmp=$_POST['barcode'];
    $ref_sell=$_SESSION['ref_sell_number']; //this var for assign unig transaction for rmove
    $insert2="SELECT idwaste_barcode FROM waste_barcode WHERE Barcode_waste='$bar_tmp'";
    $result=mysql_query($insert2) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    $id_bar=$rek[0];

    
    
    
    $show="SELECT waste_barcode_idwaste_barcode FROM transaction_waste WHERE waste_barcode_idwaste_barcode='$id_bar' AND finished=2";
    $result=mysql_query($show) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    if($rek[0]!=$id_bar)
    {
    $insert1="UPDATE waste_barcode SET stock_out=0 WHERE Barcode_waste='$bar_tmp'";
    mysql_query($insert1) or die(mysql_error());

    $insert2="SELECT idwaste_barcode FROM waste_barcode WHERE Barcode_waste='$bar_tmp'";
    $result=mysql_query($insert2) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    $id_bar=$rek[0];

    $insert3="DELETE from transaction_waste WHERE waste_barcode_idwaste_barcode='$id_bar'";
    
    mysql_query($insert3) or die(mysql_error());
    }
    //we just check also quantity
    
    if(isset($_POST['quantity']) AND !empty($_POST['quantity']))
    {
        echo $count=$_POST['quantity'];
        echo $item_type=$_POST['item_type'];
        echo $ref_sell;
        $select_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat='$item_type' AND qtty>=1";
         $result=mysql_query($select_qtty) or die(mysql_error());
        if($result>=1)
        {
            $rek=mysql_fetch_array($result);
            echo $qtty_waste=$rek['qtty'];
            $id_waste_quantity=$rek['idwaste_quantity'];
            $qtty=$qtty_waste-$count;
            if($qtty>=0)
            {
                
            echo $UPDATE="UPDATE waste_quantity SET qtty='$qtty' WHERE idwaste_quantity='$id_waste_quantity'";
            mysql_query($UPDATE)or die(mysql_error());
            
                    
            }
            else
                echo "To small";
        }
        
        
        
    }
    
    
    //redirect to sell
    $url="sell_item_waste1.php?print_out=1&item_type=".$_POST['item_type'];
    redirect($url,$TEST_T);
    exit();
}


//VALIDATION veriables

$V_BAR_EX=0;
$V_ITEM=0;
$V_BRAND=0;
$V_SERIAL=0;

$v_bar_exist=0;  

$v_pat=0;  
$v_fun=0;
$v_cln=0;
$v_vis=0;
  
$s_item=0;
$s_brand=0;
$s_serial=0;

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
    $in=swap_back($in);
    
    //connect to database
    $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    //select database dbs3
    mysql_select_db('dbs3');
    echo '</br> barcode in validate'.$in;

global $MESSG; 

//six barcode
$sel_six="SELECT * FROM six_barcode Where u_barcode=$in";
$res_six=mysql_query($sel_six);
$rek_six=mysql_fetch_array($res_six);
if($res_six!=0)
    $MESSG=11;



/////////////////just section of messag 3 and 4
 





$sql_12 = "SELECT * FROM waste_barcode                       
     Where Barcode_waste='$in'"; 
  
  $res_12= mysql_query($sql_12) or die(mysql_error());
  $res_12_fetch=mysql_fetch_array($res_12);
 
  if($res_12_fetch["Barcode"]==$in)
  {
     $MESSG=5;
     //changed by night
     $sql_121 = "SELECT * FROM waste_barcode 
                    Where Barcode_waste='$in' "; 
  
     $res_121= mysql_query($sql_121) or die(mysql_error());
     $res_121_fetch=mysql_fetch_array($res_121);
     if($res_121_fetch["Barcode"]==$in)
        $MESSG=3;
  } 
  else
     $MESSG=4;    
/////////////////

      //
      //
      /// HERE WE CHANGE To INNER JOIN if it also exist in test
      
     /////But the second instance is that item must have passa test otherwise is disposed
     //ADDING AND PASS
      
	 $sql = "SELECT * FROM waste_barcode 
     Where Barcode_waste='$in' AND stock_out=1"; 
	 
    
    
   
     
	echo "valid"; 
  $result= mysql_query($sql) or die("SELECT BAR Wrong");
  
  
  //check if bar exist in barcode in stock
  
 
  
  
  echo '<BR>va'.$in;
  
  //variable written globaly/ modified $V_BAR_EX stores barcode read from database. It exists. $v_bar_exist defines the state of existance in db of bc
  global $V_BAR_EX;
  global $v_bar_exist;
  
  //reads only once so a bug may be there if any double barcodes are already in database. Controled ower input validation
  if($rek = mysql_fetch_array($result,1))  
   {
    //comparing with hash format
     if($rek["Barcode"]==$in)
      {
         echo 'taki barcode istnieje'; 
        
         //$MESSG=3;
        //inform system that barcode already exists
        $v_bar_exist=0;
       echo "as:".$in;    
       //assignt existing barcode read from database to global variable $V_BAR_EX. Latar passed to the form add_stock.
        $V_BAR_EX=$rek["Barcode"];
        //exit();
        // return 0. Function does not return any barcode
         
        return 0;
      }
      else
      {
        //barcode exist in db, but something is wrong. doesnt fit hash code
        echo 'nierowne';
        echo ' Porownaj Barcoe[]'.$rek[Barcode].' in '.$in;
        
        // return barcode in hash form and set global $v_bar_exist as 0. That means that barcode does not exist in db. $$$shall be 1.
        $v_bar_exist=0;
       
        
        return $in;
        
      }
   }
   else
   {   
      //No result given, that means no barcode given on input to that function in database. Return barcode in hash form. $$$$Input barcode assigned as V_BAR_EX. Return it
       $v_bar_exist=1;
       $V_BAR_EX=$in;
        //$MESSG=4;
       echo 'nieistnieje';
       return $in;
    }
    
   
    
    
}    

//function checks a state of test buttons if set.
function validate_test($pat,$fun,$cln, $vis)
{
  $test=1;  
  if(isset($pat)AND $pat==1)
  if(isset($fun)AND $fun==1)
  if(isset($cln)AND $cln==1)
  if(isset($vis)AND $vis==1)
    return $test;
  else
  {
     $test=0; 
     //if not set return zero
     return $test; 
  }   
    
}

//function redirects
function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}

//repairs conducted. The vailue taken from POST.

function checkin($in)
{
    //global var counts how many repair conducted. Shall be writen to Test table for every tested barcode
    global $state1; 
   $name; 
  if($in=='1')
  {
    $name="New cable or plug fitted";
    $state1++;
    //tick_check($in,$check);
  }  
  if($in=='2')
  {
    $name="Potentiometer changed or cleaned";
    $state1++;
    //tick_check($in,$check);
  }
  if($in=='3')
  {
    $name="Lens changed or cleaned"; 
    $state1+=1;
    //tick_check($in,$check);
  }
  if($in=='4')
  {
    $name="Internal capacitor or resistor changed";
    $state1+=1;
    //tick_check($in,$check);
  }
  if($in=='5')
  {
    $name="Other internal components changed/repaired";
    $state1+=1;
    //tick_check($in,$check);
  }  
     return $name;
}

//WE ADD NEW Functions here. For barcodes check constraints, like detecting UNQ , FAU and DBS

function check_barcode_constraint($barcode)
{
    $barcode=substr($barcode,0,3);
    $barcode=strtoupper($barcode);
    if(strcmp($barcode,'UNQ')==0 OR strcmp($barcode,'DBS')==0 OR strcmp($barcode,'FAU')==0)
        return 1;
    else
        return 0;
   
}

function check_set_size($barcode)
{
    if(strlen($barcode)==10 or strlen($barcode)==12)
        return 1;
    else
        return 0;
    
    
}



//query database by default prepared statement 
/*
function add_db($sql)
{
	 
  echo mysql_query($sql);

}
*/
//$str = strtoupper($str);

//if (get_magic_quotes_gpc())

/*
MAIN APPLICATION STARTS HERE



>>>>>>>>>>>>>>>>>>>>>>>>>>
*/



//change again hash format into native backslash format. EVERY RECEIVED BARCODE is checked if no hash is there. Every interation is safe to eliminate wrong db format
  $barcode = swap_hash($_POST["barcode"]);

//$barcode=strtoupper($_POST['barcode']);
echo '</br> barcode receved from post'.$barcode;

$item=$_POST['item'];   //Type of Item: DVD, TV
$brand=$_POST['brand'];  //Company name. JVC
$serial=$_POST['serial'];  //PART NUMBER


$pat=$_POST['pat'];
$fun=$_POST['fun'];
$cln=$_POST['cln'];
$vis=$_POST['vis'];

$defect=$_POST['defect'];
$rdy=$_POST['rdy']; //if ready to use

$batch_date=$_POST['batch_date'];
$site_location=$_POST['site_location'];


//IF Todays date and Buyer id is pecified and nopt empty
if(!empty($batch_date) AND !empty($site_location))
{
    echo 'asassdfsfdsfdsdfsdfsdfsdfsdfsdfsdfsfd';
  connect_db();
  
  //than connect db and check todays date what was sold to palticular user. as a one transaction to be implemented. check if transaction finished
 echo $query="SELECT * From Buyer, transaction_waste WHERE Buyer.id_Buyer=transaction_waste.buyer_id AND date_sold='$batch_date' AND id_Buyer='$site_location'";
 //This here must be switched to 2 separate gueries to get pre sesion values or take from posted
  
 
          
  echo "1";
    echo $batch_date.$site_location;
    $_SESSION['batch_date1']=$batch_date;
   $result=query_select($query) or die("wrong");
    echo "<BR/>ES2";
//$users=array();
//$names=array();
//$batch_date=array();

$i=0;






/*
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $users[$i]=$rek["post_code"];    
     $names[$i]=$rek["town"];
     $batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }
  */
  if($rek = mysql_fetch_array($result,1))
  {
  $site_specified=1;  
  
  //if site is specified now, means now exist and if site ref number not specified than generate session ref number
  if($_SESSION['ref_sell_number']==0)
  {
      echo "Generating unique nr";
    $ref=rand();
    $ref_sell_number=$site_location.$batch_date.$ref; 
    $_SESSION['ref_sell_number']=$ref_sell_number;
    
    
    //i think here we generate a invoice req
    
    
    $query_inv="INSERT INTO Invoice_waste(main_pri,net_pri,vat_pri) VALUES(0,0,0)";
 //This here must be switched to 2 separate gueries to get pre sesion values or take from posted
    //echo $batch_date.$site_location;
   $result=query_select($query_inv);
  
    $_SESSION['inv_id_generated']=  mysql_insert_id();
    
    //to be remove if not work
  }   
  echo "sdsd";
  echo $item_type=$_POST['item_type'];
  echo $batch_date=$rek["date_sold"];
  echo $site_location=$rek["id_Buyer"];
  $na=$rek["id_Buyer"];
  $url='sell_item_waste1.php?'.'site_specified='.$site_specified.'&'
  .'batch_date='.$batch_date.'&'
  .'site_location='.$site_location.'&'
  .'site_id='.$na.'&item_type='.$item_type;  
  $_SESSION['site_id_s_s']=$na;
  redirect($url,$TEST_T);
  exit();
  }
  else if($site_specified==0)
  {
    // Here in this modul, that doesnt give ignition. Baybe the case sesion set and vaiables
    echo "else if";
    $ref=rand();
    $ref_sell_number=$site_location.$batch_date.$ref;
    //new number generated, initialisation of empty invoice and omitting adding a new sell ignition rather in session
   
// $insert="INSERT INTO Barcode_has_Buyer(Buyer_id_Buyer,Barcode_id_Barcode,date_sold,user_2,ref_sell_number) VALUES('$site_location','NULL','$batch_date','$id_user','$ref_sell_number')";
    $site_specified=1;
     // $result = mysql_query($insert) 
     //   or die(mysql_error()); 
     
    $_SESSION['ref_sell_number']=$ref_sell_number; //this unique store in session
    
    //invoice generation
    
     $query_inv="INSERT INTO Invoice_waste(main_pri,net_pri,vat_pri) VALUES(0,0,0)";
 //This here must be switched to 2 separate gueries to get pre sesion values or take from posted
    echo $batch_date.$site_location;
   $result=query_select($query_inv);
  echo "£AFTER QUERY";
 $_SESSION['inv_id_generated']=  mysql_insert_id();
          
  
    
    //end of invoice gen
        
       $url='sell_item_waste1.php?'.'site_specified='.$site_specified.'&'
  .'batch_date='.$batch_date.'&'
  .'site_location='.$site_location.'&'
  .'site_id='.$na.'&'
   .'ref_sell_new='.$ref_sell_number;  
  $_SESSION['site_id_s_s']=$site_location;
  redirect($url,$TEST_T);    
  exit();
  }   
    





}
else 
{ 
  $_SESSION['site_id_s_s'];
    
  echo "sama sesja";
  
  
  
  
    
}



//Here we assume we add qtty with empty barcode scenario
//
//problem z pustym barcodem
if(empty($barcode))
{
    $item_type=$_POST['item_type']; //item type will be weee extension specified by item type
    
    $url='sell_item_waste1.php?site_specified='.$site_specified.'&item_type='.$item_type;
    
    if(isset($_POST['quantity'])AND !empty($_POST['quantity']))
    {
        $qtty=$_POST['quantity'];
        $name_cat=$_POST['item_type'];
        
         //we try to for waste qtty get and converse specific id_wee into weee extension from item category
    
    $sql_cnv="SELECT * FROM weee_extension WHERE idweee_extension='$name_cat'";
    $result_cnv=mysql_query($sql_cnv) or die(mysql_error());
    $rek=mysql_fetch_array($result_cnv);
        $name_cat_cnv=$rek['weee_extension']; //this is id_item_cat connected to particular weee id_extension
        $name_ext=$rek['name_ext']; //name_ext is a name of particular group shall be counted and also shown on invoice
        
        
        
        
        
        
        $ref_sell_waste=$_SESSION['ref_sell_number'];
       
        //here we need to check ifmain table is initialised by a barcode waste
        
        check_init_transaction($ref_sell_waste);
        
        //inserting waste quantity
        $insert_waste_qtty="INSERT INTO waste_quantity(qtty,name_cat,idtransaction_waste,name_cat_cnv) VALUES('$qtty','$name_cat_cnv','$ref_sell_waste','$name_cat')"; 
       $result=mysql_query($insert_waste_qtty) or die(mysql_error());
       if($result)
       {
          $url.="&qc=".$qtty;
          $url.="&MESSG=18";
       }
       
        
    }
    
    redirect($url,$TEST_T); 
    //if barcode is empty redirect to form, but $$$form shall be checked by default values, also set not incomplete set of parametters can be send
  exit();         
}




// functions returns to a buffer that is not in use yet. Fun returns hash format. While barcode is still slash format. Thoough javna conversion is needed, before adding barcode 
$barcode2=validate_barcode($barcode);




echo '</br>barcode after validateing: '. $barcode2;


//check if group barcode

if(detect_group_barcode($barcode2, $PREFIX_GROUP_STICKER)==1)
    if(check_group_barcode($barcode2)==1)
        if(check_if_sold_group($barcode2)==1)
        {
            echo "GROUP BARCODE READY TO DISPOSE FOR FURTHER TREATMENT";
            
            extract_group($barcode2);
            //$v_bar_exist=0;
        }
        
        //than do the function of takin individual barcodes and  insert intowee waste
        
 
//here we try to validate a barcode inputed barcode2. We set filtering by size of set and prefix detection limits


if(check_barcode_constraint($barcode2)==0)
    $v_bar_exist=0; 
    
if(check_set_size($barcode2)==0)
    $v_bar_exist=0;





$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

//user is written as a session
$user=$_SESSION['id_user'];
//$user='sas';


$tab = array();
for($z=0;$z<=100;$z++)
   $tab[$z]=0;

 

if($v_bar_exist==1)
{
    echo "Adding Item";
    
    $item_type=$_POST['item_type']; //take weee_extension id, means particular item
    
    //we add here a query that will conver conversion item_type into weee cat
    
    $sql_cnv="SELECT * FROM weee_extension WHERE idweee_extension='$item_type'";
    $result_cnv=mysql_query($sql_cnv) or die(mysql_error());
    $rek=mysql_fetch_array($result_cnv);
        $item_type_cnv=$rek['weee_extension']; //this is id_item_cat connected to particular weee id_extension
        $name_ext=$rek['name_ext']; //name_ext is a name of particular group shall be counted and also shown on invoice
    
    
    //geting barcode details
    $check_item_cat="SELECT * FROM item_has_cat WHERE id_item_cat='$item_type_cnv'"; //we compare weee extension with a item cat id
    $result_check=mysql_query($check_item_cat)or die(mysql_error());
    $rek_check=mysql_fetch_array($result_check);
    $cat=$rek_check['cat']; //we pick up weight and category
    $weight=$rek_check['weight'];
   //than we ading a barcode to waste_barcode
    $insert_barcode="INSERT INTO waste_barcode(Barcode_waste,category,weight,type_item,stock_out,type_item_cnv) VALUES('$barcode2','$cat','$weight','$item_type_cnv','1','$item_type')";
    
    $invoice_id=$_SESSION['inv_id_generated'];
    $ref_sell=$_SESSION['ref_sell_number'];
    $buyer_id=$_SESSION['site_id_s_s'];

    $insert_invoice="";
    
    
    $result_barcode=mysql_query($insert_barcode) or die(mysql_error());
    
    $last_barcode=mysql_insert_id();
    
    if($result_barcode)
    {
        echo "Added waste_barcode";
        
        
    }
    echo "BATCH DATE".$batch_date;
    $batch_date=$_SESSION['batch_date1'];
        $insert_sell="INSERT transaction_waste(ref_sell_number,buyer_id,finished,invoice_waste_idinvoice_waste,waste_barcode_idwaste_barcode,date_sold) Values('$ref_sell','$buyer_id','1','$invoice_id','$last_barcode','$batch_date')";
        $result_sell=mysql_query($insert_sell) or die(mysql_error());
        
        if($result_sell)
        {
           echo "Added transaction sell"; 
           //this function may causing a problem no return value in prtotype
           $site_1=get_barcodes_from_db($barcode2);
           if(!empty($site_1))
           {
              $update="UPDATE waste_barcode SET site='$site_1' WHERE idwaste_barcode='$last_barcode'"; 
              mysql_query($update)or die(mysql_error());
           }
           else if(empty($site_1) AND !strncmp(strtoupper($barcode),"FAU", 3) ) //here we add fau block items assign to our promises while no sticker on it
           {
               $update="UPDATE waste_barcode SET site='18' WHERE idwaste_barcode='$last_barcode'"; 
              mysql_query($update)or die(mysql_error());  
           }    
        }    
    $url="sell_item_waste1.php?item_type=$item_type&MESSG=2";
    redirect($url,$TEST_T);
    exit();
    
}


?>

<HTML>
<HEAD>
<link rel="stylesheet" href="layout.css " type="text/css" />


<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />


<script type="text/javascript" src="csshorizontalmenu.js" > 



</script>


</HEAD>
<BODY >

<table border=1 width=100% height=800 bgcolor="F8F8F8" >
<tr>
<td colspan=2 width=100% height=5% align=right> 

<table border="0" cellpadding="1" cellspacing="3" bgcolor="#F8F8F8">

<?php
//F8F8F8  F0F0F0 #E0E0E0
if(empty($l_klient))
{
$log='<form action="log_pro.php" method="post">
<td>Login</td><td><input type="text" name="login"></td>
<td>Password</td><td><input type="password" name="pass"></td>
<tr>
<td></td><td></td><td></td><td><input type="submit" name="Submit" value="Log In" align="right"> </td>
</tr>
</form>';
echo $log;
}
else
echo "You are Logged In as ".$l_klient;

?>
</table>

</td></tr>

<tr bgcolor="#E0E0E0">
<td colspan=2 width=100% height=15% align=center valign=center> GRR Database System 2
</td>
</tr>
<tr>
<td colspan=2 width=100% height=25px align=right bgcolor="#E0E0E0"> 


<div class="horizontalcssmenu">
<ul id="cssmenu1">
<li style="border-left: 1px solid #202020;"><a href="index.php">Main</a></li>
<li><a href="login.php" >System</a>
<ul>
    <li><a href="">System Configuration</a></li>
    <li><a href="">Add a new System User</a></li>
    <li><a href="">Change User </a> </a></li>
    <li><a href=""></a></li>
     <li><a href="login.php">Logout</a></li>
    </ul></li>

<li><a href="index.php">Stock</a>
    <ul>
    <li><a href="add_stock.php">Add a random item</a></li>
    <li><a href="add_stock.php">Add on Stock</a></li>
    <li><a href="search_all_inv.php">Show Inventory</a></li>
    <li><a href="">Search an Item</a></li>
     <li><a href="">Genereate Report for Stock</a></li>
    </ul></li>
<li><a href="search_broken.php">Tests</a>
    <ul>
    <li><a href="search_broken.php">List faulty items</a></li>
    <li><a href="search_good.php">List working items</a></li>
    <li><a href="search_all.php">All items</a></li>
    <li><a href="add_barcode.php">Test Item</a></li>
    <li><a href="search_rep.php">Repairs</a></li>
    </ul>
</li>
<li><a href="">Search</a>
<ul>
    <li><a href="search_adv.php">Advanced Search</a></li>
    <li><a href="search_da_f.php">By Date</a></li>
    <li><a href=""></a></li>
    </ul>
    </li>
<li><a href="reports_sum.php">Reports</a>
    <ul>
    <li><a href="reports_sum.php">Items Summary</a></li>
    <li><a href="search_report.php">Generate Reports</a></li>
    <li><a href="search_report_pro.php">Check how many items tested</a></li>
    <li><a href="search_report_pro.php?token=1">Check how many items to be tested</a></li>
    </ul>
</li>



<li><a href="reports_sum.php">Sell</a>
    <ul>
    <li><a href="sell_item_waste.php"> Sell Items</a></li>
    <li><a href="">Add a new wholesale buyer</a></li>
    <li><a href="">Ebay Sell</a></li>
    <li><a href="">Add a new Ebay Sell Manually</a></li>
    <li><a href="">Wholesale transaction</a></li>
    
    </ul>
</li>

<li><a href="reports_sum.php">Office</a>
    <ul>
    <li><a href="site_new.php">Add a new Site Place</a></li>
    <li><a href="buyer_new.php">Add a new Buyer</a></li>
    <li><a href=""></a></li>
    </ul>
</li>

</ul>
<br style="clear: left;" />
</div>


  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>

<?php
 $item_type=$_POST['item_type'];
        $url='sell_item_waste1.php?site_specified='.$site_specified.'&item_type='.$item_type;
        redirect($url,$TEST_T);
			redirect($url,$TEST_T);
    
?>


</td>
</tr>
</table>




</BODY>
</HTML>