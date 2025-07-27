<?php

// Nhận giá trị từ URL (GET method)
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'All';
$transmission = isset($_GET['transmission']) ? $_GET['transmission'] : 'All';
$body_style = isset($_GET['body_style']) ? $_GET['body_style'] : 'All';
$start_year = isset($_GET['start_year']) ? $_GET['start_year'] : null;
$end_year = isset($_GET['end_year']) ? $_GET['end_year'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Tạo truy vấn SQL cơ bản với CTE để lấy 1 hình ảnh đầu tiên cho mỗi xe
$carQuery = "
    WITH FirstImage AS (
        SELECT 
            i.car_id,
            i.base64_data,
            ROW_NUMBER() OVER(PARTITION BY i.car_id ORDER BY i.image_id) AS row_num
        FROM 
            image i
        WHERE 
            i.category = 'exterior'
    )
    SELECT 
        c.*, 
        fi.base64_data 
    FROM 
        car AS c
    LEFT JOIN 
        FirstImage AS fi ON c.car_id = fi.car_id AND fi.row_num = 1
    WHERE 
        1=1
";

// Thêm điều kiện tìm kiếm nếu có
if ($search) {
    $carQuery.= " AND (c.make LIKE '%". $mysqli->real_escape_string($search). "%' OR c.model LIKE '%". $mysqli->real_escape_string($search). "%')";
}

// Thêm điều kiện lọc cho Transmission nếu được chọn
if ($transmission !== 'All') {
    $carQuery .= " AND c.transmission = '" . $mysqli->real_escape_string($transmission) . "'";
}

// Thêm điều kiện lọc cho Body Style nếu được chọn
if ($body_style !== 'All') {
    $carQuery .= " AND c.body_style = '" . $mysqli->real_escape_string($body_style) . "'";
}

// Thêm điều kiện lọc theo khoảng năm
if ($start_year && $end_year) {
    $carQuery .= " AND c.year BETWEEN " . $mysqli->real_escape_string($start_year) . " AND " . $mysqli->real_escape_string($end_year);
}

// Thêm điều kiện sắp xếp (sort) nếu có
switch ($sort) {
    case 'newest':
        $carQuery .= " ORDER BY c.year DESC"; // Sắp xếp theo năm mới nhất
        break;
    case 'oldest':
        $carQuery .= " ORDER BY c.year ASC"; // Sắp xếp theo năm cũ nhất
        break;
    case 'lowest-odo':
        $carQuery .= " ORDER BY c.mileage ASC"; // Sắp xếp theo quãng đường thấp nhất
        break;
    default:
        // Không sắp xếp nếu không chọn
        break;
}

$result = $mysqli->query($carQuery);
$mysqli->close();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Tạo mảng car chứa dữ liệu của xe cho từng vòng lặp
        $car = [
            "nameCar" => $row['year'] . ' ' . $row['make'] . ' ' . $row['model'],
            "priceCar" => $row['price'],
            "dateCar" => $row['year'],
            "transmissionCar" => $row['transmission'],
            "bodystyleCar" => $row['body_style']
        ];

        $postedAt = $row['posted_at'];
        $timeAgo = calculateTime($postedAt);

        // Lấy hình ảnh base64 từ cột base64_data hoặc sử dụng hình ảnh mặc định
        $imageSrc = $row['base64_data'] ? 'data:image/jpeg;base64,' . $row['base64_data'] : 'default-image.jpg';

        // Hiển thị dữ liệu từ mảng car và hình ảnh
        echo '
            <div class="col-3 item" data-year="' . $car['dateCar'] . '" data-transmission="' . $car['transmissionCar'] . '" data-body-style="' . $car['bodystyleCar'] . '">
                <a href="car.php?car_id=' . $row['car_id'] . '" onclick="show()">
                    <img src="' . $imageSrc . '" class="d-block w-100 item-img" alt="Car Image">
                    <div class="item-description">
                        <h6>' . $car['nameCar'] . '</h6>
                        <p class="info"></p>
                        <div class="d-flex justify-content-between align-items-end mt-1">
                            <h4>$' . number_format($car['priceCar'], 0, '', ',') . '</h4>
                            <p>' . $timeAgo . '</p>
                        </div>
                    </div>
                </a>
            </div>
        ';
    }
} else {
    echo "0 results";
}
?>