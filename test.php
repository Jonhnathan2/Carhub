<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if (isset($_POST['send'])) {
            if (isset($_POST['checked'])) {
                echo 'yes';
            }
        }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="checkbox" name="checked" >
        <input type="submit" name="send">
    </form>
</body>
</html>

