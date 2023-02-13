<?php



$logPass = json_decode($_POST['logPassJSON']);
// echo json_encode("ok");

$flagArr = [];
// session_start();
$logAndPassToForm = $logPass[0]."_".$logPass[1];
// $_SESSION['session'] = $logAndPassToForm;


$conn = mysqli_connect("localhost", "root", "", "RPrU");
            


$sql228 = "SELECT * FROM allTests";
if($result = mysqli_query($conn, $sql228)){
    while($row = mysqli_fetch_array($result)){
        if($row["logAndPass"] == $logAndPassToForm) array_push($flagArr, $row["logAndPass"]);
    }
}

if(count($flagArr) == 0) {
    $sql = "INSERT INTO allTests (logAndPass) VALUES ('$logAndPassToForm')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}




echo json_encode("ok");

?>