<?php
session_start();
require 'functions_calculation_weights_pre_processed.php';
require 'header_mysql.php';



//VARIABLE TO KEEP PARTICULAR SITE AND ID OF ITEM


?>
<!DOCTYPE html>
<html>
    <head>
        <title>GRR POST Processing goods</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="jquery-ui/jquery-ui.css" type="text/css">
     <!--   <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
      <!-- <link rel="stylesheet" href="jquery-ui/jquery-ui.css" type="text/css">
        <script src="jquery-ui/external/jquery/jquery.js"></script>
        <script src="jquery-ui/jquery-ui.js">
        </script>-->
      <link rel="stylesheet" href="jquery-ui2/jquery-ui-1.11.2.custom/jquery-ui.css" type="text/css">
      <script src="jquery-ui2/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
      <script src="jquery-ui2/jquery-ui-1.11.2.custom/jquery-ui.js">
        </script>   
      
      <!--  <link rel="stylesheet" href="jquery-ui1/jquery-ui-1.11.2.custom/jquery-ui.css" type="text/css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
        <!--
        <script src="jquery-ui1/jquery-ui-1.11.2.custom/external/jquery/jquery.js"></script>
        <script src="jquery-ui1/jquery-ui-1.11.2.custom/jquery-ui.js">
        </script>-->
    </head>
   <!--
    <script src="ui/js/jquery-ui.min.js">
        </script>
        <script src="ui/js/jquery.js"></script>
     -->
      
  
     <body class="ui-front">
        <style>
            h2{
               alignment-adjust: central; 
                
            }
            .ui-widget-content {
               background-color: "white-smoke";
            }
            
            fieldset[data-theme="radiolist"] .ui-controlgroup-label {
                display: none;}
            
            #table_detected {
                margin: 20px;
                padding: 20px;
                border: 1px;
                alignment-baseline: central;
                //background-color: whitesmoke;
                
                
            }
            #table_specifics{
                margin:20px;
                padding:20px;
                border:0px;
            }
            
            #wrapper_content{
                marign:20px;
                padding:20px;
                border:0px;
            }
            #content_main{
                background-color: lightgray;
            }
        </style>
        
        
        
        
        <div class="ui-widget-header">
            <p><h3>Green Resource Recycling Ltd.</h3></p><p> Goods processing system</p>
            
        </div>  <!--end of header-->
        
        <div id="content_main" class="ui-widget-content">
        
          <!--  <fieldset data-role="controlgroup" data-theme="radiolist">
                <legend>+++</legend>
                <div class="ui-li ui-li-divider ui-btn ui-bar-a ui-corner-top ui-btn-up-undefined">
                   <?php ?>
                </div>
           -->
 
      
            
        <div>
            <p>
              <!--  <h2>Goods that may need to be evaluated: </h2>-->
            </p>
        </div>
        
        <div class="ui-widget-content" id="wrapper_content">
        <!--
           
            
            <div id="accordion">
  <h3>First header</h3>
  <div>First content panel</div>
  <h3>Second header</h3>
  <div>Second content panel</div>
</div>
                
           
 
                     <div class="ui-widget">
  <label for="atts">ATTS: </label>
  <input id="atts">
</div>
    -->     
            <?php
            $site_has_att_id=0;
            close_processing_post();
            $if_print_detected=get_site_has_cat_id_session();
            if(empty($if_print_detected))
            {   
            att_search();   //here a pair of functions att_search and get_process_att
            }
            echo $site_has_att_id=get_process_att();
            $_POST['post_processed'];
            insert_goods(); //inserts into db a post processed new items

            //processs
            
            
            
            
       //    echo '<h3>NETT weight</h3>';
         //      echo '<div>weight';
            
            if(empty($if_print_detected)) //here disolve list of sites detected as soon as we go
            {
            //show all sites and atts needs to be processed
            $num=draw_detected(detect_pre_processed_items(0));
            $num;
            }
             //process
              $site_has_cat_id=$_POST['site_has_cat_id'];
              
              //wrap it through session
              $site_has_cat_id=read_site_has_cat_id($site_has_cat_id);
              
               process_pre_processed_items($site_has_cat_id);
          //     echo '</div>';
                
            
            //nett bf
           if(isset($_POST['nett_submit']))
            {
                 // echo "Inserting weigt";
                  $weight_nett=$_POST['nett_weight'];
                  $site_has_cat_id=$_POST['site_has_cat_id'];
                dbi_set_nett_weight($weight_nett, $site_has_cat_id);
            }
             
               if(!empty($site_has_att_id)) //in that situation we try to omitt ivestigation form process
               {
                   echo "SITE has attid".$site_has_att_id;
                   $site_has_cat_id=$site_has_att_id;
                   set_session_site_has_cat_id($site_has_cat_id);
                   
               }
            if($site_has_cat_id=read_site_has_cat_id(if_investigate_request($num)[0]))
            {
              // echo  "</BR>";
                echo '<div id="accordion">';
                echo '<h3>NETT weight</h3>';
              echo '<div>';
              
             $weight_nett=nett_assess($site_has_cat_id);    
                  echo '</div>';
                echo '<h3>Add a new type</h3>';
              echo '<div>';
             set_session_site_has_cat_id($site_has_cat_id); //here we set global variable called seesion that we use in loop until close is set
             //  echo  '<h3>Add new goods</h3>';
              //  echo    '<div>goods</div>';
            
           // echo '<h2> Define a new processed goods</h2>';
           
            create_new_item_processed($site_has_cat_id);
         //   echo '</BR>';
            //echo '=====================================================================</BR>';
            //draw_detected(detect_pre_processed_items(if_investigate_request($num)[1]));
             echo '</div>';
            echo '<h3>Define processed goods</h3>';
                echo  '<div>';
            
            show_goods(get_goods(),$site_has_cat_id);
            
           
            }
                echo '</div>';
            
          //return
            
           
            ?>
            </div> <!--accordion div-->
            </div> <!--min div-->
             <?php 
             if(empty($if_print_detected))
             {
                echo '<p><a href="index.php">Return</a></p>';
              }
           
            ?>
          <!--  </fieldset> -->
           
            </div><!-- END of content-->
   
           
            
            <script>
               /*  $(function() {
                    $("input[type=submit]").button();
                });
              */
             
             
              $(function (){
                  
                  $("input[type=submit]").button();
                  $("input").autocomplete();
                  
              }
                      
            );
   
                $(function (){
                  
                 //$("input[type=text]").textinput();
                  $("#accordion").accordion({
                      heightStyle: "content",
                      collapsible: true,
                      active: 2
                  }); 
                   $("select").selectmenu({width:200}); 
                 //  $("table").table();
              }
                      
            );
    
                $(function () {
                    $("a").button();
                    
                }
                        
            );
    
    function relode_pre(){
    document.getElementById('atts').submit();
    //investigate
    };
     $(function() {
    var availableTags = [
      "66",
      "66"
    ];
    $( "#atts" ).autocomplete({
      source: availableTags
    });
  });
           

          
          
            </script>
     
        
    </body>
</html>
