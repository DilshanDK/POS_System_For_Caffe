<?php 

$connection = mysqli_connect("localhost","root","","possystem");
$conn = new mysqli("localhost","root","","possystem");

if (mysqli_connect_errno()) {
    die("Connection Error". mysqli_connect_error());
}
