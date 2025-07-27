<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sell-car.css">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>CarHub - Sell Your Car</title>

</head>

<body>
    <?php include 'assets/pages/navbar.php'; ?>
    <?php
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
        header('Location: ./login.php');
    }
    ?>

    <div class="container mt-3">
        <h2 class="text-center fw-bold mb-3">SELL YOUR CAR</h2>
        <form method="POST" action="modules/postCar.php" enctype="multipart/form-data">
            <div class="d-flex justify-content-center align-items-center">
                <div class="sell-form">
                    <table class="mb-4">
                        <tr>
                            <td class="title">Make</td>
                            <td class="input">
                                <div class="dropdown-container">
                                    <input type="text" class="dropdown" id="makeInput" name="make" autocomplete="off">
                                    <div id="makeDropdown" class="dropdown-menu"></div>
                                </div>
                            </td>
                            <td class="title">Year</td>
                            <td class="input">
                                <input type="number" class="input-text" min="1981" max="<?php echo date('Y'); ?>" name="year" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Model</td>
                            <td class="input">
                                <div class="dropdown-container">
                                    <input type="text" class="dropdown" id="modelInput" name="model" autocomplete="off">
                                    <div id="modelDropdown" class="dropdown-menu"></div>
                                </div>
                            </td>
                            <td class="title">Engine</td>
                            <td class="input">
                                <input type="text" class="input-text" name="engine" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Mileage</td>
                            <td class="input">
                                <input type="text" class="input-text" name="mileage" autocomplete="off" id="mileage">
                            </td>
                            <td class="title">Drivetrain</td>
                            <td class="input">
                                <select name="driveTrain">
                                    <option value="Front-Wheel Drive (FWD)">Front-Wheel Drive (FWD)</option>
                                    <option value="Rear-Wheel Drive (RWD)">Rear-Wheel Drive (RWD)</option>
                                    <option value="All-Wheel Drive (AWD)">All-Wheel Drive (AWD)</option>
                                    <option value="Four-Wheel Drive (4WD)">Four-Wheel Drive (4WD)</option>
                                    <option value="Electric All-Wheel Drive (eAWD)">Electric All-Wheel Drive (eAWD)</option>
                                    <option value="Hybrid">Hybrid Drivetrain</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="title">VIN</td>
                            <td class="input">
                                <input type="text" class="input-text" name="VIN" autocomplete="off">
                            </td>
                            <td class="title">Transmission</td>
                            <td class="input">
                                <select name="transmission">
                                    <option value="Automatic">Automatic</option>
                                    <option value="Manual">Manual</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Title Status</td>
                            <td class="input">
                                <select name="status">
                                    <option value="Clean">Clean</option>
                                    <option value="Salvage">Salvage</option>
                                    <option value="Rebuilt">Rebuilt</option>
                                    <option value="Junk">Junk</option>
                                </select>
                            </td>
                            <td class="title">Body Style</td>
                            <td class="input">
                                <select name="bodyStyle">
                                    <option value="Coupe">Coupe</option>
                                    <option value="Convertible">Convertible</option>
                                    <option value="Hatchback">Hatchback</option>
                                    <option value="Sedan">Sedan</option>
                                    <option value="SUV/Crossover">SUV/Crossover</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Van/Minivan">Van/Minivan</option>
                                    <option value="Wagon">Wagon</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Location</td>
                            <td class="input">
                                <input type="text" class="input-text" name="location" autocomplete="off">
                            </td>
                            <td class="title">Exterior Color</td>
                            <td class="input">
                                <input type="text" class="input-text" name="exteriorColor" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td class="title">Price ($)</td>
                            <td class="input">
                                <input type="text" class="input-text" min="0" name="price" autocomplete="off" id="price">
                            </td>
                            <td class="title">Interior Color</td>
                            <td class="input">
                                <input type="text" class="input-text" name="interiorColor" autocomplete="off">
                            </td>
                        </tr>

                    </table>
                    <h4 class="fw-bold mb-3">Description</h4>
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
                    <div class="textarea" id="textarea" contenteditable="true" oninput="setContent()"></div>
                    <textarea name="description" style="display: none;" id="content"></textarea>
                </div>
            </div>

            <h4 class="fw-bold mt-4 mb-3">Upload Images <span style="font-weight: normal; font-size: 15px;">(First image in exterior will be the cover image)</span></h4>
            <div class="d-flex flex-comlumn mt-3 tab">
                <ul class="img-tab">
                    <li onclick="showTab('exterior')">Exterior</li>
                    <li onclick="showTab('interior')">Interior</li>
                    <li onclick="showTab('mechanical')">Mechanical</li>
                    <li onclick="showTab('docs')">Docs</li>
                    <li onclick="showTab('other')">Other</li>
                </ul>
                <div class="tab-content" id="exterior">
                    <div class="upload">
                        <input type="file" multiple accept="image/*" name="imageExterior[]" onchange="showListImages(event, 'imgExterior', '5')" style="display:none;">
                        <i class="fa-solid fa-upload"></i>
                        <h5>Upload your image(s)</h5>
                        <p>Maximum 10 images and minumum 5 images</p>
                    </div>
                    <div class="list-img">
                        <p style="font-weight: bold;">List of image(s):</p>
                        <ul class="list-item" id="imgExterior">
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="interior" style="display: none;">
                    <div class="upload">
                        <input type="file" multiple accept="image/*" name="imageInterior[]" onchange="showListImages(event, 'imgInterior', '4')" style="display:none;">
                        <i class="fa-solid fa-upload"></i>
                        <h5>Upload your image(s)</h5>
                        <p>Maximum 10 images and minumum 4 images</p>
                    </div>
                    <div class="list-img">
                        <p style="font-weight: bold;">List of image(s):</p>
                        <ul class="list-item" id="imgInterior">
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="mechanical" style="display: none;">
                    <div class="upload">
                        <input type="file" multiple accept="image/*" name="imageMechanical[]" onchange="showListImages(event, 'imgMechanical', null)" style="display:none;">
                        <i class="fa-solid fa-upload"></i>
                        <h5>Upload your image(s)</h5>
                        <p>(Not required)</p>
                    </div>
                    <div class="list-img">
                        <p style="font-weight: bold;">List of image(s):</p>
                        <ul class="list-item" id="imgMechanical">
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="docs" style="display: none;">
                    <div class="upload">
                        <input type="file" multiple accept="image/*" name="imageDocs[]" onchange="showListImages(event, 'imgDocs', null)" style="display:none;">
                        <i class="fa-solid fa-upload"></i>
                        <h5>Upload your image(s)</h5>
                        <p>(Not required)</p>
                    </div>
                    <div class="list-img">
                        <p style="font-weight: bold;">List of image(s):</p>
                        <ul class="list-item" id="imgDocs">
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="other" style="display: none;">
                    <div class="upload">
                        <input type="file" multiple accept="image/*" name="imageOther[]" onchange="showListImages(event, 'imgOther', null)" style="display:none;">
                        <i class="fa-solid fa-upload"></i>
                        <h5>Upload your image(s)</h5>
                        <p>(Not required)</p>
                    </div>
                    <div class="list-img">
                        <p style="font-weight: bold;">List of image(s):</p>
                        <ul class="list-item" id="imgOther">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="my-3 d-flex justify-content-center align-items-center">
                <button type="submit" class="btn-submit" name="submit">POST (-20 Credit)</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.5"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const params = new URLSearchParams(window.location.search);

            const errorMessages = {
                credit: {
                    title: "Not enough credit!",
                    html: "Please charge your wallet and try again!",
                    icon: "error",
                },
                transaction: {
                    title: "Transaction failed!",
                    html: "Your transaction could not be completed. Please try again later.",
                    icon: "error",
                },
            };

            const errorType = params.get("error");
            if (errorType && errorMessages[errorType]) {
                Swal.fire({
                    timer: 4000,
                    ...errorMessages[errorType],
                    showConfirmButton: false,
                });
            }
        });
    </script>
    <script src="js/sell-car.js"></script>
</body>
<?php include 'assets\pages\footer.php'; ?>
</html>