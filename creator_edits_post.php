<?php
include "db.php";
session_start();

if (!isset($_GET['eid'])) {
    header("Location: index.php");
    exit();
}

$eid = $_GET['eid'];

$sql = "SELECT e.eid, e.text_Post, e.date_Post, e.img, e.maxmun, u.first_name, u.last_name 
        FROM Event e
        JOIN User u ON e.sid = u.sid
        WHERE e.eid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eid);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text_Post = $_POST['text_Post'];
    $maxmun =  $_POST['participants']; // วันที่แบบ timestamp
    $img = ""; // ตัวแปรเก็บชื่อไฟล์ที่อัปโหลด
    if (isset($_POST['img'])) {
        $img = $_POST['img']; // รับชื่อไฟล์จาก JavaScript
    }
    $sql = "UPDATE Event SET text_Post=?, maxmun=?, img=? WHERE eid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssi', $text_Post, $maxmun, $img, $eid);
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
    <title>Creator Post-Event Editing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style_creator_edits_post_event.css">
    <style>
        body {
            background-image: url("img/background.png");
            background-size: cover;
            justify-content: center;
            /* จัดกึ่งกลางแนวนอน */
            align-items: normal;
            /* จัดกึ่งกลางแนวตั้ง */
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
        <div class="card" style="width: 1200px; height: 550px;">
            <form id="uploadForm" enctype="multipart/form-data" method="POST">
                <div class="picture" style="display: flex;">
                    <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt=""
                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <div class="user-info" style="display: flex;">
                        <div class="username" style="font-weight: bold;"><?php echo ($post['first_name']) ?> <?php echo ($post['last_name']) ?></div>
                        <div class="date" style="font-size: 12px; color: gray;"><?php echo ($post['date_Post']) ?></div>
                    </div>
                    <div class="button" style="margin-left: 650px;">
                        <input type="number" id="participants" name="participants" min="1" max="300"
                            placeholder="Number of activity participants" value="<?php echo ($post['maxmun']) ?>" required>
                        <button id="deleteFile" type="button" class="btn btn-danger">Danger</button>
                        <button type="submit" class="btn btn-success">Success</button>
                    </div>
                </div>

                <!-- รูปภาพที่เคยอัปโหลด -->
                <div class="card-container" style="align-items: start;">
                    <img src="" class="card-img-top" id="event-img" style="height: 300px;">
                    <div class="card-details">
                        <textarea class="form-control" name="text_Post"
                            style="width: 100%; max-width: 800px; height: 100px; padding: 10px; border: 2px solid white; 
    outline: none; font-size: 18px; caret-color: black; color: black; 
    background-color: transparent; text-align: left; 
    line-height: 1.5; resize: both; box-sizing: border-box; overflow: auto;">
    <?php echo ($post['text_Post']) ?>
</textarea>
                    </div>
                </div>

                <div class="line" style="background-color: rgb(193, 198, 202);"></div>

                <!-- ปุ่มอัปโหลดรูป -->
                <div class="button-photo">
                    <img src="img/phpoto.png" alt="Upload Icon" style="width: 50px; cursor: pointer;" id="imageTrigger">
                    <button type="button" class="btn btn-link" id="buttonTrigger">Add Photo</button>
                    <input type="file" name="file" id="imageUpload" class="form-control mt-2" style="display: none;">
                </div>

                <!-- Input hidden เก็บชื่อไฟล์ที่อัปโหลด -->
                <input type="hidden" name="img" id="img">
            </form>
        </div>
    </div>


    <script type="module">
        import {
            fetchImage
        } from "./read.js";

        let imagePath = "<?php echo $post['img'] ?>"; // 🔥 เปลี่ยนเป็น path ไฟล์ของคุณ
        fetchImage(imagePath, "event-img"); // ✅ เรียกใช้ฟังก์ชัน

        deleteImage(filePath);
    </script>

    <script src="upImg.js" type="module"></script>
    <script>
        // เมื่อฟอร์มถูกส่ง
        document.getElementById("uploadForm").addEventListener("submit", function(e) {
            const fileName = localStorage.getItem("uploadedFile"); // ดึงชื่อไฟล์จาก localStorage
            if (fileName) {
                document.getElementById("img").value = fileName; // ส่งชื่อไฟล์ไปยัง input hidden ในฟอร์ม
            } else {
                
            }
        });
    </script>


    <script>
        // เมื่อคลิกที่รูป หรือปุ่ม ให้เปิด input file
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