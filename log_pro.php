<?php
session_start();
//definicja funkcji kt�ra przekierowywuje na inn� stron�

session_unset();

$url="login.php";

function redirect($gdzie, $czas)
{
    echo "<head><meta http-equiv=\"Refresh\" content=\"$czas; URL=$gdzie\" /></head>";
}


mysql_connect('localhost', 'root', 'krasnal');
mysql_select_db('dbs3');


   if(!empty($_POST['login']) && !empty($_POST['pass'])){
   
   $sql = mysql_query('SELECT * FROM User_2 WHERE login = "'.$_POST['login'].'"');
   $ile = mysql_num_rows($sql).'<br>';
   
   if($ile == 0){
      echo 'Incorrect login<br>';
      redirect($url,3);
   }
   
   $result = mysql_fetch_array($sql);
   
   if(($_POST['login'] == $result['login']) && ($_POST['pass'] == $result['pass'])){
			echo 'Please wait...Loading System in Progress...';
			$_SESSION['logged']=1;
            $_SESSION['priv']=$result['priv'];
			$_SESSION['l_klient']=$_POST['login'];
            $_SESSION['name1']=$result['name'];
                        $_SESSION['id_user']=$result['id_user'];
			$url="index.php";
			redirect($url,2);
                        
                        if($result['priv']==1)
                        {
                        $url="test7/add_stock.php";
			redirect($url,2);  
                        }
                            
                 
   }else {
      echo 'Wrong Data!';
      redirect("login.php",2);
   }
   
   }else{
      echo 'Given Data not sufficient!';
      redirect($url,2);
   }
   

?>