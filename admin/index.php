<?php
session_start();

require_once '../config/connect_db.php';

$userRole = $_SESSION['role'];
if (!$userRole == 3) {
  header("Location: ../index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com/3.4.15?plugins=forms@0.5.9,typography@0.5.15"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: 'Inter';
    }
  </style>
</head>

<body>
  <div class="flex text-white">
    <!-- Sidebar -->
    <aside class="min-h-screen w-64 bg-[#171717]">
      <div class="p-4 flex justify-center">
        <img src="../assets/img/Logo.png" class="w-3/4" alt="Logo">
      </div>
      <nav class="mt-4">
        <ul class="divide-y divide-solid divide-[#383838]">
          <li>
            
            <a href="../index.php" class="block py-4 px-4 hover:bg-[#383838] transition-all ease-in-out duration-200">
              Home Page
            </a>
          </li>
          <li>
            <a href="index.php?view=dashboard" class="block py-4 px-4 hover:bg-[#383838] transition-all ease-in-out duration-200">
              Admin Dashboard
            </a>
          </li>
          <li>
            <a href="index.php?view=user" class="block py-4 px-4 hover:bg-[#383838] transition-all ease-in-out duration-200">
              Manage Users
            </a>
          </li>
          <li>
            <a href="index.php?view=car" class="block py-4 px-4 hover:bg-[#383838] transition-all ease-in-out duration-200">
              Manage Cars
            </a>
          </li>
        </ul>
      </nav>
    </aside>


    <!-- Main Content -->
    <main class="min-h-screen flex-1 bg-[#212121] px-6 py-8">
      <?php
      if (isset($_GET['view'])) {
        switch ($_GET['view']) {
          case 'dashboard':
            include_once 'view/dashboard.php';
            break;
          case 'user':
            include_once 'view/user.php';
            break;
          case 'car':
            include_once 'view/car.php';
            break;
          default:
            include_once 'view/dashboard.php';
            break;
        }
      } else {
        header("Location: index.php?view=dashboard");
      }
      ?>
    </main>
  </div>

</body>

</html>