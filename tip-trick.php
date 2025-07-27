<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com/3.4.15?plugins=forms@0.5.9,typography@0.5.15"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

  <title>CarHub - Selling car platform</title>
</head>

<body>
  <?php
  include 'assets/pages/navbar.php';
  ?>
  <main class="container mx-auto my-8 relative">
    <div class="flex">
      <div class="fixed left-14 w-[17.5%] space-y-5 z-[100] text-[#858585]">
        <div class="block">
          <a href="#buyingNewCar" class="text-base font-semibold hover:text-[#D6D6D6] transition duration-300 ease-in-out">Tips for Buying a New Car</a>
        </div>
        <div class="block">
          <a href="#buyingUsedCar" class="text-base font-semibold hover:text-[#D6D6D6] transition duration-300 ease-in-out">Tips for Buying a Used Car</a>
        </div>
      </div>

      <div class="flex flex-col gap-5 w-[80%] ml-[18%]">
        <h1 class="text-4xl w-fit font-extrabold border-b-2 pb-4 pe-8">Tip & Trick</h1>
        <div class="text-justify">
          <h2 id="buyingNewCar" class="text-3xl my-5 font-bold">Tips for Buying a New Car</h2>
          <div class="mt-4 space-y-4">
            <p class="text-xl font-semibold text-[#858585]">Step 1: Identify Your Needs Before purchasing a new car, consider the following:</p>
            <div class="list-disc space-y-1.5">
              <li>What type of car do you need? (Sedan, SUV, pickup truck, or sports car)</li>
              <li>What is the car’s primary use? (Daily commuting, family trips, or work)</li>
              <li>What is your budget, including operational costs like fuel, insurance, and maintenance?</li>
            </div>
  
            <p class="text-xl font-semibold text-[#858585]">Step 2: Research the Market Thorough research is key. Here’s how to do it:</p>
            <div class="list-disc space-y-1.5">
              <li>Compare prices across mdivtiple dealerships and online platforms.</li>
              <li>Read expert and user reviews to understand the pros and cons of different cars.</li>
              <li>Look for promotions, discounts, or financing options to maximize savings.</li>
            </div>
  
            <p class="text-xl font-semibold text-[#858585]">Step 3: Inspect the Car</p>
            <div class="list-disc space-y-1.5">
              <li>Visit the dealership to inspect and test drive the car. Ensure the car meets your expectations regarding performance, handling, and safety. Check for modern safety features like ABS brakes, airbags, and parking sensors.</li>
            </div>
  
            <p class="text-xl font-semibold text-[#858585]">Step 4: Negotiate and Finalize</p>
            <div class="list-disc space-y-1.5">
              <li>Don’t hesitate to negotiate for the best price. Ask about extended warranties or any complimentary services that codivd be included with the purchase.</li>
            </div>
          </div>
  
          <h2 id="buyingUsedCar" class="text-3xl mb-5 font-bold mt-10">Tips for Buying a Used Car</h2>
          <div class="mt-4 space-y-3">
            <p class="text-xl font-semibold text-[#858585]">Step 1: Choose a Reliable Source Where you buy the car from matters:</p>
            <div class="list-disc space-y-1.5">
              <li>Private Sellers: Verify the car’s history to avoid hidden issues like accidents or unpaid loans.</li>
              <li>Dealerships: These cars are usually inspected and come with warranties, but may cost more.</li>
              <li>Online Platforms: Use trusted platforms that have strong review systems for safe transactions.</li>
            </div>
  
            <p class="text-xl font-semibold text-[#858585]">Step 2: Inspect the Car Thoroughly Carefully inspect the car for any issues:</p>
            <div class="list-disc space-y-1.5">
              <li>Exterior: Look for dents, rust, and signs of repainting.</li>
              <li>Interior: Check the seats, dashboard, and controls.</li>
              <li>Engine: Test the car’s performance and listen for unusual sounds. Ask for the car’s maintenance history to understand its condition.</li>
            </div>
  
            <p class="text-xl font-semibold text-[#858585]">Step 3: Confirm the Price</p>
            <div class="list-disc space-y-1.5">
              <li>Compare the car’s price to similar models in the market to ensure it’s reasonably priced. Be aware of any additional repair or maintenance costs that may arise after purchase.</li>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-[#171717] pt-14 py-7">
    <div class="container mx-auto grid grid-cols-3 gap-20">
      <div class="flex flex-col gap-5">
        <img src="assets/img/Logo.png" class="w-40" alt="" srcset="">
        <p>CarHub is the premier platform for buying and selling cars. Join us to find your next vehicle with ease.</p>
      </div>
      <div class="flex flex-col gap-2">
        <h3 class="text-2xl font-bold mb-2">Quick Links</h3>
        <a class="no-underline" href="./index.php">Home</a>
        <a class="no-underline" href="./sell-car.php">Sell Your Car</a>
        <a class="no-underline" href="./tip-trick.php">Tip & Trick</a>
        <a class="no-underline" href="./about-us.php">About Us</a>
      </div>
      <div class="flex flex-col gap-2">
        <h3 class="text-2xl font-bold">Follow Us</h3>
        <div class="flex gap-5 text-xl">
          <a href="#"><i class="fa-brands fa-square-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-square-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin"></i></a>
        </div>
      </div>
    </div>
    <div class="text-center mt-14">
      <p>© 2024 CarHub. All Rights Reserved.</p>
    </div>
  </footer>

  <script>
window.embeddedChatbotConfig = {
chatbotId: "-0JGSKjT9NXPu-MUVHYZO",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="-0JGSKjT9NXPu-MUVHYZO"
domain="www.chatbase.co"
defer>
</script>
  <script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();

        // Lấy phần tử mục tiêu từ href
        const targetElement = document.querySelector(this.getAttribute('href'));

        // Cuộn đến phần tử đó với độ lệch là 20% từ trên
        window.scrollTo({
          top: targetElement.offsetTop - window.innerHeight * 0.05,
          behavior: 'smooth'
        });
      });
    });
</script>
</body>
</html>