<?php
include "db.php";
session_start();

if (!isset($_GET['eid'])) {
    header("Location: index.php");
    exit();
}
$eid = $_GET['eid'];

$sql = "SELECT e.text_Post, e.date_Post, e.img, u.first_name, u.last_name 
        FROM Event e
        JOIN User u ON e.sid = u.sid
        WHERE e.eid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eid);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creator Post-Event Editing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_creator_edits_post_event.css">
    <style>
        body {
            background-image: url("img/background.png");
            background-size: cover;
            justify-content: center;
            align-items: normal;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary" style="position: sticky; top: 0; z-index: 9999;">
        <div class="containerNavbar" style="display: flex; justify-content: center; align-items: center; margin-left: 10px;">
            <div class="home">
                <a href="index.php">
                    <img src="img/logo.png" alt="" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                </a>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fas fa-bell" style="font-size: 30px; cursor: pointer; color: #0b6380;"></i>
            </div>
            <div>
                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="Profile" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="container">
            <div class="card" style="  width: 1200px; height: 550px;">
                <div class="picture" style="display: flex;">
                    <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt=""
                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <div class="user-info" style="display: flex; ">
                        <div class="username" style="font-weight: bold;"><?php echo $post['first_name'] ?> <?php echo $post['last_name'] ?></div>
                        <div class="date" style="font-size: 12px; color: gray;"><?php echo $post['date_Post'] ?></div>
                    </div>
                </div>
                <div class="card-container" style="align-items: start;">
                    <img src="" class="card-img-top" alt="Card Image" id="event-img" style="height: 300px;">

                    <div class="card-details">
                        <p class="card-text"><?php echo $post['text_Post'] ?></p>
                    </div>
                </div>


            </div>
        </div>

        <script type="module">
            import {
                fetchImage
            } from "./read.js"; // ✅ นำเข้า fetchImage() จาก read.js

            let imagePath = "<?php echo $post['img'] ?>"; // 🔥 เปลี่ยนเป็น path ไฟล์ของคุณ
            fetchImage(imagePath, "event-img"); // ✅ เรียกใช้ฟังก์ชัน
        </script>
        <script src="main.js"></script>

</body>

</html>