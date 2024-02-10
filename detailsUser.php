<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: loginA.php");
}





// $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
require_once "database.php";

$concours = $conn->prepare('SELECT * FROM participants WHERE Id_Part = :Id_Part');
$concours->execute(array(
    'Id_Part' => $_GET['id'],
));
while($affich = $concours->fetch()){
    $email=$affich["email_Part"];
    $nom = $affich["Nom_Part"];
    $prenom = $affich["Prenom_Part"];
    $date_naissance = $affich["Date_nais"];
    $lieu_naissance = $affich["Lieu_de_naissance"];
    $adresse = $affich["Adresse_Part"];
    $telephone = $affich["Telph_Part"];
    $sexe = $affich["Sexe_part"];
    $etat_civil = $affich["etat_civil"];
    $nombre_enfants = $affich["nmb_enf"];
    $diplom = $affich["diplome_part"];
    $service_national = $affich["service_national"];
    $malade_chronique = $affich["malade_chronique"];
   
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
  <a href="addPost.php" id="">Add post</a>
  <div class="logout-button">
      <a href="logoutA.php" class="btn btn-warning">Logout</a>
  </div>
</div>
    <div class="container">
        <h1>User:</h1>
        <div class="details"> 
            <p><strong>nom:</strong> <?php echo $nom ?> </p>
            <p><strong>email:</strong> <?php echo $email ?></p>
            <p><strong>prenom:</strong><?php echo $prenom ?></p>
            <p><strong>date_naissance:</strong><?php echo $date_naissance ?></p>
            <p><strong>lieu_naissance:</strong><?php echo $lieu_naissance ?></p>
            <p><strong>telephone:</strong><?php echo $telephone ?></p>
            <p><strong>sexe:</strong><?php echo $sexe ?></p>
            <p><strong>etat_civil:</strong><?php echo $etat_civil ?></p>
            <p><strong>nombre_enfants:</strong><?php echo $nombre_enfants ?></p>
            <p><strong>diplom:</strong><?php echo $diplom ?></p>
            <p><strong>service_national:</strong><?php echo $service_national ?></p>
            <p><strong>adresse:</strong><?php echo $adresse ?></p>
        </div>

    </div>
</body>
</html>
