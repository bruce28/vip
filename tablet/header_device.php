<?php

/* 
 * IS used to define all ROOT functions. For system header that manages the flow of each of system module.
 */


$ROOT=array();

//FUNCTIONS
function pop_stack($name_var)  //gives the name of header device variable on top of stack want to read. Pseudo Stack
{
    $ROOT[0]['id_device'];
    $sql="SELECT * FROM session_ WHERE ".$name_var."=";
    
}

function push_stack($name_var,$value) //puts on top of stock particu;ar bariable
{
    
}