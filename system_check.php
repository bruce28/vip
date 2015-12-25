<?php
session_start();
$host='127.0.0.1';
$dbs='dbs3';
$username='root';
$password='krasnal';



?>

<HTML>
<HEAD>

<link rel="stylesheet" href="layout.css " type="text/css">
<link rel="stylesheet" href="form_cat.css " type="text/css">
</HEAD>
<BODY>

<div id="banner">

<IMG SRC="weee/WEEE%20Collection%20v3_html_m5ab1a91a.jpg" WIDTH=180 HEIGHT=151 align="right">
<BR><BR>
<IMG SRC="weee/WEEE%20Collection%20v3_html_m6a98edc9.jpg" WIDTH=449 HEIGHT=51 HSPACE=3 VSPACE=3>
<BR>
</div>
</BR></BR>

<div id="tabel_wrap_out"></BR>
    </br>
    <center><p style=""><h3>System Checkup and Recovery </h3></p></center>
    </br>
    
  <h4> Manifest Register AND Manifest Counter:</h4>
    <?php
    mysql_connect($host,$username,$password);
    mysql_select_db($dbs);
    
    $border_mani=70;
    $check_up="SELECT COUNT(idmanifest_reg) as ile, idmanifest_reg FROM manifest_counter INNER JOIN manifest_reg ON manifest_reg.idmanifest_reg=manifest_counter.manifest_reg_idmanifest_reg GROUP BY manifest_reg_idmanifest_reg,idmanifest_reg
";
            $result_check=mysql_query($check_up);
            while($rek_check=mysql_fetch_array($result_check))
            {
              if($rek_check['ile']>$border_mani)
              {
                  echo "<BR />SYSTEM Manifest idmanifest_reg_idmanifest_reg NOT COHERENT: ".$rek_check['idmanifest_reg'];
                  echo "<BR/>";
                  $incoherent=$rek_check['idmanifest_reg'];
                  $select="SELECT siteid from manifest_reg WHERE idmanifest_reg='$incoherent' ";
                  $res_select=mysql_query($select);
                  while($rek=mysql_fetch_array($res_select))
                  {
                      echo "Site id: ";
                      echo $rek['siteid'];
                      
                      //echo "<BR/>Manifest counter: ".$rek['id_manifest_counter'];
                     
                  }
                  
              }
                
            }
            
            
            
            echo "<BR/><BR/> Sites";
            
            $sites_sql="SELECT * FROM manifest_reg
Right JOIN site ON manifest_reg.siteid=site.site_id
WHERE manifest_reg.siteid is NULL";
            $result=mysql_query($sites_sql) or die(mysql_error());
            while($rek=mysql_fetch_array($result))
            {
              echo $rek['site_id'];
              echo "<BR/>";
            }
    
    
    
    ?>
    
    
    
    
<table id="tabel_out" border="1"  >

    
    




</table>
    </BR>
    
    
    

    
   
<BR><BR>

</BODY>
</HTML>