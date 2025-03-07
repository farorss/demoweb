
<?php
include 'db.php';

if (isset($_GET['eid'])) {
    $id = $_GET['eid'];

    $sql = "DELETE FROM Event WHERE eid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: profile.php");
    exit();
}
?>
