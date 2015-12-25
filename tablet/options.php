<?php

session_start();
include 'first_lvl_api.php';
include 'second_lvl_api.php';//include all needed functions
//reset_tokens_on_sub_cat();

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
        <link rel="stylesheet" href="../jquery-ui/jquery-ui.css"/>
         <script src="../jquery-ui/external/jquery/jquery.js"></script>
         <script src="../jquery-ui/jquery-ui.js "></script>
         
                    <script>
  $(function() {
    $( "#datepicker1" ).datepicker({dateFormat: 'yy-mm-dd'});
    //$.datepicker.formatDate( "yy-mm-dd", new Date( 2007, 1 - 1, 26 ) );
  });
        </script>
    </head>
    <body>

        
        
        
        <?php
        
        //php here we process options posts submits
        
        
        if(isset($_POST['change_date']))
        {
            $new_date=$_POST['new_date'];
            
            
            //update site here
             /*$site_id=get_site_sesion();
             echo $sql="UPDATE site SET batch_date='' WHERE site_id='$site_id'";
             $result=query_selecti($sql);*/
        }
        if(isset($_POST['customer']))
        {
            echo read_customers($id_customer);
               $new_customer=$_POST['customer']; 
            
        }
        ?>
        
        
        
        
        
        
        <div id="options" data-role="page" data-title="GRR Collection System"
        data-theme="b">
        
            <div data-role="header"
			data-position='fixed'
			
			data-id='vs_header'	>
                <h1>Green Resource Recycling Ltd.</h1>
                	
                <?php if($logged==1)
                {
                   echo '<a href="login.php" data-role="button" data-transition="pop" data-rel="dialog">Close Manifest and Log out</a>';  
                   echo  '<a href="manifest.php" data-transition="flip" >Continue Manifest</a>';
                }
                else {
					echo '</php><a href="login.php" data-role="button" data-transition="pop" data-rel="dialog">Log me in</a>';
                
		     	}       
                
        
               ?> 
                
            </div> <!--Header-->
            
            <?php if($logged==1) :?> 
            <div data-role='content'>
			
            </div>
		
                                 
				<?php endif ?>
            
            
            <!--
                       
                        
                           <a href="#" data-role="button">Options:</a>
                           <ul data-role="listview">
                               <li data-role="list-divider"> Manifest Organisation</li>
                               <li>Customise item view</li>
                            
                               <li> Add item category </li>
                                              
                            <li data-role="list-divider"> Manifest Configuration </li>
                            <li></li>
                            
                            <li data-role="list-divider"> Current Collection </li>
                            <li>Change site dynamically</li>
                            <li>Edit first sticker</li>
                            </ul>
            -->
		
                           <div id="accordion_id" data-role="accordion">
                               <h3></h3>
                               <div data-role="collapsible-set">
                                   
                               <div data-role="collapsible">
                         <h3>Change collection date <?php if(isset($new_date)AND !empty($new_date)) { 
                         $site_id=get_site_session_change();
                         
                         if(isset($site_id)){
                             echo $new_date;
                             set_mod_date($new_date); //this alows to set date modification to be extract later
          $sql="UPDATE site SET batch_date='$new_date' WHERE site_id='$site_id'";
                         $result=query_selecti($sql);
                         }
                         if($result)
                             echo " - Changed for: ".$new_date;
                         }
                         ?></h3>
                          <p>If collection done different day, please specify the current one
                          <form action="options.php" method="POST">
                              <input type="text" data-role="date" id="datepicker1" data-inline="true" name="new_date" placeholder="yyyy-mm-dd">
                              <input type="submit" name="change_date" value="Change">
                              
                          </form>
                          
                          
                          </p>
                             </div>
                           </div>
                               
                                 <div data-role="collapsible">
                         <h3>Change current site <?php if(isset($new_customer)){echo $new_customer; 
                          $site_id=  get_site_session_change();
                          set_site_id($site_id); //we save in sesson
                          if(isset($site_id))
                          { 
                          echo $sql="UPDATE site SET Origin_origin_id='$new_customer' WHERE site_id='$site_id'";
                         $result=query_selecti($sql);
                          }
                         if($result)
                             echo " - Changed for: ".$new_date;
                         }
                         
                         ?></h3>
                          <p>If you done mistake, and specified a wrong site. Please change a site</p>
                             
                                 <?php
                                 echo '<div data-role="main" class="ui-content">';
                                                
                                                //form for pickin a site
                                                echo '<form action="options.php" method="POST">';
                                                
                                                echo "<p>";
                                                echo '<label for="customer">Customer Location: </label>';
                                                echo "</p>";
                                                echo '<div data-role="controlgroup">';
                                                echo '<select name="customer" data-native-menu="false" data-inline="true">'; //    
                                                for($i=0;$i<=get_max_customer();$i++) //here we need to find the space of list. It will be exual to get_customer_number method  get_size_of_manifest_customer()
                                                 {    
                                                     //here we remember only last pick up. Not stored anywhere elese just one global that is gone after page reloaded. If 
                                               if($FLAG_SITE_PICKED_UP==1 AND $i==$customer_id)
                                                       $selected=" selected";
                                               else $selected="";
                                                    
                                                    
                                                    $customers=read_customers($i);
                                                            //moved one up!!
                                                   if(!empty($customers[0]))
                                                    {
                                                      echo '<option value="'.$customers[0].'" '.$selected.'>';
                                               
                                               echo $customers[1];
                                               echo " - ";
                                               echo $customers[2];
                                                
                                              
                                               
                                                 echo '</option>';
                                                    }
                                                }   
//echo $customers[2];
                                               
                                                echo '</select>';
                                              
                                                echo '<input type="submit" name="site_id" value="Pick up" data-inline="true">'; //inline
                                                
                                                  echo '</div>'; //control group
                                                echo "</form>";
                                                
                                                echo '</div>';
                                 ?>
                                 </div>
                           </div>
                               
                            </div>   
                           
                           
                           
                           
                                        <div 
			data-role='footer' 
			data-position='fixed'
			data-id='vs_footer'
			data-fullscreen='true'>
			
			<h1></h1>	
		
			</div> <!--Footer-->
        
        </div> <!--Page site-->
     
       
    </body>
</html>
