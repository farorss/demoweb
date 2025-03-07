<?php
//เสร็จ
include "db.php";
session_start();

$error = ""; // ตัวแปรเก็บข้อความผิดพลาด

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // เปลี่ยนจาก $username เป็น $email
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
   
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน (ควรเข้ารหัสในฐานข้อมูล)
        //if (password_verify($password, $row['password'])) {
        if ($password === $row['password']) {
            $_SESSION['user'] = $row['email']; // ใช้ค่าจากฐานข้อมูล
            $_SESSION['userid'] = $row['sid']; // ใช้ค่าจากฐานข้อมูล
            header("Location: index.php");
            exit();
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "ไม่พบผู้ใช้งานนี้";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('img/login_register.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
    </style>
</head>

<body>

    <form action="login.php" method="POST">
        <div class="BKlogin" style="width: 900px; padding: 20px; max-height: 550px;">
            <div>
                <h1 class="textLOGIN">SIGN IN</h1>
            </div>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <input type="text" class="form-control bkUser" name="email" placeholder="User name" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control bkUser" name="password" placeholder="User Password" required>
            </div>

            <div class="form-check mb-3">
                <label class="form-check-label fontt">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary">SIGN IN</button>
            <div class="text-center mt-3">
                <a href="register.php" class="link-light">SIGN UP</a>
            </div>
        </div>
    </form>

</body>

</html>
