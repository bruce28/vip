<?php

/* 
 * This function will include all SESSION variables required for correct work of tablet. Including local SESSIONS and function loading/unloading them when necessery
 */

//SESSION VARIABLES

$_SESSION['id_device']; //root variable, identifying whole process of communication, processing, session mentain and recovery if needed. Uniqu idetifier





$_SESSION['MANIFEST_REG_ID']; // to load from FLAG_MANIFEST_REG, that refers to a variable set in 2 level after init and gen successful. is destoyed by logout with all session variables

$_SESSION['MANIFEST_UNQ_NUMBER']; //this is original manifest unq number used to define new manifest

//3 most importand wariables of 1 level
$_SESSION['CUSTOMER_ID'];

$_SESSION['STICKER_ID']; // if this 2 are set up than level api 1 is true 

$_SESSION['LEVEL_1']; //

$_SESSION['SITE_ID'];



$_SESSION['DRIVER'];

$_SESSION['MOD_DATE'];

//SESSION FUNCTIONS



//here needed a interfaces in between sessions and local/flags variables

