<?php
if (!isset($_GET['id'])) {
    echo '<h1>User Not Found!</h1>';
    exit();
}

$userID = $_GET['id'];

// Prepare the SQL query to fetch all cars (both sold and for sale) for the given seller
$carQuery = $mysqli->prepare('
    WITH RankedImages AS (
        SELECT 
            i.car_id,
            i.base64_data,
            ROW_NUMBER() OVER(PARTITION BY i.car_id ORDER BY i.image_id) AS row_num
        FROM 
            image i
        WHERE 
            i.category = "exterior"
    )
    SELECT 
        c.car_id, 
        c.make, 
        c.model, 
        c.engine, 
        c.transmission, 
        c.mileage, 
        c.price, 
        c.year, 
        c.sold,
        ri.base64_data
    FROM 
        car c
    LEFT JOIN 
        RankedImages ri ON c.car_id = ri.car_id AND ri.row_num = 1
    WHERE 
        c.seller_id = ?
');
$carQuery->bind_param("i", $userID);
$carQuery->execute();
$carQuery->bind_result($otherCarID, $otherMake, $otherModel, $otherEngine, $otherTransmission, $otherMileage, $otherPrice, $otherYear, $carSold, $base64Data);

$listForSellCar = [];
$listSoldCar = [];

while ($carQuery->fetch()) {
    // Collect car information and images
    $carData = [
        'id' => $otherCarID,
        'make' => $otherMake,
        'model' => $otherModel,
        'engine' => $otherEngine,
        'transmission' => $otherTransmission,
        'mileage' => number_format($otherMileage, 0, '', ',') . ' miles',
        'price' => '$' . number_format($otherPrice, 0, '', ','),
        'year' => $otherYear,
        'images' => []
    ];

    // If there is an image, add it to the images array
    if ($base64Data) {
        $carData['images'][] = 'data:image/jpeg;base64,' . $base64Data;
    }

    // Separate cars based on sold status
    if ($carSold == 0) {
        // Cars for sale
        $listForSellCar[] = $carData;
    } else {
        // Sold cars
        $listSoldCar[] = $carData;
    }
}

$carQuery->close();

$userInfo = $mysqli->prepare("
WITH RatingUser AS (
    SELECT
        AVG(r.rating) AS avg_rating,
        COUNT(r.rating) AS rating_count,
        r.to_user_id
    FROM
        rating r
    GROUP BY
        r.to_user_id
)
SELECT
    u.name,
    u.email,
    u.phone,
    u.role,
    COALESCE(ru.avg_rating, 0) AS avg_rating,  -- Set default to 0 if no rating
    COALESCE(ru.rating_count, 0) AS rating_count  -- Set default to 0 if no rating
FROM
    user u
LEFT JOIN
    RatingUser ru ON u.user_id = ru.to_user_id
WHERE
    u.user_id = ?;
");
$userInfo->bind_param('i', $userID);
$userInfo->execute();
$userInfo->bind_result($userName, $userEmail, $userPhone, $role, $avgRating, $ratingCount);

$userInfo->fetch();

$avgRating = number_format($avgRating, 0, '', ',');
switch ($role) {
    case 0:
        $userRole = "Private Party";
        break;
    case 1:
        $userRole = "Dealer";
        break;
    case 2:
        $userRole = "Manufacturer";
        break;
    case 3:
        $userRole = "Adminstrator";
        break;
    default:
        $userRole = "Unknown";
        break;
}
$userInfo->close();

$ratingQuery = $mysqli->prepare("
    SELECT 
        r.rating,
        r.comment,
        r.by_user_id,
        u.name AS reviewer_name
    FROM 
        rating r
    JOIN 
        user u ON r.by_user_id = u.user_id
    WHERE 
        r.to_user_id = ?;
");
$ratingQuery->bind_param('i', $userID);
$ratingQuery->execute();
$ratingQuery->bind_result($rating, $comment, $reviewerID, $reviewerName);

$ratings = [];
while ($ratingQuery->fetch()) {
    $ratings[] = [
        'rating' => $rating,
        'comment' => $comment,
        'reviewerID' => $reviewerID,
        'reviewerName' => $reviewerName
    ];
}

$ratingQuery->close();
?>
