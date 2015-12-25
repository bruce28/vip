<?php



include 'functions_output.php';


connect_db();



for($i=0;$i<100;$i++)
{
  $rev="revise".$i;  
  $sub="sub_cat".$i;
if(isset($_POST[$rev]))
{
    echo $id_c=$_POST[$sub];
    
    
}

}
if(isset($_POST['id_cat']))
{
    $id_c=$_POST['id_cat'];
}





if(isset($_POST['deactivate']))
{
     deactivate_trace(get_active_trace($id_c),$id_c); //prtotype 
    
}








?>
<HTML>
    <HEAD>
      <link rel="stylesheet" href="layout.css " type="text/css">
      <link rel="stylesheet" href="form_cat.css " type="text/css">
        
      <style>
          td {
              text-align:center;}
          
      </style>
      
    </HEAD>
    <BODY>
      <?php
      
      //connect_db();
      echo "<table><th>weight n-1</th><th>weight n<th></th><tr><td>";
      echo get_standard_weight($id_c);
      echo "</td><td>";
      echo get_weight($id_c);
      echo "</td><td>";
      if(check_trace($id_c)==0);
      
      
      
      
      
      
      echo "</td></tr></table>"; 
      
      ?>
        </BR></BR>
      <?php
      $date_started=date("Y-m-d");
        echo "<form action='sub_cat_revise.php' method='POST'>";
        echo "<input type='text' name='date_started' value='".$date_started."' placeholder='date_started'></BR>";
        echo "<input type='text' name='weight' value='' placeholder='weight...'></BR>";
        echo "<input type='text' name='cat' value='' placeholder='category..'></BR>";
         echo "<input type='hidden' name='id_cat' value='".$id_c."' ></BR>";
        echo "<input type='Submit' name='insert' value='Add token trace'>";
        echo "</form>";
      
      ?>
        
        <?php
          if(isset($_POST['insert'])) //if insert is submited
          {
              echo "Adding token";
              //if all data are valid and set
              if(!empty($_POST['date_started']) AND !empty($_POST['weight'])AND !empty($_POST['cat']))
              {
                 echo "token generated"; 
                  
                 
                 //casting to local variables
                 
                 //$date_started=date("Y-m-d");
                 if(!empty($_POST['date_started']))
                 {
                 $date_started=$_POST['date_started'];
                 }
                 $weight=$_POST['weight'];
                 $cat=$_POST['cat'];
                 
                 ///HERE WE BEGIN TRANSACTION
                 
                 
                 $GOOD_ACT=constraint_activation(check_activation($id_c));
                 
                 if($GOOD_ACT==1) //constraint activation returns 1 if the activation stack is correct, that means only one valid active category. It can also gives 
                 {                //result, that no active category 2 or no category at all 3
                     
                    echo "One active category, must be deactivated first";
                    
                    echo "<form action='sub_cat_revise.php' method='POST'>";
                    echo "<input type='hidden' name='id_cat' value='".$id_c."'>";
                    echo "<input type='Submit' name='deactivate' value='Deactivate'>";
                    echo "</form>";
                    //get_trace() is defined in tablet system in second API it actually takes a numeric value of item type and returns it's token. What if many??
                    //get_active_trace defined in second tablet API. It takes sub cat returns active idtrace. Does not have cheching of result consistency
                   
                     
                 }
                 else if($GOOD_ACT==2) //no active category
                 {
                     echo "No active category for item type yet. Assiging new one";
                     insert_token_trace($date_started,$weight,$cat,$id_c);  //syntax with parameters means add collected item type as token trace and upgrade it as new active category 
                 }
                 else if($GOOD_ACT==3) //not yet in trace token
                 {
                     echo "Not yet in token trace. Assiging the new one";
                     insert_token_trace($date_started,$weight,$cat,$id_c);
                 }
                 
                 //BUT first check a constraint activation. 
        
                   
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 //END TRANSACTION
              }
              
          }
        
        ?>
        
    </BODY>
    
    </HTML>