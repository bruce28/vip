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

$MESSG=0;
//debbugin values for a test mode

$TEST_T=0;

$site_id;

//error_reporting(E_ALL ^ E_NOTICE);



 $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    //select database dbs3
    mysql_select_db('dbs3');

?>


<?php

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
   $url="sell_item.php";
   $ref_sell_tmp=$_SESSION['ref_sell_number'];
   
   
  $update="UPDATE Barcode
INNER JOIN Barcode_has_Buyers ON Barcode.id_Barcode=Barcode_has_Buyer.Barcode_id_Barcode
SET stock_out='0' WHERE ref_sell_number='$ref_sell'";
   
   
   $select_sql="SELECT * FROM Barcode_has_Buyer WHERE ref_sell_number='$ref_sell_tmp'"; 
   
   //$update="UPDATE Barcode SET stock_out='0' WHERE ref_sell_number='$ref_sell'";
   $re=mysql_query($select_sql) or die(mysql_error());
   
   while($res_t=mysql_fetch_array($re))
   {
    $bar_tmp=$res_t['Barcode_id_Barcode'];
    $insert1="UPDATE Barcode SET stock_out=0 WHERE id_Barcode='$bar_tmp'";
    mysql_query($insert1) or die(mysql_error());
    
    $insert2="UPDATE Barcode_has_Buyer SET finished=3 WHERE ref_sell_number='$ref_sell_tmp'";
    
    mysql_query($insert2) or die(mysql_error());
    
    
    $invoice="UPDATE Barcode_has_Buyer SET Invoice_inv_id='1' WHERE ref_sell_number='$ref_sell_tmp'";
     mysql_query($invoice) or die(mysql_error());
    
    $last_invoice_nr=$res_t['Invoice_inv_id'];
   
    
   }
   
   //lets implement cancel removing last inv id
    
   
    echo "Last invoice ". $last_invoice_nr;
    if(empty($last_invoice_nr))
    {
 
       
     echo "in empty trans ";
      $max_value="SELECT MAX(inv_id) as maxinv FROM invoice";
        
      $res_max=mysql_query($max_value) or die(mysql_errno());
         $rek_max=mysql_fetch_array($res_max);
         $max_id=$rek_max['maxinv'];
         
               $delete="DELETE FROM invoice WHERE inv_id='$max_id'";
       mysql_query($delete) or die(mysql_error());
       
          $alter="ALTER TABLE invoice AUTO_INCREMENT=$max_id";
        mysql_query($alter) or die(mysql_error());
        echo $max_id;
    }
    else
    {
       echo "IN Initialised cancel";
        
       $delete="DELETE FROM invoice WHERE inv_id='$last_invoice_nr'";
       mysql_query($delete) or die(mysql_error());
       
       $alter="ALTER TABLE invoice AUTO_INCREMENT=$last_invoice_nr";
        mysql_query($alter) or die(mysql_error()); 
    }  
   
   
   
   //select every sel ref before and change to 0 finished and update barcode
   
   
   
   unset($_SESSION['site_id_s_s']);
   unset($_SESSION['ref_sell_number']);
			redirect($url,$TEST_T);
   exit();
}



if(isset($_POST['Finish'])) {
   echo 'Processing your sell request';
   $ref_sell=$_SESSION['ref_sell_number'];
   $url="sell_item_invoice.php?invoice=1&show=1&ref_sell=".$ref_sell;
   
   
   $update="UPDATE Barcode_has_Buyer SET finished='2' WHERE ref_sell_number='$ref_sell'";
   mysql_query($update) or die(mysql_error());
   
    $inv_sql="Insert INTO Invoice(main_pri,vat,net) VALUES(0,0,0)";
   //mysql_query($inv_sql) or die(mysql_error());
   
   $inv_last_id=mysql_insert_id();
   
   //here we modify code to omit insert and use the last insert id
   
   $inv_last_id=$_SESSION['inv_id_generated'];
   
   $update_inv="UPDATE Barcode_has_Buyer SET Invoice_inv_id='$inv_last_id' WHERE ref_sell_number='$ref_sell'";
   
   mysql_query($update_inv) or die(mysql_error());
   
   
   
   
   unset($_SESSION['site_id_s_s']);
   unset($_SESSION['ref_sell_number']);
   // select every ref and 
			redirect($url,$TEST_T);
   exit();
}  
  

//changin remove modul add

if(isset($_POST['print_out']))
{
    $bar_tmp=$_POST['barcode'];
    
    $insert2="SELECT id_Barcode FROM Barcode WHERE Barcode='$bar_tmp'";
    $result=mysql_query($insert2) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    $id_bar=$rek[0];

    
    
    
    $show="SELECT Barcode_id_Barcode FROM barcode_has_buyer WHERE Barcode_id_Barcode='$id_bar' AND finished=2";
    $result=mysql_query($show) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    if($rek[0]!=$id_bar)
    {
    $insert1="UPDATE Barcode SET stock_out=0 WHERE Barcode='$bar_tmp'";
    mysql_query($insert1) or die(mysql_error());

    $insert2="SELECT id_Barcode FROM Barcode WHERE Barcode='$bar_tmp'";
    $result=mysql_query($insert2) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    $id_bar=$rek[0];

    $insert3="DELETE from barcode_has_buyer WHERE Barcode_id_Barcode='$id_bar'";
    
    mysql_query($insert3) or die(mysql_error());
    }
    $url="sell_item.php?print_out=1";
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
 





$sql_12 = "SELECT * FROM Barcode                       
     Where Barcode='$in'"; 
  
  $res_12= mysql_query($sql_12) or die(mysql_error());
  $res_12_fetch=mysql_fetch_array($res_12);
 
  if($res_12_fetch["Barcode"]==$in)
  {
     $MESSG=5;
     //changed by night
     $sql_121 = "SELECT * FROM Barcode 
     INNER JOIN Test ON Barcode.id_Barcode=Test.Barcode_id_Barcode                      
     Where Barcode='$in' AND Ready='0'"; 
  
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
      
	 $sql = "SELECT * FROM Barcode 
     INNER JOIN Test ON Barcode.id_Barcode=Test.Barcode_id_Barcode
     Where Barcode='$in' AND Ready='1'"; 
	 
    
    
   
     
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
        $v_bar_exist=1;
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
       $v_bar_exist=0;
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

//query database by default prepared statement 
function add_db($sql)
{
	 
  echo mysql_query($sql);

}

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
  $query="SELECT * From Buyer INNER JOIN Barcode_has_Buyer ON Buyer.id_Buyer=Barcode_has_Buyer.Buyer_id_Buyer WHERE date_sold='$batch_date' AND id_Buyer='$site_location'";
 //This here must be switched to 2 separate gueries to get pre sesion values or take from posted
  
 
          
  
    echo $batch_date.$site_location;
   $result=query_select($query);
    
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
    $ref=rand();
    $ref_sell_number=$site_location.$batch_date.$ref; 
    $_SESSION['ref_sell_number']=$ref_sell_number;
    
    
    //i think here we generate a invoice req
    
    
    $query_inv="INSERT INTO Invoice(main_pri,vat,net) VALUES(0,0,0)";
 //This here must be switched to 2 separate gueries to get pre sesion values or take from posted
    //echo $batch_date.$site_location;
   $result=query_select($query_inv);
  
    $_SESSION['inv_id_generated']=  mysql_insert_id();
    
    //to be remove if not work
  }   
  
  echo $batch_date=$rek["date_sold"];
  echo $site_location=$rek["id_Buyer"];
  $na=$rek["id_Buyer"];
  $url='sell_item.php?'.'site_specified='.$site_specified.'&'
  .'batch_date='.$batch_date.'&'
  .'site_location='.$site_location.'&'
  .'site_id='.$na;  
  $_SESSION['site_id_s_s']=$na;
  redirect($url,$TEST_T);
  exit();
  }
  else if($site_specified==0)
  {
    // Here in this modul, that doesnt give ignition. Baybe the case sesion set and vaiables
    
    $ref=rand();
    $ref_sell_number=$site_location.$batch_date.$ref;
    //new number generated, initialisation of empty invoice and omitting adding a new sell ignition rather in session
   
// $insert="INSERT INTO Barcode_has_Buyer(Buyer_id_Buyer,Barcode_id_Barcode,date_sold,user_2,ref_sell_number) VALUES('$site_location','NULL','$batch_date','$id_user','$ref_sell_number')";
    $site_specified=1;
     // $result = mysql_query($insert) 
     //   or die(mysql_error()); 
     
    $_SESSION['ref_sell_number']=$ref_sell_number; //this unique store in session
    
    //invoice generation
    
     $query_inv="INSERT INTO Invoice(main_pri,vat,net) VALUES(0,0,0)";
 //This here must be switched to 2 separate gueries to get pre sesion values or take from posted
    echo $batch_date.$site_location;
   $result=query_select($query_inv);
  
 $_SESSION['inv_id_generated']=  mysql_insert_id();
          
  
    
    //end of invoice gen
        
       $url='sell_item.php?'.'site_specified='.$site_specified.'&'
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


//set_tab_val($check);
//chck_def();

//problem z pustym barcodem
if(empty($barcode))
{
    $url='sell_item.php?'.'site_specified='.$site_specified;
    redirect("$url",0); 
    //if barcode is empty redirect to form, but $$$form shall be checked by default values, also set not incomplete set of parametters can be send
  exit();         
}

if(!empty($item))
{
 //type of item is set as true if item field is not empty   
 $s_item=1; 
 $V_ITEM=$item; //Field V_ITEM that is sent back is set on that particulat item name that was send before  
     
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


// if pat is set

/*
if(isset($pat))
{
  if($pat==0)  
  $v_pat=1;
  if($pat==1)
  $v_pat=2;  
  echo "PAT ustawione".$pat;  
}

if(isset($fun))
{
  if($fun==0)  
  $v_fun=1;
  if($fun==1)
  $v_fun=2;  
  echo "FUN ustawione".$fun;  
}

if(isset($cln))
{
  if($cln==0)  
  $v_cln=1;
  if($cln==1)
  $v_cln=2;  
  echo "CLN ustawione".$cln;  
}
if(isset($vis))
{
  if($vis==0)  
  $v_vis=1;
  if($vis==1)
  $v_vis=2;  
  echo "VIS ustawione".$vis;  
}

*/


// functions returns to a buffer that is not in use yet. Fun returns hash format. While barcode is still slash format. Thoough javna conversion is needed, before adding barcode 
$barcode2=validate_barcode($barcode);

echo '</br>barcode after validateing: '. $barcode2;

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

//user is written as a session
$user=$_SESSION['id_user'];
//$user='sas';


$tab = array();
for($z=0;$z<=100;$z++)
   $tab[$z]=0;

  //echo $barcode2;
    //echo $_POST[$idd];
    //echo " "; 
  echo $pat ;
		//echo $_POST[$name];
    //echo " "; 
      
      
      //barcode not exist  v-pat set
      // if barcode does not exist in database or barcode read from db exist but doesnt fit the barcode inputed and everything else is set than
if($v_bar_exist!=0 /**
 * AND 
 * $s_item=0 AND
 * $s_brand=0 AND
 * $s_serial=0
 */
)
{
   /**
 *  
 *     //prepared statement. Set an random item, while part number not set. Cahnge here to ad PART NUMBER/
 *     $insert2="INSERT INTO `item`(`pn` ,`brand` ,`name`) VALUES ('$serial','$brand','$item')";
 *     
 *   echo mysql_query($insert2) or die("Insert ITEm Wrong");
 *     
 *   // last id stored of last item modified and saved as variable $id_item_l 
 *   $last_id = mysql_insert_id();
 *   $id_item_l= $last_id;
 *   //$barcode=(string)$barcode;
 *   echo '<br>before insert'.$barcode;
 *   
 *   //changing to hash format for purpose of writing hash format into db.
 *   $barcode=swap_back($barcode);
 *   //prepared statement. Add barcode, serial number not in form. delivery and stocked_problem. Delivery id must be set before the form is filled. Delivery is Site id cause
 *   // every particular item added to stock comes from particular siteplace
 *  $insert3="INSERT INTO `barcode` (`Item_id_item` ,`Barcode` ,`serial` ,`date`,stock_in,user_2,Site_site_id) VALUES ('$last_id','$barcode','0',NOW(),'1','$user','$sesja')";
 *   
 */
  $barcode=swap_back($barcode);
 /////update seeling and barcode as
 
   $check_sql="SELECT * FROM Barcode WHERE stock_out=1 AND Barcode='$barcode'";
   $res1=mysql_query($check_sql) or die("SELECt from barcode sold out");
   
   if(mysql_num_rows($res1))
   {
    //just if not sold, before was no redirect
      echo "item sold";
      $url="sell_item.php?MESSG=1";
      redirect($url,$TEST_T);
      exit();
   }
 
     
     $check_sql1="SELECT * FROM Barcode WHERE Barcode='$barcode'";
   $barco=mysql_query($check_sql1) or die("SELECt from barcode sold out");
   
    $rek1=mysql_fetch_array($barco);
     $ba=$rek1["id_Barcode"];
      echo $ba;
      //here update
    
    
     //end update
// $ba=mysql_insert_id();
      // bar id is the last id of barcode that had been added
      //$bar_id=mysql_insert_id();   
    echo "Barcode ID: ".$bar_id." Barcode ".$barcode." Barcode2".$barcode2."sddas ";
    
      // this if set cheked before on the condition coming into insert function. but checked twice just for sure 
    $ref=$_SESSION['ref_sell_number'];
    $inv_gn=$_SESSION['inv_id_generated']; //here mistake cause probably not generated inv id in the multi seed
    echo "</BR>FASDF: ";
    echo $barcode." ";
    echo $site_location." s".$ba;
    echo "</BR>";
    $site_location=$_SESSION["site_id_s_s"];
    
     $insert3="INSERT INTO Barcode_has_Buyer(Barcode_id_Barcode, Invoice_inv_id,Buyer_id_Buyer,ref_sell_number,date_sold,user_2,finished) VALUES('$ba','$inv_gn','$site_location','$ref',now(),'$id_user','1')";
    
  mysql_query($insert3) or die(mysql_error());

  
  $insert3="UPDATE barcode SET stock_out=1 WHERE barcode='$barcode'";
    
  mysql_query($insert3) or die("Update Barcode Wrong");
  
  
      // bar id is the last id of barcode that had been added
      //$bar_id=mysql_insert_id();   
    echo "Barcode ID: ".$bar_id." Barcode ".$barcode." Barcode2".$barcode2."sddas ";
    
    
    //ADD a transaction, 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      
      
     /**
 *  $ts=validate_test($pat,$fun,$cln,$vis);
 *       echo "<BR><BR>SATE </br>". $state1."</br> STATE</br><BR>";
 * 	 $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`,`state`) VALUES ('$user','$bar_id','$pat', '$cln', '$fun', '$vis', '$ts','$state1')"; 
 * 	 
 * 	 
 *      //hash fromat to backslash format since we do not use barcode inertion anymore
 * 	 $barcode=swap_hash($barcode);
 *   //echo mysql_query($insert1) or die("INSERT test Wrong");
 *      //last test_id
 *      $last_id_t = mysql_insert_id();
 *      echo "last".$last_id_t;
 * 	 $d=0;
 * for($i=1;$i<=10;$i++)
 * { 

 *   $d++;
 * 	
 * 	$def_name="defect".$d;
 *   //$tab[$i]=0;   
 * 	  echo "</ BR></BR>"; 
 *   
 *     //echo $_POST[$weight];
 *     //echo " "; 
 *   
 *     //echo $_POST[$cat_id];
 *   
 * 	//we recieve defect incrementation by name
 * 	if(isset($_POST["$def_name"]))
 * 	 if($_POST["$def_name"]=="1")
 * 	 {
 * 	  echo $d;
 * 	   
 * 	  echo $_POST["def_name"];
 * 	  
 *       $nam=checkin($d);
 *       $insert4="INSERT INTO`defect`( `Test_id_test` ,`state` ,`notes`) 
 *      VALUES ('$last_id_t','$nam',NULL )";
 *     
 *   //echo mysql_query($insert4) or die("INSERT defect wrong");
 *      }
 */

  

    //echo $sum_sub;
  //$tab[$_POST[$cat_id]]+=$sum_sub; 

 
	//echo $site;
	
	
	
   


  

/*
  $pre=1;        
  $insert5="INSERT INTO `quantity` (`Item_id_item` ,`quantity`) 
VALUES ('$id_item_l','$pre'
) ";
  
    
  //echo mysql_query($insert5);
*/
  if($rdy==0)
  {
    
     $update1="UPDATE `test` SET `disposal`='1' WHERE `id_test`='$last_id_t'";
  
    echo $last_id_t;
    //echo mysql_query($update1) or die("Blad w zapytaniu!");

  }

   
  
   $update2="UPDATE `test` SET `state`='$state1' WHERE `id_test`='$last_id_t'";
  
   
 // mysql_query($update2) or die("Blad w zapytaniu!");
  
  //that was redireted to sell intem pro the sam form, not good may be mistake here
  //optional
    $barcode=swap_hash($barcode);
   $url="sell_item.php?test=".$barcode."&MESSG=2";
   //concat($url,$check);
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
    <li><a href="sell_item.php"> Sell Items</a></li>
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
/*
$sql = "SELECT * FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id";
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
     echo "</table> ";
*/

/*
 * echo "PRE". $V_BAR_EX;
 * $V_BAR_EX=swap_hash($V_BAR_EX);
 * $url='sell_item.php?'.'bar_ex='.$v_bar_exist.'&'
 * /.'v_pat='.$v_pat.'&'
 * .'v_fun='.$v_fun.'&'
 * .'v_cln='.$v_cln.'&'
 * .'v_vis='.$v_vis.'&'/
 * .'s_item='.$s_item.'&'
 * .'s_brand='.$s_brand.'&'
 * .'s_serial='.$s_serial.'&'
 * .'V_BARCODE='.$V_BAR_EX.'&'
 * .'V_ITEM='.$V_ITEM.'&'
 * .'V_BRAND='.$V_BRAND.'&'
 * .'V_SERIAL='.$V_SERIAL
 * ;
 */



//if barcode not in db hopefully

   $site_specified=1;

   $site_location=$_SESSION['site_id_s_s'];
//     $url='sell_item.php?'.'site_specified='.$site_specified.'&'
 //  .'batch_date='.$batch_date.'&'
  // .'site_location='.$site_location.'&'
  // .'site_id='.$na; 

//a fresh link
  $url="sell_item.php?MESSG=$MESSG";


   //.'ref_sell_new='.$ref_sell_number;  
 // $_SESSION['site_id_s']=$na;

/*
for($i=0;$i<10;$i++)
{
   echo $check[$i];
   echo "</BR>"; 
}
chck_def();
*/
//$url=concat($url,$defect);

/*
for($i=1;$i<=6;$i++)
{ 

  $d++;
	$pointer_defect=0;
    
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
	   
	  echo $_POST["def_name"];
      $pointer_defect=1; 
      }
   
     
    $url.="&".$def_name."=".$pointer_defect; 
}      
*/
			redirect($url,$TEST_T);
    
?>


</td>
</tr>
</table>




</BODY>
</HTML>