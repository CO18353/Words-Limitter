<?php
    session_start();
    unset($_SESSION["valid"]);
    unset($_SESSION["userID"]);
    unset($_SESSION["userName"]);
    session_destroy();
    echo "<script>Logged Out Succesfully!</script>";
    header("Location:login.php");
?>