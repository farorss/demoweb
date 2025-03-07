<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $eid = $_GET['eid'];
    $sid = $_SESSION['userid'];
    $status = 1;
    $name_check = 1;

    $sql = 'INSERT INTO JoinEvent (eid, sid, status, name_check) VALUES (?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiii', $eid, $sid, $status, $name_check);
    $stmt->execute();

}
header("Location: index.php");
exit();
?>