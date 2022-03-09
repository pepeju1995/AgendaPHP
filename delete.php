<?php

require "db.php";

session_start();

  if(!isset($_SESSION["user"])){
    header("Location: login.php");
    return;
  }

$id = $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
$stmt->execute([":id" => $id]);

if($stmt->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
}

$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

header('Location: home.php');
?>
