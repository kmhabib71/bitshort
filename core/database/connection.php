<?php

$hostDetails = 'mysql:host=127.0.0.1; dbname=bitshort_main; charset=utf8mb4';
$userAdmin = 'bitshort_main';
$pass = 'paaEgy@71';
try{
    $pdo = new PDO($hostDetails,$userAdmin,$pass);
} catch(PDOExecption $e){
    echo 'Connection error!' . $e->getMessage();
}

?>
