<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/user.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>CarHub - User Page</title>


</head>

<body>
    <?php
    include 'assets/pages/navbar.php'; 
    include 'modules/userPage.php';
    ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-4">
                <div class="car-seller">
                    <div class="row d-flex align-items-center">
                        <div class="col-3 pe-1 text-center">
                            <img src="assets/img/avatar.png" class="w-100" alt="">
                        </div>
                        <div class="col-9">
                            <div class="d-flex align-items-end mb-2">
                                <h5 class="fw-bold m-0"><?php echo $userName; ?></h5>
                                <p style="margin: 0 0 0 8px;">(<?php echo $userRole; ?>)</p>
                            </div>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><i class="fa-solid fa-star"></i> <?php echo $avgRating; ?> (<?php echo $ratingCount; ?>)</li>
                                <li class="breadcrumb-item"><?php echo count($listSoldCar); ?> sold</li>
                                <li class="breadcrumb-item"><?php echo count($listForSellCar); ?> for selling</li>
                            </ol>
                        </div>
                    </div>
                    <hr class="mx-2">
                    <div class="px-2">
                        <div class="d-flex align-items-center">
                            <p class="m-0"><i class="fa-regular fa-envelope me-1 text-center" style="height: 13px; width: 13px;"></i> Email: </p>
                            <p class="ms-1 my-0" style="color: white; width: 300px; overflow: hidden; text-overflow: ellipsis;"><?php echo $userEmail; ?></p>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <p class="m-0"><i class="fa-solid fa-phone me-1 text-center" style="height: 13px; width: 13px;"></i> Phone: </p>
                            <p class="ms-1 my-0" style="color: white; width: 300px; overflow: hidden; text-overflow: ellipsis;"><?php echo $userPhone; ?></p>
                        </div>
                    </div>
                </div>
                <h4 class="fw-bold mt-5">Rating</h4>
                <hr>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $_GET['id']):?>
                <div class="container d-flex justify-content-center align-items-center">
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="text-center">
                            <p class="m-0">Rating this user:</p>
                            <div id="rating" class="d-flex justify-content-center my-2">
                                <div class="fs-4 d-flex align-items-center rating">
                                    <i data-value="1" class="fa-regular fa-star"></i>
                                    <i data-value="2" class="fa-regular fa-star"></i>
                                    <i data-value="3" class="fa-regular fa-star"></i>
                                    <i data-value="4" class="fa-regular fa-star"></i>
                                    <i data-value="5" class="fa-regular fa-star"></i>
                                    <input type="hidden" name="ratingValue" id="ratingValue">
                                </div>
                            </div>
                            <textarea name="ratingComment" rows="5" id="" class="form-control mt-3" style="width:400px; background-color:transparent;color:white;border:#858585 solid 0.2px;"></textarea>
                            <button name="postRating" class="btn my-3">Send</button>
                        </div>
                    </form>
                    <?php include 'modules/postRating.php'; ?>
                </div>
                <?php endif; ?>
                <?php
                if (!empty($ratings)):
                    foreach ($ratings as $rating): 
                ?>
                <div class="row my-3">
                    <div class="col-2">
                        <img src="assets/img/avatar.png" class="w-100">
                    </div>
                    <div class="col-10">
                        <a href="user.php?id=<?= $rating['reviewerID']; ?>">
                            <h6><?= $rating['reviewerName'] ?></h6>
                        </a>
                        <div class="fs-5 d-flex align-items-center">
                            <?php
                                $fullStars = $rating['rating'];
                                $totalStars = 5;
                            
                                for ($i = 1; $i <= $fullStars; $i++) {
                                    echo '<i class="fa-solid fa-star"></i>';
                                }

                                for ($i = $fullStars + 1; $i <= $totalStars; $i++) {
                                    echo '<i class="fa-regular fa-star"></i>';
                                }
                            ?>
                        </div>
                        <p class="mt-2"><?= $rating['comment'] ?></p>
                    </div>
                </div>
                <?php
                    endforeach;
                else:
                    echo "<p>No rating.</p>";
                endif;
                ?>
            </div>
            <div class="col-8">
                <ul id="sellerTab" class="d-flex seller-tab px-0" role="tablist">
                    <li role="presentation">
                        <div class="tab-item active" data-bs-toggle="tab" data-bs-target="#for-selling" role="tab">For selling</div>
                    </li>
                    <li role="presentation">
                        <div class="tab-item" data-bs-toggle="tab" data-bs-target="#sold" role="tab">Sold</div>
                    </li>
                </ul>
                <div class="tab-content" id="sellerTabContent">
                    <div class="tab-pane fade show active" id="for-selling" role="tabpanel" tabindex="0">
                        <div class="row">
                            <?php
                            if ($listForSellCar == []) {
                                echo "<p>No car found.</p>";
                            } else {
                                foreach ($listForSellCar as $car):
                            ?>
                                    <div class="col-4 mb-3">
                                        <a href="car.php?car_id=<?= $car['id'] ?>" class="d-flex flex-column mx-2">
                                            <img src="<?= !empty($car['images']) ? $car['images'][0] : '' ?>" style="height: 168px;" class="w-100 mb-2" alt="">
                                            <h5 class="fw-bold mb-1"><?= $car['year'] . ' ' . $car['make'] . ' ' . $car['model'] ?></h5>
                                            <p class="m-0"><?= $car['mileage'] ?> | <?= $car['engine'] ?> | <?= $car['transmission'] ?></p>
                                            <hr class="my-2">
                                            <h5 class="fw-bold m-0"><?= $car['price'] ?></h5>
                                        </a>
                                    </div>
                            <?php endforeach;
                            } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sold" role="tabpanel" tabindex="0">
                    <div class="row">
                            <?php
                            if ($listSoldCar == []) {
                                echo "<p>No car found.</p>";
                            } else {
                                foreach ($listSoldCar as $car):
                            ?>
                                    <div class="col-4">
                                        <a href="car.php?car_id=<?= $car['id'] ?>" class="d-flex flex-column mx-2">
                                            <img src="<?= !empty($car['images']) ? $car['images'][0] : '' ?>" class="w-100 mb-2" alt="">
                                            <h5 class="fw-bold mb-1"><?= $car['year'] . ' ' . $car['make'] . ' ' . $car['model'] ?></h5>
                                            <p class="m-0"><?= $car['mileage'] ?> | <?= $car['engine'] ?> | <?= $car['transmission'] ?></p>
                                            <hr class="my-2">
                                            <h5 class="fw-bold m-0"><?= $car['price'] ?></h5>
                                        </a>
                                    </div>
                            <?php endforeach;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.rating i').forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));

                // Nếu ngôi sao đã chọn, nhấp lại sẽ hủy chọn
                if (this.classList.contains('fa-solid')) {
                    clearStars();
                } else {
                    setStars(value);
                    document.getElementById('ratingValue').value = value;
                }
            });
        });

        // Hàm đánh dấu các ngôi sao đến ngôi sao được nhấp
        function setStars(value) {
            clearStars();
            document.querySelectorAll('.rating i').forEach(star => {
                const starValue = parseInt(star.getAttribute('data-value'));
                if (starValue <= value) {
                    star.classList.remove('fa-regular');
                    star.classList.add('fa-solid');
                }
            });
        }

        // Hàm xóa tất cả các ngôi sao đã chọn
        function clearStars() {
            document.querySelectorAll('.rating i').forEach(star => {
                star.classList.remove('fa-solid');
                star.classList.add('fa-regular');
            });
        }
    </script>
</body>
<?php include 'assets\pages\footer.php'; ?>
</html>