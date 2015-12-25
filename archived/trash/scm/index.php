<?php
session_start();
include '../header_valid.php';
$l_klient=$_SESSION['l_klient'];
//echo $l_klient;
$id_user=$_SESSION['id_user'];
include '../header.php';
include 'manifest_config.php';
include 'db_config.php';

$site_id;
 

mysql_connect($serwer, $login, $haslo);
mysql_select_db($baza);

?>
<HTML>
<HEAD>

<link href="design.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="design.css" type="text/css">

<link rel="stylesheet" href="../layout.css " type="text/css">
<link rel="stylesheet" href="../form_cat.css " type="text/css">

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





  </td>
</tr>
<tr>
<td colspan=2 width=100% height=90% align=left valign=top>

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>


 <table border="2"><tr>
<td>
<h2> GRR Database System 2: </h2>
</td>
</tr>
<tr><td>
<H4>Visit Site Code: </H4> 

<?php



        
if(!empty($_POST['location']))
$loca=trim($_POST['location']);
echo $loca;

   
   if(!empty($loca)){ 
    $flag_s=0;
    $wynik1 = mysql_query("SELECT * FROM Origin WHERE post_code='$loca'");
         
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
        echo '</BR>';
          
         $flag_s=1;
   	  echo "<a href='site.php'> (Change Location) </a>";
            
            }
            
            if($flag_s!=1)
            {
                echo "Not Specified"; 
	         	echo "<a href='site.php'> (SPECIFY) </a>";
             }  
           
    
  /**
 *  $wynik = mysql_query("INSERT INTO Site(Origin_origin_id,site_ref_number,Rep_Auth,Dest_Location,batch_date,batch_id) VALUES($origin,'','14','7932',now(),'')")
 *    or die("Blad w zapytaniu!"); 
 */
   }
   else {
    echo "Not Specified"; 
		echo "<a href='site.php'> (SPECIFY) </a>";
   
	 }
    
         if(!empty($origin))
         {
             
         
         $site_id=$origin;
         echo $site_id;
         }
         

  //else echo "Nie moge polaczyc sie z baza danych!"; 


?>

</td></tr><tr><td>

<?php 


//we take manifest fields from sub_categories set up   
    $wynik = mysql_query("SELECT * FROM Sub_cat INNER JOIN Category ON Category.id = Sub_cat.Category_id INNER JOIN Weight ON Weight.id = Sub_cat.Weight_id WHERE sub_cat.kind=2 ORDER BY name_sub ASC ") 
        or die(mysql_error()); 
         
     
    
    
    
    if(isset($_POST['date_op']) AND !empty($_POST['date_op']))
    {
        $date1=$_POST['date_op'];
    }
    else
    {
       //$date1 = date('m/d/Y h:i:s a', time());
       $date1= date('y/m/d');
        
    }
    echo $date1;
   
    echo "<table border='1'><tr><th>Subcategory</th><th>Quantity Recv.</th></tr>";

   
    echo "<form action='report.php' method='post'><tr>";




    $in=0;
    $i=0;
    while($rek = mysql_fetch_array($wynik,1)) { 
        $in++;
        $i++;
        echo "<td>".$rek["Name_sub"]." (".$rek['weight']." kg)</td><td><input type='text' name='quantity".$in."'></td>";  //quantity id, how many picked up
        
        echo '<input type="hidden" name="id'.$in.'" value="'.htmlentities($rek["id_c"]).'">'; //number of sub category unique
        echo '<input type="hidden" name="weight'.$in.'" value="'.htmlentities($rek["weight"]).'">';  //weight of subcategory
	echo '<input type="hidden" name="cat_id'.$in.'" value="'.htmlentities($rek["Category_id"]).'">'; //category
        echo '<input type="hidden" name="date1" value="'.htmlentities($date1).'">';  //date manifest rised
         if($i%$num_columns==0)
          echo "</tr><tr>"; 
    } 
     
     echo '<input type="hidden" name="in" value="'.htmlentities($in+1).'">';
     echo '<input type="hidden" name="submitted" value="1">';
 if(isset($site_id))    echo '<input type="hidden" name="site_id" value="'.htmlentities($site_id).'">';
   if(isset($site_id)) echo "<tr><td></td><td></td><td><input type='submit' name='Submit' value='Confirm' align='right'> </td>";
  
   echo "</form>";
    echo "</table>";

    mysql_close(); 

?> 
<a href="../index.php"><button> Return</button></a>
</td></tr>

</td>
</tr>
</table>



</td>

</table>




</BODY>
</HTML>