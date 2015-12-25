<?php

session_start();
#include 'second_lvl_api.php';//include all needed functions
#include 'first_lvl_api.php';
#include 'session_device.php';
//include 'header_mysql_tablet.php';
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
        
        
       
        
        
        <div id="atts" data-role="page"
        data-theme="b" data-title="manifest">
        
            <div data-role="header">
                <h1>Green Resource Recycling Ltd.</h1>
                <a href="manifest.php" data-icon="back">Go back to manifest</a>
                 <a href="options.php" data-transition="pop" data-icon="grid">Options</a>
            </div><!--Header-->
            
            <div data-role="content">
            <p> Calculating Weee categories..
            <a href="#atts_specify" data-role="button">Set ATTS</a>
            
            </p>
            
           
          
             </div>
            
            
            <div>
                <table data-role="table" class="ui-responsive">
                    <thead><th>WEEE CATEGORY</th><th>Weights</th></thead>
                <tbody>
                    <!-- Here content generated dynamically ,throu calculation modul -->
                    <tr>
                         <?php // show_result_one_row_at_time(get_weee_categories()); 
                         
                         
                      //  $id_c=get_sub_cat_id()[0];    //get all subcategories availible, Result as array sid_c first dimension second name
                       
                     //   echo "Weigt: ". get_weight_for_calculations($id_c[0])[1];//Here we pass re id of indexed category and get weight propered calculated, must be looped
                    
                         //for qqty received no delay purpose we extract session variable
                         $manifest_reg_id= $_SESSION['MANIFEST_REG_ID']; 
                        
                         $weee_weights_calculated=calculate_weights($manifest_reg_id);   
                         show_result_one_row_at_time($weee_weights_calculated);
                         
                         
                         //we missing site id here
                        $site_id=$_SESSION['SITE_ID'];
                      dbi_clone_manifest($manifest_reg_id, $site_id); //here we add site_sub_cat
                         ?> 
                        
                    </tr>
                    
                    
                    
                    
                </tbody>
                    
                </table>
                
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
        
        <div id="atts_specify" data-role="page" data-theme="b">
            <div data-role="header">
             
                     <h1>Green Resource Recycling Ltd.</h1>
                <a href="atts.php" data-icon="back">Go back</a>
                 <a href="options.php" data-transition="pop" data-icon="grid">Options</a>
            
                
           
            </div> <!--Header ends for aats-specidy -->
            
            <div data-role="content">
            <p> Calculating Weee categories..
         <!--   <a href="#atts_specify" data-role="button"> Finish Manifest</a>-->
            
            </p>
            
           
          
             </div>
            
            
            <div>
                <form action="atts_finish.php" method="POST" data-ajax="false">
                <table data-role="table" class="ui-responsive">
                    <thead><th>WEEE CATEGORY</th><th>Weights</th><th>ATT numbers</th></thead>
                <tbody>
                    <!-- Here content generated dynamically ,throu calculation modul -->
                    <tr>
                         <?php // show_result_one_row_at_time(get_weee_categories()); 
                         
                         
                      //  $id_c=get_sub_cat_id()[0];    //get all subcategories availible, Result as array sid_c first dimension second name
                       
                     //   echo "Weigt: ". get_weight_for_calculations($id_c[0])[1];//Here we pass re id of indexed category and get weight propered calculated, must be looped
                    
                         //for qqty received no delay purpose we extract session variable
                         $manifest_reg_id= $_SESSION['MANIFEST_REG_ID']; 
                        
                         
                         
                         
                         $weee_weights_calculated=calculate_weights($manifest_reg_id);   
                         
                         $atts=check_atts();
                         $categories_num=get_weee_categories();
                       //  echo "test";
                         $att_weights=att_assignment($manifest_reg_id);
                         $att_flag=detect_atts($atts, $weee_weights_calculated);
                         //var_dump($att_weights);
                         //show_result_one_row_at_time($att_weights);
                       //  print_r($att_weights);
                         
                         
                         $mixed_atts=show_active($att_weights);
                         
                         
                         //we get two result sets one is [0] which att flag is active by 19 categories other its name att from att table.
                         //Other thing todo is getting a new weight not through old calculation module but throu new function stemming from atts weights
                        $conve=convert_to_att_flag($mixed_atts);
                        
                         //Now we have an array with calculated summary weights for each att category, but what we need to do is get them
                         //and connect to weee categories. We need means to detect them during drawing summary weee category table, Such an 
                         //primitive association can be found in att table
                         
                         //gets an array att from att_assignment and returs active flag adjusted to show results
                       //  $att_flag[0]=show_active($att_weights);
                         
                         //gets flags[0] activates, now lets show active atts
                         show_result_one_row_at_time_att($weee_weights_calculated,$conve[0],$conve[1],$conve[2]);  // old weight $att_flag[2]
                         
                         //generate delivery here
                        // dbi_generate_delivery($att_flag);
                         
                         ?> 
                        
                    </tr>
                    
                    
                    
                    
                </tbody>
                    
                </table>
           
                </form>        
            </div> <!--form-->
            
            
        </div> <!--END of page MANIFEST_SPECIFY-->
         
     
        
    </body>
</html>



<?php
//PROCESSING 1 LEVEL API HERE

//echo $_POST['customer'];

//check_if_site_picked_up($_POST['site_id']); //this writes result to FLAGS only one site refresh. OTHER SESSION OR DEVICE HEADER

?>