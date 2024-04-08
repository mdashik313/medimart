
<?php
require_once ('config.php');
require_once('sendMail.php');



if(isset($_POST['set'])){

    $patient_id = $_POST['patient-id'];
    $disease = $_POST['disease'];
    $medicine = $_POST['medicine'];
    $email = "mdashik5360@gmail.com";
    $message = 'Dear sir, here are details of your prescription.
      Patient id: ' . $patient_id . '. 
      Disease name: '. $disease . '. 
      Medicine: ' . $medicine; 

    $query = "INSERT INTO prescription (patient_rfid, disease , medicine) VALUES ('$patient_id', '$disease', '$medicine')";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Data inserted";
        sendMail($message,$email);
    }else{
        echo "Data not inserted";
    }
}

if(isset($_POST['out'])){
  echo "<script>window.location.href='logout.php';</script>";
}



?>




<!DOCTYPE html>
<html>
<head>
	<title>Welcome Doctor </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">

    <h1>Patient List</h1>
		<table>
			<thead>
				<tr>
					<th>Patient ID</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				<tr>
                <?php
                    $query = "SELECT * FROM user WHERE category = 'customer'";
                    $result = mysqli_query($conn, $query);
                    if($result){
                       while($row= mysqli_fetch_assoc($result)){

                        $id = $row['patient_rfid'];
                        $name = $row['name'];
                       ?>
                          <td><?php echo $id; ?></td>
                        <td><?php echo $name; ?></td>
                        </tr> 
                        <?php
                       }
                    }
                    ?>
				
				<!-- Add more rows as needed -->
			</tbody>
		</table>
	</div>

		<h1>Welcome Doctor <?php //echo $doctor_name?>Shafayet</h1>
		<form action=""method="post">
			<label for="patient-id">Patient ID:</label>
			<input type="text" id="patient-id" name="patient-id">

			<label for="disease">Disease:</label>
			<input type="text" id="disease" name="disease">

			<label for="medicine">Medicine:</label>
			<input type="text" id="medicine" name="medicine">

			<input type="submit" value="Submit" name= "set">
			<input type="submit" value="Logout" name= "out">
      
		</form>
	</div>
</body>
</html>

<style>
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
    margin-bottom: 10px;
    font-weight: bold;
  }
  
  input[type="text"], input[type="submit"] {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: none;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
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
