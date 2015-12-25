<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_cat($name_cat)
{
     $select_weight="SELECT * FROM item_has_cat WHERE id_item_cat='$name_cat'";
   $result_weight=mysql_query($select_weight) or die(mysql_error());
   $rek_wei=mysql_fetch_array($result_weight);
    return $weight=$rek_wei['cat'];
    
    
}

function get_weight_qtty($ref_sell,$name_cat)
{
   
   $waste_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat=";
   //$result_waste=mysql_query($waste_qtty);
   
   
   $select_weight="SELECT * FROM item_has_cat WHERE id_item_cat='$name_cat'";
   $result_weight=mysql_query($select_weight) or die(mysql_error());
   $rek_wei=mysql_fetch_array($result_weight);
   $weight=$rek_wei['weight'];
   $sum_waste_qtty=0;
 
   $item_type_qtty=$name_cat;
         
   $waste_qtty_query=$waste_qtty.$item_type_qtty;
         
   $result_waste=mysql_query($waste_qtty_query) or die(mysql_error());
   while($rek_waste=mysql_fetch_array($result_waste))
         {
           $sum_waste_qtty+=$rek_waste['qtty'];
             
         }
         $waste_qtty;
         $waste_bar_qtty=$rek['quantity'];
          return $waste_bar_qtty+=$sum_waste_qtty*$weight;
    
    
    

}

function get_waste_qtty($ref_sell,$name_cat)
{
   
   $waste_qtty="SELECT * FROM waste_quantity WHERE idtransaction_waste='$ref_sell' AND name_cat=";
   //$result_waste=mysql_query($waste_qtty);
   
   $sum_waste_qtty=0;
 
   $item_type_qtty=$name_cat;
         
   $waste_qtty_query=$waste_qtty.$item_type_qtty;
         
   $result_waste=mysql_query($waste_qtty_query) or die(mysql_error());
   while($rek_waste=mysql_fetch_array($result_waste))
         {
           $sum_waste_qtty+=$rek_waste['qtty'];
             
         }
         $waste_qtty;
         $waste_bar_qtty=$rek['quantity'];
          return $waste_bar_qtty+=$sum_waste_qtty;
    
    
    

}

function get_item_name($item_type)
{
    $sql_item_type="SELECT * FROM item,item_has_cat WHERE item.Item_has_cat_id_item_cat=item_has_cat.id_item_cat AND id_item_cat='$item_type' ";
    $result=mysql_query($sql_item_type) or die(mysql_error());
    $rek=mysql_fetch_array($result);
    return $rek['name'];
    
}

function add_db($sql)
{
	 
	 
   $result=mysql_query($sql) or die(mysql_error());
	return $result;
}

function show_concat_waste($ref_sell)
{
    
    mysql_connect('localhost','root','krasnal') or die(mysql_error());
    mysql_select_db('dbs3') or die(mysql_error());
  $customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
        . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' GROUP BY type_item ORDER By type_item";



//echo $ref_sell;
$reuse=array();

$cust=add_db($customer1);
$waste_barcode=array();
$waste_barcode_weight=array();
//echo "bf fetch";
while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //echo " in fetch ";
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
  $index=$rek['type_item'];
 // echo " <BR /> ";
   $waste_barcode[$index]+=$rek['quantity'];
   $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
   //echo '<tr>';
	//echo '<td>'.get_item_name($rek['type_item']).'</td>';
	// echo '<td>'.$rek["quantity"].'</td>';
	// echo '<td>'.$rek["category"].'</td>';
	//   echo '<td>'.$rek["pn"].'.</td>';
        //     	echo '<td>1</td>';
	//echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	//echo '</tr>';
         
         $cat=$rek['category'];
        $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
$waste_barcode[3];
$waste_barcode_weight[3];


$weee_reused_waste_qtty=array();    
    for($name_cat=0;$name_cat<62;$name_cat++)
    {
        if(($qtty=get_waste_qtty($ref_sell, $name_cat))>0)
        {
        echo "<tr>";
        echo "<td>";
   echo $qtty+$waste_barcode[$name_cat]; 
        echo " UNIT </td>";
        echo "<td>";
        echo get_item_name($name_cat);
        echo "</td>";
       // echo '<td>';
       // echo get_weight_qtty($ref_sell, $name_cat)+$waste_barcode_weight[$name_cat];
    //    echo "</td>";
    //    echo "<td>".$name_cat."</td>";
        echo  "</tr>"; 
        $sum_qtty=  get_weight_qtty($ref_sell, $name_cat);+$waste_barcode[$name_cat];
          $cat=get_cat($name_cat);
         $weee_reused_waste_qtty[$cat]+=get_weight_qtty($ref_sell, $name_cat);
         
        
        }
        else {
            $customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
             . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' AND type_item='$name_cat' GROUP BY type_item ORDER By type_item";
            
            $cust=add_db($customer1);
            while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { 
             $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
           
             if($rek['quantity']>0)
             {    
             $index=$rek['type_item'];
              $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
 // echo " <BR /> ";
           //$waste_barcode[$index]+=$rek['quantity'];
          // $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
           echo '<tr>';
              echo '<td>'.$rek["quantity"].' Unit</td>';
	    echo '<td>'.get_item_name($rek['type_item']).'</td>';
	 //   echo '<td>'.$waste_barcode_weight[$index]
         //   .'</td>';
	 //  echo '<td>'.$rek["category"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</tr>';
         
       //  $cat=$rek['category'];
      //  $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
     }
  
	  //$tab[$rek["id_test"]]+=1;
}  
    
    
}


    }
}

//This functions show this of waste barcode and waste quantity nm what. it just swaps the name of item with qtty
function show_concat_waste_swaped($ref_sell)
{
    
    mysql_connect('localhost','root','krasnal') or die(mysql_error());
    mysql_select_db('dbs3') or die(mysql_error());
  $customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
        . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' GROUP BY type_item ORDER By type_item";



//echo $ref_sell;
$reuse=array();

$cust=add_db($customer1);
$waste_barcode=array();
$waste_barcode_weight=array();
//echo "bf fetch";
while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { //changed from 1 
   $i++;  
   //echo " in fetch ";
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
  $index=$rek['type_item'];
 // echo " <BR /> ";
   $waste_barcode[$index]+=$rek['quantity'];
   $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
   //echo '<tr>';
	//echo '<td>'.get_item_name($rek['type_item']).'</td>';
	// echo '<td>'.$rek["quantity"].'</td>';
	// echo '<td>'.$rek["category"].'</td>';
	//   echo '<td>'.$rek["pn"].'.</td>';
        //     	echo '<td>1</td>';
	//echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	//echo '</tr>';
         
         $cat=$rek['category'];
        $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
  
	  //$tab[$rek["id_test"]]+=1;
}
$waste_barcode[3];
$waste_barcode_weight[3];


$weee_reused_waste_qtty=array();    
    for($name_cat=0;$name_cat<62;$name_cat++)
    {
        if(($qtty=get_waste_qtty($ref_sell, $name_cat))>0)
        {
        echo "<tr>";
        echo "<td>";
        echo get_item_name($name_cat);
        echo "</td>";
        echo "<td>";
   echo $qtty+$waste_barcode[$name_cat]; 
        echo " UNIT </td>";
        
       // echo '<td>';
       // echo get_weight_qtty($ref_sell, $name_cat)+$waste_barcode_weight[$name_cat];
    //    echo "</td>";
    //    echo "<td>".$name_cat."</td>";
        echo  "</tr>"; 
        $sum_qtty=  get_weight_qtty($ref_sell, $name_cat);+$waste_barcode[$name_cat];
          $cat=get_cat($name_cat);
         $weee_reused_waste_qtty[$cat]+=get_weight_qtty($ref_sell, $name_cat);
         
        
        }
        else {
            $customer1="SELECT waste_barcode.category,waste_barcode.weight,type_item,count(*) as quantity FROM transaction_waste, waste_barcode,item_has_cat Where waste_barcode.idwaste_barcode=transaction_waste.waste_barcode_idwaste_barcode "
             . "AND Item_has_cat.id_item_cat=waste_barcode.type_item AND ref_sell_number='$ref_sell' AND type_item='$name_cat' GROUP BY type_item ORDER By type_item";
            
            $cust=add_db($customer1);
            while($rek = mysql_fetch_array($cust,MYSQL_BOTH)) { 
             $i++;  
   //if($tab[$rek["id_test"]]<'1')
   //{
    //here we count unige barcode waste and add to array
           
             if($rek['quantity']>0)
             {    
             $index=$rek['type_item'];
              $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
 // echo " <BR /> ";
           //$waste_barcode[$index]+=$rek['quantity'];
          // $waste_barcode_weight[$index]=$rek['weight']*$rek['quantity'];
           echo '<tr>';
              
	    echo '<td>'.get_item_name($rek['type_item']).'</td>';
            echo '<td>'.$rek["quantity"].' UNIT</td>';
	 //   echo '<td>'.$waste_barcode_weight[$index]
         //   .'</td>';
	 //  echo '<td>'.$rek["category"].'</td>';
	  // echo '<td>'.$rek["pn"].'.</td>';
        //      	echo '<td>1</td>';
	 //echo '<td>'.$rek["sum_weight"].'</td>';
	// echo '<td>'.$rek["Name_sub"].'</td>';
	 echo '</tr>';
         
       //  $cat=$rek['category'];
      //  $reuse[$cat]+=$rek['weight'] * $rek['quantity'];
     //}
     }
  
	  //$tab[$rek["id_test"]]+=1;
}  
    
    
}


    }
}

//function checks if main table initialised for transaction
function check_init_transaction($ref_sell_waste)
{ 
    
    
    
    
    
}