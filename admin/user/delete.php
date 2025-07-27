<?php
require_once '../../config/connect_db.php';

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Bắt đầu giao dịch
    $mysqli->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

    try {
        // Xóa các đánh giá liên quan đến người dùng (by_user_id hoặc to_user_id)
        $deleteRatings = $mysqli->prepare("DELETE FROM rating WHERE by_user_id = ? OR to_user_id = ?");
        $deleteRatings->bind_param('ii', $userID, $userID);
        $deleteRatings->execute();
        $deleteRatings->close();

        // Lấy danh sách các car_id của các xe có seller_id là userID
        $carIds = [];
        $result = $mysqli->query("SELECT car_id FROM car WHERE seller_id = $userID");
        while ($row = $result->fetch_assoc()) {
            $carIds[] = $row['car_id'];
        }

        // Nếu có xe đã xóa, xóa các ảnh liên quan đến các xe đó
        if (!empty($carIds)) {
            // Xóa ảnh liên quan đến car_id
            $deleteImages = $mysqli->prepare("DELETE FROM image WHERE car_id IN (" . implode(',', $carIds) . ")");
            $deleteImages->execute();
            $deleteImages->close();
        }

        // Xóa các xe có seller_id là userID
        $deleteCars = $mysqli->prepare("DELETE FROM car WHERE seller_id = ?");
        $deleteCars->bind_param('i', $userID);
        $deleteCars->execute();
        $deleteCars->close();

        // Cuối cùng xóa người dùng
        $deleteUser = $mysqli->prepare("DELETE FROM user WHERE user_id = ?");
        $deleteUser->bind_param('i', $userID);
        $deleteUser->execute();
        $deleteUser->close();

        // Cam kết giao dịch
        $mysqli->commit();

        // Chuyển hướng thành công
        header("Location: ../index.php?view=user&delete=success");
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $mysqli->rollback();

        // Chuyển hướng thất bại
        header("Location: ../index.php?view=user&delete=failed");
    }
}
?>
