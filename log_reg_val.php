<?php

include("connection.php");

if (isset($_POST["log"])) {

    // echo"<script>alert('hi');</script>";

    $name = trim(($_POST["uname"]));
    $pass = trim(($_POST["logpass"]));
    // echo"".$name."".$pass."".$check;

    if (isset($_POST["isadmin"]) && $_POST["isadmin"] === 'admin') {

        $sql = "SELECT * FROM `adminreg` WHERE `uName`='$name' AND `password`='$pass'";
        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result);

        if (mysqli_num_rows($result) > 0) {

            session_start();
            $_SESSION["userName"] = $row["uName"];
            header("Location:home.php");
        } else {
            echo "erro admin";
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
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your data has been submitted successfully.'
                });
            </script>
            ";
            }
        }
    }
}


if (isset($_POST["reg"])) {

    // echo"<script>alert('hi');</script>";

    $name = trim(($_POST["name"]));
    $email = trim(($_POST["email"]));
    $address = trim(($_POST["address"]));
    $phone = trim(($_POST["phone"]));
    $pass = trim(($_POST["pass"]));
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $repass = trim(($_POST["repass"]));

    // echo"".$name."".$email."".$pass;

    if (empty($name) || empty($email)  || empty($address) || empty($phone) || empty($pass) || empty($repass)) {

        
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Registration Fail',
            text: 'Check Your Details And Try Again!'
        });
    </script>";
    header("location:index.php");
    } else {
        $sql = "INSERT INTO `userreg`(`name`, `email`,`address`, `phoneNo`, `pass`) VALUES ('$name','$email','$address','$phone','$hash')";
        $rs = mysqli_query($connection, $sql);
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your data has been submitted successfully.'
        });
        </script>";
        header("location:index.php");
    }
}
