<?php
$carCarousel_query = $mysqli->prepare("
WITH RankedCars AS (
    SELECT 
        car_id,
        make,
        model,
        price,
        year,
        posted_at,
        ROW_NUMBER() OVER (ORDER BY posted_at DESC) AS car_rank
    FROM 
        car
),
RankedImages AS (
    SELECT 
        i.car_id,
        i.base64_data,
        ROW_NUMBER() OVER(PARTITION BY i.car_id ORDER BY i.image_id) AS image_rank
    FROM 
        image i
    WHERE 
        i.category = 'exterior'
)
SELECT 
    c.car_id,
    c.make, 
    c.model, 
    c.price, 
    c.year, 
    c.posted_at,
    ri.base64_data
FROM 
    RankedCars c
LEFT JOIN 
    RankedImages ri ON c.car_id = ri.car_id AND ri.image_rank <= 3
WHERE 
    c.car_rank <= 3
ORDER BY 
    c.car_rank, ri.image_rank;
");

$carCarousel_query->execute();
$carCarousel_query->bind_result($carID, $carTitleMake, $carTitleModel, $carTitlePrice, $carTitleYear, $carPostedAt, $carCarouselImg);

$carousel = [];
$currentCarId = null;

while ($carCarousel_query->fetch()) {
    if ($currentCarId !== $carID) {
        $carousel[] = [
            "car_id" => $carID,
            "make" => $carTitleMake,
            "model" => $carTitleModel,
            "price" => $carTitlePrice,
            "year" => $carTitleYear,
            "posted_at" => $carPostedAt,
            "images" => []
        ];
        $currentCarId = $carID;
    }
    if ($carCarouselImg) {
        $carousel[array_key_last($carousel)]['images'][] = 'data:image/jpeg;base64,' . $carCarouselImg;
    }
}

$carCarousel_query->close();

$isFirst = true;

foreach ($carousel as $info) {
    $car_id = $info['car_id'];
    $name = $info['year'] . ' ' . $info['make'] . ' ' . $info['model'];
    $price = $info['price'];
    $timeAgo = calculateTime($info['posted_at']);
    $images = $info['images'];

    $activeClass = $isFirst ? ' active' : '';
    $isFirst = false;
?>
    <a href="car.php?car_id=<?php echo $car_id; ?>">
        <div class="carousel-item<?php echo $activeClass; ?>" data-bs-interval="5000">
            <div class="row">
                <div class="col-9 p-1">
                    <!-- Ảnh chính đầu tiên -->
                    <img src="<?php echo isset($images[0]) ? $images[0] : 'path/to/default-image.jpg'; ?>" class="d-block w-100" alt="Car Image">
                </div>
                <div class="col-3 p-1">
                    <div class="row">
                        <!-- Các ảnh phụ nếu có -->
                        <img class="pb-2" src="<?php echo isset($images[1]) ? $images[1] : 'path/to/default-thumbnail.jpg'; ?>" class="d-block w-100" alt="Thumbnail">
                        <img src="<?php echo isset($images[2]) ? $images[2] : 'path/to/default-thumbnail.jpg'; ?>" class="d-block w-100" alt="Thumbnail">
                    </div>
                </div>
            </div>
            <div class="carousel-caption d-none d-md-block text-start" style="z-index: 1;">
                <h4><?php echo $name; ?></h4>
                <p>Price: <span id="title-price">$<?php echo number_format($price, 0, '', ','); ?></span></p>
                <p>Time: <span id="title-time"><?php echo $timeAgo; ?></span></p>
            </div>
        </div>
    </a>
<?php
}
?>