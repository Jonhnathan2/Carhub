<?php
$userInfo_query = $mysqli->query("SELECT user_id, username, name, email, phone, credit, role FROM user");

if ($userInfo_query) {
  $users = $userInfo_query->fetch_all(MYSQLI_ASSOC);
} else {
  echo "Error: " . $mysqli->error;
  exit();
}

?>

<h1 class="font-bold text-3xl">List of Users</h1>
<div class="bg-[#383838] px-3 py-5 mt-10 rounded-lg">
  <table class="w-full table-auto text-sm text-left divide divide-y divide-[#858585]">
    <thead>
      <tr class="uppercase text-[#858585]">
        <th class="px-4 py-2 w-[5%]">ID</th>
        <th class="px-4 py-2 w-[15%]">Username</th>
        <th class="px-4 py-2 w-[15%]">Name</th>
        <th class="px-4 py-2 w-[20%]">Email</th>
        <th class="px-4 py-2 w-[15%]">Phone</th>
        <th class="px-4 py-2 w-[10%]">Credit</th>
        <th class="px-4 py-2 w-[15%]">Role</th>
        <th class="px-4 py-2 w-[5%]"></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $userInfo):
        $user_id = $userInfo['user_id'];
        $username = $userInfo['username'];
        $name = $userInfo['name'];
        $email = $userInfo['email'];
        $phone = $userInfo['phone'];
        $credit = $userInfo['credit'];
        $role = $userInfo['role'];

        switch ($role) {
          case 0:
            $role = "Private Party";
            break;
          case 1:
            $role = "Dealer";
            break;
          case 2:
            $role = "Manufacturer";
            break;
          case 3:
            $role = "Administrator";
            break;
          default:
            $role = "Unknown";
            break;
        }
      ?>
        <tr class="hover:bg-[#454545] ease-in-out duration-200">
          <td class="px-4 py-4"><?= $user_id ?></td>
          <td class="px-4 py-4"><?= $username ?></td>
          <td class="px-4 py-4"><?= $name ?></td>
          <td class="px-4 py-4"><?= $email ?></td>
          <td class="px-4 py-4"><?= $phone ?></td>
          <td class="px-4 py-4"><?= $credit ?></td>
          <td class="px-4 py-4"><?= $role ?></td>
          <td class="px-4 py-4 flex items-center justify-between">
            <button id="openModal" class="px-2 py-1 text-[#858585] hover:text-white ease-in-out duration-200"
              data-userID="<?= $user_id ?>"
              data-username="<?= $username ?>"
              data-name="<?= $name ?>"
              data-email="<?= $email ?>"
              data-phone="<?= $phone ?>"
              data-credit="<?= $credit ?>"
              data-role="<?= $userInfo['role'] ?>">
              <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div id="userModal" class="fixed inset-0 flex items-center justify-center w-full h-full bg-[#383838] bg-opacity-50 hidden">
  <div class="block bg-[#383838] w-[25%] drop-shadow-lg rounded-lg divide-y divide-solid divide-[#474747]">
    <div class="flex px-6 py-4 justify-between items-center">
      <h2 class="font-bold text-2xl tracking-wide">User's Information</h2>
      <button id="closeModal" class="text-white"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <form action="user/edit.php" method="POST" class="grid grid-cols-1 gap-4 px-6 py-5 text-sm">
      <!-- ID -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="ID" class="text-white">ID:</label>
        <input type="text" id="ID" name="ID" class="col-span-3 text-sm bg-transparent rounded-lg p-2" readonly>
      </div>

      <!-- Username -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="username" class="text-white">Username:</label>
        <input type="text" id="username" name="username" class="col-span-3 text-sm bg-transparent rounded-lg p-2" readonly>
      </div>

      <!-- Name -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="name" class="text-white">Name:</label>
        <input type="text" id="name" name="name" class="col-span-3 text-sm bg-transparent rounded-lg p-2" autocomplete="off">
      </div>

      <!-- Email -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="email" class="text-white">Email:</label>
        <input type="text" id="email" name="email" class="col-span-3 text-sm bg-transparent rounded-lg p-2" autocomplete="off">
      </div>

      <!-- Phone -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="phone" class="text-white">Phone:</label>
        <input type="text" id="phone" name="phone" class="col-span-3 text-sm bg-transparent rounded-lg p-2" autocomplete="off">
      </div>

      <!-- Credit -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="credit" class="text-white">Credit:</label>
        <input type="text" id="credit" name="credit" class="col-span-3 text-sm bg-transparent rounded-lg p-2" autocomplete="off">
      </div>

      <!-- Role -->
      <div class="grid grid-cols-4 gap-4 items-center">
        <label for="role" class="text-white">Role:</label>
        <select name="role" id="role" class="col-span-3 text-sm bg-transparent rounded-lg p-2">
          <option class="bg-[#474747]" value="0">Private Party</option>
          <option class="bg-[#474747]" value="1">Dealer</option>
          <option class="bg-[#474747]" value="2">Manufacturer</option>
          <option class="bg-[#474747]" value="3">Administrator</option>
        </select>
      </div>

      <div class="flex justify-end gap-10 mt-3">
        <a href="" id="deleteBtn" class="px-4 py-2 border border-red-400 text-red-400 hover:drop-shadow-xl hover:shadow-[0_0_8px_2px_rgba(255,0,0,0.6)] rounded-lg">Delete</a>
        <input class="px-4 py-2 border border-[#838383] text-[#838383] hover:drop-shadow-xl hover:shadow-[0_0_8px_2px_rgba(131,131,131,0.6)] cursor-pointer rounded-lg" type="submit" value="Edit" name="edit">
      </div>
    </form>
  </div>
</div>



<script src="js/user_page.js"></script>