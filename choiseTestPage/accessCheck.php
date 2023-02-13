<?php

$userAnsver = json_decode($_POST['topicAndNumberJSON']);


session_start();
$logAndPass = $_SESSION['session'];



$conn = mysqli_connect("localhost", "root", "", "RPrU");
$sql228 = "SELECT * FROM allTests WHERE logAndPass = '$logAndPass'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql228));

mysqli_close($conn);

$numberResult = [];
$result = [];

if(!empty($userAnsver)) {
    $fromSQL = str_split($row[$userAnsver[count(($userAnsver)) - 1]]);


    for($i = 0; $i < count($fromSQL); $i++) {
        if($fromSQL[$i] == ';') array_push($numberResult, $fromSQL[$i]);
    }

    array_push($result, $userAnsver[count($userAnsver) - 1], count($numberResult), $row);

    echo json_encode($result);
}





?>