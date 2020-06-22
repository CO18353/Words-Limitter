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
        $query = "SELECT id,hashed_password FROM clients WHERE username = '" . $conn->real_escape_string($user) . "';";
        $result = $conn->query($query);
        if (mysqli_num_rows($result) == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row["hashed_password"])) {
                $_SESSION["userName"] = $user;
                $_SESSION["uid"] = $row["id"];
                $_SESSION["valid"] = true;
                header("Location:admin.php");
            } else {
                $msg = "Incorrect Password";
                $msgClass = "alert-danger";
            }
        } else {
            $msg = "You are not authorized to login";
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
                <div id="heading">Login</div>
                <div id="para">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <?php if ($msg != '') : ?>
                            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?>
                            </div>
                        <?php endif; ?>
                        <label for="username">Enter Username&nbsp;</label><input type="text" name="username" id="username" /><br />
                        <label for="password">Enter Password&nbsp;&nbsp;</label><input type="password" name="password" id="password" /><br />
                        <button type="submit" name="submit" value="Login">Login</button>
                        <button type="button" name="register" value="register" onclick="window.open('register.php','_self');">Register</button>
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