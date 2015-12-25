<?php

/**
 * @author gencyolcu
 * @copyright 2013
 */


function val_postal_no_white_sp($post_code)
{
   $s=45; 
   $post=array();
   $z=0;
   for($i=0;$i<$s;$i++)
   {
   
    if($post_code[$i]!=' ')
    {
     $post_code[$z]=$post_code[$i];
     $z++;
     //echo $post_code[$i];
    }
   
         
   } 
    
    //echo $post_code;
  return $post_code; 
}


?>