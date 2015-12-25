<?php
session_start();
include '../header_valid.php';
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include '../header.php';
include 'manifest_config.php';
include 'db_config.php';
include '../header_valid.php';
include '../header_mysql.php';

//unset($_SESSION['restore_site_id']);
mysql_connect('127.0.0.1','root','krasnal');
mysql_select_db('dbs3');
$site_id;
function get_start_dbs($id)
{
    $SELECT="SELECT * FROM manifest_reg WHERE idmanifest_reg='$id'";
    $result=mysql_query($SELECT) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['start_dbs'];
}

function num_select()
{
    $sql="SELECT * From origin";
    $result=mysql_query($sql) or die(mysql_error());
    $num=mysql_num_rows($result);
    global $post_codes;
    $i=0;
    while($rek=mysql_fetch_array($result,MYSQL_BOTH))
    {
        
        
       $post_codes[$i]=$rek['post_code'];  
      // echo $rek['post_code'];
       $i++;
    }
   
    
    
    return $num;
}

mysql_connect($serwer, $login, $haslo);
mysql_select_db($baza);


if(isset($_POST['Unregister']))
{
    if(isset($_SESSION['l_klient']))
    {
        session_unset();
    }
  

}

if(isset($_POST['register']))
{
    if(isset($_SESSION['l_klient']))
    {
        echo "zalogowany";
    }
    
    else{
    echo "Hejo";


//definicja funkcji kt�ra przekierowywuje na inn� stron�

//session_unset();

$url="index.php";

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


mysql_connect('localhost', 'root', 'krasnal');
mysql_select_db('dbs3');


   if(!empty($_POST['login']) && !empty($_POST['pass'])){
   
   $sql = mysql_query('SELECT * FROM user_2 WHERE login = "'.$_POST['login'].'"');
   $ile = mysql_num_rows($sql).'<br>';
   
   
   if($ile == 0){
      echo 'Incorrect login<br>';
      redirect($url,3);
   }
   
   $result = mysql_fetch_array($sql);
   
   $password=$result['pass'];
   
   if(($_POST['login'] == $result['login']) && ($password == $result['pass'])){
			echo 'Please wait...Loading System in Progress...';
			$_SESSION['logged']=1;
                        //here we add sesion status logged. user
            $_SESSION['priv']=$result['priv'];
			$_SESSION['l_klient']=$_POST['login'];
            $_SESSION['name1']=$result['name'];
                        $_SESSION['id_user']=$result['id_user'];
			$url="index.php";
                         $message="Driver registered successfuly. Welcome ";
                         $message.=$_SESSION['name1'];
			//redirect($url,0);
                 
   }else {
      echo 'Wrong Data!';
      $message="Sorry wrong data";
      //redirect($url,2);
     
   }
   
   }else{
      echo 'Given Data not sufficient!';
      $message="Sorry wrong data";
      //redirect($url,2);
   }
   


   
    }
}
?>
<!doctype html>
<HTML>
<HEAD>


     <title>GRR Site Collection System</title>
     <meta name="viewport" content="width=device-width">
     <meta name="mobile-web-app-capable" content="yes">
     <link rel="shortcut icon" sizes="196x196" href="/icon.png">
  
<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

<link rel="stylesheet" type="text/css" href="../csshorizontalmenu.css" />

<script type="text/javascript" src="../csshorizontalmenu.js">



</script>


</HEAD>
<BODY >

<table border=1 width=100% height=800 bgcolor="F8F8F8" >
<tr>
<td colspan=2 width=100% height=5% align=right> 

<table border="0" cellpadding="1" cellspacing="3" bgcolor="#F8F8F8">

<?php
//F8F8F8  F0F0F0 #E0E0E0
/*
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
*/
?>
</table>

</td></tr>

<tr bgcolor="#E0E0E0">
<td colspan=2 width=100% height=15% align=center valign=center> GRR Database System 2
</td>
</tr>
<tr>
<td colspan=2 width=100% height=25px align=right bgcolor="#E0E0E0"> 





  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p> mysql_connect('localhost', 'root', 'krasnal');
 
mysql_select_db('dbs3');?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>


 <table  border="2" id="form_stock"><tr>
<td>
<h2> GRR Van Registration module: </h2>
</td>
</tr>
<tr><td>
<H4>Your's details: </H4> 

<?php if(isset($_SESSION['l_klient']))
{
    $grr_mem=$_SESSION['l_klient'];
   $wynik1 = mysql_query("SELECT * FROM user_2 WHERE login='$grr_mem'");
         
         while($rek1=mysql_fetch_array($wynik1)){
            $origin=$rek1["login"];
            $comp_name=$rek1['name'];
            $post=$rek1['surname_user'];
          //  $name=$rek1['priv'];
           // $surname=$rek1['surname'];
         //   $town=$rek1['town'];
            
            echo $rek["site_id"];
        echo '</BR>';
        echo $comp_name;
     //   echo '</BR>';
       // echo $name;
      //  echo '</BR>';
        //echo $surname;
        echo '</BR>';
        echo $post;
        echo '</BR>';
        echo $town;
        echo '</BR>';
          
}}   
    ?>

<?php if(!isset($_SESSION['l_klient'])) : ?>
 <style>
#ramka {width:252; height:97; background-color:red}
#login {width:250; height:95; background-color:lightblue}
</style>

 <link href="/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="lo.css" rel="stylesheet">



<body topmargin=1>
<hr>
<BR />
<BR />
<BR />
<BR />

<?php //include 'header_login.php'?>
  <div class="container">
      <form class="form-signin" name="log" method="post" action="index.php">
        <h2 class="form-signin-heading">Please. Register a Vehicle.</h2>
        <input type="text" name="pass" class="form-control" placeholder="Registration.." autofocus>
        <input type="text" name="login" class="form-control" placeholder="Driver">
      
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button>
      </form>

    <!-- /container -->




 </div>
   
  <?php endif ?>
<?php if(isset($_SESSION['l_klient']) AND !isset($_POST['Submit'])) : ?>
<p>
   <h2> Please specify GRR site place: </h2> 
</p>
<BR />

<p>
    <?php
    $date1 = date('m/d/Y h:i:s a', time());
    echo $date1;
   
    echo "<table border='1'>";

   
    echo "<form action='index.php' method='post'>";


    // echo '<tr><td>Location</td><td><input placeholder="Post Code" type="text" name="location"></td></tr>';
     echo '<tr><td>Location</td><td>';
     echo '<select name="location">';
    // global $post_codes;
     
for($i=0;$i<num_select();$i++)
{

  echo '<option value="'.$post_codes[$i].'">'.$post_codes[$i].'</option>';  
   //echo $post_codes;
}
echo '</select>';
echo '</td></tr>';
     
//echo '<tr><td>Date of Collection  </td><td><input placeholder="YYYY-MM-DD" type="text" name="date_op">(Optional)</td></tr>';

     
    
    echo "<tr><td colspan='3'></td><td><input type='submit' name='Submit' value='Confirm' align='right'> </td></tr>";
    echo "</form>";
    echo "</table>";


?> 

</p>


<BR />
<p>If you done any mistakes, please unregister a van now</p><BR /><p>
   <form action="index.php" method="POST"> 
   <input type="submit" name="Unregister" value="Unregister Van">    
   </form></p>
    <?php endif ?>

   
<?php if(isset($_SESSION['l_klient']) AND isset($_POST['Submit'])) : ?>
<p>
   <h2>  GRR site place has been specified: </h2> 
</p><BR />

<p>
   You are at:
   <?php
   $loca=$_POST['location'];
   $wynik1 = mysql_query("SELECT * FROM origin WHERE post_code='$loca'");
         
         while($rek1=mysql_fetch_array($wynik1)){
            $origin=$rek1["origin_id"];
            $comp_name=$rek1['company_name'];
            $post=$rek1['post_code'];
            $name=$rek1['name'];
            $surname=$rek1['surname'];
            $town=$rek1['town'];
            
            echo $rek["site_id"];
        echo '</BR>';
        echo $comp_name;
        echo '</BR>';
        echo $name;
        echo '</BR>';
        echo $surname;
        echo '</BR>';
        echo $post;
        echo '</BR>';
        echo $town;
        echo '</BR><BR />';
          
         $flag_s=1;
   	  echo "<a href='site.php'> (Change Location) </a>";
            
            }
            
            if($flag_s!=1)
            {
                echo "Not Specified"; 
	         	echo "<a href='site.php'> (SPECIFY) </a>";
             }  
           
    ?>
</p>


<p>
    <?php
    //validating barcose start dbs sticker
    if(isset($_POST['Submit']))
    if(isset($_POST['sticker_start']))
    {
        if(isset($_POST['sticker_start']))
        {
           $size_def=strlen($barcode_string="dbs/000000/1");
           $size_in=strlen($_POST['sticker_start']);
           if($size_def==$size_in)
           {
           echo "Sticker range set in session ".$_SESSION['start_dbs_barcode']=$_POST['sticker_start'];
           }
           
         }
    }
    
    if(!isset($_SESSION['start_dbs_barcode']))
    {
         echo "<h3>Please specify Manifest Identification stickers starting range</h3>
     <BR />
      
  
     <BR />";

     echo "<table style='WIDTH:300px'><tr><td width='20%'><form action='index.php' method='POST'>";
     echo "<input  type='text' name='sticker_start' placeholder='DBS/...'></td>";
     //echo '<input type="hidden" name="confirmation_manifest" value="1">';
   // echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
   // echo "<input type='hidden' name='location' value='".$loca."' > ";
     echo "<input type='hidden' name='location' value='".$loca."' > ";
     echo "<td width='20%'><input type='submit' name='Submit' value='SET' align='right'> </td>";
  for($i=0;$i<$_POST['in'];$i++)
    {
        $in=$_POST['in'];
    echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
    $quant="quantity".$i;
   // echo $quant;
    $quant=$_POST[$quant];
    //echo $i;
    //echo $quant;
    $quant=select_sub_cat($i, $id_manif_count);
   // echo $quant;
    //echo "<input type='hidden' name='quantity".$i."' value='".$quant."'>";
    }
   echo "</form></tr></table>";
    }
    
    if(isset($_SESSION['start_dbs_barcode']))
    {    
    echo "<table border='1'>";

   
    echo "<form action='index2.php' method='post'>";


    // echo '<tr><td>Location</td><td><input placeholder="Post Code" type="text" name="location"></td></tr>';
     echo '<tr><td> Grr Memeber is: '.$_SESSION['l_klient'].' You are at: '.$loca.' The Car number is assigned to you for this collection. If everything is fine you can rise the manifest.But please double check before proceeding</td>';
     

     
//echo '<tr><td>Date of Collection  </td><td><input placeholder="YYYY-MM-DD" type="text" name="date_op">(Optional)</td></tr>';

     echo "<input type='hidden' name='location' value='".$loca."' > ";
    
    echo "<td colspan='3'></td><td><input type='submit' name='Submit' value='Proceed' align='right'> </td></tr>";
    echo "</form>";
    echo "</table>";

    }
 
?> 

</p>


<BR />
<p>If you done any mistakes, please unregister a van now</p><BR /><p>
   <form action="index.php" method="POST"> 
   <input type="submit" name="Unregister" value="Unregister Van">    
   </form></p>
    <?php endif ?>
      
   
   

</td></tr><tr><td>

    <?php    echo $message;
        
        ?>
        

<!--<a href="../index.php"><h3><button> Return</button></h3></a>-->
</td></tr>

</td>
</tr>
</table>



</td>

</table>




</BODY>
</HTML>