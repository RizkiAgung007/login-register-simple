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
    <title>Register</title>

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
        if(isset($_POST["submit"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeatPass = $_POST["repeat-pass"];
            // Mengamankan password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();
            if(empty($username) or empty($email) or empty($password) or empty($repeatPass)) {
                array_push($errors, "All field are required");
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email not valid");
            }
            if(strlen($password)<8) {
                array_push($errors, "Password must be at least 8 characters");
            }
            if($password!==$repeatPass) {
                array_push($errors, "Password and Repeat Password must match");
            }
            require_once "connect.php";
            // Mengecek apakah email sudah digunakan dalam database atau belum
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if($rowCount>0) {
                array_push($errors, "Email already registered");
            }

            if(count($errors)>0) {
                foreach($errors as $error) {
                    echo "<div class= 'alert alert-danger'>$error</div>";
                }
            }else {
                // Escape input untuk mencegah SQL Injection
                $username = mysqli_real_escape_string($conn, $username);
                $email = mysqli_real_escape_string($conn, $email);
                $passwordHash = mysqli_real_escape_string($conn, $passwordHash);

                // Buat query langsung tanpa prepared statements
                $sql = "INSERT INTO users (full_name, email, password) VALUES ('$username', '$email', '$passwordHash')";

                // Jalankan query
                if (mysqli_query($conn, $sql)) {
                    echo "<div class='alert alert-success'>You registered successfully.</div>";
                } else {
                    echo "Something went wrong";
                }

            }
        }
        ?>
        <form action="register.php" method="post">
            <div class="form-grup">
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-grup">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-grup">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-grup">
                <input type="text" class="form-control" name="repeat-pass" placeholder="Repeat Password">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="register">
            </div>
        </form>
        <div class="mt-5"><p>Allready Register <a href="login.php" class="text-decoration-none">Login Here</a></p></div>
    </div>
</body>
</html>