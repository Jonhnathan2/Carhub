<?php
require_once '../../config/connect_db.php';

if (isset($_POST['edit'])) {
  if (empty($_POST['ID'])) {
      echo "Error: User ID is required.";
      exit;
  }

  $userID = intval($_POST['ID']);
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $credit = intval($_POST['credit']);
  $role = intval($_POST['role']);

  $editUser = $mysqli->prepare("UPDATE user SET name = ?, email = ?, phone = ?, credit = ?, role = ? WHERE user_id = ?");
  $editUser->bind_param('sssiii', $name, $email, $phone, $credit, $role, $userID);

  if ($editUser->execute()) {
      header("Location: ../index.php?view=user&edit=success");
  } else {
    header("Location: ../index.php?view=user&edit=failed");
  }

  $editUser->close();
}

?>
