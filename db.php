<?php

$host = "localhost";
$db = "contacts_app";
$user = "root";
$password = "";

try{
  $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch(PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}

?>
