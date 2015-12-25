<?php

session_start();

include 'third_lvl_api.php';
error_reporting(E_ALL); ini_set('display_errors','off');
//reset_tokens_on_sub_cat();
connect_dbi();
$legged=0;

if($_SESSION['logged']==1)
{
	$logged=$_SESSION['logged'];
	$user=$_SESSION['l_klient'];	
}


function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


?>


<html>
    <head>
        <title>GRR Collection System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
        <link rel="stylesheet" href="jquery.mobile/jquery.mobile-1.4.4.min.css"/>
        <script src="jquery-2.1.1.js"></script>
        <script src="jquery.mobile/jquery.mobile-1.4.4.min.js"></script>
    </head>
    <body>
        
        
       
        
        
        <div id="att_close" data-role="page"
        data-theme="b" data-title="manifest">
        
            <div data-role="header">
                <h1>Green Resource Recycling Ltd.</h1>
              <!---  <a href="manifest.php" data-icon="back">Go back to manifest</a>
                 <a href="options.php" data-transition="pop" data-icon="grid">Options</a>-->
            </div><!--Header-->
            
            <div data-role="content">
            <p> Manifest Done</p>
            <?php
             $manifest_reg_id= $_SESSION['MANIFEST_REG_ID']; 
              finish_manifest($manifest_reg_id);
                         //here session unset
                       session_unset();
                        $logged=0;
                        redirect("tablet.php", 1);
            ?>
            
            <p>    <a href="tablet.php?finished=1" data-role="button">Close Manifest</a>
            
            </p>
            
           
          
             </div>
            
            
       
            
            
            <div data-role="footer"
                 data-position="fixed"
                 >
             <div data-role="navbar">   
             <a href="" data-role="button"></a>   
             <a href="" data-role="button"></a>
             <a href="" data-role="button"></a>
             </div><!--END OF NAVBAR ELEMENT-->
            <?php //get_size_of_manifest(0);
              
            ?> 
            </div>
            
            
        </div> <!--manifest site-->
        
       
         
      
        
    </body>
</html>


