<!DOCTYPE html>

<?php
session_start();

require 'header_mysql_tablet.php';
connect_dbi();

//Here we process customer form. No need to organise functions since these are used once only for that module

function dbi_check_customer($post_code)
{
    $sql="SELECT * FROM origin WHERE post_code ='$post_code'";
    $result=query_selecti($sql);
    //mysqli_fetch_array($result);
    $num=mysqli_num_rows($result);
    if($num==0)
    return 0;
    else 
        return $num; 
}

function dbi_add_new_customer($sql_query)
{
   //get special source id
    
    
    
  
}

function check_emptiness_array($array)
{
    $status=0; //status says that array is not validated correctly by default
    
    $size=sizeof($array);
    echo "Size".$size." s";
    $size--; //means dont calculate the last one that shoulkd be submit button
    
    /*
    for($i=0;$i<$size;$i++)
    {
        echo "Counter".$i;
        //echo $array[$i][1];
        
        //we go through fields that many times, that the size of initialized arrat values
        if(empty($array[$i]))
        echo $status=0;   //if any input value is empty than set
        else
          echo $status=1;
        
        
    }
    */
    $i=0;
    foreach ($array as $data)
    {
        $i++;
        echo "foreach";
        echo $data;
        if(empty($data))
            $status=1;
        else
            $status=0;
    }
    
    return $status;
    
}


?>

<html>
<head>
	<title>Page Title</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="jquery.mobile/jquery.mobile-1.4.4.css" />
        <script src="jquery-2.1.1.js"></script>
        <script src="jquery.mobile/jquery.mobile-1.4.4.js"></script>
</head>
<body>

<div id="customer" data-role="page"
     data-theme="b">

	<div data-role="header">
		<h1>Green Resource Recycling Ltd.</h1>
                <a href="tablet.php" >Go back</a>
	</div><!-- /header -->

        <?php
       $MESSG="INPUT DATA"; 
        if(isset($_POST['add']))
        {
            echo "Processing";
            //print_r($_POST);
           // echo "Result of emptiness ".check_emptiness_array($_POST);
            
            $name=$_POST["name"];
            $surname=$_POST["surname"];
            $company_name=$_POST["company_name"];
            $house=$_POST["house"];
            $street=$_POST["street"];
            $post_code=$_POST["post_code"];
            $town=$_POST["town"];
            $email=$_POST["email"];
            $phone=$_POST["phone"];
           
            
            
            
            
            if(dbi_check_customer($post_code)>0)
            {
                echo "Already exists";
                $MESSG="EXISTS";
             //   echo '<a href="#messages" id="mess" onLoad="message()">comm</a>';
                
                
                
            }
            else
            {
                //do the code
                
                $CID='CID';
                //if not exist build query
              
              if(!empty($post_code)AND !empty($name)AND !empty($surname)AND !empty($town)) //add only when main values not empty 
              {
              echo $prepared_customer_statement="INSERT INTO origin(Source_source_id,company_name,name,surname,post_code,house_number,street,town,email,phone) VALUES('$CID','$company_name','$name','$surname','$post_code','$house','$street','$town','$email','$phone')";
                
              
                query_selecti($prepared_customer_statement);
                $MESSG="ADDED SUCCESSFULY";
                
              }
              else
              {
                  echo "Could not add any";
              $MESSG="Could not add any";
              }
            }
            
            
            //ADDING INTO DB TABLE - steps
            
            
            
            //check if not already there. A fresh copy from root
            
            
            
            //if not there than add a new one. inform is added. redirect to tablet
            
            
            
            
            
            
  
        }
        ?>
        
	<div role="main" class="ui-content">
		<p><h3>Add a new customer</h3></p>
                <div data-role="controlgroup">
                <form action="customer.php" METHOD="POST">
                    <input type="text" name="name" value="<?php if(isset($name))echo $name;?>" placeholder="Name..">
                    <input type="text" name="surname" value="<?php if(isset($surname))echo $surname;?>" placeholder="Surname..">
                    <input type="text" name="company_name" value="<?php if(isset($company_name))echo $company_name;?>" placeholder="Company name..">
                     <input type="text" name="house" value="<?php if(isset($house))echo $house;?>" placeholder="House number">
                    <input type="text" name="street" value="<?php if(isset($street))echo $street;?>" placeholder="Street adress">
                    <input type="text" name="post_code" value="<?php if(isset($post_code))echo $post_code;?>" placeholder="Post code">
                    <input type="text" name="town" value="<?php if(isset($town))echo $town;?>" placeholder="Town">
                    <input type="text" name="email" value="<?php if(isset($email))echo $email; ?>" placeholder="E-mail">
                    <input type="text" name="phone" value="<?php if(isset($phone))echo $phone; ?>" placeholder="Phone">
                    <input type="Submit" name="add" value="Add">
                </form>
                </div>
                
                
	</div><!-- /content -->
        <div>
            
            <?php echo $MESSG;?>
           </div>
	<div data-role="footer">
		<h4></h4>
	</div><!-- /footer -->
</div><!-- /page -->


<div id="messages" data-role="page">
   <p> <?php echo $MESSG; ?></p>
</div>
<script>
   function message(){
       document.getElementById("mess").click();
       
   }; 
</script>
</body>
</html>