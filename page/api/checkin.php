<?php
// ini_set("display_errors",1);
// error_reporting(E_ALL);
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT");
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

function _forbidden() {
  return enc(array("success" => false, "code" => -1));
}

function get() {
  _unused();
}

function post() {
    global $req, $db;
    if (empty($_SESSION["admin_login"]) || empty($req["barcode"])) {
      return _forbidden();
    } 
    
    $barcode = $db->real_escape_string($req["barcode"]);
    $unix_time = time();
    if (!empty($req["image"])) {
        $image = $db->real_escape_string($req["image"]);
        $db->query("INSERT INTO `timecard` (barcode, timestamp, image_route) VALUE ('$barcode', {$unix_time},'$image');");
        return enc(array("success" => true, "code" => 1));
    } else {
        $db->query("INSERT INTO `timecard` (barcode, timestamp) VALUE ('$barcode', {$unix_time});");
        return enc(array("success" => true, "code" => 0));
    }
}

function put() {
    global $req, $db;
    if (empty($req["admin_login"]) || empty($req["barcode"])) {
      return _forbidden();
    } 
    
    $barcode = $db->real_escape_string($req["barcode"]);
    $unix_time = time();
    if (!empty($req["image"])) {
        $image = $db->real_escape_string($req["image"]);
        $db->query("INSERT INTO `timecard` (barcode, timestamp, image) VALUE ('$barcode', {$unix_time},'$image');");
        return enc(array("success" => true, "code" => 1));
    } else {
        $db->query("INSERT INTO `timecard` (barcode, timestamp) VALUE ('$barcode', {$unix_time});");
        return enc(array("success" => true, "code" => 0));
    }
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
