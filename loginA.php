<?php
session_start();
if (isset($_SESSION["admin"])) {
   header("Location: indexA.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
body {
    background-image: url("medical.jpg");
    font: inherit;
    background-color: #cccccc; /* Used if the image is unavailable */
    height: 100vh; /* You must set a specified height */
    display: flex;
    align-items: center;
    justify-content: center;
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Do not repeat the image */
    background-size: cover;
}

.container {
    text-align: center;
}

form {
    width: 100%;
    max-width: 400px;
    margin: 0 auto; /* Center the form */
}

.form-group {
    margin-bottom: 20px;
}

.form-btn {
    text-align: center;
}

/* Improved styling for the "Not registered yet, Register Here" link */
p {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}

a {
    color: #007bff;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

</style>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $user_name = $_POST["user_name"];
           $Pas_Word_Admin = $_POST["Pas_Word_Admin"];
            require_once "database.php";
            $all=$conn->query("SELECT * FROM admin WHERE user_name = '$user_name'");
            while($user=$all->fetch()){
                if ($user) {
                    if (password_verify($Pas_Word_Admin, $user["Pas_Word_Admin"])) {
                        session_start();
                        $_SESSION["admin"] = "yes";
                        // $_SESSION["id_user"]=$user['id'];
                        header("Location: indexA.php");
                        die();
                    }else{
                        echo "<div class='alert alert-danger'>Password does not match</div>";
                    }
                }else{
                    echo "<div class='alert alert-danger'>UserName does not match</div>";
                }
             
}
        }
        ?>
      <form action="logina.php" method="post">
        <div class="form-group">
            <input type="user_name" placeholder="Enter user_name:" name="user_name" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password:" name="Pas_Word_Admin" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
      </form>
     <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>








