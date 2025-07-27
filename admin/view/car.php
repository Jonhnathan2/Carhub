<?php
$carInfo_query = $mysqli->prepare('
  SELECT 
      c.car_id, 
      c.make, 
      c.model, 
      c.mileage, 
      c.price, 
      c.year,
      c.posted_at,
      c.sold,
      u.name
  FROM 
      car c
  LEFT JOIN 
      user u ON c.seller_id = u.user_id
');

if (!$carInfo_query) {
  echo "Error: " . $mysqli->error;
  exit();
}

$carInfo_query->bind_result($carID, $carMake, $carModel, $carMileage, $carPrice, $carYear, $carPostedAt, $carSold, $carSeller);

$car = [];

if ($carInfo_query->execute()) {
  while ($carInfo_query->fetch()) {
    $car[] = [
      'id' => $carID,
      'make' => $carMake,
      'model' => $carModel,
      'mileage' => $carMileage,
      'price' => $carPrice,
      'year' => $carYear,
      'postedAt' => $carPostedAt,
      'sold' => $carSold,
      'seller' => $carSeller,
    ];
  }
} else {
  echo "Error: " . $carInfo_query->error;
}

$carInfo_query->close();
?>

<h1 class="font-bold text-3xl">List of Cars</h1>
<div class="bg-[#383838] px-3 py-5 mt-10 rounded-lg">
  <table class="w-full table-auto text-sm text-left divide divide-y divide-[#858585]">
    <thead>
      <tr class="uppercase text-[#858585]">
        <th class="px-4 py-2 w-[5%]">ID</th>
        <th class="px-4 py-2 w-[22.5%]">Name</th>
        <th class="px-4 py-2 w-[12.5%]">Mileage</th>
        <th class="px-4 py-2 w-[12.5%]">Price</th>
        <th class="px-4 py-2 w-[10%]">Seller</th>
        <th class="px-4 py-2 w-[15%]">Posted At</th>
        <th class="px-4 py-2 w-[10%]">Status</th>
        <th class="px-4 py-2 w-[12.5%]">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($car as $info):
        switch ($info['sold']) {
          case 0:
            $sold = "<p class='w-16 text-sm bg-[#198754] font-medium px-4 py-1.5 rounded-lg'>For Sale</p>";
            break;
          case 1:
            $sold = "<p class='w-16 text-sm bg-[#dc3545] font-medium px-4 py-1.5 rounded-lg'>Sold</p>";
            break;
        }
        $mileage = number_format($info['mileage'], 0, '', ',') . " miles";
        $price = "$". number_format($info['price'], 0, '', ',');
      ?>
        <tr class="hover:bg-[#454545] ease-in-out duration-200">
          <td class="p-4"><?= $info['id'] ?></td>
          <td class="p-4"><?= $info['year'] . " " . $info['make'] . " " . $info['model'] ?></td>
          <td class="p-4"><?= $mileage ?></td>
          <td class="p-4"><?= $price ?></td>
          <td class="p-4"><?= $info['seller'] ?></td>
          <td class="p-4"><?= $info['postedAt'] ?></td>
          <td class="p-4 text-center"><?= $sold ?></td>
          <td class="p-4 flex items-center gap-10">
            <a class="px-4 py-1.5 text-sm text-[#858585] border border-[#858585] rounded-lg hover:text-white hover:border-white ease-in-out duration-200" href="../car.php?car_id=<?= $info['id'] ?>">View</a>
            <a class="px-4 py-1.5 text-sm text-[#858585] border border-[#858585] rounded-lg hover:text-white hover:border-white ease-in-out duration-200" href="">Delete</a>
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