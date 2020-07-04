<?php
session_start();
if (!isset($_SESSION["valid"])) {
    header("Location:login.php");
}
require_once("dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="admin.css" />
    <title>WriteSoft</title>
</head>

<body>
    <div class="wrapper">
        <div id="row1">
            <header class="">WriteSoft</header>
        </div>
        <div id="row2">
            <nav>
                <ul class="index">
                    <li style="padding-bottom:20px;"><a href="admin.php">Main Menu</a></li>
                </ul>
            </nav>
            <div id="main">
                <div id="heading">
                    Projects
                </div>
                <div id="para">
                    <table class="info">
                        <tr>
                            <th>Topic</th>
                            <th>Number of Words</th>
                            <th>Instructions</th>
                            <th>Delivery date</th>
                        </tr>
                        <?php
                        $statement = "SELECT * FROM client_data WHERE user='" . $_SESSION["uid"] . "' ORDER BY delivery_date ASC;";
                        $result = $conn->query($statement);
                        $result->fetch_all(MYSQLI_ASSOC);
                        if ($result->num_rows == 0) {
                        ?>
                            <tr>
                                <td colspan="2">No Data</td>
                            </tr>
                        <?php
                        }
                        foreach ($result as $row) {
                        ?>
                            <tr>
                                <td><?php echo $row['topic']; ?></td>
                                <td><?php echo $row['word_count']; ?></td>
                                <td><?php echo $row['content']; ?></td>
                                <td><?php echo $row['delivery_date']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div id="row3">Made By:-Tanveer Singh Kochhar</div>
    </div>
</body>

</html>
