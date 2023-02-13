<?php

$fileEst = [];

for($i = 0; $i < 100; $i++) if(file_exists('../img/element'.$i.'.png')) array_push($fileEst, $i);
$text = count($fileEst);
$fp = fopen("../generalPHP/file.txt", "w");
fwrite($fp, $text);
fclose($fp);

?>