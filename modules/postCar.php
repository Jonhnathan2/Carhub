<?php
session_start();

include '../config/connect_db.php';

$userId = $_SESSION['user_id'];

$getStmt = $mysqli->prepare("SELECT credit FROM user WHERE user_id = ?");
$getStmt->bind_param("i", $userId);

if ($getStmt->execute()) {
    $result = $getStmt->get_result();
    $user = $result->fetch_assoc();
    $getStmt->close();

    if ($user) {
        if ($user['credit'] - 20 < 0) {
            header("Location: ../sell-car.php?error=credit");
            exit();
        } else {
            $credit = $user['credit'] - 20;

            $updateCredit_query = $mysqli->prepare("UPDATE user SET credit = ? WHERE user_id = ?");
            $updateCredit_query->bind_param("ii", $credit, $userId);

            if (!$updateCredit_query->execute()) {
                $updateCredit_query->close();
                header("Location: ../sell-car.php?error=transaction");
                exit();
            }

            $updateCredit_query->close();
        }
    }
} else {
    // Lỗi trong truy vấn SELECT
    echo "Query failed: " . $getStmt->error;
    $getStmt->close();
    exit();
}


if (isset($_POST['submit'])) {
  if (isset($_POST["description"]) && isset($_FILES["imageExterior"]) && isset($_FILES["imageInterior"])) {
    // Lấy thông tin xe từ form
    $make = $_POST['make'];
    $year = $_POST['year'];
    $model = $_POST['model'];
    $engine = $_POST['engine'];
    $mileage = str_replace(",", '', $_POST['mileage']);
    $driveTrain = $_POST['driveTrain'];
    $VIN = $_POST['VIN'];
    $transmission = $_POST['transmission'];
    $status = $_POST['status'];
    $bodyStyle = $_POST['bodyStyle'];
    $location = $_POST['location'];
    $exteriorColor = $_POST['exteriorColor'];
    $interiorColor = $_POST['interiorColor'];
    $price = str_replace(",", '', $_POST['price']);
    $description = $_POST["description"];

    $info_stmt = $mysqli->prepare('INSERT INTO car (make, model, engine, drivetrain, transmission, mileage, VIN, body_style, status, exterior_color, interior_color, location, price, year, seller_id, description, posted_at, sold) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
    $sold = 0;
    $posted_at = date('Y-m-d H:i:s');
    $sellerID = $_SESSION['user_id'];
    $info_stmt->bind_param("sssssissssssiiissi", $make, $model, $engine, $driveTrain, $transmission, $mileage, $VIN, $bodyStyle, $status, $exteriorColor, $interiorColor, $location, $price, $year, $sellerID, $description, $posted_at, $sold);

    if ($info_stmt->execute()) {
      $car_id = $mysqli->insert_id;
      echo "<script>alert('Posted successfully!')</script>";
    } else {
      echo "Error: " . $stmt->error;
    }

    $info_stmt->close();

    // Upload images
    function uploadImages($inputName, $category, $car_id)
    {
      global $mysqli;

      // Kiểm tra xem input có tồn tại và là mảng không
      if (isset($_FILES[$inputName]) && is_array($_FILES[$inputName]['name']) && !empty($_FILES[$inputName]['name'][0])) {
        $fileCount = count($_FILES[$inputName]['name']);

        if ($fileCount >= 4 && $fileCount <= 10) {
          uploadImageAsBase64($_FILES[$inputName], $category, $car_id);
        } else {
          echo "Error: You need to upload between 4 and 10 files for the $category images!";
        }
      } else {
        echo "Error: No files uploaded for $category images!";
      }
    }

    function uploadImageAsBase64($images, $category, $car_id)
    {
      global $mysqli;
      foreach ($images['tmp_name'] as $key => $tmp_name) {
        $file = $images['tmp_name'][$key];
        $file_name = $images['name'][$key];

        $imageBase64Data = base64_encode(file_get_contents($file));

        $img_query = $mysqli->prepare("INSERT INTO image (name, category, car_id, base64_data) VALUES (?,?,?,?)");
        $img_query->bind_param("ssis", $file_name, $category, $car_id, $imageBase64Data);

        if (!$img_query->execute()) {
          echo "Error: " . $img_query->error;
        }

        $img_query->close();
      }
      header("Location: ../car.php?car_id=" . $car_id);
    }

    // Gọi hàm uploadImages cho từng loại hình ảnh
    uploadImages('imageExterior', 'exterior', $car_id);
    uploadImages('imageInterior', 'interior', $car_id);
    uploadImages('imageMechanical', 'mechanical', $car_id);
    uploadImages('imageDocs', 'docs', $car_id);
    uploadImages('imageOther', 'other', $car_id);
    

    return;
  } else {
    return;
  }
}
