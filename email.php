
<?php
include('PHPMailer-master\PHPMailer-master\class.smtp.php');
include('PHPMailer-master\PHPMailer-master\class.phpmailer.php');



function new_line($GME)
{
    $data="</BR>";
    $data=$GME;
    return $data;        
}

//$mail->send();

function send_email($data)
{
    $mail = new PHPMailer(true);

//Send mail using gmail
$send_using_gmail="true";
if($send_using_gmail){
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "tls"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 587; // set the SMTP port for the GMAIL server
    $mail->Username = "dbs3.grr.4@gmail.com"; // GMAIL username
    $mail->Password = "dbs312grr"; // GMAIL password
}

    
  $email="dbs3.grr.4@gmail.com";
$name="DBS3";
$email_from="dbs3.grr.4@gmail.com";
$name_from="Import module NEW";
//Typical mail data
$mail->AddAddress($email, $name);
$mail->SetFrom($email_from, $name_from);
$mail->Subject = "Import";
$mail->Body = "Import details: ".$data;




try{
    $mail->Send();
    echo "Success!";
} catch(Exception $e){
    //Something went bad
    echo "Fail :(";
    echo $e;
    //exit();
}


}
?>
