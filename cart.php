<?php
session_start();
if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}


include("headerUser.php");
include("connection.php");

$userId = $_SESSION["userId"];
$sql = "SELECT * FROM `cart` WHERE userId = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_POST['delete'])) {
    $deleteId = $_POST['deleteId'];
    // Perform deletion query
    $stmt = $connection->prepare("DELETE FROM cart WHERE cartId = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();

    // Refresh the page after deletion
    header("Location: cart.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your Cart</title>
    <style>
        h1 {
            text-align: center;
            color: #444;
        }

        /* New CSS for auto-scroll and centering */
        .cart-container {
            width: 1300px;
            height: 400px;
            overflow-y: auto;
            margin: 30px auto;
            display: flex;
            /* align-items: center;
            justify-content: center; */
            position: sticky;
            top: -120px;
        }

        /* End of new CSS */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
            position: sticky;
            top: 0px;
            height: 20px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 8px 40px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            position: sticky;
            bottom: -200px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div style="display: block; margin: 20px auto;">
        <h1>Your Cart</h1>

        <!-- New div container for auto-scroll and centering -->
        <div class="cart-container">
            <table>
                <tr>

                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    $totalAmount = 0;
                    while ($row = $result->fetch_assoc()) {
                        $totalAmount += $row["total"];
                        echo "<tr>
                        <td>{$row["name"]}</td>
                        <td>Rs. {$row["price"]}</td>
                        <td>{$row["quantity"]}</td>
                        <td>Rs. {$row["total"]}</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='deleteId' value='{$row["cartId"]}'>
                                <button type='submit' class='delete-btn' name='delete'>Delete</button>
                            </form>
                        </td>
                      </tr>";
                    }
                    echo "<tr>
                    <td colspan='3' style='text-align:right; font-weight:bold;'>Total Amount</td>
                    <td style='position: sticky; top:100px;'>Rs. {$totalAmount}</td>
                    <td>
                        <form method='post' action='payment.php'>
                            <button type='submit' class='checkout-btn'>Checkout</button>
                        </form>
                    </td>
                  </tr>";
                } else {
                    echo "<tr><td colspan='5' class='no-data'>Your cart is empty</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>


</body>

</html>
<?php include("foot.php"); ?>