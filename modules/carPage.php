<?php
if (!isset($_GET['car_id'])) {
    echo "<h1>Car Not Found</h1>";
    exit();
} else {

    $car_id = $_GET['car_id'];

    // Get th information about car
    $car_query = $mysqli->prepare('SELECT make, model, engine, drivetrain, transmission, mileage, VIN, body_style, status, exterior_color, interior_color, location, price, year, seller_id, description, posted_at, sold FROM car WHERE car_id = ?');
    $car_query->bind_param("i", $car_id);
    $car_query->execute();

    $car_query->bind_result($carMake, $carModel, $carEngine, $carDriveTrain, $carTransmission, $mileage, $carVIN, $carBodyStyle, $carStatus, $carExteriorColor, $carInteriorColor, $carLocation, $price, $carYear, $carSellerID, $carDescription, $postedAt, $carSold);


    if ($car_query->fetch()) {
        $car_title = $carYear . ' ' . $carMake . ' ' . $carModel;
        $carMileage = number_format($mileage, 0, '', ',') . ' miles';
        if ($carSold == 0) {
            $carPrice = '$' . number_format($price, 0, '', ',');
        } else {
            $carPrice = '<span><s>$' . number_format($price, 0, '', ',') . '</s> SOLD</span>';
        }
        $carPostedAt = calculateTime($postedAt);
    } else {
        header("Location: index.php ");
    }

    $car_query->close();

    $category = array('exterior', 'interior', 'mechanical', 'docs', 'other');

    // Query for exterior images
    $imgExterior = [];
    $imgExterior_query = $mysqli->prepare('SELECT base64_data FROM image WHERE car_id = ? AND category = ?');
    $imgExterior_query->bind_param("is", $car_id, $category[0]);
    $imgExterior_query->execute();

    $imgExterior_query->bind_result($imgNameExterior);

    while ($imgExterior_query->fetch()) {
        $imgExterior[] = 'data:image/jpeg;base64,' . $imgNameExterior;
    }

    $imgExterior_query->close();

    // Query for interior images
    $imgInterior = [];
    $imgInterior_query = $mysqli->prepare('SELECT base64_data FROM image WHERE car_id =? AND category =?');
    $imgInterior_query->bind_param("is", $car_id, $category[1]);
    $imgInterior_query->execute();

    $imgInterior_query->bind_result($imgNameInterior);

    while ($imgInterior_query->fetch()) {
        $imgInterior[] = 'data:image/jpeg;base64,' . $imgNameInterior;
    }

    $imgInterior_query->close();

    // Query for mechanical images
    $imgMechanical = [];
    $imgMechanical_query = $mysqli->prepare('SELECT base64_data FROM image WHERE car_id =? AND category =?');
    $imgMechanical_query->bind_param("is", $car_id, $category[2]);
    $imgMechanical_query->execute();

    $imgMechanical_query->bind_result($imgNameMechanical);

    while ($imgMechanical_query->fetch()) {
        $imgMechanical[] = 'data:image/jpeg;base64,' . $imgNameMechanical;
    }

    $imgMechanical_query->close();

    // Query for docs images
    $imgDocs = [];
    $imgDocs_query = $mysqli->prepare('SELECT base64_data FROM image WHERE car_id =? AND category =?');
    $imgDocs_query->bind_param("is", $car_id, $category[3]);
    $imgDocs_query->execute();

    $imgDocs_query->bind_result($imgNameDocs);

    while ($imgDocs_query->fetch()) {
        $imgDocs[] = 'data:image/jpeg;base64,' . $imgNameDocs;
    }

    $imgDocs_query->close();


    // Query for other images
    $imgOther = [];
    $imgOther_query = $mysqli->prepare('SELECT base64_data FROM image WHERE car_id =? AND category =?');
    $imgOther_query->bind_param("is", $car_id, $category[4]);
    $imgOther_query->execute();

    $imgOther_query->bind_result($imgNameOther);

    while ($imgOther_query->fetch()) {
        $imgOther[] = 'data:image/jpeg;base64,' . $imgNameOther;
    }

    $imgOther_query->close();

    // Get seller information selling car
    $seller_query = $mysqli->prepare('SELECT name, phone, role FROM user WHERE user_id = ?');
    $seller_query->bind_param("i", $carSellerID);
    $seller_query->execute();
    $seller = $seller_query->bind_result($sellerName, $sellerPhone, $role);
    $seller_query->fetch();

    //    if ($role == 0) {
    //         $sellerRole = 'Private Party';
    //     } else if ($role == 1) {
    //         $sellerRole = 'Dealer';
    //     } else if ($role == 2) {
    //         $sellerRole = 'Manufacturer';
    //     }
    switch ($role) {
        case 0:
            $sellerRole = 'Private Party';
            break;
        case 1:
            $sellerRole = 'Dealer';
            break;
        case 2:
            $sellerRole = 'Manufacturer';
            break;
        case 3:
            $sellerRole = 'Adminstrator';
            break;
    }

    $seller_query->close();

    // Array of all car's images
    $imgAll = array_merge($imgExterior, $imgInterior, $imgMechanical, $imgDocs, $imgOther);
    $imgAll = array_values($imgAll);

    // Count cars for sale, sold and ratings
    $car_stats_query = $mysqli->prepare('SELECT COUNT(CASE WHEN sold = 1 THEN 1 END) AS sold, COUNT(CASE WHEN sold = 0 THEN 1 END) AS forSale FROM car WHERE seller_id = ?');
    $car_stats_query->bind_param("i", $carSellerID);
    $car_stats_query->execute();
    $car_stats_query->bind_result($carSold, $carForSale);
    $car_stats_query->fetch();

    $car_stats_query->close();

    // Get average rating of car
    $rating_query = $mysqli->prepare('SELECT AVG(rating) AS avg, COUNT(rating) AS count FROM `rating` WHERE to_user_id = ?');
    $rating_query->bind_param("i", $carSellerID);
    $rating_query->execute();
    $rating = $rating_query->bind_result($avg, $countRating);
    $rating_query->fetch();
    $avgRating = number_format($avg, 0, '', ',');

    $rating_query->close();

    // Find other cars for sale from this seller, including their exterior images
    $other_query = $mysqli->prepare('
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
        ri.base64_data
    FROM 
        car c
    LEFT JOIN 
        RankedImages ri ON c.car_id = ri.car_id AND ri.row_num = 1
    WHERE 
        c.seller_id = ? 
        AND c.car_id != ?
        AND c.sold = 0
    LIMIT 2;
    ');
    $other_query->bind_param("ii", $carSellerID, $car_id);
    $other_query->execute();
    $other_query->bind_result($otherCarID, $otherMake, $otherModel, $otherEngine, $otherTransmission, $otherMileage, $otherPrice, $otherYear, $base64Data);

    $otherCars = [];

    while ($other_query->fetch()) {
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

        // Store the car data
        $otherCars[] = $carData;
    }

    $other_query->close();
}
