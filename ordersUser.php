<?php
session_start();

if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
    exit();
}

include("headerUser.php");
include("connection.php");
$id = $_SESSION["userId"];

$sql = "SELECT * FROM `orders` WHERE `uid`='$id' AND `isdelete`='0'";
$result = $conn->query($sql);
?>

<div class="itemsBody">
    <div class="ordersUser">
        <div class="header">My Orders</div>
        <table class="ordersUserTable">
            <thead>
                <tr class="ordersUsertr">
                    <th class="ordersUserth">Item Name</th>
                    <th class="ordersUserth">Item Price</th>
                    <th class="ordersUserth">Quantity</th>
                    <th class="ordersUserth">Total Bill</th>
                    <th class="ordersUserth">Date & Time</th>
                    <th class="ordersUserth">Cancel</th>
                </tr>
            </thead>
            <tbody id="ordersUserTbody">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $iid = $row["itemid"];
                        $iname = $row["itemname"];
                        $iprice = $row["itemprice"];
                        $iQuantity = $row["quantity"];
                        $date = $row['date'];
                        echo '<tr class="ordersUsertr">';
                        echo '<td class="ordersUsertd">' . $iname . '</td>';
                        echo '<td class="ordersUsertd">' . $iprice . '</td>';
                        echo '<td class="ordersUsertd">' . $iQuantity . '</td>';
                        echo '<td class="ordersUsertd">' . $row['totbill'] . '</td>';
                        echo '<td class="ordersUsertd">' . $row['date'] . '</td>';
                        echo '<td class="ordersUsertd">
                                <form action="ordersUser.php" method="post">
                                    <input type="hidden" name="order_id" value="' . $row['uid'] . '">
                                    <input class="ordersUserdelete" value="Delete" name="delete" type="submit">
                                </form>
                              </td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST["delete"])) {
    $orderId = $_POST["order_id"];

    // Retrieve the order details for updating the item quantity
    $orderDetailsSql = "SELECT * FROM `orders` WHERE `uid` = ?";
    $stmt = $conn->prepare($orderDetailsSql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderDetailsResult = $stmt->get_result();
    $orderDetails = $orderDetailsResult->fetch_assoc();
    $stmt->close();

    if ($orderDetails) {
        $iid = $orderDetails["itemid"];
        $iQuantity = $orderDetails["quantity"];

        // Start transaction
        $conn->begin_transaction();
        try {
            // Mark the order as deleted
            $updateOrderSql = "UPDATE `orders` SET `isdelete` = '1' WHERE `uid` = ?";
            $stmt = $conn->prepare($updateOrderSql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $stmt->close();

            // Update the item quantity
            $updateItemSql = "UPDATE `items` SET `quantity` = `quantity` + ? WHERE `itemid` = ?";
            $stmt = $conn->prepare($updateItemSql);
            $stmt->bind_param("ii", $iQuantity, $iid);
            $stmt->execute();
            $stmt->close();

            // Commit transaction
            $conn->commit();
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error processing your request. Please try again later.'
                });
            </script>";
        }
    }

    header("Location: ordersUser.php");
    exit();
}
?>

<?php include("foot.php"); ?>
