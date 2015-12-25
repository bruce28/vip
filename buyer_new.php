<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header.php';
include 'header_mysql.php';
include 'validation.php';
include 'functions.php';
include 'menu_header.php';
//include 'dbs3_config.php';

function show_site()
{
    
 connect_db();

$sql_select="SELECT * FROM Buyer  WHERE postcode NOT Like 'Blank' ORDER BY id_Buyer DESC";

$result=query_select($sql_select);
while($rek=mysql_fetch_array($result))
{
//echo "<table>";    
echo "<tr><td>";
 echo $rek["postcode"];
  echo "</td><td>";
echo $rek["company_name"];
echo "</td><td>";  
echo $rek["name"];
 // echo "sdfsdf";
echo "</td><td>";   
echo $rek["surname"];
 echo "</td><td>";
 echo $rek["address"];
  
  
 echo "</td><td>";
 echo $rek["town"];
  
  echo "</td><td>";
 
  //$postal_code = strtoupper (str_replace(' ', '', $postal_code));
 

 echo $email=$rek['email'];
 echo "</td><td>";
 
 echo $phone=$rek['phone']; 
 echo "</td><td>";
  if(empty($rek['ttl_nr']))
  echo "-";
  else
 echo $rek['ttl_nr'];
 echo "</td><td>";
    echo "</td></tr>";
  
  
  
 } 
  
  
    
    
}


$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 

$site_id;
$STATUS_ADD=0;

if(isset($_POST['Modify'])) {
   echo 'Modified';
   $url="buyer_new.php";
   
   
   $company_name=$_POST['comp_name'];
   $name=$_POST['name'];
   $surname=$_POST['surname'];
   $street=$_POST['street'];
   $town=$_POST['town'];
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
   $postal_code=$_POST['post_code'];
   $postal_code = strtoupper (str_replace(' ', '', $postal_code));
   $email=$_POST['email'];
  $phone=$_POST['phone']; 
   $ttl=$_POST['ttl'];
   
 connect_db();

$sql_select="UPDATE Buyer SET company_name='$company_name', name='$name', surname='$surname', postcode='$postal_code',
 address='$street', town='$town', email='$email', phone='$phone', ttl_nr='$ttl' Where postcode='$postal_code'";

$result=query_select($sql_select);  
   
   if($result)
   $STATUS_ADD=2;
		//	redirect($url,0);
  // exit();
}
  


if($_GET['site_add']=='1')
{
  $company_name=$_POST['comp_name'];
$name=$_POST['name'];
$surname=$_POST['surname'];
$street=$_POST['street'];
$town=$_POST['town'];
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
$postal_code=$_POST['post_code'];
$postal_code = strtoupper (str_replace(' ', '', $postal_code));
$email=$_POST['email'];
$phone=$_POST['phone']; 
$ttl=$_POST['ttl'];   
 ///  echo "inside add site"; echo $postal_code;


if($STATUS_ADD==2)
{
    
    unset($company_name);
    unset($name);
   unset($surname);
   unset($street);
   unset($town);
   unset($postal_code);
   unset($email);
  unset($phone); 
  unset($ttl);
   
    
}



connect_db();

$sql_select="SELECT * FROM Buyer Where postcode='$postal_code'";

$result=query_select($sql_select);
$rek=read_rows($result);
 if($rek["id_Buyer"]) echo $rek["id_Buyer"];   
if($rek!=0)
{
  echo "Podany kupiec juz istnieje";    
  if($rek["id_Buyer"]) echo $rek["id_Buyer"];   
  
  $company_name=$rek['company_name'];
  $name=$rek['name'];
  $surname=$rek['surname'];
  $street=$rek['address'];
  $town=$rek['town'];
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
  $postal_code=$rek['postcode'];
  $postal_code = strtoupper (str_replace(' ', '', $postal_code));
  $email=$rek['email'];
  $phone=$rek['phone'];
  $ttl=$rek['ttl_nr']; 
  //$_SESSION['post_code']=$rek['post_code'];
   
  
  
  
  
  
}
else
{
  $sql_add_site="INSERT INTO Buyer(company_name,name,surname,postcode,address,town,email,phone,ttl_nr) 
  VALUES('$company_name','$name','$surname','$postal_code','$street','$town','$email','$phone','$ttl')"; 
  
  //if($_SESSION['post_code']==$_POST['post_code']) 
  
   if(isset($company_name)AND !empty($company_name)AND
isset($name)AND !empty($name) AND
isset($surname)AND !empty($surname)AND
isset($street)AND !empty($street)AND
isset($town)AND !empty($town)
AND isset($_POST['post_code']) AND !empty($_POST['post_code'])
)
{
  $result=query_select($sql_add_site);
  
    $flag_inserted =$result;

if ( $flag_inserted ) {

  // Success handling
  // . . .
  ///    echo "Dodano Sita";
       
         unset($company_name);
    unset($name);
   unset($surname);
   unset($street);
   unset($town);
   unset($postal_code);
   unset($email);
  unset($phone); 
  unset($ttl);
  
    
       
    } else {

   // Error handling
   // . . .
 ///        echo "niedodano sita";
     }  
    
     }

   
    
}    
}

///echo "poza add site";
?>

<HTML>
<HEAD>

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css" />

<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />

<script type="text/javascript" src="csshorizontalmenu.js" > 



</script>
<link href="form.css" rel="stylesheet" type="text/css" />

</HEAD>
<BODY>

<table border=1 width=100% height=800 bgcolor="F8F8F8" >
<tr>
<td colspan=2 width=100% height=5% align=right> 

<table id="login" border="0" cellpadding="1" cellspacing="3" >
<tr><td>
<?php
//F8F8F8  F0F0F0 #E0E0E0
if(empty($l_klient))
{
$log='<form action="log_pro.php" method="post" align="right">
<td align="right">Login</td><td><input type="text" name="login"></td>
<td align="right">Password</td><td><input type="password" name="pass"></td>
<tr>
<td></td><td></td><td></td><td><input type="submit" name="Submit" value="Log In" align="right"> </td>
</tr>
</form>';
echo $log;
}
else
echo "You are Logged In as ".$l_klient;

?>
</td></tr>
</table>

</td></tr>

<tr bgcolor="#E5E5E5" >
<td colspan=2 width=100% height=15% align=center valign=center> GRR Database System 2
</td>
</tr>
<tr>
<td colspan=2 width=100% height=25px align=right bgcolor="#E0E0E0"> 


<?php show_menu(); ?>


  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>
</BR>
<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php if(isset($STATUS_ADD)AND $STATUS_ADD==2) {
echo "Site Place details has been changed <B>".$_POST['post_code']."</B>  ";} 

//show_site();
?>
<div>
<div id="form_out_site">
<form class="form" action="buyer_new.php?site_add=1" method="POST">  
  
   <p class="post_code">  
        <input type="text" name="post_code" id="post_code"  value="<?php echo $postal_code; ?>"/>  
        <label for="post_code">Postal Code</label>  
    </p> 
  
  
      <p class="comp_name">  
        <input type="text" name="comp_name" id="comp_name" value="<?php echo $company_name; ?>" />  
        <label for="comp_name">Company Name</label>  
    </p>  
    
    <p class="name">  
        <input type="text" name="name" id="name" value="<?php echo $name; ?>" />  
        <label for="name">Name</label>  
    </p>  
    
    <p class="surname">  
        <input type="text" name="surname" id="surname" value="<?php echo $surname; ?>" />  
        <label for="surname">Surname</label>  
    </p> 
    
    <p class="email">  
        <input type="text" name="email" id="email" value="<?php echo $email ?>" />  
        <label for="email">E-mail</label> <i>(Optional)</i>  
    </p> 
    
    
    <p class="phone">  
        <input type="text" name="phone" id="phone" value="<?php echo $phone ?>" />  
        <label for="phone">Phone </label>   <i>(Optional)</i>
    </p> 
    
    <p class="street">  
        <input type="text" name="street" id="street" value="<?php echo $street; ?>" />  
        <label for="street">Street</label>  
    </p> 
    
    <p class="town">  
        <input type="text" name="town" id="town" value="<?php echo $town; ?>" />  
        <label for="town">Town</label>  
    </p> 
        
     <p class="ttl">  
        <input type="text" name="ttl" id="ttl" value="<?php echo $ttl; ?>" />  
        <label for="ttl">T11 Number</label>  
    </p> 
  
  
    <p class="submit">  
        <input type="submit" value="Create" /> 
        <input type="submit" name='Modify' value="Modify" /> 
    </p>  
  
</form>  

</div>
<div id="box_right"><table border="1" 
><?php show_site();?> </table></div>



</div>
</td>
</tr>
</table>




</BODY>
</HTML>
