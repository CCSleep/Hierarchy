<?php
// ini_set("display_errors",1);
// error_reporting(E_ALL);
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header('Content-Type: application/json');
$req = json_decode(file_get_contents('php://input'), true);
$method = $_SERVER['REQUEST_METHOD'];
include "db.php";

function enc($array) {
  return json_encode($array);
}

function _unused() {
  http_response_code(400);
}

function get() {
  _unused();
}

function post() {
  global $req, $db;
  if (empty($req["username"]) || empty($req["password"])) {
      return enc(array("success" => false, "code" => -1));
  } elseif (!empty($_SESSION["card_barcode"])) {
      return enc(array("success" => false, "code" => -3));
  }
  
  $username = $db->real_escape_string($req["username"]);
  $password = $db->real_escape_string($req["password"]);
  
  $encodedPassword = sha1($password);
  $row = $db->query("SELECT * FROM `users` WHERE username='$username' AND password='$encodedPassword';");
  if ($row !== false && $row->num_rows === 1) {
    $fetch_one = $row->fetch_assoc();
    $_SESSION["username"] = $username;
    $_SESSION["card_barcode"] = $fetch_one["barcode"];
    return enc(array("success" => true, "code" => 0));
  } else {
    return enc(array("success" => false, "code" => -2));
  }
}

function put() {
  _unused();
}

function delete() {
  _unused();
}
switch ($method) {
  case "GET":
    echo get();
    break;
  case "POST":
    echo post();
    break;
  case "PUT":
    echo put();
    break;
  case "DELETE":
    echo delete();
    break;
}

 ?>
