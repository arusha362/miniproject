<?php
$username = $_POST['user'];
$password = $_POST['user_pass'];
$email = $_POST['mail'];
$phonecode = $_POST['phoneCode'];
$phone = $_POST['mob_digits'];

if(!empty($username) || !empty($password) || !empty($email) || !empty($phonecode) || !empty($phone)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "registered_gf";
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if(mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect())
    } else {
        $SELECT = "SELECT email From register Where email = ? Limit 1";
        $INSERT = "INSERT Into register (user, user_pass, mail, phoneCode, phone) values(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if($rnum==0){
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sssii", $username, $password, $email, $phoneCode, $phone);
            $stmt->execute();
            echo "New record inserted sucessfully";
        } else {
            echo "Someone already register using this email";
        }
        $stmt->close();
        $conn->close();

    }
} else{
    echo "All fields are required";
    die();
}
?>
