<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/car.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Document</title>

</head>

<body>
    <?php 
    include 'assets/pages/navbar.php'; 
    include 'modules/carPage.php';
    ?>
    <div class="container car-img overflow-hidden my-3 p-0">
        <div class="row">
            <div class="col-8 pe-1">
                <img class="img-fluid" src="<?php echo $imgExterior[0]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
            </div>
            <div class="col-2 px-1">
                <div class="row img-col">
                    <img class="img-fluid img-row" src="<?php echo $imgExterior[1]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                    <img class="img-fluid img-row py-2" src="<?php echo $imgExterior[2]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                    <img class="img-fluid img-row pb-2" src="<?php echo $imgExterior[3]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                    <img class="img-fluid img-row" src="<?php echo $imgExterior[4]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                </div>
            </div>
            <div class="col-2 px-1">
                <div class="row img-col">
                    <img class="img-fluid img-row" src="<?php echo $imgInterior[0]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                    <img class="img-fluid img-row py-2" src="<?php echo $imgInterior[1]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                    <img class="img-fluid img-row pb-2" src="<?php echo $imgInterior[2]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                    <div class="img-row img-mask">
                        <div class="position-relative">
                            <img class="img-fluid" src="<?php echo $imgInterior[3]; ?>" data-bs-toggle="modal" data-bs-target="#imageModal" alt="">
                            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <h5 class="mb-0 fw-semibold">View More</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Display Carousel -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content px-5 pt-3 pb-2">
                <div class="modal-body">
                    <i id="zoomToggle" class="fa fa-search-plus mb-3"></i>
                    <div id="carouselExteriorModal" class="carousel slide">
                        <div class="carousel-inner">
                            <?php
                            $first = true; // Khởi tạo biến để theo dõi phần tử đầu tiên
                            foreach ($imgAll as $img) {
                            ?>
                                <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                                    <img src="<?php echo $img; ?>" class="d-block w-100 zoomable" alt="Image">
                                </div>
                            <?php
                                $first = false; // Đặt biến thành false sau lần lặp đầu tiên
                            }
                            ?>
                        </div>

                        <!-- Controls for previous and next -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExteriorModal" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExteriorModal" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Car's Infomation -->
    <div class="container p-0">
        <div class="row">
            <div class="col-8">
                <div class="car-tag">
                    <p>Tag: </p>
                    <ol class="breadcrumb ms-1">
                        <li class="breadcrumb-item"><a href="index.php?transmission=<?php echo $carTransmission; ?>"><?php echo $carTransmission; ?></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo $carMake; ?></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo $carModel; ?></a></li>
                    </ol>
                </div>
                <div class="container text-holder">
                    <h3 class="car-name"><?php echo $car_title; ?></h3>
                    <h6 class="car-info">
                        <?php echo $carMileage; ?> | <?php echo $carTransmission; ?> | <?php echo $carEngine; ?>
                    </h6>
                    <div class="d-flex align-items-end w-100">
                        <h2 class="car-price m-0 d-flex" style="width: 40%;"><?php echo $carPrice; ?></h2>
                        <p class="car-time ms-auto"><i class="fa-regular fa-clock me-1"></i>Posted in: <?php echo $carPostedAt; ?></p>
                    </div>
                </div>
                <table class="table-car mt-4 w-100">
                    <tbody>
                        <tr>
                            <td>Make</td>
                            <td class="col-info"><?php echo $carMake; ?></td>
                            <td>Engine</td>
                            <td class="col-info"><?php echo $carEngine; ?></td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td class="col-info"><?php echo $carModel; ?></td>
                            <td>Drivetrain</td>
                            <td class="col-info"><?php echo $carDriveTrain; ?></td>
                        </tr>
                        <tr>
                            <td>Mileage</td>
                            <td class="col-info"><?php echo $carMileage; ?></td>
                            <td>Transmission</td>
                            <td class="col-info"><?php echo $carTransmission; ?></td>
                        </tr>
                        <tr>
                            <td>VIN</td>
                            <td class="col-info"><?php echo $carVIN; ?></td>
                            <td>Body Style</td>
                            <td class="col-info"><?php echo $carBodyStyle; ?></td>
                        </tr>
                        <tr>
                            <td>Title Status</td>
                            <td class="col-info"><?php echo $carStatus; ?></td>
                            <td>Exterior Color</td>
                            <td class="col-info"><?php echo $carExteriorColor; ?></td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td class="col-info"><?php echo $carLocation; ?></td>
                            <td>Interior Color</td>
                            <td class="col-info"><?php echo $carInteriorColor; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Car Seller Details -->
            <div class="col-4">
                <div class="car-seller">
                    <h4>Seller Information</h4>
                    <div class="row d-flex align-items-center">
                        <div class="col-4 pe-1 text-center">
                            <img src="assets/img/avatar.png" class="w-100" alt="">
                        </div>
                        <div class="col-8">
                            <div class="d-flex align-items-end">
                                <h5 class="fw-bold m-0"><a href="user.php?id=<?= $carSellerID ?>"><?php echo $sellerName; ?></a></h5>
                                <p style="margin: 0 0 0 8px;"><?php echo $sellerRole; ?></p>
                            </div>
                            <ol class="breadcrumb my-2">
                                <li class="breadcrumb-item"><i class="fa-solid fa-star"></i> <?php echo $avgRating; ?> (<?php echo $countRating; ?>)</li>
                                <li class="breadcrumb-item"><?php echo $carSold; ?> sold</li>
                                <li class="breadcrumb-item"><?php echo $carForSale; ?> for selling</li>
                            </ol>
                            <button class="btn">Seller's phone number: <?php echo $sellerPhone; ?></button>
                        </div>
                    </div>

                    <?php
                    if ($carSold > 1) {
                    ?>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 15px;">
                                <h6 class="fw-bold m-0">Cars for sale from this seller:</h6>
                                <a href="user.php" style="font-size: 14px; color: #858585;">See more</a>
                            </div>
                            <div class="d-flex justify-content-between mb-2 w-100">
                            <?php foreach ($otherCars as $car): ?>
                                <a href="car.php?car_id=<?= $car['id'] ?>" class="d-flex flex-column" style="width:48%;">
                                    <img src="<?= !empty($car['images']) ? $car['images'][0] : '' ?>" class="w-100 mb-2" alt="">
                                    <h6 class="fw-bold mb-1"><?= $car['year'] . ' ' . $car['make'] . ' ' . $car['model'] ?></h6>
                                    <p><?= $car['mileage'] ?> | <?= $car['engine'] ?> | <?= $car['transmission'] ?></p>
                                    <h5 class="fw-bold m-0"><?= $car['price'] ?></h5>
                                </a>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    <?php }; ?>
                </div>
            </div>
        </div>

        <div class="my-5">
            <?php echo $carDescription; ?>
        </div>
    </div>

    <script src="js/car.js"></script>
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
<?php include 'assets\pages\footer.php'; ?>
</html>