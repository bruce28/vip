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
include 'config_six.php';
$site_id;
if(isset($_SESSION['meter']))
unset($_SESSION['meter']);
$state_ind=0;

?>







<HTML>
<HEAD>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" media="screen">


<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">


<link rel="stylesheet" type="text/css" href="csshorizontalmenu.css" />

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

    <center><h4>Barcode Origins </h4></center>
    
    </BR>
    </BR>
    </BR>
   
    <div style="margin: 10px;">
    
    
 <?php
 $search=$_POST['search'];
 echo '<form action="barcode_show_det.php" method="POST">';
 echo '<input name="search" value="'.$search.'">';
 echo '<input type="submit" name="Submit" value="Search">';
 echo "</form>";
 
              ?>
                  
        <style>
          label{
          margin-left: 10px;   
          color: #999999;
          font: normal 13px/100% Verdana, Tahoma, sans-serif;
            }
           </style>
    </div>
    
    
    
    
    <?php
    if(isset($_POST['Submit']))
    {
        $search=$_POST['search'];
        $show_barcode='SELECT * FROM Item'
         . ' INNER JOIN Barcode ON Barcode.Item_id_item=Item.id_item'
        . ' INNER JOIN Site ON Site.site_id = Barcode.Site_site_id'
        . ' INNER JOIN Item_has_Cat ON Item_has_Cat.id_item_cat=Item.Item_has_Cat_id_item_cat'
        .' INNER JOIN Test ON Barcode.id_Barcode=Test.Barcode_id_Barcode'
                .' INNER JOIN Origin On Origin.origin_id= Site.Origin_origin_id'
                .' INNER JOIN Source ON Origin.Source_source_id=Source.source_id'
        . "  WHERE Barcode.Barcode='$search'";
        
$result=mysql_query($show_barcode)or die(mysql_error());
        
        while($rek_list=mysql_fetch_array($result, MYSQL_BOTH))
        {
          //echo "</br>";  
         //echo $i;
        $i++;
       // echo $rek_list[0];
        
        //echo "<form action='manifest_rep_print.php' method='POST'";   
        
    
    echo "<table><tr><td> Unique barcode: <b>";
        echo $rek_list[8]." ";
        echo "</b></td><td> Item type: <b>".$rek_list[4]."</b></td><b>";
        
        echo "</b></td><td> Brand: <b>";
        echo $rek_list[3];
        echo "</td><td> Model: <b>";
        echo $rek_list[2];
        echo "</b></td>";
        //print(intval($rek_list['sum']));
       //echo $rek_list[40];
        echo "</b><td> Sells Status: <b>";
        
        //this is a part that manages sell status
        //checking six bit
        //
       $barcode=$rek_list[8];
         $select_six_barcode="SELECT u_barcode FROM six_barcode WHERE u_barcode='$barcode'";
        $result_six_barcode=mysql_query($select_six_barcode)or die(mysql_error());
        $rek_six=mysql_fetch_array($result_six_barcode);
        //
        //end
        //echo $rek_six[0];
                //$rek_list[11].
                //." ".$rek_list[12]." ".$rek_list[13]." ".$rek_list[14].
        if(!empty($rek_six[0])) echo "Sold on Ebay";     
        else if($rek_list[13]!=1 AND $rek_list['Ready']==1) echo " IN STOCK"; else if ($rek_list[13]!=1 AND $rek_list['Ready']==0) echo 'Didnt Passed Test. Disposed'; else echo " Sold ";
        echo "</b></td></tr>";
        echo "<tr></tr><tr></tr><tr></BR><td colspan='8'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add.php' method='POST'>";
        
 //       $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
    //    $site_ref_num=$rek_list['site_ref_number'];
        $item_id=$rek_list[4];
        $buyer_id=$rek_list[5];
        $u_barcode=$rek_list[0];
//echo "ssd";
        echo "<input type='hidden' name='item_id' value='".$item_id."'>";
        echo "<input type='hidden' name='buyer_id' value='".$buyer_id."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        //echo "<input type='Submit' name='ten_cat' value='E-Bay Shipment'>";
        
        echo "</form>";
        
        echo "</td></tr>";
       //end 10 cat here second
        
        echo "<tr><td colspan='8'></td><td style='font-size:11px'>";
        //10 cat 1.
        echo "<form action='six_add.php' method='POST'";
        
   //     $source=  str_replace("H", "", $rek_list['source_id']);
  //      $date_r=$rek_list['batch_date'];
  //      $site_ref_num=$rek_list['site_ref_number'];
  //      $site_id=$rek_list['site_id'];        
//echo "ssd";
        echo "<input type='hidden' name='site_id' value='".$site_id."'>";
        echo "<input type='hidden' name='site_ref_number' value='".$site_ref_num."'>";
        echo "<input type='hidden' name='date_r' value='".$date_r."'>";
        echo "<input type='hidden' name='source' value='".$source."'>";
        
     //   echo "<input type='Submit' name='ten_cat' value='Generate 10 categories Sheet'>";
        echo "<input type='Submit' name='tv_cat' value='Full Route' disabled>";
        //echo "<input type='Submit' name='tv_cat' value='Route'></span>";
        echo "</form></td></tr><tr><td> <b>Stock-in item:</b></BR></BR>";
        
              $sql_origin="SELECT id_Barcode, Site_site_id,Item_id_item, Barcode,Barcode.date as bar_date,pn,brand,Item.name as item,
    site_id,site_ref_number,batch_date, Source_source_id, 
    Origin.company_name as company_name_s, Origin.name as name_s, Origin.surname as surname_s,
    Origin.post_code as post_code_s, Origin.town as town_s
FROM Barcode
INNER JOIN Item ON Barcode.Item_id_item = Item.id_item
INNER JOIN Site ON Site.site_id = Barcode.Site_site_id
INNER JOIN Origin ON Origin.origin_id = Site.Origin_origin_id
where Barcode='$u_barcode'";
        $res_ori=mysql_query($sql_origin);
        $rek_ori=mysql_fetch_array($res_ori);
        echo "Premises code: <b>";
        echo $rek_list[49]; //+3
        echo "</b></BR>Stock-in Barcode: <b>";
        echo $rek_list[8];
        echo "</b></BR>Item Model Number: <b>";
         echo $rek_list[2];
         echo "</b></BR>Brand: <b>";
          echo $rek_list[3];
          echo "</b></BR> Item type: <b>";
           echo $rek_list[4];
           echo "</b></BR>Site ID: ";
           
             echo $rek_list[6];
             echo "</BR>Site Reference: ";
          echo $rek_list[16];
          echo "</BR> Collection Date: <b>";
           echo $rek_list[44];
echo "</b></BR>Source Code: <b>";           
             echo $rek_list[48];
echo "</b></BR>";
           //  echo $rek_list[11];
           echo "</BR> Origin Name: ";
             echo $rek_list[50];  //+3
        echo "</BR>Origin Surname: ";
         echo $rek_list[51];
echo "</BR>Postal Code: ";
             echo $rek_list[52];
           echo "</BR>Origin town: ";
             echo $rek_list[55];
        echo "</BR>";
             echo "</td></tr></table>";
        
       
        
        }
        echo " </p>";
    }
   
   
    
    ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</td>
</table>


    
    

</BODY>
</HTML>