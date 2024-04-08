<?php

require_once ('config.php');
session_start();

$user_currency= "SELECT * FROM user where request_status=1";
$user_currency_result = mysqli_query($conn, $user_currency);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Admin</title>
</head>
<body>
<div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6 text-center">Requestes For purchasing our Coins or Withdraw Money</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tr class="bg-dark text-white">
                                <th>User Name</th>
                                <th>Phone</th>
                                <th>Requested Amount</th>
                                <th>Tnx id</th>
        

                            </tr> 
                            <?php
                                while($row = mysqli_fetch_assoc($user_currency_result))
                                {

                                    $username=$row['name'];
                                    $id=$row['id'];
                                    $phone = $row['request_phone'];
                                    $req=$row['request_amount'];
                                    $txn=$row['txn']
                                    

                            ?>
                                <td><?php echo $username; ?></td>
                                <td>0<?php echo $phone; ?></td>
                                <td><?php echo $req; ?></td>
                                <td><?php echo $txn; ?></td>
                                <td><a href="recharge.php? approve=<?php echo $id; ?>" class="btn btn-primary">Approve</a></td>    
                                <td><a href="decline.php? dltid=<?php echo $id; ?>" class="btn btn-danger">Decline</a></td>

                                </tr> 

                                <?php
                                }
                                ?> 

                        </table>

                    </div>


                </div>

            </div>

        </div>

    </div>
    

</div>
<div>
        <h2 class="display-6 text-center"><a href="logout.php"><button class="btn btn-danger" >logout</button></a> </h2>   
</div>    
</body>
</html>