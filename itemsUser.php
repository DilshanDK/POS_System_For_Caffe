<?php
session_start();
if (!isset($_SESSION["userName"])) {
    header("Location:index.php");
    exit();
}

include("headerUser.php");
include("connection.php");

if (isset($_POST['inputData'])) {
    $inputData = $_POST['inputData'];
    $sqlS = "SELECT * FROM items WHERE (`name` LIKE ? OR `price` LIKE ?) AND isdelete = '0'";
    $stmt = $connection->prepare($sqlS);
    $search_param = "%$inputData%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $connection->query("SELECT * FROM items WHERE isdelete = '0'");
}

if (isset($_POST["buy"])) {
    header("Location: payment.php?itemId=" . $_POST['itemId'] . "&itemQuantity=" . $_POST['Iquantity']. "&itemName=" . $_POST['itemName']. "&itemPrice=" . $_POST['itemPrice']);
    exit();
}

if (isset($_POST["cart"])) {
    $itemId = $_POST["itemId"];
    $itemName = $_POST["itemName"];
    $itemPrice = $_POST["itemPrice"];
    $itemQuantity = $_POST["Iquantity"];
    $total = $itemPrice * $itemQuantity;
    $userId = $_SESSION["userId"];

    $cartItem = array(
        "id" => $itemId,
        "name" => $itemName,
        "price" => $itemPrice,
        "quantity" => $itemQuantity,
        "total" => $total
    );

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }

    array_push($_SESSION["cart"], $cartItem);

    $stmt = $connection->prepare("INSERT INTO cart (`name`, `price`, `quantity`, `total`, `userId`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiii", $itemName, $itemPrice, $itemQuantity, $total, $userId);
    $stmt->execute();
    $stmt->close();

    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Item added to cart successfully!'
        });
    </script>";
}
?>


<div class="itemsBody">
    <div id="output"></div>
    <div class="itemSerach">
        <form id="myForm" method="post">
            <input id="inputData" type="text" placeholder="Search..." class="searchBar" name="inputData">
        </form>
    </div>
    <div class="itemdiv">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
               <div class='itemMenu'>
               <img src='{$row['itemid']}.jpg' class='itemImg'>
               <form action='' method='post'>
                   <div class='itemDecP'>
                       <p class='Iname' id='Iname'>{$row['name']}</p>
                       <p class='Iprice' id='Iprice'>Rs. {$row['price']}</p>
                   </div>
                   <input type='hidden' name='itemId' value='{$row['itemid']}'>
                   <input type='hidden' name='itemName' value='{$row['name']}'>
                   <input type='hidden' name='itemPrice' value='{$row['price']}'>
                   <input type='submit' class='buy' value='Buy Now' name='buy'></input>
                   <div style='display: flex; padding: 3px 28px;width:380px;'>
                       <input name='Iquantity' class='quantity' type='number' min='1' max='{$row['quantity']}' value='1'></input>
                       <input type='submit' class='cart' value='Add to cart' name='cart'></input>
                   </div>
               </form>
           </div>";
            }
        }
        ?>
    </div>
</div>

<?php include("foot.php"); ?>
