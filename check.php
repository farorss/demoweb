<?php
//หลังบ้าน โพส

include "db.php";
session_start();

// รับ eid จาก URL
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


$sql = 'select COUNT(*) AS count
        FROM JoinEvent
        WHERE eid = ? and status = 3';
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$sql = "select
j.sid,
u.first_name,
u.last_name
FROM JoinEvent j
JOIN User u ON j.sid = u.sid
JOIN Event e ON j.eid = e.eid
WHERE e.eid = ? and j.status = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eid);
$stmt->execute();
$result_ch = $stmt->get_result();

$sql = "select
j.sid,
u.first_name,
u.last_name
FROM JoinEvent j
JOIN User u ON j.sid = u.sid
JOIN Event e ON j.eid = e.eid
WHERE e.eid = ? and j.status = 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eid);
$stmt->execute();
$resulty = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check reques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style_check.css">
    <style>
        body {
            background-image: url("img/background.png");
            background-size: cover;
        }

        .card::-webkit-scrollbar {
            width: 10px;
            /* ขนาดความกว้างของ scrollbar */
            height: 30px;
            /* ขนาดความสูงของ scrollbar ในแนวตั้ง */
        }

        .card::-webkit-scrollbar-thumb {
            background-color: rgb(170, 170, 170);
            border-radius: 8px;
        }

        .card::-webkit-scrollbar-thumb:hover {
            background-color: rgb(118, 115, 115);
        }

        .card::-webkit-scrollbar-button {
            display: none;
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
    </nav>



    <div class="d-flex justify-content-center align-items-center vh-100" style="gap: 20px;">
        <!-- การ์ดที่ 1 ฝั่งซ้าย -->
        <div class="card me-3" style="width: 450px; gap: 20px; padding: 10px; max-height: 520px; overflow-y: auto;">
            <div class="picture">
                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="">
                <div class="user-info">
                    <div class="username">
                        <?php echo ($post['first_name']) ?> <?php echo ($post['last_name']) ?>
                        <div class="date" style="font-weight: bold; font-size: 11px; color: rgb(55, 123, 187);">
                            <?php echo ($post['date_Post']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="image">
                <img src="" class="card-img-top" alt="Card Image" id="event-img" style="width: 25rem;">
            </div>
            <div class="taxt">
                <?php echo ($post['text_Post']) ?>
            </div>
        </div>

        <!-- การ์ดที่ 2 -->
        <div class="d-flex flex-column" style="gap: 10px; padding: 10px;">
            <div class="card me-3" style="width:600px; gap: 20px; padding: 20px; max-height: 250px; overflow-y: auto; padding-right: 10px;">
                <div style="margin-right: 10px;">
                    <h1>Requested</h1>
                </div>
                <?php if ($result_ch->num_rows > 0) {
                    while ($postCh = $result_ch->fetch_assoc()) { ?>
                        <div class="small-picture">
                            <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="" style=" width: 45px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <div class="user-info">
                                <div class="username">
                                    <?php echo ($postCh['first_name']) ?> <?php echo ($postCh['last_name']) ?>
                                </div>
                            </div>
                            <div class="button" style="gap: 50px; margin-left: 190px; width: 220px;">
                                <a type="button" class="btn btn-danger" href="check_Danger.php?sid=<?php echo $postCh['sid']; ?>&eid=<?php echo $eid; ?>">Danger</a>
                                <a type="button" class="btn btn-success" href="check_Success.php?sid=<?php echo $postCh['sid']; ?>&eid=<?php echo $eid; ?>">Success</a>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>

            <!-- การ์ดที่ 3 -->
            <div class="d-flex flex-column" style="gap: 10px;">
                <div class="card me-3" style="width:600px; gap: 20px; padding: 20px; max-height: 250px; overflow-y: auto; padding-right: 10px;">
                    <div style="display: flex; align-items: center; gap: 22rem;">
                        <div>
                            <h1>Joined</h1>
                        </div>
                        <div>
                            <h1><?php echo ($row['count']) ?>/<?php echo ($post['maxmun']) ?></h1>
                        </div>
                    </div>
                    <?php if ($resulty->num_rows > 0) {
                        while ($juinNow = $resulty->fetch_assoc()) { ?>
                            <div class="small-picture">
                                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="" style=" width: 45px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <div class="user-info">
                                    <div class="username">
                                        <a href="profile_participants.php?sid=<?php echo $juinNow['sid']; ?>" style="text-decoration: none; color: inherit;">
                                            <?php echo ($juinNow['first_name']) ?> <?php echo ($juinNow['last_name']) ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        import {
            fetchImage
        } from "./read.js";

        let imagePath = "<?php echo $post['img'] ?>"; // 🔥 เปลี่ยนเป็น path ไฟล์ของคุณ
        fetchImage(imagePath, "event-img"); // ✅ เรียกใช้ฟังก์ชัน
    </script>

</body>

</html>