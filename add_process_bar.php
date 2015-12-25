<?php
session_start();
//header('Location: add_barcode.php?processing=true&bar_ex='.$v_bar_exist.'');
//$state=0;

include 'header_valid.php';

$test=0;
$TEST_T=0;
$MESSG=0;
include "header_mysql.php";

$_SESSION["bar_last"];

$_SESSION['meter'];


if (empty($_POST['submitted'])) {
   echo 'Test form not filled';
   if(isset($_SESSION['meter']))
unset($_SESSION['meter']);
   $url="add_barcode.php";
   
			redirect($url,0); //1
            exit();
}

if(isset($_POST['Cancel'])) {
   //echo 'Test form not filled';
   if(isset($_SESSION['meter']))
unset($_SESSION['meter']);
    
   $url="add_barcode.php?MESSG=10";
   
			redirect($url,0);
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
$v_frm=0;
$v_rin=0;
$v_fuse=0;
  
$s_item=0;
$s_brand=0;
$s_serial=0;

$state1=0;
$check=array();
$check[2]=2;
$defect=array();
$barcode_id=0;
$picked_up_test=0;
$v_com=0;
$V_COMU=0;


/*
function chck_def()
{
  $def=array();  
  global $defect;  
  for($i=0;$i<5;$i++){  
  $def="defect".$i;  
  $defect[$i]=$_POST['def']; 
  echo "s ".$defect[$i];
}
}

function set_tab_val(&$tab)
{
    for($i=0;$i<10;$i++)
      $tab[$i]=10;   
    
}
 
function concat($url,&$defect)
{
    
  for($i=0;$i<5;$i++){  
  //$url.="&defect".$i."=".$con[$i];
  $url.="&defect".$i."=".$defect[$i];
  echo $url;  
  
  }
  return $url;
}


function tick_check($i,&$check)
{
    
    //$check[3]=3;
    $check[$i]=1;
  
}
*/

function check_test($id_bar)
{
  global $MESSG;
  connect_db();
  $sql="SELECT * FROM Test Where Barcode_id_Barcode=$id_bar";
  $result=add_db($sql);
  if($rek=mysql_fetch_array($result,1))
  {
    if($MESSG==4)
    $MESSG=3;
    $id_test=$rek["id_test"];
    return $id_test;
  }
  else
  {
    return -1;  
  } 
}

function add_db($sql)
{
   $result=mysql_query($sql)or die(mysql_error()) ;
	return $result;
}

function fill_fields($item,$brand,$serial,$barcode)
{  
  global $item;  
  global $brand;
  global $serial;
  global $picked_up_test;
  global $MESSG;
    
  $barcode=swap_back($barcode);  
  //if(empty($item)AND isset($item))
  //{
    $connect=mysql_connect('localhost','root','krasnal')
     or die(mysql_error());

     mysql_select_db('dbs3');
     echo 'empty item';
     
     $sql_get_barcode="Select * from Barcode Where Barcode='$barcode'";
     $result=add_db($sql_get_barcode);
     if($item_id = mysql_fetch_array($result,1))
     {
     $item_id_1= $item_id["Item_id_item"]; 
     echo $item_id_1;
     
     $sql_get_item="SELECT * FROM Item Where id_item='$item_id_1'";
     $result=add_db($sql_get_item);
     if($res = mysql_fetch_array($result,1))
     {
     $item=$res["name"];
     $brand=$res["brand"];
     $serial=$res["pn"];
     
       $MESSG=4;
     //$picked_up_test=1;
     echo $item;
     }
     else
      echo 'Barcode in the system but no item issociated';
     }
     else{
        //if($_SESSION["bar_last"]!=$barcode)
       // {  //if item in the system maybe reset settings test
        $item='0';
        $brand='0';
        $serial='0';
        $_SESSION["bar_last"]=$barcode;
        $MESSG=2;
      //  }
     }
     
    
    
 // }  
    
    
    
    
    
}

  
function barcode_string()  
{
    
    
    
}   


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
    $in=swap_back($in);
    //chech trim here
    //$in=trim($in); maybe doubles?
    $connect=mysql_connect('localhost','root','krasnal')
    or die(mysql_error());

    mysql_select_db('dbs3');
    echo '</br> barcode in validate'.$in;


      
     
      
	 $sql = "SELECT * FROM Barcode Where Barcode='$in'"; 
	 
    
    
     
	echo "valid"; 
  $result= mysql_query($sql) or die("SELECT BAR Wrong");
  
  echo '<BR>va'.$in;
  global $V_BAR_EX;
  global $v_bar_exist;
  global $barcode_id;
  $rek=0;
  //$in=  addslashes($in);
  if($rek = mysql_fetch_array($result, 1))  
   {
      
     if($rek['Barcode']==$in)  //since before was more clear $rek['Barcode']==$in
      {
         echo 'taki barcode istnieje'; 
        
        
         $barcode_id=$rek["id_Barcode"];
         $v_bar_exist=1;
       echo "as:".$in;    
        $V_BAR_EX=$rek["Barcode"];
        //exit();
        return 0;  //return zero but why?
      }
      else
      {
        echo 'nierowne';  //dangerous cause if nierowne than going to insert new neds an instans in sesjon messaging system.hm seems function fill fields see that valuse an get message but this tottally dont
        echo ' Porownaj Barcoe[]'.$rek['Barcode'].' in '.$in;
        $v_bar_exist=3;
        $V_BAR_EX=$in;
                //$rek['Barcode'];
        return $in;
        
      }
   }
   else
   {   
       $v_bar_exist=0;
       $V_BAR_EX=$in;
       echo 'nieistnieje';
       return $in;
    }
}    

//adding validation of to more fields formatted and reinstallation
function validate_test($pat,$fun,$cln, $vis,$rin,$frm,$fuse)
{
  $test=1;  
  if(isset($pat)AND ($pat==1 OR $pat==2))
   if(isset($rin)AND ($rin==1 OR $rin==2))
    if(isset($frm)AND ($frm==1 OR $frm==2))
         if(isset($fuse)AND ($fuse==1 OR $fuse==2))  //adding validation for corrected fuse
  if(isset($fun)AND $fun==1)
  if(isset($cln)AND $cln==1)
  if(isset($vis)AND $vis==1)
    return $test;
  else
  {
     $test=0; 
     return $test; 
  }   
    
}
function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


function checkin($in)
{
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



//$str = strtoupper($str);

//if (get_magic_quotes_gpc())  
//issuse is a white space by the end of string this produce nieistnieje przy comparison generuje blad typu 3. Solution we try trim
//notice passed barcode with % and space also. something wrong with stock input, cause if added something stocked in that 0 
$barcode = swap_hash(trim($_POST["barcode"]));

//$barcode=strtoupper($_POST['barcode']);
echo '</br> barcode receved from post'.$barcode;
$item=$_POST['item'];
$brand=$_POST['brand'];
$serial=$_POST['serial'];
$pat=$_POST['pat'];
$fun=$_POST['fun'];
$cln=$_POST['cln'];
$vis=$_POST['vis'];
$defect=$_POST['defect'];
$rdy=$_POST['rdy'];

$frm=$_POST['frm'];
$rin=$_POST['rin'];
$fuse=$_POST['fuse'];

//set_tab_val($check);
//chck_def();

if( empty($barcode))
{
    redirect("add_barcode.php",0); 
  exit();         
}

fill_fields($item,$brand,$serial,$barcode);

if($picked_up_test==1)
{
  $pat=NULL;
  $fun=$cln=$vis=$frm=$rin=null;  
    
}
if(!empty($item))
{
    
 $s_item=1; 
 $V_ITEM=$item;  
     
}


if(!empty($brand))
{
 $s_brand=1;   
 $V_BRAND=$brand; 
}


if(!empty($serial))
{
 $s_serial=1;    
 $V_SERIAL=$serial;
}



if(isset($pat))
{
  if($pat==0)  
  $v_pat=1;
  if($pat==1)
  $v_pat=2;  
  if($pat==2)
  $v_pat=3;
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

if(isset($frm))
{
  if($frm==0)  
  $v_frm=1;
  if($frm==1)
  $v_frm=2;  
  if($frm==2)
  $v_frm=3;
  echo "FRM ustawione".$frm;  
}

if(isset($rin))
{
  if($rin==0)  
  $v_rin=1;
  if($rin==1)
  $v_rin=2;  
  if($rin==2)
  $v_rin=3;
  echo "RIM ustawione".$rin;  
}

if(isset($fuse))
{
  if($fuse==0)  
  $v_fuse=1;
  if($fuse==1)
  $v_fuse=2;  
  if($fuse==2)
  $v_fuse=3;
  echo "FUSE ustawione".$pat;  
}


$barcode2=validate_barcode($barcode);

echo '</br>barcode after validateing: '. $barcode2;

$connect=mysql_connect('localhost','root','krasnal')
  or die(mysql_error());

mysql_select_db('dbs3');

$user=$_SESSION['id_user'];


$tab = array();
for($z=0;$z<=100;$z++)
   $tab[$z]=0;

  //echo $barcode2;
    //echo $_POST[$idd];
    //echo " "; 
  echo $pat ;
		//echo $_POST[$name];
    echo " EXI OR NOT"; 
      
      
      //barcode not exist  v-pat set
if($v_bar_exist==0 AND $v_pat!=0 AND $v_fun!=0 AND
$v_cln!=0 AND
$v_vis!=0 AND
$s_item!=0 AND
$s_brand!=0 AND
$s_serial!=0 AND
$v_frm!=0 AND
$v_rin!=0
)
{
    echo "inside inser empty";
    
    $insert2="INSERT INTO `item`(`pn` ,`brand` ,`name`) VALUES ('$serial','$brand','$item')";
    
  echo mysql_query($insert2) or die(mysql_error());
    
  $last_id = mysql_insert_id();
  $id_item_l= $last_id;
  //$barcode=(string)$barcode;
  echo '<br>before insert'.$barcode;
  $barcode=swap_back($barcode);
  
  //no need while testing add a date to barcode.date. removed  NOW() ,,`date` 
 $insert3="INSERT INTO `barcode` (`Item_id_item` ,`Barcode` ,`serial`,date,stock_in,user_2) VALUES ('$last_id','$barcode','0',now(),'1',$user
)";
  
    
  mysql_query($insert3) or die("INSERT Barcode Wrong");

      
      $bar_id=mysql_insert_id();   
    echo "Barcode ID: ".$bar_id." Barcode ".$barcode." Barcode2".$barcode2."sddas ";
      $ts=validate_test($pat,$fun,$cln,$vis,$rin,$frm);
      echo "<BR><BR>SATE </br>". $state."</br> STATE</br><BR>";
	 $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`,`state`,Formatted_id_form,Reinstallation_id_reinst,date) VALUES ('$user','$bar_id','$pat', '$cln', '$fun', '$vis', '$ts','$state1','$frm','$rin',now())"; 
	 
	 
	 $barcode=swap_hash($barcode);
  echo mysql_query($insert1) or die("INSERT test Wrong");
     
     $last_id_t = mysql_insert_id();
     echo "last".$last_id_t;
	 $d=0;
for($i=1;$i<=10;$i++)
{ 

  $d++;
	
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
	  
      $nam=checkin($d);
      $insert4="INSERT INTO`defect`( `Test_id_test` ,`state` ,`notes`) 
     VALUES ('$last_id_t','$nam',NULL )";
    
  echo mysql_query($insert4) or die("INSERT defect wrong");
     }
    
}
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
 // echo mysql_query($update1) or die("Blad w zapytaniu!");

  }

   
  
   $update2="UPDATE `test` SET `state`='$state1' WHERE `id_test`='$last_id_t'";
  
   
  mysql_query($update2) or die("Blad w zapytaniu!");
  
   $url="index.php?test=".$barcode;
   //concat($url,$check);
     redirect($url,$TEST_T+5);
     exit();
 }
 
 
 
 
 
 
$v_test_bar_id=check_test($barcode_id); 
 echo 'jhjkhsdakjhasdkj'.$barcode_id;
 
 $meter=0;
 
 if($v_pat==2)  //V_PAT YES PASS
 {    $meter=2;
      $_SESSION['meter']=$meter;
      $MESSG1=11;
      if(isset($_POST['meter']))
        if(!empty($_POST['meter']))
            $meter_out=$_POST['meter'];
        
        if($v_pat==2 AND empty($meter_out))
        {
            $meter=0;
        }
 }
 if($v_pat==3 OR $v_pat==1)  //V PAT NOT APPLICABLE OR FAIL
 {
     $meter=1; //allow to add
      $_SESSION['meter']=$meter;
     
 }
 
 //if barcode exist and had not yet been tested
if($v_bar_exist==1 AND $v_pat!=0 AND $v_fun!=0 AND
$v_cln!=0 AND
$v_vis!=0 AND
$s_item!=0 AND
$s_brand!=0 AND
$s_serial!=0 AND
$v_frm!=0 AND
$v_rin!=0 AND $v_test_bar_id==-1 AND $v_fuse!=0 AND $meter==1 OR $meter==2
)
{
    
   echo "</BR>barcode does not exist";
   
   
   if($meter==1) //meter defaul not needed
   {
   $ts=validate_test($pat,$fun,$cln,$vis,$frm,$rin,$fuse);
      echo "<BR><BR>SATE </br>". $state."</br> STATE</br><BR>";
	 $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`,`state`,Formatted_id_form,Reinstallation_id_reinst,date,Fuse_id_fuse) VALUES ('$user','$barcode_id','$pat', '$cln', '$fun', '$vis', '$ts','$state1','$frm','$rin',CURDATE(),'$fuse')"; 
	 
	 
	 $barcode=swap_hash($barcode);
  echo mysql_query($insert1) or die(mysql_error());
 
  
   }
   else if($meter==2)  //meter specified
   {
       $ts=validate_test($pat,$fun,$cln,$vis,$frm,$rin,$fuse);
       //validation for metter
       if($meter_out>0)
       $insert1 = "INSERT INTO `test` (`User_2_id_user`, `Barcode_id_Barcode`, `Pat_id_pat`, `Cleaning_id_clean`, `Functional_id_fun`, `Visual_id_visual`, `Ready`,`state`,Formatted_id_form,Reinstallation_id_reinst,date,Fuse_id_fuse,meter) VALUES ('$user','$barcode_id','$pat', '$cln', '$fun', '$vis', '$ts','$state1','$frm','$rin',CURDATE(),'$fuse','$meter_out')"; 
	 
	 
	 $barcode=swap_hash($barcode);
  echo mysql_query($insert1) or die(mysql_error());
   }    
     $last_id_t = mysql_insert_id();
     echo "last".$last_id_t;
	 $d=0;
         
         //free sesion
         if(isset($_SESSION['meter']))
             unset($_SESSION['meter']);
         
for($i=1;$i<=10;$i++)
{ 

  $d++;
	
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
	  
      $nam=checkin($d);
      $insert4="INSERT INTO`defect`( `Test_id_test` ,`state` ,`notes`) 
     VALUES ('$last_id_t','$nam',NULL )";
    
  echo mysql_query($insert4) or die("INSERT defect wrong");
     }
    
}
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
 // echo mysql_query($update1) or die("Blad w zapytaniu!");

  }

   
  
   $update2="UPDATE `test` SET `state`='$state1' WHERE `id_test`='$last_id_t'";
  
   
  mysql_query($update2) or die("Blad w zapytaniu!");
  
  /*
   $url="index.php?test=".$barcode;
   //concat($url,$check);
     redirect($url,5);
     exit();
    */
     
     $url="add_barcode.php?test=".$barcode."&MESSG=1";
   //concat($url,$check);
     redirect($url,$TEST_T);
     exit();
   
 }
 
 /*
 if($v_bar_exist==1 AND $v_pat!=0 AND $v_fun!=0 AND
$v_cln!=0 AND
$v_vis!=0 AND
$s_item!=0 AND
$s_brand!=0 AND
$s_serial!=0 AND
$v_frm!=0 AND
$v_rin!=0 AND $v_test_bar_id!=-1
)
{
 $v_com=1;
 $V_COMU=1;   
    echo "inside";
} 
 */
 
 
 
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


echo "PRE". $V_BAR_EX;
$V_BAR_EX=swap_hash($V_BAR_EX); //if we add trime here that works fine no % at the end20
$url='add_barcode.php?'.'bar_ex='.$v_bar_exist.'&'
.'v_pat='.$v_pat.'&'
.'v_fun='.$v_fun.'&'
.'v_cln='.$v_cln.'&'
.'v_vis='.$v_vis.'&'
.'v_frm='.$v_frm.'&'
.'v_rin='.$v_rin.'&'
.'v_fuse='.$v_fuse.'&'        
.'s_item='.$s_item.'&'
.'s_brand='.$s_brand.'&'
.'s_serial='.$s_serial.'&'
.'V_BARCODE='.$V_BAR_EX.'&'
.'V_ITEM='.$V_ITEM.'&'
.'V_BRAND='.$V_BRAND.'&'
.'V_SERIAL='.$V_SERIAL.'&'
.'MESSG='.$MESSG
;
if($v_com==1)
  $url.="&V_COMU=".$V_COMU; 


if($meter_out>0)
    $url.="&meter_out=".$meter_out;

   
if($v_bar_exist==1)
{
   //$url.="&block_test=1"; 
      if($v_test_bar_id==-1)
         $url.="&block_test=1";     
    
}
else
    

   
/*
for($i=0;$i<10;$i++)
{
   echo $check[$i];
   echo "</BR>"; 
}
chck_def();
*/
//$url=concat($url,$defect);

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

			redirect($url,$TEST_T);
    
?>
<br><BR>

<?php //<IMG SRC="weee/WEEE%20Collection%20v3_html_594f4c37.jpg" WIDTH=642 HEIGHT=127>
?>

</BODY>
</HTML>