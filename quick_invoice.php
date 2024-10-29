
    <?php

    include('connection.php');
    $sql = "SELECT * FROM `items`";
    $rs = mysqli_query($connection, $sql);

?>
<select><?php
    while ($row = mysqli_fetch_array($rs)) {
        echo "<option value='" . $row["itemid"] . "'" . "name='" . $row["name"] . "'" . ">" . $row["name"] . "</option>";
    }?>
    </select>

 