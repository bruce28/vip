<?php

session_start();
include 'second_lvl_api.php';//include all needed functions
include 'first_lvl_api.php';
include 'session_device.php';

//reset_tokens_on_sub_cat();
error_reporting(E_ALL); ini_set('display_errors','off');
$legged=0;

if($_SESSION['logged']==1)
{
	$logged=$_SESSION['logged'];
	$user=$_SESSION['l_klient'];	
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
        
        
       
        
        
        <div id="manifest" data-role="page" data-dom-cache="true"
        data-theme="b" data-title="manifest">
        
            <div data-role=header>
                <h1>Green Resource Recycling Ltd.</h1>
              <!--  <a href="tablet.php" data-icon="back">Collection details</a>-->
                 <a href="options.php" data-transition="pop" data-icon="grid">Options</a>
            </div><!--Header-->
            
            <div data-role="content">
            <p>Manifest
            <a href="atts.php" data-role="button" data-transition="pop" data-ajax="false">Finish Manifest</a>
            
            </p>
            
           
          <!--  <div data-filter="true" class="ui-grid-a">-->
           <div >
               
                <!--<div >1. TV's 21</div>
                <div>2. TV'2 45</div>
                <div>3. Sky box</div>
                <div>4. Monitors : /NEW/</div>-->
                <?php //show_full_items_list_all_stock();
                 echo "SITE_SESSIOn".get_site_sesion();   
                //echo $SIZE_OF_MANIFEST;
                //variable for qtty sign incremented on manifest - tmp
               
               
                //here we initialize manifest for testing purposes. But should be first function checking if last len manifest generated correctly all state $FINISHED_CORRECTLY
                $MANIFEST_STATE=initialize_manifest_reg();  //is in llop of every item add generet new one. shall have a lock and check
                if($MANIFEST_STATE>1)
                 //   echo "MANIFEST GENERATED CORRECTLY";
                $FLAG_MANIFEST_UNQ_NUMBER=$MANIFEST_STATE; //here initialize the counter generator
                
                // $SIZE_OF_MANIFEST;
                
                
                //here lets check get and change sqlload if needes
                echo "GET";
                var_dump($_GET);
                
                if(isset($_GET['type']))
                {                             //Later on this module shall be rewrite to be more scalable
                    echo "Type set";
                    $sql_load;  //get sql_load
                    $type=$_GET['type'];
                    if($type==1)    
                    {
                        echo "Type 1. Electrics";
                        $sql="SELECT * from sub_cat WHERE kind=2 AND item_type=3 ORDER BY Name_sub ASC";
                    }
                    
                    if($type==2)
                    {
                        echo "Type 2. Material";
                        $sql="SELECT * from sub_cat WHERE kind=2 AND item_type=2 ORDER BY Name_sub ASC";
                    }
                    if($type==3)
                    {
                        echo "Type 2. Bric-a-Brac";
                        $sql="SELECT * from sub_cat WHERE kind=2 AND item_type=1 ORDER BY Name_sub ASC";
                    }
                    
                    $sql_load=$sql;  //Lets load our statement into main sql_load. Than execute
                }
                else
                   ;  //if all, not type of tab set than use original sql load statement
                get_size_of_manifest($sql_load); //here we initialize one more time global variables that are gone to pass them to argument of generate manifest counter
                
                //commented only visible , lest count each one
                 //$SIZE_OF_MANIFEST=$SIZE_VISIBLE;
                $SIZE_OF_MANIFEST=$SIZE_OF_MANIFEST;
                generate_default_manifest_counter($SIZE_OF_MANIFEST);
                $manifest_reg_id=read_manifest_id($FLAG_MANIFEST_UNQ_NUMBER);
                
                if(!empty($manifest_reg_id))
                $_SESSION['MANIFEST_REG_ID']=$manifest_reg_id;
                //lets keep from no on all the time current id manifest id, tha we use to add one
                
                //here we should have a wrapper to extract session id to local variable..check it state and compare throu dbi api. manitor the states
                
               // echo "SESSION: MANIFEST_REG: ".$_SESSION['MANIFEST_REG_ID'];
                
                
                $qtty_digit=0;
               
                construct_table_draw_table($sql_load); //here probably is generated SIZEOF MANIFEST VISIBLE
                
                 
                 
                process_received(receive());
                
                ?>    
                
                
            </div>
             </div>
            
            
            <div data-role="footer"
                 data-position="fixed"
                 >
             <div data-role="navbar">   
                 <a href="manifest.php" data-role="button">All</a>   
                 <a href="manifest.php?type=1" data-role="button">Electrics</a>   
             <a href="manifest.php?type=2" data-role="button">Material</a>
             <a href="manifest.php?type=3" data-role="button">Bric-a-Brac</a>
             </div><!--END OF NAVBAR ELEMENT-->
            <?php get_size_of_manifest($sql_load);
             
            // echo $SIZE_VISIBLE;
             //  echo "</BR>";
          //    echo $SIZE_VISIBLE_AND_ACTIVE;
            //   echo "</br>";
           //    echo $SIZE_VISIBLE_AND_STANDARD;
          //     echo $SIZE_OF_MANIFEST;
              show_last_add();
               
            ?> 
            </div>
            
            
        </div> <!--manifest site-->
    </body>
</html>



<?php
//PROCESSING 1 LEVEL API HERE

//echo $_POST['customer'];

//check_if_site_picked_up($_POST['site_id']); //this writes result to FLAGS only one site refresh. OTHER SESSION OR DEVICE HEADER

?>