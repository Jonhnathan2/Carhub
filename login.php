<?php 
session_start();

if(isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/form.css">
  <script src="js/alert.js"></script>

  <title>CarHub - Login</title>
</head>

<body>
  <div class="header">
    <button onclick="history.back()"><i class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Go Back</button>
  </div>

  <div class="alert" id="sign-in">
    <div class="alert-content">
      <h1>Login successful!</h1>
      <p>You have successfully logged in. Redirecting to home page.</p>
    </div>
  </div>

  <div class="alert" id="error-login">
    <div class="alert-content">
      <h1>Wrong Username or Password !</h1>
      <p>Please check again your username or password.</p>
    </div>
  </div>

  <?php
    include 'config/connect_db.php';

    if (isset($_POST['submit'])) {
      $username_input = $_POST['username']; // Đổi tên biến để tránh nhầm lẫn
      $password = $_POST['password'];
  
      // Truy vấn để kiểm tra xem người dùng có tồn tại không
      $query = $mysqli->prepare('SELECT * FROM user WHERE username = ?');
      $query->bind_param('s', $username_input);
      $query->execute();
      $result = $query->get_result();
  
      // Kiểm tra xem có người dùng nào được tìm thấy không
      if ($result && $result->num_rows > 0) {
          $user = $result->fetch_assoc(); // Lấy dữ liệu của người dùng
  
          // Kiểm tra mật khẩu
          if (password_verify($password, $user['password'])) {
              $_SESSION['user_id'] = $user['user_id'];
              $_SESSION['username'] = $user['username'];
              $_SESSION['name'] = $user['name'];
              $_SESSION['role'] = $user['role'];

              echo '
              <script>
                showAlert("sign-in")
                setTimeout(function() {
                  window.location.href = "index.php"; // Chuyển hướng sau khi alert hoàn tất
                }, 3000);
              </script>';
              exit; // Thêm exit để dừng script sau khi chuyển hướng
          } else {
              // Mật khẩu không đúng
              echo '<script>showAlert("error-login")</script>';
          }
      } else {
          // Người dùng không tồn tại
          echo '<script>showAlert("error-login")</script>';
      }
  }
  
  ?>

  <div class="container">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form">
      <h2 class="form-title">Log In</h2>
      <input type="text" name="username" class="form-input" placeholder="Username" autocomplete="off">
      <span id="usernameError" class="message-error"></span>

      <input type="password" name="password" class="form-input" placeholder="Password" autocomplete="off">
      <span id="passwordError" class="message-error"></span>

      <button type="submit" name="submit" class="form-btn">Login</button>
      <span class="form-link">Don't have an account ? <a href="signup.php">SIGN UP</a></span>
    </form>
  </div>
  <script>

  </script>
</body>

</html>