<?php
session_start();
include("connect.php");

$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

$check = mysqli_query($connect, "SELECT mobile,password,role FROM user WHERE mobile='$mobile' AND password='$password' AND role='$role'");
if(mysqli_num_rows($check) > 0) {
    echo '<script>alert("yes");</script>';
    $userdata = mysqli_fetch_array($check);
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;

    echo '<script>window.location="../phpfiles/dashboard.php";</script>';
} else {
    echo '<script>alert("Invalid credentials or user not found!");window.location="../register.html";</script>';
}

