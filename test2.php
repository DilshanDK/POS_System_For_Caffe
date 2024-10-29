<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "possystem";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM userreg";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Database Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #searchBar {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Data from Database</h1>
    <input type="text" id="searchBar" placeholder="Search...">
    <table id="defaultTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            if ($result->num_rows > 0) {
                $tableBody = "";
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td>' . $row['uid'] . '</td>';
                    $tableBody .= '<td>' . $row['name'] . '</td>';
                    $tableBody .= '<td>' . $row['email'] . '</td>';
                    $tableBody .= '</tr>';
                }
                echo $tableBody;
            } 
            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $("#searchBar").keyup(function() {
                var searchTerm = $(this).val().trim();
                $.ajax({
                    url: "test3.php", // Replace with the actual path to your test.php file
                    method: "post",
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        $("#tableBody").html(response);
                    },
                    error: function() {
                        console.error("An error occurred.");
                    }
                });
            });
        });
    </script>

</body>

</html>