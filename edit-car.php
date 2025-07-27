<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_GET['car_id'])) {
    header("Location: index.php");
    exit();
}

include 'config/connect_db.php';

$result = $mysqli->query("SELECT seller_id FROM car WHERE car_id = " . $_GET['car_id']);

if ($result) {
    $row = $result->fetch_assoc();
    $seller_id = $row['seller_id'];
    if ($seller_id != $_SESSION['user_id']) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if (isset($_POST['edit'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = (int)$_POST['year'];
    $engine = $_POST['engine'];
    $mileage = (int)str_replace(",", '', $_POST['mileage']);
    $drivetrain = $_POST['drivetrain'];
    $VIN = $_POST['VIN'];
    $transmission = $_POST['transmission'];
    $titleStatus = $_POST['titleStatus'];
    $bodyStyle = $_POST['bodyStyle'];
    $location = $_POST['location'];
    $exteriorColor = $_POST['exteriorColor'];
    $interiorColor = $_POST['interiorColor'];
    $price = (int)str_replace(",", '', $_POST['price']);
    $sold = isset($_POST['sold']) ? 1 : 0;
    $car_id = (int)$_GET['car_id'];

    // Update query
    $edit_query = $mysqli->prepare('
        UPDATE car 
        SET make = ?, model = ?, year = ?, engine = ?, mileage = ?, drivetrain = ?, VIN = ?, transmission = ?, status = ?, body_style = ?, location = ?, exterior_color = ?, interior_color = ?, price = ?, sold = ? 
        WHERE car_id = ?
    ');

    if ($edit_query) {
        $edit_query->bind_param(
            "ssisissssssssiii",
            $make,
            $model,
            $year,
            $engine,
            $mileage,
            $drivetrain,
            $VIN,
            $transmission,
            $titleStatus,
            $bodyStyle,
            $location,
            $exteriorColor,
            $interiorColor,
            $price,
            $sold,
            $car_id
        );

        // Execute query
        if ($edit_query->execute()) {
            header("Location: car.php?car_id=" . $car_id);
            exit();
        } else {
            echo "Error updating record: " . $edit_query->error;
        }

        $edit_query->close();
    } else {
        echo "Error preparing query: " . $mysqli->error;
    }
}

class CarImage {
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // Truyền kết nối MySQLi vào class
    }

    public function getImages($id, $category)
    {
        $images = [];
        $img = null;

        $stmt = $this->db->prepare("SELECT base64_data FROM image WHERE car_id = ? AND category = ?");

        if ($stmt) {
            $stmt->bind_param("is", $id, $category);
            $stmt->execute();
            $stmt->bind_result($img);
            while ($stmt->fetch()) {
                $images[] = 'data:image/jpeg;base64,' . $img;
            }
            $stmt->close();
        }
        return $images;
    }
}

class Car {
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // Truyền kết nối MySQLi vào class
    }

    public function getCar($id) {
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->db->prepare("
            SELECT make, model, engine, drivetrain, transmission, mileage, VIN, body_style, 
                   status, exterior_color, interior_color, location, price, year, description, sold 
            FROM car 
            WHERE car_id = ?
        ");

        if ($stmt) {
            // Gắn tham số và thực thi câu lệnh
            $stmt->bind_param('i', $id);
            $stmt->execute();

            // Gắn kết quả vào các biến
            $stmt->bind_result(
                $carMake, $carModel, $carEngine, $carDrivetrain, $carTransmission, $carMileage, 
                $carVIN, $carBodyStyle, $carStatus, $carExteriorColor, $carInteriorColor, 
                $carLocation, $carPrice, $carYear, $carDescription, $carSold
            );

            // Lấy kết quả
            if ($stmt->fetch()) {
                $car = [
                    "make" => $carMake,
                    "model" => $carModel,
                    "engine" => $carEngine,
                    "drivetrain" => $carDrivetrain,
                    "transmission" => $carTransmission,
                    "mileage" => $carMileage,
                    "VIN" => $carVIN,
                    "bodyStyle" => $carBodyStyle,
                    "titleStatus" => $carStatus,
                    "exteriorColor" => $carExteriorColor,
                    "interiorColor" => $carInteriorColor,
                    "location" => $carLocation,
                    "price" => $carPrice,
                    "year" => $carYear,
                    "description" => $carDescription,
                    "sold" => $carSold
                ];
            } else {
                // Không tìm thấy xe
                $car = null;
            }

            // Đóng statement
            $stmt->close();
        } else {
            // Lỗi khi chuẩn bị câu lệnh
            throw new Exception("Failed to prepare the SQL statement.");
        }

        return $car;
    }
}

$car = (new Car($mysqli))->getCar($_GET['car_id']);
$img = new CarImage($mysqli);

$exterior = $img->getImages($_GET['car_id'],  'exterior');
$interior = $img->getImages($_GET['car_id'], 'interior');
$mechanical = $img->getImages($_GET['car_id'], 'mechanical');
$docs = $img->getImages($_GET['car_id'], 'docs');
$other = $img->getImages($_GET['car_id'], 'other');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarHub - Edit</title>

    <link rel="stylesheet" href="css/edit-car.css">
</head>

<body>
    <div class="header">
        <button onclick="history.back()"><i class="fa-solid fa-arrow-left" style="margin-right: 5px;"></i> Go Back</button>
    </div>
    <div class="container">
        <h1 class="h1" style="text-align: center;">EDIT CAR</h1>
        <form action="/CarHub/edit-car.php?car_id=<?= $_GET['car_id']; ?>" method="POST" style="margin-top: 20px;">
            <div class="grid-2">
                <div class="form-control">
                    <label>Make:</label>
                    <input type="text" id="make" name="make" value="<?= $car['make']; ?>">
                </div>
                <div class="form-control">
                    <label>Model:</label>
                    <input type="text" id="model" name="model" value="<?= $car['model']; ?>">
                </div>
                <div class="form-control">
                    <label>Year:</label>
                    <input type="number" min="1981" max="<?php echo date('Y'); ?>" id="year" name="year" value="<?= $car['year']; ?>">
                </div>
                <div class="form-control">
                    <label>Engine:</label>
                    <input type="text" id="engine" name="engine" value="<?= $car['engine']; ?>">
                </div>
                <div class="form-control">
                    <label>Mileage:</label>
                    <input type="text" id="mileage" name="mileage" value="<?= $car['mileage']; ?>">
                </div>
                <div class="form-control">
                    <label>Drivetrain:</label>
                    <select name="drivetrain">
                        <option value="Front-Wheel Drive (FWD)" <?php if($car['drivetrain'] == 'Front-Wheel Drive (FWD)') {echo 'selected';} ?> >Front-Wheel Drive (FWD)</option>
                        <option value="Rear-Wheel Drive (RWD)" <?php if($car['drivetrain'] == 'Rear-Wheel Drive (RWD)') {echo 'selected';} ?> >Rear-Wheel Drive (RWD)</option>
                        <option value="All-Wheel Drive (AWD)" <?php if($car['drivetrain'] == 'All-Wheel Drive (AWD)') {echo 'selected';} ?> >All-Wheel Drive (AWD)</option>
                        <option value="Four-Wheel Drive (4WD)" <?php if($car['drivetrain'] == 'Four-Wheel Drive (4WD)') {echo 'selected';} ?> >Four-Wheel Drive (4WD)</option>
                        <option value="Electric All-Wheel Drive (eAWD)" <?php if($car['drivetrain'] == 'Electric All-Wheel Drive (eAWD)') {echo 'selected';} ?> >Electric All-Wheel Drive (eAWD)</option>
                        <option value="Hybrid" <?php if($car['drivetrain'] == 'Hybrid Drivetrain') {echo 'selected';} ?> >Hybrid Drivetrain</option>
                    </select>
                </div>
                <div class="form-control">
                    <label>VIN:</label>
                    <input type="text" id="VIN" name="VIN" value="<?= $car['VIN']; ?>">
                </div>
                <div class="form-control">
                    <label>Transmission:</label>
                    <select name="transmission">
                        <option value="Automatic" <?php if($car['transmission'] == 'Automatic') {echo 'selected';} ?> >Automatic</option>
                        <option value="Manual" <?php if($car['transmission'] == 'Manual') {echo 'selected';} ?> >Manual</option>
                    </select>
                </div>
                <div class="form-control">
                    <label>Title Status:</label>
                    <select name="titleStatus">
                        <option value="Clean" <?php if($car['titleStatus'] == 'Clean') {echo 'selected';} ?> >Clean</option>
                        <option value="Salvage" <?php if($car['titleStatus'] == 'Salvage') {echo 'selected';} ?> >Salvage</option>
                        <option value="Rebuilt" <?php if($car['titleStatus'] == 'Rebuilt') {echo 'selected';} ?> >Rebuilt</option>
                        <option value="Junk" <?php if($car['titleStatus'] == 'Junk') {echo 'selected';} ?> >Junk</option>
                    </select>
                </div>
                <div class="form-control">
                    <label>Body Style:</label>
                    <select name="bodyStyle">
                        <option value="Coupe" <?php if($car['bodyStyle'] == 'Coupe') {echo 'selected';} ?> >Coupe</option>
                        <option value="Convertible" <?php if($car['bodyStyle'] == 'Convertible') {echo 'selected';} ?> >Convertible</option>
                        <option value="Hatchback" <?php if($car['bodyStyle'] == 'Hatchback') {echo 'selected';} ?> >Hatchback</option>
                        <option value="Sedan" <?php if($car['bodyStyle'] == 'Sedan') {echo 'selected';} ?> >Sedan</option>
                        <option value="SUV/Crossover" <?php if($car['bodyStyle'] == 'SUV/Crossover') {echo 'selected';} ?> >SUV/Crossover</option>
                        <option value="Truck" <?php if($car['bodyStyle'] == 'Truck') {echo 'selected';} ?> >Truck</option>
                        <option value="Van/Minivan" <?php if($car['bodyStyle'] == 'Van/Minivan') {echo 'selected';} ?> >Van/Minivan</option>
                        <option value="Wagon" <?php if($car['bodyStyle'] == 'Wagon') {echo 'selected';} ?> >Wagon</option>
                    </select>
                </div>
                <div class="form-control">
                    <label>Location:</label>
                    <input type="text" id="location" name="location" value="<?= $car['location']; ?>">
                </div>
                <div class="form-control">
                    <label>Exterior Color:</label>
                    <input type="text" id="exteriorColor" name="exteriorColor" value="<?= $car['exteriorColor']; ?>">
                </div>
                <div class="form-control">
                    <label>Interior Color:</label>
                    <input type="text" id="interiorColor" name="interiorColor" value="<?= $car['interiorColor']; ?>">
                </div>
                <div class="form-control">
                    <label>Price ($):</label>
                    <input type="text" id="price" name="price" value="<?= $car['price']; ?>">
                </div>
                <div class="form-control">
                    <label>Sold:</label>
                    <input type="checkbox" name="sold" <?php if($car['sold'] == 1) {echo 'checked';} ?> >
                </div>
            </div>
            <h2 style="margin: 30px 0 15px 0; text-align: center;">DESCRIPTION</h2>
            <div class="format-section">
                <div class="one">
                    <select class="select-heading" onchange="formatText('formatBlock', this.value); this.selectedIndex=0;">
                        <option class="option-heading" selected>Format</option>
                        <option value="h1" class="option-heading">Heading 1</option>
                        <option value="h2" class="option-heading">Heading 2</option>
                        <option value="h3" class="option-heading">Heading 3</option>
                    </select>
                </div>
                <div class="two">
                    <button type="button" class="btn-format" onclick="formatText('bold')"><i class="fa-solid fa-bold"></i></button>
                    <button type="button" class="btn-format" onclick="formatText('italic')"><i class="fa-solid fa-italic"></i></button>
                    <button type="button" class="btn-format" onclick="formatText('underline')"><i class="fa-solid fa-underline"></i></button>
                </div>
                <div class="three">
                    <button type="button" class="btn-format" onclick="formatText('justifyLeft')"><i class="fa-solid fa-align-left"></i></button>
                    <button type="button" class="btn-format" onclick="formatText('justifyCenter')"><i class="fa-solid fa-align-center"></i></button>
                    <button type="button" class="btn-format" onclick="formatText('justifyRight')"><i class="fa-solid fa-align-right"></i></button>
                    <button type="button" class="btn-format" onclick="formatText('justifyFull')"><i class="fa-solid fa-align-justify"></i></button>
                </div>
                <div class="four">
                    <button type="button" class="btn-format" onclick="formatText('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
                    <button type="button" class="btn-format" onclick="formatText('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
                </div>
                <div class="five">
                    <button type="button" class="btn-format" id="show-code" data-active="false"><i class="fa-solid fa-code"></i></button>
                </div>
            </div>
            <div class="textarea" id="textarea" contenteditable="true" oninput="setContent()"><?= htmlspecialchars_decode($car['description']); ?></div>
            <textarea name="description" style="display: none;" id="content"></textarea>

            <div class="center" style="margin-top: 20px;">
                <input class="btn-submit" type="submit" name="edit" value="Edit">
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.5"></script>
    <script src="js/edit-car.js"></script>
</body>
<?php include 'assets\pages\footer.php'; ?>
</html>