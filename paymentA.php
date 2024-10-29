<?php
session_start();
if (!isset($_SESSION["userName"])) {
    header("Location:index.php");
    exit();
}

include('headerAdmin.php');

include('connection.php');

if (isset($_POST["pay"])) {
    $uid = $_SESSION["userId"];
    $itemId = $_GET['itemId'];
    $itemName = $_GET['itemName'];
    $itemPrice = $_GET['itemPrice'];
    $itemQuantity = $_GET['itemQuantity'];
    $date = date('Y-m-d');
    date_default_timezone_set('Asia/Colombo');
    $time = date('H:i:s');
    $total = $itemPrice * $itemQuantity;
    $uName = $_SESSION['userName'];

    $cardNo = $_POST["cardNo"];
    $cardName = $_POST["cardname"];
    $cvv = $_POST["cvv"];

    if (!empty($cardName) && !empty($cardNo) && !empty($cvv)) {
        // Start a transaction
        $connection->begin_transaction();
        try {
            // Check available quantity
            $quantityCheckSql = $connection->prepare("SELECT `quantity` FROM `items` WHERE `itemid` = ?");
            $quantityCheckSql->bind_param("i", $itemId);
            $quantityCheckSql->execute();
            $quantityCheckSql->bind_result($availableQuantity);
            $quantityCheckSql->fetch();
            $quantityCheckSql->close();

            if ($availableQuantity >= $itemQuantity) {
                // Insert order into the database
                $ordersql = $connection->prepare("INSERT INTO `orders`(`uid`, `itemid`, `itemname`, `itemprice`, `quantity`, `totbill`, `date`, `time`) VALUES (?,?,?,?,?,?,?,?)");
                $ordersql->bind_param("iisiiiss", $uid, $itemId, $itemName, $itemPrice, $itemQuantity, $total, $date, $time);
                $ordersql->execute();
                $orderId = $ordersql->insert_id; // Get the ID of the inserted order
                $ordersql->close();

                // Update item quantity in the inventory
                $updateSql = $connection->prepare("UPDATE `items` SET `quantity` = `quantity` - ? WHERE `itemid` = ?");
                $updateSql->bind_param("ii", $itemQuantity, $itemId);
                $updateSql->execute();
                $updateSql->close();

                // Commit the transaction
                $connection->commit();

                // JavaScript function to generate PDF
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const { jsPDF } = window.jspdf;
                        function generatePDF() {
                            
                            var doc = new jsPDF();
                            doc.setFontSize(35);
                            doc.text('Invoice', 85, 30);
                            doc.setFontSize(20);
                            doc.text('Order Number: {$orderId}', 20, 60);
                            doc.setFontSize(20);
                            doc.text('Invoice Date: {$date}', 20, 70);
                            doc.setFontSize(20);
                            doc.text('Invoice Time: {$time}', 20, 80);
                            doc.setFontSize(20);
                            doc.text('Customer Name: {$uName}', 20, 90);
                            doc.setFontSize(25);
                            doc.text('Item Details', 80, 120);
                            doc.setFontSize(20);
                            doc.text('Item Name: {$itemName}', 20, 140);
                            doc.text('Price: Rs.{$itemPrice}', 20, 150);
                            doc.text('Quantity: {$itemQuantity}', 20, 160);
                            doc.text('Total Amount: Rs.{$total}', 20, 170);

                            doc.setFontSize(25);
                            doc.text('Thank you for your purchase!', 45, 250);
                            doc.save('invoice.pdf');
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful',
                            text: 'Your payment was successful! Click OK to download the invoice.',
                            showConfirmButton: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                generatePDF();
                                setTimeout(function() {
                                    window.location.href = 'itemsUser.php';
                                }, 1000); // Delay of 1 second for user to download PDF
                            }
                        });
                    });
                </script>";
            } else {
                // Rollback the transaction
                $connection->rollback();
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Unsuccessful!',
                        text: 'Insufficient stock for the requested quantity!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'itemsUser.php';
                        }
                    });
                </script>";
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $connection->rollback();
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Unsuccessful!',
                    text: 'There was an error processing your payment. Please try again later.'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'itemsUser.php';
                    }
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Unsuccessful!',
                text: 'Please Check Your Payment Details!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'itemsUser.php';
                }
            });
        </script>";
    }
}
?>

<div class="containerP">
    <div class="card-container">
        <div class="front">
            <div class="image">
                <img src="chip.png" alt="">
                <img src="visa.png" alt="">
            </div>
            <div class="card-number-box">################</div>
            <div class="flexbox">
                <div class="box">
                    <span>Card Holder</span>
                    <div class="card-holder-name">Full Name</div>
                </div>
                <div class="box">
                    <span>Expires</span>
                    <div class="expiration">
                        <span class="exp-month">mm</span>
                        <span class="exp-year">yy</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="back">
            <div class="stripe"></div>
            <div class="box">
                <span>CVV</span>
                <div class="cvv-box"></div>
                <img src="visa.png" alt="">
            </div>
        </div>
    </div>
    <form action="" method="post">
        <div class="inputBox">
            <span>Card Number</span>
            <input type="text" name="cardNo" maxlength="16" class="card-number-input">
        </div>
        <div class="inputBox">
            <span>Card Holder</span>
            <input type="text" name="cardname" class="card-holder-input">
        </div>
        <div class="flexbox">
            <div class="inputBox">
                <span>Expiration mm</span>
                <select name="month" id="" class="month-input">
                    <option value="" selected disabled>Month</option>
                    <?php
                    for ($i = 1; $i <= 12; $i++) {
                        printf('<option value="%02d">%02d</option>', $i, $i);
                    }
                    ?>
                </select>
            </div>
            <div class="inputBox">
                <span>Expiration yy</span>
                <select name="year" id="" class="year-input">
                    <option value="" selected disabled>Year</option>
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i <= $currentYear + 10; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="inputBox">
                <span>CVV</span>
                <input name="cvv" type="text" maxlength="4" class="cvv-input">
            </div>
        </div>
        <input type="submit" name="pay" value="Submit" class="submit-btn">
    </form>
</div>

<?php include('foot.php'); ?>