<?php
session_start(); // Khởi động session

// Xóa tất cả các biến session
$_SESSION = [];

// Nếu bạn muốn xóa cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cuối cùng, hủy session
session_destroy(); // Hủy session

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chính
header('Location: ../index.php'); // Hoặc index.php tùy thuộc vào yêu cầu của bạn
exit();
?>
