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
$data = $type == 'POST' ? $_POST : $_GET;


function isPasswordValid($password)
{
  $test = true;

  $length = strlen($password); //8 - 16


  if ($length < 8 ||  $length > 16) {
    $test = false;
  }

  if (!preg_match('/[\'^£$%&*()}{@#~?><>,!.|=_+¬-]/', $password)) {
    $test = false;
  }


  return $test;
}



if ($type == 'POST') {
  $data = json_decode(file_get_contents('php://input'));

  if ($data) {
    // check if valid email
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    $valid_email = (preg_match($regex, $data->email));

    $valid_password = isPasswordValid($data->password);

    if (!$valid_email) {
      $response = [
        "success" => false,
        "message" => "Please add valid email address"
      ];
      echo json_encode($response);
    } else if (!$valid_password) {
      $response = [
        "success" => false,
        "message" => "Please add valid password"
      ];
      echo json_encode($response);
    } else {
      $details = [
        "name" => $data->name,
        "email" => $data->email,
        "password" => $data->password
      ];
      $user = new user($details);
      $user->setDB($conn);
      $store = $user->store();
      echo json_encode($store);
    }
  } else {
    $response = [
      "success" => false,
      "message" => "Please add payload"
    ];
    echo json_encode($response);
  }
} 


?>