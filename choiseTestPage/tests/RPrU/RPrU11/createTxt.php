<?php

$fileEst = [];

for($i = 0; $i < 100; $i++) if(file_exists('../RPrU11/imgRPrU11/element'.$i.'.png')) array_push($fileEst, $i);
$text = count($fileEst);
$fp = fopen("file.txt", "w");
fwrite($fp, $text);
fclose($fp);

?>