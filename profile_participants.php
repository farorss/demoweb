<?php
// Q user คนอื่น

include "db.php";
session_start();



if (!isset($_GET['sid'])) {
    header("Location: index.php");
    exit();
}
//ข้อมูล user
$sid = $_GET['sid'];
$sql = "SELECT 
                first_name, 
                last_name, 
                CASE 
                    WHEN sex = 1 THEN 'man' 
                    WHEN sex = 2 THEN 'woman' 
                    ELSE NULL 
                END AS sex,
                date_of_birth 
            FROM User WHERE sid = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sid);
$stmt->execute();
$Usedata = $stmt->get_result();
$UserById = $Usedata->fetch_assoc();

//กิจกรรมที่เคยเข้าร่วม
$sql = "select eid
FROM JoinEvent
WHERE sid = ? and status = 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sid);
$stmt->execute();
$resulty = $stmt->get_result();
$CreEID = $resulty->fetch_assoc();

$eidCR = $CreEID['eid'];
$sql = "select e.text_Post, e.date_Post, u.first_name, u.last_name
FROM Event e
JOIN User u ON e.sid = u.sid
WHERE eid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eidCR);
$stmt->execute();
$result_Event = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style_profile_participants.css">
    <style>
        body {
            background-image: url("img/background.png");
            background-size: cover;

        }
    </style>
</head>

<body>
    <nav class="navbar bg-body-tertiary" style="position: sticky; top: 0; z-index: 9999;">
        <div class="containerNavbar" style="display: flex; justify-content: center; align-items: center; margin-left: 10px;">
            <div class="home">
                <a href="index.php">
                <img src="img/logo.png"  alt="" style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                </a>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>



    <div class="container">
        <div class="card">
            <div class="picture">
                <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="">
            </div>
            <div class="username">
                <?php echo ($UserById['first_name']) ?> <?php echo ($UserById['last_name']) ?>
            </div>
            <div class="sex-birthda">
                <?php echo ($UserById['sex']) ?> | <?php echo ($UserById['date_of_birth']) ?>
            </div>
            <div class="line"></div>
            <div class="event">
                <p>joined Event</p>
            </div>
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

    <div class="cardsEvent" style="display: flex; justify-content: center; align-items: center; margin: 2px; ">
        <div class="row row-cols-1 row-cols-md-3 g-1">
            <?php if ($result_Event->num_rows > 0) {
                while ($juin = $result_Event->fetch_assoc()) { ?>
                    <div class="col">
                        <a href="" style="text-decoration: none; color: inherit;">

                            <div class="card" style="width: 23rem; cursor: pointer; display: flex; flex-direction: column; justify-content: space-between; height: 90%;">
                                <div class="small-picture" style="display: flex; align-items: center; gap: 10px; padding:10px;">
                                    <img src="https://i.pinimg.com/736x/a4/2a/d1/a42ad18430800eb2e41484cc7e30459a.jpg" alt="Profile Picture"
                                        style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                    <div class="user-info" style="display: flex; flex-direction: column;">
                                        <div class="small-username" style="font-weight: bold; font-size: 10px; color: rgb(55, 123, 187);">
                                        <?php echo ($juin['first_name']) ?> <?php echo ($juin['last_name']) ?>
                                        </div>
                                        <div class="date" style="font-weight: bold; font-size: 9px; color: rgb(55, 123, 187);">
                                        <?= $juin['date_Post'] ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body" style="flex-grow: 1;">
                                    <p class="card-text">
                                        <span class="text-container" id="text-<?= $index ?>">
                                            <?= $juin['text_Post'] ?>
                                        </span>
                                        <button onclick="toggleText('<?= $index ?>')" style="border: none; background: none; color: blue; cursor: pointer; padding: 0;">
                                            See more
                                        </button>
                                    </p>
                                </div>

                                <img src="<?= $card['image'] ?>" class="card-img-top" alt="Card Image" style="height: 200px; object-fit: cover;">

                            </div>
                        </a>
                    </div>
            <?php }
            } ?>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>