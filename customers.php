<?php
session_start();
if (!isset($_SESSION["userName"]) && $_SESSION["userName"] == $row["uName"]) {
    header("Location:index.php");
}

include("headerAdmin.php");
include("connection.php");

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM `userreg` WHERE `uid` = ?";
    $stmt = $connection->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

$search = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM `userreg` WHERE `name` LIKE ? OR `email` LIKE ? OR `phoneNo` LIKE ? OR `address` LIKE ?";
$stmt = $connection->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Customers</title>
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
            top: 0px;
            z-index: 500;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .deleteButton {
            background-color: #ff4d4d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .deleteButton:hover {
            background-color: #ff0000;
            transform: scale(1.05);
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
        });
    </script>
</head>

<body>
    <div style="display: block; margin:0px auto;">
        <h1>Customers</h1>
        <input type="text" id="searchInput" placeholder="Search customers..." class="searchInput">
        <div class="customersAdmin">
            <div class="table-container">
                <table class="customersAdminTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No.</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phoneNo']}</td>
                                    <td>{$row['address']}</td>
                                    <td>
                                        <form method='get' action=''>
                                            <input type='hidden' name='delete_id' value='{$row['uid']}'>
                                            <button type='submit' class='deleteButton'>Delete</button>
                                        </form>
                                    </td>
                                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='no-data'>No customers found</td></tr>";
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