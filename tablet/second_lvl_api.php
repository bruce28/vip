<?php
include 'header_mysql_tablet.php'; //mysql connection and query functions
include 'flags.php'; //include all needed FLAGS


/*
 *  
 * Functions for second mani level
 */

//Error handling and raport functions

function check_result_set($result)
{
    //switch - call an event to handle them
    
    
    
}

//STANDAR WEIGHTS

function get_standard_weight($id_c)
{
    $sql="SELECT * FROM weight INNER JOIN sub_cat ON weight.id=sub_cat.Weight_id WHERE id_c='$id_c'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result,MYSQL_BOTH);
    return $rek['weight'];  //cannt be possible, ever to return the value of a two or more element set. NEVER
}

//END


//There is a need to modify this functions for additional parameter active 0 or 1, that way we can see if there are any traces that are not active. and accordingly
//this helps use to follow the trace stack

function get_trace($id_c) //function takes as argument a value of sub_cat and returns valid token from trace
{
    $sql="SELECT * FROM trace where sub_cat_id_c='$id_c' AND active=1";  //we add active=1 to check if there is active trace
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek['token_dynamic_idtoken'];
    //neds checking if more than 2 result. This must be error raporting system. One active possible for one sub_cat at a time
}
function get_token($token) //functions get valid token for an active sub item and returns active weight
{
    $sql="SELECT * FROM token_dynamic where idtoken='$token'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek['weight_spare'];
    
}

function get_token_category($token) //functions get valid token for an active sub item and returns active weight
{
    $sql="SELECT * FROM token_dynamic where idtoken='$token'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek['category_spare'];
    
}


function check_trace($id_c) //function barely checks if trace is availible, returns token if yes, 0 value if not
{
       if(($token=get_trace($id_c))==0)
       {
         return 0;  
       }
       else 
           return $token; 
}

function get_weight($id_c)  //functions if trace not availible returns standard weights, if availible returns weights from tokens
{
    if(get_trace($id_c)==0) //if trace is empty that means assess standard weights
    {
      return get_standard_weight($id_c);
    }
    else
    {
      $weight=get_token(get_trace($id_c));  
      return $weight;
    }
    
}


function visible($kind)
{
    if($kind==2)
    return "V";
}


//PROTOTYPES

function get_active_trace($id_c)
{
    $sql="SELECT idtrace FROM trace WHERE active=1 and sub_cat_id_c='$id_c'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[0]; //MYSQL BOTH everywhere or not?! Remember this can be more than one value set, possibly
}

function check_active_token()
{
    
    
}

function standard($token)
{
   global $TOKEN_STD; 
   if($token==0) 
   return "OS";
   else if($token==$TOKEN_STD)
       return "S";
   else
       return $token;
}

function check_period_calculated() //thios function checks if calculations were made on a particular period this must be checkd if non standard sub categories
{
    
}
//END OF PROTOTYPES

function show_token_list($token)
{
    $sql="SELECT * From token_dynamic WHERE idtoken='$token'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result,MYSQL_BOTH);
    return array($rek['date'],$rek['date_started']);
}


function show_full_items_list_all_stock()
{
    
connect_dbi();

$sql="SELECT * from sub_cat";









$result=query_selecti($sql);
$counter_grid=1;
while($rek=mysqli_fetch_array($result,MYSQL_BOTH))
{
    $counter_grid++;
       
   if(($counter_grid%3==0))
   echo '<div class="ui-block-c">'; 
   else if($counter_grid%3==1)
   echo '<div class="ui-block-a">';
   else 
   echo '<div class="ui-block-b">';

   echo $rek['id_c']." ".$rek['Name_sub']." ".visible($rek['kind'])." ".  standard($rek['token_dynamic_idtoken'])." ".show_token_list($rek['token_dynamic_idtoken'])[1];
   
   echo '</div>';
    
}
        
        
}



//FUNTION DUPLICATE OF SHOW FULL_ITEMS_LIST_ALL_STOCK

function construct_table()
{
    
connect_dbi();

$sql="SELECT * from sub_cat";


$result=query_selecti($sql);
$counter_grid=1;
while($rek=mysqli_fetch_array($result,MYSQL_BOTH))
{
    $counter_grid++;
       
   if(($counter_grid%2==0))
   echo '<div class="ui-block-a">'; 
   else if($counter_grid%2==1)
   echo '<div class="ui-block-b">';
   

   echo $rek['id_c']." ".$rek['Name_sub']." ".visible($rek['kind'])." ".  get_weight($rek['id_c'])." kgs ";
  echo "<div data-role='controlblock' data-type='horizontal'>";
  echo "<div data-role='fieldcontain'>";
   echo '<input type="submit" value="+" data-role="button" data-inline="true">';
    echo '<input type="button" value="-" data-inline="true">';
     echo '<input type="text" value="" data-inline="true" data-mini="true">';
     echo "</div>";
     echo "</div>";
   echo '</div>';
    
}
        
        
}

//END OF DUPLICATE OF SHOW FULL_ITEMS_LIST_ALL_STOCK



//NEW FUNCTION THAT GIVES INTERACTIVE FUNCTION CONSTRUCT TABLE THAT ACTUALLY USES GRIP ELEMENT AS ITS PARENT THOU

function construct_table_draw($sql_load)
{
    //here we get all parameters needed to set a size of manifests
    
    $PARAMETER="true";//just something
    get_size_of_manifest($PARAMETER); //yes here only once. Lets change it
    //ok no global db cause before connect local db glob
connect_dbi();


//here this query should be prepered and keep as one global passed to functons. Reference add to db needs to read first counter

//* $sql="SELECT * from sub_cat ORDER BY id_c DESC";


$sql=$sql_load;

$NUM_DRAW=0;

$result=query_selecti($sql);
$counter_grid=1;
while($rek=mysqli_fetch_array($result,MYSQL_BOTH))
{
    //here shall be checked counter_grid and a Size_of_manifest if any discrepancies than communicate. Serious error. This means that what is visible on manifest
    //is different of that what was logicly received from manifest size function that is the main one needes for calculation
    $counter_grid++;
    $NUM_DRAW++; //This variable is local to draw function and is used to get ordered row in table   
    $rcvd_qtty=  qtty_rcvd_manifest_counter_no_delay(extract_session_manifest_reg(), 
            $rek['id_c']);
    $sub_cat_item_name=$rek['Name_sub']; //this is name of subcategory.
    $placeholder_sub_cat=$sub_cat_item_name;
    $placeholder_sub_cat.="...QTTY...";
    

   if(($counter_grid%2==0))
   echo '<div class="ui-block-a">'; 
   else if($counter_grid%2==1)
   echo '<div class="ui-block-b">';
  //was #manifest
      echo '<form action="" id="manifest.php " method="POST" data-ajax="true" data-prefetch="true">' ;
   
  echo '<p data-inline="true">';
   echo $rek['id_c']." ".$rek['Name_sub']." ".visible($rek['kind'])." ".  get_weight($rek['id_c'])." kgs ";
   echo ' QTTY: '.$rcvd_qtty.' </p>';
  echo "<div data-role='controlblock' data-type='horizontal'>";
  echo "<div data-role='fieldcontain'>";
  echo '<input type="hidden" name="num_sub_cat_un" value="'.$rek['id_c'].'">'; //this hidden variable is used to generate universal post sub_category number and send it
   
  echo '<input type="hidden" name="no-delay" value="'.$rcvd_qtty.'">'; //temoporary to send qtty without delay
  echo '<input type="submit" value="+" name="plus'.$NUM_DRAW.'" data-role="button" data-transition="flip">';
    echo '<input type="submit" value="-" name="minus'.$NUM_DRAW.'" data-role="button">';
     echo '<input type="text" name="qtty'.$NUM_DRAW.'" value="" placeholder="'.$placeholder_sub_cat.'"  >'; 
     echo "</div>";
     echo "</div>";
   echo '</div>';
   
   echo '</form>';
    
}
        
        
}
//END OF CONSTRUCT_TABLE_DRAW




//Modifieed for table organisation
function construct_table_draw_table($sql_load)
{
    //here we get all parameters needed to set a size of manifests
    
    $PARAMETER="true";//just something
    get_size_of_manifest($sql_load); //yes here only once. Lets change it
    //ok no global db cause before connect local db glob
connect_dbi();


//here this query should be prepered and keep as one global passed to functons. Reference add to db needs to read first counter

//* $sql="SELECT * from sub_cat ORDER BY id_c DESC";


$sql=$sql_load;

$NUM_DRAW=0;
 echo '<table data-filter="true">';
$result=query_selecti($sql);
$counter_grid=0;
echo "<tr>";
while($rek=mysqli_fetch_array($result,MYSQL_BOTH))
{
    //here shall be checked counter_grid and a Size_of_manifest if any discrepancies than communicate. Serious error. This means that what is visible on manifest
    //is different of that what was logicly received from manifest size function that is the main one needes for calculation
    $counter_grid++;
    $NUM_DRAW++; //This variable is local to draw function and is used to get ordered row in table   
    $rcvd_qtty=  qtty_rcvd_manifest_counter_no_delay(extract_session_manifest_reg(), 
            $rek['id_c']);
    $sub_cat_item_name=$rek['Name_sub']; //this is name of subcategory.
    $placeholder_sub_cat=$sub_cat_item_name;
    $placeholder_sub_cat.="...QTTY...";
  
    
 
   /*   
   if(($counter_grid%2==0))
   echo '<td>1'; 
   else if($counter_grid%2==1)
   echo '<td>2';
    * 
    */
  //was #manifest
     echo '<td>';
     
      echo '<form action="" id="manifest'.$NUM_DRAW.'" method="POST" data-ajax="false" data-prefetch="false">' ;
   //taken numeric value out
 //$rek['id_c']." ".
   echo $rek['Name_sub']." ".visible($rek['kind'])." ".  get_weight($rek['id_c'])." kgs ";
   echo ' QTTY: '.$rcvd_qtty.' </p>';

  echo '<input type="hidden" name="num_sub_cat_un" value="'.$rek['id_c'].'">'; //this hidden variable is used to generate universal post sub_category number and send it
   
  echo '<input type="hidden" name="no-delay" value="'.$rcvd_qtty.'">'; //temoporary to send qtty without delay
  echo '<input type="submit" value="+" name="plus'.$NUM_DRAW.'" data-role="button" data-transition="flip" data-inline="true">';
    echo '<input type="submit" value="-" name="minus'.$NUM_DRAW.'" data-role="button" data-inline="true">';
     echo '<input type="text" name="qtty'.$NUM_DRAW.'" value="" placeholder="'.$placeholder_sub_cat.'"  >'; 
     
   echo '</td>';
   
  if($counter_grid%3==0)
      echo '<tr></tr>';
      
   
   echo '</form>';
    
   
   
}
echo '</table>';
        
        
}













//Functions for drawing handling


function receive()
{
    //Function receives the frontend events and recognise them. Buildes an array of event set
    global $SIZE_OF_MANIFEST;
   // echo "SIZE OF MANIFEST: ".$SIZE_OF_MANIFEST;  //READ sub_categories until manifest size. ALL those on received from DB will not appear if there are not less than manifest size
    for($i=0;$i<$SIZE_OF_MANIFEST+1;$i++) //hopefuly this will solve provlem of processing the lats item print on manifets byrt not incremented
    {
        //here loop will be receiving and checkin the buttons clicked and pick up values. The constraint that is important is MANIFEST SIZE. Sall it be stored in DEVICE_HEADER, FLAGS OR MIDDLE LEVEL?
        
        //processing names
        $name_plus="plus".$i;
        $name_minus="minus".$i;
        $name_qtty="qtty".$i;
        
        global $FLAG_QTTY_ADDED_LAST;
        global $FLAG_QTTY_SUB_LAST;
        global $FLAG_LAST_SUB_CAT;
        global $FLAG_QTTY_BULK_ADD_LAST;
        
        global $FLAG_LAST_CLICK;
        
        //this is sub cat received;
        $sub_cat_rcvd=$_POST['num_sub_cat_un'];
        
        //ACTUALY THERE IS DISCREPANCY IN LOGIC SIZE OF MANIFEST ACTUALLY ONLY MEANS THAT id_c cannot be bigger than it?? NOT really it limits acctuall list of manifest items
        if(!empty($_POST[$name_qtty]) AND isset($_POST[$name_plus]))
        {
            $FLAG_LAST_CLICK=3;
            $FLAG_QTTY_BULK_ADD_LAST=$_POST[$name_qtty];
            $FLAG_LAST_SUB_CAT=$sub_cat_rcvd; //one variable for 3 condition check
            return $FLAG_QTTY_BULK_ADD_LAST; //this more safe than using global flags, what if page reloaded twice its lost..anyway..
        }
        else //here we use else if stiop running add one if the input qtty is filled. We can try the same with minus . Two blocks of independent conditions. 
        if(isset($_POST[$name_plus]))
        {
            $FLAG_LAST_CLICK=1;
       //     echo "</br>ADDED ".$sub_cat_rcvd;
       //     echo "</br>Sub_category received: ".$sub_cat_rcvd;    
       //     echo "</br>Order: ".$name_plus;
            
            global $FLAG_QTTY_NO_DELAY;
            global $qtty_digit;
            $qtty_digit=1;
            $FLAG_QTTY_NO_DELAY=$_POST['no-delay'];
            //Flags picked up by show_add() in footer #manifest
            $FLAG_QTTY_ADDED_LAST=$name_plus;
            $FLAG_LAST_SUB_CAT=$sub_cat_rcvd; //this is hidden value for plus$i
            //here we call DB API , e.g insert : transactions
            
            //than return to process_received
            return $sub_cat_rcvd;  //we will return real sub_cat on manifest tablet, shall be checkd if is really from manifest visible set. Problem is when manifest and tablet system are different
            //epsilon(1 to n) manifest size of set(root)- size of set(tablet) == 0
        }//here if we add condition else we shorten the computatnion. For further optimisation
        if(isset($_POST[$name_minus])) //check if minus clicked. If yes which one and return value. But dont rally know the sign. we will return the sign ;) signed int
        {
            $FLAG_LAST_CLICK=2; //cause only one parameter returned by function
            
            $FLAG_QTTY_SUB_LAST=$name_minus;
            $FLAG_LAST_SUB_CAT=$sub_cat_rcvd;
            
            return $sub_cat_rcvd;
            
        }
        
        
        
        
        
    }
    
    
    
    
    
    
}
function qtty_rcvd_manifest_counter_no_delay($manifest_reg_id,$sub_cat)
{
  //  echo "in qtty rcvd ".$manifest_reg_id." ".$sub_cat;
  //  echo "||";
   $sql="SELECT manifest_counter FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$manifest_reg_id' AND sub_cat='$sub_cat'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result,MYSQLI_BOTH);
  //  echo "***/";
 //   echo $rek['manifest_counter'];
 //   echo "Z";
    return $rek[0];  //returns value of qtty from manifest counter for particular sub cat and manifest reg we are in
    
}


function qtty_rcvd_manifest_counter($manifest_reg_id,$sub_cat)
{
   // echo "in qtty rcvd ".$manifest_reg_id." ".$sub_cat;
   // echo "||";
   $sql="SELECT manifest_counter FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$manifest_reg_id' AND sub_cat='$sub_cat'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result,MYSQLI_BOTH);
   // echo "***/";
 //   echo $rek['manifest_counter'];
   // echo "Z";
    return $rek[0];  //returns value of qtty from manifest counter for particular sub cat and manifest reg we are in
    
}

function process_received($value_clicked)//shall have some parameters
{
   //but use global for now
   
    global $FLAG_LAST_CLICK;
    global $FLAG_LAST_SUB_CAT;
   global $FLAG_QTTY_NO_DELAY;
    
   $manifest_reg_id=extract_session_manifest_reg();
   $value_clicked;
   
   //echo "Processing received: ".$value_clicked;
  // echo $FLAG_LAST_SUB_CAT;
   if($FLAG_LAST_CLICK==1){ //add 1
      // echo "clciked 1aad";
      $qtty=qtty_rcvd_manifest_counter(extract_session_manifest_reg(), $value_clicked); 
     // echo "Present value: ".$qtty;
      //$qtty=$FLAG_QTTY_NO_DELAY;
      $qtty+=1;
   //   echo "AFTER ADD ".$qtty;
   
 $sql="UPDATE manifest_counter SET manifest_counter='$qtty' WHERE manifest_reg_idmanifest_reg='$manifest_reg_id' AND sub_cat='$FLAG_LAST_SUB_CAT'";
   
  //if(!empty($qtty))
  $result=query_selecti($sql);
   }   
   
   
   
   
   
   if($FLAG_LAST_CLICK==2){ //minus 1
    //   echo "clciked 1aad";
      $qtty=qtty_rcvd_manifest_counter(extract_session_manifest_reg(), $value_clicked); 
     // echo "Present value: ".$qtty;
      $qtty=$qtty-1;
   //   echo "After minus: ".$qtty;
   $sql="UPDATE manifest_counter SET manifest_counter='$qtty' WHERE manifest_reg_idmanifest_reg='$manifest_reg_id' AND sub_cat='$FLAG_LAST_SUB_CAT'";
   
  #if(!empty($qtty))
  $result=query_selecti($sql);
   }   
   
   if($FLAG_LAST_CLICK==3){ //add qtty
   //    echo "clciked 1aad";
   //here a bug to slow function.There is a delay. if want to add 20 to -14 it adds 20
     $qtty=qtty_rcvd_manifest_counter(extract_session_manifest_reg(), $FLAG_LAST_SUB_CAT); 
   //   echo "Present value: ".$qtty;
     //echo "value clicked".$value_clicked;
      $qtty+=$value_clicked;
  //    echo "AFTER ADD ".$qtty;
   
  $sql="UPDATE manifest_counter SET manifest_counter='$qtty' WHERE manifest_reg_idmanifest_reg='$manifest_reg_id' AND sub_cat='$FLAG_LAST_SUB_CAT'";
   
  //if(!empty($qtty))
  $result=query_selecti($sql);
   }   
   
   
   
   
   
   
//$rek=mysqli_fetch_array($result);
   
    
    
}



function extract_session_manifest_reg()
{
    
    $manifest_reg_id=$_SESSION['MANIFEST_REG_ID'];
    return $manifest_reg_id; //or shall be extracted to flag?..
    
}















































//CLEARING DATA FUNCTION

function reset_tokens_on_sub_cat()
{
    connect_dbi();
    
    $update="UPDATE `sub_cat` SET `token_dynamic_idtoken`=1";
    query_selecti($update);
}




connect_dbi();//this is because if not than db global variable not declared seems if in scope never called to dbi_connect function. Weird ;)


/************ MANIFEST PROCESSING FUNCTIONS ************/

function get_size_of_manifest($sql_load) //this gives back the size of manifest
{
   //PARAMETERS: $FLAG_VISIBLE, $FLAG_ALL    
    
    $counter=0; //size of result stored here
    
    //STATE OF MANIFEST
    
    
    
    global $SIZE_OF_MANIFEST;
    global $SIZE_VISIBLE_AND_ACTIVE;
    global $SIZE_VISIBLE;
    global $SIZE_VISIBLE_AND_STANDARD;
    
    
    
    //get all
    
    
   $sql=$sql_load;
   
        
    $result=query_selecti($sql);
    while($rek=mysqli_fetch_array($result))
    {
       $counter++; 
    }
   $SIZE_OF_MANIFEST=$counter;
   
   
    
//DEFAULT: GET ALL VISIBLE on Manifest. ALL standard and non-standard with active token trace 
    $sql="SELECT * FROM sub_cat WHERE kind=2";
    
    $result=query_selecti($sql);
    while($rek=mysqli_fetch_array($result))
    {
       $counter++; 
    }
    //This calculeted all visibles, doesnt asses if active weights or not are connected. Calculation only done on sub_cat. Compatible backward with old module
    $SIZE_VISIBLE=$counter;
    
    $counter=0;
    
     $sql="SELECT * FROM sub_cat INNER JOIN trace ON sub_cat.id_c=trace.sub_cat_id_c WHERE kind=2 AND active=1";  //are only those active with trace activated. Othe will be bu left join
     
    
    $result=query_selecti($sql);
    while($rek=mysqli_fetch_array($result))
    {
       $counter++; 
    }
    $SIZE_VISIBLE_AND_ACTIVE=$counter;
    
    $counter=0;
     
    $sql="SELECT * FROM sub_cat LEFT JOIN trace ON sub_cat.id_c=trace.sub_cat_id_c WHERE sub_cat.kind=2 AND trace.sub_cat_id_c IS NULL";  // only visible but not having activated trace
     
    
    $result=query_selecti($sql);
    while($rek=mysqli_fetch_array($result))
    {
       $counter++; 
    }
    
    $SIZE_VISIBLE_AND_STANDARD =$counter;
    
    $counter=0;
    
}

function group_manifest()
{
    
    
}



//prototypes


function show_last_add()
{
    global $FLAG_QTTY_ADDED_LAST;
    global $FLAG_QTTY_SUB_LAST;
    global $FLAG_LAST_SUB_CAT;
    global $FLAG_QTTY_BULK_ADD_LAST;
    
    echo '<div data-role="controlgroup">';
    echo '</BR>';
    
    if(!empty($FLAG_QTTY_ADDED_LAST))
    {
   
    echo "<h2>Added Successfuly: ";//be careful this is numeric order of items appering on manifest, nameplus iteration from frontend
     //echo $FLAG_QTTY_ADDED_LAST;
     echo get_dbi_sub_cat_name($FLAG_LAST_SUB_CAT);
     echo " +1 Unit";
     echo "</h2>";
    }    
//echo '</BR>';
 //   else if($FLAG_LAST_SUB_CAT)
 //   echo $FLAG_LAST_SUB_CAT; //this real category id_c
   
    //echo '</BR>';
    else
   if(!empty($FLAG_QTTY_SUB_LAST))
   {
       echo "<h2>Subsided successfuly: ";
    
     echo get_dbi_sub_cat_name($FLAG_LAST_SUB_CAT);
     echo " -1 Unit";
     echo "</h2>";   
   // echo $FLAG_QTTY_SUB_LAST;
   }    
//echo '</BR>'
    else if(!empty($FLAG_QTTY_BULK_ADD_LAST))
    {
        echo "<h2>Added Bulk: ";
          
        echo get_dbi_sub_cat_name($FLAG_LAST_SUB_CAT);
        echo " + ";
        echo $FLAG_QTTY_BULK_ADD_LAST; 
     echo " Units";
     echo "</h2>";   
    }
   
    echo '</div>';
}





/*********** END OF MANIFEST FUNCTIONS************************/



/*********** DATABASE API ************************/

//FUCTION READ

function read_sub_categories()
{
    global $sql_load;
    
    //$sql="SELECT id_c from sub_cat ORDER BY id_c DESC";
    $sql=$sql_load;
    $result=query_selecti($sql);
    return $result; //just return array
    
}

function get_max_customer()
{
    $sql="SELECT MAX(origin_id) AS origin_max FROM origin";
    $result=query_selecti($sql);
    
    //gets the higest value in column not how manyt ropws
    
    $rek=mysqli_fetch_array($result);
    return $rek[0];
    
    
}
/** This function has  common problem. It gives null for select tag
 * 
 * @param type $id_customer
 * @return type
 */
function read_customers($id_customer)
{
    $sql="SELECT * FROM origin WHERE origin_id='$id_customer'";
    
    $result=query_selecti($sql);
    
    $rek=mysqli_fetch_array($result,MYSQL_BOTH);
    
    return array($rek[0],$rek[5],$rek[8],$rek[1],$rek[2],$rek[3],$rek[4],$rek[6],$rek[8]); //here we switch a bit for picking up for select element
    
}

function read_read_stickers() //not yet used
{
    
}


function read_manifest_id($manifest_unq_number)
{
    $sql="SELECT idmanifest_reg FROM manifest_reg WHERE manifest_unq_num='$manifest_unq_number'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[0];
    
}

//FUNCTION WRITE
function initialize_manifest_reg()//creates auto incremented row prepered for manifest reg. Can be done while manifest started. Set status as running 6  define constans INITIALISED $FLAG_RUNNING
{
    //can be only generated if there is site_ung_number first
    global $FLAG_MANIFEST_UNQ_NUMBER;
    //generate once if not generate
    echo "initialising manifest_reg";
    
    
    
    //first extract from session
    
    if(isset($_SESSION['MANIFEST_UNQ_NUMBER']))
    {
        echo "Getting number form seesion";
        $manifest_unq_number=$_SESSION['MANIFEST_UNQ_NUMBER'];
        
    }
    else
    {
        echo "generating fresh num";
        $manifest_unq_number=generate_manifest_unq_number();  //here each time is different. we need to check if already is not setr the same
    }
    
    //go set the session
    //if not set yet, good chance to initialized it once
    if(check_manifest_unq_num_set($manifest_unq_number)==1)
    {
        echo "Set man_unq_num";
    }
    else
    {
        //if not yet generated
    $_SESSION['MANIFEST_UNQ_NUMBER']=$manifest_unq_number;
    }
    
    
    $start_dbs=1;    
    
    $date_today=date("Y-m-d");
    
    //state of manifest
    $state=MANIFEST_INITIALISED;
     
    $driver_num=  get_driver_session(); //here for driver num
    //didnt work so we go a new solution
    
    $driver_num=  convert_driver_id(get_driver_session());
    $sql="INSERT INTO manifest_reg(manifest_unq_num,date_manifest,driver_num,hash_serial,group1,start_dbs,closed) VALUES('$manifest_unq_number','$date_today','$driver_num','0','95','$start_dbs',$state)";
    
    //here we query prepared statement
    if((check_manifest_state($manifest_unq_number))==MANIFEST_INITIALISED)//return state.Here comes checking with flags constand
    {    
        //run the query if and only if MANIFEST IS ALREADY INITIALISED. HERE OR SOMEWHERE ELSE checking last ten device local manifest if running or other states
        //but first implement flow
    
        //CORRECTION: this initialisation will be done only if already initialized. incorrect
        
    }
    else if(check_manifest_state($manifest_unq_num)==MANIFEST_NOT_FINISHED) 
    {
            $result=query_selecti($sql);
            $FLAG_MANIFEST_UNQ_NUMBER=$manifest_unq_num; //asignment done only once when new seesion of second api starts. generation of manifest unq id is its part 
            //if done set a flag manifest_ung num ; load unload to session, header..etc
         
            $manifest_unq_num=$FLAG_MANIFEST_UNQ_NUMBER;
    }
    if($result)
    {
        
        echo $manifest_unq_number;
        
        return $manifest_unq_number; //or last inserted id
        
    }
        
 }

function generate_default_manifest_counter($SIZE_OF_MANIFEST)//AFTER INITIALISATION OF MANIFEST_REG, WE CREATE THE SPACE IN MANIFEST COUNTER AND ASSIGH MAnifest unq number to the counter.STAUS CHANGES from initiialized to running
{
    //instead or preset size of manifest there may be a function checking the sub_cat maybe 
    global $FLAG_MANIFEST_UNQ_NUMBER; //to be funny we take unique manifest_number as global :) asuuming it's correctly stored somewhere :)
    //if exist of course ;P
    
    
      //**
    $result_sub_categories=read_sub_categories();//we ll read all no constraint
    //** dont know how many. needs to be extracted to manifest counter. leets check how many
    
    $number_of_subcategories_avl=mysqli_num_rows($result_sub_categories);  //checking how many
          echo "NUMBER AVAIL: ".$number_of_subcategories_avl; //OK extracted 61 sub cat availible originally. assuming those the some drove on manifest. but here we 
    //genereate the counter only to manifest size, the main varaiable for calculations. 
    if(!empty($FLAG_MANIFEST_UNQ_NUMBER))
    {
       $c=0; 
       echo "Generating counter table";
       echo "Extatracting availible categoreis: ".$number_of_subcategories_avl." -".$SIZE_OF_MANIFEST;
       
    for($i=0;$i<$SIZE_OF_MANIFEST;$i++) //being careful here...
    {
        
        $row=mysqli_fetch_row($result_sub_categories); //gets one and put pointer ahead
        $sub_cat=$row[0];
        
        //get manifest reg id
        //conversion of uniqu number for ai manifest id
        
        $manifest_id=read_manifest_id($FLAG_MANIFEST_UNQ_NUMBER);
        
        //lets do the transaction or not...
        //prepared statement instead                                                                        //QTTY set 0 ;EXTRACT sub_cat real. old mode they are orgines 1 to n
        $sql="INSERT INTO manifest_counter(manifest_counter,sub_cat,manifest_reg_idmanifest_reg,finished) VALUES('0','$sub_cat',$manifest_id,'0')";
        //state finished is 0 while manifest counter initialized. we give counter as order of items, doesnt matter, and sub_cat 0, cause nothing picked up yet.
        //we also leave space for further function for manifest_counter clonong. That comes with manifest site_has cat filling in real time. not sure of its purpose yet
        $result=query_selecti($sql);
        if($result)
            $c++;
    }
    echo "done: ".$i."==".$c;
    if($c==$i)
    {
        //here we put a sticker. good place
        
        $first_sticker=get_sticker_session();
        $sql="UPDATE manifest_reg SET start_dbs='$first_sticker' WHERE manifest_unq_num='$FLAG_MANIFEST_UNQ_NUMBER'"; //here w can switch as well to manifest_id
        query_selecti($sql);
        
        
        echo "Before site generatiion";
        $last_site=dbi_generate_site();//if initialized and generated manifest reg and counter than open a new site to write
         //here we update site manifest_counter
         set_site_id($last_site); // here we set session site id only if it was genereted correctly
        
        echo "Updating site ".$last_site;
        
        //site id temporary keep in session
        //$_SESSION['SITE_ID']=$last_site;
        
        echo $update="UPDATE manifest_reg SET siteid='$last_site' WHERE idmanifest_reg='$manifest_id'";
        $result=query_selecti($update);
        if($result)
        {
            echo "Manifest Reg site updated";
        }
    }
    }
    else
        echo "Couldnt initialized manifest counter cause global FLAG_MANIFEST_REG not set, UNQ_NUM";
            
    
}

function dbi_generate_site()
{
    $customer_id=get_site_sesion(); //here we redad from session every generation. this is customer origin
    $site_ref_number=  generate_manifest_unq_number();//we change it later for site generator
    $batch_date=date("Y-m-d");
    
    global $db;
    
    $batch_id=70; //changed incremeneted every month
    $site_size=0; //Zero. to be updated
    
    echo $sql="INSERT INTO site(Origin_origin_id,site_ref_number,Rep_Auth,Dest_Location,batch_date,batch_id,closed) VALUES('$customer_id','$site_ref_number','14','7932','$batch_date','$batch_id','$site_size')";
    $result=query_selecti($sql);
        
    $last_site=mysqli_insert_id($db); //lets take and return site_id. Shall be kept for manifest counter
    if(mysqli_affected_rows($result)==1) //check for insert??
    {
        echo "generated site";
        
        return $last_site;
   
    }
    else
    {
        echo "No site inserted. Initialised";
        return $last_site;
    }
}




function dbi_clone_manifest($manifest_reg_id,$site_id)
{
    //first check if this sub_cat are not there
    //dont douoble
    //if there onlu up to date the table
    //this function shal;l berely initialise
    
  $sql="SELECT * FROM site_has_cat WHERE Site_site_id='$site_id'";
    $result=query_selecti($sql);
    
    $rek=mysqli_fetch_array($result);
    
    if($rek)
    {
        echo "Site sub_cat already initialized go for up date";
        
        //cloning
        
        
     $sql="SELECT * FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$manifest_reg_id'";
    $result=query_selecti($sql);
    while($rek=mysqli_fetch_array($result,MYSQLI_BOTH))
    {
        //rule: pick up one write one. Mind the order of sub cat
        
        $site_id;
        $id_c=$rek['sub_cat'];
        $qtty=$rek['manifest_counter'];        
        
        $insert="UPDATE site_has_cat SET Quantity='$qtty' WHERE Site_site_id='$site_id' AND Sub_cat_id_c='$id_c'";
        
        $result1=query_selecti($insert);
        
    }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //END cloning up-to date
        
    }
    else
    {  
    
    
   //take manifest reg_id and clone state to new sub_categories
    
    ///read counter
    
    //create counter in sub. needs site and sticker id
    
    $sql="SELECT * FROM manifest_counter WHERE manifest_reg_idmanifest_reg='$manifest_reg_id'";
    $result=query_selecti($sql);
    while($rek=mysqli_fetch_array($result,MYSQLI_BOTH))
    {
        //rule: pick up one write one. Mind the order of sub cat
        
        $site_id;
        $id_c=$rek['sub_cat'];
        $qtty=$rek['manifest_counter'];        
        
        $insert="INSERT INTO site_has_cat(Sub_cat_id_c,Site_site_id,Quantity) VALUES('$id_c','$site_id','$qtty')";
        
        $result1=query_selecti($insert);
        
    }
        
    
    } //end of condition that didint detects site_site_id
    
}

//FUNCTION CHECK

function check_manifest_set($FLAG_MANIFEST_SET) //checks set of 10 
{
    //we will get the last 10 manifest regs using order by desc
    
}

function check_manifest_state($manifest_unq_num)
{
    $sql="SELECT * FROM manifest_reg WHERE manifest_unq_num='$manifest_unq_num'";
    $result=query_selecti($sql);
    
    error_msg("check_manifest_state", $result);
    
    $rek=mysqli_fetch_array($result,MYSQLI_BOTH); //will be zero cause this manifest unq number doe not exzist. than generate new one ;)
    //we need to return a need to create afresh one to function iinitiaze manifest
    
    return $rek['closed'];//here returns check up
    
}





//flow: criticalrtur->haltsystem-_errormessage
function critial_return_value($result) //if more than two rows return communicate and halt system
{
    $num_rows=mysqli_num_rows($result);
    if($num_rows>1)
    {
        
        return $num_rows;
    }
    else if ($num_rows==1)
        return $num_rows;
    else 
        return 0;
}

function halt_system($num_rows)
{
    if($num_rows>1)
    {
        echo ": Critical error. To many results returned: ".$num_rows.". ";
        die();
    }
    else if($num_rows==1)
        return 1;
    else
        return 0;
        
 }


function error_msg($parameter,$result)
{
    
    $num_rows=halt_system(critial_return_value($result));
    if($num_rows==1)
        return 1;
    else if($num_rows==0)
    {
        $rek=mysqli_fetch_array($result,MYSQLI_BOTH);  
        return $rek['closed'];
    }
        else
        echo $parameter;
    
}








/*********** HEADER Functions************************/

function generate_device_header()
{
    
    
}

function check_heders_exist()
{
    
    
}

//this ll count the real number of element printed on manifest form . Must be somehow compared with real visible manifest elements. Moduul for apper elements
function count_manifest_form()
{
    
    
}

function get_dbi_sub_cat_name($id_c)
{
    $sql="SELECT Name_sub FROM sub_cat where id_c='$id_c'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return strtoupper($rek[0]);
}