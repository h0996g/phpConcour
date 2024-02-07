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
    background-color: #cccccc; /* Used if the image is unavailable */
    display: flex;
    align-items: center;
    justify-content: center;
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Do not repeat the image */
    background-size: cover;
}

.container {
    text-align: center;
    max-width: 400px;
    margin: 0 auto; /* Center the container */
    overflow-y: auto; /* Enable vertical scrolling */
}

form {
    width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

.form-btn {
    text-align: center;
}

/* Improved styling for the "Already Registered, Login Here" link */
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
                $email=$_POST["email"];
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $date_naissance = $_POST["date_naissance"];
                $lieu_naissance = $_POST["lieu_naissance"];
                $adresse = $_POST["adresse"];
                $telephone = $_POST["telephone"];
                $sexe = $_POST["sexe"];
                $etat_civil = $_POST["etat_civil"];
                $nombre_enfants = $_POST["nombre_enfants"];
                $diplom = $_POST["diplom"];
                $service_national = $_POST["service_national"];
                $malade_chronique = $_POST["malade_chronique"];
                $password = $_POST["password"];
                
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
     
                $errors = array();
                
                // if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
                //  array_push($errors,"All fields are required");
                // }
                // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //  array_push($errors, "Email is not valid");
                // }
                // if (strlen($password)<8) {
                //  array_push($errors,"Password must be at least 8 charactes long");
                // }
                // if ($password!==$passwordRepeat) {
                //  array_push($errors,"Password does not match");
                // }
                require_once "database.php";
                 $all=$conn->query("SELECT * FROM participants WHERE email_Part = '$email'");
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
         $add = $conn->prepare("INSERT INTO participants (Nom_Part,Prenom_Part,Date_nais,Lieu_de_naissance,Adresse_Part,Telph_Part,Sexe_part,etat_civil,nmb_enf,diplome_part,service_national,malade_chronique ,email_Part, Pasword_Part) values(:Nom_Part,:Prenom_Part,:Date_nais,:Lieu_de_naissance,:Adresse_Part,:Telph_Part,:Sexe_part,:etat_civil,:nmb_enf,:diplome_part,:service_national,:malade_chronique ,:email_Part, :Pasword_Part)");
     
         $add->execute(array(
             'Nom_Part' => $nom,
             'email_Part' => $email,
             'Pasword_Part' => $passwordHash,
             'Prenom_Part'=> $prenom,
             'Date_nais'=> $date_naissance,
             'Lieu_de_naissance'=> $lieu_naissance,
             'Adresse_Part'=> $adresse,
             'Telph_Part'=> $telephone,
             'Sexe_part'=> $sexe,
             'etat_civil'=> $etat_civil,
             'nmb_enf'=> $nombre_enfants,
             'diplome_part'=> $diplom,
             'service_national'=> $service_national,
             'malade_chronique'=> $malade_chronique,
             

           ));
           $add->closeCursor();
                     echo "<div class='alert alert-success'>You are registered successfully.</div>";
     
     }catch(Exception $e){
                     die("Something went wrong");
     }    
             }
       }
        ?>
        <form action="registration.php" method="post">
        <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="email" require>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="nom" placeholder="Nom">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="prenom" placeholder="Prénom">
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="date_naissance" placeholder="Date de naissance">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lieu_naissance" placeholder="Lieu de naissance">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="adresse" placeholder="Adresse">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="telephone" placeholder="Téléphone">
            </div>
            <div class="form-group">
                <select class="form-control" name="sexe">
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="etat_civil">
                    <option value="célibataire">Célibataire</option>
                    <option value="marié">Marié</option>
                    <option value="divorcé">Divorcé</option>
                    <option value="veuf">Veuf</option>
                </select>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="nombre_enfants" placeholder="Nombre d'enfants">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="diplom" placeholder="Diplôme">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="service_national" placeholder="Service National">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="malade_chronique" placeholder="Malade Chronique">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="S'inscrire" name="submit">
            </div>
        </form>
        <div>
            <p>Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
        </div>
    </div>
</body>

</html>
