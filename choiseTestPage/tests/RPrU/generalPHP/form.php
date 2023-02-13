<?php
// include_once '../../../../php/startPage.php';

$userAnsver = json_decode($_POST['answerJSON']);
$rightArr = 
[
    ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '2', '23', '8', '23', '12', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
    ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '1', '2', '23', '3', '2', '23', '8', '23', '3', '23', '11', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
    ['', '', '', '', '13', '24', '14', '19', '', '', '', '', '', '', '', '', '', '22', '', '', '18', '', '', '', '', '', '', '1', '2', '23', '15', '23', '3', '26', '17', '9', '23', '12', ''],
    ['', '', '', '', '13', '24', '14', '19', '', '', '', '', '', '', '', '', '', '22', '', '', '18', '', '', '', '', '', '', '1', '2', '23', '15', '23', '3', '26', '17', '23', '12', '', '', '', '', '', '', '', '', '21', '', '', '', '', '', '', '', '', '', '', '', '', '7', '', '', '', '', '', ''],
    ['', '1', '2', '23', '3', '2', '23', '5', '9', '23', '12', '', '', '', '', '', '', '', '', '', '21', '', '', '', '', '', '', '', '', '', '', '', '', '6', '', '', '', '', ''],
    ['', '', '1', '2', '23', '15', '23', '3', '23', '3', '25', '11', '', '', '', '', '', '', '21', '', '', '', '', '18', '', '', '', '', '', '', '', '14', '24', '16', '24', '10', '20', '', ''],
    ['', '1', '2', '3', '2', '5', '2', '4', '2', '8', '3', '11', '', '', '', '', '', '', '21', '', '', '', '', '', '', '', '', '', '', '', '', '7', '', '', '', '', '', '', ''],
    ['1', '9', '23', '3', '5', '2', '23', '4', '2', '23', '8', '3', '11', '', '', '', '', '21', '', '', '', '', '', '', '', '', '', '', '', '', '6', '', '', '', '', '', '', '', ''],
    ['1', '2', '23', '3', '5', '2', '23', '4', '2', '23', '8', '3', '11', '', '', '', '', '21', '', '', '', '', '', '', '', '', '', '', '', '', '6', '', '', '', '', '', '', '', ''],
    ['1', '2', '23', '3', '2', '23', '5', '9', '23', '3', '23', '11', '', '', '', '', '', '', '', '21', '', '', '', '', '', '', '', '', '', '', '', '', '7', '', '', '', '', '', ''],
    ['', '', '', '', '34', '20', '9', '25', '20', '32', '', '', '', '', '', '', '', '28', '29', '32', '30', '37', '22', '', '', '', '1', '2', '3', '2', '27', '13', '7', '', '', '15', '18', '3', '11', '', '', '', '', '28', '22', '', '31', '36', '21', '', '', '', '', '', '', '', '35', '19', '9', '26', '19', '33', '', '', '']
];
$goodAnsver = [];
$badAnsver = []; 
$withoutEmptyString = [];

for($i = 0; $i < count($rightArr[$userAnsver[1] - 1]); $i++) {
    if($userAnsver[0][$i] === $rightArr[$userAnsver[1] - 1][$i] && $rightArr[$userAnsver[1] - 1][$i] !== '') array_push($goodAnsver, $i + 1);
    if($userAnsver[0][$i] !== $rightArr[$userAnsver[1] - 1][$i]) array_push($badAnsver, $i + 1);
    if($rightArr[$userAnsver[1] - 1][$i] !== "") array_push($withoutEmptyString, $i + 1);
}
$mark = count($goodAnsver) / count($withoutEmptyString) * 10;




session_start();
$logAndPass = $_SESSION['session'];


$columnName = 'RPrU'.$userAnsver[1];
$conn = mysqli_connect("localhost", "root", "", "RPrU");


$stolbec_logPass = '';


$sql228 = "SELECT * FROM allTests WHERE logAndPass = '$logAndPass'";
$stolbec_logPass = mysqli_fetch_array(mysqli_query($conn, $sql228))["$columnName"];   //вроде круто работает
// $row = $row["0"];

// $sql228 = "SELECT * FROM allTests";
// if($result = mysqli_query($conn, $sql228)){
//     while($row = mysqli_fetch_array($result)){
//         $stolbec_logPass = $row["$columnName"];
//     }
// }
   





$sql = "UPDATE allTests SET $columnName = '$stolbec_logPass$mark;' WHERE logAndPass = '$logAndPass'";
$countAttemptsArr = [];
$numberAttempts = str_split($stolbec_logPass);
for($i = 0; $i < count($numberAttempts); $i++) {
   if($numberAttempts[$i] == ';') array_push($countAttemptsArr, $numberAttempts[$i]);
}

if(count($countAttemptsArr) < 3) mysqli_query($conn, $sql);
mysqli_close($conn);


echo json_encode([$rightArr, $goodAnsver, $badAnsver, $mark, count($countAttemptsArr)]);

?>