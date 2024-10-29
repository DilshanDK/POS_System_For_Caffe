<?php
session_start();
if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}
include("headerAdmin.php");
include("connection.php");

$date = date("Y-m-d");
$sqlTi = "SELECT COUNT('itemid') AS Ti FROM items ";
$sqlToT = "SELECT COUNT('orderid') AS ToT FROM orders WHERE `date`='$date' AND `isdelete`='0' ";
$sqlTc = "SELECT COUNT('uid') AS Tc FROM userreg ";
$sqlTo = "SELECT COUNT('orderid') AS T_o FROM orders WHERE  `isdelete`='0' ";
$rTi = mysqli_query($connection, $sqlTi);
$rToT = mysqli_query($connection, $sqlToT);
$rTc = mysqli_query($connection, $sqlTc);
$rTo = mysqli_query($connection, $sqlTo);
$rowTi = mysqli_fetch_assoc($rTi);
$rowToT = mysqli_fetch_assoc($rToT);
$rowTc = mysqli_fetch_assoc($rTc);
$rowTo = mysqli_fetch_assoc($rTo);

?>

<div class="bodyc">
    <p style="text-align: center; filter: drop-shadow(10px 15px 35px black); font-size:50px; font-weight:bold; margin:10px auto;">Dashboard</p>
    <div class="process">

        <div class="size">
            <img src="item.gif" alt="" style=" width:200px;">
            <p> Total Items <br> <span style="font-size: 40px; padding-top: 10px;"><?php echo $rowTi["Ti"]; ?></span></p>
        </div>
        <div class="size">
            <img src="today.gif" alt="" style=" width:200px;">
            <p>Today Total Orders <br> <span style="font-size: 40px; padding-top: 10px;"><?php echo $rowToT["ToT"]; ?></span></p>
        </div>
        <div class="size">
            <img src="customer.gif" alt="" style="  border-radius: 10px; width:200px;">
            <p>Total Customers <br><span style="font-size: 40px; padding-top: 10px;"><?php echo $rowTc["Tc"]; ?></span></p>
        </div>
        <div class="size">
            <img src="orders.gif" alt="" style="  border-radius: 10px; width:200px;">
            <p>Total orders <br><span style="font-size: 40px; padding-top: 10px;"><?php echo $rowTo["T_o"]; ?></span></p>
        </div>

    </div>
</div>
<?php include_once("foot.php"); ?>