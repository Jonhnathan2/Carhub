<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <title>CarHub - My Cars</title>

    <style>
        .table-container {
            max-width: 100%;
            overflow-x: auto;
            white-space: nowrap;
            border: 1px solid #585858;
        }
        /* width */
        .table-container::-webkit-scrollbar {
        height: 7px;
        }

        /* Track */
        .table-container::-webkit-scrollbar-track {
        background: #ffffff;
        }

        /* Handle */
        .table-container::-webkit-scrollbar-thumb {
        background: mediumseagreen;
        }

        .car-table {
            width: 2200px; /* Set width to make table scrollable */
            border-collapse: collapse;
        }

        .car-table th,
        .car-table td {
            border: 1px solid #585858;
            padding: 10px 15px;
            text-align: center;
        }

        .car-table th {
            font-weight: 600;
        }

        .car-table .col-action {
            display: grid !important;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
        }

        .car-table .button {
            padding: 5px 10px;
            background-color: transparent;
            border: 1px solid #585858;
            border-radius: 5px;
            color: silver;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .car-table .button:hover {
            color: white;
            border: white solid 1px;
        }
        footer {
            margin-top: auto; /* Ensure footer stays at the bottom of the viewport */
        }
    </style>
</head>
<body>
    <?php
        include('assets/pages/navbar.php');
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
    ?>
    <div class="container mt-3">
        <h1 class="fw-bold">My Cars</h1>
        <div class="mt-4 d-flex justify-content-center">
            <div class="table-container">
                <table class="car-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Car</th>
                            <th>Engine</th>
                            <th>Drivetrain</th>
                            <th>Transmission</th>
                            <th>Mileage</th>
                            <th>VIN</th>
                            <th>Body Style</th>
                            <th>Title Status</th>
                            <th>Exterior Color</th>
                            <th>Interior Color</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Posted At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $table_query = $mysqli->prepare("SELECT * FROM car WHERE seller_id = ?");
                            $table_query->bind_param('i', $_SESSION['user_id']);
                            $table_query->execute();
                            $result = $table_query->get_result();
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>". $row['car_id']. "</td>";
                                echo "<td>". $row['year'] . " " . $row['make']. " ". $row['model'] ."</td>";
                                echo "<td>". $row['engine']. "</td>";
                                echo "<td>". $row['drivetrain']. "</td>";
                                echo "<td>". $row['transmission']. "</td>";
                                echo "<td>". $row['mileage']. "</td>";
                                echo "<td>". $row['VIN']. "</td>";
                                echo "<td>". $row['body_style']. "</td>";
                                echo "<td>". $row['status']. "</td>";
                                echo "<td>". $row['exterior_color']. "</td>";
                                echo "<td>". $row['interior_color']. "</td>";
                                echo "<td>". $row['location']. "</td>";
                                echo "<td>$". number_format($row['price'], 0, '', ',') . "</td>";
                                echo "<td>". $row['posted_at']. "</td>";
                                if ($row['sold'] == 0) {
                                    echo "<td><span class='badge text-bg-success'>For Sale</span></td>";
                                } else {
                                    echo "<td><span class='badge text-bg-danger'>Sold</span></td>";
                                }
                                echo "<td class='col-action'>            
                                            <a href='edit-car.php?car_id=". $row['car_id'] ."' class='button'>Edit</a>
                                            <a href='modules/deleteCar.php?car_id=". $row['car_id'] . "' class='button'>Delete</a>
                                            <a href='car.php?car_id=". $row['car_id'] ."' class='button'>View</a>
                                    </td>";
                                echo "</tr>";
                            }
                            $table_query->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<?php include 'assets\pages\footer.php'; ?>
</html>
