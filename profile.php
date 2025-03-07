<?php
// Q user ตัวเอง
include "db.php";
session_start();

//ข้อมูลตัวเอง
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$Myresult = $stmt->get_result();
$myPro = $Myresult->fetch_assoc();

$id = $myPro['sid'];
$sql = "select * from Event where sid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$myEvert = $stmt->get_result();

//กิจกรรมที่เคยเข้าร่วม
$sql = 'select
j.eid,
e.text_Post,
e.date_Post,
e.img
FROM JoinEvent j
JOIN User u ON j.sid = u.sid
JOIN Event e ON j.eid = e.eid
WHERE j.sid = ?
AND (j.status IN (1, 2) OR (j.status = 3 AND j.name_check = 3))';
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$myJEvert = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style_profile.css">
    <!-- Font Awesome CDN -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-image: url('img/background.png');
            background-size: cover;
        }

        /* เปลี่ยนพื้นหลังปุ่ม Dropdown เป็นสีขาว และซ่อนขอบ */
        .btn-secondary {
            background-color: #ffffff !important;
            border: none !important;
            color: #000 !important;
            padding: 5px 10px;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-menu {
            background-color: #ffffff !important;
            border: none !important;

            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);/
        }

        .dropdown-item:hover {
            background-color: #f8f9fa !important;

        }

        .nav-tabs {
            border-bottom: none !important;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            padding: 10px;
            text-decoration: none;

        }

        .nav-tabs .nav-link {
            border: none !important;
            color: blue !important;
        }

        .nav-tabs .nav-link.active {
            border: none !important;
            color: green !important;
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
                <i class="fas fa-bell" style="font-size: 30px; cursor: pointer; color: #0b6380;"></i> <!-- ไอคอนกระดิ่งจาก Font Awesome -->
            </div>
            <div><!--[แก้] รูปคนเข้า -->
                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg"
                    alt="Profile" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
            </div>

        </div>
    </nav>


    <div class="container">
        <div class="card">
            <div class="picture"> <!--[แก้] รูปคนเข้า -->
                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="">
            </div>
            <div class="username">
                <?php echo ($myPro['first_name']) ?> <?php echo ($myPro['last_name']) ?>
            </div>
            <div class="line"></div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="myEventTab" href="#">my event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="joinedEventTab" href="#">joined Event</a>
                </li>
            </ul>
        </div>
    </div>

    <style>
        .text-container {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* จำกัดให้แสดง 2 บรรทัด */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <div class="cardsEvent" style="display: flex; justify-content: center; align-items: center; margin: 5px; margin-left: 50px;">
        <div class="row row-cols-1 row-cols-md-3 g-1">
            <?php if ($myEvert->num_rows > 0) {
                while ($card = $myEvert->fetch_assoc()) { ?>
                    <div class="col">
                        <div class="card" style="margin: 10px; width: 20rem; cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                            <div class="small-picture" style="display: flex; align-items: center; gap: 10px; padding:10px; justify-content: space-between;">
                                <div style="display: flex; gap: 10px;">
                                    <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="Profile Picture"
                                        style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                    <div class="user-info" style="display: flex; flex-direction: column;">
                                        <div class="small-username" style="font-weight: bold; font-size: 10px; color: rgb(55, 123, 187);">
                                            <?php echo ($myPro['first_name']) ?> <?php echo ($myPro['last_name']) ?>
                                        </div>
                                        <div class="date" style="font-weight: bold; font-size: 9px; color: rgb(55, 123, 187);">
                                            <?php echo ($card['date_Post']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" role="button" id="dropdownMenuLink-<?= $card['eid'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="img/dots_horizontal_icon_135684.png" style="width: 20px;">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink-<?= $card['eid'] ?>">
                                        <li>
                                            <a class="dropdown-item edit-button"
                                                href="creator_edits_post_event.php?eid=<?= $card['eid'] ?>">
                                                Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="event_Delete.php?eid=<?= $card['eid'] ?>">Delete</a></li>
                                    </ul>
                                </div>


                            </div>

                            <!-- คลิกที่การ์ดไปหน้า check.php -->
                            <a href="check.php?eid=<?php echo ($card['eid']) ?>" style="text-decoration: none; color: inherit;">
                                <div class="card-body" style="flex-grow: 1;">
                                    <p class="card-text">
                                        <span class="text-container" id="text-<?php echo ($card['eid']) ?>">
                                            <?= $card['text_Post'] ?>
                                        </span>
                                        <button onclick="toggleText('<?php echo ($card['eid']) ?>'); event.stopPropagation();" style="border: none; background: none; color: blue; cursor: pointer; padding: 0;">
                                            See more
                                        </button>
                                    </p>
                                </div>

                                <img src="" id="event_<?php echo ($card['eid']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            </a>
                        </div>
                    </div>

                    <script type="module">
                        import {
                            fetchImage
                        } from "./read.js"; // ✅ นำเข้า fetchImage() จาก read.js

                        let imagePath = "<?php echo $card['img'] ?>"; // 🔥 เปลี่ยนเป็น path ไฟล์ของคุณ
                        fetchImage(imagePath, "event_<?php echo ($card['eid']) ?>"); // ✅ เรียกใช้ฟังก์ชัน
                    </script>

            <?php }
            } ?>
        </div>
    </div>


    <!-- เคยเข้าร่วม -->
    <div class="joinedEvent" style="display: flex; justify-content: center; align-items: center; margin: 5px; margin-left: 50px;">
        <div class="row row-cols-1 row-cols-md-3 g-1">
            <?php if ($myJEvert->num_rows > 0) {
                while ($card = $myJEvert->fetch_assoc()) {
                    $eidCR = $card['eid'];

                    $sql = "SELECT e.eid, e.text_Post, e.date_Post, e.img, u.first_name, u.last_name
                        FROM Event e
                        JOIN User u ON e.sid = u.sid
                        WHERE eid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $eidCR);
                    $stmt->execute();
                    $EventCR = $stmt->get_result();
                    $cardCR = $EventCR->fetch_assoc();
            ?>
                    <div class="col">
                        <div class="card event-card"
                            style="margin: 10px; width: 20rem; cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; height: 100%;"
                            onclick="window.location.href='detailsJoined.php?eid=<?= urlencode($eidCR) ?>'">

                            <div class="small-picture" style="display: flex; align-items: center; gap: 10px; padding:10px;">
                                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="Profile Picture"
                                    style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                <div class="user-info" style="display: flex; flex-direction: column;">
                                    <div class="small-username" style="font-weight: bold; font-size: 10px; color: rgb(55, 123, 187);">
                                        <?= htmlspecialchars($cardCR['first_name'] . " " . $cardCR['last_name']) ?>
                                    </div>
                                    <div class="date" style="font-weight: bold; font-size: 9px; color: rgb(55, 123, 187);">
                                        <?= htmlspecialchars($card['date_Post']) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" style="flex-grow: 1;">
                                <p class="card-text">
                                    <span class="text-container" id="text-<?= htmlspecialchars($eidCR) ?>">
                                        <?= htmlspecialchars($card['text_Post']) ?>
                                    </span>
                                    <button onclick="toggleText('<?= htmlspecialchars($eidCR) ?>'); event.stopPropagation();"
                                        style="border: none; background: none; color: blue; cursor: pointer; padding: 0;">
                                        See more
                                    </button>
                                </p>
                            </div>

                            <img src="" id="event_<?php echo ($cardCR['eid']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">

                            <!-- <img src="" data-img="<?= htmlspecialchars($cardCR['img']) ?>" id="event_<?= $cardCR['eid'] ?>" class="card-img-top" alt="Card Image" style="height: 200px; object-fit: cover;"> -->
                        </div>
                    </div>
                    <script type="module">
                        import {
                            fetchImage
                        } from "./read.js"; // ✅ นำเข้า fetchImage() จาก read.js

                        let imagePath = "<?php echo $cardCR['img'] ?>"; // 🔥 เปลี่ยนเป็น path ไฟล์ของคุณ
                        fetchImage(imagePath, "event_<?php echo ($cardCR['eid']) ?>"); // ✅ เรียกใช้ฟังก์ชัน
                    </script>


            <?php }
            } ?>
        </div>
    </div>

    <script>
        // dropdown
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
                const menu = toggle.nextElementSibling; // เลือก dropdown menu ที่อยู่ถัดจาก toggle button

                toggle.addEventListener("click", function(event) {
                    event.stopPropagation(); // หยุดการทำงานของ event ปกติ

                    // เปิด/ปิด dropdown menu
                    menu.classList.toggle("show");
                });
            });

            // คลิกที่อื่น => ปิด dropdown ทั้งหมด
            document.addEventListener("click", function() {
                document.querySelectorAll(".dropdown-menu").forEach(menu => {
                    menu.classList.remove("show");
                });
            });

            // ป้องกัน dropdown ปิดเมื่อคลิกข้างใน
            document.querySelectorAll(".dropdown-menu").forEach(menu => {
                menu.addEventListener("click", function(event) {
                    event.stopPropagation();
                });
            });
        });;
    </script>

    <script>
        // สลับแท็บระหว่าง "my event" และ "joined Event" 
        document.addEventListener("DOMContentLoaded", function() {
            const myEventTab = document.getElementById("myEventTab");
            const joinedEventTab = document.getElementById("joinedEventTab");
            const cardsEvent = document.querySelector(".cardsEvent");
            const joinedEvent = document.querySelector(".joinedEvent");

            function setActiveTab(clickedTab) {
                myEventTab.classList.remove("active");
                joinedEventTab.classList.remove("active");

                if (clickedTab === "myEvent") {
                    myEventTab.classList.add("active");
                    cardsEvent.style.display = "flex";
                    joinedEvent.style.display = "none";
                } else {
                    joinedEventTab.classList.add("active");
                    joinedEvent.style.display = "flex";
                    cardsEvent.style.display = "none";
                }
            }

            myEventTab.addEventListener("click", function() {
                setActiveTab("myEvent");
            });

            joinedEventTab.addEventListener("click", function() {
                setActiveTab("joinedEvent");
            });

            // ตั้งค่าเริ่มต้นให้แสดง myEvent
            setActiveTab("myEvent");
        });
    </script>

    <script src="main.js"></script>
    <!-- Bootstrap JavaScript & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>