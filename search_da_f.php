<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include 'header.php';
include 'menu_header.php';
$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 

$site_id;
?>

<HTML>
<HEAD>

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">

<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />

<script type="text/javascript" src="csshorizontalmenu.js">



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


<?php show_menu(); ?>

  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>
<p> Search by Date: </p>

<h2>FORMAT: YYYY-MM-DD </h2>


<table border="1">
<tr><td>From</td><td>To</td></tr>
<tr>
<form action="search_date.php" method="POST">

<td>
<input type="text "id="" name="date_from" value="" />
</td>

<td>
<input type="text "id="" name="date_to" value="" />
</td>



<input type="hidden" name="submitted" value="1" />

<td>
<input type='submit' name='Submit' value='Search' align='right'>
</td>

</tr>
</form>
</table>

</td>
</table>

</BODY>
</HTML>