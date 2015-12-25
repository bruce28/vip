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



$DEB_MES=0;

$usr_ex=0;

function check_source($id)
{
    $db = connect_dbi();
    $sql ="SELECT * FROM source ";
    $result = query_selecti($db,$sql);
    while($rek = mysqli_fetch_array($result))
    {
      echo "<option value='".$rek['source_id']."'>".$rek['town_name']."</option>";               
    }
  //  return $rek['town_name'];
    
}




if(isset($_POST['submitted']))
{
    echo "Form submitted";
    $DEB_MES.="form submitted";
}



// Declaring variables as emty, to make sure form is prefilled with zero value on begining
$company_name=NULL;
$name=NULL;
$surname=NULL;
$street=NULL;
$town=NULL;

$postal_code=NULL;
$email=NULL;
$phone=NULL; 
$source=NULL;


 //if the message null or unset than echoing the notice



//Function shows records in Origin table
function show_site()
{
    
 $db=connect_dbi();

$sql_select="SELECT * FROM Origin"
        . " INNER JOIN Source ON source.source_id=Origin.Source_source_id"
        . " ORDER BY origin_id DESC";

$result=query_selecti($db,$sql_select);
while($rek=mysqli_fetch_array($result))
{
//echo "<table>";    
echo "<tr><td>";
 echo $rek["post_code"];
  echo "</td><td>";
echo $rek["company_name"];
echo "</td><td>";  
echo $rek["name"];
  //echo "sdfsdf";
echo "</td><td>";   
echo $rek["surname"];
 echo "</td><td>";
 echo $rek["street"];
  
  
 echo "</td><td>";
 echo $rek["town"];
  
  echo "</td><td>";
 
  //$postal_code = strtoupper (str_replace(' ', '', $postal_code));
  echo $rek["Source_source_id"];
  
  echo "</td><td>";
echo $rek["town_name"];
echo "</td><td>";
 echo $email=$rek['email'];
 echo "</td><td>";
 
  echo $phone=$rek['phone']; 
 
  echo "</td></tr>";
    
  
  
  
 } 
 
 mysqli_free_result($result);
 mysqli_close($db);
  
  
    
    
}


//MAIN CODE

$site_id;
$STATUS_ADD=0;

//modify section. status_add check if previous was modification
if(isset($_POST['Modify'])) {
   echo 'Modified';
   $url="site_new.php";
   
   
   $company_name=trim($_POST['comp_name']);
   $name=trim($_POST['name']);
   $surname=trim($_POST['surname']);
   $street=trim($_POST['street']);
   $town=trim($_POST['town']);
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
   $postal_code=trim($_POST['post_code']);
   $postal_code = strtoupper (str_replace(' ', '', $postal_code));
   $email=trim($_POST['email']);
   $phone=trim($_POST['phone']); 
   
   
   if(!get_magic_quotes_gpc())
{
     $company_name=addslashes($company_name);
$name=addslashes($name);
$surname=  addslashes($surname);
$street=  addslashes($street);
$town=  addslashes($town);
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
$postal_code=  addslashes($postal_code);
$postal_code = strtoupper (str_replace(' ', '', $postal_code));
$email=  addslashes($email);
$phone=  addslashes($phone); 
$source= addslashes($source);
    
    
}
   
  
  //additional source location id and town location
  $source_id=trim($_POST['source']);
  $source_name;
   
  $db=connect_dbi();

$sql_select="UPDATE Origin SET company_name='$company_name', name='$name', surname='$surname', post_code='$postal_code',
 street='$street', town='$town', email='$email', phone='$phone' Where post_code='$postal_code'";

$result=query_selecti($db,$sql_select);  
   
   if($result)
   $STATUS_ADD=2;
		//	redirect($url,0);
  // exit();
}
  


if(isset($_GET['site_add'])=='1')
{
  $company_name=trim($_POST['comp_name']);
$name=trim($_POST['name']);
$surname=trim($_POST['surname']);
$street=trim($_POST['street']);
$town=trim($_POST['town']);
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
$postal_code=trim($_POST['post_code']);
$postal_code = strtoupper (str_replace(' ', '', $postal_code));
$email=trim($_POST['email']);
$phone=trim($_POST['phone']); 
$source=trim($_POST['source']);



if(!get_magic_quotes_gpc())
{
     $company_name=addslashes($company_name);
$name=addslashes($name);
$surname=  addslashes($surname);
$street=  addslashes($street);
$town=  addslashes($town);
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
$postal_code=  addslashes($postal_code);
$postal_code = strtoupper (str_replace(' ', '', $postal_code));
$email=  addslashes($email);
$phone=  addslashes($phone); 
$source= addslashes($source);
    
    
}
   
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
   
    
}



$db=connect_dbi();

$sql_select="SELECT * FROM Origin Where post_code='$postal_code'";

$result=query_selecti($db,$sql_select);
$rek=read_rowsi($result);
 if($rek["origin_id"]) echo $rek["origin_id"];   
if($rek!=0)
{
  echo "Podany user juz istnieje";  
  $usr_ex=1;
  if($rek["origin_id"]) echo $rek["origin_id"];   
  
  $company_name=$rek['company_name'];
  $name=$rek['name'];
  $surname=$rek['surname'];
  $street=$rek['street'];
  $town=$rek['town'];
//$postal_code=val_postal_no_white_sp($_POST['post_code']);
  $postal_code=$rek['post_code'];
  $postal_code = strtoupper (str_replace(' ', '', $postal_code));
  $email=$rek['email'];
  $phone=$rek['phone']; 
  //$_SESSION['post_code']=$rek['post_code'];
   
  
  
  
  
  
}
else
{
    //Optimizing to CONSTRAINT INO DB Source_source_id 
   //$source='H101'; 
  $sql_add_site="INSERT INTO Origin(Source_source_id,company_name,name,surname,post_code,street,town,email,phone) 
  VALUES('$source','$company_name','$name','$surname','$postal_code','$street','$town','$email','$phone')"; 
  
  //if($_SESSION['post_code']==$_POST['post_code']) 
  
if(isset($company_name)AND !empty($company_name)AND
isset($name)AND !empty($name) AND
isset($surname)AND !empty($surname)AND
isset($street)AND !empty($street)AND
isset($town)AND !empty($town)
AND isset($_POST['post_code']) AND !empty($_POST['post_code'])
)
{
  $result=query_selecti($db,$sql_add_site);
  
    $flag_inserted = $result;

if ( $flag_inserted ) {

  // Success handling
  // . . .
 ///     echo "Dodano Sita";
       
    unset($company_name);
    unset($name);
   unset($surname);
   unset($street);
   unset($town);
   unset($postal_code);
   unset($email);
  unset($phone); 
    
       
    } else {

   // Error handling
   // . . .
 ///        echo "niedodano sita";
     }  
    
      unset($company_name);
      unset($name);
      unset($surname);
      unset($street);
      unset($town);
      unset($postal_code);
      unset($email);
      unset($phone); 
     
     
     
     
     
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

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>

 
?> 
<?php if(isset($STATUS_ADD)) {
    if($STATUS_ADD==2)
    {
echo "Site Place details has been changed <B>".$_POST['post_code']."</B>  ";} 

}
//show_site();
?>
<div>
<div id="form_out_site">
<form class="form" action="site_new.php?site_add=1" method="POST">  
  
   <p class="post_code">  
        <input type="text" name="post_code" id="post_code"  value="<?php if(!empty($postal_code))echo $postal_code; ?>"/>  
        <label for="post_code">Postal Code</label>  
    </p> 
  
      <p class="comp_name">  
        <input type="text" name="comp_name" id="comp_name" value="<?php if(!empty($company_name)) echo $company_name; ?>" >  
        <label for="comp_name">Company Name</label>  
    </p>  
    
    <p class="name">  
        <input type="text" name="name" id="name" value="<?php if(!empty($name)) echo $name; ?>" />  
        <label for="name">Name</label>  
    </p>  
    
    <p class="surname">  
        <input type="text" name="surname" id="surname" value="<?php if(!empty($surname)) echo $surname; ?>" />  
        <label for="surname">Surname</label>  
    </p> 
    
    <p class="email">  
        <input type="text" name="email" id="email" value="<?php if(!empty($email)) echo $email ?>" />  
        <label for="email">E-mail</label> <i>(Optional)</i>  
    </p> 
    
    
    <p class="phone">  
        <input type="text" name="phone" id="phone" value="<?php if(!empty($phone)) echo $phone ?>" />  
        <label for="phone">Phone </label>   <i>(Optional)</i>
    </p> 
    
    <p class="street">  
        <input type="text" name="street" id="street" value="<?php if(!empty($street)) echo $street; ?>" />  
        <label for="street">Street</label>  
    </p> 
    
    <p class="town">  
        <input type="text" name="town" id="town" value="<?php if(!empty($town)) echo $town; ?>" />  
        <label for="town">town</label>  
    </p> 
        
    <p class="source"> 
        <select name="source"> 
            <?php 
 check_source($id);
            ?>
        </select>
        <label for="source">Source Code</label>  
    </p> 
  
    <p>
        <input type="hidden" name="submitted" value="1" />
    </p>
    <p class="submit">  
        <input type="submit" value="Create" />
        <?php if($usr_ex==1) : ?>
        <input type="submit" name='Modify' value="Modify" /> 
        <?php endif ?>
    </p>  
  
</form>  

</div>
<div id="box_right"><table border="1" ><?php show_site();?> </table></div>



</div>
</td>
</tr>
</table>



<?php //echo $DEB_MES;
 //check_source($id);
?>
</BODY>
</HTML>