<?php

session_start();
#include 'second_lvl_api.php';//include all needed functions
#include 'first_lvl_api.php';
#include 'session_device.php';
//include 'header_mysql_tablet.php';
include 'third_lvl_api.php';

require 'first_lvl_api.php';  //for manifest sticker manipulation

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
        
        
       
        
        
        <div id="att_finish" data-role="page"
        data-theme="b" data-title="manifest">
        
            <div data-role="header">
                <h1>Green Resource Recycling Ltd.</h1>
              <!---  <a href="manifest.php" data-icon="back">Go back to manifest</a>
                 <a href="options.php" data-transition="pop" data-icon="grid">Options</a>-->
            </div><!--Header-->
            
            <div data-role="content">
            <p> Manifest Done. Please SET Your Last Sticker than Close.</p>
            
            <?php
            
            
                 $manifest_reg_id= $_SESSION['MANIFEST_REG_ID']; 
                 
                 
                 
            //borrowed
            
              $sql="SELECT siteid from manifest_reg WHERE idmanifest_reg='$manifest_reg_id'";
                         $result=query_selecti($sql);
                         $rek=mysqli_fetch_array($result);
                         $site_id=$rek[0];
                         //intiased the second time in code. Taken from bf update
                         //this barely to get to site range dbi write   
                         
                         
                 
                  if(isset($_POST['submit']))
                    {
                        if(!empty($_POST['last_sticker'])) //if something is set than 
                        {   
                            
                            
                            $last_sticker=$_POST['last_sticker']; //get that
                            if(validate_size_barcode($last_sticker)==1)  //process that
                            {   //if sticker size is correct
                                dbi_set_last_sticker ($manifest_reg_id, $last_sticker); //and write to database
                            }
                            else {;} //if sticker size not valid
                        }
                   }
                         
                 
              echo '<div data-role="controlgroup">';
                          $last_sticker=dbi_get_last_sticker($manifest_reg_id); //get end_dbs from db
                          
                            echo '<form action="atts_finish.php" method="POST">';
                         echo '<input type="text" name="last_sticker" value="'.$last_sticker.'" placeholder="last sticker..." autofocus="">';
                              echo '<input type="submit" name="submit" value="Set">';
                         echo '</form>';
                         echo '</div>';
                         
                         
                         
            //here a space for a table with collection details
                         echo '<p>Your manifest collection details: </p>';
                         echo '<div>';
                         echo '<table  data-role="table" data-mode="columntoggle" class="ui-responsive" data-column-btn-text="Edit!" >';
                 
      echo  '<thead><tr>
          <th data-priority="6">Collection</th>
          <th>First</th>
          <th data-priority="1">Last Sticker</th>
           <th>You collected: </th>
        </tr>
      </thead>';
      echo '<tbody>';
                         echo '<tr>';
                         echo '<td>';
                         echo get_post_code_session(get_site_sesion());
                         echo '</td>';
                         echo '<td>';
                         echo $first_sticker=get_sticker_session();
                         echo '</td>';
                         echo '<td>';
                         echo $last_sticker;
                         echo '</td>';
                         
                         echo '<td>';
                        echo $range=calculate_sticker_range($first_sticker, $last_sticker);
                           
                        echo " items"; 
                         //add to db
                         dbi_write_sticker_range($site_id, $range);
                         echo '</td>';
                        echo '</tr>';
                         echo '</tbody>';
                         echo' </table>';
                        echo '</div>';
                         
                   
            ?>
            
            
            <p>    <a href="att_close.php" data-role="button">Close Manifest</a>
            
            </p>
            
           
          
             </div>
            
            
            <div>
          <!--        <table data-role="table" class="ui-responsive">
                    <thead><th>WEEE CATEGORY</th><th>Weights</th></thead>
                <tbody>
                    <!-- Here content generated dynamically ,throu calculation modul   <tr> -->
                  
                         <?php 
                         
                         
                       
                         
                         
                         
                         
                         
                         
                         
                          //$result=calculate_weights($manifest_reg_id);  
                         //echo show_result_one_row_at_time($result);
                         
                 //     $manifest_reg_id= $_SESSION['MANIFEST_REG_ID']; 
                        
                        
                         
                         
                         $weee_weights_calculated=calculate_weights($manifest_reg_id);   
                         
                         $atts=check_atts();
                         $categories_num=get_weee_categories();
                         //$att_flag=detect_atts($atts, $weee_weights_calculated);
                         //show_result_one_row_at_time_att($weee_weights_calculated,$att_flag[0],$att_flag[1],$att_flag[2]);
                        
                         
                         //get site from manifest counter
                         /*   
                         $sql="SELECT siteid from manifest_reg WHERE idmanifest_reg='$manifest_reg_id'";
                         $result=query_select($sql);
                         $rek=mysqli_fetch_array($result);
                         */
                        //connect_dbi();
                         
                         //
                         
                          $att_weights=att_assignment($manifest_reg_id);
                         $att_flag=detect_atts($atts, $weee_weights_calculated);
                         //var_dump($att_weights);
                         //show_result_one_row_at_time($att_weights);
                         print_r($att_weights);
                         
                         
                         $mixed_atts=show_active($att_weights);
                         
                         
                         //we get two result sets one is [0] which att flag is active by 19 categories other its name att from att table.
                         //Other thing todo is getting a new weight not through old calculation module but throu new function stemming from atts weights
                        $conve=convert_to_att_flag($mixed_atts);
                         
                         
                         
                         
                         
                         //
                         
                          $sql="SELECT siteid from manifest_reg WHERE idmanifest_reg='$manifest_reg_id'";
                         $result=query_selecti($sql);
                         $rek=mysqli_fetch_array($result);
                         $site_id=$rek[0];
                         var_dump($result);
                         
                         
                        
                         
                         $sql="SELECT * FROM delivery WHERE Site_site_id='$site_id'";
                         $result=query_selecti($sql);
                         $rek=  mysqli_fetch_array($result);
                         if($rek)
                            echo "Cannt insert delivery already done" ;
                         else{ //do not 
                         //generate delivery her
                             dbi_generate_delivery_dynamic_att($conve,$site_id);
                         //update manifest to close 0 i think done
                         
                         //seting att[s]
                         
                        
                         $att_tv=$_POST['TV'];
                         $att_mobile=$_POST['Mobile'];
                         $att_weee=$_POST['WEEE'];
                         
                         $att_bric=$_POST['Bric'];
                         $att_cd=$_POST['CD'];
                        // $att_toner=$_POST['Toner'];
                         
                         $att_ink=$_POST['INK'];
                         
                         $qtty_tv=$_POST['weightTV'];
                          $qtty_mobile=$_POST['weightMobile'];
                           $qtty_weee=$_POST['weightWEEE'];
                            $qtty_bric=$_POST['weightBric'];
                             $qtty_cd=$_POST['weightCD'];
                          //    $qtty_toner=$_POST['weightToner'];
                               $qtty_ink=$_POST['weightINK'];
                               
                               
                               $att_nferr=$_POST['Non-Ferrous_Metal'];
                               $qtty_nferr=$_POST['weightNon-Ferrous_Metal'];
                         
                         //Telies update
                         $sql="UPDATE delivery SET att_num='$att_tv',QtyPickedUp='$qtty_tv',QNum='$qtty_tv'  WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='TV'";
                         query_selecti($sql);
                         
                         $sql="UPDATE delivery SET att_num='$att_mobile',QtyPickedUp='$qtty_mobile',QNum='$qtty_mobile' WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='A2'";
                         query_selecti($sql);
                         
//weee
                         $sql="UPDATE delivery SET att_num='$att_weee',QtyPickedUp='$qtty_weee',QNum='$qtty_weee' WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='93'";
                         query_selecti($sql);
                         
                         //toners
                         $sql="UPDATE delivery SET att_num='$att_ink',QtyPickedUp='$qtty_ink',QNum='$qtty_ink' WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='99'";
                         query_selecti($sql);
                         
                            //cds
                         $sql="UPDATE delivery SET att_num='$att_cd',QtyPickedUp='$qtty_cd',QNum='$qtty_cd' WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='A1'";
                         query_selecti($sql);
                         
                               //bric
                         $sql="UPDATE delivery SET att_num='$att_bric',QtyPickedUp='$qtty_bric',QNum='$qtty_bric' WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='94'";
                         query_selecti($sql);
                         
                          $sql="UPDATE delivery SET att_num='$att_nferr',QtyPickedUp='$qtty_nferr',QNum='$qtty_nferr' WHERE Site_site_id='$site_id' AND Trans_Category_Category_id='19'";
                         query_selecti($sql);
                         }//this goes also with condition si is not reste automaticaly
                         //lets consider to keep it in session
                         //cause they are reseted while refresed
                         //
                         //
                         //end of atts modif
                         
                         
                         //this two executed while closed link clicke
                         
                         /*
                         echo $sql="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$manifest_reg_id'";
                         $result_closed=query_selecti($sql);
                         //$rek=mysqli_fetch_array($result_closed);
                        //$site_id=$rek[0];
                         
                         echo $sql="UPDATE manifest_counter SET finished=1 WHERE manifest_reg_idmanifest_reg='$manifest_reg_id'";
                         $result=query_selecti($sql);
                         //$rek=mysqli_fetch_array($result);
                        // $site_id=$rek[0];
                         */
                      /*   
                         echo '<form action="atts_finish.php" method="POST">';
                          echo '<input type="text">';
                                 
                         
                         echo '</form>';
                       */
                         
                         
                         
                 /*     
                         
              finish_manifest($manifest_reg_id);
                         //here session unset
                       session_unset();
                        $logged=0;
                   */      
                         ?> 
                        
                    </tr>
                    
                    
                    
                    
              <!--  </tbody>
                    
                </table>
                -->
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



<?php
//PROCESSING 1 LEVEL API HERE

//echo $_POST['customer'];

//check_if_site_picked_up($_POST['site_id']); //this writes result to FLAGS only one site refresh. OTHER SESSION OR DEVICE HEADER

?>