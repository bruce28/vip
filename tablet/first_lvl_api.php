<?php
include 'flags.php';
/* 
 * First level API contains all functions to validate and confirm that manifest can be rised. It simply
 * Implements all behaviours on tablet system before manifest. 
 */


function generate_manifest_unq_number()
{
           $token=rand(1000,10000);
           //generate the unique manifest number
           
           //small modification: we add also post code to generator
           $manifest_new_number= get_site_sesion()."4".get_post_code_session(get_site_sesion())."5".rand(100,10000).$token;
           return $manifest_new_number; 
};

function check_if_site_picked_up($site_id)  //site id is result of submit pick up form
{
    global $FLAG_SITE_PICKED_UP;
    
    if(isset($site_id))
        $FLAG_SITE_PICKED_UP=1;
    else {
        $FLAG_SITE_PICKED_UP=0;    
      //  echo "not picked up";
    }
            
    
    
}


//OPS to TO 

function set_site($customer_id) //just leave header device for now
{
    //writes customer_id to manifest_reg or theoreticaly can generate a new site
    
    //manifest_reg does not exist yet. We can write it to header device session variable or in session
    
    
    //set as session
    
    $_SESSION['CUSTOMER_ID']=$customer_id;
  
}

function get_site_sesion()
{
     $customer_id=$_SESSION['CUSTOMER_ID'];
     return $customer_id;
             
}


function unset_site()
{
    unset($_SESSION['CUSTOMER_ID']);
    
}

function set_first_sticker($sticker)
{
    $_SESSION['STICKER_ID']=$sticker;
    return $sticker;
}

function get_sticker_session()
{
    $sticker=$_SESSION['STICKER_ID'];
    return $sticker;
}

function unset_first_sticker()
{
    unset($_SESSION['STICKER_ID']);
}

function set_level_1($level_1)
{
    $_SESSION['LEVEL_1']=$level_1; 
    
}

function get_level_1()
{
   $level_1=$_SESSION['LEVEL_1']; 
    return $level_1;
}

function unset_level_1()
{
   unset($_SESSION['level_1']);    
}

function check_manifest_unq_num_set($manifest_unq_num)
{
    if($_SESSION['MANIFEST_UNQ_NUMBER']==$manifest_unq_num)
    {
        echo $_SESSION['MANIFEST_UNQ_NUMBER'];
        return 1;
    }
    else 
        return 0;
    
    
}


function set_site_id($site_id)
{
    $_SESSION['SITE_ID']=$site_id;
    return $site_id;
}

function get_site_session1()
{
   // $site_id=$_SESSION['SITE_ID'];
    return $site_id;
}

/** Is a function to return changed siteid session
 * 
 * @return site_id_session
 */
function get_site_session_change()
{
  $site_id=$_SESSION['SITE_ID'];
    return $site_id;
}

function unset_site_id()
{
    unset($_SESSION['SITE_ID']);
}


//for driver

function set_driver_id($user)
{
    $_SESSION['DRIVER']=$user;
    
}

function get_driver_session()
{
    
    return $_SESSION['DRIVER'];
    
}
/** returns a id_user
 * 
 * @param type $login
 * @return id_user
 */
function convert_driver_id($login)
{
  echo  $sql="SELECT id_user FROM user_2 WHERE login='$login'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[0];
}

//function for bacrode validation

function validate_size_barcode($barcode)
{
    if(strlen($barcode)==12)
    {
        //echo "x".strlen($barcode);
        return 1;
    }
        else return 0;
            

    
}


function calculate_sticker_range($first_sticker,$last_sticker)
{
  //get an actual subset of string differentiation is done
    
    $first_sticker_value =  substr($first_sticker,4,-2);
    $last_sticker_value =  substr($last_sticker,4,-2);
    
    
    //before return we need some checking if the slash values are the same and prefixes also. Avoid problems in the future
    //echo (int)$first_sticker_value;
    return ((int)$last_sticker_value-(int)$first_sticker_value)+1;  //add one to give actual set value-+
    
}

function dbi_write_sticker_range($site_id,$range)
{
    $sql="UPDATE site SET closed='$range' WHERE site_id='$site_id'";
    $result=query_selecti($sql);
   // $rek=  mysqli_fetch_array($result);
    
}


function get_post_code_session($customer_id) //used to generate unique manifets id
{
    $sql="SELECT post_code FROM origin WHERE origin_id='$customer_id'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[0];
}

/** Function gets the size of origin table. Shall be grouped with get_ and size_ functions
 * 
 * @return num_customers
 */
function get_size_of_manifest_customer()
{
    $sql="SELECT * FROM origin";
    $result=query_selecti($sql);
    $num_customers=mysqli_num_rows($result);
    return $num_customers;
    
}

function set_mod_date($date)
{
   $_SESSION['MOD_DATE']=$date;
}

function get_mod_date_session()
{
    return $_SESSION['MOD_DATE'];
}

function unset_mod_date()
{
   unset($_SESSION['MOD_DATE']);   

}
