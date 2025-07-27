<?php
  session_start();

  require_once("./config.php");
  $vnp_SecureHash = $_GET['vnp_SecureHash'];
  $vnp_Amount = $_GET['vnp_Amount'];
  $userID = $_SESSION['user_id'];
  $inputData = array();
  foreach ($_GET as $key => $value) {
      if (substr($key, 0, 4) == "vnp_") {
          $inputData[$key] = $value;
      }
  }
  
  unset($inputData['vnp_SecureHash']);
  ksort($inputData);
  $i = 0;
  $hashData = "";
  foreach ($inputData as $key => $value) {
      if ($i == 1) {
          $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
      } else {
          $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
          $i = 1;
      }
  }

  $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

  $mysqli = new mysqli("localhost", "root", "", "carhub");
  // Check connection
  if ($mysqli->connect_error) {
      die("Connection failed: " . $mysqli->connect_error);
  }

  $getStmt = $mysqli->prepare("SELECT credit FROM user WHERE user_id = ?");
  $getStmt->bind_param("i", $userID);
  if ($getStmt->execute()) {
    $getStmt->bind_result($userCredit);
    if ($getStmt->fetch()) {
        $currentCredit = $userCredit;
    } else {
        $currentCredit = 0;
    }
  } else {
      echo "Query failed: " . $getStmt->error;
  }
  $getStmt->close();


  switch ($vnp_Amount) {
    case 1000000:
        $credit = $currentCredit + 10;
        break;
    case 2000000:
        $credit = $currentCredit + 20;
        break;
    case 5000000:
        $credit = $currentCredit + 50;
        break;
    case 10000000:
        $credit = $currentCredit + 100;
        break;
    case 20000000:
        $credit = $currentCredit + 200;
        break;
    case 50000000:
        $credit = $currentCredit + 500;
        break;
    default:
        die("Invalid amount.");
  }


  $postStmt = $mysqli->prepare("UPDATE user SET credit = ? WHERE user_id = ?");
  $postStmt->bind_param("ii", $credit, $userID);
  if ($postStmt->execute()) {
    header("Location: index.php?status=success");
  } else {
    header("Location: index.php?status=error&error_code=" . $_GET['vnp_ResponseCode']);
  }
?>