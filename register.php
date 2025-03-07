<?php
//เสร็จแล้ว
include "db.php";
session_start();
    //สมัคร insert user
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $sex = $_POST['sex'];
        $date_of_birth = $_POST['date_of_birth'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // เข้ารหัสรหัสผ่าน
    

        if ($_POST['password'] != $_POST['password_Confirm']) {
            die("Connection failed");
        }
    
        // เตรียม SQL statement
        $sql = "INSERT INTO User (first_name, last_name, sex, date_of_birth, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisss", $first_name, $last_name, $sex, $date_of_birth, $email, $password);
        $stmt->execute();

        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .form-control {
            width: 300px;
            font-size: 16px;
        }

        body {
            background-image: url("img/login_register.png");
            background-size: cover;
            /* ทำให้รูปครอบคลุมพื้นที่ทั้งหมด */
        }
    </style>
</head>

<body>
    <form action="register.php" method="POST">
        <div class="BKlogin" style="width: 900px; padding: 20px; max-height: 550px;">
            <div>
                <h1 class="textLOGIN">REGISTER</h1>
            </div>

            <div class="mb-3" style="margin-right: 0;">
                <div class="col-12">
                    <select class="form-select" aria-label="Default select example" name="sex">
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
                <div class="col-md-6">
                    <input type="date" class="form-control" id="birthdate" lang="en" name="date_of_birth" required>
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <div class="col-md-6">
                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_Confirm" required>
                </div>
            </div>

            <div class="form-check mb-5">
                <input class="form-check-input" type="checkbox" required>
                <label class="form-check-label  fontt">I do accept the terms and conditions of your site</label>
            </div>
            <div class="button">
                <button type="submit" class="btn btn-primary">SIGN UP</button>
            </div>
        </div>
    </form>
    
</body>

</html>