<?php

require_once('config.php');
require_once('sendMail.php');
session_start();

$user_id = $_SESSION['id'];
$query1 = "SELECT * FROM user WHERE id = $user_id";
$result1 = mysqli_query($conn, $query1);
$row = mysqli_fetch_assoc($result1);
$u_name = $row['name'];
$u_balance = $row['currancy'];
$u_email = $row['email'];

if (isset($_POST['buy'])) {

    $medicine_id = $_POST['medicine_id'];
    $selected_value = $_POST['quantity'];
	//echo "Selected value is: " . $selected_value;
    $cur_val = $_SESSION['currancy'];
    $email = "afahad201119@bscse.uiu.ac.bd";
   

    if($medicine_id!="$"){
        $price = 0;
        $pric = "";
        $m_name = "";
        if($medicine_id==1) {
            $m_name = "Napa extra 500 mg";

            if($selected_value==1){
                $price = 30;
                $pric = "30";
                $cur_val -= 30;
            }
            else if($selected_value==2){
                $price = 60;
                $pric = "60";
                $cur_val -= 60;
            }
        }
        else {
            $m_name = "Pantonyx 20 mg";

            if($selected_value==1){
                $price = 50;
                $pric = "50";
                $cur_val -= 50;
            }
            else if($selected_value==2){
                $price = 100;
                $pric = "100";
                $cur_val -= 100;
            }
        }
        echo "value : " . $selected_value . " id : " . $medicine_id;
        $u_id =  $_SESSION['id'];
        $cur_vall = $cur_val . "";
        $query = "UPDATE medicine SET buying_status = 1,quantity = $selected_value  WHERE id = $medicine_id";
        $result = mysqli_query($conn, $query);
        $query = "UPDATE user SET currancy=currancy-$price  WHERE id = $u_id";
        $result = mysqli_query($conn, $query);
        $msg = "You have bought " . $m_name . ". Quantity : " . $selected_value . ". Price : " . $pric . ". Your current balance : " . $cur_vall;
        sendMailPurchase($msg,$u_email,$u_name);
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main_div">
        <nav>
            <h1>Medimart UIU</h1>
            <div class="cred">
                <p>User : <?php echo $u_name;?>  <br> Balance : <?php echo $u_balance;?> TK</p>
                <a href="index.php"><button>Logout</button></a>
            </div>

        </nav>

        <div class="main_body">

            <div class="recharge">
                <div style="margin-left: 28px;margin-bottom:-10px">
                    <?php
                    if (isset($_POST['request'])) {

                        $currency = $_POST['currency'];
                        $user_id = $_SESSION['id'];
                        $req_phone = $_POST['req_phone'];
                        $txn = $_POST['txn'];

                        $query1 = "SELECT * FROM user WHERE id = $user_id";
                        $result1 = mysqli_query($conn, $query1);

                        if ($result1) {
                            $row = mysqli_fetch_assoc($result1);
                            $request_status = $row['request_status'];

                            if ($request_status == 1) {
                                echo "You have already sent a request. Have to wait until the request is approved or rejected before making next currency request";
                            } else {
                                $query = "UPDATE user SET request_status =1,request_amount=$currency,request_phone='$req_phone',txn='$txn'  WHERE id = $user_id";
                                $result = mysqli_query($conn, $query);
                                if ($result > 0) {
                                    echo "Request send";
                                } else {
                                    echo "Request not send";
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <div class="rech">

                    <p>Steps to recharge your account <br> 1.Choose ammount to be recharged. <br>2.Pay the money through Bkash at : <span>01883983907</span> <br> 3.Fill the other fields</p>
                    <form action="" method="post">
                        <table>
                            <tr>
                                <td>
                                    <input required placeholder="Recharge ammount" type="text" name="currency">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input required placeholder="Sender phone number" type="text" name="req_phone">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input required placeholder="Tnx id" type="text" name="txn">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="submit" name="request">Request</button>
                                </td>
                            </tr>
                        </table>


                    </form>
                </div>
            </div>

            <div class="buy">
                <form method="post">
                    <h1 style="margin-left:40px;">Please choose your desired medicine</h1>

                    <table style="margin-left:40px;">
                        <tr>
                            <td style="color:black;">Please select an item</td>
                        </tr>
                        <tr>
                            <td>

                                <input onchange="printSelectedOption();" type="radio" id="1" name="option" value="Napa 500mg">
                                <label style="font-size: 25px;" for="option1">Napa 500mg </label> <br>
                            </td>
                        </tr>

                        <tr>
                            <td>

                                <input onchange="printSelectedOption();" type="radio" id="2" name="option" value="Pantonyx 20mg">
                                <label style="font-size: 25px;" for="option2">Pantonyx 20mg </label>
                            </td>
                        </tr>

                        <tr>
                            <td>

                                <!-- <input onchange="printSelectedOption();" type="radio" id="3" name="option" value="Pantonyx 20mg">
                                <label style="font-size: 25px;" for="option3">Pantonyx 20mg </label> -->
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label style="color:black;" id="selected_item"></label>
                            </td>
                        </tr>

                        <!-- <tr>
                            <td>
                                <input required style="height: 28px;border: 1px solid white;" type="password" id="confirm_pass" name="option" placeholder="Enter your password">
                            </td>
                        </tr> -->

                        <tr>
                            <td>
                                <label style="font-size: 23px;" for="quantity">Quantity:</label>
                                    <select id="dropdown" name="quantity">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                    <br><br>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input onclick="purchase();" style="height: 28px;border: 1px solid white;" type="submit" name="buy" value="Confirm">
                                <input type="hidden" id="medicine_id" name="medicine_id" value="$">
                            </td>
                        </tr>
                    </table>
                    <p id="purchase-msg" style="margin-left:40px;margin-top:10px;"> <?php if (isset($_POST['buy']) && $medicine_id!="$") echo "Thank you for purchasing. <br> Please wait for dropping your medicine."; ?> </p>
                </form>

                <div id="result"></div>

                <script>
                    function printSelectedOption() {
                        var selectedOption = document.querySelector('input[name="option"]:checked');
                        if (selectedOption) {
                            var item = "";
                            if (selectedOption.value == "Napa 500mg")
                                item = "You have selected Napa 500mg. Price : 30 TK"
                            else if (selectedOption.value == "Pantonyx 20mg")
                                item = "You have selected Pantonyx 20mg. Price : 50 TK"
                            // else if (selectedOption.value == "Pantonyx 20mg")
                            //     item = "You have selected Pantonyx 20mg. Price : 20 TK"
                            document.getElementById('selected_item').innerText = item;
                        }
                    }

                    function purchase() {
                        var selectedOption = document.querySelector('input[name="option"]:checked');
                        if (selectedOption) {
                            var id;
                            if (selectedOption.value == "Napa 500mg") {
                                id = 1;
                            } else if (selectedOption.value == "Pantonyx 20mg") {
                                id = 2;
                            } else if (selectedOption.value == "Pantonyx 20mg") {
                                id = 2;
                            }
                            document.getElementById('medicine_id').value = id;
                            //document.getElementById('purchase-msg').innerHTML = "Thank you for purchasing";
                        }
                    }
                </script>
            </div>
        </div>

    </div>



</body>

</html>