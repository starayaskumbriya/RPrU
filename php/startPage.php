<?php
// include_once 'choiseTestPage/tests/RPrU/generalPHP/form.php';


$logPass = json_decode($_POST['logPassJSON']);
// echo json_encode($logPass);


      
// $conn = mysqli_connect("localhost", "capybara_vlad", "mQMch75rzZwLHgM", "capybara_RPrU");
// $sql = "INSERT INTO logAndPass (log, pass) VALUES ('$logPass[0]', '$logPass[1]')";
// mysqli_query($conn, $sql);
// mysqli_close($conn);

// $conn = mysqli_connect("localhost", "root", "", "RPrU");
// $sql = "INSERT INTO logAndPass (log, pass) VALUES ('$logPass[0]', '$logPass[1]')";
// mysqli_query($conn, $sql);
// mysqli_close($conn);

// $conn = mysqli_connect("localhost", "root", "", "RPrU");
// $sql = "CREATE TABLE MyGuests (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     firstname VARCHAR(30) NOT NULL,
//     lastname VARCHAR(30) NOT NULL,
//     email VARCHAR(50),
//     reg_date TIMESTAMP
//     )";
// mysqli_query($conn, $sql);
// mysqli_close($conn);

// $toForm = $logPass[0] + '_' + $logPass[1];
// Header('Location: choiseTestPage/tests/RPrU/generalPHP/form.php?get=$toForm');

$answer = [];
$flagArr = [];
session_start();
$logAndPassToForm = $logPass[0]."_".$logPass[1];
// $_SESSION['session'] = $logAndPassToForm;
$_SESSION['session'] = $logAndPassToForm;
// array_push($_SESSION['session'], $logAndPassToForm, 228);


$conn = mysqli_connect("localhost", "root", "", "RPrU");

$sql228 = "SELECT * FROM allTests";
if($result = mysqli_query($conn, $sql228)){
    while($row = mysqli_fetch_array($result)){
        if($row["logAndPass"] == $logAndPassToForm) array_push($flagArr, $row["logAndPass"]);
    }
}

if(count($flagArr) == 0) array_push($answer, 0);
else array_push($answer, 1);






// $conn = mysqli_connect("localhost", "root", "", "RPrU");
// $sql = "INSERT INTO main (logAndPass) VALUES ('$logPass[0]_$logPass[1]')";
// mysqli_query($conn, $sql);
// mysqli_close($conn);


echo json_encode($answer);
?>