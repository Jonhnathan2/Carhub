<?php
session_start();

// Kiểm tra session user_id
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Kiểm tra car_id trong URL
if (!isset($_GET['car_id'])) {
    header("Location: index.php");
    exit();
}

include '../config/connect_db.php';

// Lấy seller_id của xe để kiểm tra quyền xóa
$car_id = intval($_GET['car_id']); // Chuyển thành số nguyên để tránh SQL injection
$result = $mysqli->query("SELECT seller_id FROM car WHERE car_id = $car_id");

if ($result) {
    $row = $result->fetch_assoc();
    $seller_id = $row['seller_id'];
    if ($seller_id != $_SESSION['user_id']) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Xóa dữ liệu từ bảng image
$delete_image_query = $mysqli->prepare("DELETE FROM image WHERE car_id = ?");
$delete_image_query->bind_param("i", $car_id);

// Xóa dữ liệu từ bảng car
$delete_car_query = $mysqli->prepare("DELETE FROM car WHERE car_id = ?");
$delete_car_query->bind_param("i", $car_id);

// Thực hiện xóa dữ liệu
if ($delete_image_query->execute() && $delete_car_query->execute()) {
    header("Location: ../my-cars.php");
} else {
    echo "Error deleting record: " . $mysqli->error;
}

// Đóng kết nối
$delete_image_query->close();
$delete_car_query->close();
$mysqli->close();
?>
