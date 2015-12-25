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
include 'menu_header.php'; 
include 'header_mysql.php';
include 'functions_group_barcode.php';
$site_id;
if(isset($_SESSION['meter']))
unset($_SESSION['meter']);


?>

<HTML>
<HEAD>
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">

<!--

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css" />
-->


<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="csshorizontalmenu.js" > 




</script>
<script type="text/javascript" src="jquery-1.10.2.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>


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

<?php show_menu(); ?>


  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>

<?php

 connect_db();

 //HERE we receive 
 
 $list=$_POST['group_list']; 
 
 

    
?>
    
  <?php
  
  if(isset($_POST['submit'])AND !empty($_POST['group_sticker']) AND !empty($_POST['group_list'])AND !empty($_POST['group_description']))
  {
      echo "checking data";
      $barcode=$_POST['group_sticker'];
      if(detect_group_barcode($barcode, $PREFIX_GROUP_STICKER)==1) //if is valid format of grp
         if(check_group_barcode($barcode)!=1)
//if is there 
         {
      echo "Prepering initialisation";
      $group=initialize_group_barcode();
         }
         
         echo "UPDATE DESCRITION";
         $description=$_POST['group_description'];
         $update="UPDATE group_barcode SET reserved='$description' WHERE group_barcode='$barcode'";
         query_select($update);
  }
  else
      echo "Please set group barcode";
  
  if(!empty($_POST['group_list'])AND !empty($_POST['group_sticker']) AND !empty($_POST['group_list'])AND !empty($_POST['group_description'])AND !empty($group))
  {
      $barcode=$_POST['group_sticker'];
       if(detect_group_barcode($barcode, $PREFIX_GROUP_STICKER)==1) //if is valid format of grp
       {
     echo "initialising"; 
      //$barcode="2";
      
      for($i=0;$i<sizeof($barcode=get_list($list));$i++)
      {
          echo $i;
          $barcode2=if_valid_barcode($barcode[$i]); //only if a barcode else dont put
           if($barcode2!=1)
                  set_individual_barcode($barcode2, $group); 
      }
      }
  }
  else
      echo "Please specify fields";
      echo '</BR> Processed list: ';
  //echo $list=get_list($list);
 
  ?>
    

<table border="2" >
    <tr><td>
    <form ACTION="group_sticker.php" METHOD="POST">
        <input type="text" size="256" name="group_list" placeholder="List of separate barcodes....">
        <input type="text" name="group_sticker" placeholder="Group barcode...">
          <input type="text" name="group_description" placeholder="Group Description...">
        <input type="Submit" name="submit" value="Add group barcode">
        
        
        
                
    </form>
        </td></tr>    
</table>
    
    
    
    
</td>
</table>




</BODY>
</HTML>