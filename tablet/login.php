<?php

session_start();
include 'first_lvl_api.php';
include 'header_mysql_tablet.php';

?>
 

<html>
    <head>
        <title>GRR Collection System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1">
        <link rel="stylesheet" href="jquery.mobile/jquery.mobile-1.4.4.min.css"/>
        <script src="jquery-2.1.1.js"></script>
        <script src="jquery.mobile/jquery.mobile-1.4.4.min.js"></script>
    </head>
    <body>
        
        
        <div id="login" data-role="page" data-title="Login"
        data-theme="b">
        
            <div data-role="header">
			
	      	
                <h1>Green Resource Recycling Ltd.</h1>
                	
                <a href="#" data-role="button" data-rel="back" data-transition="flip" data-icon="back" data-iconpos="notext">Go back</a>
               
                
                
                
                
            </div> <!--Header-->
            
            <?php //echo "logged ".$_SESSION['l_klient'] ?>
            <div data-role='content'>
				
				<div data-role="control-group">
				<form method="POST" action="login.php">
				<p>
					<div data-inline="true">Login:</div>
					<div data-inline="true"><input type="text" name="login" value=""
					 </div
				</p>
				</div>
				<p>
					Password:
					<input type="password" name="password" value=""
				</p>
				<div data-inline="true"><input type="Submit" name="login_send" value="Login" data-role="button"></div>
				</form>
				
			</div>
					
				
			<div 
			data-role='footer' 
			data-position='fixed'
			data-id='vs_footer'
			data-fullscreen='true'>
			
			
		
			</div> <!--Footer-->
        
        </div> <!--Page site-->
        
        <div id="1" data-role="page">
		<div data-role='content'>
			
				<div><p>Given data were wrong</p></div>
		</div>
		
		</div>
		
		
        
    </body>
    
  <?php

//definicja funkcji która przekierowywuje na inn¹ stronê

session_unset();

$url="tablet.php";

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


$mysqli=new mysqli('localhost', 'root', 'krasnal','dbs3');
//mysql_select_db('dbs3');


if(isset($_POST['login_send']))
{
   
   if(!empty($_POST['login']) && !empty($_POST['password'])){
   
   $result=$mysqli->query('SELECT * FROM user_2 WHERE login = "'.$_POST['login'].'"')or trigger_error($mysqli->error."[$sql]");
   //$ile = mysqli_num_rows($sql).'<br>';
   
   if($ile == 0){
      echo 'Incorrect login<br>';
      //redirect($url,3);
   }
   
   //$result = mysqli_fetch_array($sql);
   $rek=$result->fetch_array(MYSQLI_BOTH);
   
   if(($_POST['login'] == $rek['login']) && ($_POST['password'] == $rek['pass'])){
			echo 'Please wait...Loading System in Progress...';
			
			//echo "window.location='/'"
			
			
			$_SESSION['logged']=1;
            $_SESSION['priv']=$rek['priv'];
			$_SESSION['l_klient']=$_POST['login'];
            $_SESSION['name1']=$rek['name'];
                        $_SESSION['id_user']=$rek['id_user'];
			//$url="index.php";
			redirect($url,0);
            //echo "<script>$.mobile.navigate('#process')</script>";     
   }else {
      echo 'Wrong Data!';
      session_unset();
      redirect($url,0);
   }
   
   }else{
     echo 'Given Data not sufficient!';
     session_unset();
     redirect($url,0);
   }
   
}
?>
   
    
</html>
