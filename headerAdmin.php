<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandiyan Art Recidence</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btnI {
            transition: background-color 0.3s;
            background-color: #f0f0f0; /* default color */
        }

        .btnI.active {
            background-color: #020f91; /* active color */
            color: white;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Check local storage for active button
            var activeButtonId = localStorage.getItem('activeButtonId');
            if (activeButtonId) {
                $("#" + activeButtonId).addClass("active");
            } else {
                // If no active button is found in local storage, set the first button as active
                $(".btnI").eq(0).addClass("active");
                localStorage.setItem('activeButtonId', $(".btnI").eq(0).attr('id'));
            }

            $(".btnI").click(function() {
                $(".btnI").removeClass("active"); // remove active class from all buttons
                $(this).addClass("active"); // add active class to the clicked button
                localStorage.setItem('activeButtonId', $(this).attr('id')); // save the active button id to local storage
            });
        });
    </script>
</head>

<body>
    <div>
        <div class="container">
            <img src="logo.jpg" class="headerAImg">
            <p style="font-size: 40px; font-weight:bolder; margin-left: -60px;">Kandiyan Art Recidence</p>
            <p class="hi">Hello <a href="" style="text-decoration: none; font-weight:bolder;"><?php echo $_SESSION["userName"]; ?></a></p>
            <a href="index.php"><button class="logout" onclick="">Logout</button></a>
        </div>
        <div class="bodymain">
            <div class="links">
                <button class="btnI" id="dashboard" style="margin-top: 50px;" onclick="window.location.href='home.php'">Dashboard</button>
                <button class="btnI" id="quickInvoice" onclick="window.location.href='quickInvoice.php'">Quick Invoice</button>
                <button class="btnI" id="itemsAdmin" onclick="window.location.href='itemsAdmin.php'">Items</button>
                <button class="btnI" id="customers" onclick="window.location.href='customers.php'">Customers</button>
                <button class="btnI" id="ordersAdmin" onclick="window.location.href='ordersAdmin.php'">Orders</button>
                <button class="btnI" id="report" onclick="window.location.href='report.php'">Reports</button>
            </div>
        