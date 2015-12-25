<?php
include 'header_valid.php';
require_once 'functions_new_weights.php'; //prototype of get_site_has_weight
//require_once 'tablet/second_lvl_api.php';
$_SESSION['site_has_cat_id'];
/**
 * Description of functions_calculation_weights_pre_processed
 *
 * @author dbs3
 */

//lets try to connect throuhl OO MSQLI


mysql_connect("127.0.0.1","root","krasnal");
mysql_select_db("dbs3");

/**  functions takes site_has_cat_id paramater and decides to read local passed or one stored ion session. A wrapper basicly
 * 
 * @param type $site_has_cat_id
 */
function read_site_has_cat_id($site_has_cat_id)
{
    if(empty($site_has_cat_id))
    {
        return get_site_has_cat_id_session(); 
    }
    else
    {
       return $site_has_cat_id; 
    }
    
}

function set_session_site_has_cat_id($site_has_cat_id)
{
    $_SESSION['site_has_cat_id']=$site_has_cat_id;    
}

function get_site_has_cat_id_session()
{
   return $_SESSION['site_has_cat_id']; 
    
}

function detect_pre_processed_items($site_id) //detect by site id
{
    
    if($site_id==0)
    $sql="select Name_sub, batch_date,site_ref_number,Quantity,site_has_cat.id as idd,Site_site_id,post_code from sub_cat INNER JOIN site_has_cat ON site_has_cat.Sub_cat_id_c=sub_cat.id_c "
            . "INNER JOIN site on site.site_id=site_has_cat.Site_site_id "
            . "INNER JOIN origin on origin.origin_id=site.Origin_origin_id "
            . "INNER JOIN weight ON weight.id=sub_cat.Weight_id WHERE weight=1 AND Quantity>0 ";
    else
         $sql="select Name_sub, batch_date,site_ref_number,Quantity,site_has_cat.id as idd,Site_site_id from sub_cat INNER JOIN site_has_cat ON site_has_cat.Sub_cat_id_c=sub_cat.id_c "
            . "INNER JOIN site on site.site_id=site_has_cat.Site_site_id "
            . "INNER JOIN weight ON weight.id=sub_cat.Weight_id WHERE weight=1 AND Quantity>0 AND Site_site_id='$site_id'";
    $result=mysql_query($sql) or die(mysql_error());
    return $result;
}

/**  Detects sites and atts that needs to be processed here passes site_has_cat_id starts
 * 
 * @param type $result
 * @return type
 */
function draw_detected($result)
{
    $button_loop_counter=0; //an element that is assigned to button element name 
     
    echo "<table id='table_detected' class='ui-widget-content' ><thead><td></td></thead><tbody>";
    while($rek=mysql_fetch_array($result))
    {
         $site_has_cat_id=$rek[4]; //site_has_cat_id 
        $button_loop_counter++;
        //show all
        echo '<tr>';
        echo '<td><p>';
        echo strtoupper($rek[0]);
        echo '</p></td>';
        
         echo '<td> - ATT: '; 
        echo find_att($site_has_cat_id);
        echo '</td>';
        
        echo '<td><p> - Collected from ';
        echo $rek[6];
        echo '</p></td>';
        echo '<td><p> on ';
        $site_reference_number=$rek[2];
       echo $rek[1];
        echo '</p></td>';
        echo '<td><p>';
       
        $site_id=$rek[5];  //site id
        
        echo '<form id="investigate" action="pre_processed_good_process.php" method="POST">';
        echo '<input type="hidden" name="site_id'.$button_loop_counter.'" value="'.$site_id.'">';
        echo '<input type="hidden" name="site_has_cat_id'.$button_loop_counter.'" value="'.$site_has_cat_id.'">';
        echo '<input type="submit" name="process'.$button_loop_counter.'" value="Investigate">';
        echo '</form>';
        echo '</p></td>';
        
        
         echo '</tr>';
    }
    echo '</tbody></table>';
    //or $button_llop_counter
    return mysql_num_rows($result); //returns ho many rows rturned how many item draw
    
}

function if_investigate_request($num_of_inv)
{
    //generate identifier for each item to be consider
    for($i=0;$i<=$num_of_inv;$i++)
    {
        $name="process".$i;    
    
    
         if(isset($_POST[$name]))
          {
              $site_has_cat_id=$_POST['site_has_cat_id'.$i];
              $site_id=$_POST['site_id'.$i];
              
             // echo "SITE HAS CAT ID: ".$site_has_cat_id;
              
              return array($site_has_cat_id,$site_id);
          }
    }
    
}


function draw_detected_id($site_has_cat_id)
{
    /*
    echo <<<FORM
    
    <h2>Detected</h2>
    
    
FORM;
    
    
    */
    
}

function create_new_item_processed($site_has_cat_id)
{
    

  echo <<<FORM1
    
    <table>
    <form action="pre_processed_good_process.php" method="POST">
    <input type="text"  name="post_processed" value="" placeholder="E.g: Brass, cooper..">
    
    
    
    
    
FORM1;
  
  
  
  echo '<input type="hidden" name="site_has_cat_id" value="'.$site_has_cat_id.'">';
  
    echo <<<FORM2
 
    <input type="submit" name="create_post_processed" value="Add">
    </form>
    </table>
  
FORM2;
  
    
    
    
    
    
    
    
            
           
    
}

/**
 * Functions insert post_processed items 
 */

function insert_goods()
{
    if(isset($_POST['create_post_processed']))
    {   
       // echo "Inert";
    $name=$_POST['post_processed'];
         if(!empty($name))
         {
              $sql="INSERT INTO post_processed_goods(post_processed_goods_name) VALUES('$name')";
    
              $result=query_select($sql);
         }
    }
    else ;//echo "Non";
    
    
    
}


function get_goods()
{
    
   // echo "Goods: </BR>";
    $sql="SELECT * FROM post_processed_goods";
    $result=query_select($sql);
   return $result;
}


function 
show_goods($result,$site_has_cat_id)
{
    
  //  echo '<h2> Specify processed goods collected </h2>';
  $i=0;  
  
  echo "Sitehascat_id: ".$site_has_cat_id;
  
  echo '<table class="ui-widget-content" id="table_specifics"><form action="pre_processed_good_process.php" method="POST">';   //here we generate form as it goes, since we want to process this values
  while($rek=mysql_fetch_array($result))
  {
      $i++;
      echo '<tbody>';
      echo '<tr>';
      
    // echo '<td>';
       $post_process_id=$rek[0];
     // echo '</td>';
       echo '<td>';
       echo $rek[1];
        echo '</td>';
        
        //processing database output for checkin a current state for goods in pre 
        
        
          $post_id=$post_process_id;
        $result_look=dbi_look_pre_process($site_has_cat_id, $post_id);
        $DETECT_PROCESSED=0;
        $rek=mysql_fetch_array($result_look,MYSQL_BOTH);
        if($rek) //if is detected as process3ed
        {
            
         $DETECT_PROCESSED=1;   
        $dbi_weight=$rek['weight_post_processed'];
        $dbi_revision=$rek['review_nr'];
        $dbi_stream_waste=$rek['waste_stream'];
        }
        else {$dbi_stream_waste=0;}
        
        
        
        
        
        echo '<td>';
        echo '<input type="text" name="weight'.$i.'" placeholder="Weight processed..">';
       echo '<input type="hidden" name="post_id'.$i.'" value="'.$post_process_id.'">';
        echo '</td>';
        echo '<td>';
        
        
        
        
        //function that draws dropdown list of stream waste
        
        
        draw_list_waste_stream($i,$dbi_stream_waste);
        
        //name=stream as option
        echo '</td>';
        echo '<td>';
      //  $site_has_cat_id=$_POST['site_has_cat_id'];
       echo  '<input type="hidden" name="site_has_cat_id" value="'.$site_has_cat_id.'">';
         echo '<input type="submit" name="add_weight'.$i.'" value="Process" >';
         echo '</td>';
        echo '<td>';
        
      
        if($rek)
        {
        echo 'Currently hold '.$dbi_weight.' kgs from last revision on '.$dbi_revision; //or none. Never processed. Not processed yet
        }
        else { echo 'None. Not Yet received'; }
      
        echo '</td>';
      echo '</tr>';
  }
  //here we add leftovers
   $weight_nett=dbi_check_nett_weight($site_has_cat_id);
 $weight_gross=dbi_get_weight_gross($site_has_cat_id);
 echo '<tr><td colspan="4"></td><td>Waste materials '.  get_totals_post_process($weight_nett, $weight_gross);
  echo ' kgs</td></tr>';
  echo '</tbody>';
  echo '</form></table>';  
  
$weight_nett=dbi_check_nett_weight($site_has_cat_id);
 
  
//  echo '</BR>=====================================================================</BR>';
  
  echo "Total Nett Weight: ". $weight_gross=dbi_get_weight_gross($site_has_cat_id);
 //  echo "</BR>Waste materials ".  get_totals_post_process($weight_nett, $weight_gross);

  echo "</BR>STATUS: Running";
  echo "</BR>Last Revieved: ";
  echo '<a href="pre_processed_good_process.php?close=2&site_has_cat_id='.$site_has_cat_id.'">Done</a>';
  
  
  
   echo '</BR>=====================================================================</BR>';
  close_investigation();
}


function close_investigation()
{
    //here we set get close go out without doing anythin just reset session
    
     echo "</BR></BR>";
            echo '<a href="pre_processed_good_process.php?close=1">  Close</a>';
     echo '<a href="print.php?post_process=1&site_has_cat_id='.$site_has_cat_id.'">Print</a>';
}


function nett_assess($site_has_cat_id)
{
   //  =====================================================================</BR>
    echo <<<NETT1
    
  
     NETT weight: 
NETT1;
    $site_details=get_site_details($site_has_cat_id);
    $post_code=$site_details[0];
    $collection_date=$site_details[1];
    $driver=$site_details[2];
    echo '<p>Collection: '.$site_has_cat_id.', from: '.$post_code.' on '.$collection_date.' by '.dbi_get_user($driver).'<p>';
    echo '<p>ATT:'.  find_att($site_has_cat_id).'</p>';
    
    if($weight_nett=dbi_check_nett_weight($site_has_cat_id)) //checking if nett is set already
    {
        echo "Nett Weight already set. ".$weight_nett." kgs";
    }
    else
    {
    echo <<<NETT2
    <form action='pre_processed_good_process.php' method='POST'>
    <input type="text" name="nett_weight" placeholder="weight.." >
        
NETT2;
        
   echo '<input type="hidden" name="site_has_cat_id" value="'.$site_has_cat_id.'">';
   
   echo <<<NETT3
    <input type="submit" name="nett_submit" value="Set">
    </form>
  
</BR>
    
NETT3;
    }
    return $weight_nett;
    
}

/**  Functions searches deliveries to get att ticket number, based on the reference to site_has_category id 
 *   of particular item.             
 */

function find_att($site_has_cat_id)
{
  $sql="SELECT att_num FROM site INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id"
          ." INNER JOIN delivery on delivery.Site_site_id=site.site_id WHERE id='$site_has_cat_id' and Trans_Category_Category_id='19'";
  
  $result=query_select($sql);
   $rek=mysql_fetch_array($result); 
return $rek[0];
   
}


function draw_list_waste_stream($i,$dbi_stream_waste)
{
    $sql="SELECT * FROM item_type";
    $result=query_select($sql);
    //$num_streams=mysql_num_rows($result);
    
  //echo "DBI STREAM WSSTE".$dbi_stream_waste;
    
    echo '<select class="select" name="stream'.$i.'">';
    
   while($rek=mysql_fetch_array($result))
   {
    $i++;
    if($dbi_stream_waste==$rek[0])
        echo '<option value="'.$rek[0].'" selected >'.$rek[1].'</option>';
    else
    echo '<option value="'.$rek[0].'">'.$rek[1].'</option>';
   }
    echo '</select>';
    
}



/**  It initialize if not or updates the particular postprocess good in pre_process table. We call it processing
 * 
 * 
 */

function process_pre_processed_items($site_has_cat_id)
{
    //show all items processed now
    //show what is availible in post_process
    
    //than write to pre process one by one if not there initialise
    
    //site_has_cat will be unique here
    
    //generator
    
    for($i=0;$i<=mysql_num_rows(query_select("SELECT * FROM post_processed_goods"));$i++)
    {
    $name="add_weight".$i;
    $name_weight="weight".$i;
    $name_stream="stream".$i;
    $name_post_id="post_id".$i;
    
    if(isset($_POST[$name]))
    {
        $weight=0;
        $stream=$_POST[$name_stream];
        $weight=$_POST[$name_weight];
        $post_id=$_POST[$name_post_id];
        echo "Processing ".$i." ".$stream;
        echo " weight ".$weight;
        echo "post_id :".$post_id;
        
        modify_pre_process($site_has_cat_id,$post_id,$weight,$stream);
        //or we add function processing here.better
        //return array(); //we return this array set for insert
    }
    }
    
}

 
function modify_pre_process($site_has_cat_id,$post_id,$weight,$waste_stream)  //it gets unique pre processed item type id and post processed result goods
{
    //one post process item can be assigned to one site_has_vat. if is there than go revision
    
    //find
    
    
  $result=dbi_look_pre_process($site_has_cat_id,$post_id);
   
    $num=mysql_num_rows($result);
    echo "Nums: ".$num;
    
    if($num==0)  //if post processed good not yet defined in pre processed table than add first time rev 0
    {
      
        if(!empty($weight))
        dbi_write_pre_process($site_has_cat_id, $post_id, $weight, $waste_stream);
        
    }
    else if($num==1)
    {
        //if exist call revision
        $revision=search_if_revision($result);
        if($revision==0)
        {
         echo "First revision";
           if(!empty($weight)) //revision cant be done if weight is empty
     dbi_update_pre_process($site_has_cat_id, $post_id, $weight, $waste_stream);
        }   
     else if($revision>0)
     {
         echo "This is revision number".$revision;
     }  
        
    }   
    else
        echo "error. critical. contact admin";
    
    
}

function search_if_revision($result)
{
    $rek=mysql_fetch_array($result,MYSQL_BOTH);
    $review=$rek['review_nr'];
    return $review;   
}

function dbi_write_pre_process($site_has_cat_id,$post_id,$weight,$waste_stream)
{
    
    $date_processed=date("Y-m-d H:i:s");
    
     echo $sql="INSERT INTO pre_processed(pre_processed,site_has_cat_id,post_processed_goods_idpost_processed_goods,weight_post_processed,"
            . "category_pre_processed,date_processed,review_nr,waste_stream) VALUES('0','$site_has_cat_id','$post_id','$weight','0','$date_processed','0','$waste_stream')";
        $result=query_select($sql);
    return $result;
}


function dbi_get_weight_for_item($site_has_cat_id,$post_id)
{
    $sql="SELECT weight_post_processed FROM pre_processed WHERE site_has_cat_id='$site_has_cat_id' AND post_processed_goods_idpost_processed_goods='$post_id' ";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    return $rek[0];
}

function dbi_update_pre_process($site_has_cat_id,$post_id,$weight,$waste_stream)
{
    //here we modify that function so that we can check if is there
    
    $curent_item_weight=  dbi_get_weight_for_item($site_has_cat_id,$post_id);
    
    if(!empty($curent_item_weight))
    {
        $weight_increment=$curent_item_weight+$weight;
        $weight=$weight_increment;
        
    }
    
 echo   $update="UPDATE pre_processed SET weight_post_processed='$weight', waste_stream='$waste_stream' WHERE site_has_cat_id='$site_has_cat_id' AND"
            . " post_processed_goods_idpost_processed_goods='$post_id' ";
    $result=query_select($update);
    return $result;
}

function dbi_look_pre_process($site_has_cat_id,$post_id )
{
    $sql="SELECT * FROM pre_processed WHERE site_has_cat_id='$site_has_cat_id' AND post_processed_goods_idpost_processed_goods='$post_id'";
    $result=query_select($sql);
    return $result;   
}
/**  Functions gives an array of results. Input taken from dbi SITE,SITE_HAS_CAT,ORIGIN,DELIVERY
 * 
 * @param type $site_has_cat_id
 * @return array(collection_details)
 */
function get_site_details($site_has_cat_id)
{
$sql="select * from site INNER JOIN delivery ON site.site_id=delivery.Site_site_id "
            . " INNER JOIN site_has_cat ON site_has_cat.Site_site_id=site.site_id "
            . " INNER JOIN origin ON site.Origin_origin_id=origin.origin_id"
            . " WHERE site_has_cat.id='$site_has_cat_id'";
    
    $result=query_select($sql);
    $rek=mysql_fetch_array($result,MYSQL_BOTH);
    return array($rek['post_code'],$rek['batch_date'],$rek['picker1']); //return an array of result. To nett weight details 
    //return array();
}


//must be moved to main system functions
function dbi_get_user($user_id)
{
    $sql="SELECT * from user_2 where id_user='$user_id'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result,MYSQL_BOTH);
    return $rek['login'];
}

function dbi_get_all_weight_site($site_id)
{
    $sql="SELECT Sub_cat_id_c,Quantity FROM site_has_cat WHERE Site_site_id='$site_id'";
    while($rek=query_select($sql)) //calculate evey sub_cat ids times qtty and get weights throu new calculation module
    {
        
        
    }
    
    
}

function dbi_check_nett_weight($site_has_cat_id)
{
    $sql="SELECT * FROM nett WHERE site_has_cat_id='$site_has_cat_id'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    return $rek[1];
    
}

function dbi_set_nett_weight($weight,$site_has_cat_id)
{
    $sql="INSERT INTO nett(weight,site_has_cat_id) VALUES('$weight','$site_has_cat_id')";
    $result=query_select($sql);
    return $result;
    
}

function get_totals_post_process($weight_nett,$weight_gross)
{
    return $weight_nett-$weight_gross;
}


function dbi_get_weight_gross($site_has_cat_id)
{
    $sql="SELECT SUM(weight_post_processed)FROM pre_processed WHERE site_has_cat_id='$site_has_cat_id'";
    $result=query_select($sql);
    $rek=mysql_fetch_array($result);
    return $rek[0];
}

/**  Function closes processing of particular case
 * 
 */

function close_processing_post()
{
   if($_GET['close']==1)
   {
     //  echo "Site closed";
      session_unset($_SESSION['site_has_cat_id']);
       
   }
   if($_GET['close']==2)
   {
     //  echo "Site closed";
       $site_has_cat_id=$_GET['site_has_cat_id'];
       
       
       dbi_set_done_status($site_has_cat_id);
      session_unset($_SESSION['site_has_cat_id']);
       
   }
   
    
}

function dbi_set_done_status($site_has_cat_id)
{
    $sql="UPDATE pre_processed SET status=1 WHERE site_has_cat_id='$site_has_cat_id'";
    $result=query_select($sql);
    
    
    
    
}

/** Function draws a form for att search
 * 
 * 
 * 
 */
function att_search()
{
      echo '<div class="ui-widget">';
      echo '<form id="atts" action="pre_processed_good_process.php" method="GET">';
      echo '<label for="atts">ATTS: </label>';
     
      
      
      echo '<input type="text" name="att" id="atts">';
      echo '<input type="submit" name="atts_sumbit" value="Search">';
      echo '</form>';
      echo '</div>';
}


/** Function detects and process GET array searching for att send by form. It makes call for search_att_in_pre_process
 * 
 * @return type
 * 
 */

function get_process_att()
{
   // echo print_r($_GET);
    if(!empty($_GET['att']))
    {
        echo "ATT detected";
        echo $att=$_GET['att'];
        $site_has_att_id = search_att_in_pre_process($att);
        return $site_has_att_id;
    }
}
/**  It returns item id
 * 
 * @param type $att
 * @return site_has_cat_id
 * @todo We need to check where is a bug. Since it returns wrong site_has_cat_id
 *       I think this is. Or the problem may be that systems show wrong att on the sheet 
 *       The solution: It's in none-assignemnt or relation in between att delivery and sub_cat_id
 *       It's fixed by adding a straight mixed non ferrous id_c in search querry    
 *  */          
function search_att_in_pre_process($att)
{
   $sql="SELECT id FROM site  
INNER JOIN delivery on delivery.Site_site_id=site.site_id 
INNER JOIN site_has_cat ON site.site_id=site_has_cat.Site_site_id
WHERE att_num='$att' AND Quantity=1 AND Trans_Category_Category_id='19' AND Sub_cat_id_c='63'"; 
   $result=query_select($sql);
   $rek=mysql_fetch_array($result);
    return $rek[0];
}

function get_if_site_id_is_qtty_one($site_has_cat_id)
{
    $sql="SELECT qtty FROM site_has_cat WHERE id";
    
}