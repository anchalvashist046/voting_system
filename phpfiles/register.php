<?php
include("connect.php");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$age=$_POST['age'];
$password = $_POST['password'];
$address = $_POST['address'];
$role = $_POST['role'];

if ($age < 18) {
    echo '<script>alert("You must be at least 18 years old to register.");
          window.location="../register.html";
          </script>';
    exit;
}


// Check if password and confirmed password match
if ($_POST['password'] != $_POST['cpassword']) {
    echo '<script>alert("Password and confirmed password do not match");
          window.location="../register.html";
          </script>';
    exit;
}

// Hash the password
//$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the user into the database
$insert = mysqli_query($connect, "INSERT INTO user (name, mobile, age,password, address, role, status, vote) VALUES ('$name', '$mobile','$age' ,'$password', '$address', '$role', 0, 0)");

if ($insert) {
    echo '<script>alert("Registration Successful!");
          window.location="../login.html";
          </script>';
} else {
    echo '<script>alert("Some error occurred!");
          window.location="../register.html";
          </script>';
}


