<?php
session_start();
if(isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- link Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<style>
    body {
        padding: 50px;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 50px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    .form-grup {
        margin-bottom: 30px;
    }
</style>
<body>
    <div class="container">
        <?php
        if(isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "connect.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user) {
                if(password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die ();
                } else {
                    echo "<div class = 'alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class = 'alert alert-danger'>Email does not match</div>";
            }
        }
        ?>

        <form action="login.php" method="post">
            <div class="form-grup">
                <input type="email" name="email" placeholder="Your Mail" class="form-control">
            </div>
            <div class="form-grup">
                <input type="password" name="password" placeholder="Your Password" class="form-control">
            </div>
            <div class="form-grup">
                <input type="submit" name="login" value="Login" class="btn btn-primary">
            </div>
        </form>
        <div class="mt-5"><p>Not Register yet <a href="register.php" class="text-decoration-none">Register Here</a></p></div>
    </div>
</body>
</html>