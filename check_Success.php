<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sid = $_GET['sid'];
    $eid = $_GET['eid'];

    // SQL ลบข้อมูล
    $sql = "UPDATE JoinEvent SET status = 3 WHERE sid = ? AND eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $sid, $eid);

    if ($stmt->execute()) {
        echo "User removed successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
header("Location: check.php?eid=$eid");
exit();
?>