<?php
session_start();

require_once 'config/connect_db.php';

if (isset($_SESSION['user_id'])) {
    $credit_query = $mysqli->query('SELECT credit FROM user WHERE user_id =' . $_SESSION["user_id"]);
    if ($credit_query) {
        $credit_row = $credit_query->fetch_assoc();
        $credit = $credit_row['credit'];
    } else {
        echo "Error: " . $mysqli->error; // Handle query error
    }
}
?>
<link rel="stylesheet" href="css/navbar.css">
<link rel="stylesheet" href="css/footer.css">
<script>
    function showDrop() {
        const drop = document.getElementById("dropNavbar");
        drop.classList.toggle("show");

        document.addEventListener("click", function handleClickOutside(event) {
            if (!drop.contains(event.target) && event.target.closest("button") === null) {
                drop.classList.remove("show");
                document.removeEventListener("click", handleClickOutside);
            }
        });
    }
</script>
<header class="sticky-header">
    <nav>
        <ul>
            <li id="logo"><a href="index.php"><img src="assets/img/Logo.png" width="150px"></a></li>
            <li><a id="item" href="sell-car.php">Sell a car</a></li>
            <li><a id="item" href="index.php">Buy a car</a></li>
            <li><a id="item" href="tip-trick.php">Tips & Tricks</a></li>
            <li><a id="item" href="about-us.php">About us</a></li>
        </ul>
        <div class="right-navbar">
            <div class="search-container">
                <form action="index.php" method="get">
                    <input type="text" name="search" placeholder="Search for cars (ex. BMW, Audi, Ford)" autocomplete="off">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </form>
            </div>

            <?php if (!isset($_SESSION['username'])): ?>

                <a class="a-user" href="login.php">
                    <i class="fa-regular fa-circle-user"></i>
                </a>

            <?php else: ?>

                <div class="drop">
                    <button onclick="showDrop()" class="drop-toggle">Hi, <?= $_SESSION['name'] ?> !</button>
                    <div id="dropNavbar" class="drop-content">
                        <p class="credit">Your Credit: <?= $credit; ?></p>
                        <?php if ($_SESSION['role'] == '3') {
                            echo '<a href="admin" class="drop-item">Admin dashboard</a>';
                        } ?>
                        <a href="user.php?id=<?= $_SESSION['user_id'] ?>" class="drop-item">My profile</a>
                        <a href="my-cars.php" class="drop-item">My cars</a>
                        <a href="credit">My wallet</a>
                        <a href="modules/logout.php" class="drop-item">Logout</a>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </nav>
</header>