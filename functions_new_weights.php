<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_site_has_cat_weight($site_id,$sub_cat)
{
    global $site_date_collection;
    
   $sql="SELECT * FROM site_has_cat WHERE Site_site_id='$site_id'";
    $result=query_select($sql);
    
    
    
    //$date="SELECT * FROM site WHERE site_id"
    
    
    
    while($rek=mysql_fetch_array($result,MYSQL_BOTH))
    {
        
       $sum_weight+=$rek['Quantity']*get_weight($rek['Sub_cat_id_c']); //this takes quantity stored in site_has_cat and recalculates it it takes new weight through new module of calculation
        //including standard weight and non standard
    }
    return $sum_weight;
}
