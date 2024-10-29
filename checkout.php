<?php
session_start();

// Redirect if invoice data not set
// if (!isset($_SESSION['invoice'])) {
//     header("Location: index.php");
//     exit();
// }

include('headerAdmin.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="process_checkout.php" method="post">
            <div class="input-group">
                <label for="customerCash">Customer Cash</label>
                <input type="number" id="customerCash" name="customerCash" required>
            </div>
            <div class="input-group">
                <label for="balance">Balance</label>
                <input type="text" id="balance" name="balance" readonly>
            </div>
            <!-- Display invoice details -->
            <div class="invoice-details">
                <h2>Invoice Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price ($)</th>
                            <th>Total Price ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['invoice'] as $item): ?>
                            <tr>
                                <td><?php echo $item['description']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['unitPrice']; ?></td>
                                <td><?php echo $item['totalPrice']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit">Process Checkout</button>
        </form>
    </div>
</body>
</html>

<?php
include('foot.php');
?>
