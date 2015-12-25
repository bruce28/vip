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
//include 'tablet/second_lvl_api.php';
include 'functions_api.php';
include 'functions_new_weights.php';
$site_id;
if(isset($_SESSION['meter']))
unset($_SESSION['meter']);

/*
function get_site_has_cat_weight($site_id,$sub_cat)
{
     $sql="SELECT * FROM site_has_cat WHERE Site_site_id='$site_id'";
    $result=query_select($sql);
    
    
    while($rek=mysql_fetch_array($result,MYSQL_BOTH))
    {
       $sum_weight+=$rek['Quantity']*get_weight($rek['Sub_cat_id_c']); //this takes quantity stored in site_has_cat and recalculates it it takes new weight through new module of calculation
        //including standard weight and non standard
    }
    return $sum_weight;
}*/

?>

<HTML>
<HEAD>
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="layout.css " type="text/css" />
<link rel="stylesheet" href="form1.css " type="text/css" />
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

<?php // <p>Welcome in the System:  echo $_SESSION['name1']; </p>
//LETS ADD PROCESSING FUNCTION HERE

connect_db();
$query="SELECT * From Origin ";
//this can be twofold, both distinct inner join or every site place distinctivel from origin tabel
//INNER JOIN Site ON Origin.origin_id=Site.Origin_origin_id

$result=query_select($query);

$users=array();
$names=array();
$batch_date=array();

$i=0;
while($rek = mysql_fetch_array($result,1))  
   {
     $i++; 
     $users[$i]=$rek["post_code"];    
     $names[$i]=$rek["town"];
     $origin[$i]=$rek["origin_id"];
     //$batch_date[$i]=$rek["batch_date"];  
    // echo $users[$i].$names[$i];
   }


?> 
<?php if(isset($_GET['test'])) {
echo "Item with Barcode <B>".$_GET['test']."</B> added to the System ";} ?>

    <center><h4>Collection Sheet Report Management</h4></center>
    
    </BR>
    </BR>
    </BR>
   
    <div style="margin: 10px;">
    <form action="manifest_rep.php" method="POST" >
      <p><select name="site" size="1">
 <?php
    for($z=0;$z<=$i;$z++)
    {
        echo '<option value="'.$origin[$z].'">'.$names[$z].'</option>';

    }
        echo '</select></span>';
        
      ?>                
        <label for="site" >Collection Place</label>              
                      </p>
                      <p><input type="text" name="date" value="" placeholder="YYYY-MM-DD"><label for="date">Day of collection</date></p>
                      <input type="submit" name="Generate" value="Generate" style="
             background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #EEEEEE), to(#FFFFFF));  
    background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE 1px, #FFFFFF 25px);  
    box-shadow: rgba(0,0,0, 0.1) 0px 0px 2px;  
    -moz-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;  
    -webkit-box-shadow: rgba(0,0,0, 0.01) 0px 0px 2px;   
    
    border-collapse:collapse;  
             
             ">
                      <input type="checkbox" name="print_out" value="yes" <?php if(isset($_POST['print_out'])) echo 'checked=""'; ?>  >Only Never print out before<br>
    </form>
        <style>
          label{
          margin-left: 10px;   
          color: #999999;
          font: normal 13px/100% Verdana, Tahoma, sans-serif;
            }
           </style>
    </div>
    
    
    
    
    <?php
    if(isset($_POST['Generate']))
    {
        
        echo '<p style="margin-left: 10px;">';
        echo "<BR />";
        // Searching ond output results module
        
        if(empty($_POST['date'])AND empty($_POST['site']))
        {    
        $select_list="SELECT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id
           GROUP BY town, batch_date,site_id ORDER BY batch_date DESC;
         ";
        }
        else if(!empty($_POST['date'])) 
        {
            $dd_s=$_POST['date'];
           $select_list="SELECT DISTINCT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id WHERE batch_date='$dd_s'
           GROUP BY town, batch_date,site_id ORDER BY batch_date DESC; 
         ";            //here change
            
        }
        else if(!empty($_POST['site']))
        {
           $dd_t=$_POST['site']; 
          $select_list="SELECT DISTINCT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id WHERE origin_id='$dd_t'
           GROUP BY town, batch_date,site_id ORDER BY batch_date DESC;
         ";              //here change
            
        }
        if(!empty($_POST['date'])AND !empty($_POST['site']))
        {
           $dd_t=$_POST['site']; 
            $dd_s=$_POST['date'];
      $select_list="SELECT DISTINCT town,batch_date,site_ref_number,site_id,source_id, SUM(sum_weight) as sum FROM site
           INNER JOIN Origin ON site.Origin_origin_id=origin.origin_id
           INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id 
           INNER JOIN source ON source.source_id=origin.Source_source_id WHERE origin_id='$dd_t' AND batch_date='$dd_s' 
           GROUP BY town,batch_date,site_id ORDER BY batch_date DESC;
         "; //change here
        }
        $result_list=mysql_query($select_list)or die(mysql_error());
        $num_list_row= mysql_num_rows($result_list);
        for($i=0;$i<$num_list_row;$i++)
        {
            
         
    $rek_list=mysql_fetch_array($result_list);
        //echo "<form action='manifest_rep_print.php' method='POST'";   
        echo "<table><tr><td>".($i+1).".</td><td>Reports for: <b>";
        echo $rek_list['town'];
        echo "</b></td><td>on <b>";
        echo $rek_list['batch_date'];
        echo "</b></td><td> specified by site number: <b>";
        echo $rek_list['site_ref_number'];
        echo "</b></td><td> Total weight collected: <b>";
        //print(intval($rek_list['sum']));
        //get round insrted
          //print(round($rek_list['sum'],1));
            //if($rek_list['sum']==0)
            //{
           // echo "Rec";
            $site_id=$rek_list['site_id'];
            $sub_cat=0;
           $site_date_collection=$rek_list['batch_date'];
          echo  get_site_has_cat_weight($site_id, $sub_cat);
            //if NULL take site id and result weight than sum it
            
            //NEW CALCULATIONS
           // }
            echo "KG</b></td></tr>";
        echo "<tr></tr><tr></tr><tr></BR><td colspan='4'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='manifest_rep_print.php' method='POST'>";
        
        $source=  str_replace("H", "", $rek_list['source_id']);
        $date_r=$rek_list['batch_date'];
        $site_ref_num=$rek_list['site_ref_number'];
        $site_id=$rek_list['site_id'];        
//echo "ssd";
        echo "<input type='hidden' name='site_id' value='".$site_id."'>";
        echo "<input type='hidden' name='site_ref_number' value='".$site_ref_num."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
       // echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        
        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='4'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='manifest_rep_print.php' method='POST'>";
        
        $source=  str_replace("H", "", $rek_list['source_id']);
        $date_r=$rek_list['batch_date'];
        $site_ref_num=$rek_list['site_ref_number'];
        $site_id=$rek_list['site_id']; 
        //echo $site_id;
//echo "ssd";
        echo "<input type='hidden' name='site_id' value='".$site_id."'>";
        echo "<input type='hidden' name='site_ref_number' value='".$site_ref_num."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        echo "<input type='Submit' name='tv_cat' value='Collection Sheet'>";
        
        echo "</form></td></tr>";
        
        
        echo "</table>";
        }
        echo " </p>";
    }
    
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td>
</table>




</BODY>
</HTML>