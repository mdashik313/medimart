<?php
    require_once ('config.php');
    session_start();
    
    if(isset($_GET['approve'])){
        $id = $_GET['approve'];
        $query1="SELECT * FROM user WHERE id = $id";
        $result1 = mysqli_query($conn, $query1);
        if($result1){
            $row=mysqli_fetch_assoc($result1);
            $value=$row['request_amount'];
            $status=$row['request_status'];
        }
        if($status==1){
            $query ="UPDATE user SET request_status =0,request_amount=0,currancy=currancy+$value,request_phone='0',txn='0' WHERE id = $id";
            $result = mysqli_query($conn, $query);
            if($result>0){
                echo "<script>window.location.href='admin.php';</script>";
            }else{
                echo "ERRORS";
            }
        }
       else{
         
       }

}
        

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recharge</title>
</head>
<body>
    
</body>
</html>