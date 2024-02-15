<!-- 
// $fname = $_POST['fname'];
// $lname = $_POST['lname'];
// $email = $_POST['email'];
// $mobile = $_POST['mobile'];
// // $orderid = $_POST['orderid'];
// $amount = $_POST['amount'];
// $address = $_POST['address'];
// $city = $_POST['city'];
// $state = $_POST['state'];
// $pincode = $_POST['pincode'];
// $country = $_POST['country'];
// $pan = $_POST['pan'];

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "donation";

// $conn = new mysqli($servername, $username, $password,$dbname);
// if ($conn->connect_error) {
// 	echo "$conn->connect_error";
// 	die("Connection Failed : " . $conn->connect_error);
// } else {
// 	$stmt = $conn->prepare("insert into registration(fname, lname, email, mobile, amount, address, city ,state , pincode, country, pan) values(?, ?, ?, ?, ?, ? ,?, ?, ?,?, ?)");
// 	$stmt->bind_param("ssssisssiss", $fname, $lname, $email, $mobile, $amount, $address, $city, $state, $pincode, $country, $pan);
// 	$execval = $stmt->execute();
// 	echo $execval;
// 	echo "Registration successfully...";
// 	$stmt->close();
// 	$conn->close();
// } -->

<?php
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];

// Check if the amount is other or predefined
if ($_POST["amount"] == "other") {
    $amount = $_POST["customAmount"]; // If the amount is custom, fetch it from customAmount field
} else {
    $amount = $_POST["amount"]; // Otherwise, get the predefined amount
}

$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$pan = $_POST['pan'];

// $servername = "localhost";
// $username = "pswelfare_donadmin";
// $password = "sdjN?#l=I{;9";
// $dbname = "pswelfare_dondata";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donation";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "$conn->connect_error";
    die("Connection Failed : " . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO registration (fname, lname, email, mobile, amount, address, city, state, pincode, country, pan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisssiss", $fname, $lname, $email, $mobile, $amount, $address, $city, $state, $pincode, $country, $pan);
    $execval = $stmt->execute();
	echo $execval;
	echo "Registration successfully...";
	$stmt->close();
	$conn->close();
}
?>
