<?php
include "db.php";
session_start();

$email = $_SESSION['user'];
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text_Post = $_POST['text_Post'];
    $date_Post = date('Y-m-d H:i:s'); // วันที่แบบ timestamp
    $maxmun = $_POST['participants'];
    $img = ""; // ตัวแปรเก็บชื่อไฟล์ที่อัปโหลด
    if (isset($_POST['img'])) {
        $img = $_POST['img']; // รับชื่อไฟล์จาก JavaScript
    }
    $sql = "INSERT INTO Event (sid, text_Post, date_Post, maxmun, img) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issis', $userData['sid'], $text_Post, $date_Post, $maxmun, $img);
    $stmt->execute();

    // หลังจากโพสต์สำเร็จ จะกลับไปที่หน้า index.php
    header("Location: index.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/post.css">
    <style>
        body {
            background-image: url('img/background.png');
            background-size: cover;
            justify-content: center;
        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary" style="position: sticky; top: 0;">
        <div class="containerNavbar" style="display: flex; justify-content: center; align-items: center; margin-left: 10px;">
            <div class="home">
                <a href="index.php">
                    <img src="img/logo.png" alt="" style="height: 50px; width: 50px;">
                </a>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="width: 1200px; height: 500px;">
            <form id="uploadForm" enctype="multipart/form-data" method="POST">
                <div class="picture" style="display: flex;">
                    <div class="profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 15px; background-color: red;"></div>
                    <div class="user-info" style="display: flex;">
                        <div class="username" style="font-weight: bold;"><?php echo ($userData['first_name']) ?> <?php echo ($userData['last_name']) ?></div>
                        <div class="date" style="font-size: 12px; color: gray;"><?= date('d M. Y') ?></div>
                    </div>

                    <div class="button" style="margin-left: 650px;">
                        <input type="number" id="participants" name="participants" min="1" max="300"
                            placeholder="Number of activity participants" required>
                        <button id="deleteFile" type="button" class="btn btn-danger">Danger</button>
                        <button type="submit" class="btn btn-success">Success</button>
                    </div>
                </div>

                <textarea class="form-control me-2" placeholder="" aria-label="" name="text_Post"
                    style="width: 800px; height: 300px; padding: 10px; border: 2px solid white; 
                outline: none; font-size: 18px; caret-color: black; color: black; 
                background-color: transparent; text-align: left; 
                line-height: 1.5; resize: none; box-sizing: border-box; overflow: auto;"
                    onfocus="this.style.boxShadow='0 0 10px rgba(255, 255, 255, 0.8)';"
                    onblur="this.style.boxShadow='none';"></textarea>

                <div class="line"></div>

                <div class="button-photo">
                    <img src="img/phpoto.png" alt="Upload Icon" style="width: 50px; cursor: pointer;" id="imageTrigger">
                    <button type="button" class="btn btn-link" id="buttonTrigger">Add Photo</button>
                    <input type="file" name="file" id="imageUpload" class="form-control mt-2" style="display: none;">
                </div>

                <!-- Input hidden สำหรับเก็บชื่อไฟล์ที่อัปโหลด -->
                <input type="hidden" name="img" id="img">

            </form>
        </div>
    </div>

    <script src="upImg.js" type="module"></script>
    <script>
        // เมื่อฟอร์มถูกส่ง
        document.getElementById("uploadForm").addEventListener("submit", function(e) {
            const fileName = localStorage.getItem("uploadedFile"); // ดึงชื่อไฟล์จาก localStorage
            if (fileName) {
                document.getElementById("img").value = fileName; // ส่งชื่อไฟล์ไปยัง input hidden ในฟอร์ม
            } else {
                alert("❌ กรุณาอัปโหลดไฟล์ก่อน!");
                e.preventDefault(); // ถ้าไม่มีไฟล์ จะไม่ส่งฟอร์ม
            }
        });
    </script>


    <script>
        document.getElementById("imageTrigger").addEventListener("click", function() {
            document.getElementById("imageUpload").click();
        });

        document.getElementById("buttonTrigger").addEventListener("click", function() {
            document.getElementById("imageUpload").click();
        });
    </script>

    <script src="main.js"></script>
</body>

</html>