<?php
$username = $_POST['username'];
$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);
$gender = $_POST['gender'];
$address= $_POST['address'];
$email = $_POST['email'];
$phoneCode = $_POST['phoneCode'];
$phone = $_POST['phone'];
if (!empty($username) || !empty($password) || !empty($gender) ||!empty(address) || !empty($email) || !empty($phoneCode) || !empty($phone)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "covid19_patient_management";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From patient Where email = ? Limit 1";
     $INSERT = "INSERT Into patient (username, password, gender, address, email, phoneCode, phone) values(?, ?, ?, ?, ?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $stmt->store_result();
     $stmt->fetch();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssssii", $username, $password, $gender, $address, $email, $phoneCode, $phone);
      $stmt->execute();
      echo "New record inserted sucessfully";
	  header("location: login.php");
     } else {
      echo "Someone already patient using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>