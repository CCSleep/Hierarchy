<?php
// ini_set("display_errors",1);
// error_reporting(E_ALL);
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
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
  if (!empty($_SESSION["card_barcode"])) {
      session_destroy();
      return enc(array("success" => true,"code" => 0));
  } else {
      return enc(array("success" => true,"code" => -1));
  }
}

function post() {
  if (!empty($_SESSION["card_barcode"])) {
      session_destroy();
      return enc(array("success" => true,"code" => 0));
  } else {
      return enc(array("success" => true,"code" => -1));
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
