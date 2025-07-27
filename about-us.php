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

  <main class="container mx-auto w-1/2 my-10 text-justify">
    <h1 class="text-4xl w-fit font-extrabold border-b-2 pb-4 pe-8">About Us</h1>
      <h2 class="mt-10 mb-3 font-bold text-2xl">Who We Are</h2>
      <p>We are Luong Thanh Dat, Tran Thai Son, and Do Quoc Bao, final-year students at BTEC FPT College. As young and passionate individuals, we share a common goal: to create an innovative solution that addresses the challenges faced by car buyers and sellers in Vietnam.</p>
      <div class="my-10 grid grid-cols-3 gap-14">
        <div class="flex flex-col items-center text-justify font-bold">
          <img class="rounded-full drop-shadow-xl w-40 h-40 object-cover" src="assets/img/Daz.jpg">
          <h3 class="text-xl text-center mt-3">Luong Thanh Dat</h3>
          <hr class="border-[#494949] w-3/4 my-2">
          <p class="text-[#858585] text-sm">Co-founder CarHub</p>
        </div>
        <div class="flex flex-col items-center text-justify font-bold">
          <img class="rounded-full drop-shadow-xl w-40 h-40 object-cover" src="assets/img/Finn.jpg">
          <h3 class="text-xl text-center mt-3">Tran Thai Son</h3>
          <hr class="border-[#494949] w-3/4 my-2">
          <p class="text-[#858585] text-sm">Co-founder CarHub</p>
        </div>
        <div class="flex flex-col items-center text-justify font-bold">
          <img class="rounded-full drop-shadow-xl w-40 h-40 object-cover" src="assets/img/Jonhnathan.jpg">
          <h3 class="text-xl text-center mt-3">Do Quoc Bao</h3>
          <hr class="border-[#494949] w-3/4 my-2">
          <p class="text-[#858585] text-sm">Co-founder CarHub</p>
        </div>
      </div>

      <h2 class="mt-10 mb-3 font-bold text-2xl">Our Vision</h2>
      <p>Recognizing the increasing demand for car transactions in today's world, we envisioned CarHub as a platform to make buying and selling vehicles simpler, more reliable, and accessible for everyone. Our goal is to bridge the gap between buyers and sellers, helping them connect easily and efficiently.</p>

      <h2 class="mt-10 mb-3 font-bold text-2xl">What We Offer</h2>
      <div class="list-disc space-y-1.5">
        <li><strong>Ease of Access:</strong> A user-friendly platform tailored for all, from first-time buyers to seasoned sellers.</li>
        <li><strong>Reliability:</strong> Verified listings and transparent processes to build trust within the community.</li>
        <li><strong>Diverse Options:</strong> From brand-new cars to pre-owned ones, we offer a variety of listings to cater to every need and budget.</li>
      </div>

      <h2 class="mt-10 mb-3 font-bold text-2xl">Our Mission</h2>
      <p>CarHub was born out of our capstone project at BTEC FPT College, driven by the desire to apply what we’ve learned academically to a real-world challenge. We aim to make car trading as seamless and transparent as possible, fostering a safe and efficient marketplace for everyone involved.</p>

      <h2 class="mt-10 mb-3 font-bold text-2xl">Why Choose CarHub?</h2>
      <div class="list-disc space-y-1.5">
        <li><strong>For Buyers:</strong> Discover a wide range of cars that match your preferences, all in one place.</li>
        <li><strong>For Sellers:</strong> Reach the right audience with ease, increasing your chances of successful transactions.</li>
        <li><strong>For Everyone:</strong> A trustworthy and hassle-free experience from start to finish.</li>
      </div>

      <h2 class="mt-10 mb-3 font-bold text-2xl">Our Journey</h2>
      <p>Building CarHub has been a remarkable experience, filled with challenges, growth, and innovation. This project represents not just our technical skills, but also our commitment to addressing real-life problems with practical solutions.</p>

  </main>

  <footer class="bg-[#171717] pt-14 py-7 sticky">
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
</body>
</html>