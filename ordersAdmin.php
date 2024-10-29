<?php

session_start();
if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}

include("headerAdmin.php");
include("connection.php");

$search = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM `orders` WHERE (`orderid` LIKE ? OR `itemname` LIKE ? OR `itemprice` LIKE ? OR `quantity` LIKE ? OR `totbill` LIKE ? OR `date` LIKE ? OR `time` LIKE ?) AND `isdelete`='0' ORDER BY CASE WHEN `status` = 'Not Delivered' THEN 1 ELSE 2 END, `status` DESC";
$stmt = $connection->prepare($sql);
$search_param = "$search%";
$stmt->bind_param("sssssss", $search_param, $search_param, $search_param, $search_param, $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <style>
        .customersAdmin {
            margin: 20px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 1400px;
            background-color: #ffffff;
            outline: 1px solid #0056b3;
            overflow-y: scroll;
        }

        h1 {
            text-align: center;
            color: #444;
            margin: 0;
            padding: 20px 0;
        }

        .searchInput {
            width: 500px;
            height: 20px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 16px;
            margin: 10px auto;
            display: block;
            outline: 1px solid #0056b3;
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #fff;
        }

        .table-container {
            height: 320px;
            overflow-y: auto;
        }

        .customersAdminTable {
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
            background-color: #00ffc8;
            color: #000000;
            position: sticky;
            top: 0;
            z-index: 500;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .statusButton {
            padding: 8px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .statusButton.yes {
            background-color: gray;
            color: white;
            cursor: not-allowed;
        }

        .statusButton.no {
            background-color: green;
            color: white;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .statusButton.no:hover {
            transform: scale(1.1);
            background-color: darkgreen;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                var search = $(this).val();
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $('#customersTableBody').html($(data).find('#customersTableBody').html());
                    }
                });
            });

            $(document).on('click', '.statusButton.no', function() {
                var button = $(this);
                var orderId = button.data('id');

                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        update_status: true,
                        orderid: orderId
                    },
                    success: function(response) {
                        if (response == 'success') {
                            location.reload();
                        } else {
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div style="display: block; margin:10px auto;">
        <h1>Orders</h1>
        <input type="text" id="searchInput" placeholder="Search Orders..." class="searchInput">
        <div class="customersAdmin">
            <div class="table-container">
                <table class="customersAdminTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Bill</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        <?php
                        if (isset($_POST['update_status']) && isset($_POST['orderid'])) {
                            $orderid = $_POST['orderid'];
                            $update_sql = "UPDATE `orders` SET `status` = 'Delivered' WHERE `orderid` = ?";
                            $stmt = $connection->prepare($update_sql);
                            $stmt->bind_param("i", $orderid);

                            if ($stmt->execute()) {
                                echo 'success';
                                exit();
                            } else {
                                echo 'error';
                                exit();
                            }
                        }

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $status = $row['status'] == 'Delivered' ? 'Delivered' : 'Not Delivered ';
                                $buttonText = $status == 'Delivered' ? 'Delivered' : 'Not Delivered ';
                                $buttonClass = $status == 'Delivered' ? 'statusButton yes' : 'statusButton no';
                                $disabled = $status == 'Delivered' ? 'disabled' : '';
                                echo "<tr>
                                    <td>{$row['orderid']}</td>
                                    <td>{$row['itemname']}</td>
                                    <td>{$row['itemprice']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['totbill']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['time']}</td>
                                    <td><button class='$buttonClass' data-id='{$row['orderid']}' $disabled>$buttonText</button></td>
                                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='no-data'>No Any Order Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php include("foot.php"); ?>
