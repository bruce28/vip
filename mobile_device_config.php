<?php

 $dbs3_in="dbs3";
 $dbs3_out="dbs3";
        
 $username='root';
 $password='krasnal';

 $host_out="192.168.0.224";
  $host_out="192.168.0.225";
  $host_out="192.168.43.156";

/*
 $connect1=mysql_connect($host_out,$username,$pass);
$host_out="192.168.0.223";
$connect2=mysql_connect($host_out,$username,$pass);

$host_out="192.168.43.156";
$connect3=mysql_connect($host_out,$username,$pass);

if($connect1)
  $host_out="192.168.0.224";
else if($connect2)
    $host_out="192.168.0.223";
else if($connect3)
    $host_out="192.168.43.156";
  */  

    


mysql_close($connect1);
mysql_close($connect2);
mysql_close($connect3);

$host_out="192.168.43.156";
//$host_out="192.168.43.164";
$host_in="127.0.0.1"; //definition of inner host. Main host
     //$host_out="192.168.43.164";   
       
//$host_out="192.168.0.3";
//$host_out="192.168.0.26";
//$host_out="192.168.43.217";        
//$host_out="192.168.43.164";
//$host_out="192.168.0.21";
$host_out="192.168.0.11";
//$host_out="192.168.0.31";
//

//$host_out="10.0.1.4";

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


