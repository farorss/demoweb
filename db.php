<?php

$server = "localhost";
$dbname = "projectweb";
$username = "demoWed";
$password = "1234";

$conn = new mysqli($server, $username, $password, $dbname);
$conn->set_charset("utf8");
