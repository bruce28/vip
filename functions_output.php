<?php
include 'tablet/second_lvl_api.php';
/* 
 * This functions adopted to help output data from db
 */
//ERROR RAPORTING

function non_standard_and_non_active()
{
    
    
    
}

//FUNCTIONS FOR COLLECTION 


//FUNTIONS for OUTPUT

function show_token_trace()
{
    
    
}

function insert_new_token_trace()
{
    
    
}

function draw_token_trace_edit()
{
    
    echo "<table>";
    echo "<tr>";
    echo "<td>";
    
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    
}


//FOR ADDING NEW TOKEN TRACE


function constraint_categories($cat)  //checks if category really exists in category tables. Cause we lost INNDB constraints by table denormalisation
{
    
    
    
}



function constraint_activation($act_tuple) //this will check if there is previous active token trace
{
    //extract tuple
    
    $all=$act_tuple[1];
    $act=$act_tuple[0];
    
    if($act==1)
        return 1;
   else if($act==0)
   {
        return 2;   
   }
   else if($act==0 AND $all==0)
   {
       return 3;
   }
    else {
        echo "F: Constraint activation: More than one active weight. System stopped. Call ADMIN";
        die();    
    }
}

function check_activation($id_c) 
{
    //Two variables for stoting results for how many non-active and how many active
    $non_active=0;
    $active=0;
    $all=0;
    
    $sql="SELECT * FROM trace WHERE sub_cat_id_c='$id_c'";
    $result=query_select($sql);        
    //we check if there are one or more id_c - one or more traces for collected one item sub type
    $counter=0;
    while($rek=mysql_fetch_array($result))
    {
        $counter++;
        
        
    }
    echo "all ".$all=$counter;
    
    $counter=0;
    
    $sql.=" AND active=1";
    $result=query_select($sql);
    while($rek=mysql_fetch_array($result))
    {
        $counter++;
        
                
        
    }
    echo " active: ".$active=$counter;
    
    
    
    return array($active,$all); //returning a tuple with one item type size of active trace and all active and non active
    
}

//This for checkin trace active

//INSERT token trace

function insert_token_trace($date_started,$weight,$cat,$id_c) //transactions
{
      mysql_query("START TRANSACTION");
         
                     $IA1="INSERT INTO token_dynamic(date_started,weight_spare,category_spare) VALUES('$date_started','$weight',$cat)";
         
                        $a1=mysql_query($IA1)or mysql_error();                           
                      $last_token= mysql_insert_id() ; //here we need a backup function to check or do the collecting of last recent inserted token
            
                      
                      
                      
                        echo $last_token;
                       
                           
                        $IA2="INSERT INTO trace(sub_cat_id_c,token_dynamic_idtoken,active) VALUES('$id_c','$last_token','1')"; //we will be using only trace active to differentiate them
                     
                        $a2=mysql_query($IA2) or mysql_error();
         
                       
         
      
         
         //$sa4="DELETE barcode FROM barcode JOIN item ON Barcode.Item_id_item = item.id_item WHERE Barcode = ''"
         
         
                        if($a1 AND $a2)
                       {
                       mysql_query("COMMIT");
                       }
                        else {
                         mysql_query("ROLLBACK");
                            }
    
    
}

function deactivate_trace($idtrace,$id_c) //No checking if redundancy.Risky. We leave this for the error detecting functions for running system
{
    echo "ID_TRACE ".$idtrace;
    $sql="UPDATE trace SET active=0 WHERE sub_cat_id_c='$id_c' AND idtrace='$idtrace' AND active=1";
    $result=query_select($sql);
    
    if($result)
        echo "Deactivated";
    else 
        echo "Failed to deatcivate";
    
}