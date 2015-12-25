<?php
session_start();
include 'header.php';
include 'header_mysql.php';
include 'menu_header.php';

$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];

$serwer = "localhost";  
$login  = "root";  
$haslo  = "krasnal";  
$baza   = "dbs3";  
$tabela = "Sub_cat"; 

$site_id;

connect_db();
$query="SELECT * From User_2";
$result=query_select($query);

$users=array();
$names=array();

$i=0;
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $users[$i]=$rek["id_user"];    
     $names[$i]=$rek["name"];  
    // echo $users[$i].$names[$i];
   }


//<input type="text "id="" name="user" value="" />

?>

<HTML>
<HEAD>

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">

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
<td colspan=2 width=100% height=90% align=left valign=top >


<h2>FORMAT: YYYY-MM-DD </h2>


<h3><p></p></h3>

<table border="1" style="width: auto;">
<tr><td>From *</td><td>To *</td></tr>
<tr>
<form action="search_date_adv.php" method="POST">

<td>
<input type="text "id="" name="date_from" value="<?php echo date("Y-m-d"); ?>" />
</td>

<td>
<input type="text "id="" name="date_to" value="<?php echo date("Y-m-d"); ?>" />
</td>
</tr>

<tr>
<tr><td colspan="2" bgcolor="grey"></td></tr></br></br>
<tr><td>Repairs Number (SUM)</td><td></td></tr>
<td>
<input type="text "id="" name="repairs" value="" />

</td>
<td>
<select name="wage" size="1">
<option>=</option>
<option> > </option>
<option> < </option>
</select>
</td>

<tr>
<tr><td colspan="2" bgcolor="grey"></td></tr></br></br>
<tr><td>Tester (User)</td><td></td></tr>
<td>
<?php


echo '<select name="user" size="1">';

for($z=0;$z<=$i;$z++)
{
  echo '<option value="'.$z.'">'.$names[$z].'</option>';

}
echo '</select>';
?>
</td>
<td>

</td>



</tr>

</tr>
<tr><td colspan="2" bgcolor="grey"></td></tr></br></br>
<tr><td>Item Type (eg. DVD)</td><td></td></tr>
<tr>
<td>
<input type="text "id="" name="item" value="" />
</td>

<td>  </td>
</tr>
<input type="hidden" name="submitted" value="1" />

<td>
<input type='submit' name='Submit' value='Search' align='right'>
</td>

</tr>
</form>
</table>
</BR></BR>
<p>(*) Field Required</p>

</td>
</table>

</BODY>
</HTML>