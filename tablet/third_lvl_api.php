<?php
include 'second_lvl_api.php';

$FLAG_SIZE_SUB_CAT;
/* 
 * Here we dynamically generete calculations. 
 */
function show_result_one_row_at_time($result)
{
    //for generetig and formatin result line by line. AS result it takes whole results array[1n wee]
    
    //$rek=mysqli_fetch_row($result);
    //return $rek;
    
   // var_dump($result);
    $cat_name=array();
   $cat_name=get_weee_categories()[1];
   //var_dump($cat_name);
   $i=0;
    foreach ($result as $cat)  //two dimension array is return 0 is id cat 1 is name of category..
    {
        $i++;
        echo '<tr><td>';
        
       echo $cat_name[$i]; 
        echo '</td>';
        echo '<td>';
    echo $cat;
  
    
    echo '</td></tr>';
    }
    
}


function show_result_one_row_at_time_att($result,$att_flag,$att_flag_name,$att_sum_weight)
{
    //for generetig and formatin result line by line. AS result it takes whole results array[1n wee]
    
    //$rek=mysqli_fetch_row($result);
    //return $rek;
    
   // var_dump($result);
    $cat_name=array();
   $cat_name=get_weee_categories()[1];
   //var_dump($cat_name);
   $i=0;
   
  // echo '<form action="#att_process" method="POST">';
    foreach ($result as $cat)  //two dimension array is return 0 is id cat 1 is name of category..
    {
        $i++;
        
        //here if att 14 ink than get weigth
        
        echo '<tr><td>';
        
       echo $cat_name[$i]; 
        echo '</td>';
        echo '<td>';
    echo $cat;
    echo '</td>';
    echo '<td>';
    echo $att_flag_name[$i];
    //here we will use a function that gets new weights throu att_weight object
    
    echo draw_att_field($att_flag[$i],$att_flag_name[$i],$att_sum_weight[$i]); //if set. att name , weight
    echo '</td></tr>';
    
    }
    echo '<tr><td></td><td></td><td><input type="submit" name="att" value="Add ATTs"></td></tr>';
    
    
}

function get_calculation_results($result)
{
    
    
}
/**
 * 
 * @global type $FLAG_SIZE_SUB_CAT
 * @return array(sub_cat_id|sub_cat_name)
 */

function get_sub_cat_id()
{
    $sub_cat_id=array();
    $sub_cat_name=array();
    global $FLAG_SIZE_SUB_CAT;
    
    $sql="SELECT * FROM sub_cat";
    $result=query_selecti($sql);
    $i=0;
    $num_sub_cat_availible=mysqli_num_rows($result);
    $FLAG_SIZE_SUB_CAT=$num_sub_cat_availible;
    while($rek=mysqli_fetch_array($result,MYSQLI_BOTH))
    {
        $i++;
        
        $sub_cat_id[$i]=$rek['id_c'];
       $sub_cat_name[$i]=$rek['Name_sub'];
        
    }
            return array($sub_cat_id,$sub_cat_name); //sub cat id and name
}

function get_weee_categories()
{
    connect_dbi();
    $weee_cat=array(); 
    $weee_cat_name=array();
    $blank=array();
    $sql="SELECT * FROM category";
    $result=query_selecti($sql);
    //count how many categories are there. Mind some may be non active or visible. BYt bu unique it we calculate all
    $num_categories_availible= mysqli_num_rows($result);
    //echo $num_categories_availible;
    $i=0;
    while($rek=mysqli_fetch_array($result,MYSQLI_BOTH))
    {
       $i++;
       //var_dump($rek);
       //echo $rek['id']; // GET CATEGORY UNIQU AI NUMBER 
       $weee_cat_name[$i]=$rek['name_cat'];
       $weee_cat[$i]=$rek['id'];
       $blank[$i]=0;
       //echo $weee_cat[$i];
    }
    
    //here we initialise an array
    /*
    for($i=0;$i=$num_categories_availible;$i++)
    {
        $weee_cat
    }
    */
    return array($weee_cat,$weee_cat_name,$blank); //zero to zero for calculation assignment. cant properly define cat indexes be default 0
}


function get_counter()
{
    
}
/**  It takes a sub category identifier and returs its actual weight in the system along
 *   with its uningue identifier   
 * 
 * @param type $id_c
 * @return array(actual_weight_for_category,id_c)
 */

function get_weight_for_calculations($id_c)
{
    $actual_weight_for_category=get_weight($id_c); //this is called to 2 api. To take a proper weight from sub_cat standard and non-standard if needed. Takes sub_cat id, return a present actual weight for that day that called active standard or non standard
    return array($actual_weight_for_category,$id_c);
}

function calculate_weights($manifest_reg_id) // $actual_weight_for_category //input tupe with actual weight and sub_cat number
{
    //lets assign each tupple to proper category. remember some categories are non-standard. May change. Basic table for Categories is category. Non-standard one must always include in category on each devices
    //$id_c=array();
    //loop for hom many id_c is there in global flag for now
    global $FLAG_SIZE_SUB_CAT;
    //$FLAG_SIZE_SUB_CAT=65;
     $id_c=get_sub_cat_id()[0];
     //var_dump($id_c);
     
     
     //here we generate an array to keep all weights
       $weee_weights_calculated =array();
       
       $weee_weights_calculated =get_weee_categories()[2];  
       
       
       //An array initialization for small_att_assignment function
     //  $small_att_weight=array();
     
    for($i=1;$i<$FLAG_SIZE_SUB_CAT+1;$i++) //here this only condition doeas its word look into it.
    {
     //+  echo  "</BR>Calculating: ";
      //+ echo $i;
      //+ echo " - ";
      // var_dump($id_c);
       $actual_weight_for_category=get_weight_for_calculations($id_c[$i])[0];
       $actual_name_of_sub_cat=get_weight_for_calculations($id_c[$i])[1];
        
         $weight=$actual_weight_for_category;
   //+    echo " - ";
        $actual_name_of_sub_cat;
  // echo  $actual_weight_for_category[1];
    
    //+    echo "</BR>";
     //+   echo "Active category: ";
        //$category_active=0;
         $category_active=check_category_assignment($actual_name_of_sub_cat);
        
        //here we calculate weights. We take actual sub_cat. check its weight actual and category actual for that moment on device. and check how many in counter
        //what is needed is to compare function of a counter with that actual ones taken fron sub_cat. Shall be the same 
        
        
        //get qtty received for specific manifest_reg and sub_cat. one at a tine
        
        $qtty_rcvd=qtty_rcvd_manifest_counter_no_delay($manifest_reg_id, $actual_name_of_sub_cat);
       //+ echo "</br>received :";
        $qtty_rcvd;
        //calculations here
      
        $weee_weights_calculated[$category_active]+=$weight * $qtty_rcvd;  //actual weight from universal tables times qtty rcved from counter. No real validation checks or casting sub_categories from sub_cat into conter
        
        //echo "total cat ";
        //echo $weee_weights_calculated;
        
        //check each sub_cat and get atts weights along_side
        
    //    $category_att;  // This variable is used to store actual item att
        
     //  $category_att=small_att_assignment(); //this is to initialise another table
       
       //than assign the weight to active att category
      // $small_att_assignment[category_att];
     }
    
    
   
    
    return $weee_weights_calculated;
    
}

/** function asses the att category sub_cat item goes
 * 
 * @param type $id_c
 * @return att
 */

function small_att_assignment($id_c)
{
    $sql="SELECT atts FROM sub_cat WHERE id_c='$id_c'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[0];
    
}
 /**    Used to assign weights to particular atts groups
  * 
  * 
  * @global type $FLAG_SIZE_SUB_CAT
  * @param type $manifest_reg_id
  * @return array(small_att_assignment) Description
  */

function att_assignment($manifest_reg_id)  //manifest_reg_id needed to get ptoper qtty
{ 
    global $FLAG_SIZE_SUB_CAT;

     $id_c=get_sub_cat_id()[0]; //gets all id_c availible
    
     
     
    
     $small_att_weight=array();
     
    for($i=1;$i<$FLAG_SIZE_SUB_CAT+1;$i++) //here this only condition doeas its word look into it.
    {
     //+  echo  "</BR>Calculating: ";
      //+ echo $i;
      //+ echo " - ";
      // var_dump($id_c);
       $actual_weight_for_category=get_weight_for_calculations($id_c[$i])[0]; //weight of sub_cat
       $actual_name_of_sub_cat=get_weight_for_calculations($id_c[$i])[1];     //ident of sub cat
        
         $weight=$actual_weight_for_category;  //alias
   //+    echo " - ";
        $actual_name_of_sub_cat;
  // echo  $actual_weight_for_category[1];
    
    //+    echo "</BR>";
     //+   echo "Active category: ";
        //$category_active=0;
         $category_active=check_category_assignment($actual_name_of_sub_cat);
        
        //here we calculate weights. We take actual sub_cat. check its weight actual and category actual for that moment on device. and check how many in counter
        //what is needed is to compare function of a counter with that actual ones taken fron sub_cat. Shall be the same 
        
        
        //get qtty received for specific manifest_reg and sub_cat. one at a tine
        
        $qtty_rcvd=qtty_rcvd_manifest_counter_no_delay($manifest_reg_id, $actual_name_of_sub_cat);
       //+ echo "</br>received :";
        $qtty_rcvd;
        //calculations here
      
        //$weight * $qtty_rcvd;  //actual weight from universal tables times qtty rcved from counter. No real validation checks or casting sub_categories from sub_cat into conter
        
        //echo "total cat ";
        //echo $weee_weights_calculated;
        
        //check each sub_cat and get atts weights along_side
        
        $category_att;  // This variable is used to store actual item att
        
   //  echo "</BR>".$actual_name_of_sub_cat." ATT: ".
             $category_att=small_att_assignment($actual_name_of_sub_cat); //this is to initialise another table
       
       //than assign the weight to active att category
       $small_att_assignment[$category_att]+=$weight * $qtty_rcvd;  //shall work we are using functionality of weight callculation  from site has subcat
       if($small_att_assignment[$category_att]>0)
        ;//  echo "Weight: ".$small_att_assignment[$category_att]." for ATT: ".$category_att;
       
       
     }
     return $small_att_assignment;
    
}

/** Processes an object that att_assignment returns
 * 
 * @param type $atts_weights
 * @return type
 * 
 */


function show_active($atts_weights)
{
    $id_att=0; //variable to store a number used for category of att
    //Go throu array
    $i=0;
    echo "Prepering to show";
   $size_of_atts_weights=sizeof($atts_weights);
   //get size of all atts reference
   $size_of_att_table=get_size_of_att();
   
   
   //
   //init an array for return
   $att=array();
   $att_cat=array();
   $weights_calculated_att=array();
   
    while($i<$size_of_att_table)  //question: how many times interact?  sizeof att_WEIGHTS IS TO SMALL to generate id_att quals 10 e.g
    {             //I think we must interact that many times that are att categories or that many times there is wee cat
      $i++;
        if($atts_weights[$i]>0)  //what is set than take it's weight and cast
        {   ///  echo "</br> ATT_WEIGHT".$i." we".$atts_weights[$i];
                //open assocciation table att and query it for and active att weights
                $id_att=$i;//get index of aats weights and check it
                $sql="SELECT att,cat_att FROM att WHERE id_att=$id_att";   //while id_att from index att_weights than take info
                $result=query_selecti($sql);
                $rek=mysqli_fetch_array($result);
                /// echo "</br>ID ATT".$id_att." has att ".$rek[0]." with weight ".$atts_weights[$i]." CAT: ".$rek[1] ;
                   $att[$i]=$rek[0];
                   $att_cat[$i]=$rek[1];
                   $weights_calculated_att[$i]=$atts_weights[$i];          
                   
               
        }
        
        
        
        
        
    }
        //return arrays of att and its category that is assigned to
        return array($att,$att_cat,$weights_calculated_att);  //returns a weight for atts group as third. to convert
    
}

/** Functions cast an acctive atts for weee_category template. Also trying to return second array with att
 * 
 * @param type $mixed_atts
 * @return att_flag[0]
 */

function convert_to_att_flag($mixed_atts)
{
    //or do it based on size of operator ;)
    $size_of_att_table=get_size_of_att(); //this result is generated based on size of att table so it cant be bigger than that
    $i=0;
    
    $result=array();
    $result=get_weee_categories(); //lets do the replica
    
    //here we ll store a name of att array
   
    $att_calculated_weights=array();
    
   $att_name=array();
    
    while($i<$size_of_att_table)
    {
        $i++;
        $att_name[$mixed_atts[1][$i]]=$mixed_atts[0][$i];
        $result[2][$mixed_atts[1][$i]]=1; //category it goes
        
        //weights are there just cast them into proper category
        $att_calculated_weights[$mixed_atts[1][$i]]=$mixed_atts[2][$i]; //weight number i < size of att table
        
    }
    return array($result[2],$att_name,$att_calculated_weights);
    
}













/** It will get an actual category item sub cat goes. Standard and nonstandard
 * 
 * @param type $id_c
 * @return type
 */

function check_category_assignment($id_c)
{
    //function takes subcategory index and checks its reference standard or not gives buck result id category it goes
    
    //first we search for non-standard category
    
    $sql="SELECT * from trace WHERE sub_cat_id_c='$id_c' AND active=1"; //if active one if none go standard. if none standard than system bereak down
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    $token=$rek['token_dynamic_idtoken']; //get returned token for active trace
    $category_spare=get_token_category($token);  //2 lvl API get category spare base on active token trace      
    if($token) //if for active trace token_dynamics is set
    {
        return $category_spare;  //here we would like to expand to che3ck the situation where active trace is there but has no token at all. critical error
    }
    


//here if none non-standard active trace than give standard one. Standard must be there. IF both non there exit with -1;
    
    $sql="SELECT * from sub_cat WHERE id_c='$id_c'"; //ASUME one item has only and only one category
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    $standard_category_name=$rek['Category_id'];
    
    if($standard_category_name)
        return $standard_category_name; // do not search for non-standard??  No first seach non standard if none than give the standard. We code up
       
    else
    {   
        die();
        return -1;
    }
        
}

function write_weights_back()
{
    
    
}

/**
 * @todo Description
 * 
 * @param type $name Description
 * @return array(att_name,att_cat)
 * 
 */
function check_atts()  //Selects from att table the values tuple of name of att and associated category number
{
    $atts=array();  // name of att
    $cat_atts=array(); // number of att cat
    $sql="SELECT att, cat_att FROM att";
    $result=query_selecti($sql);
    $i=0;
    while($rek=mysqli_fetch_array($result))
    {
        $i++;
        $atts[$i]=$rek[0];  //name
        $cat_atts[$i]=$rek[1];  //categories it goes
    }
      
    return array($atts,$cat_atts); //number
}

/**
 * @param array $atts It takes a valid atts with its category assigned atts table
 * @return type Description
 */
function detect_atts_by_type($atts_mixed,$categories_num)
{
    echo "Detecting atts NEW module";
    /**
     * 
     */
    
    $att_flag=array();   //variable for show up the att field. Values Active / Non-active 
    $att_flag_name_att=array(); //Just to show up name of att type. E.g mobiles
    
    $keep_weights_for_atts=array();
    
    $siz_cat= sizeof($categories_num);  //result of weee weights calculated if zero ignore att if set show att
    
    //extract tuple atts-mixed
    
    $att_name=$atts_mixed[0];
    $att_cat=$atts_mixed[1];
    
    $do_att=0;
    while($do_att<$size_cat)
    {
        $do_att++;  //while do att is lesser than all weee categories
        
        
        //Here operations we gona do on our data
        
        /**  Calculating Atts for looping through each availible weee category. But new att mechanism
         *   is assigned to sub_cat. That way we first must check sub_cat. What if we can do this. Atts grouping
         *   directly with weight calculations?? Than pass it as a optional argument???
         * 1. Check
         * 2.   
         */
        
        
        
        //END
        
    }
    
    
}



function detect_atts($atts_mixed,$categories_num) //takes tupe of arrays of result from att table
{
    $table_category_wth_atts=array();
    echo "Deteckting atts";
    
    
    $att_flag=array();
    $att_flag_name_att=array();
    
    $keep_weights_for_atts=array();
    
    $siz_cat= sizeof($categories_num);  //result of weee weights calculated if zero ignore att if set show att
    
    //extract tuple atts-mixed
    
    $att_name=$atts_mixed[0];
    $att_cat=$atts_mixed[1];
   // var_dump($categories_num);
    for($i=0;$i<$siz_cat;$i++)
    {
        //if($att_cat[$i]==0)
       // echo "</BR>";
         //   echo $att_cat[$i];
                
       //     echo '</BR>';
         // $att_name[$i];
       
            if($categories_num[$i]>0)
            {
         //       echo $i." not empty: ".$categories_num[$i];
                //if weee_category weight is not empty
                 //search atts ident to find proper attscat
               
            
                for($a=0;$a<=sizeof($att_cat);$a++)
                {
              //         echo $att_cat[$a];
                   // $categories_num[$i];// here should be category id obteined from reall one, but lack of time
                            //so depending on the set of $i
                     // echo $a+1;     //this are the atts numbers
                      if($i==3)//case ogfmobiles phones
                      {
                          //future field for atts assigned to particular item type
                          $sql_conotation="SELECT id_c FROM sub_cat WHERE conotation='mobile_att'";
                          $result=query_selecti($sql_conotation);
                          $rek=mysqli_fetch_array($result);
                          if($keep_weights_for_atts[3]=get_weight($rek[0])) //if the weight of mobile really set
                          {
                              if(!empty($keep_weights_for_atts[3]))
                              {
                                $att_flag[3]=1;
                               
                              $att_flag_name_att[3]="Mobile";
                              }
                          }
                                 
                              else
                          ;
                      }
                      else                          
                      if($att_cat[$a]==$i){
                          if($i==1) //omit if finds lda/ check calculations
                              ;
                          else
                          {
                       //        echo "found att: ".$att_cat[$a];
                      //        echo " for ".$i;  
                              $att_flag[$i]=1;
                              $att_flag_name_att[$i]=$att_name[$a];
                              $keep_weights_for_atts[$i]=$categories_num[$i];
                          }
                    //from 0 search in table not in db :)
                         
                          
                      }  
                      else if($att_cat[$a]=="1-10"){
                        //  echo "found special att 1-10 only one for".$i;
                          //here take calculated weee_categories and check
                          //if any weight set
                          $keep_weight=0;
                          for($d=0;$d<=10;$d++)
                          {
                              
                              if($categories_num[$d]>0)
                              {
                                  
                                  $keep_weight+=$categories_num[$d];
                                  
                                  
                              }
                              if($keep_weight>0)
                              {   
                                  if($keep_weights_for_atts[3])//that means if set moboile weight than subside
                                  $keep_weights_for_atts[9]=$keep_weight-$keep_weights_for_atts[3]; //lets keep as 3 index of array 2 dimension returned
                                  else
                                    $keep_weights_for_atts[9]=$keep_weight;  
                                  $att_flag[9]=1;
                               
                              $att_flag_name_att[9]="Weee";
                              }
                          }
                      }
                                                   
                }
    
            
            }       
    }// end of for    
    
    
    
    
    return array($att_flag,$att_flag_name_att,$keep_weights_for_atts);// att flag were is active and also alongside the name of att for placeholder
}

function draw_att_field($att_flag,$att_cat_name,$weight_att)
{
    if($att_flag)
    {
        $att_field="<input type='hidden' name='weight".$att_cat_name."' value='".$weight_att."'>";
       $att_field.="<input type='text' name='".$att_cat_name."' value='' placeholder='ATT: ".$att_cat_name."..".$weight_att."'>"; 
        echo $att_field;
    }
    
}

function dbi_generate_delivery($detected_flag,$site_id) //we will read from results from detect_att function
{
    
    //to be wrapped
       //get site from manifest counter
      // connect_dbi();
                        

    
    $form_flag_att_name=$detected_flag[1];
    $form_att=array();
    $form_name=array();
    $zz=0;
    for($form_counter=0;$form_counter<20;$form_counter++)
    {   
        $zz++;
        echo "NAME.".$name=$form_flag_att_name[$form_counter];
        if(!empty($name))
         {
            
          echo $form_counter; 
          
          echo $_POST[$name];
              //echo "Yup[i";
          $form_att[$zz]=$form_counter;
          $form_name[$zz]=$_POST[$name];
          
        }
    }
    //get deliveries
    //check site_id in delieveries
    
    //
    
    //mobiles//
    //cd
    ////toners
    
    //wwwee
    echo "DBI GENERATE DELIVERY";
    //var_dum($form_name);
    $atts=check_atts();
    
   // $site_id_s=get_site_session1();
    
    //$site_id=547;
    $inks=0;
    echo "SITE TAKEN FROM SESSION IS ".$site_id_s;
    for($i=0;$i<20;$i++)
    {
        echo $i;
        if($i==3)
        {    
         if($mobile_att=$detected_flag[1][3]) //here we return name mobile
            {
        echo "</BR>Detected mobiles: ".$mobile_att;
        echo "</BR>Weight: ".$detected_flag[1][3];
        
        //$stream_id=dbi_get_stream($stream_word);
        //dbi_write_att($site_id, $att, $stream_id);
          //have no stream, has their atts     
        
        // $stream_word="SDA";
                
                //its 93
                
                //$stream_id=dbi_get_stream($stream_word);
              //$site_id;
         $stream_id='A2';
                $att=1;
                dbi_write_att($site_id, $att, $stream_id);
                    
            }
        }
        
        
        if($detected_flag[1][$i])
        {
            
           //echo "detects ".$atts[0][$i];
           //echo " FL".$detected_flag[1][$i];
            
           if($i==9)
           {
                 if($detected_flag[0][9]==1) ///weeee
            {
                echo "</br></br>WEEE detected";
                $stream_word="SDA";
                
                //its 93
                
                $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=1;
               echo "YY DETECTED  ".$form_att[8];
                dbi_write_att($site_id, $att, $stream_id);
               
            }
        
           }
           
           if($i==11) //tvs
           {
                if($detected_flag[0][11]==1) //twv
                echo "TV detected";
                $stream_word="TV";
                
                //its 93
                
                $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=1;
                dbi_write_att($site_id, $att, $stream_id);
                
               
           }
            if($i==12) //tvs
           {
                if($detected_flag[0][12]==1) //twv
                echo "TV detected";
                $stream_word="TV";
                
                //its 93
                
                $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=1;
                dbi_write_att($site_id, $att, $stream_id);
                
               
           }
           
            if($i==13) //cds
           {
                if($detected_flag[0][13]==1) //twv
                echo "TV detected";
                $stream_word="CDs";
                
                //its 93
                
                $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=1;
                dbi_write_att($site_id, $att, $stream_id);
                
               
           } 
            if($i==17) //toners
           {
                if($detected_flag[0][17]==1) //twv
                echo "Toners detected";
                $stream_word="Toners";
                
                //its 93
                if($inks==1)
                {    
                $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=2;
                }
                else
                {
                     $stream_id=dbi_get_stream($stream_word);
                    $att=1;
                }
                    dbi_write_att($site_id, $att, $stream_id);
                
               
           } 
           
            if($i==14) //tvs
           {
                if($detected_flag[0][14]==1) //ink
                echo "Toners detected";
                $stream_word="Toners";
                
                //its 93
                $inks=1;
               // $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=1;
                
                //dbi_write_att($site_id, $att, $stream_id);
                
               
           }
           
             if($i==15) //bric
           {
                if($detected_flag[0][15]==1) //ink
                echo "Brick detected";
                $stream_word="Brick-a-Brack";
                
               
                $stream_id=dbi_get_stream($stream_word);
                $site_id;
                $att=3;
                
                dbi_write_att($site_id, $att, $stream_id);
                
               
           } 
            
        }
        
        
       
        
    }
    
    
    
    
    //insert deliveries for the first time()
}


/**
 * 
 * @param type $detected_flag
 * @param type $site_id
 */


function dbi_generate_delivery_dynamic_att($detected_flag,$site_id) //we will read from results from detect_att function
{
    
    //to be wrapped
       //get site from manifest counter
      // connect_dbi();
                        
echo "Generating dynamic delivery insert</BR>";
    
    $form_flag_att_name=$detected_flag[1];
    $flag_att=$detected_flag[0];
   
    
    //optimazie to store ins sesion
   echo $size_of_weee_cat=sizeof(get_weee_categories()[0]);
    
    print_r($form_flag_att_name);
    
    for($i=0;$i<$size_of_weee_cat;$i++)
    {
        //echo $i++;
        if(!empty($form_flag_att_name[$i]))
        echo "Detected ATTS: ".$form_flag_att_name[$i];
    }
    
 
           
         
                if($detected_flag[0][1]==1)  //if weee waste is set than generate delivery and insert
                {
                echo "WEEE Prepered to insert delievry";
                $stream_id="93";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
               
                if($detected_flag[0][11]==1) //tv  
                {
                echo "TV Prepered to insert delievry";
                $stream_id="TV";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
       
                 
               
               
                if($detected_flag[0][12]==1) //mobiles  
                {
                echo "TVs Prepered to insert delievry";
                $stream_id="A2";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
                
                 
               
                if($detected_flag[0][13]==1) //cd's  
                {
                echo "CD's Prepered to insert delievry";
                $stream_id="A1";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
          
                 if($detected_flag[0][14]==1) //toners  
                {
                echo "Toners Inks Prepered to insert delievry";
                $stream_id="99";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
                
                
                
                 if($detected_flag[0][15]==1) //bric  
                {
                echo "Bric Prepered to insert delievry";
                $stream_id="94";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
                
                
                 if($detected_flag[0][18]==1) //ferrous 
                {
                echo "Ferrous Prepered to insert delievry";
                $stream_id="18";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
                
                 if($detected_flag[0][19]==1) //non-ferrous  
                {
                echo "Non-ferrous Prepered to insert delievry";
                $stream_id="19";
                
               
                //$stream_id=dbi_get_stream_reverse($stream_id);
                $site_id;
                $att=1;
                
                dbi_write_att($site_id, $att, $stream_id);
                }
                
  
}



function dbi_write_att($site_id,$att,$stream_id)
{
    $date=date("Y-m-d");
    $user=convert_driver_id(get_driver_session());
    if(isset($_SESSION['MOD_DATE']))//here we update the implementation of dbr write att
    {
        $date=get_mod_date_session(); //only id even once session mod date set we are gona use it after using would be goood to unset it
    }
    echo $sql="INSERT INTO delivery(Trans_Category_Category_id,Site_site_id,date,picker1,trans_ref_num,closed,att_num) VALUES('$stream_id','$site_id','$date',$user,'1','0','$att')";
    $result=query_selecti($sql);
    //var_dump($result);
    mysqli_affected_rows($result);
    
    
    
}

function dbi_get_stream($stream_word)
{
    $sql="SELECT * FROM trans_category";
    $result=query_selecti($sql);
    $stream_id=array();
    $stream_name=array();
    $i=0;
    while($rek=mysqli_fetch_array($result))
    {
        $i++;
        $stream_id[$i]=$rek[0];
        $stream_name[$i]=$rek[1];
        if($stream_word==$stream_name[$i])
        {
            
           return $stream_id[$i];
           
        }
    }
    
    
    
    
    
}


function dbi_get_stream_reverse($stream_id)
{
    $sql="SELECT * FROM trans_category WHERE Category_id='$stream_id'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[1];
     
}


function finish_manifest($manifest_reg_id)
{
    
      //this two executed while closed link clicke
                         
                         $sql="UPDATE manifest_reg SET closed=0 WHERE idmanifest_reg='$manifest_reg_id'";
                         $result_closed=query_selecti($sql);
                         $rek=mysqli_fetch_array($result_closed);
                        $site_id=$rek[0];
                         
                        $sql="UPDATE manifest_counter SET finished=1 WHERE manifest_reg_idmanifest_reg='$manifest_reg_id'";
                         $result=query_selecti($sql);
                         $rek=mysqli_fetch_array($result);
                         $site_id=$rek[0];
}


/** Used in show_active(). This berely gets an active set of atts availible
 * @return number_of_att
 */
function get_size_of_att()
{
    $sql="SELECT * FROM att";
    $result=query_selecti($sql);
    return mysqli_num_rows($result);
}

function dbi_get_last_sticker($manifest_reg_id)
{
    
  $sql="SELECT end_dbs FROM manifest_reg WHERE idmanifest_reg='$manifest_reg_id'";
    $result=query_selecti($sql);
    $rek=mysqli_fetch_array($result);
    return $rek[0];
}


function dbi_set_last_sticker($manifest_reg_id,$last_sticker)
{
    
  $sql="UPDATE manifest_reg SET end_dbs='$last_sticker' WHERE idmanifest_reg='$manifest_reg_id'";
  $result=query_selecti($sql);
  //$rek=mysqli_fetch_array($result);
    
    
}