<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

function button1($conn){
    try {      
        $add = $conn->prepare("INSERT INTO participe (Id_Part, ID_Concours,Resultat) values(:Id_Part,:ID_Concours,:Resultat)");
    
        $add->execute(array(
            'Id_Part' => $_SESSION['id_user'],
            'ID_Concours' => $_POST['id_concour'],
            'Resultat' => 'en attente'
        ));

        $add->closeCursor();
    } catch(Exception $e){
        // Handle the exception if needed
        die($e);
    } 
} 

try {
    $conn = new PDO('mysql:host=localhost;dbname=memoir;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // $all = $conn->query('SELECT * FROM Concours where id_post =1 ');
} catch(Exception $e){
    die('ERROR :'.$e->getMessage());
}

if(isset($_POST['button1'])) { 
    button1($conn); 
    // header("Refresh:0");
    header("Location: ".$_SERVER['PHP_SELF']."?id=".$_GET['id']);
  exit();

}

$concours = $conn->prepare('SELECT * FROM concours WHERE Id_Poste = :Id_Poste');
$concours->execute(array(
    'Id_Poste' => $_GET['id'],
));
while($affich = $concours->fetch()){
    $id_concour = $affich['ID_Concours'];
    $date_concour = $affich['Date_Concours'];
    $lieu_concour = $affich['Lieu_Concours'];
    $nombre_post = $affich['Nombre_poste'];
}
$concours->closeCursor();

$participe = $conn->prepare('SELECT * FROM participe WHERE Id_Part = :Id_Part and ID_Concours = :ID_Concours');
$participe->execute(array(
    'ID_Concours' => $id_concour,
    'Id_Part' => $_SESSION['id_user']
));

$resultat = 'register';

while($participe_affich = $participe->fetch()){
    $resultat = $participe_affich['Resultat'];
}

$participe->closeCursor();
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

        .button:hover {
            /* background-color: #ffca2b; */
            /* color: #212529; */
            /* border: 1px solid #ffca2b; */
        }
    </style>
 
</head>
<body>
<div class="navbar">
  
  <a href="index.php" id="showAllPostsButton">Home</a>
  <a href="In_process.php" id="showClientPostsButton">In process</a>
  <div class="logout-button">
      <a href="logout.php" class="btn btn-warning">Logout</a>
  </div>
</div>
    <div class="container">
        <h1>Concours Details</h1>
        <div class="details"> 
            <p><strong>Date:</strong> <?php echo $date_concour ?> </p>
            <p><strong>Place:</strong> <?php echo $lieu_concour ?></p>
            <p><strong>Number of Participants:</strong><?php echo $nombre_post ?></p>
        </div>
        <form method="post">
            <input type="hidden" name="form_submitted" value="1">
            <input type="hidden" name="id_concour" value="<?php echo $id_concour ?>">
            <input type="submit"  name="button1" class="button"  value="<?php echo $resultat ?>" <?php if($resultat != 'register'){ echo 'disabled="disabled"'; } ?> />
        </form>
    </div>
</body>
</html>
