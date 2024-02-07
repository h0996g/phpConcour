<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: loginA.php");
}





$conn = new PDO('mysql:host=localhost;dbname=concours;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$concours = $conn->prepare('SELECT * FROM users WHERE id = :id_user');
$concours->execute(array(
    'id_user' => $_GET['id'],
));
while($affich = $concours->fetch()){
    $nom = $affich['nom'];
    $prenom = $affich['prenom'];
    $email = $affich['email'];
    // $nombre_post = $affich['nombre_post'];
}
$concours->closeCursor();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5; /* Light Gray */
    background-image: url("medical.jpg");

    margin: 0;
    padding: 0;
}

.navbar {
        background-color: #333;
        overflow: hidden;
        display: flex;
        justify-content: space-between; /* Align items to the start and end of the flex container */
        padding: 0 20px; /* Add padding to give some space */
    }

    .logout-button {
        margin-left: auto; /* Push the logout button to the right by using margin-left: auto */
        
    }

    .navbar a {
        color: #f2f2f2;
        text-decoration: none;
        padding: 14px 16px;
    }

    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }
    h1 {
    color: #4caf50; /* Green */
}

.btn {
    padding: 10px 20px;
    font-size: 16px;
    margin: 10px;
    background-color: #ffc107; /* Yellow */
    color: #212529; /* Black */
    border: 1px solid #ffc107; /* Yellow */
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}
       

        .container {
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
        }

        h1 {
            color: #4caf50;
        }

        .details {
            margin-bottom: 20px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            /* background-color: #4caf50; */
            color: #212529;
            border: 1px solid #ffc107;
            border-radius: 5px;
            text-decoration: none;
        }

        .button:hover {
            /* background-color: #ffca2b; */
            /* color: #212529; */
            /* border: 1px solid #ffca2b; */
        }
    </style>
 
</head>
<body>
<div class="navbar">
  
  <a href="indexA.php" id="showAllPostsButton">Home</a>
  <a href="#lisner" id="showClientPostsButton">Add post</a>
  <div class="logout-button">
      <a href="logoutA.php" class="btn btn-warning">Logout</a>
  </div>
</div>
    <div class="container">
        <h1>Concours Details</h1>
        <div class="details"> 
            <p><strong>nom:</strong> <?php echo $nom ?> </p>
            <p><strong>email:</strong> <?php echo $email ?></p>
            <p><strong>prenom</strong><?php echo $prenom ?></p>
        </div>

    </div>
</body>
</html>
