<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url("medical.jpg");
            font: inherit;
            background-color: #cccccc; 
            height: 100vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            background-position: center; 
            background-repeat: no-repeat; 
            background-size: cover;
        }

        .container {
            text-align: center;
        }

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-btn {
            text-align: center;
        }

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
              if (isset($_POST["submit"])) {
                $fullName = $_POST["fullname"];
                $password = $_POST["password"];
                
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
     
                $errors = array();
                
               
                require_once "database.php";
                 $all=$conn->query("SELECT * FROM admin WHERE user_name = '$fullName'");
     
                
                
                $rowCount = $all->fetchColumn();
                if ($rowCount>0) {
                 array_push($errors,"Email already exists!");
                }
                if (count($errors)>0) {
                 foreach ($errors as  $error) {
                     echo "<div class='alert alert-danger'>$error</div>";
                 }
                }else{
                 
              
     
     try{
         $add = $conn->prepare("INSERT INTO admin (user_name, PasWord_admin) values(:user_name,:PasWord_admin)");
     
         $add->execute(array(
             'user_name' => $fullName,
             
             'PasWord_admin' => $passwordHash,
           ));
           $add->closeCursor();
                     echo "<div class='alert alert-success'>You are registered successfully.</div>";
     
           
     }catch(Exception $e){
                     die("Something went wrong");
     }    
             }
       }
        ?>
        <form action="registerAdmin.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
            <p>Already Registered? <a href="login.php">Login Here</a></p>
        </div>
    </div>
</body>

</html>