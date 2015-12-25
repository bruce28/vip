<?php
session_start();
require 'functions_calculation_weights_pre_processed.php';
require 'header_mysql.php'

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>GRR POST Processing goods</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
 <link rel="stylesheet" href="ui/css/jquery-ui.min.css" type="text/css">
        
    </head>
   <!--
    <script src="ui/js/jquery-ui.min.js">
        </script>
        <script src="ui/js/jquery.js"></script>
     -->
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    
    <body bgcolor="whitesmoke">
        <style>
            h2{
               alignment-adjust: central; 
                
            }
        </style>
        
        <div><h2>  </h2></div>
        
        <div>
          <div class="ui-widgets">
              <div class="ui-widget-header">
            <?php
         //  echo "<p>Green Resource Recycling<p>";
           
           
           
            ?>
            
                  <p>Green Resource Recycling Ltd.</p>
               
                  
               
                </div>
                <div class="ui-widget-content">
           <!-- <button class="ui-state-hover">kjkj</button>-->
           <div> <table border="1" class="ui-widget-shadow">
                <thead>
                
                </thead>
                <tbody>
                    <tr>
                        <td>
                           Green Resource Recycling LTD
                        </td>
                        
                    </tr>
                    <tr><td>271 Sheepcot Lane</td></tr>
                    <tr><td>WD257DL, Watford</td></tr>
                </tbody>
                
                
            </table>
               </div>
           
           <div><p><h4>Non-ferrous Weightbridge Docket</h4></p>
           <p><h4>Date of collection</h4></p>
           </div>
           
            </BR></BR>
           
            <div>
                
                <table>
                    
                    <tr>
                        <td>Driver: </td>
                        
                    </tr>
                    <tr>
                        <td>Reg:</td>
                    </tr>
                    
                </table>
                
            </div>
            
           <div>
              
               
               
               <table>
                <thead>
                
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                         Collected from:
                        </td>
                        <td>X</td>
                        <td>Weight collected: </td>
                        <td> X</td>
                    </tr>
                    
                </tbody>
                
                
            </table>
               
           </div>
            </BR></BR></BR>
            
            
            <div>
            
            <?php
            
            
            //echo '<table ><form action="pre_processed_good_process.php" method="POST">'
            echo  '<table class="ui-widget-content" id="table_specifics">';
                 echo "<tr>";
                echo  "<td>";
                
                echo "<ul><li></li><li></li><li></li></ul>";
                //show_goods(get_goods());
                 echo "</td>";
                 echo "<td>Good type</td>";
                 echo "<td></td>";
                 echo "<td>Weight</td>";
                 echo "<td>STREAM?</td>";
                  echo"</tr>";
                    
               echo "</table>";
            
            ?>
            
              
                
            </div>
           
           
            </div>
            </div>
            
            <a href="pre_processed_good_process.php">Back</a>
            <script>
                
                $(function () {
                    $("table").button();
                }
                        
                      
            );
    
              $(function (){
                            $("#1").button();
                        }
                                );
                        
                
                $(function ()
                {
                    $("a").button();
                }          
            );
                
               /*  $(function() {
                    $("input[type=submit]").button();
                });
              */
              
    

          
          
            </script>
        </div>
        
    </body>
</html>
