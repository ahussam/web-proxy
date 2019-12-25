<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=proxy;','root','');
}catch(PDOExcption $e){
exit ('database error.');
}
?>
