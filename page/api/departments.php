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
  global $req, $db;
  if (empty($_GET["alias"])) {
    return enc(array("success" => false, "code" => -1));
  }
  $alias = $db->real_escape_string($_GET["alias"]);
  $ctl = $db->query("SELECT * FROM `departments` WHERE alias='$alias'");
  $fetch_one = $ctl->fetch_assoc();
  if ($ctl->num_rows === 1) {
    return enc(array_merge(array("success" => true, "code" => 0), array("data"=>$fetch_one)));
  } else {
    return enc(array("success" => false, "code" => -2));
  }
}

function post() {
  global $req, $db;
  if (empty($_GET["alias"])) {
    return enc(array("success" => false, "code" => -1));
  }
  $alias = $db->real_escape_string($_GET["alias"]);
  $ctl = $db->query("SELECT * FROM `departments` WHERE alias='$alias'");
  $fetch_one = $ctl->fetch_assoc();
  if ($ctl->num_rows === 1) {
    return enc(array_merge(array("success" => true, "code" => 0), array("data"=>$fetch_one)));
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
