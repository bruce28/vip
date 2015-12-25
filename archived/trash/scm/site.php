<?php
session_start();
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
include '../header_valid.php';
include '../header_mysql.php';
include 'manifest_config.php';
include 'db_config.php';

$post_codes=array();



//connection to database
mysql_connect($serwer, $login, $haslo) or die(mysql_error()); 
mysql_select_db($baza); 


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



?>

<HTML>
<HEAD>


</HEAD>
<BODY bgcolor="#C0C0C0" >
<table border=1 width=800 height=800 style="alignment-adjust: central">
<tr>
<td colspan=2 width=100% height=5% align=right> 

<table border="0" cellpadding="1" cellspacing="3" bgcolor="#C0C0C0">

<?php

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

<a href="rej.php"></a></td></tr>

<tr bgcolor="grey">
<td colspan=2 width=100% height=15% align=center valign=center> GRR Database System 2
</td>
</tr>
<tr>
<td colspan=2 width=100% height=25px align=right bgcolor="grey">   </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>


<h2> GRR Database System 2: </h2>
<BR>
<H3>Visit Site Code: </H3>

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
     
echo '<tr><td>Date of Collection  </td><td><input placeholder="YYYY-MM-DD" type="text" name="date_op">(Optional)</td></tr>';

     
    
    echo "<tr><td colspan='3'></td><td><input type='submit' name='Submit' value='Confirm' align='right'> </td></tr>";
    echo "</form>";
    echo "</table>";


?> 



</td>
</tr>
</table>





</BODY>
</HTML>