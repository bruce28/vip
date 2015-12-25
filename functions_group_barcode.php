<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$PREFIX_GROUP_STICKER="GRP"; //prefix that is used to detect group barcode


function detect_group_barcode($barcode,$PREFIX_GROUP_STICKER) //first compares barcode if this is a group prefix
{
    echo "detecting group0";
   echo  $group=strtoupper(substr($barcode,0,3));
    if(strcmp($PREFIX_GROUP_STICKER,$group)==0){
    echo "detected group sticker ".$group;
    return 1;}
    else
        return 0;
   
}

//if group detected check if is in the system

function check_group_barcode($barcode)
{
    echo $sql="SELECT * FROM group_barcode WHERE group_barcode='$barcode'";
    $result=query_select($sql);
         
    if(mysql_num_rows($result)>0)
    {
        echo "Group barcode in the system";
        return 1;
    }
    else 0;
}

function check_if_sold_group($barcode)
{
      echo $sql="SELECT * FROM group_barcode WHERE group_barcode='$barcode' AND details=1";
    $result=query_select($sql);
    if(mysql_num_rows($result)>0)
    {
        echo "Not yet sold";
        return 1;
        
    }
        
    }
    
function if_valid_barcode($barcode)
{
    $barcode2=substr($barcode,0,3);
    $barcode2=strtoupper($barcode2);
    if(strcmp($barcode2,'UNQ')==0 OR strcmp($barcode2,'DBS')==0 OR strcmp($barcode2,'FAU')==0)
            return $barcode;
    else {
        return 1;
        }
            
    
}



function extract_list($list)
{
    //this function will clear the list a bit and organise an output format lets strip in ;
    
    $replace=array();
    $replace[0]=" ";
    $replace[1]="\n";
            
    //$list=str_replace($replace[0], ";", $list); 
    
    
    
    return $list;
    
}

function proccess_string_barcode() //takes list of barcodes as a string and formats, removing white spacves. Giving as result number of barcodes recognised
{
    
}



 function initialize_group_barcode()
 {
     //connect_dbi();
     $group_barcode=$_POST['group_sticker'];
     $details='1';
     $reserved=$l_klient;
     
     echo $sql="INSERT INTO group_barcode(group_barcode,details,reserved) VALUES('$group_barcode','$details','$reserved')";//initialised by 1-ones
     $result=query_select($sql);
     if($result)
     {
         echo "Group barcode initialised";
        echo var_dump($result);
        echo $group_barcode_id=mysql_insert_id();
        return $group_barcode_id;  //after initialising we sent back only once a group barcode
     }
     echo var_dump($result);
 }
 

 
 function get_list($list)
 {
   $list=extract_list($list);  
   
   //return as array
   
   $list_returned=array();
   
   $number_of_barcodes=100;
   
   //$list_returned=$list;
   
   
   //$list_returned=implode(' ', array_slice(explode(' ', $list), 0, 1));
   
///$list_returned=getNWordsFromString($list);
   
$barcodes = explode(" ", $list);
//echo $barcodes[0]; 
//echo $barcodes[1];
   
   //return the barcodes
//   $list_returned=$list;
   return $barcodes; 
 }
 
 function set_individual_barcode($barcode,$group)
 {
     $barcode_individual=$barcode;
    echo  $group_barcode=$group;
   echo   $SQL="INSERT INTO barcode_individual(barcode_individual,group_barcode_idgroup_barcode) VALUES('$barcode_individual','$group_barcode')";
     
     $result=query_select($SQL);
     if($result)
     {
         $individual_id=mysql_insert_id(); //get last individual inser id for barcode
         echo "Genereted group for barcode :".$individual_id;
     }
     
     
 }
    
 function extract_group($barcode)
 {
     
     //we extract as particular group of items
     
     $item_type=$_POST['item_type']; //take weee_extension id, means particular item
    
    //we add here a query that will conver conversion item_type into weee cat
    
    $sql_cnv="SELECT * FROM weee_extension WHERE idweee_extension='$item_type'";
    $result_cnv=mysql_query($sql_cnv) or die(mysql_error());
    $rek=mysql_fetch_array($result_cnv);
        $item_type_cnv=$rek['weee_extension']; //this is id_item_cat connected to particular weee id_extension
        $name_ext=$rek['name_ext']; //name_ext is a name of particular group shall be counted and also shown on invoice
    
    
    //geting barcode details
    $check_item_cat="SELECT * FROM item_has_cat WHERE id_item_cat='$item_type_cnv'"; //we compare weee extension with a item cat id
    $result_check=mysql_query($check_item_cat)or die(mysql_error());
    $rek_check=mysql_fetch_array($result_check);
    $cat=$rek_check['cat']; //we pick up weight and category
    $weight=$rek_check['weight'];
     
     
     //end
     
     
     
     
     
     
     
     
     
     
     
     echo $sql="SELECT * FROM group_barcode INNER JOIN barcode_individual ON group_barcode.idgroup_barcode=barcode_individual.group_barcode_idgroup_barcode WHERE group_barcode='$barcode' AND details='1' ";
     $result=query_select($sql);
     
     
     
     while($rek=mysql_fetch_array($result,MYSQL_BOTH))
     {
         
         //here a check if is already sold
         
         
         if(check_if_barcode_individual_sold($rek['barcode_individual'])==0)
         {
             
         
         
         
         echo $rek['barcode_individual'];
         //get a first barcode from barcode individual
         $barcode=$rek['barcode_individual'];
         //insert waste barcode
         echo "</BR></BR>";
         
         
         
         
        echo $insert="INSERT into waste_barcode(Barcode_waste,category,weight,type_item,stock_out,type_item_cnv,site) VALUES('$barcode','$cat','$weight','$item_type_cnv',1,'$item_type','0')";
         $result1=query_select($insert);
      
         
         $last_barcode=mysql_insert_id();
         
         //transaction details
         
   
    
    $invoice_id=$_SESSION['inv_id_generated'];
    $ref_sell=$_SESSION['ref_sell_number'];
    $buyer_id=$_SESSION['site_id_s_s'];

         
         
         //insert transaction
         $batch_date=$_SESSION['batch_date1'];
      
         echo  $transaction="INSERT INTO transaction_waste(ref_sell_number,buyer_id,finished,invoice_waste_idinvoice_waste,waste_barcode_idwaste_barcode,date_sold) VALUES('$ref_sell','$buyer_id','1','$invoice_id','$last_barcode','$batch_date')";
         $result2=query_select($transaction);
        echo "DONE ".$rek['barcode_individual'];
         }
     }
     //here close status of barcode group. Set it sold 2
     
     
 }
 
 function check_if_barcode_individual_sold($barcode_individual)
 {
     $sql="SELECT * FROM waste_barcode WHERE Barcode_waste='$barcode_individual'";
     $result=query_select($sql);
     
     if(mysql_num_rows($result)>0)
         return 1;
     else return 0;
     
     //mysql_fetch_array($result);
     
     
             
     
 }
 
 function update_group_sold($barcode)
 {
     $sql="UPDATE group_barcode SET details=2 WHERE group_barcode='$barcode'";
     query_select($sql);
     
 }