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
  <title>CarHub - Sign Up</title>
</head>

<body>
  <div class="header">
    <button onclick="history.back()"><i class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Go Back</button>
  </div>

  <div class="alert" id="sign-up">
    <div class="alert-content">
      <h1>Registration successful!</h1>
      <p>Your account has been created successfully. You can now log in.</p>
    </div>
  </div>
  
  <div class="container">
    <?php
    include 'config/connect_db.php';

    if (isset($_POST['submit'])) {
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $username = $_POST['username'];
      $name = $_POST['name'];
      $password = $_POST['password'];
  
      // Kiểm tra xem username đã tồn tại hay chưa
      $checkStmt = $mysqli->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
      $checkStmt->bind_param("s", $username);
      $checkStmt->execute();
      $checkStmt->bind_result($usernameExists);
      $checkStmt->fetch();
      $checkStmt->close();
  
      if ($usernameExists > 0) {
          // Nếu username đã tồn tại, thông báo cho người dùng
          echo "<script>alert('Tên người dùng đã tồn tại. Vui lòng chọn tên khác.');</script>";
      } else {
          // Mã hóa mật khẩu
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
          // Sử dụng prepared statement để bảo mật
          $stmt = $mysqli->prepare("INSERT INTO user (username, password, name, email, phone, role) VALUES (?, ?, ?, ?, ?, ?)");
          $role = 0; // Vai trò mặc định (ví dụ: 1 là người dùng)
          $stmt->bind_param("sssssi", $username, $hashed_password, $name, $email, $phone, $role);
  
          if ($stmt->execute()) {
              echo "
              <script>
                showAlert('sign-up');
                setTimeout(function() {
                  window.location.href = 'login.php';
                }, 3000);
              </script>";
          } else {
              echo "Có lỗi xảy ra: " . $stmt->error;
          }
  
          $stmt->close();
      }
      $mysqli->close();
    }
    ?>

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form" autocomplete="off">
      <h2 class="form-title">Sign Up</h2>

      <input type="email" id="email" name="email" class="form-input" placeholder="Email" onchange="validateForm('email', this.value)">
      <span id="emailError" class="message-error"></span>

      <input type="tel" id="phone" name="phone" class="form-input" placeholder="Phone" onchange="validateForm('phone', this.value)">
      <span id="phoneError" class="message-error"></span>

      <input type="text" id="name" name="name" class="form-input" placeholder="Name" onchange="validateForm('name', this.value)">
      <span id="nameError" class="message-error"></span>

      <input type="text" id="username" name="username" class="form-input" placeholder="Username" onchange="validateForm('username', this.value)">
      <span id="usernameError" class="message-error"></span>

      <input type="password" id="password" name="password" class="form-input" placeholder="Password" onchange="validateForm('password', this.value)">
      <span id="passwordError" class="message-error"></span>

      <input type="password" id="re-password" name="re-password" class="form-input" placeholder="Re-password" onchange="validateForm('repassword', this.value)">
      <span id="repasswordError" class="message-error"></span>

      <button type="submit" name="submit" class="form-btn" disabled>Signup</button>
      <span class="form-link">Already have an account? <a href="login.php">SIGN IN</a></span>
    </form>
  </div>

  <script>
    var emailError = document.getElementById('emailError');
    var nameError = document.getElementById('nameError');
    var usernameError = document.getElementById('usernameError');
    var passwordError = document.getElementById('passwordError');
    var repasswordError = document.getElementById('repasswordError');
    var submitBtn = document.getElementsByName('submit')[0];

    function validateForm(type, input) {
      let isValid = true;

      if (type === 'email') {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(input) || input.length == 0) {
          emailError.textContent = "Invalid email format";
          isValid = false;
        } else {
          emailError.textContent = "";
        }
      }
      if (type === 'phone') {
        if (input.length == 0) {
          phoneError.textContent = "Number cannot be empty";
          isValid = false;
        } else {
          phoneError.textContent = "";
        }
      }
      if (type === 'name') {
        if (input.length === 0) {
          nameError.textContent = "Name cannot be empty";
          isValid = false;
        } else {
          nameError.textContent = "";
        }
      }
      if (type === 'username') {
        if (input.length < 4) {
          usernameError.textContent = "Username must be at least 4 characters";
          isValid = false;
        } else {
          usernameError.textContent = "";
        }
      }
      if (type === 'password') {
        if (input.length < 6) {
          passwordError.textContent = "Password must be at least 6 characters";
          isValid = false;
        } else {
          passwordError.textContent = "";
        }
      }
      if (type === 'repassword') {
        var password = document.getElementById('password').value;
        if (input !== password) {
          repasswordError.textContent = "Passwords do not match";
          isValid = false;
        } else {
          repasswordError.textContent = "";
        }
      }

      checkAllFieldsValid();
      return isValid;
    }

    function checkAllFieldsValid() {
      const emailValid = emailError.textContent === "" && document.getElementById('email').value.trim() !== "";
      const phoneValid = phoneError.textContent === "" && document.getElementById('phone').value.trim() !== "";
      const nameValid = nameError.textContent === "" && document.getElementById('name').value.trim() !== "";
      const usernameValid = usernameError.textContent === "" && document.getElementById('username').value.trim() !== "";
      const passwordValid = passwordError.textContent === "" && document.getElementById('password').value.trim() !== "";
      const repasswordValid = repasswordError.textContent === "" && document.getElementById('re-password').value.trim() !== "";

      // Enable the submit button only if all fields are valid and not empty
      submitBtn.disabled = !(emailValid && nameValid && usernameValid && passwordValid && repasswordValid);
    }
    
  </script>
</body>

</html>