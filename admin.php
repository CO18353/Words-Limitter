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
        <div class="" id="row1">
            <header class="">WriteSoft</header>
        </div>
        <div id="row2">
            <nav>
            </nav>
            <div id="main">
                <div id="heading">
                    Dashboard
                </div>
                <div id="para">
                    Welcome to the dashboard, <?php echo $_SESSION["userName"]; ?>
                    <ul>
                        <li><a href="add_project.php">Add Projects</a></li>
                        <li><a href="view_projects.php">View Ongoing Projects</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="row3">
            Made By:-Tanveer Singh Kochhar
        </div>
    </div>
</body>

</html>