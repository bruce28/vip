<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $site_date_collection; //here we stor as session actual site collected for comparison, but be care ful
function get_batch_date_for_site($site_id)
{
    $sql="SELECT * FROM site WHERE site_id='$site_id'";
    $result=query_select($sql);
    
}

//STANDAR WEIGHTS

function get_standard_weight($id_c)
{
    $sql="SELECT * FROM weight INNER JOIN sub_cat ON weight.id=sub_cat.Weight_id WHERE id_c='$id_c'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result,MYSQL_BOTH);
    return $rek['weight'];  //cannt be possible, ever to return the value of a two or more element set. NEVER
}

//END


//There is a need to modify this functions for additional parameter active 0 or 1, that way we can see if there are any traces that are not active. and accordingly
//this helps use to follow the trace stack

function get_trace($id_c) //function takes as argument a value of sub_cat and returns valid token from trace
{
    $sql="SELECT * FROM trace where sub_cat_id_c='$id_c' AND active=1";  //we add active=1 to check if there is active trace
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    return $rek['token_dynamic_idtoken'];
    //neds checking if more than 2 result. This must be error raporting system. One active possible for one sub_cat at a time
}
function get_token($token) //functions get valid token for an active sub item and returns active weight
{
    global $site_date_collection;
    //here we must compare an active token dynamic with the site batch date 
    $sql="SELECT * FROM token_dynamic where idtoken='$token' ";
    $result=query_select($sql);
    //query db. One active token assumed. but there may be other non active. Take a token and play in that case. We will divide area for zones of token_dynamic.
    //if site vbatch date fits any of the active or non active token than get weight and cat from that area
    
    //$date1 = "2012-01-12";
//$date2 = "2011-10-12";
$rek=mysql_fetch_array($result);

$date1=$rek['date_started']; //this is a form in active token
$date2=$site_date_collection;
$dateTimestamp1 = strtotime($date1);  //this is date started 
$dateTimestamp2 = strtotime($date2); //this date collected
 
if ($dateTimestamp1 < $dateTimestamp2)  //while that active is less than date collected
{
   // echo "$date1 is newer than $date2";
    return $rek['weight_spare'];
}
else
{
    return 0;
    echo "$date1 no availivle non-standard weights $date2 ";
    
}   
    
    //take from active token dynamic and date started and check if site was done before that or not
    //$rek=mysql_fetch_array($result,MYSQL_BOTH);
    
    //$active_token_date_valid_from=$rek['date_started'];
    //echo "<td>saddas";
 //  echo $active_token_date_valid_from;
  // echo $site_date_collection;
   
   

  //  echo "</td>";
   // if(true) //if date active non standard weiht is valid longer than collected
   // {        
    
    
    $rek=mysql_fetch_array($result);
    return $rek['weight_spare'];
    //return 2;
 //   }
//    else 
 //   {
        //get standard weight than. for now. but it cant stay since may be any other non active token in that period
        //get_standard_weight($id_c)
      //  return 0;
 //   }
    
    }

function get_token_category($token) //functions get valid token for an active sub item and returns active weight
{
    $sql="SELECT * FROM token_dynamic where idtoken='$token'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    return $rek['category_spare'];
    
}


function check_trace($id_c) //function barely checks if trace is availible, returns token if yes, 0 value if not
{
       if(($token=get_trace($id_c))==0)
       {
         return 0;  
       }
       else 
           return $token; 
}

function get_weight($id_c)  //functions if trace not availible returns standard weights, if availible returns weights from tokens
{
    if(get_trace($id_c)==0) //if trace is empty that means assess standard weights
    {
      return get_standard_weight($id_c); //that si the case we understand
    }
    else //here if there is an active trace. Means do not consider items type for collection before date started go standard
    {
      $weight=get_token(get_trace($id_c)); 
      
      if($weight==0)
        return get_standard_weight ($id_c);
     else
      return $weight;
    }
    
}
