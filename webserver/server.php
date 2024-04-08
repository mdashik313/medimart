<?php
require_once('config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';



function sendMail1($email,$pass){
    $message = "Hello Abu Bakar Fahad. You are a verified customer. Website : https://medimatuiu.000webhostapp.com/ . Your user name : Abu Bakar Fahad, Temporary PIN number : ";
    $message = $message . $pass;    
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;
    $mail->Username = 'mashik201123@bscse.uiu.ac.bd'; // email
    $mail->Password = 'ashik1ashik'; // password
    $mail->setFrom('mashik201123@bscse.uiu.ac.bd', 'Medimart UIU'); // From email and name
    $mail->addAddress($email, 'Abu Bakar Fahad'); // to email and name
    $mail->Subject = 'RFID verification is successful';
    $mail->msgHTML($message); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
    $mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
    // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
        echo "Message sent!";
    }
}
function sendMail2($email,$pass){
    $message = "Hello Md Ashik. You are a verified customer. Website : https://medimatuiu.000webhostapp.com/ . Your user name : Md Ashik, Temporary PIN number : ";
    $message = $message . $pass; 
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;
    $mail->Username = 'mashik201123@bscse.uiu.ac.bd'; // email
    $mail->Password = 'ashik1ashik'; // password
    $mail->setFrom('mashik201123@bscse.uiu.ac.bd', 'Medimart UIU'); // From email and name
    $mail->addAddress($email, 'Md Ashik'); // to email and name
    $mail->Subject = 'RFID verification is successful';
    $mail->msgHTML($message); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
    $mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
    // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }else{
        echo "Message sent!";
    }
}

if (isset($_POST['check_medicine_status'])) {

    $query = "SELECT * FROM medicine WHERE buying_status=1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_assoc($result);
        $rem = $row['item_remaining'];
        $medicine_id = $row['id'];
        if($row['item_remaining']!=0){
            
            $query = "UPDATE medicine SET item_remaining =$rem - 1,buying_status=0  WHERE id = $medicine_id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if($medicine_id==1) {
                    if($row['quantity']==1){
                        echo "11";
                    }
                    else echo "12";
                }
                else if($medicine_id==2) {
                    if($row['quantity']==1){
                        echo "21";
                    }
                    else echo "22";
                }
                
            } else {
                echo "error_updating";
            }
        }
        else {
            // $query = "UPDATE medicine SET buying_status=0  WHERE id = $medicine_id";
            // $result = mysqli_query($conn, $query);

            // if ($result) {
            //     if($medicine_id==1) echo "1";
            //     else if($medicine_id==2) echo "2";
            //     else if($medicine_id==3) echo "3";

            // } else {
            //     echo "error_updating";
            // }
            echo "error_updating";
        }
    } else {
        echo "no_res_found";
    }
}

if(isset($_POST['rfid'])){
    $rfid = $_POST['rfid'];

    //generate random pass and save to db
    $random_number = rand(1000, 9999);
    $pass = $random_number . "";
    $query = "UPDATE user SET password = '$pass'  WHERE patient_rfid = $rfid";
    $result = mysqli_query($conn, $query);
    if($rfid == 1){
        sendMail1("afahad201119@bscse.uiu.ac.bd",$pass);
    }
    else if($rfid == 2){
        sendMail2("mdashik5360@gmail.com",$pass);
    }
}
?>
