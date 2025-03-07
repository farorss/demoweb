<?php
//Qตัวเองส่วนหัว และ คนอื่นโพส

include "db.php";
session_start();
/*
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
*/


$sql = "select e.eid, e.text_Post, e.date_Post, u.first_name, u.last_name
            FROM Event e
            JOIN User u ON e.sid = u.sid
            order by date_Post desc";
$Event_result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('img/background.png');
            background-size: cover;
        }

        .text-container {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* จำกัดให้แสดง 2 บรรทัด */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .BkpostUser {
            background: #fff;
            width: 600px;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-container img {
            height: 50px;
            width: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .imgpost img {
            width: 100%;
            border-radius: 10px;
            margin-top: 10px;
        }

        .button-photo .btn {
            color: green;
            /* สีเริ่มต้น */
            text-decoration: none;
            /* ลบเส้นใต้เริ่มต้น */
            font-weight: bold;
            padding: 10px;
            border: none;
            background: none;
            cursor: pointer;
        }

        .button-photo .btn:focus,
        .button-photo .btn:active {
            color: green;
            text-decoration: underline;
            outline: none;
            /* เอาเส้นขอบออกเวลาโฟกัส */
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
            <!-- เปรียบเทียบข้อมูล -->
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative me-3">
                <i class="fas fa-bell" style="font-size: 30px; cursor: pointer; color: #0b6380;"></i>
            </div>
            <div> <!--[แก้] รูปคนเข้า -->
                <a href="profile.php">
                    <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="Profile" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-right: 20px;">
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="display: flex; align-items: center;">
        <div class="card" onclick="window.location.href='posts.php'" style="cursor: pointer; margin: 30px; padding: 20px; width: 90%; height: 250px; border-radius: 25px; display: flex; flex-direction: column; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px; width: 100%; justify-content: center; margin-top: 20px;">
                <div class="profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 15px; background-color: red; "></div>
                <input class="form-control" type="text" value="   Share your activities..." aria-label="readonly input example" style="border-radius: 50px; width: 80%; max-width: 900px; height: 60px;" readonly>
            </div>
            <div class="line" style="width: 750px; height: 3px; background-color: rgb(193, 198, 202); border-radius: 3px; margin: 30px;"></div>
            <div class="button-photo">
                <img src="img/phpoto.png" alt="" style="width: 50px;">
                <button type="button" class="btn btn-link">add photo</button>
            </div>
        </div>
    </div>


    <!-- ส่วนแสดง cardsEvent -->

    <div class="cardsEvent" style="display: flex; justify-content: center; align-items: center; margin: 5px; border-radius: 50px; width: 100%;">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 gx-0 gy-0">
                <?php if ($Event_result->num_rows > 0) {
                    while ($post = $Event_result->fetch_assoc()) { ?>
                        <div class="col" style="padding: 0; margin: 0; display: flex; justify-content: center;">
                            <div class="card" style="margin: 5px; width: 28rem; cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; height: 90%; border-radius: 35px;">
                                <div class="small-picture" style="display: flex; align-items: center; gap: 10px; padding:10px;">
                                    <div class="profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 15px; background-color: red; "></div>
                                    <div class="user-info" style="display: flex; flex-direction: column;">
                                        <div class="small-username" style="font-weight: bold; font-size: 10px; color: rgb(55, 123, 187); margin-right: 200px;">
                                            <?php echo ($post['first_name']) ?> <?php echo ($post['last_name']) ?> <!-- ชื่อคนทำ -->
                                        </div>
                                        <div class="date" style="font-weight: bold; font-size: 9px; color: rgb(55, 123, 187);">
                                            <?php echo ($post['date_Post']) ?>
                                        </div>
                                    </div>

                                    <!-- ปุ่มขอเข้าร่วมกิจกรรม -->
                                    <a href="joinEvent.php?eid=<?php echo ($post['eid']) ?>">
                                        <button onclick="joinEvent()" style="border: none; background: none; padding: 0; cursor: pointer;">
                                            <img src="img/13.png" alt="button image" style="width: 35px; height: 35px; object-fit: cover;">
                                        </button></a>
                                </div>

                                <div class="card-body" style="flex-grow: 1;">
                                    <p class="card-text">
                                        <span class="text-container" id="text-<?php echo ($post['eid']) ?>">
                                            <?php echo ($post['text_Post']) ?> <!-- ข้อความ -->
                                        </span>
                                        <button onclick="toggleText('<?php echo ($post['eid']) ?>')" style="border: none; background: none; color: blue; cursor: pointer; padding: 0;">
                                            See more
                                        </button>
                                    </p>
                                </div>

                                <!-- รูป -->
                                <img id="event-img-<?php echo ($post['eid']) ?>" class="card-img-top" alt="Card Image" style="height: 200px; object-fit: cover;">
                                <script>
                                    window.onload = function() {
                                        fetchImage('<?php echo $post['img']; ?>', 'event-img-<?php echo ($post['eid']) ?>');
                                    };
                                </script>


                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>

        <script>
            function toggleText(index) {
                let textContainer = document.getElementById('text-' + index);
                if (textContainer.style.whiteSpace === 'nowrap') {
                    textContainer.style.whiteSpace = 'normal';
                } else {
                    textContainer.style.whiteSpace = 'nowrap';
                }
            }

            function joinEvent() {
                alert("คุณได้ส่งคำขอเข้าร่วมกิจกรรม");
            }
        </script>


        <script src="read.js" type="module"></script>
        <script src="main.js"></script>


    </div>
</body>

</html>