<?php
session_start();
require_once("dbconn.php");
if (isset($_SESSION["valid"])) //if already logged in redirect to admin page
{
    header("Location:admin.php");
}
//Msg variables
$msg = '';
$msgClass = '';
if (filter_has_var(INPUT_POST, 'submit')) //Check for Submit
{
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);
    if (empty($user) || empty($pass)) //if username or password field is empty echo below statement
    {
        $msg = "Please Fill All the Fields";
        $msgClass = "alert-danger";
    } else {
        $query = "SELECT id FROM clients WHERE username = '" . $conn->real_escape_string($user) . "';";
        $result = $conn->query($query);
        if (mysqli_num_rows($result) == 0) {
            $newpassword = password_hash($pass, PASSWORD_BCRYPT);
            if ($conn->query("INSERT INTO `clients`(`username`, `hashed_password`) VALUES('" . $user . "','" . $newpassword . "') ;")) {
                header("Location:login.php");
            }
        } else {
            $msg = "User Already Exists";
            $msgClass = "alert-danger";
        }
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

<body>
    <div class="wrapper">
        <div class="" id="row1">
            <header>WriteSoft</header>
        </div>
        <div id="row2">
            <nav></nav>
            <div id="main">
                <div id="heading">Register</div>
                <div id="para">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <?php if ($msg != '') : ?>
                            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?>
                            </div>
                        <?php endif; ?>
                        <label for="username">Enter Username&nbsp;</label><input type="text" name="username" id="username" /><br />
                        <label for="password">Enter Password&nbsp;&nbsp;</label><input type="password" name="password" id="password" /><br />
                        <button type="submit" name="submit" value="register">Register</button>
                        <button type="button" name="login" value="login" onclick="window.open('login.php','_self');">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="row3">
            Made By:-Tanveer Singh Kochhar
        </div>
    </div>
</body>

</html>