<?php

require_once ('config.php');
session_start();

?>




<!DOCTYPE html>
<html>
<head>
	<title>Prescription</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include('nav.php'); ?>
	<div class="container">

    
	</div>
        <?php 
            $patient_rfid = $_SESSION['patient_rfid'];
            $query = "select * from prescription where patient_rfid=$patient_rfid";
            $result = mysqli_query($conn, $query);
            $disease = "";
            $medicine = "";
            $msg = "";
            if($result){
                if(mysqli_num_rows($result)){
                    $row = mysqli_fetch_array($result);
                    $disease = $row['disease'];
                    $medicine = $row['medicine'];
                    $msg = "You have a prescripton.";
                }
            }
            else {
                $patient_rfid = "";
                $msg = "Currently you don't have any prescription.";
            }
            

        ?>
		<h1>Welcome <?php echo $_SESSION['name'] . '. '. $msg;?></h1>
        <h3>
            <?php
                if(isset($_POST['dlt'])){
                    $patient_rfid = $_SESSION['patient_rfid'];
                    $query = "DELETE from prescription where patient_rfid=$patient_rfid";
                    $result = mysqli_query($conn, $query);
                    if($result){
                        echo "Prescription deleted";
                    }else{
                        echo "Error delting";
                    }
                }
            ?>
        </h3>
		<form action=""method="post">
			<label style="font-size: 20px;" for="patient-id">Patient ID:</label>
			<input style=" background-color: transparent;" readonly type="text" id="patient-id" name="patient-id" value="<?php echo $patient_rfid; ?>">

            <label style="font-size: 20px;" for="disease">Disease:</label>
			<input style=" background-color: transparent;" readonly type="text" id="disease" name="disease" value="<?php echo $disease; ?>">
			
            <label style="font-size: 20px;" for="medicine">Medicine:</label>
			<input style=" background-color: transparent;" readonly type="text" id="medicine" name="medicine" value="<?php echo $medicine; ?>">

            <a href="user.php">Buy medicine</a>
			<input style="font-size: 17px;" type="submit" value="Delete prescription" name= "dlt">

		</form>
	</div>
</body>
</html>

<style>
    a {
        text-decoration: none;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: none;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        text-align: center;

    }
    a:hover {
        background-color: #3e8e41;
    }
  .container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  label {
    margin-bottom: ;
    font-weight: bold;
  }
  
  input[type="text"], input[type="submit"] {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: none;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
    font-size: 20px;
  }
  
  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
  }
  
  input[type="submit"]:hover {
    background-color: #3e8e41;
  }
  table {
	border-collapse: collapse;
	width: 100%;
}

th, td {
	padding: 10px;
	text-align: left;
	border-bottom: 1px solid #ddd;
}

th {
	background-color: #4CAF50;
	color: white;
}

tr:nth-child(even) {
	background-color: #f2f2f2;
}

</style>