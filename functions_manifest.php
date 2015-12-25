<?php

/* 
 * functions for manifest modifications. Especcialy hot it is formated on displayed
 */


function manifest_visible($kind)
{
    switch($kind){
        case 1:
           $text="Not. Deprecated";
            break;
        case 2:
            $text="VISIBLE";
            break;
        default:
           $text="New type.";
            break;
        
    }
    return $text;
    
}


function manifest_dbi_get_att_sub_cat($id_c) //get sub cat return actual att
{
  $sql="select * from sub_cat WHERE id_c='$id_c'";
  $result=query_select($sql);
  
  $rek=mysql_fetch_array($result,MYSQL_BOTH);
  $att=$rek['atts'];
      echo $att;  
    return $att;
    
}

function manifest_dbi_get_att_name($atts) //get atts number value from sub_cat and return its real name from atts table
{
  $sql="select * from att WHERE id_att='$atts'";
  $result=query_select($sql);
  
  $rek=mysql_fetch_array($result,MYSQL_BOTH);
  $att=$rek['att'];
        
    return $att;
     
    
}



function manifest_dbi_get_att($att_name) //get atts number value from sub_cat and return its real name from atts table
{
  $sql="select * from att WHERE att='$att_name'";
  $result=query_select($sql);
  
  $rek=mysql_fetch_array($result,MYSQL_BOTH);
  $att=$rek['id_att'];
        
    return $att;
     
    
}

function manifest_dbi_get_number_elements_att() //used mostly for function that do dropdown list
{
     $sql="select * from att";
  $result=query_select($sql);
  $num=mysql_num_rows($result);
        
    return $num;
    
}

function manifest_dbi_number_elements_item_types()
{
     $sql="select * from item_type";
  $result=query_select($sql);
  $num=mysql_num_rows($result);
        
    return $num;
    
    
    
}

//item types functions


function manifest_dbi_get_item_type_sub_cat($id_c) //get sub cat return actual type item
{
  $sql="select * from sub_cat WHERE id_c='$id_c'";
  $result=query_select($sql);
  
  $rek=mysql_fetch_array($result,MYSQL_BOTH);
  $att=$rek['item_type'];
      echo $att;  
    return $att;
    
}

function manifest_dbi_get_item_type_name($id_type_name) //get sub cat return actual type item
{
  $sql="select * from item_type WHERE iditem_type='$id_type_name'";
  $result=query_select($sql);
  
  $rek=mysql_fetch_array($result,MYSQL_BOTH);
  $item_type_name=$rek['name_item_type'];
     
    return $item_type_name;
    
}