<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandiyan Art Residence</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <style>
        .btnI {

            transition: background-color 0.01s;
            background-color: #f0f0f0;
            /* default color */
        }

        .btnI.active {
            background-color: #020f91;
            color: white;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Retrieve the active button id from local storage
            var activeButtonId = localStorage.getItem('activeButtonId');
            if (activeButtonId) {
                $("#" + activeButtonId).addClass("active");
            }

            $(".btnI").click(function() {
                $(".btnI").removeClass("active"); // remove active class from all buttons
                $(this).addClass("active"); // add active class to the clicked button
                localStorage.setItem('activeButtonId', $(this).attr('id')); // save the active button id to local storage

                // Redirect based on the button clicked
                if (this.id === 'btnI') {
                    window.location.href = 'itemsUser.php';
                } else if (this.id === 'btnC') {
                    window.location.href = 'cart.php';
                } else if (this.id === 'btnM') {
                    window.location.href = 'ordersUser.php';
                }
            });
        });
    </script>
</head>

<body>
    <div>
        <div class="container">
            <img src="logo.jpg" class="headerUImg">
            <p style="font-size: 45px; font-weight: bolder; margin: 30px 40px 30px -150px;">Kandiyan Art Residence</p>
            <p class="hi">Hello <a href="" style="text-decoration: none; font-weight: bolder;"><?php echo $_SESSION["userName"]; ?></a></p>
            <a href="index.php"><button class="logout">Logout</button></a>
        </div>
        <div class="bodymain">
            <div class="links">
                <button id="btnI" class="btnI" style="margin-top: 50px;">Items</button>
                <button id="btnC" class="btnI">Cart</button>
                <button id="btnM" class="btnI">My Orders</button>
            </div>