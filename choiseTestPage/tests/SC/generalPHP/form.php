<?php
$userAnsver = json_decode($_POST['answerJSON']);
$rightArr = 
[
    ['1', '', '', '', '', '4', '', '', '', '', '27', '5', '24', '3', '17', '10', '', '4', '', '8', '29', '', '29', '', '29'],
    ['1', '', '', '', '', '4', '', '', '', '', '27', '16', '24', '3', '17', '6', '', '4', '', '8', '29', '', '29', '', '29'],
    ['1', '', '', '', '', '4', '', '', '', '', '27', '17', '20', '3', '17', '6', '13', '18', '', '8', '29', '29', '', '', '29'],
    ['1', '', '', '', '', '4', '', '', '', '', '27', '17', '20', '3', '17', '6', '9', '10', '', '8', '29', '29', '29', '', '29'],
    ['1', '', '', '', '', '', '27', '5', '17', '20', '3', '17', '4', '', '13', '18', '', '8', '29', '', '29', '', '', '29'],
    ['1', '', '', '', '', '', '27', '16', '5', '24', '3', '17', '4', '', '', '4', '', '8', '29', '', '', '29', '', '29'],
    ['1', '', '', '', '', '27', '16', '24', '3', '17', '4', '', '6', '', '8', '29', '', '29', '', '29'],
    ['', '1', '', '', '', '', '20', '23', '17', '20', '3', '17', '6', '19', '11', '10', '', '8', '29', '', '29', '29', '', '29'],
    ['1', '20', '5', '24', '3', '17', '19', '14', '', '4', '', '8', '', '29', '', '29', '', '29'],
    ['1', '', '20', '3', '17', '22', '20', '23', '17', '22', '9', '12', '18', '6', '8', '29', '29', '', '29', '29'],
    ['1', '20', '5', '24', '3', '17', '9', '10', '', '4', '', '8', '29', '29', '', '29', '', '29'],
    ['1', '', '', '', '', '27', '3', '17', '', '', '22', '20', '25', '3', '17', '9', '10', '6', '', '8', '29', '29', '29', '', '29'],
    ['1', '', '', '', '', '', '27', '3', '17', '20', '3', '17', '22', '20', '26', '23', '17', '22', '9', '12', '21', '18', '6', '8', '29', '29', '', '', '29', '29'],
    ['1', '', '', '', '', '', '', '27', '3', '17', '', '', '', '', '22', '20', '26', '5', '24', '3', '17', '9', '10', '', '', '4', '', '8', '29', '29', '', '', '29', '', '29']
];
$goodAnsver = [];
$badAnsver = [];
$withoutEmptyString = [];
for($i = 0; $i < count($rightArr[$userAnsver[1] - 1]); $i++) {
    
    if($rightArr[$userAnsver[1] - 1][$i] !== "")  array_push($withoutEmptyString, $i + 1);
    
    if($userAnsver[0][$i] === $rightArr[$userAnsver[1] - 1][$i] && $rightArr[$userAnsver[1] - 1][$i] !== '') array_push($goodAnsver, $i + 1);
    if($userAnsver[0][$i] !== $rightArr[$userAnsver[1] - 1][$i]) array_push($badAnsver, $i + 1);
}
$mark = count($goodAnsver) / count($withoutEmptyString) * 10;


$conn = mysqli_connect("localhost", "capybara_vlad", "mQMch75rzZwLHgM", "capybara_RPrU");
$sql = "INSERT INTO markTable (testNumber, mark) VALUES ('test$userAnsver[1]','$mark')";
mysqli_query($conn, $sql);
mysqli_close($conn);

echo json_encode([$rightArr, $goodAnsver, $badAnsver, $mark, $userAnsver[0]]);

?>