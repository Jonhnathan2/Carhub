<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: ./login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/credit.css">
  <script src="https://cdn.tailwindcss.com/3.4.15?plugins=forms@0.5.9,typography@0.5.15"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    module.exports = {
      theme: {
        extend: {
          colors: {
            'ch-gray': '#212121',
          },
        }
      }
    }
  </script>
  <title>CarHub - Credit</title>
</head>

<body>

  <div class="header">
    <button onclick="window.location.href='../index.php'"><i class="fa-solid fa-house" style="margin-right: 5px;"></i> Go Home</button>
  </div>
  <div class="container mx-auto">
    <h1 class="text-center text-4xl font-bold">Wallet Deposit</h1>
    <table class="mx-auto w-9/12 text-sm text-center my-5 divide-y divide-solid divide-gray-500">
      <thead class="text-xs text-gray-700 uppercase">
        <tr>
          <th class="py-4">Credit</th>
          <th class="py-4">Denomination</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-dashed divide-gray-700">
        <tr>
          <td class="py-3">10</td>
          <td class="py-3">10.000 VND</td>
        </tr>
        <tr>
          <td class="py-3">20</td>
          <td class="py-3">20.000 VND</td>
        </tr>
        <tr>
          <td class="py-3">50</td>
          <td class="py-3">50.000 VND</td>
        </tr>
        <tr>
          <td class="py-3">100</td>
          <td class="py-3">100.000 VND</td>
        </tr>
        <tr>
          <td class="py-3">200</td>
          <td class="py-3">200.000 VND</td>
        </tr>
        <tr>
          <td class="py-3">500</td>
          <td class="py-3">500.000 VND</td>
        </tr>
      </tbody>
    </table>


    <form class="mx-auto w-3/5" action="payment.php" method="post">
      <div class="flex justify-between items-center my-2">
        <label class="w-1/6 font-bold" for="amount">Amount:</label>
        <select class="w-5/6 dark:bg-transparent rounded-lg focus:outline-none" name="amount">
          <option class="bg-[#212121]" value="10000">10.000 VND</option>
          <option class="bg-[#212121]" value="20000">20.000 VND</option>
          <option class="bg-[#212121]" value="50000">50.000 VND</option>
          <option class="bg-[#212121]" value="100000">100.000 VND</option>
          <option class="bg-[#212121]" value="200000">200.000 VND</option>
          <option class="bg-[#212121]" value="500000">500.000 VND</option>
        </select>
      </div>

      <div class="flex items-center justify-between mt-6">
        <p class="font-bold">Select payment method:</p>
        <div class="flex items-center">
          <input type="radio" checked class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" name="bankCode" value="VNBANK">
          <label class="ms-2" for="bankCode">Payment via ATM card/Domestic account</label>
        </div>
        <div class="flex items-center">
          <input type="radio" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" name="bankCode" value="INTCARD">
          <label class="ms-2" for="bankCode">Payment by international card</label>
        </div>
      </div>

      <div class="flex justify-center mt-6">
        <button class="items-center px-4 py-2 border border-gray-500 rounded-lg hover:cursor-pointer" type="submit">Pay</button>
      </div>
    </form>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Kiểm tra tham số GET trong URL
      const params = new URLSearchParams(window.location.search);

      if (params.get("status") === "success") {
        Swal.fire({
          timer: 4000,
          title: "Payment completed successfully!",
          html: "Your payment was successful, and your wallet has been credited!",
          icon: "success",
          showConfirmButton: false,
        });
      }
    });
  </script>
</body>

</html>