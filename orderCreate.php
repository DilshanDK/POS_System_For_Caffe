<?php


session_start();
if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}

include("headerUser.php");
include("connection.php");

$sql = "SELECT * FROM `items`";
$rs = mysqli_query($connection, $sql);



if (isset($_POST["insertOrder"])) {
    $uid = trim($_SESSION["userId"]);
    $itemN = trim($_POST["drop"]);
    $s = "SELECT `itemid` FROM `items` where `name`='$itemN'";
    $r = mysqli_query($connection, $s);
    $row = mysqli_fetch_array($r);
    $itemid = $row["itemid"];
    $iprice = trim($_POST["iprice"]);
    $iquantity = trim($_POST["iquantity"]);
    date_default_timezone_set('Asia/Colombo');
    $date = date("Y-m-d");
    $time = date(" H:i:s");
    // echo $uid . " " . $item . " " . $iprice . " " . $iquantity . " " . $date;

    if (!empty($itemN) && !empty($iprice) && !empty($iquantity)) {
        $ordersql = "INSERT INTO `orders`(`uid`,`itemid`,`itemname`, `itemprice`,`quantity`,`totbill`,`date`,`time`) VALUES ('$uid','$itemid','$itemN','$iprice','$iquantity',($iprice*$iquantity),'$date','$time')";
        $result = mysqli_query($connection, $ordersql);
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Your order submided!.'
        });
    </script>";
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Select Item!',
            text: 'Your order not confirmed.'
        });</script>";
    }
}




?>
<div class="orderCreate">
    <form action="orderCreate.php" method="post">
        <div>
            <label>Items</label>
            <select id="dropdownId" name="drop" style="width: 200px; border-radius: 10px; padding: 5px 10px;">
                <option value="">Select item</option>
                <?php
                while ($row = mysqli_fetch_array($rs)) {
                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                } ?>
            </select>
        </div>
        <div>
            <label>Price</label>
            <input type="text" name="iprice">
        </div>
        <div>
            <label>Quantity</label>
            <input type="text" name="iquantity">
        </div>
        <button type="submit" name="insertOrder">Insert</button>
    </form>
</div>

<div class="alert">
    <div class="icon">
        <i id="icon" class="fa-regular fa-circle-check"></i>
    </div>
    <div class="title">
        <h1>Success!</h1>
    </div>
    <div class="desctiption">Your Registration Successful</div>
    <button class="hide" id="hide" onclick="">OK</button>
</div>


<?php
include("foot.php");
?>