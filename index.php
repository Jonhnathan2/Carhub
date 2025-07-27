<?php
include('config/connect_db.php');

$selectedTransmission = isset($_GET['transmission']) ? $_GET['transmission'] : 'All';
$selectedBodyStyle = isset($_GET['body_style']) ? $_GET['body_style'] : 'All';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <title>CarHub - Selling car platform</title>


</head>

  <?php
  include 'assets/pages/navbar.php';
  ?>

  <div class="container my-3">

    <div id="carouselFavCar" class="carousel main carousel-dark slide custom-carousel-size overflow-hidden" data-bs-ride="carousel">
      <div class="carousel-inner">

        <?php include 'modules/indexCarousel.php'; ?>

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselFavCar" data-bs-slide="prev" style="width: 5%; z-index: 0;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselFavCar" data-bs-slide="next" style="width: 5%; z-index: 0;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>



    <div class="title d-flex justify-content-between">
      <div class="d-flex">
        <h4 class="me-3">Cars</h4>
        <div class="dropdown me-2">
          <a href="#" id="yearsDropdown" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Years</a>
          <div class="dropdown-menu px-3">
            <div class="mb-2">
              <label for="startYear" class="form-label">From</label>
              <select id="startYear" name="start_year" class="form-control">
              </select>
            </div>
            <div class="mb-2">
              <label for="endYear" class="form-label">To</label>
              <select id="endYear" name="end_year" class="form-control">
              </select>
            </div>
          </div>
        </div>


        <div class="dropdown me-2">
          <a href="#" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo ($selectedTransmission === 'All') ? 'Transmission' : $selectedTransmission; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="filterCars('All', null, null, null)">All</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars('Automatic', null, null, null)" <?php if ($selectedTransmission == 'Automatic') echo 'selected'; ?>>Automatic</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars('Manual', null, null, null)" <?php if ($selectedTransmission == 'Manual') echo 'selected'; ?>>Manual</a></li>
          </ul>
        </div>


        <div class="dropdown me-2">
          <a href="#" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo ($selectedBodyStyle === 'All') ? 'Body Style' : $selectedBodyStyle; ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'All', null, null)">All</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Coupe', null, null)" <?php if ($selectedBodyStyle == 'Coupe') echo 'selected'; ?>>Coupe</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Convertible', null, null)" <?php if ($selectedBodyStyle == 'Convertible') echo 'selected'; ?>>Convertible</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Hatchback', null, null)" <?php if ($selectedBodyStyle == 'Hatchback') echo 'selected'; ?>>Hatchback</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Sedan', null, null)" <?php if ($selectedBodyStyle == 'Sedan') echo 'selected'; ?>>Sedan</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'SUV/Crossover', null, null)" <?php if ($selectedBodyStyle == 'SUV/Crossover') echo 'selected'; ?>>SUV/Crossover</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Truck', null, null)" <?php if ($selectedBodyStyle == 'Truck') echo 'selected'; ?>>Truck</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Van/Minivan', null, null)" <?php if ($selectedBodyStyle == 'Van/Minivan') echo 'selected'; ?>>Van/Minivan</a></li>
            <li><a class="dropdown-item" href="#" onclick="filterCars(null, 'Wagon', null, null)" <?php if ($selectedBodyStyle == 'Wagon') echo 'selected'; ?>>Wagon</a></li>
          </ul>
        </div>


      </div>


      <div class="filter-set">
        <a href="" onclick="">Newest</a>
        <a href="" onclick="">Oldest</a>
        <a href="" onclick="">Lowest Mileage</a>
      </div>
    </div>
    <div class="row mt-4">
      <?php include 'modules/indexRow.php'; ?>
    </div>
  </div>

  <script type="text/javascript" src="js/main.js"></script>
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
  <?php include 'assets\pages\footer.php'; ?>
</body>
</html>