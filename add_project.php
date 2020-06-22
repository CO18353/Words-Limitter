<?php
session_start();
if (!isset($_SESSION["valid"])) {
    header("Location:login.php");
}
require_once("dbconn.php");
$msg = '';
$msgClass = '';
if (isset($_POST["submit"])) {

    $new_date = date("Y-m-d");
    $topic = $conn->real_escape_string($_POST["topic"]);
    $wordcount = $conn->real_escape_string($_POST["wordcount"]);
    $info = $conn->real_escape_string($_POST["info"]);
    $count = $wordcount;
    $date_to_check;

    $stat = "SELECT * FROM client_data WHERE user='" . $_SESSION["uid"] . "' ORDER BY delivery_date DESC LIMIT 1;";
    $res = $conn->query($stat);
    $res->fetch_all(MYSQLI_ASSOC);
    if ($res->num_rows > 0) {
        foreach ($res as $r) {
            $date_to_check= $r["delivery_date"];
        }
    }
    else
        $date_to_check = date("Y-m-d");
    $statement= "SELECT * FROM client_data WHERE user='" . $_SESSION["uid"] . "' AND delivery_date='".$date_to_check."';";
    $result = $conn->query($statement);
    $result->fetch_all(MYSQLI_ASSOC);

    if ($result->num_rows > 0) {
        foreach ($result as $row) {
            $count += $row["word_count"];
        }
    }
    if ($count > 1000)
        $new_date = date("Y-m-d", strtotime('+1 day',strtotime($date_to_check)));
    else
        $new_date=$date_to_check;
    if ($conn->query("INSERT INTO `client_data`(`user`,`topic`, `word_count`, `content`, `delivery_date`) VALUES ('" . $_SESSION["uid"] . "','" . $topic . "','" . $wordcount . "','" . $info . "','" . $new_date . "') ;")) {
        $msg = 'Succesfully Added';
        $msgClass = "alert-success";
    } else {
        $msg = "Error in Adding";
        $msgClass = "alert-danger";
    }
}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<body>
    <div class="wrapper">
        <div class="" id="row1">
            <header class="">WriteSoft</header>
        </div>
        <div id="row2">
            <nav>
                <ul class="index">
                    <li><a href="admin.php">Main Menu</a></li>
                </ul>
            </nav>
            <div id="main">
                <div id="heading">
                    Add Project
                </div>
                <div id="para">
                    <form action="add_project.php" method="POST">
                        <label for="topic">Topic</label><br>
                        <input type="text" id="topic" name="topic" pattern="[\w :-]+" required /><br>
                        <label for="wordcount">Number of Words</label><br>
                        <input type="number" id="wordcount" name="wordcount" pattern="[0-9]+" title="Word Count cannot exceed 1000" max="1000" required /><br>
                        <label for="info">Additional Information</label><br>
                        <textarea name="info" id="info" required pattern="[\w :-]+"></textarea><br>
                        <p>Total word count: <span id="display_count">0</span> words. Words left: <span id="word_left">1000</span></p>
                        <button type="submit" name="submit" value="submit">Add</button>
                    </form>
                    <?php if ($msg != '') : ?>
                        <div id="messages" class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="row3">Made By:-Tanveer Singh Kochhar</div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $("#info").on('keyup', function() {
            var words = this.value.match(/\S+/g).length;
            if (words > 1000) {
                // Split the string on first 1000 words and rejoin on spaces
                var trimmed = $(this).val().split(/\s+/, 1000).join(" ");
                // Add a space at the end to keep new typing making new words
                $(this).val(trimmed + " ");
                alert("Maximum limit Reached");
            } else {
                $('#display_count').text(words);
                $('#word_left').text(1000 - words);
            }
        });
    });
</script>

</html>