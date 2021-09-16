<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
  header('Access-Control-Allow-Headers: token, Content-Type');
  header('Access-Control-Max-Age: 1728000');
  header('Content-Length: 0');
  header('Content-Type: text/plain');
  die();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include '../database.php';
include '../controllers/user.php';



$type = $_SERVER['REQUEST_METHOD'];


if ($type == 'GET') {

  if ($_GET['id']) {
    $user = new user();
    $user->setDB($conn);
    echo json_encode($user->fetch($_GET['id']));
  } else {
    $user = new user();
    $user->setDB($conn);
    echo json_encode($user->getAll());
  }
}
