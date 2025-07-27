<?php
    if (isset($_POST['postRating'])) {
        $ratingValue = $_POST['ratingValue'];
        $comment = $_POST['ratingComment'];
        $byUserID = $_SESSION['user_id'];
        $toUserID = $_GET['id'];

        $post_query = $mysqli->prepare("INSERT INTO rating (rating, comment, by_user_id, to_user_id) VALUES (?,?,?,?)");
        $post_query->bind_param("isii", $ratingValue, $comment, $byUserID, $toUserID);
        $post_query->execute();
        $post_query->close();

        echo '<script>window.location.replace("user.php?id='. $_GET['id'].'");</script>';
    }
?>