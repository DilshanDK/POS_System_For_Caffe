<?php

include("connection.php");

if (isset($_POST["login"])) {

    // echo"<script>alert('hi');</script>";

    $name = trim(($_POST["uname"]));
    $pass = trim(($_POST["logpass"]));
    // echo"".$name."".$pass."".$check;

    if (!empty($name) && !empty($pass)) {

        if (isset($_POST["isadmin"]) && $_POST["isadmin"] === 'admin') {

            $sql = "SELECT * FROM `adminreg` WHERE `uName`='$name' AND `password`='$pass'";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_array($result);

            if (mysqli_num_rows($result) > 0) {

                session_start();
                $_SESSION["userName"] = $row["uName"];
                header("Location:home.php");
            } else {
                echo "<script>
                    alert('invalid admin user name or password');</script>";
            }
        } else {

            $sql = "SELECT * FROM `userreg` WHERE `name`='$name' OR `email`='$name'";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                if (password_verify($pass, $row["pass"])) {
                    session_start();
                    $_SESSION["userName"] = $row["name"];
                    $_SESSION["userId"] = $row["uid"];
                    header("Location:itemsUser.php");
                } else {
                    echo "<script>alert('invalid User user name or password');</script>";
                }
            }
        }
    } else {
        // echo "<script>alert('fill Login details');</script>";
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your order submided!.'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    </script>";
    }
}


if (isset($_POST["register"])) {


    $name = trim(($_POST["name"]));
    $email = trim(($_POST["email"]));
    $address = trim(($_POST["address"]));
    $phone = trim(($_POST["phone"]));
    $pass = trim(($_POST["pass"]));
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $repass = trim(($_POST["repass"]));


    if ((empty($name) || empty($email)  || empty($address) || empty($phone) || empty($pass) || empty($repass)) && ($pass==$repass)) {


        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Success!',
            text: 'Your order submided!.'
        }).then((result) => {
            if (result.isConfirmed) {
                alert(Registration UnSuccess! Fill Correct Details);
                window.location.href = 'index.php';
            }
        });
    </script>";
    } else {
        $sql = "INSERT INTO `userreg`(`name`, `email`,`address`, `phoneNo`, `pass`) VALUES ('$name','$email','$address','$phone','$hash')";
        $rs = mysqli_query($connection, $sql);
        echo"<script>alert(Registration Success!)</script>";
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your order submided!.'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    </script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandiyan Art Recidence</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body onload="log()">
    <div class="hero">
        <div class="container">
            <img src="logo.jpg" style="border: 1px solid black; width:80px; margin-left: 50px;border-radius: 5px;padding: 1px;">
            <p style="font-size: x-large; font-weight:bolder; margin: 20px 40px;">Kandiyan Art Recidence</p>
        </div>
        <div class="fom" id="frm">
            <div class="btnbox">
                <button id="logfrm" onclick="log()">Login</button>
                <button id="regfrm" onclick="reg()">Register</button>
            </div>

            <form action="index.php" method="post" class="input-g" id="log">
                <p id="success">Registration Successful!</p>
                <input class="in" type="text" name="uname" placeholder="Enter Name">
                <input class="in" type="password" name="logpass" placeholder="Enter Password">
                <label>Admin</label>
                <input class="check" type="checkbox" value="admin" name="isadmin" />
                <input class="frmbtn" name="login" type="submit" value="Login" onclick="dislog()"></input>
            </form>


            <form action="index.php" method="post" class="input-g" id="reg">
                <input class="in" type="text" name="name" placeholder="Enter Name">
                <input class="in" type="email" name="email" placeholder="Enter Email">
                <input class="in" type="text" name="address" placeholder="Enter Address">
                <input class="in" type="text" maxlength="10" name="phone" placeholder="Enter Phone No.">
                <input class="in" type="password" minlength="6" maxlength="12" name="pass" placeholder="Enter Password">
                <input class="in" type="password" minlength="6" maxlength="12" name="repass" placeholder="Confirm Password">
                <input type="submit" class="frmbtn" name="register" value="Register"></input>
            </form>

        </div>
    </div>
    <div class="foot"></div>
    </div>

    <script src="index.js"></script>
</body>

</html>