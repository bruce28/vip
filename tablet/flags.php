<?php

/* 
 *HERE ALL FLAGS INCLUDED FOR API 1 and 2 Stage
 */

//$sql_load="SELECT * from sub_cat WHERE kind=2 ORDER BY id_c ASC";
$sql_load="SELECT * from sub_cat WHERE kind=2 ORDER BY Name_sub ASC";

$TOKEN_STD=1; // FLAG defines the value of token describing STANDARD ones. Those identify items on manifest that not yet changed or those new ones. N-S (Not standard ones) / O-S (Old stock)


//MANIFEST
$SIZE_OF_MANIFEST=0;  //This variable is used to store the items of sub_category items on manifest. Dependent VISIBLE, ALL, User-defined


$FLAG_VISIBLE;


$SIZE_VISIBLE=0;
$SIZE_VISIBLE_AND_STANDARD=0;
$SIZE_VISIBLE_AND_ACTIVE=0;



//FIRST LEVEL API FLAGS



//JUST 3 VALUES IT STORES Not set, set or new one(2)
$FLAG_SITE_PICKED_UP=0;  //DO not picked up 

//LAST ITEM ADDED. NO need to store them all the time. TO read by show_add()

$FLAG_QTTY_ADDED_LAST=0;
$FLAG_QTTY_SUB_LAST=0;
$FLAG_QTTY_BULK_ADD_LAST=0;
$FLAG_LAST_SUB_CAT=0;

//CONSTANS CAN BE SEPARATE FILE
//CONSTANS DEphp define constans
//DEFINED FOR MANIFEST_REG STATE

if(!defined('MANIFEST_RUNNING'))    
    define("MANIFEST_RUNNING", 6);
if(!defined('MANIFEST_NOT_FINISHED')) 
define("MANIFEST_NOT_FINISHED",0);
if(!defined('MANIFEST_FINISHED')) 
define("MANIFEST_FINISHED",1);  
if(!defined('MANIFEST_INITIALISED')) 
define("MANIFEST_INITIALISED",2);  //the state of being initialised by its generation barely
if(!defined('MANIFEST_IMPORTED_TO_ROOT')) 
define("MANIFEST_IMPORTED_TO_ROOT",10);
if(!defined('MANIFEST_READY_TO_IMPORT')) 
define("MANIFEST_READY_TO_IMPORT",9);



$FLAG_MANIFEST_SET=10; //how many last manifest are read, to check if state of them is correct

$FLAG_MANIFEST_UNQ_NUMBER; //this is global for keeping genereted manifest

$FLAG_MANIFEST_REG_STATE; //global manifest state ; const set originnaly at initialize mani_reg

$FLAG_MANIFEST_REG; //this keeps id manifest reg

$FLAG_LAST_CLICK; //here we utilise the click event ident 1 is plus, 2minus 3, is add qtty


$FLAG_QTTY_NO_DELAY;