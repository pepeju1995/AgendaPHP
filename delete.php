<?php

require "db.php";

session_start();

  if(!isset($_SESSION["user"])){
    header("Location: login.php");
    return;
  }

$id = $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);

if($stmt->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
}

$contact = $stmt->fetch(PDO::FETCH_ASSOC);

if($contact["user_id"] != $_SESSION["user"]["id"]){
  http_response_code(403);
  echo ("HTTP 403 UNAUTHORIZED");
  return;
}

$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

$_SESSION["flash"] = ["message" => "Contact {$contact["name"]} deleted."];

header('Location: home.php');
?>
