<?php

session_start();
include 'second_lvl_api.php';//include all needed functions
include 'first_lvl_api.php';
//reset_tokens_on_sub_cat();
error_reporting(E_ALL); ini_set('display_errors','off');
$logged=0;

if($_SESSION['logged']==1)
{
	$logged=$_SESSION['logged'];
	echo $user=$_SESSION['l_klient'];	
}

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}

if(isset($_POST['sticker_id']))
{
     echo "SS". strlen($_POST['first_sticker']);
    if(validate_size_barcode($_POST['first_sticker'])==1)
    {
        echo "First sticker";
        $sticky=1;
    $first_sticker=set_first_sticker($_POST['first_sticker']);
    }
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
        
        
        <div id="site-details" data-role="page" data-title="GRR Collection System"
        data-theme="b">
        
            <div data-role="header"
			data-position='fixed'
			
			data-id='vs_header'	>
                <h1>Green Resource Recycling Ltd.</h1>
                	
                <?php if($logged==1)
                {
                   echo '<a href="login.php" data-role="button" data-transition="pop" data-rel="dialog">Log out</a>';  
                  if(get_site_sesion() AND $sticky==1) //fucking ajax
                 echo  '<a href="manifest.php" data-transition="flip" data-ajax="false" >Start Manifest</a>';
                }
                else {
					echo '</php><a href="login.php" data-role="button" data-transition="pop" data-rel="dialog">Log me in</a>';
                
		     	}       
                
        
               ?> 
                
            </div> <!--Header-->
            <?php if($logged==1) :?> 
            <div data-role='content'>
				
				
				
                <p>Welcome  <?php echo strtoupper($user); ?>.</p>
                <p> </p>
                
                <?php

                if($logged==1){
                 echo "driver initialized";
                     set_driver_id($user);
                }
//PROCESSING 1 LEVEL API HERE

                if($_GET['finished'])
                {
                   echo '<p>Your previous manifest has been rised correctly. Please Log in to rise another one</p>';
                }
                
                
                //set driver inseesion device
                if(isset($_SESSION['l_kilent']))
                {
                    echo "driver initialized";
                     set_driver_id($_SESSION['l_klient']);//fresh from login 
                }
                
                
                
$customer_id=$_POST['customer']; //this is remembered to select the last decision

if(isset($customer_id))
    set_site ($customer_id); //this is to eliminate  loosing of previous choice, to upgrade wahat is previously remember in session. break a circly


check_if_site_picked_up($_POST['site_id']); //this writes result to FLAGS only one site refresh. OTHER SESSION OR DEVICE HEADER

if($FLAG_SITE_PICKED_UP==1)
{
    echo "<p>";
   echo "You are at: ";
 $custom=get_site_sesion();
   if(!empty($custom)) //this helped i think to don not loose customer id on the manifest
     ; // $customer_id=$custom;
   else
   set_site($customer_id);
   
   echo "<table data-role='button'><tr>";
   foreach ($arr=read_customers($customer_id) as $key=>$customer)
   {
      echo "<td>";
       echo $customer;
       echo "</td>";
   }
       echo "</tr></table>";
  
    echo "</p>";

}
else
{
    //here
    $check_id=get_site_sesion ();
    if(!empty($check_id))
    { 
        
        echo "SESSUION".$customer_id=$check_id;
    
    $FLAG_SITE_PICKED_UP=1;
    }
}   //keep in sesson

if(isset($_POST['sticker_id']))
{
     echo "SS". strlen($_POST['first_sticker']);
    if(validate_size_barcode($_POST['first_sticker'])==1)
    {
        echo "First sticker";
        $sticky=1;
    $first_sticker=set_first_sticker($_POST['first_sticker']);
    }
}
else if(get_sticker_session()){
    $first_sticker=get_sticker_session();
}   


//echo $customer_id;
//echo $FLAG_SITE_PICKED_UP;

if($customer_id==0 AND $FLAG_SITE_PICKED_UP==1) //IF SITE SPECIFIED AND IT WAS NEW CUSTOMER THAN GO TO ADD CUSTOMER
{
    echo "redirecting to specify new customer";
   // echo '<a href="customer.php">A </a>';
    $FLAG_GO_CUSTOMER_DETAILS=1;
    redirect("customer.php", 0);
    
   // header('Location: #customer-details');
    die();
    
}


?>
            
                
			</div>
					<div data-role='collapsible-set'>
				                <div data-role="collapsible" data-collapsed="true">   
                                                    <h1><a herf="#" data-transition="flip" data-role="button" data-mini="true" > SPECIFY COLLECTION PLACE</a>
				               </h1>
                                                <?php
                                                $customers=array();
                                                
                                                echo '<div data-role="main" class="ui-content">';
                                                
                                                //form for pickin a site
                                                echo '<form action="#site-details" method="POST">';
                                                
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
                                                 echo '<option value="0">';
                                                echo 'Add a new customer...';
                                                echo '</option>';
                                                echo '</select>';
                                              
                                                echo '<input type="submit" name="site_id" value="Pick up" data-inline="true">'; //inline
                                                
                                                  echo '</div>'; //control group
                                                echo "</form>";
                                                
                                                echo '</div>';
                                                //
                                                
                                                
                                                
                                                
                                                ?>
                                                </div> <!--collapisble site-->
                                                 <div data-role="collapsible" data-collapsed="true">  
                                                     <h1><a herf="#"  data-role="button" data-mini="true" 
                                                            > SPECIFY STICKER SCOPE</a>
                                                     </h1>
                                                     <p>
                                                         
                                                     <form action="tablet.php" METHOD="POST">
                                                     <input type="text" name="first_sticker" value="<?php if(!empty($first_sticker))echo $first_sticker;?>" placeholder="first sticker.."> 
                                                       
    
                                                     <input type="submit" name="sticker_id" value="Add">    
                                                     </form>   
                                                         
                                                     </p>
                                                 
                                                 </div>
						
					</div><!--body-->
				<?php endif ?>
			<div 
			data-role='footer' 
			data-position='fixed'
			data-id='vs_footer'
			data-fullscreen='true'>
			
			<h1></h1>	
		
			</div> <!--Footer-->
        
        </div> <!--Page site-->
        
        
        <div id="customer-details" data-role="page"
        data-theme="b">
        
           ADD CUSTOMER
        </div> <!--manifest site-->
    </body>
</html>



<?php
//PROCESSING 1 LEVEL API HERE

//echo $_POST['customer'];

//check_if_site_picked_up($_POST['site_id']); //this writes result to FLAGS only one site refresh. OTHER SESSION OR DEVICE HEADER

?>