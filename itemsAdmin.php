<?php
session_start();
if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}

include("headerAdmin.php");
include("connection.php");

$sql = "SELECT * FROM `items` where `isdelete`='0'";
$result = mysqli_query($connection, $sql);

// Check if form is submitted
if (isset($_POST["insert"])) {
    // Retrieve form data
    $iname = trim($_POST["iname"]);
    $iprice = trim($_POST["iprice"]);
    $iquantity = trim($_POST["iquantity"]);

    // File upload handling
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_error = $_FILES['image']['error'];

    // Check if file is uploaded successfully
    if ($file_error === 0) {
        // Read image data
        $file_data = file_get_contents($file_tmp);
        $file_data = mysqli_real_escape_string($connection, $file_data);

        // Insert data into database
        $isql = "INSERT INTO `items`(`name`, `price`, `quantity`, `img`) VALUES ('$iname','$iprice','$iquantity','$file_data')";
        $rs = mysqli_query($connection, $isql);
        if ($rs) {
            $seconds = 1;
            header("refresh: $seconds; url=" . $_SERVER['PHP_SELF']);
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your Item has been added successfully!'
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to add the item!'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                text: 'Please upload a valid image file!'
            });
        </script>";
    }
}


?>

<div style="display:flex; margin: 40px auto;">
    <div class="iteminsert">
        <h1 style="text-align: center; margin: 30px;"> Item Manager</h1>
        <form action="itemsAdmin.php" method="post" enctype="multipart/form-data" style="display: block;">
            <table class="itemInsertAdminTable">
                <tr>
                    <td class="insertDatalabel"> <label for="">Name</label></td>
                    <td class="insertData"><input type="text" name="iname" required></td>
                </tr>
                <tr style="padding: 0;">
                    <td class="insertDatalabel"><label for="">Price</label></td>
                    <td class="insertData"><input type="text" name="iprice" required></td>
                </tr>
                <tr>
                    <td class="insertDatalabel"><label for="">Quantity</label></td>
                    <td class="insertData"><input type="text" name="iquantity" required></td>
                </tr>
                <tr>
                    <td class="insertDatalabel"><label for="">Image</label></td>
                    <td class="insertData"><input type="file" name="image" required></td>
                </tr>
                <tr style="text-align: center;">
                    <td colspan="2"><input type="submit" class="insertItem" name="insert" value="Insert"></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="itemsAdmin">
        <table class="itemsAdminTable">
            <tr>
                <th class="itemAdminth">Item ID</th>
                <th class="itemAdminth">Item Name</th>
                <th class="itemAdminth">Item Price</th>
                <th class="itemAdminth">Quantity</th>
            </tr>
            <?php
            // Display items from the database
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td class="itemAdmintd"> <?php echo $row["itemid"]; ?></td>
                    <td class="itemAdmintd"> <?php echo $row["name"]; ?></td>
                    <td class="itemAdmintd"> <?php echo $row["price"]; ?></td>
                    <td class="itemAdmintd"> <?php echo $row["quantity"]; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php
include("foot.php");
?>